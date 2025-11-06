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

<!-- Loading Screen - Liquid Ring (igual al hero) -->
<div id="loading-screen">
    <div class="loader-liquid-overlay">
        <div class="loader-liquid-ring">
            <div class="loader-liquid-arc"></div>
            <div class="loader-liquid-arc-2"></div>
            <div class="loader-liquid-arc-3"></div>
        </div>
        
        <!-- Ondulación del agua -->
        <div class="loader-water-ripple-effect"></div>
        
        <!-- Brillo interior pulsante -->
        <div class="loader-inner-glow"></div>
    </div>
    
    <!-- Indicador de progreso -->
    <div class="loading-progress">
        <span id="loading-percentage">0%</span>
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
    flex-direction: column;
    z-index: 99999;
    transition: opacity 0.6s ease;
}

#loading-screen.hidden {
    opacity: 0;
    pointer-events: none;
}

/* Contenedor del círculo líquido */
.loader-liquid-overlay {
    position: relative;
    width: 140px;
    height: 140px;
    pointer-events: none;
}

/* Anillo que gira constantemente */
.loader-liquid-ring {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation: loaderRingRotate 20s linear infinite;
}

@keyframes loaderRingRotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Arco semicircular con efecto líquido */
.loader-liquid-arc {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 20px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.4);
    border-right-color: rgba(0, 0, 0, 0.3);
    filter: blur(8px);
    box-shadow: 
        inset 0 0 20px rgba(0, 0, 0, 0.3),
        0 0 30px rgba(0, 0, 0, 0.2);
}

/* Segundo arco con offset para efecto de profundidad */
.loader-liquid-arc-2 {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border-radius: 50%;
    border: 15px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.2);
    border-right-color: rgba(0, 0, 0, 0.15);
    filter: blur(12px);
    animation: loaderRingRotate 15s linear infinite reverse;
}

/* Tercer arco más pequeño */
.loader-liquid-arc-3 {
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    border-radius: 50%;
    border: 12px solid transparent;
    border-bottom-color: rgba(0, 0, 0, 0.3);
    border-left-color: rgba(0, 0, 0, 0.2);
    filter: blur(6px);
    animation: loaderRingRotate 25s linear infinite;
}

/* Efecto de ondulación del agua */
.loader-water-ripple-effect {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid rgba(0, 0, 0, 0.2);
    transform: translate(-50%, -50%);
    filter: blur(3px);
    animation: loaderPulseRipple 4s ease-in-out infinite;
}

@keyframes loaderPulseRipple {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.3;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.1);
        opacity: 0.6;
    }
}

/* Brillo interior del círculo */
.loader-inner-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 70%;
    height: 70%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(0, 0, 0, 0.1) 0%,
        transparent 70%
    );
    filter: blur(20px);
    animation: loaderGlowPulse 3s ease-in-out infinite;
}

@keyframes loaderGlowPulse {
    0%, 100% {
        opacity: 0.5;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.8;
        transform: translate(-50%, -50%) scale(1.1);
    }
}

.loading-progress {
    margin-top: 40px;
    font-size: 11px;
    letter-spacing: 3px;
    color: #999;
    font-weight: 300;
}
</style>

