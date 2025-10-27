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

<!-- Loading Screen - Auto Hide Garantizado -->
<div id="loading-screen">
    <div class="tao-loader">
        <div class="tao-yin"></div>
        <div class="tao-yang"></div>
        <div class="dot-light"></div>
        <div class="dot-dark"></div>
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

.tao-loader {
    position: relative;
    width: 120px;
    height: 120px;
    animation: taoRotate 3s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}

.tao-yin {
    position: absolute;
    width: 60px;
    height: 120px;
    left: 0;
    background: #000;
    border-radius: 120px 0 0 120px;
}

.tao-yang {
    position: absolute;
    width: 60px;
    height: 120px;
    right: 0;
    background: #fff;
    border-radius: 0 120px 120px 0;
    border: 1px solid #000;
}

.dot-light {
    position: absolute;
    width: 20px;
    height: 20px;
    background: #fff;
    border-radius: 50%;
    top: 50%;
    left: 20px;
    transform: translateY(-50%);
}

.dot-dark {
    position: absolute;
    width: 20px;
    height: 20px;
    background: #000;
    border-radius: 50%;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

@keyframes taoRotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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