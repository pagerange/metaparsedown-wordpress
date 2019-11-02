<?php

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

if (!defined('ABSPATH')) die('Direct script access is not allowed');

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once __DIR__ . '/autoload.php';

use Pagerange\Markdown\MetaParsedown;
use Plugin as MpPlugin;

/**
 * Minium required version of PHP to run plugin
 */
define('PHP_REQUIRED', '7.0.0');

/**
 * Minimum required version of PHP to use YAML functionality
 */
define('YAML_PHP_REQUIRED', '7.1.3');

try {

    // Test for minimum required PHP version.
    if(version_compare(PHP_VERSION, PHP_REQUIRED) < 0) {
        if(isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        deactivate_plugins(plugin_basename(__FILE__));
       throw new MetaparsedownException('Plugin Not Activated: MetaParsedown requires a minimum PHP version of ' . PHP_REQUIRED . '.  You may need to talk to your server admin to change this setting.');
    }

    // Test that server can make URL calls with fopen
    if( !ini_get('allow_url_fopen') ) {
        throw new MetaparsedownException('Plugin Not Activated: MetaParsedown requires that <strong>allow_url_fopen</strong> be enabled in your PHP settings.  You may need to talk to your server admin to change this setting.');
    } 

    $mp = new MetaParsedown;

    $plugin = new MpPlugin($mp);

    $plugin->run();
    
} catch (MetaparsedownException $e) {

	$e->handle();

} catch (Exception $e) {

    _e($e->getMessage(), 'metaparsedown');

}

