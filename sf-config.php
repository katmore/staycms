<?php
/**
 * sf-config.php
 * This is the all-important configuration file for your CMS (staycms).
 * 
 * This is the only file you need to edit to get your site up and running, 
 * you shouldn't have to edit more than a few lines (sometimes none at all!).
 * 
 * Some site customizations, such as site name, copyright splash, theme, 
 * and content namespace are also configured here.
 * 
 * Further down, filename and URL path's can be configured, which may need to be changed in some situations.
 * 
 */


/*
 *
 * Set the name of the site
 * This can be used by themes (or even in content)
 * 
 */
$site_name = "<!--from sf-config setting 'site_name'-->A StayCMS Website<!--end 'site_name'-->";


/*
 *
 * Set site's copyright message
 * This will be used by themes
 * And can be overridden on a per contentid basis (copyright-contentid.inc.php)
 *
 */
$site_copyright = "<!--from sf-config setting 'site_copyright'-->Site Content &copy;" . date("Y") . " All Rights Reserved.<!--end 'site_copyright'-->";



/*
 * 
 * Set the name of the theme
 * this typically correlates to a directory in the theme folder
 * 
 */
$theme_name = "diviate";


/*
 * 
 * Set the content namespace
 * this typically correlates to a directory in the content folder
 * 
 */
$content_name = "sample";


/*
 *
 * The base URL for the home directory (no trailing slash)
 * path can be relative (as in "./") or full (as in "http://example.com")
 * 
 *
 */
$home_baseurl = "./";



/*
 *
 * The format for generating URLs to content items
 * use %contentid% to refer to a particular content item id
 * This is used in themes and in content itself, for example like this $page->showContentLink("about")
 * 
 * A failsafe format is as follows:
 * $content_linkformat = $home_baseurl . "?p=%contentid%";
 * 
 * But this failsafe might not always be most desired (ie: for legibility, for search engines)
 * something like this can be used
 * $content_linkformat = $home_baseurl . "%contentid%.html";
 * if there are appropriate mod_rewrite directives in the .htaccess file at the root of the installation
 * example .htaccess:
 # RewriteEngine On
 #
 # RewriteCond %{REQUEST_FILENAME} -f [NC,OR]
 # RewriteCond %{REQUEST_FILENAME} -d [NC]
 # RewriteRule .* - [L]
 # 
 # RewriteRule ^(.*)\.html /sf.php?p=$1 [L]
 * 
 */
$content_linkformat = $home_baseurl . "?p=%contentid%";


/*
 *
 * Do we show staycms errors?
 * It is dumb to have this set to true in a production environment.
 *
 */
$show_sferrors = false;


/*
 *
 * Set the application path (where this file, and sf.php are located) (full or relative path as appropriate)
 * And the include path (which includes the sf.inc.php leading to the the sf class definitions)
 * 
 * it's unlikely this will need to be changed
 *
 */
//$app_path = __DIR__ . "/"; //would be ./ if from same directory as this config, use trailing slash on path otherwise
$app_path = "./";
/*
 * 
 * Set JUST the name of the include folder, this is not a path, but just the name of the folder
 *  this makes it easy to form the path used by php to access files
 *  typically, the default 'sf-include' is going to be used
 * 
 */
$include_folder = "sf-include";


/*
 * 
 * Set JUST the name of the theme folder, this is not a path, but just the name of the folder
 *  this makes it easy to form both the base URL and the path used by php to access files
 *  typically, the default 'sf-theme' is going to be used, but it really is arbitrary 
 *  (as long as it matches the system's directory structure).
 * 
 */
$theme_folder = "sf-theme";


/*
 * 
 * Set JUST the name of the content folder, this is not a path, but just the name of the folder
 *  this makes it easy to form both the base URL and the path used by php to access files
 *  typically, the default 'sf-content' is going to be used, but it really is arbitrary 
 *  (as long as it matches the system's directory structure).
 * 
 */
$content_folder = "sf-content";


/*
 * 
 * name of primary extention to load
 * 
 */
$primary_extention = "page";


/*
 * 
 * addon extentions to load
 * $addon_toload is an array of strings containing what addon (expected to be in include path)
 * could be in separate file, or could just be here directly
 * 
 */
require("sf-addons.php");


/*
 * 
 * Set the include path, where the core, extention, modules, widgets, etc kind of files are at 
 * 
 */
$include_path = $app_path . $include_folder; //only change if the "includes" (base, modules) is different


/*
 *
 * Set the path to the themes directory
 * The path to the actual chosen theme
 * it doesn't need to be in the app directory, but it sure makes sense
 * 
 * it's unlikely this will need to be changed, except in custom situations
 *
 */
$themes_dir = $app_path . $theme_folder; //only change this if you setup a folder other than the default 'theme' to put themes into
$theme_path = "$themes_dir/$theme_name";


/*
 *
 * Set the path to the content directory
 * And path to actual chosen content namespace
 * 
 * it's unlikely this will need to be changed, except in custom situations
 *
 */
$content_dir = $app_path . $content_folder; //only change this if you setup a folder other than the default 'content' to put content namespaces into
$content_path = "$content_dir/$content_name";


/*
 *
 * The base URL for the chosen theme this URL base is handy for themes that 
 * refer to their own images or stylesheets the theme's php files don't *need* 
 * to be available publically so this could be any publically accessible folder 
 * with files, stylesheets, etc that the theme is written to expect. It can be 
 * relative (as in "theme/barebones") or full (as in "http://example.com/theme/barebones").
 * 
 * It is unlikely this will need to be changed, but may in custom situations.
 *
 */
$theme_baseurl = $home_baseurl . "$theme_folder/$theme_name";















