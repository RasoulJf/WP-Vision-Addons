<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Iran_Map_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'iran-map';
    }

    public function get_title() {
        return esc_html__( 'نقشه ایران', 'iran-map-elementor' );
    }

    public function get_icon() {
        return 'eicon-google-maps';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_keywords() {
        return [ 'iran', 'map', 'نقشه', 'ایران' ];
    }

    public function get_script_depends() {
        return [ 'wpvision-iran-map-script' ];
    }

    public function get_style_depends() {
        return [ 'wpvision-iran-map-style' ];
    }

    private function get_provinces_list() {
        return [
            'tehran' => 'تهران',
            'isfahan' => 'اصفهان',
            'fars' => 'فارس',
            'khorasan-razavi' => 'خراسان رضوی',
            'khuzestan' => 'خوزستان',
            'azerbaijan-east' => 'آذربایجان شرقی',
            'azerbaijan-west' => 'ارومیه',
            'kermanshah' => 'کرمانشاه',
            'mazandaran' => 'مازندران',
            'gilan' => 'گیلان',
            'kermanshah' => 'کرمانشاه',
            'bushehr' => 'بوشهر',
            'hamedan' => 'همدان',
            'chaharmahal-bakhtiari' => 'چهارمحال و بختیاری',
            'lorestan' => 'لرستان',
            'ilam' => 'ایلام',
            'kohgiluyeh-boyerahmad' => 'کهگیلویه و بویراحمد',
            'hormozgan' => 'هرمزگان',
            'sistan-baluchestan' => 'سیستان و بلوچستان',
            'khorasan-north' => 'خراسان شمالی',
            'khorasan-south' => 'خراسان جنوبی',
            'alborz' => 'البرز',
            'ardabil' => 'اردبیل',
            'golestan' => 'گلستان',
            'qazvin' => 'قزوین',
            'qom' => 'قم',
            'kurdistan' => 'کردستان',
            'kerman' => 'کرمان',
            'markazi' => 'مرکزی',
            'semnan' => 'سمنان',
            'yazd' => 'یزد',
            'zanjan' => 'زنجان'
        ];
    }

    protected function register_controls() {
        // محتوا - استان‌ها
        $this->start_controls_section(
            'provinces_section',
            [
                'label' => esc_html__( 'استان‌ها', 'iran-map-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'province',
            [
                'label' => esc_html__( 'انتخاب استان', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces_list(),
                'default' => 'tehran',
            ]
        );

        $repeater->add_control(
            'tooltip_text',
            [
                'label' => esc_html__( 'متن تولتیپ', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'متن تولتیپ خود را اینجا وارد کنید', 'iran-map-elementor' ),
                'label_block' => true,
                'rows' => 3,
                'description' => esc_html__( 'این متن در تولتیپ نمایش داده می‌شود', 'iran-map-elementor' ),
            ]
        );

        $repeater->add_control(
            'phone',
            [
                'label' => esc_html__( 'شماره تماس', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '021-12345678',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'label_offset_x',
            [
                'label' => esc_html__( 'جابجایی افقی نام (X)', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
                'description' => esc_html__( 'موقعیت افقی نام استان روی نقشه', 'iran-map-elementor' ),
            ]
        );

        $repeater->add_control(
            'label_offset_y',
            [
                'label' => esc_html__( 'جابجایی عمودی نام (Y)', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
                'description' => esc_html__( 'موقعیت عمودی نام استان روی نقشه', 'iran-map-elementor' ),
            ]
        );

        $this->add_control(
            'provinces_list',
            [
                'label' => esc_html__( 'لیست استان‌ها', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'province' => 'tehran',
                        'tooltip_text' => 'دفتر مرکزی تهران',
                        'phone' => '021-12345678',
                        'label_offset_x' => ['size' => 0],
                        'label_offset_y' => ['size' => 0],
                    ],
                ],
                'title_field' => '{{{ tooltip_text }}}',
            ]
        );

        $this->end_controls_section();

        // تنظیمات نقشه
        $this->start_controls_section(
            'map_settings_section',
            [
                'label' => esc_html__( 'تنظیمات نقشه', 'iran-map-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'map_width',
            [
                'label' => esc_html__( 'عرض نقشه', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iran-map-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'map_height',
            [
                'label' => esc_html__( 'ارتفاع نقشه', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iran-map-container svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // استایل - رنگ‌های نقشه
        $this->start_controls_section(
            'map_colors_section',
            [
                'label' => esc_html__( 'رنگ‌های نقشه', 'iran-map-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'province_default_color',
            [
                'label' => esc_html__( 'رنگ پیش‌فرض استان‌ها', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E7E7E7',
                'selectors' => [
                    '{{WRAPPER}} .map .province path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'province_hover_color',
            [
                'label' => esc_html__( 'رنگ هاور استان‌ها', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FF6A36',
                'selectors' => [
                    '{{WRAPPER}} .map .province path.active:hover' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'province_border_color',
            [
                'label' => esc_html__( 'رنگ حاشیه استان‌های فعال', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FF6A36',
                'selectors' => [
                    '{{WRAPPER}} .map .province path.active' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'province_border_width',
            [
                'label' => esc_html__( 'ضخامت حاشیه', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .map .province path.active' => 'stroke-width: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // استایل - تایپوگرافی نام استان
        $this->start_controls_section(
            'province_label_style',
            [
                'label' => esc_html__( 'نام استان روی نقشه', 'iran-map-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .city-name',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__( 'رنگ متن', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .city-name' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_hover_color',
            [
                'label' => esc_html__( 'رنگ متن در هاور', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
            ]
        );

        $this->end_controls_section();

        // استایل - تولتیپ
        $this->start_controls_section(
            'tooltip_style_section',
            [
                'label' => esc_html__( 'استایل تولتیپ', 'iran-map-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_background',
            [
                'label' => esc_html__( 'رنگ پس‌زمینه', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .show-title' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tooltip_shadow',
                'selector' => '{{WRAPPER}} .show-title',
            ]
        );

        $this->add_responsive_control(
            'tooltip_padding',
            [
                'label' => esc_html__( 'فاصله داخلی', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .show-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_border_radius',
            [
                'label' => esc_html__( 'گردی گوشه‌ها', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .show-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_name_typography',
                'label' => esc_html__( 'تایپوگرافی نام', 'iran-map-elementor' ),
                'selector' => '{{WRAPPER}} .show-title .tooltip-name',
            ]
        );

        $this->add_control(
            'tooltip_name_color',
            [
                'label' => esc_html__( 'رنگ نام', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FF6A36',
                'selectors' => [
                    '{{WRAPPER}} .show-title .tooltip-name' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_phone_typography',
                'label' => esc_html__( 'تایپوگرافی شماره', 'iran-map-elementor' ),
                'selector' => '{{WRAPPER}} .show-title .tooltip-phone',
            ]
        );

        $this->add_control(
            'tooltip_phone_color',
            [
                'label' => esc_html__( 'رنگ شماره', 'iran-map-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .show-title .tooltip-phone' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $provinces_data = $settings['provinces_list'];
        $label_hover_color = $settings['label_hover_color'];
        $provinces_list = $this->get_provinces_list();

        // ساخت آرایه استان‌های فعال
        $active_provinces = [];
        foreach ( $provinces_data as $item ) {
            $province_key = $item['province'];
            $active_provinces[$province_key] = [
                'name' => isset($provinces_list[$province_key]) ? $provinces_list[$province_key] : '',
                'tooltip_text' => $item['tooltip_text'],
                'phone' => $item['phone'],
                'label_offset_x' => isset($item['label_offset_x']['size']) ? $item['label_offset_x']['size'] : 0,
                'label_offset_y' => isset($item['label_offset_y']['size']) ? $item['label_offset_y']['size'] : 0,
            ];
        }
        ?>
        <div class="iran-map-elementor-wrapper" data-provinces='<?php echo esc_attr( json_encode( $active_provinces ) ); ?>' data-hover-color="<?php echo esc_attr( $label_hover_color ); ?>">
            <div id="IranMap" class="iran-map-container clear">
                <div class="map">
                    <span class="show-title"></span>
                    <?php echo $this->get_iran_svg(); ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_iran_svg() {
        $svg_file = WPVISION_DIR . 'assets/svg/iran-map.svg';
        if ( file_exists( $svg_file ) ) {
            return file_get_contents( $svg_file );
        }
        return '';
    }
}