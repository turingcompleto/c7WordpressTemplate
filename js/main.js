(function($) {
    'use strict';

    // ==========================================
    // VARIABLES GLOBALES
    // ==========================================
    let currentSlideIndex = 0;
    let slides = [];
    let isTransitioning = false;
    let autoPlayInterval;

    // ==========================================
    // DOM READY
    // ==========================================
    $(document).ready(function() {
        
        // ==========================================
        // SISTEMA DE LOGOS DINÁMICOS
        // ==========================================
        function switchLogo() {
            const $lightLogo = $('.site-logo-image.light-logo');
            const $darkLogo = $('.site-logo-image.dark-logo');
            const $header = $('.site-header');
            
            // Si no hay logos dinámicos, salir
            if ($lightLogo.length === 0 || $darkLogo.length === 0) {
                return;
            }
            
            const scrollTop = $(window).scrollTop();
            const heroHeight = $('.hero-section').length ? $('.hero-section').outerHeight() : 0;
            const hasHero = $('.hero-section').length > 0;
            const isScrolled = scrollTop > 100;
            
            // Lógica del logo:
            // 1. Si estamos EN el hero → Logo BLANCO
            // 2. Si el header tiene .scrolled (fondo negro) → Logo BLANCO
            // 3. Si no hay hero y no está scrolled → Logo OSCURO
            
            if (hasHero && scrollTop < heroHeight - 100) {
                // Caso 1: Estamos en el hero
                $lightLogo.addClass('active');
                $darkLogo.removeClass('active');
                $header.removeClass('on-light-bg');
            } else if (isScrolled) {
                // Caso 2: Header con scroll (fondo negro) → Logo BLANCO
                $lightLogo.addClass('active');
                $darkLogo.removeClass('active');
                $header.addClass('on-light-bg'); // Mantener para el menú
            } else {
                // Caso 3: Fuera del hero, sin scroll → Logo OSCURO
                $lightLogo.removeClass('active');
                $darkLogo.addClass('active');
                $header.addClass('on-light-bg');
            }
        }
        
        // Ejecutar al cargar
        switchLogo();
        
        // Ejecutar al hacer scroll
        $(window).on('scroll', function() {
            switchLogo();
        });
        
        setTimeout(function() {
            initHeroSlider();
        }, 300);

        // ==========================================
        // HEADER SCROLL EFFECT
        // ==========================================
        let lastScroll = 0;
        
        $(window).on('scroll', function() {
            const currentScroll = $(window).scrollTop();
            
            if (currentScroll > 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
            
            if (currentScroll > lastScroll && currentScroll > 300) {
                $('.site-header').css('transform', 'translateY(-100%)');
            } else {
                $('.site-header').css('transform', 'translateY(0)');
            }
            
            lastScroll = currentScroll;
        });

        // ==========================================
        // MOBILE MENU
        // ==========================================
        $('.menu-toggle').on('click', function(e) {
            e.stopPropagation();
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        $('.main-navigation a').on('click', function() {
            $('.menu-toggle').removeClass('active');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open');
        });

        // Cerrar menú al hacer clic fuera
        $(document).on('click', function(e) {
            if ($('body').hasClass('menu-open')) {
                if (!$(e.target).closest('.main-navigation').length && 
                    !$(e.target).closest('.menu-toggle').length) {
                    $('.menu-toggle').removeClass('active');
                    $('.main-navigation').removeClass('active');
                    $('body').removeClass('menu-open');
                }
            }
        });

        // Cerrar menú con ESC
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $('.main-navigation').hasClass('active')) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        // ==========================================
        // ANIMACIONES AL HACER SCROLL
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
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in').forEach(function(el) {
                observer.observe(el);
            });

            document.querySelectorAll('.project-card').forEach(function(el) {
                observer.observe(el);
            });

            document.querySelectorAll('.section-title').forEach(function(el) {
                observer.observe(el);
            });
        }

        initAnimations();

        // ==========================================
        // PROJECT CARDS - HOVER CON GSAP
        // ==========================================
        $('.project-card').each(function() {
            const card = this;
            const $card = $(this);
            const $image = $card.find('.project-image img');
            const $description = $card.find('.project-description');
            
            $card.on('mouseenter', function() {
                if (typeof gsap !== 'undefined') {
                    gsap.to($image[0], {
                        scale: 1.08,
                        duration: 1.2,
                        ease: "power2.out"
                    });
                    
                    gsap.to($description[0], {
                        opacity: 1,
                        y: 0,
                        duration: 0.4,
                        ease: "power2.out",
                        delay: 0.1
                    });
                } else {
                    $image.css({
                        'transform': 'scale(1.08)',
                        'transition': 'transform 1.2s ease'
                    });
                }
            });
            
            $card.on('mouseleave', function() {
                if (typeof gsap !== 'undefined') {
                    gsap.to($image[0], {
                        scale: 1,
                        duration: 1.2,
                        ease: "power2.out"
                    });
                    
                    gsap.to($description[0], {
                        opacity: 0,
                        y: 10,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                } else {
                    $image.css('transform', 'scale(1)');
                }
            });

            $card.on('mousemove', function(e) {
                if (typeof gsap !== 'undefined') {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const percentX = (x - centerX) / centerX;
                    const percentY = (y - centerY) / centerY;
                    
                    gsap.to($card.find('.project-image')[0], {
                        rotationY: percentX * 3,
                        rotationX: -percentY * 3,
                        duration: 0.3,
                        ease: "power2.out",
                        transformPerspective: 1000,
                        transformOrigin: "center center"
                    });
                }
            });
            
            $card.on('mouseleave', function() {
                if (typeof gsap !== 'undefined') {
                    gsap.to($card.find('.project-image')[0], {
                        rotationY: 0,
                        rotationX: 0,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                }
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
                    }, 800);
                }
            }
        });

        // ==========================================
        // PARALLAX SCROLL
        // ==========================================
        if ($(window).width() > 768) {
            $(window).on('scroll', function() {
                const scrolled = $(window).scrollTop();
                $('.hero-section').css('transform', 'translateY(' + (scrolled * 0.5) + 'px)');
            });
        }

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
            $('html, body').animate({ scrollTop: 0 }, 800);
        });

    }); // End Document Ready

    // ==========================================
    // HERO SLIDER CON EFECTO LÍQUIDO/AGUA
    // ==========================================
    function initHeroSlider() {
        slides = $('.hero-slide');
        const slideCount = slides.length;
        
        if (slideCount === 0) {
            console.log('No hero slides found');
            return;
        }

        console.log('Hero Slider: Found ' + slideCount + ' slides');
        
        slides.eq(0).addClass('active');
        createNavDots();
        
        if (slideCount > 1) {
            startAutoPlay();
            
            $('.hero-section').on('mouseenter', function() {
                stopAutoPlay();
            }).on('mouseleave', function() {
                startAutoPlay();
            });
        }
        
        $(document).on('keydown', function(e) {
            if (e.keyCode === 37) {
                previousSlide();
            } else if (e.keyCode === 39) {
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
        if (isTransitioning || index === currentSlideIndex || !slides[index]) {
            return;
        }
        
        isTransitioning = true;
        const $currentSlide = slides.eq(currentSlideIndex);
        const $nextSlide = slides.eq(index);
        
        // Transición crossfade muy suave tipo Asmobius
        if (typeof gsap !== 'undefined') {
            const tl = gsap.timeline({
                onComplete: function() {
                    $currentSlide.removeClass('active');
                    isTransitioning = false;
                }
            });
            
            // Fade out muy suave del slide actual
            tl.to($currentSlide[0], {
                opacity: 0,
                duration: 2,
                ease: "power2.inOut"
            });
            
            // Preparar el siguiente slide
            tl.set($nextSlide[0], {
                opacity: 0
            }, 0);
            
            // Fade in del siguiente slide con overlap
            tl.to($nextSlide[0], {
                opacity: 1,
                duration: 2,
                ease: "power2.inOut",
                onStart: function() {
                    $nextSlide.addClass('active');
                }
            }, 0.5); // Overlap de 0.5s para transición más suave
            
        } else {
            // Fallback sin GSAP
            $currentSlide.css({
                'opacity': '0',
                'transition': 'opacity 2s cubic-bezier(0.4, 0, 0.2, 1)'
            });
            
            setTimeout(function() {
                $currentSlide.removeClass('active');
                $nextSlide.addClass('active').css('opacity', '1');
                isTransitioning = false;
            }, 1500);
        }
        
        // Actualizar dots con animación suave
        $('.hero-nav-dot').removeClass('active');
        $('.hero-nav-dot').eq(index).addClass('active');
        
        currentSlideIndex = index;
    }

    function nextSlide() {
        if (slides.length === 0) return;
        const nextIndex = (currentSlideIndex + 1) % slides.length;
        goToSlide(nextIndex);
    }

    function previousSlide() {
        if (slides.length === 0) return;
        const prevIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
        goToSlide(prevIndex);
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(function() {
            nextSlide();
        }, 7000); // 7 segundos - timing elegante tipo Asmobius
    }

    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }

    // ==========================================
    // WINDOW LOAD
    // ==========================================
    $(window).on('load', function() {
        $('.fade-in, .project-card, .section-title').each(function() {
            const elementTop = $(this).offset().top;
            const viewportBottom = $(window).scrollTop() + $(window).height();
            
            if (elementTop < viewportBottom - 100) {
                $(this).addClass('visible');
            }
        });
    });

})(jQuery);