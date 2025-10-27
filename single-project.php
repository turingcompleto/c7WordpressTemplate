<?php
/**
 * Single Project Template
 */
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-project'); ?>>
    
    <!-- Project Hero -->
    <div class="project-hero">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full'); ?>
        <?php endif; ?>
    </div>

    <!-- Project Content -->
    <div class="project-content-wrapper">
        <div class="project-header">
            <?php
            $categories = get_the_terms(get_the_ID(), 'project_category');
            if ($categories && !is_wp_error($categories)) :
                ?>
                <div class="project-category">
                    <?php echo esc_html($categories[0]->name); ?>
                </div>
            <?php endif; ?>

            <h1 class="project-title"><?php the_title(); ?></h1>

            <div class="project-meta">
                <?php
                $location = get_post_meta(get_the_ID(), '_project_location', true);
                $year = get_post_meta(get_the_ID(), '_project_year', true);
                $area = get_post_meta(get_the_ID(), '_project_area', true);
                ?>

                <?php if ($location) : ?>
                    <div class="meta-item">
                        <span class="meta-label"><?php _e('Location:', 'asmobius'); ?></span>
                        <span class="meta-value"><?php echo esc_html($location); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($year) : ?>
                    <div class="meta-item">
                        <span class="meta-label"><?php _e('Year:', 'asmobius'); ?></span>
                        <span class="meta-value"><?php echo esc_html($year); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($area) : ?>
                    <div class="meta-item">
                        <span class="meta-label"><?php _e('Area:', 'asmobius'); ?></span>
                        <span class="meta-value"><?php echo esc_html($area); ?> m²</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="project-content">
            <?php the_content(); ?>
        </div>

        <!-- Project Navigation -->
        <div class="project-navigation">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>

            <?php if ($prev_post) : ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-previous">
                    <span class="nav-label"><?php _e('Previous Project', 'asmobius'); ?></span>
                    <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                </a>
            <?php endif; ?>

            <?php if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-next">
                    <span class="nav-label"><?php _e('Next Project', 'asmobius'); ?></span>
                    <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>

</article>

<!-- Related Projects -->
<section class="related-projects">
    <h2 class="section-title"><?php _e('Related Projects', 'asmobius'); ?></h2>
    
    <div class="projects-grid">
        <?php
        $categories = get_the_terms(get_the_ID(), 'project_category');
        $category_ids = array();
        
        if ($categories && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
        }

        $related_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'project_category',
                    'field' => 'term_id',
                    'terms' => $category_ids,
                ),
            ),
        ));

        if ($related_query->have_posts()) :
            while ($related_query->have_posts()) : $related_query->the_post();
                $categories = get_the_terms(get_the_ID(), 'project_category');
                $category_name = '';
                if ($categories && !is_wp_error($categories)) {
                    $category_name = $categories[0]->name;
                }
                ?>
                <article class="project-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="project-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('project-thumb'); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="project-info">
                            <?php if ($category_name) : ?>
                                <div class="project-category"><?php echo esc_html($category_name); ?></div>
                            <?php endif; ?>
                            
                            <h3 class="project-title"><?php the_title(); ?></h3>
                        </div>
                    </a>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>