<?php get_header(); ?><main class="section"><div class="container content-page"><?php while(have_posts()):the_post();?><h1><?php the_title();?></h1><?php the_content();?><?php endwhile;?></div></main><?php get_footer(); ?>

