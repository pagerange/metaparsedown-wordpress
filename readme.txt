=== MetaParsedown ===
Contributors: Pagerange
Tags: markdown, markdown-extra, parsedown, parsedown-extra, metaparsedown, yaml, github, gitlab, bitbucket
Requires at least: 5.0
Tested up to: 5.2.1
Requires PHP: 7.0
Stable tag: 1.0
Donate Link: http://pagerange.com/projects/wordpress/metaparsedown
License: MIT
License URI: https://github.com/pagerange/metaparsedown-wordpress/blob/master/LICENSE.txt

Import markdown and markdown-extra documents to Wordpress posts and pages, output as HTML, parse and save YAML front matter to post_meta, tags, and (optionally) the posts tables.

== Description ==
Import markdown and markdown-extra documents to Wordpress posts and pages, output as HTML, parse and save YAML front matter to post_meta, tags, and (optionally) the posts tables.

* Built on MetaParsedown, Parsedown and Symfony YAML components
* Supports docments in both Markdown and Markdown-Extra formats
* Easy to use
* Lighweight
* Optionally style markdown code snippets for syntax highlighting
* Maintain cannonical markdown documents through your favourite git repository
* Works with both Gutenberg and classic wordpress editors

## How to use
Simply add the `metaparsedown` shortcode to your post, identifying the markdown document in the `url` attribute:

`[metaparsedown url='https://gitlab.com/pagerange/docs/raw/master/markdown/test_markdown.md' /]`

Optionally, parse and save markdown YAML front matter to the post_meta table by adding the `meta` attribute.

`[metaparsedown url='https://gitlab.com/pagerange/docs/raw/master/markdown/test_markdown.md' meta="true" /]`

Optionally, overwrite the post's 'post_title' and 'post_excerpt' fields with YAML values by adding the `overwrite` attribute.

`[metaparsedown url='https://gitlab.com/pagerange/docs/raw/master/markdown/test_markdown.md' meta="true" overwrite="true" /]`


== Frequently Asked Questions ==

= How can I add syntax hilighting to my markdown documents? =

You can do one of two things:

1. Add and enqueue a syntax highlighting Javascript package.

or...

2. Use MetaParsedown's built-in syntax highlighting using the microlight js highlight package.  Simply add the following code to your theme's `functions.php` file:

`
if(function_exists('metaparsedown_plugins_url')) {

	function metaparsedown_load_scripts()
	{
		wp_enqueue_style('metaparsedown', 
			metaparsedown_plugins_url('/css/style.css'));
		wp_enqueue_script('microlight', 
			metaparsedown_plugins_url('/js/microlight.js'), [], null, true);
		wp_enqueue_script('metaparsedown', 
			metaparsedown_plugins_url('/js/script.js'), array('microlight'), null, true);
	}
	add_action('wp_enqueue_scripts', 'metaparsedown_load_scripts', 10);

}

`

## Support

Add issues at <https://github.com/pagerange/metaparsedown-wordpress/issues>.


== Installation ==

Install directly from WordPress plugin repository.

Or, download the ZIP file from https://github.com/pagerange/metaparsedown-wordpress/archive/master.zip 


== Donate ==

Donate via Paypal at <http://pagerange.com/projects/wordpress/metaparsedown>


== Changelog ==
= v1.0.0 =
* Version 1.0 released