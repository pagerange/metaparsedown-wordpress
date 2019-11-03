<?php

/**
 * Bootstrap class for MetaParsedown plugin
 */

namespace Metaparsedown;

use Metaparsedown\MetaparsedownException;

class MetaparsedownPlugin
{

	/**
	 * MetaParsedown object
	 * @var MetaParsedown
	 */
	private $mp;


    /**
     * ID of the current post
     * @var Int
     */
    private $post_id;


	/**
	 * @param MetaParsedown $mp
	*/
	public function __construct(Pagerange\Markdown\MetaParsedown $mp)
	{
		$this->mp = $mp;
	}

    /**
     * Get the current post ID
     * @return Int ID of the current post
     */
    private function getPostId()
    {
         if(!$post_id = get_the_ID()) {
            throw new MetaparsedownException('MetaParsedown Exception: Could not get the post ID.');
        }

        return $post_id;
    }

	/**
	 * Run the plugin
	 * @return void
	 */
	public function run()
	{
		add_shortcode('metaparsedown', array($this, 'metaparsedownShortcode'));
	}


	/**
	 * MetaParsedown Shortcode.
	 * @param  Array $attributes passed to shortcode
	 * @return String Markedown parsed to HTML
	*/
	public function metaparsedownShortcode($atts)
	{

		try {

            $this->post_id = $this->getPostId();

	        $file = $this->getFile($atts);

	        $this->testHeaders($file);

	        $markdown = file_get_contents($file);

	        $this->processMeta($markdown, $atts);

	        return sprintf("\n<div class=\"metaparsedown\">\n %s \n</div>\n",
	        	 $this->mp->text( $this->mp->stripMeta($markdown) ) );


	     } catch (MetaparsedownException $e) {

	     	$e->handle();

	     } catch (Exception $e) {

    		_e($e->getMessage(), 'metaparsedown');

		 }
    } 


    /**
     * Test response headers from file URL
     * @param  string $file URL of file
     * @return bool 
     * @throws Exception if not 200 OK
     */
    private function testHeaders($file)
    {
    	$headers = get_headers($file);
    	if(stripos($headers[0], '200 OK') == false){ 
            throw new MetaparsedownException('MetaParsdown Error: The URL passed to the shortcode does not exist');
    	}
    	return true;
    }	
    


    /**
     * Get file from attributes passed to shortcode
     * @param  array $atts
     * @return string filename
     * @throws Exception
     */
    private function getFile($atts)
    {
    	 if (empty($atts['url'])) {
    	 	throw new MetaparsedownException('MetaParsdown Error: must provide file URL in shortcode');
            
        } 
        return $atts['url']; 
    }



    /**
     * Process YAML frontmatter in Markdown document
     * @param  MetaParsdown $mp
     * @param  string $markdown
     * @return void
     * @throws Exception if post ID not defined
     */
    private function processMeta($markdown, $atts) 
    {
    	if(!empty($atts['meta'])) {

    		$this->testYaml();
            
            $metadata = $this->mp->meta($markdown);

            // Overwrite existing post fields with YAML
            // meta data, if the user requests it
            if(!empty($atts['overwrite'])) {

                 if(!empty($metadata['summary'])) {
                    $this->setExcerpt($metadata['summary']);
                }

                if(!empty($metadata['title'])) {
                    $this->setTitle($metadata['title']);
                }

            }

            // Append YAML tags (if any) to the current
            // post's tags
            if(!empty($metadata['tags'])) {
                $this->setTags($metadata['tags']);
            }

            // Write the YAML metadata to the post_meta table
            update_post_meta($this->post_id, 'metaparsedown', $metadata);

        
        }
        return true;
    }


    /**
     * Set excerpt if markdown doc has 'summary' field.
     * @param string the summary
     */
    private function setExcerpt($summary)
    {
        $post = array(
            'ID' => $this->post_id,
            'post_excerpt' => sanitize_text_field($summary)
        );
        wp_update_post($post); 
        return true; 
    }


    /**
     * Add tags for post, creating new ones if necessary
     * @param array or string $tags Array of tags, or comma delimited string
     */
    private function setTags($tags)
    {
        wp_set_post_tags($this->post_id, $tags, true);
        return true;
    }


    /**
     * Set the post title based on the Markdown YAML title
     * @param String the YAML title
     */
    public function setTitle($title)
    {
        $slug = sanitize_title($title);
        $post = array(
            'ID' => $this->post_id,
            'post_title' => sanitize_text_field($title),
            'post_name' => $slug

        );
        wp_update_post($post);
        return true; 
    }


    /**
     * Test that server meets minimum requirement to run Yaml component
     * @return void
     * @throws  Exception
     */
    private function testYaml()
    {
    	// Yaml component requires higher version of PHP
        if(version_compare(PHP_VERSION, METAPARSEDOWN_YAML_PHP_REQUIRED) < 0) {
            throw new MetaparsedownException('MetaParsedown Exception: Extracting YAML metadata with MetaParsedown requires a minimum PHP version of ' . METAPARSEDOWN_YAML_PHP_REQUIRED . '.  You may need to talk to your server admin to change this setting.');
        }
    }


// end Plugin
}