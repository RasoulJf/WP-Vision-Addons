<?php
/**
 * Plugin Update Checker Loader - Version 5.6
 * 
 * This file loads the Plugin Update Checker library.
 * It initializes the autoloader and makes the PucFactory class available.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load the autoloader
require_once dirname(__FILE__) . '/Puc/v5p6/Autoloader.php';

// Initialize the autoloader
new YahnisElsts\PluginUpdateChecker\v5p6\Autoloader();

// Load the factory class
require_once dirname(__FILE__) . '/Puc/v5p6/PucFactory.php';

// Load the v5 compatibility layer (generic factory)
require_once dirname(__FILE__) . '/Puc/v5/PucFactory.php';
