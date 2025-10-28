<?php
/**
 * Main Template File
 */
get_header(); ?>

<!-- Hero Section con efecto Tao -->
<section class="hero-section">
    <div class="hero-slides-container">
        <?php
        $hero_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => 5,
            'meta_key' => '_hero_slide',
            'meta_value' => '1',
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        if ($hero_query->have_posts()) :
            $slide_index = 0;
            while ($hero_query->have_posts()) : $hero_query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                
                // Si no hay imagen, continuar con el siguiente
                if (!$image_url) {
                    continue;
                }
                
                $categories = get_the_terms(get_the_ID(), 'project_category');
                $category_name = '';
                if ($categories && !is_wp_error($categories)) {
                    $category_name = $categories[0]->name;
                }
                $location = get_post_meta(get_the_ID(), '_project_location', true);
                $active_class = ($slide_index === 0) ? 'active' : '';
                ?>
                <div class="hero-slide <?php echo $active_class; ?>" data-slide="<?php echo $slide_index; ?>">
                    <div class="hero-slide-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
                    
                    <div class="hero-content">
                        <?php if ($category_name) : ?>
                            <span class="hero-category"><?php echo esc_html($category_name); ?></span>
                        <?php endif; ?>
                        
                        <h1><?php the_title(); ?></h1>
                        
                        <?php if ($location) : ?>
                            <p class="hero-description"><?php echo esc_html($location); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                $slide_index++;
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <div class="hero-slide active">
                <div class="hero-slide-image" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);"></div>
                <div class="hero-content">
                    <span class="hero-category">Architecture</span>
                    <h1><?php echo get_theme_mod('hero_title', 'Architecture & Design'); ?></h1>
                    <p class="hero-description"><?php echo get_theme_mod('hero_description', 'Creating timeless spaces'); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- OVERLAY LÍQUIDO PERMANENTE -->
    <div class="liquid-overlay">
        <div class="liquid-ring">
            <div class="liquid-arc"></div>
            <div class="liquid-arc-2"></div>
            <div class="liquid-arc-3"></div>
            
            <!-- Partículas de agua fluyendo -->
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
            <div class="water-flow-particle"></div>
        </div>
        
        <!-- Ondulación del agua -->
        <div class="water-ripple-effect"></div>
        
        <!-- Brillo interior pulsante -->
        <div class="inner-glow"></div>
        
        <!-- Gotas flotantes -->
        <div class="floating-drops">
            <div class="floating-drop"></div>
            <div class="floating-drop"></div>
            <div class="floating-drop"></div>
            <div class="floating-drop"></div>
            <div class="floating-drop"></div>
        </div>
    </div>
    
    <!-- Símbolo Tao decorativo -->
    <div class="tao-symbol">☯</div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-indicator-line"></div>
        <div class="scroll-indicator-text">Scroll</div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section">
    <div class="projects-container">
        <h2 class="section-title fade-in">Works</h2>
        
        <div class="projects-grid">
            <?php
            $projects_query = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    $categories = get_the_terms(get_the_ID(), 'project_category');
                    $category_name = '';
                    if ($categories && !is_wp_error($categories)) {
                        $category_name = $categories[0]->name;
                    }
                    
                    // Obtener meta información
                    $location = get_post_meta(get_the_ID(), '_project_location', true);
                    $year = get_post_meta(get_the_ID(), '_project_year', true);
                    ?>
                    <article class="project-card fade-in">
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
                wp_reset_postdata();
            else :
                ?>
                <p style="grid-column: 1 / -1; text-align: center; color: #999;">No projects found.</p>
            <?php endif; ?>
        </div>
        
        <?php if ($projects_query->found_posts > 8) : ?>
            <div class="load-more-container">
                <a href="<?php echo get_post_type_archive_link('project'); ?>" class="btn-load-more">
                    View All Projects
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="about-image" style="background-image: url('https://c7estudio.esuntipazo.com/wp-content/uploads/2019/01/Residencia-Cerro-de-la-Luz-221-FHD-Render-9-scaled.png');"></div>
    
    <div class="about-content">
        <h2 class="fade-in">About Us</h2>
        
        <?php
        // Get about page content
        $about_page = get_page_by_path('about');
        if ($about_page) :
            ?>
            <div class="fade-in">
                <?php echo wpautop(wp_trim_words($about_page->post_content, 80)); ?>
            </div>
            <a href="<?php echo get_permalink($about_page->ID); ?>" class="btn-more" style="display: inline-block; margin-top: 30px; padding: 12px 40px; border: 1px solid #000; color: #000; text-decoration: none; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; transition: all 0.3s ease;">
                <?php _e('Learn More', 'asmobius'); ?>
            </a>
        <?php else : ?>
            <p class="fade-in">
                <?php _e('We are a creative architecture studio dedicated to designing innovative and sustainable spaces that enhance the human experience.', 'asmobius'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>