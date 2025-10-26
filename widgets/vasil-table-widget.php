<?php
if (!defined('ABSPATH')) {
    exit;
}

class Elementor_Vasil_Table_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'vasil_table';
    }

    public function get_title() {
        return __('جدول المنتور', 'elementor-vasil-table');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Title Section
        $this->start_controls_section(
            'title_section',
            [
                'label' => __('عنوان', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('نمایش عنوان', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('بله', 'elementor-vasil-table'),
                'label_off' => __('خیر', 'elementor-vasil-table'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'table_title',
            [
                'label' => __('عنوان جدول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('انواع بسته بندی واسیل', 'elementor-vasil-table'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Header Section
        $this->start_controls_section(
            'header_section',
            [
                'label' => __('هدرهای جدول', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $header_repeater = new \Elementor\Repeater();

        $header_repeater->add_control(
            'header_text',
            [
                'label' => __('متن هدر', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('عنوان ستون', 'elementor-vasil-table'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'table_headers',
            [
                'label' => __('ستون‌های جدول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $header_repeater->get_controls(),
                'default' => [
                    ['header_text' => 'تعداد کارتن'],
                    ['header_text' => 'نوع بسته بندی'],
                    ['header_text' => 'نوع ارتقا'],
                    ['header_text' => 'وزن هر کرتن'],
                ],
                'title_field' => '{{{ header_text }}}',
            ]
        );

        $this->end_controls_section();

        // Table Data Section
        $this->start_controls_section(
            'table_section',
            [
                'label' => __('داده‌های جدول', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $row_repeater = new \Elementor\Repeater();

        $row_repeater->add_control(
            'row_cells',
            [
                'label' => __('سلول‌های ردیف (با | جدا کنید)', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '۱۲۸ عدد | قوطی طلایی فلزی | ۱ سال | ۲۵ گرم',
                'placeholder' => 'مقدار ۱ | مقدار ۲ | مقدار ۳ | مقدار ۴',
                'description' => 'هر سلول را با | جدا کنید',
            ]
        );

        $this->add_control(
            'table_rows',
            [
                'label' => __('ردیف‌های جدول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $row_repeater->get_controls(),
                'default' => [
                    ['row_cells' => '۱۲۸ عدد | قوطی طلایی فلزی | ۱ سال | ۲۵ گرم'],
                    ['row_cells' => '۸۵ عدد | قوطی طلایی فلزی | ۱ سال | ۲۵ گرم'],
                    ['row_cells' => '۲۴ عدد | قوطی طلایی فلزی | ۱ سال | ۲۵ گرم'],
                    ['row_cells' => '۱۲ عدد | قوطی طلایی فلزی | ۱ سال | ۲۵ گرم'],
                ],
                'title_field' => '{{{ row_cells }}}',
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('استایل عنوان', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('رنگ عنوان', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6347',
                'selectors' => [
                    '{{WRAPPER}} .vasil-table-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('تایپوگرافی عنوان', 'elementor-vasil-table'),
                'selector' => '{{WRAPPER}} .vasil-table-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('فاصله عنوان', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vasil-table-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Header Style
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __('استایل هدر جدول', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_bg_color',
            [
                'label' => __('رنگ پس‌زمینه هدر', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6347',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table thead' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => __('رنگ متن هدر', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table thead tr th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'label' => __('تایپوگرافی هدر', 'elementor-vasil-table'),
                'selector' => '{{WRAPPER}} .vasil-custom-table thead tr th',
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label' => __('فاصله داخلی هدر', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'header_border_color',
            [
                'label' => __('رنگ خط جداکننده هدر', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table thead tr th' => 'border-right-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Body Style
        $this->start_controls_section(
            'body_style_section',
            [
                'label' => __('استایل محتوای جدول', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'body_text_color',
            [
                'label' => __('رنگ متن', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'body_typography',
                'label' => __('تایپوگرافی محتوا', 'elementor-vasil-table'),
                'selector' => '{{WRAPPER}} .vasil-custom-table tbody tr td',
            ]
        );

        $this->add_responsive_control(
            'body_padding',
            [
                'label' => __('فاصله داخلی سلول‌ها', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'row_odd_bg',
            [
                'label' => __('رنگ پس‌زمینه ردیف‌های فرد', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fafafa',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'row_even_bg',
            [
                'label' => __('رنگ پس‌زمینه ردیف‌های زوج', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'row_hover_bg',
            [
                'label' => __('رنگ پس‌زمینه hover', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff5f0',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cell_border_color',
            [
                'label' => __('رنگ خط جداکننده سلول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e8e8e8',
                'selectors' => [
                    '{{WRAPPER}} .vasil-custom-table tbody tr td' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .vasil-custom-table tbody tr' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Table Container Style
        $this->start_controls_section(
            'container_style_section',
            [
                'label' => __('استایل کانتینر جدول', 'elementor-vasil-table'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'table_bg_color',
            [
                'label' => __('رنگ پس‌زمینه جدول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .vasil-table-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_border_radius',
            [
                'label' => __('گردی گوشه‌ها', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .vasil-table-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_box_shadow',
                'label' => __('سایه', 'elementor-vasil-table'),
                'selector' => '{{WRAPPER}} .vasil-table-wrapper',
            ]
        );

        $this->add_responsive_control(
            'table_margin',
            [
                'label' => __('فاصله بیرونی جدول', 'elementor-vasil-table'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vasil-table-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="vasil-table-container">
            <?php if ($settings['show_title'] === 'yes' && !empty($settings['table_title'])) : ?>
            <h1 class="vasil-table-title"><?php echo esc_html($settings['table_title']); ?></h1>
            <?php endif; ?>
            
            <div class="vasil-table-wrapper">
                <table class="vasil-custom-table">
                    <?php if (!empty($settings['table_headers'])) : ?>
                    <thead>
                        <tr>
                            <?php foreach ($settings['table_headers'] as $header) : ?>
                            <th><?php echo esc_html($header['header_text']); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <?php endif; ?>
                    <tbody>
                        <?php foreach ($settings['table_rows'] as $row) : 
                            $cells = explode('|', $row['row_cells']);
                        ?>
                        <tr>
                            <?php foreach ($cells as $cell) : ?>
                            <td><?php echo esc_html(trim($cell)); ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}