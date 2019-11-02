<?php

class ExceptionHandler
{

	/**
	 * Handle plugin exceptions with some nice output
	 * @param  \Exception $e
	 * @return void
	*/
	public static function Exception(\Exception $e)
	{
		$msg= translate($e->getMessage(), 'metaparsedown');
    
	    if(is_admin()) {
	    	// Output exception for admin user
	    	add_action( 'admin_notices', function() use($msg) {
	        echo "<div class=\"error notice\">
	        <p>{$msg}</p>
	        </div>";
	    	});
	    	 // Suppress default "Plugin activated" notice
		    if ( isset( $_GET['activate'] ) ) {
		        unset( $_GET['activate'] );
		        deactivate_plugins(plugin_basename(__FILE__));
		    }
	    } else {
	    	// Output simple error message to theme template
	    	 echo "<div class=\"error notice\" style=\"color: #ff0000; font-weight: bold;\">
	        	<p>{$msg}</p>
	        </div>";
	    }
    
	}

// end ExceptionHandler class
}