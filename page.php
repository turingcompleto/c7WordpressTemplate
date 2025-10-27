<?php
/**
 * Template for displaying pages
 */
get_header(); ?>

<div class="page-wrapper">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php if (has_post_thumbnail()) : ?>
                <div class="page-hero">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="page-content-wrapper">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>

                <div class="page-content">
                    <?php the_content(); ?>
                </div>

                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'asmobius'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

        </article>

        <?php
        // If comments are open or there is at least one comment
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>