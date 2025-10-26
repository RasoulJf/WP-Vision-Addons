<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin Settings Page
 */
class WPVision_Admin_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('wpvision Addons', 'wpvision'),
            __('wpvision Addons', 'wpvision'),
            'manage_options',
            'wpvision-addons',
            [$this, 'render_settings_page'],
            'dashicons-admin-plugins',
            59
        );
    }

    public function register_settings() {
        register_setting('wpvision_settings', 'wpvision_enabled_widgets');
        register_setting('wpvision_github_settings', 'wpvision_github_url');
        register_setting('wpvision_github_settings', 'wpvision_github_branch');
        register_setting('wpvision_github_settings', 'wpvision_github_token');
    }

    public function enqueue_admin_styles($hook) {
        if ($hook !== 'toplevel_page_wpvision-addons') {
            return;
        }
        
        wp_enqueue_style('wpvision-admin-style', WPVISION_URL . 'assets/css/admin-style.css', [], WPVISION_VERSION);
    }

    public function render_settings_page() {
        // Get current settings
        $enabled_widgets = get_option('wpvision_enabled_widgets', [
            'iran_map' => 'on',
            'vasil_table' => 'on',
            'slider' => 'on'
        ]);

        // Get GitHub settings
        $github_url = get_option('wpvision_github_url', '');
        $github_branch = get_option('wpvision_github_branch', 'main');
        $github_token = get_option('wpvision_github_token', '');

        // Handle form submission
        if (isset($_POST['wpvision_save_settings']) && check_admin_referer('wpvision_settings_nonce')) {
            $new_settings = [
                'iran_map' => isset($_POST['wpvision_iran_map']) ? 'on' : 'off',
                'vasil_table' => isset($_POST['wpvision_vasil_table']) ? 'on' : 'off',
                'slider' => isset($_POST['wpvision_slider']) ? 'on' : 'off'
            ];
            update_option('wpvision_enabled_widgets', $new_settings);
            $enabled_widgets = $new_settings;
            
            // Save GitHub settings
            if (isset($_POST['wpvision_github_url'])) {
                update_option('wpvision_github_url', sanitize_text_field($_POST['wpvision_github_url']));
                $github_url = $_POST['wpvision_github_url'];
            }
            if (isset($_POST['wpvision_github_branch'])) {
                update_option('wpvision_github_branch', sanitize_text_field($_POST['wpvision_github_branch']));
                $github_branch = $_POST['wpvision_github_branch'];
            }
            if (isset($_POST['wpvision_github_token'])) {
                update_option('wpvision_github_token', sanitize_text_field($_POST['wpvision_github_token']));
                $github_token = $_POST['wpvision_github_token'];
            }
            
            echo '<div class="notice notice-success is-dismissible"><p>' . __('تنظیمات با موفقیت ذخیره شد!', 'wpvision') . '</p></div>';
        }
        ?>
        <div class="wrap wpvision-settings-wrap">
            <h1 class="wpvision-title">
                <span class="wpvision-logo">🎨</span>
                <?php echo esc_html__('wpvision Addons - تنظیمات ویجت ها', 'wpvision'); ?>
            </h1>
            <p class="wpvision-description"><?php echo esc_html__('ویجت های مورد نظر خود را فعال یا غیرفعال کنید', 'wpvision'); ?></p>

            <form method="post" action="">
                <?php wp_nonce_field('wpvision_settings_nonce'); ?>
                
                <div class="wpvision-widgets-grid">
                    <!-- Iran Map Widget -->
                    <div class="wpvision-widget-card <?php echo ($enabled_widgets['iran_map'] === 'on') ? 'active' : ''; ?>">
                        <div class="widget-card-header">
                            <span class="widget-icon">🗺️</span>
                            <h3><?php echo esc_html__('نقشه ایران', 'wpvision'); ?></h3>
                        </div>
                        <div class="widget-card-body">
                            <p><?php echo esc_html__('ویجت نقشه تعاملی ایران با قابلیت سفارشی‌سازی کامل', 'wpvision'); ?></p>
                            <ul class="widget-features">
                                <li>✓ نقشه SVG تعاملی</li>
                                <li>✓ سفارشی‌سازی رنگ‌ها</li>
                                <li>✓ تولتیپ اطلاعاتی</li>
                                <li>✓ لینک به استان‌ها</li>
                            </ul>
                        </div>
                        <div class="widget-card-footer">
                            <label class="wpvision-toggle">
                                <input type="checkbox" name="wpvision_iran_map" <?php checked($enabled_widgets['iran_map'], 'on'); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php echo ($enabled_widgets['iran_map'] === 'on') ? esc_html__('فعال', 'wpvision') : esc_html__('غیرفعال', 'wpvision'); ?></span>
                            </label>
                        </div>
                    </div>

                    <!-- Vasil Table Widget -->
                    <div class="wpvision-widget-card <?php echo ($enabled_widgets['vasil_table'] === 'on') ? 'active' : ''; ?>">
                        <div class="widget-card-header">
                            <span class="widget-icon">📊</span>
                            <h3><?php echo esc_html__('جدول المنتور', 'wpvision'); ?></h3>
                        </div>
                        <div class="widget-card-body">
                            <p><?php echo esc_html__('ویجت جدول حرفه‌ای با طراحی زیبا و قابلیت‌های پیشرفته', 'wpvision'); ?></p>
                            <ul class="widget-features">
                                <li>✓ طراحی مدرن و زیبا</li>
                                <li>✓ سفارشی‌سازی کامل</li>
                                <li>✓ ریسپانسیو</li>
                                <li>✓ ستون‌های نامحدود</li>
                            </ul>
                        </div>
                        <div class="widget-card-footer">
                            <label class="wpvision-toggle">
                                <input type="checkbox" name="wpvision_vasil_table" <?php checked($enabled_widgets['vasil_table'], 'on'); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php echo ($enabled_widgets['vasil_table'] === 'on') ? esc_html__('فعال', 'wpvision') : esc_html__('غیرفعال', 'wpvision'); ?></span>
                            </label>
                        </div>
                    </div>

                    <!-- Slider Widget -->
                    <div class="wpvision-widget-card <?php echo ($enabled_widgets['slider'] === 'on') ? 'active' : ''; ?>">
                        <div class="widget-card-header">
                            <span class="widget-icon">🎬</span>
                            <h3><?php echo esc_html__('اسلایدر تصویر', 'wpvision'); ?></h3>
                        </div>
                        <div class="widget-card-body">
                            <p><?php echo esc_html__('ویجت اسلایدر حرفه‌ای با انیمیشن‌های چرخشی و عمودی و طراحی مدرن', 'wpvision'); ?></p>
                            <ul class="widget-features">
                                <li>✓ انیمیشن چرخشی و نرم</li>
                                <li>✓ پیش‌نمایش اسلاید بعدی</li>
                                <li>✓ اتوپلی و ناوبری</li>
                                <li>✓ سفارشی‌سازی کامل</li>
                            </ul>
                        </div>
                        <div class="widget-card-footer">
                            <label class="wpvision-toggle">
                                <input type="checkbox" name="wpvision_slider" <?php checked($enabled_widgets['slider'], 'on'); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php echo ($enabled_widgets['slider'] === 'on') ? esc_html__('فعال', 'wpvision') : esc_html__('غیرفعال', 'wpvision'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- GitHub Auto-Update Settings -->
                <div class="wpvision-section-header" style="margin-top: 40px;">
                    <h2>
                        <span class="dashicons dashicons-update" style="font-size: 24px; vertical-align: middle;"></span>
                        <?php echo esc_html__('تنظیمات بروزرسانی خودکار GitHub', 'wpvision'); ?>
                    </h2>
                    <p class="description"><?php echo esc_html__('برای فعال‌سازی بروزرسانی خودکار از GitHub، اطلاعات زیر را تکمیل کنید.', 'wpvision'); ?></p>
                </div>

                <div class="wpvision-github-settings" style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row">
                                <label for="wpvision_github_url">
                                    <?php echo esc_html__('آدرس Repository در GitHub', 'wpvision'); ?>
                                </label>
                            </th>
                            <td>
                                <input type="url" 
                                       id="wpvision_github_url" 
                                       name="wpvision_github_url" 
                                       value="<?php echo esc_attr($github_url); ?>" 
                                       class="regular-text" 
                                       placeholder="https://github.com/username/repository-name/">
                                <p class="description">
                                    <?php echo esc_html__('مثال: https://github.com/your-username/wpvision-addons/', 'wpvision'); ?><br>
                                    <?php echo esc_html__('⚠️ اگر خالی بماند، بروزرسانی خودکار غیرفعال است.', 'wpvision'); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="wpvision_github_branch">
                                    <?php echo esc_html__('نام Branch', 'wpvision'); ?>
                                </label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="wpvision_github_branch" 
                                       name="wpvision_github_branch" 
                                       value="<?php echo esc_attr($github_branch); ?>" 
                                       class="regular-text" 
                                       placeholder="main">
                                <p class="description">
                                    <?php echo esc_html__('پیش‌فرض: main (یا master برای مخازن قدیمی)', 'wpvision'); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="wpvision_github_token">
                                    <?php echo esc_html__('GitHub Access Token', 'wpvision'); ?>
                                    <span style="color: #999;"><?php echo esc_html__('(اختیاری)', 'wpvision'); ?></span>
                                </label>
                            </th>
                            <td>
                                <input type="password" 
                                       id="wpvision_github_token" 
                                       name="wpvision_github_token" 
                                       value="<?php echo esc_attr($github_token); ?>" 
                                       class="regular-text" 
                                       placeholder="ghp_xxxxxxxxxxxxxxxxxxxx">
                                <p class="description">
                                    <?php echo esc_html__('فقط برای مخازن خصوصی (Private) لازم است.', 'wpvision'); ?><br>
                                    <?php echo esc_html__('راهنمای ساخت توکن: Settings > Developer settings > Personal access tokens', 'wpvision'); ?>
                                </p>
                            </td>
                        </tr>
                    </table>

                    <?php if (!empty($github_url)) : ?>
                    <div class="wpvision-status-box" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin-top: 20px;">
                        <strong>✅ <?php echo esc_html__('وضعیت: فعال', 'wpvision'); ?></strong><br>
                        <?php echo esc_html__('بروزرسانی خودکار از GitHub فعال است.', 'wpvision'); ?>
                    </div>
                    <?php else : ?>
                    <div class="wpvision-status-box" style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin-top: 20px;">
                        <strong>⚠️ <?php echo esc_html__('وضعیت: غیرفعال', 'wpvision'); ?></strong><br>
                        <?php echo esc_html__('برای فعال‌سازی، آدرس GitHub Repository را وارد کنید.', 'wpvision'); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="wpvision-submit-wrapper">
                    <?php submit_button(__('ذخیره تنظیمات', 'wpvision'), 'primary large', 'wpvision_save_settings'); ?>
                </div>
            </form>

            <div class="wpvision-info-box">
                <h3>📚 <?php echo esc_html__('راهنما', 'wpvision'); ?></h3>
                <p><?php echo esc_html__('برای استفاده از ویجت‌ها، وارد صفحه ویرایش با Elementor شوید و ویجت مورد نظر را از پنل سمت چپ انتخاب کنید.', 'wpvision'); ?></p>
                <p><strong><?php echo esc_html__('توجه:', 'wpvision'); ?></strong> <?php echo esc_html__('پس از تغییر تنظیمات، کش مرورگر خود را پاک کنید.', 'wpvision'); ?></p>
            </div>
        </div>
        <?php
    }
}

new WPVision_Admin_Settings();