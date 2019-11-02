<?php

/**
 * Copy this code to your theme's  functions.php file
 * to enable some basic syntax highlighting and in your
 * rendered markdown files.  
 *
 * Note, this will only work if you have left the metaparsedown
 * install directory in its default folder: 'metaparsedown'...
 * otherwise, edit the following code to meet your needs.
 */
function metaparsedown_scripts()
{
	wp_enqueue_style('metaparsedown', plugins_url() . '/metaparsedown/assets/css/style.css');
	wp_enqueue_script('microlight', plugins_url() .'/metaparsedown/assets/js/microlight.js', [], null, true);
	wp_enqueue_script('metaparsedown', plugins_url() .'/metaparsedown/assets/js/script.js', array('microlight'), true);
}
add_action('wp_enqueue_scripts', 'metaparsedown_scripts', 10);