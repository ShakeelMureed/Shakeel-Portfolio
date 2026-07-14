(() => {
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

  const observer = 'IntersectionObserver' in window ? new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } }), { threshold: .08 }) : null;
  document.querySelectorAll('.reveal').forEach(element => observer ? observer.observe(element) : element.classList.add('visible'));

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

