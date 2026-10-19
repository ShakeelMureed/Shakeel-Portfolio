(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  // One named timeline drives both the hero entrance and the deterministic canvas beats.
  const heroMotionTimeline = Object.freeze({
    introDelays: [80, 190, 420, 640, 800],
    visualDelay: 220,
    sceneDuration: 8.8,
    gatherStart: 0.45,
    gatherEnd: 2.15,
    networkStart: 2.0,
    networkEnd: 3.2,
    signalStart: 3.55,
    signalEnd: 5.6,
    fadeStart: 8.0,
    fadeEnd: 8.75,
  });
  const hero = document.querySelector('.hero');
  const heroCopy = hero?.querySelector('.hero-copy');
  if (hero && !reduceMotion) {
    hero.querySelector('.hero-visual')?.style.setProperty('--hero-visual-delay', `${heroMotionTimeline.visualDelay}ms`);
    if (heroCopy) Array.from(heroCopy.children).forEach((element, index) => {
      element.style.setProperty('--hero-enter-delay', `${heroMotionTimeline.introDelays[index] ?? 0}ms`);
    });

    if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
      let spotlightQueued = false;
      let pointerPosition;
      hero.addEventListener('pointermove', event => {
        pointerPosition = event;
        if (spotlightQueued) return;
        spotlightQueued = true;
        window.requestAnimationFrame(() => {
          const bounds = hero.getBoundingClientRect();
          hero.style.setProperty('--pointer-x', `${((pointerPosition.clientX - bounds.left) / bounds.width) * 100}%`);
          hero.style.setProperty('--pointer-y', `${((pointerPosition.clientY - bounds.top) / bounds.height) * 100}%`);
          spotlightQueued = false;
        });
      });
      hero.addEventListener('pointerleave', () => {
        hero.style.setProperty('--pointer-x', '74%');
        hero.style.setProperty('--pointer-y', '48%');
      });
    }
  }
  const heroCanvas = hero?.querySelector('.hero-motion-canvas');
  const heroContext = heroCanvas?.getContext('2d');
  if (hero && heroCanvas && heroContext) {
    const clamp = value => Math.max(0, Math.min(1, value));
    const ease = (start, end, value) => {
      const t = clamp((value - start) / (end - start));
      return t * t * (3 - 2 * t);
    };
    const seeded = value => {
      const n = Math.sin(value * 127.1 + 311.7) * 43758.5453;
      return n - Math.floor(n);
    };
    const particles = Array.from({ length: 52 }, (_, index) => ({
      x: .52 + seeded(index + 1) * .46,
      y: .1 + seeded(index + 93) * .78,
      angle: seeded(index + 20) * Math.PI * 2,
      radius: 22 + seeded(index + 42) * 126,
      size: 1.2 + seeded(index + 50) * 2.4,
      accent: index % 11 === 0 ? 'coral' : (index % 5 === 0 ? 'lime' : 'white'),
    }));
    const links = [[-1, -.72], [-.92, .05], [-.56, .66], [.55, -.66], [.92, -.02], [.66, .64]];
    const colors = getComputedStyle(hero);
    const lime = colors.getPropertyValue('--cyan').trim() || '#b6ee58';
    const coral = colors.getPropertyValue('--coral').trim() || '#ff705c';
    let width = 0;
    let height = 0;
    let ratio = 1;
    let sceneTime = 0;
    let sceneStart = 0;
    let animationFrame = 0;

    const draw = time => {
      if (!width || !height) return;
      const ctx = heroContext;
      ctx.clearRect(0, 0, width, height);
      const centerX = width * .92;
      const centerY = height * .45;
      const scale = Math.min(width, height) / 600;
      const gather = ease(heroMotionTimeline.gatherStart, heroMotionTimeline.gatherEnd, time);
      const network = ease(heroMotionTimeline.networkStart, heroMotionTimeline.networkEnd, time);
      const signal = ease(heroMotionTimeline.signalStart, heroMotionTimeline.signalEnd, time);
      const fade = 1 - ease(heroMotionTimeline.fadeStart, heroMotionTimeline.fadeEnd, time);

      const glow = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, width * .28);
      glow.addColorStop(0, 'rgba(182,238,88,.075)');
      glow.addColorStop(1, 'rgba(182,238,88,0)');
      ctx.fillStyle = glow;
      ctx.fillRect(0, 0, width, height);

      ctx.save();
      ctx.beginPath();
      ctx.rect(width * .49, 0, width * .51, height);
      ctx.clip();
      ctx.globalAlpha = .11;
      ctx.strokeStyle = '#9ba0aa';
      ctx.lineWidth = 1;
      for (let x = width * .52; x < width; x += 42) {
        ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, height); ctx.stroke();
      }
      for (let y = 24; y < height; y += 42) {
        ctx.beginPath(); ctx.moveTo(width * .49, y); ctx.lineTo(width, y); ctx.stroke();
      }
      ctx.restore();

      ctx.save();
      ctx.globalAlpha = fade;
      particles.forEach((particle, index) => {
        const spreadX = Math.cos(particle.angle) * particle.radius * scale;
        const spreadY = Math.sin(particle.angle) * particle.radius * scale;
        const startX = particle.x * width;
        const startY = particle.y * height;
        const drift = Math.sin(time * .7 + index * 2.1) * 3 * scale;
        const x = startX * (1 - gather) + (centerX + spreadX) * gather + drift * (1 - gather);
        const y = startY * (1 - gather) + (centerY + spreadY) * gather + drift * (1 - gather);
        ctx.globalAlpha = fade * (.23 + .5 * gather);
        ctx.fillStyle = particle.accent === 'coral' ? coral : (particle.accent === 'lime' ? lime : '#d9dde2');
        ctx.beginPath();
        ctx.arc(x, y, particle.size * (1 - .24 * gather), 0, Math.PI * 2);
        ctx.fill();
      });

      ctx.globalAlpha = fade * network * .34;
      ctx.strokeStyle = lime;
      ctx.lineWidth = 1;
      links.forEach(([dx, dy]) => {
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + dx * 130 * scale, centerY + dy * 130 * scale);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(centerX + dx * 130 * scale, centerY + dy * 130 * scale, 2.4 * scale, 0, Math.PI * 2);
        ctx.fillStyle = lime;
        ctx.fill();
      });

      const coreRadius = (8 + 3 * Math.sin(time * 2.2)) * scale;
      ctx.globalAlpha = fade * (.12 + network * .18);
      ctx.beginPath(); ctx.arc(centerX, centerY, coreRadius * 2.7, 0, Math.PI * 2); ctx.stroke();
      ctx.globalAlpha = fade * (.3 + network * .3);
      ctx.fillStyle = lime;
      ctx.beginPath(); ctx.arc(centerX, centerY, coreRadius, 0, Math.PI * 2); ctx.fill();
      ctx.restore();

      const lineStart = width * .55;
      const lineEnd = width * .96;
      const lineY = height * .92;
      ctx.save();
      ctx.globalAlpha = .42 * ease(heroMotionTimeline.signalStart - .2, heroMotionTimeline.signalStart + .3, time) * (1 - .25 * ease(7.1, 7.8, time));
      ctx.strokeStyle = 'rgba(255,255,255,.28)';
      ctx.lineWidth = 1;
      ctx.beginPath(); ctx.moveTo(lineStart, lineY); ctx.lineTo(lineEnd, lineY); ctx.stroke();
      ctx.globalAlpha *= .9;
      ctx.strokeStyle = lime;
      ctx.lineWidth = 2;
      ctx.beginPath(); ctx.moveTo(lineStart, lineY); ctx.lineTo(lineStart + (lineEnd - lineStart) * signal, lineY); ctx.stroke();
      if (signal > 0) {
        ctx.fillStyle = coral;
        ctx.beginPath(); ctx.arc(lineStart + (lineEnd - lineStart) * signal, lineY, 3 + 1.5 * Math.sin(time * 4) ** 2, 0, Math.PI * 2); ctx.fill();
      }
      ctx.restore();
    };

    const resize = () => {
      const bounds = hero.getBoundingClientRect();
      width = bounds.width;
      height = bounds.height;
      ratio = Math.min(window.devicePixelRatio || 1, 1.5);
      heroCanvas.width = Math.round(width * ratio);
      heroCanvas.height = Math.round(height * ratio);
      heroContext.setTransform(ratio, 0, 0, ratio, 0, 0);
      draw(sceneTime);
    };
    const animate = now => {
      if (document.hidden) { animationFrame = 0; return; }
      sceneTime = ((now - sceneStart) / 1000) % heroMotionTimeline.sceneDuration;
      draw(sceneTime);
      animationFrame = window.requestAnimationFrame(animate);
    };
    const startAnimation = () => {
      if (reduceMotion) { sceneTime = 6.4; draw(sceneTime); return; }
      if (!animationFrame) {
        sceneStart = performance.now() - sceneTime * 1000;
        animationFrame = window.requestAnimationFrame(animate);
      }
    };
    resize();
    startAnimation();
    window.addEventListener('resize', resize, { passive: true });
    document.addEventListener('visibilitychange', () => {
      if (document.hidden && animationFrame) {
        window.cancelAnimationFrame(animationFrame);
        animationFrame = 0;
      } else if (!document.hidden) startAnimation();
    });
  }
  const progress = document.querySelector('.page-progress');
  let progressQueued = false;
  const updateProgress = () => {
    if (!progress || progressQueued) return;
    progressQueued = true;
    window.requestAnimationFrame(() => {
      const scrollable = document.documentElement.scrollHeight - window.innerHeight;
      progress.style.transform = `scaleX(${scrollable > 0 ? window.scrollY / scrollable : 0})`;
      progressQueued = false;
    });
  };
  if (progress && !reduceMotion) {
    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }
  const menuButton = document.querySelector('.menu-button');
  const nav = document.querySelector('.nav-links');
  if (menuButton && nav) {
    menuButton.addEventListener('click', () => { const open = nav.classList.toggle('open'); menuButton.setAttribute('aria-expanded', String(open)); });
    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { nav.classList.remove('open'); menuButton.setAttribute('aria-expanded', 'false'); }));
  }

  const filters = document.querySelectorAll('[data-filter]');
  const projects = document.querySelectorAll('[data-category]');
  filters.forEach(filter => filter.addEventListener('click', () => {
    const category = filter.dataset.filter;
    filters.forEach(item => { const selected = item === filter; item.classList.toggle('is-active', selected); item.setAttribute('aria-pressed', String(selected)); });
    projects.forEach(project => project.classList.toggle('is-hidden', category !== 'all' && !project.dataset.category.includes(category)));
  }));

  const modal = document.querySelector('#project-modal');
  let lastTrigger;
  document.querySelectorAll('.project-modal-open').forEach(button => button.addEventListener('click', () => {
    const data = button.closest('.project-card').querySelector('.modal-data');
    if (!modal || !data) return;
    lastTrigger = button;
    modal.querySelector('[data-modal-title]').textContent = data.dataset.title;
    modal.querySelector('[data-modal-platform]').textContent = data.dataset.platform;
    modal.querySelector('[data-modal-content]').innerHTML = data.innerHTML;
    const image = modal.querySelector('[data-modal-image]'); image.src = data.dataset.image; image.alt = data.dataset.title;
    const url = modal.querySelector('[data-modal-url]'); url.hidden = !data.dataset.url; if (data.dataset.url) url.href = data.dataset.url;
    modal.showModal(); document.body.style.overflow = 'hidden';
  }));
  const closeModal = () => { if (!modal?.open) return; modal.close(); document.body.style.overflow = ''; lastTrigger?.focus(); };
  modal?.querySelector('[data-modal-close]')?.addEventListener('click', closeModal);
  modal?.addEventListener('click', event => { if (event.target === modal) closeModal(); });
  modal?.addEventListener('close', () => { document.body.style.overflow = ''; });

  const revealItems = document.querySelectorAll('.reveal');
  const observer = !reduceMotion && 'IntersectionObserver' in window ? new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } }), { threshold: .1, rootMargin: '0px 0px -36px 0px' }) : null;
  if (observer) {
    document.documentElement.classList.add('motion-ready');
    revealItems.forEach(element => {
      const siblingIndex = Array.from(element.parentElement?.children || []).filter(child => child.classList.contains('reveal')).indexOf(element);
      element.style.setProperty('--reveal-delay', `${Math.min(siblingIndex, 4) * 90}ms`);
      observer.observe(element);
    });
  } else {
    revealItems.forEach(element => element.classList.add('visible'));
  }

  const form = document.querySelector('#contact-form');
  form?.addEventListener('submit', async event => {
    event.preventDefault(); const status = document.querySelector('#form-status'); const button = form.querySelector('button[type="submit"]');
    status.textContent = smpData.messages.sending; button.disabled = true;
    const body = new FormData(form); body.append('nonce', smpData.nonce);
    try { const response = await fetch(smpData.ajaxUrl, { method: 'POST', body }); const result = await response.json(); status.textContent = result.success ? smpData.messages.success : smpData.messages.error; if (result.success) form.reset(); }
    catch (_) { status.textContent = smpData.messages.error; }
    finally { status.classList.add('show'); button.disabled = false; }
  });
})();

