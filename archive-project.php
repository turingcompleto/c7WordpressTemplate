<?php
/**
 * Archive Projects Template - Asmobius Style
 */
get_header(); ?>

<div class="page-wrapper" style="padding-top: 120px;">
    <div class="projects-container">
        
        <!-- Page Title -->
        <header class="page-header" style="margin-bottom: 60px;">
            <h1 class="section-title visible">
                <?php
                if (is_tax('project_category')) {
                    single_term_title();
                } else {
                    _e('All Works', 'asmobius');
                }
                ?>
            </h1>
        </header>

        <!-- Filtros de categorías -->
        <div class="project-filters">
            <a href="<?php echo get_post_type_archive_link('project'); ?>" 
               class="filter-btn <?php echo !is_tax() ? 'active' : ''; ?>">
                All
            </a>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'project_category',
                'hide_empty' => true,
            ));
            
            foreach ($categories as $category) :
                $active_class = (is_tax('project_category', $category->slug)) ? 'active' : '';
                ?>
                <a href="<?php echo get_term_link($category); ?>" 
                   class="filter-btn <?php echo $active_class; ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Grid de proyectos -->
        <div class="projects-grid">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $categories = get_the_terms(get_the_ID(), 'project_category');
                    $category_name = '';
                    if ($categories && !is_wp_error($categories)) {
                        $category_name = $categories[0]->name;
                    }
                    
                    $location = get_post_meta(get_the_ID(), '_project_location', true);
                    $year = get_post_meta(get_the_ID(), '_project_year', true);
                    ?>
                    <article class="project-card visible">
                        <a href="<?php the_permalink(); ?>">
                            <div class="project-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('project-thumb'); ?>
                                <?php else : ?>
                                    <div style="width: 100%; height: 100%; background: #f0f0f0;"></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="project-info">
                                <?php if ($category_name) : ?>
                                    <div class="project-category"><?php echo esc_html($category_name); ?></div>
                                <?php endif; ?>
                                
                                <h3 class="project-title"><?php the_title(); ?></h3>
                                
                                <div class="project-meta">
                                    <?php if ($location) : ?>
                                        <span><?php echo esc_html($location); ?></span>
                                    <?php endif; ?>
                                    <?php if ($year) : ?>
                                        <span><?php echo esc_html($year); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php
                endwhile;
                
                // Paginación minimalista
                ?>
                <div class="load-more-container" style="grid-column: 1 / -1;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Prev', 'asmobius'),
                        'next_text' => __('Next →', 'asmobius'),
                        'class' => 'pagination-minimal'
                    ));
                    ?>
                </div>
                <?php
            else :
                ?>
                <p style="grid-column: 1 / -1; text-align: center; color: #999; padding: 60px 0;">
                    <?php _e('No projects found.', 'asmobius'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>