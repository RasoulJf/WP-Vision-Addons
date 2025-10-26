<?php
if (!defined('ABSPATH')) {
    exit;
}

class WPVision_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'wpvision_slider';
    }

    public function get_title() {
        return __('اسلایدر تصویر', 'wpvision');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_keywords() {
        return ['slider', 'اسلایدر', 'تصویر', 'carousel'];
    }

    public function get_script_depends() {
        return ['wpvision-slider-script'];
    }

    public function get_style_depends() {
        return ['wpvision-slider-style'];
    }

    protected function register_controls() {
        // Content Tab - Slides
        $this->start_controls_section(
            'slides_section',
            [
                'label' => __('اسلایدها', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label' => __('تصویر پس‌زمینه', 'wpvision'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_title',
            [
                'label' => __('عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('عنوان اسلاید', 'wpvision'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_subtitle',
            [
                'label' => __('زیرعنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_description',
            [
                'label' => __('توضیحات', 'wpvision'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => __('متن دکمه', 'wpvision'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('دریافت کاتالوگ', 'wpvision'),
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => __('لینک دکمه', 'wpvision'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'wpvision'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('لیست اسلایدها', 'wpvision'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_title' => __('وانیل سامینه', 'wpvision'),
                        'button_text' => __('دریافت کاتالوگ', 'wpvision'),
                    ],
                    [
                        'slide_title' => __('اسلاید دوم', 'wpvision'),
                        'button_text' => __('دریافت کاتالوگ', 'wpvision'),
                    ],
                ],
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();

        // Slider Settings
        $this->start_controls_section(
            'slider_settings_section',
            [
                'label' => __('تنظیمات اسلایدر', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('پخش خودکار', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('بله', 'wpvision'),
                'label_off' => __('خیر', 'wpvision'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('مدت زمان هر اسلاید (ms)', 'wpvision'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label' => __('نوع انیمیشن', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rotate',
                'options' => [
                    'slide' => __('اسلاید', 'wpvision'),
                    'fade' => __('محو شدن', 'wpvision'),
                    'rotate' => __('چرخش', 'wpvision'),
                ],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => __('سرعت انیمیشن (ms)', 'wpvision'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 900,
                'min' => 300,
                'max' => 2000,
                'step' => 100,
            ]
        );

        $this->add_control(
            'show_navigation',
            [
                'label' => __('نمایش دکمه‌های ناوبری', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('بله', 'wpvision'),
                'label_off' => __('خیر', 'wpvision'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => __('نمایش نقاط ناوبری', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('بله', 'wpvision'),
                'label_off' => __('خیر', 'wpvision'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'slides_spacing',
            [
                'label' => __('فاصله بین اسلایدها (%)', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],
                'description' => __('هرچه عدد کوچکتر باشد، اسلایدها به هم نزدیک‌تر می‌شوند', 'wpvision'),
            ]
        );

        $this->add_control(
            'side_slides_scale',
            [
                'label' => __('اندازه اسلایدهای کناری', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 85,
                ],
                'description' => __('اندازه اسلایدهای قبل و بعد نسبت به اسلاید اصلی', 'wpvision'),
            ]
        );

        $this->add_control(
            'side_slides_opacity',
            [
                'label' => __('شفافیت اسلایدهای کناری', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Container
        $this->start_controls_section(
            'container_style_section',
            [
                'label' => __('استایل کانتینر', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label' => __('ارتفاع اسلایدر', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('گردی گوشه‌ها', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'slider_shadow',
                'label' => __('سایه', 'wpvision'),
                'selector' => '{{WRAPPER}} .wpvision-slider-container',
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __('رنگ Overlay', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.2)',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-overlay' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Content
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('استایل محتوا', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => __('موقعیت محتوا', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => __('چپ', 'wpvision'),
                    'center' => __('وسط', 'wpvision'),
                    'right' => __('راست', 'wpvision'),
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('فاصله داخلی محتوا', 'wpvision'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '40',
                    'right' => '60',
                    'bottom' => '40',
                    'left' => '60',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Title Style
        $this->add_control(
            'title_heading',
            [
                'label' => __('عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('رنگ عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .wpvision-slide-title',
            ]
        );

        $this->add_control(
            'title_background',
            [
                'label' => __('پس‌زمینه عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __('فاصله داخلی عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'default' => [
                    'top' => '15',
                    'right' => '25',
                    'bottom' => '15',
                    'left' => '25',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label' => __('گردی گوشه عنوان', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('استایل دکمه', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('عادی', 'wpvision'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('رنگ متن', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('رنگ پس‌زمینه', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FF6B35',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('هاور', 'wpvision'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('رنگ متن', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('رنگ پس‌زمینه', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E85A2A',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .wpvision-slide-button',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('فاصله داخلی', 'wpvision'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'default' => [
                    'top' => '15',
                    'right' => '40',
                    'bottom' => '15',
                    'left' => '40',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('گردی گوشه‌ها', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Navigation Dots
        $this->start_controls_section(
            'dots_style_section',
            [
                'label' => __('استایل نقاط', 'wpvision'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('رنگ نقاط', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#CCCCCC',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_active_color',
            [
                'label' => __('رنگ نقطه فعال', 'wpvision'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label' => __('اندازه نقاط', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_spacing',
            [
                'label' => __('فاصله بین نقاط', 'wpvision'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpvision-slider-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];
        
        if (empty($slides)) {
            return;
        }

        $slider_settings = [
            'autoplay' => $settings['autoplay'] === 'yes',
            'autoplaySpeed' => $settings['autoplay_speed'],
            'animationType' => $settings['animation_type'],
            'animationDuration' => $settings['animation_duration'],
            'slidesSpacing' => $settings['slides_spacing']['size'],
            'sideScale' => $settings['side_slides_scale']['size'] / 100,
            'sideOpacity' => $settings['side_slides_opacity']['size'] / 100,
        ];
        ?>
        <div class="wpvision-slider-wrapper" 
             data-settings='<?php echo esc_attr(json_encode($slider_settings)); ?>'
             data-content-position="<?php echo esc_attr($settings['content_position']); ?>"
             data-spacing="<?php echo esc_attr($settings['slides_spacing']['size']); ?>"
             data-side-scale="<?php echo esc_attr($settings['side_slides_scale']['size'] / 100); ?>"
             data-side-opacity="<?php echo esc_attr($settings['side_slides_opacity']['size'] / 100); ?>">
            
            <div class="wpvision-slider-container">
                <?php foreach ($slides as $index => $slide) : 
                    $image_url = isset($slide['slide_image']['url']) ? $slide['slide_image']['url'] : '';
                ?>
                <div class="wpvision-slider-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                     style="background-image: url('<?php echo esc_url($image_url); ?>')">
                    <div class="wpvision-slider-overlay"></div>
                    <div class="wpvision-slider-content wpvision-content-<?php echo esc_attr($settings['content_position']); ?>">
                        <?php if (!empty($slide['slide_title'])) : ?>
                            <div class="wpvision-slide-title"><?php echo esc_html($slide['slide_title']); ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['slide_subtitle'])) : ?>
                            <div class="wpvision-slide-subtitle"><?php echo esc_html($slide['slide_subtitle']); ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['slide_description'])) : ?>
                            <div class="wpvision-slide-description"><?php echo esc_html($slide['slide_description']); ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['button_text'])) : 
                            $target = $slide['button_link']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $slide['button_link']['nofollow'] ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($slide['button_link']['url']); ?>" 
                               class="wpvision-slide-button"
                               <?php echo $target . $nofollow; ?>>
                                <?php echo esc_html($slide['button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ($settings['show_dots'] === 'yes') : ?>
            <div class="wpvision-slider-dots">
                <?php foreach ($slides as $index => $slide) : ?>
                    <span class="wpvision-slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                          data-slide="<?php echo $index; ?>"></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($settings['show_navigation'] === 'yes') : ?>
            <div class="wpvision-slider-navigation">
                <button class="wpvision-slider-prev" aria-label="<?php echo esc_attr__('قبلی', 'wpvision'); ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="wpvision-slider-next" aria-label="<?php echo esc_attr__('بعدی', 'wpvision'); ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}