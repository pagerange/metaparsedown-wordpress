<?php


if (!defined('ABSPATH')) die('Direct script access is not allowed');

/*
Plugin Name: MetaParsedown
Plugin URI: http://pagerange.com/projects/wordpress/metaparsedown
Description: Parse external markdown files and inject HTML into posts and pages, retrieve YAML metadata from them if required.
Version: 1.0.0
Author: Pagerange
Author URI: http://pagerange.com
Text Domain: metaparsedown
License: MIT
*/

define('PHP_REQUIRED', '5.3.1');

define('YAML_PHP_REQUIRED', '7.1.3');

require_once ABSPATH . 'wp-admin/includes/plugin.php';

require_once __DIR__ . '/autoload.php';

require_once __DIR__ . '/metaparsedown_shortcode.php';

require_once __DIR__ . '/exception_handler.php';

try {
    // Test for minimum required PHP version.
    if(version_compare(PHP_VERSION, PHP_REQUIRED) < 0) {
       throw new Exception('Plugin Not Activated: MetaParsedown requires a minimum PHP version of ' . PHP_REQUIRED . '.  You may need to talk to your server admin to change this setting.');
    }

    // Test that server can make URL calls with fopen
    if( !ini_get('allow_url_fopen') ) {
        throw new Exception('Plugin Not Activated: MetaParsedown requires that <strong>allow_url_fopen</strong> be enabled in your PHP settings.  You may need to talk to your server admin to change this setting.');
    } 

    add_shortcode('metaparsedown', 'metaparsedown_shortcode');

} catch (Exception $e) {
    handle_exception($e);
}


