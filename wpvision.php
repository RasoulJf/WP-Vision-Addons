<?php
/**
 * Plugin Name: wpvision Addons
 * Plugin URI: https://wpvision.com
 * Description: مجموعه ویجت های حرفه ای برای Elementor - شامل نقشه ایران، جدول المنتور و اسلایدر تصویر
 * Version: 1.0.0
 * Author: wpvision Team
 * Author URI: https://wpvision.com
 * Text Domain: wpvision
 * Domain Path: /languages
 * Elementor tested up to: 3.20.0
 * Elementor Pro tested up to: 3.20.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define Constants
define('WPVISION_VERSION', '1.0.0');
define('WPVISION_DIR', plugin_dir_path(__FILE__));
define('WPVISION_URL', plugin_dir_url(__FILE__));
define('WPVISION_FILE', __FILE__);

// GitHub Auto-Update Configuration
function wpvision_load_update_checker() {
    // Get GitHub URL from options (can be set in admin panel)
    $github_url = get_option('wpvision_github_url', '');
    
    // Only initialize if GitHub URL is set
    if (!empty($github_url) && file_exists(WPVISION_DIR . 'includes/plugin-update-checker.php')) {
        require_once(WPVISION_DIR . 'includes/plugin-update-checker.php');
        
        try {
            $myUpdateChecker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
                $github_url,
                WPVISION_FILE,
                'wpvision-addons'
            );
            
            // Set branch (default: main)
            $branch = get_option('wpvision_github_branch', 'main');
            if ($myUpdateChecker && !empty($branch)) {
                $myUpdateChecker->setBranch($branch);
            }
            
            // Optional: Set GitHub access token for private repositories
            $github_token = get_option('wpvision_github_token', '');
            if ($myUpdateChecker && !empty($github_token)) {
                $myUpdateChecker->setAuthentication($github_token);
            }
            
            // Enable release assets (recommended for proper versioning)
            if ($myUpdateChecker) {
                $myUpdateChecker->getVcsApi()->enableReleaseAssets();
            }
        } catch (Exception $e) {
            // Log error for debugging but don't break the plugin
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('WPVision Update Checker Error: ' . $e->getMessage());
            }
        }
    }
}
add_action('plugins_loaded', 'wpvision_load_update_checker');

/**
 * Main wpvision Addons Class
 */
final class WPVision_Addons {

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Load Admin Settings
        require_once(WPVISION_DIR . 'includes/admin-settings.php');

        // Register Widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Register Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        
        // Register Widget Scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
    }

    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('برای استفاده از "%1$s" باید افزونه "%2$s" نصب و فعال باشد.', 'wpvision'),
            '<strong>' . esc_html__('wpvision Addons', 'wpvision') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'wpvision') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function register_widgets($widgets_manager) {
        // Get enabled widgets from settings
        $enabled_widgets = get_option('wpvision_enabled_widgets', [
            'iran_map' => 'on',
            'vasil_table' => 'on',
            'slider' => 'on'
        ]);

        // Register Iran Map Widget
        if (isset($enabled_widgets['iran_map']) && $enabled_widgets['iran_map'] === 'on') {
            require_once(WPVISION_DIR . 'widgets/iran-map-widget.php');
            $widgets_manager->register(new \Iran_Map_Widget());
        }

        // Register Vasil Table Widget
        if (isset($enabled_widgets['vasil_table']) && $enabled_widgets['vasil_table'] === 'on') {
            require_once(WPVISION_DIR . 'widgets/vasil-table-widget.php');
            $widgets_manager->register(new \Elementor_Vasil_Table_Widget());
        }

        // Register Slider Widget
        if (isset($enabled_widgets['slider']) && $enabled_widgets['slider'] === 'on') {
            require_once(WPVISION_DIR . 'widgets/slider-widget.php');
            $widgets_manager->register(new \WPVision_Slider_Widget());
        }
    }

    public function widget_styles() {
        $enabled_widgets = get_option('wpvision_enabled_widgets', [
            'iran_map' => 'on',
            'vasil_table' => 'on',
            'slider' => 'on'
        ]);

        // Iran Map Styles
        if (isset($enabled_widgets['iran_map']) && $enabled_widgets['iran_map'] === 'on') {
            wp_enqueue_style(
                'wpvision-iran-map-style',
                WPVISION_URL . 'assets/css/iranmap.css',
                [],
                WPVISION_VERSION
            );
        }

        // Vasil Table Styles
        if (isset($enabled_widgets['vasil_table']) && $enabled_widgets['vasil_table'] === 'on') {
            wp_enqueue_style(
                'wpvision-vasil-table-style',
                WPVISION_URL . 'assets/css/vasil-table.css',
                [],
                WPVISION_VERSION
            );
        }

        // Slider Styles
        if (isset($enabled_widgets['slider']) && $enabled_widgets['slider'] === 'on') {
            wp_enqueue_style(
                'wpvision-slider-style',
                WPVISION_URL . 'assets/css/slider.css',
                [],
                WPVISION_VERSION
            );
        }
    }

    public function widget_scripts() {
        $enabled_widgets = get_option('wpvision_enabled_widgets', [
            'iran_map' => 'on',
            'vasil_table' => 'on',
            'slider' => 'on'
        ]);

        // Iran Map Scripts
        if (isset($enabled_widgets['iran_map']) && $enabled_widgets['iran_map'] === 'on') {
            wp_register_script(
                'wpvision-iran-map-script',
                WPVISION_URL . 'assets/js/iranmap.js',
                ['jquery'],
                WPVISION_VERSION,
                true
            );
        }

        // Slider Scripts
        if (isset($enabled_widgets['slider']) && $enabled_widgets['slider'] === 'on') {
            wp_register_script(
                'wpvision-slider-script',
                WPVISION_URL . 'assets/js/slider.js',
                ['jquery'],
                WPVISION_VERSION,
                true
            );
        }
    }
}

WPVision_Addons::instance();