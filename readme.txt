=== MetaParsedown ===
Contributors: Pagerange
Tags: markdown, parsedown, metaparsedown, yaml, github, gitlab, bitbucket
Requires at least: 5.0
Tested up to: 5.2.1
Requires PHP: 5.3
Stable tag: 1.0
License: MIT
License URI: https://github.com/pagerange/metaparsedown-wordpress/blob/master/LICENSE.txt

Import markdown documents to Wordpress posts and pages, output as HTML, parse and save YAML frontmatter to post_meta.

== Description ==
Import markdown documents to Wordpress posts and pages, output as HTML, parse and save YAML frontmatter to post_meta.

* Built on MetaParsedown, Parsedown, and Symfony YAML components.
* Easy to use
* Lighweight
* Optionally style markdown code snippets for syntax highlighting
* Maintain markdown through your favourite git repository
* Works with both Gutenberg and classic wordpress editors

## How to use
Simply add the `metaparsedown` shortcode to your post:

`[metaparsedown file="http://example.com/markdown_file.md" /]

Otionally, parse and save markdown YAML front matter to the post_meta table.

`[metaparsedown file="http://example.com/markdown_file.md" meta="true" /]`


== Frequently Asked Questions ==

= How can I add syntax hilighting to my markdown documents? =
You can do one of two things:

1. Add and enqueue a syntax highlighting Javascript package.

or...

2. Use MetaParsedown's built-in syntax highlighting using the microlight js highlight package.  Simply add the the following code to your theme's `functions.php` file:

```php
function metaparsedown_scripts()
{
	wp_enqueue_style('metaparsedown', plugins_url() . '/metaparsedown/assets/css/style.css');
	wp_enqueue_script('microlight', plugins_url() .'/metaparsedown/assets/js/microlight.js', [], null, true);
	wp_enqueue_script('metaparsedown', plugins_url() .'/metaparsedown/assets/js/script.js', array('microlight'), true);
}
add_action('wp_enqueue_scripts', 'metaparsedown_scripts', 10);

```

## Support

Add issues at <https://github.com/pagerange/metaparsedown-wordpress/issues>.

== Installation ==

Install directly from WordPress plugin repository.

Or, download the ZIP file from https://github.com/pagerange/metaparsedown-wordpress/archive/master.zip 

== Changelog ==
= v1.0.0 =
* Version 1.0 released
