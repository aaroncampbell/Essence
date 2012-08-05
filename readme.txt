=== Essence ===
Contributors: aaroncampbell
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S89UBLE9C9NPC
Requires at least: 3.4
Tested up to: 3.4.1
Stable tag: 0.2.1

A high-quality, well coded, fast loading theme designed as a base for new themes.

== Description ==

Essence is designed to be modular and easy to extend.  It does not do everything,
but what it does it does well and what it does not do can be added with a plugin.
The plan is to have a whole suite of essence plugins that can be used to add
functionality without making the theme too large and cumbersome.  It should just
do what you want and nothing more.

== Changelog ==

= 0.2.1 =
* Change "Essence Theme Framework for WordPress" to "Essence Theme Framework" because the former is considered spam

= 0.2.0 =
* Add author-box.php to make it easier to specify your own author box
* Fix comment reply JS for inline replies
* Upgrade to Foundation 3.0.7
* Drop some IE7 fixes

= 0.1.0 =
* Move from Blueprint to Foundation which is responsive
* Further move toward HTML5
* Remove all the pre-packaged headers
* Remove a lot of constants

= 0.0.7 =
* Add twitter sprite for web intents
* Add support for new Flex headers in WordPress 3.4

= 0.0.6 =
* Add support for speech input to search and settings
* Added essence_show_template_file()

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
