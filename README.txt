=== Theme Functionality ===
Contributors: Stefan Reichert
Donate link: http://stefan-reichert.com/
Tags: theme functionality, automatic favicons, additional mime-types, clean header,
Requires at least: 4.4
Tested up to: 4.8.7
Stable tag: 2.8.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Functionality plugin with important settings, enhancements and fixes for WordPress themes.

== Description ==

= Functions =
1. Allow upload of svg and font files
2. Embed Video iframes responsively
3. Remove admin bar
4. Remove admin navigation items
5. Update notification for Administrators
6. Quick Performance Report
7. Add custom CSS for Administrators
8. Add custom JS for Administrators
9. Remove inline css style from gallery
10. Clean the output of image css-classes in editor
11. Remove width and height in editor
12. (Deactivated) Redirect Attachment Pages (mostly images) to their parent page
13. Remove WordPress generated content from the head
14. Add various favicons and logos for iOS, Android, Windows
15. Removes invalid rel attribute values in the categorylist
16. Add page slug to body class with prefix 'page-slug-'
17. Add page slug to corresponding navigation classes with prefix 'menu-item-'


= 1. Allow upload of svg and font files =
Add mime types for 'svg', 'ttf', 'otf', 'woff', 'woff2', 'eot' to media uploader


= 2. Embed Video iframes responsively =
Add oEmbedded class for responsive iFrame Videos from Youtube/Vimeo and Twitter
Twitter gets additional class 'embed-container__twitter' for smaller padding-bottom

You need to add custom css for .embed-container from http://embedresponsively.com/
.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; }
.embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
.embed-container__twitter { padding-bottom: 30%; }

= 3. Remove admin bar =
Removes the Admin bar on front end for users without role 'edit_posts'


= 4. Remove admin navigation items =
Remove 'Comment' navigation link for users without role 'moderate_comments'
Remove 'Tools' navigation link for users without role 'manage_options'


= 5. Update notification for Administrators =
Show update notification only to admins to prevent user confusion


= 6. Quick Performance Report =
Display a quick performance report for admins as HTML comment at the bottom of the page


= 7. Add custom CSS for Administrators =
Checks if file exists in (child) 'theme-folder/css/admin.css' and enqueues file automatically


= 8. Add custom JS for Administrators =
Checks if file exists in 'theme-folder/js/admin.min.js' and enqueues file automatically


= 9. Remove inline css style from gallery =
You need to style your gallery through your own css files


= 10. Clean the output of image css-classes in editor =
Better align classes: alignright, alignleft, aligncenter


= 11. Remove width and height in editor =
Better responsive images


= 12. Redirect Attachment Pages (mostly images) to their parent page  =
Only if parent is available


= 13. Remove WordPress generated content from the <head> or footer =
* Post and comment feeds
* Category feeds
* EditURI link
* Windows live writer
* Index link
* Previous link
* Start link
* Links for adjacent posts
* Shortlink
* Canonical links
* Clean up comment styles in the head
* Remove WordPress version
* Remove comment cookie
* Remove WordPress version from RSS feeds
* Remove WordPress version from CSS + JS
* Remove injected css for recent comments widget
* Remove inline CSS and JS from WordPress emoji support
* Remove wp-embedded.min.js from footer
* Remove WPML information
* Remove WPML CSS + JS

-> Options page planned in v3.0.0 to decide which content is removed


= 14. Add various favicons and logos =
Checks if WordPress-Core function 'has_site_icon()' is supported
Checks if the following file exist in the (child) theme-folder
* apple-touch-icon.png (180x180)
* apple-touch-icon-180x180-precomposed.png (180x180)
* apple-touch-icon-152x152-precomposed.png (152x152)
* apple-touch-icon-120x120-precomposed.png (120x120)
* apple-touch-icon-76x76-precomposed.png (76x76)
* apple-touch-icon-precomposed.png (57x57)
* favicon.ico (16x16 + 32x32 + 48x48)
* browserconfig.xml for MS tile-icons (needs the file(s) in the (child) theme-folder with relative path from root: /wp-content/themes/...)
* manifest.json for android-chrome icons (needs the file(s) in the (child) theme-folder with relative path from root: /wp-content/themes/...)

Also generates tags for application names on mobile
* <meta name="apple-mobile-web-app-title" content="'.get_bloginfo('name').'">
* <meta name="application-name" content="'.get_bloginfo('name').'">';

