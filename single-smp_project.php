<?php get_header(); ?><main class="section"><div class="container content-page"><?php while(have_posts()):the_post();?><p class="eyebrow">Case Study</p><h1><?php the_title();?></h1><?php if(has_post_thumbnail())the_post_thumbnail('large',['class'=>'single-project-image']);?><div class="markdown-content"><?php the_content();?></div><?php endwhile;?></div></main><?php get_footer(); ?>

