<?php

/**
 * Enqueue all scripts and styles if user requests it
 * @return Void
 */
function metaparsedown_enqueue_scripts()
{
		wp_enqueue_style('mpstyle', plugin_dir_url(__FILE__) . 'assets/css/metaparsedown.css');
        wp_enqueue_script('microlight', plugin_dir_url(__FILE__) . 'assets/js/microlight.js', array(), true);
        wp_enqueue_script('mpscript', plugin_dir_url(__FILE__) . 'assets/js/metaparsedown.js', array('microlight'), true);
}

add_action('wp_enqueue_scripts', 'metaparsedown_enqueue_scripts', 10);