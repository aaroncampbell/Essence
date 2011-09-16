=== Essence ===
Contributors: aaroncampbell
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S89UBLE9C9NPC
Requires at least: 3.1
Tested up to: 3.3.0
Stable tag: 0.0.5

A high-quality, well coded, fast loading theme designed as a base for new themes.

== Description ==

Essence is designed to be modular and easy to extend.  It does not do everything,
but what it does it does well and what it does not do can be added with a plugin.
The plan is to have a whole suite of essence plugins that can be used to add
functionality without making the theme too large and cumbersome.  It should just
do what you want and nothing more.

== Changelog ==

= 0.0.5 =
* info, alert, and error boxes recolored to match theme
* Add some missing text domains
* Add settings for Header Image width/height so you can upload any size header image.
* Styles for new features in Twitter Widget Pro
* Fix footer floating next to widgets
* Fix link to essencetheme.com
* Don't require child themes to @import the Essence stylesheet
* Automatically enqueue a child theme's style.css
* Don't use essence_title()
* Fix navigation hover gradients

= 0.0.4 =
* Replace TEMPLATEPATH with get_template_directory() - See http://core.trac.wordpress.org/ticket/18298
* Style the reply to comment link
* Style the comment form

= 0.0.3 =
* Added page navigation links to Tag templates

= 0.0.2 =
* Fixed error in category.php
* Added page navigation links to Author, Category, Archive, and Search templates
* Fixed issue with floated elements at end of multi-page posts
* Fixed issue with top comment navigation links
* Fixed blockquote padding
* Added custom header support
* Added custom background support
* Added ability to widgetize right side of header
* Added the ability to use a logo in place of the site name in header
* Fixed issue with no background color behind main content on pages that didn't use index.php
* Added sanitization of options
* Use edit_theme_options instead of manage_options for theme settings page
* Got rid of unused contants
* Made the $_REQUEST['debug'] functionality only work with WP_DEBUG

= 0.0.1 =
* Original Version
