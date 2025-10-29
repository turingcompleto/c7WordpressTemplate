<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php wp_body_open(); ?>

<!-- Loading Screen - Tao Brush Style -->
<div id="loading-screen">
    <div class="tao-brush-loader">
        <svg width="140" height="140" viewBox="0 0 140 140">
            <defs>
                <!-- Gradiente para efecto de tinta -->
                <radialGradient id="inkGradient">
                    <stop offset="0%" style="stop-color:#000;stop-opacity:1" />
                    <stop offset="70%" style="stop-color:#000;stop-opacity:0.8" />
                    <stop offset="100%" style="stop-color:#000;stop-opacity:0.3" />
                </radialGradient>
                
                <!-- Filtro para bordes irregulares de brocha -->
                <filter id="brushEdge">
                    <feTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="4" />
                    <feDisplacementMap in="SourceGraphic" scale="3" />
                </filter>
            </defs>
            
            <!-- Semicírculo principal estilo brocha -->
            <g class="tao-main">
                <path 
                    d="M 70 20 
                       C 75 22, 80 25, 85 30
                       C 95 40, 105 50, 115 65
                       C 120 75, 120 80, 118 90
                       L 70 70
                       Z" 
                    fill="url(#inkGradient)"
                    filter="url(#brushEdge)"
                    opacity="0.95"
                />
                
                <!-- Trazo grueso de brocha -->
                <path 
                    d="M 70 20 
                       A 50 50 0 0 1 118 90" 
                    fill="none"
                    stroke="#000"
                    stroke-width="18"
                    stroke-linecap="round"
                    opacity="0.7"
                />
                
                <!-- Trazo fino decorativo -->
                <path 
                    d="M 70 20 
                       A 50 50 0 0 1 118 90" 
                    fill="none"
                    stroke="#000"
                    stroke-width="2"
                    stroke-linecap="round"
                    opacity="0.3"
                />
            </g>
        </svg>
    </div>
</div>

<style>
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    transition: opacity 0.5s ease;
}

.tao-brush-loader {
    animation: taoSmoothRotate 2.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.1));
}

.tao-main {
    transform-origin: 70px 70px;
}

@keyframes taoSmoothRotate {
    0% { 
        transform: rotate(0deg);
    }
    100% { 
        transform: rotate(360deg);
    }
}
</style>

<script>
// SISTEMA DE 5 NIVELES PARA OCULTAR EL LOADER
(function() {
    var loader = document.getElementById('loading-screen');
    var hidden = false;
    
    function hideLoader() {
        if (!hidden && loader) {
            hidden = true;
            loader.style.opacity = '0';
            setTimeout(function() {
                if (loader && loader.parentNode) {
                    loader.parentNode.removeChild(loader);
                }
            }, 500);
        }
    }
    
    // Nivel 1: Inmediato después de 200ms
    setTimeout(hideLoader, 200);
    
    // Nivel 2: DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hideLoader);
    } else {
        hideLoader();
    }
    
    // Nivel 3: Window load
    window.addEventListener('load', hideLoader);
    
    // Nivel 4: Forzar después de 800ms
    setTimeout(hideLoader, 800);
    
    // Nivel 5: ELIMINAR FORZOSAMENTE después de 1.5 segundos
    setTimeout(function() {
        if (loader && loader.parentNode) {
            loader.parentNode.removeChild(loader);
        }
    }, 1500);
})();
</script>

<!-- Header -->
<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <?php bloginfo('name'); ?>
                </a>
                <?php
            }
            ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Primary Navigation -->
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ));
            ?>
        </nav>
    </div>
</header>