(function($) {
    'use strict';

    class WPVisionSlider {
        constructor(element) {
            this.$wrapper = $(element);
            this.$container = this.$wrapper.find('.wpvision-slider-container');
            this.$slides = this.$wrapper.find('.wpvision-slider-item');
            this.$dots = this.$wrapper.find('.wpvision-slider-dot');
            this.$prevBtn = this.$wrapper.find('.wpvision-slider-prev');
            this.$nextBtn = this.$wrapper.find('.wpvision-slider-next');
            
            this.currentIndex = 0;
            this.totalSlides = this.$slides.length;
            this.autoplayTimer = null;
            
            // Parse settings
            const settingsAttr = this.$wrapper.data('settings');
            this.settings = typeof settingsAttr === 'string' ? JSON.parse(settingsAttr) : settingsAttr;
            
            this.init();
        }

        init() {
            if (this.totalSlides <= 1) {
                return;
            }

            // Set initial state
            this.updateSlides();
            
            // Bind events
            this.bindEvents();
            
            // Start autoplay if enabled
            if (this.settings.autoplay) {
                this.startAutoplay();
            }
        }

        bindEvents() {
            const self = this;
            
            // Dot navigation
            this.$dots.on('click', function() {
                const index = $(this).data('slide');
                self.goToSlide(index);
            });
            
            // Arrow navigation
            this.$prevBtn.on('click', () => this.prevSlide());
            this.$nextBtn.on('click', () => this.nextSlide());
            
            // Pause on hover
            this.$wrapper.on('mouseenter', () => this.pauseAutoplay());
            this.$wrapper.on('mouseleave', () => {
                if (this.settings.autoplay) {
                    this.startAutoplay();
                }
            });
            
            // Keyboard navigation
            $(document).on('keydown', function(e) {
                if (self.$wrapper.is(':hover')) {
                    if (e.keyCode === 37) { // Left arrow
                        self.prevSlide();
                    } else if (e.keyCode === 39) { // Right arrow
                        self.nextSlide();
                    }
                }
            });
            
            // Touch/Swipe support
            let touchStartX = 0;
            let touchEndX = 0;
            
            this.$container.on('touchstart', function(e) {
                touchStartX = e.originalEvent.touches[0].clientX;
            });
            
            this.$container.on('touchend', function(e) {
                touchEndX = e.originalEvent.changedTouches[0].clientX;
                self.handleSwipe(touchStartX, touchEndX);
            });
        }

        handleSwipe(startX, endX) {
            const swipeThreshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
            }
        }

        updateSlides() {
            const self = this;
            
            // Get settings
            const spacing = this.settings.slidesSpacing || 15;
            const scale = this.settings.sideScale || 0.85;
            const opacity = this.settings.sideOpacity || 0.5;
            const animationType = this.settings.animationType || 'rotate';
            
            // Calculate positions
            const rightTranslate = spacing + 50; // percentage
            const leftTranslate = -(spacing + 50); // percentage
            
            this.$slides.each(function(index) {
                const $slide = $(this);
                $slide.removeClass('active next-preview prev-preview hidden');
                
                const nextIndex = (self.currentIndex + 1) % self.totalSlides;
                const prevIndex = (self.currentIndex - 1 + self.totalSlides) % self.totalSlides;
                
                if (index === self.currentIndex) {
                    // Active slide (center)
                    $slide.addClass('active');
                    $slide.css({
                        'transform': `translate(-50%, -50%) translateX(0) translateY(0) rotateY(0deg) scale(1)`,
                        'opacity': 1
                    });
                } else if (index === nextIndex) {
                    // Next slide (right side)
                    $slide.addClass('next-preview');
                    
                    if (animationType === 'rotate') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${rightTranslate}%) translateY(15px) rotateY(15deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    } else if (animationType === 'fade') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${rightTranslate}%) translateY(0) rotateY(0deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    } else if (animationType === 'slide') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${rightTranslate}%) translateY(0) rotateY(0deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    }
                } else if (index === prevIndex) {
                    // Previous slide (left side)
                    $slide.addClass('prev-preview');
                    
                    if (animationType === 'rotate') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${leftTranslate}%) translateY(15px) rotateY(-15deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    } else if (animationType === 'fade') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${leftTranslate}%) translateY(0) rotateY(0deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    } else if (animationType === 'slide') {
                        $slide.css({
                            'transform': `translate(-50%, -50%) translateX(${leftTranslate}%) translateY(0) rotateY(0deg) scale(${scale})`,
                            'opacity': opacity
                        });
                    }
                } else {
                    // Hidden slides
                    $slide.addClass('hidden');
                    $slide.css({
                        'transform': `translate(-50%, -50%) translateX(0) translateY(30px) scale(0.7)`,
                        'opacity': 0
                    });
                }
            });
            
            // Update dots
            this.$dots.removeClass('active');
            this.$dots.eq(this.currentIndex).addClass('active');
        }

        goToSlide(index) {
            if (index === this.currentIndex || index < 0 || index >= this.totalSlides) {
                return;
            }
            
            this.currentIndex = index;
            this.updateSlides();
            this.resetAutoplay();
        }

        nextSlide() {
            this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
            this.updateSlides();
            this.resetAutoplay();
        }

        prevSlide() {
            this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
            this.updateSlides();
            this.resetAutoplay();
        }

        startAutoplay() {
            const self = this;
            this.autoplayTimer = setInterval(function() {
                self.nextSlide();
            }, this.settings.autoplaySpeed || 5000);
        }

        pauseAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        }

        resetAutoplay() {
            this.pauseAutoplay();
            if (this.settings.autoplay) {
                this.startAutoplay();
            }
        }

        destroy() {
            this.pauseAutoplay();
            this.$dots.off('click');
            this.$prevBtn.off('click');
            this.$nextBtn.off('click');
            this.$wrapper.off('mouseenter mouseleave');
            this.$container.off('touchstart touchend');
        }
    }

    // Initialize sliders
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/wpvision_slider.default', function($scope) {
            const $slider = $scope.find('.wpvision-slider-wrapper');
            if ($slider.length) {
                new WPVisionSlider($slider[0]);
            }
        });
    });

    // For non-Elementor preview
    $(document).ready(function() {
        $('.wpvision-slider-wrapper').each(function() {
            new WPVisionSlider(this);
        });
    });

})(jQuery);
