<?php


class MetaparsedownException extends \Exception
{

	/**
	 * Handle plugin exceptions
	 * @return void
	*/
	public function handle()
	{
		$msg= translate($this->getMessage(), 'metaparsedown');
    
	    if(is_admin()) {
	    	// Output error message for admin user
	    	add_action( 'admin_notices', function() use($msg) {
	        	printf('<div class="error notice"><p>%s</p></div>', $msg);
	    	});
	    	
	    } else {
	    	// Output simple error message to theme template
	    	 printf('<div class="error notice" style="color: #ff0000;"><p>%s</p></div>', $msg);
	    }
    
	}
}