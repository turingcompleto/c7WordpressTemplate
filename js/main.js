(function($) {
    'use strict';

    // ==========================================
    // VARIABLES GLOBALES
    // ==========================================
    let isScrolling = false;
    let scrollTimeout;

    // ==========================================
    // DOM READY
    // ==========================================
    $(document).ready(function() {
        
        // Hide Loading Screen con efecto
        setTimeout(function() {
            $('.loading-screen').addClass('hide');
            initAnimations();
        }, 800);

        // ==========================================
        // HEADER SCROLL EFFECT
        // ==========================================
        let lastScroll = 0;
        
        $(window).on('scroll', function() {
            const currentScroll = $(window).scrollTop();
            
            // Cambiar header al hacer scroll
            if (currentScroll > 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
            
            // Ocultar/mostrar header al hacer scroll
            if (currentScroll > lastScroll && currentScroll > 200) {
                $('.site-header').css('transform', 'translateY(-100%)');
            } else {
                $('.site-header').css('transform', 'translateY(0)');
            }
            
            lastScroll = currentScroll;
        });

        // ==========================================
        // MOBILE MENU
        // ==========================================
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        $('.main-navigation a').on('click', function() {
            $('.menu-toggle').removeClass('active');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open');
        });

       // ==========================================
// HERO SLIDER CON EFECTO AGUA/TAO
// ==========================================

let currentSlideIndex = 0;
let slides = [];
let isTransitioning = false;
let autoPlayInterval;

function initHeroSlider() {
    slides = $('.hero-slide');
    const slideCount = slides.length;
    
    if (slideCount === 0) return;
    
    // Mostrar primer slide
    slides.eq(0).addClass('active');
    
    // Crear navegación de dots
    createNavDots();
    
    // Auto-play solo si hay múltiples slides
    if (slideCount > 1) {
        startAutoPlay();
        
        // Pausar en hover
        $('.hero-section').on('mouseenter', function() {
            stopAutoPlay();
        }).on('mouseleave', function() {
            startAutoPlay();
        });
    }
    
    // Navegación con teclado
    $(document).on('keydown', function(e) {
        if (e.keyCode === 37) { // Left arrow
            previousSlide();
        } else if (e.keyCode === 39) { // Right arrow
            nextSlide();
        }
    });
}

function createNavDots() {
    const navContainer = $('<div class="hero-navigation"></div>');
    
    slides.each(function(index) {
        const dot = $('<div class="hero-nav-dot"></div>');
        
        if (index === 0) {
            dot.addClass('active');
        }
        
        dot.on('click', function() {
            goToSlide(index);
        });
        
        navContainer.append(dot);
    });
    
    $('.hero-section').append(navContainer);
}

function goToSlide(index) {
    if (isTransitioning || index === currentSlideIndex) return;
    
    isTransitioning = true;
    const $currentSlide = slides.eq(currentSlideIndex);
    const $nextSlide = slides.eq(index);
    
    // Animación líquida de salida
    $currentSlide.addClass('fade-out');
    
    setTimeout(function() {
        $currentSlide.removeClass('active fade-out');
        $nextSlide.addClass('active');
        
        // Actualizar dots
        $('.hero-nav-dot').removeClass('active');
        $('.hero-nav-dot').eq(index).addClass('active');
        
        currentSlideIndex = index;
        
        setTimeout(function() {
            isTransitioning = false;
        }, 500);
        
    }, 1000);
}

function nextSlide() {
    const nextIndex = (currentSlideIndex + 1) % slides.length;
    goToSlide(nextIndex);
}

function previousSlide() {
    const prevIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
    goToSlide(prevIndex);
}

function startAutoPlay() {
    stopAutoPlay();
    autoPlayInterval = setInterval(function() {
        nextSlide();
    }, 7000); // Cambiar cada 7 segundos
}

function stopAutoPlay() {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
    }
}

// Inicializar al cargar
$(document).ready(function() {
    setTimeout(function() {
        initHeroSlider();
    }, 500);
});

        // ==========================================
        // ANIMACIONES AL HACER SCROLL (Intersection Observer)
        // ==========================================
        function initAnimations() {
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry, index) {
                    if (entry.isIntersecting) {
                        setTimeout(function() {
                            entry.target.classList.add('visible');
                        }, index * 100); // Stagger effect
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observar todos los elementos con fade-in
            document.querySelectorAll('.fade-in').forEach(function(el) {
                observer.observe(el);
            });

            // Observar project cards individualmente
            document.querySelectorAll('.project-card').forEach(function(el) {
                observer.observe(el);
            });

            // Observar section titles
            document.querySelectorAll('.section-title').forEach(function(el) {
                observer.observe(el);
            });

            // Observar botones
            document.querySelectorAll('.view-more-projects').forEach(function(el) {
                observer.observe(el);
            });
        }

        // ==========================================
        // PROJECT CARDS - HOVER EFFECTS AVANZADOS
        // ==========================================
        $('.project-card').each(function() {
            const $card = $(this);
            const $image = $card.find('.project-image');
            
            $card.on('mouseenter', function(e) {
                // Animación de la imagen
                TweenMax.to($card.find('.project-image img'), 1.2, {
                    scale: 1.08,
                    ease: Power2.easeOut
                });
                
                // Mostrar descripción
                TweenMax.to($card.find('.project-description'), 0.4, {
                    opacity: 1,
                    y: 0,
                    ease: Power2.easeOut,
                    delay: 0.1
                });
            });
            
            $card.on('mouseleave', function() {
                TweenMax.to($card.find('.project-image img'), 1.2, {
                    scale: 1,
                    ease: Power2.easeOut
                });
                
                TweenMax.to($card.find('.project-description'), 0.3, {
                    opacity: 0,
                    y: 10,
                    ease: Power2.easeOut
                });
            });

            // Efecto parallax sutil en el movimiento del mouse
            $card.on('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const percentX = (x - centerX) / centerX;
                const percentY = (y - centerY) / centerY;
                
                TweenMax.to($image, 0.3, {
                    rotationY: percentX * 2,
                    rotationX: -percentY * 2,
                    ease: Power2.easeOut,
                    transformPerspective: 1000,
                    transformOrigin: 'center center'
                });
            });
            
            $card.on('mouseleave', function() {
                TweenMax.to($image, 0.6, {
                    rotationY: 0,
                    rotationX: 0,
                    ease: Power2.easeOut
                });
            });
        });

        // ==========================================
        // SMOOTH SCROLL
        // ==========================================
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000, 'easeInOutCubic');
                }
            }
        });

        // ==========================================
        // PARALLAX SCROLL EFFECT
        // ==========================================
        if ($(window).width() > 768) {
            $(window).on('scroll', function() {
                const scrolled = $(window).scrollTop();
                
                // Parallax en hero
                $('.hero-section').css('transform', 'translateY(' + (scrolled * 0.5) + 'px)');
                
                // Parallax sutil en project cards
                $('.project-card').each(function() {
                    const $this = $(this);
                    const offsetTop = $this.offset().top;
                    const scrollPercent = (scrolled - offsetTop + $(window).height()) / $(window).height();
                    
                    if (scrollPercent > 0 && scrollPercent < 2) {
                        const translateY = (scrollPercent - 1) * 30;
                        $this.css('transform', 'translateY(' + translateY + 'px)');
                    }
                });
            });
        }

        // ==========================================
        // PAGE TRANSITIONS
        // ==========================================
        $('a').not('[target="_blank"]').not('[href^="#"]').not('.no-transition').on('click', function(e) {
            if (this.hostname === window.location.hostname) {
                e.preventDefault();
                const href = $(this).attr('href');
                
                $('body').append('<div class="page-transition"></div>');
                
                setTimeout(function() {
                    $('.page-transition').addClass('active');
                }, 10);
                
                setTimeout(function() {
                    window.location = href;
                }, 600);
            }
        });

        // ==========================================
        // BACK TO TOP BUTTON
        // ==========================================
        const backToTop = $('<button class="back-to-top" aria-label="Back to top">↑</button>');
        $('body').append(backToTop);

        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 400) {
                backToTop.addClass('show');
            } else {
                backToTop.removeClass('show');
            }
        });

        backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 1000, 'easeInOutCubic');
        });

        // ==========================================
        // LAZY LOADING DE IMÁGENES
        // ==========================================
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('loading');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }

        // ==========================================
        // KEYBOARD NAVIGATION
        // ==========================================
        $(document).on('keydown', function(e) {
            // ESC cierra el menú móvil
            if (e.keyCode === 27 && $('.main-navigation').hasClass('active')) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        // ==========================================
        // PRELOAD HOVER IMAGES
        // ==========================================
        $('.project-card').each(function() {
            const imgSrc = $(this).find('img').attr('src');
            if (imgSrc) {
                const img = new Image();
                img.src = imgSrc;
            }
        });

    }); // End Document Ready

    // ==========================================
    // WINDOW LOAD
    // ==========================================
    $(window).on('load', function() {
        // Re-check animations
        $('.fade-in, .project-card, .section-title').each(function() {
            const elementTop = $(this).offset().top;
            const viewportBottom = $(window).scrollTop() + $(window).height();
            
            if (elementTop < viewportBottom - 100) {
                $(this).addClass('visible');
            }
        });
    });

    // ==========================================
    // EASING FUNCTIONS
    // ==========================================
    $.easing.easeInOutCubic = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

})(jQuery);