<?php


if (!defined('ABSPATH')) die('Direct script access is not allowed');


/**
 * MetaParsedown Shortcode.
 * @param  Array $attributes passed in shortcode
 * @return String Markedown parsed to HTML
 */
function metaparsedown_shortcode($atts)
{
    try {

        if (!empty($atts['file'])) {
            $file = $atts['file']; 
        } else {
            throw new Exception('MetaParsdown Error: must provide file URL in shortcode');
        }

        $headers = get_headers($file);

        if(strpos($headers[0], '404 Not Found') !== false){ 
            throw new Exception('MetaParsdown Error: The URL passed to the shortcode does not exist');
        } else {

            $mp = new Pagerange\Markdown\MetaParsedown;

            $md = file_get_contents($file);

            if(!empty($atts['meta'])) {

                // Yaml component requires higher version of PHP
                if(!(version_compare(PHP_VERSION, YAML_PHP_REQUIRED) > 0)) {
                    throw new Exception('MetaParsedown Exception: Extracting YAML metadata with MetaParsedown requires a minimum PHP version of ' . YAML_PHP_REQUIRED . '.  You may need to talk to your server admin to change this setting.');
                }
                $metadata = $mp->meta($md);
                if($post_id = get_the_ID()) {
                    update_post_meta($post_id, 'metaparsedown', $metadata);
                } else {
                    throw new Exception('MetaParsedown Exception: Could not get the post ID while updating post metadata.');
                }
            }

            $html = "\n<div class=\"metaparsedown\">\n". 
                        $mp->text($mp->stripMeta($md)) . 
                    "\n</div>\n";
            
            return $html;

        }

        return false;

        } catch (Exception $e) {
            handle_exception($e);
        }
    } 