<script>
// LOADER REAL - Espera a que todos los recursos se carguen
(function() {
    var loader = document.getElementById('loading-screen');
    var percentageElement = document.getElementById('loading-percentage');
    
    if (!loader) return;
    
    var resourcesTotal = 0;
    var resourcesLoaded = 0;
    var isComplete = false;
    var minimumDisplayTime = 800; // Mínimo 800ms para que se vea la animación
    var startTime = Date.now();
    
    // Función para actualizar el progreso
    function updateProgress() {
        if (resourcesTotal === 0) return;
        
        var percentage = Math.round((resourcesLoaded / resourcesTotal) * 100);
        if (percentageElement) {
            percentageElement.textContent = percentage + '%';
        }
        
        // Si todo está cargado, ocultar el loader
        if (resourcesLoaded >= resourcesTotal && !isComplete) {
            completeLoading();
        }
    }
    
    // Función para ocultar el loader
    function hideLoader() {
        if (!loader) return;
        
        var elapsedTime = Date.now() - startTime;
        var remainingTime = Math.max(0, minimumDisplayTime - elapsedTime);
        
        setTimeout(function() {
            loader.classList.add('hidden');
            setTimeout(function() {
                if (loader && loader.parentNode) {
                    loader.parentNode.removeChild(loader);
                }
            }, 600); // Esperar a que termine la transición
        }, remainingTime);
    }
    
    function completeLoading() {
        isComplete = true;
        if (percentageElement) {
            percentageElement.textContent = '100%';
        }
        hideLoader();
    }
    
    // Contar todos los recursos a cargar
    function countResources() {
        // Imágenes
        var images = document.querySelectorAll('img');
        resourcesTotal += images.length;
        
        // Background images en hero slider
        var heroImages = document.querySelectorAll('.hero-slide-image');
        resourcesTotal += heroImages.length;
        
        // CSS
        var stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
        resourcesTotal += stylesheets.length;
        
        // Scripts
        var scripts = document.querySelectorAll('script[src]');
        resourcesTotal += scripts.length;
        
        // Si no hay recursos, terminar inmediatamente
        if (resourcesTotal === 0) {
            resourcesTotal = 1;
            resourcesLoaded = 1;
        }
        
        console.log('Total resources to load:', resourcesTotal);
    }
    
    // Cargar imágenes normales
    function loadImages() {
        var images = document.querySelectorAll('img');
        
        if (images.length === 0) {
            resourcesLoaded += 0;
            updateProgress();
            return;
        }
        
        images.forEach(function(img) {
            if (img.complete) {
                resourcesLoaded++;
                updateProgress();
            } else {
                img.addEventListener('load', function() {
                    resourcesLoaded++;
                    updateProgress();
                });
                img.addEventListener('error', function() {
                    resourcesLoaded++;
                    updateProgress();
                });
            }
        });
    }
    
    // Cargar imágenes de fondo del hero slider
    function loadBackgroundImages() {
        var heroImages = document.querySelectorAll('.hero-slide-image');
        
        if (heroImages.length === 0) {
            resourcesLoaded += 0;
            updateProgress();
            return;
        }
        
        heroImages.forEach(function(element) {
            var bgImage = window.getComputedStyle(element).backgroundImage;
            var imageUrl = bgImage.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
            
            if (imageUrl && imageUrl !== 'none') {
                var img = new Image();
                img.onload = function() {
                    resourcesLoaded++;
                    updateProgress();
                };
                img.onerror = function() {
                    resourcesLoaded++;
                    updateProgress();
                };
                img.src = imageUrl;
            } else {
                resourcesLoaded++;
                updateProgress();
            }
        });
    }
    
    // Cargar stylesheets
    function loadStylesheets() {
        var stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
        
        stylesheets.forEach(function(link) {
            // Los CSS generalmente ya están cargados en este punto
            resourcesLoaded++;
            updateProgress();
        });
    }
    
    // Cargar scripts
    function loadScripts() {
        var scripts = document.querySelectorAll('script[src]');
        
        scripts.forEach(function(script) {
            // Los scripts generalmente ya están cargados en este punto
            resourcesLoaded++;
            updateProgress();
        });
    }
    
    // Iniciar la carga
    function init() {
        countResources();
        updateProgress();
        
        // Cargar todos los recursos
        loadImages();
        loadBackgroundImages();
        loadStylesheets();
        loadScripts();
    }
    
    // Esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Fallback de seguridad: ocultar después de máximo 10 segundos
    setTimeout(function() {
        if (!isComplete) {
            console.warn('Loader fallback: forzando cierre después de 10 segundos');
            completeLoading();
        }
    }, 10000);
    
    // También escuchar el evento window.load como backup
    window.addEventListener('load', function() {
        // Dar un pequeño delay para asegurar que todo está renderizado
        setTimeout(function() {
            if (!isComplete) {
                resourcesLoaded = resourcesTotal;
                completeLoading();
            }
        }, 200);
    });
    
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