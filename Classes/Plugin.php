<?php

/**
 * Bootstrap class for MetaParsedown plugin
 */

class Plugin
{

	/**
	 * MetaParsedown object
	 * @var MetaParsedown
	 */
	private $mp;


	/**
	 * @param MetaParsedown $mp
	*/
	public function __construct(Pagerange\Markdown\MetaParsedown $mp)
	{
		$this->mp = $mp;
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

	        $file = $this->getFile($atts);

	        $this->testHeaders($file);

	        $markdown = file_get_contents($file);

	        $this->processMeta($markdown, $atts);

	        return sprintf("\n<div class=\"metaparsedown\">\n %s \n</div>\n",
	        	 $this->mp->text( $this->mp->stripMeta($markdown) ) );;

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
     * @throws Exception if 404 Not Found
     */
    private function testHeaders($file)
    {
    	$headers = get_headers($file);
    	if(strpos($headers[0], '404 Not Found') !== false){ 
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
    	 if (empty($atts['file'])) {
    	 	throw new MetaparsedownException('MetaParsdown Error: must provide file URL in shortcode');
            
        } 
        return $atts['file']; 
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

            if($post_id = get_the_ID()) {
                update_post_meta($post_id, 'metaparsedown', $metadata);
            } else {
                throw new MetaparsedownException('MetaParsedown Exception: Could not get the post ID while updating post metadata.');
            }
        }
    }



    /**
     * Test that server meets minimum requirement to run Yaml component
     * @return void
     * @throws  Exception
     */
    private function testYaml()
    {
    	// Yaml component requires higher version of PHP
        if(!(version_compare(PHP_VERSION, YAML_PHP_REQUIRED) > 0)) {
            throw new MetaparsedownException('MetaParsedown Exception: Extracting YAML metadata with MetaParsedown requires a minimum PHP version of ' . YAML_PHP_REQUIRED . '.  You may need to talk to your server admin to change this setting.');
        }
    }


// end Plugin
}