Generate icons through http://realfavicongenerator.net/
You don't need the precomposed files, all is resized in iOS and Android

Redirect the root requests for /favion.ico and /favicon.png to your child theme
Swap CHILDTHEME with your child name and place BEFORE the Wordpress rewrites
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/wp-content/themes/CHILDTHEME/favicon\.ico$ [NC]
    RewriteCond %{HTTP_HOST} (.+)
    RewriteRule ^(.*)favicon\.(ico|png)$ http://%1/wp-content/themes/CHILDTHEME/favicon.ico [R=301,L,NC]
</IfModule>


= 15. Removes invalid rel attribute values in the category list =


= 16. Add page slug to body class =
Add the current page slug to the body class for better css target with prefix 'page-slug-'


= 17. Add page slug navigation
Add page slug to corresponding navigation classes with prefix 'menu-item-'



= Website =
https://github.com/fanfarian/sr-theme-functionality


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload 'sr-theme-functionality' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Let the magic happen...

== Frequently Asked Questions ==

= Q. I have a question =
A. Please create an issue on GitHub: https://github.com/fanfarian/sr-theme-functionality/issues


== Screenshots ==
1. No screenshots available

== Changelog ==

= 2.8.14 =
Small bugfixes


= 2.8.13 =
Renamed readme.txt
Updates the update script to v4.4
* YahnisElsts (https://github.com/YahnisElsts/plugin-update-checker)


= 2.8.12 =
Small bugfixes

= 2.8.11 =
Weird invisible character bugfix

= 2.8.10 =
New css-class for Twitter embedds 'embed-container__twitter' for smaller padding-bottom

= 2.8.9 =
Removed: Freemius Plugin Analytics

= 2.8.7 =
Update for loading favicons & touch icons -> less is more: http://realfavicongenerator.net/blog/new-favicon-package-less-is-more/
Use http://realfavicongenerator.net to update your files and look for instructiuons in #14

= 2.8.6 =
Add prefix 'page-slug-' to page slug for body class (added in 2.6.0)
Added a plugin icon
Test: Freemius Plugin Analytics

= 2.8.5 =
Use correct github url (do not just copy-paste without thinking)

= 2.8.4 =
Test the new update script v4

= 2.8.3 =
Updates the update script to v4
* YahnisElsts (https://github.com/YahnisElsts/plugin-update-checker)
Updates Required/Tested versions: 4.4 - 4.7

= 2.8.2 =
Compatibility with WordPress 4.6

= 2.8.1 =
New Feature: Add page slug to corresponding navigation classes with prefix 'menu-item'

= 2.8.0 =
Greatly improved performance with better existing file check for custom admin JS+CSS and favicons

= 2.7.5 =
Changed Favicon stuff
* Change filename for 192x192 size from 'touch-icon-192x192.png' to 'apple-touch-icon.png'
* New PNG Favicons 16x16, 32x32, 96x96

= 2.7.4 =
Update 'plugin-update-checker'

= 2.7.3 =
Remove wp-embedded.min.js from footer

= 2.7.2 =
Small bugfixes with embedded images

= 2.7.1 =
Small bugfix with oEmbedd feature

= 2.7.0 =
Check if WordPress-Core function 'has_site_icon()' is supported and use this function.
Otherwise insert favicons as described in 14.

= 2.6.0 =
New Features
* Removes invalid rel attribute values in the categorylist
* Add page slug to body class

= 2.5.0 =
Alternative, flexible and better update script for the plugin
* YahnisElsts (https://github.com/YahnisElsts/plugin-update-checker)

= 2.4.0 =
Automatically update the plugin from GitHub with new updater script based on
* Smashing Magazin (http://www.smashingmagazine.com/2015/08/deploy-wordpress-plugins-with-github-using-transients/)

= 2.3.0 =
* Added script for custom admin javascript in theme-folder/js/admin.min.js inclusion

= 2.2.1 =
* Better Readme

= 2.2.0 =
* New name: sr-theme-functionality
* Removed update script 'GitHub Updater' from 'radishconcepts', better coming in later version

= 2.1.2 =
* GitHub Updater Test

= 2.1 =
* Updates via GitHub Updater from 'radishconcepts'

= 2.0 =
* Custom Posts/Taxonomy in separates Plugin abgespalten

= 1.0 =
* First Version
* Hosted on GitHub
* Plugin Boilerplate template

== Upgrade Notice ==
