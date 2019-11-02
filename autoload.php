<?php

if (!defined('ABSPATH')) die('Direct script access is not allowed');

/**
 * Class Autoloader for MetaParsedown Wordpress Plugin
 * @version 1.0
 * @author  Steve George <steve@pagerange.com>
 * @created 2019-111-01
 * @updated 2010-11-01
 * @license MIT
 */
spl_autoload_register(function($class){
    $base_dir = __DIR__ . '/Classes/';

    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});