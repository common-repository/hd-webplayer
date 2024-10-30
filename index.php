<?php
/******************************************************************
Plugin Name:HD Webplayer
Plugin URI:http://hdwebplayer.com?q=wordpress-installation
Description:Video Player extension for your Wordpress websites.
Version:1.1
Author:HD Webplayer
Author URI:http://hdwebplayer.com
License:GPL2

Copyright 2011 HD Webplayer  (email : admin@hdwebplayer.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
******************************************************************/

require_once('installer.php');
require_once('uninstaller.php');
require_once('shortcode.php');
require_once('tabs.php');

global $webplayer_version;
global $installed_webplayer_version;

$webplayer_version = "1.1";
$installed_webplayer_version = get_site_option('webplayer_version');

/******************************************************************
/* Add Custom CSS file
******************************************************************/
function webplayer_plugin_css() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/webplayer.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

/******************************************************************
/* Creating Menus
******************************************************************/
function webplayer_plugin_menu() {
	add_menu_page("HD Webplayer Title", "HD Webplayer", "administrator", "webplayer", "webplayer_plugin_pages");
	add_submenu_page("webplayer", "HD Webplayer Videos", "Videos", "administrator", "videos", "webplayer_plugin_pages");
	add_submenu_page("webplayer", "HD Webplayer Playlist", "Playlist", "administrator", "playlist", "webplayer_plugin_pages");
  	add_submenu_page("webplayer", "HD Webplayer License", "License", "administrator", "license", "webplayer_plugin_pages");
	add_submenu_page("webplayer", "HD Webplayer Documentation", "Documentation", "administrator", "documentation", "webplayer_plugin_pages");
}

/******************************************************************
/* Assigning Menu Pages
******************************************************************/
function webplayer_plugin_pages() {
	webplayer_admin_tabs($_GET["page"]);
	require_once (dirname(__FILE__) . "/" . $_GET["page"] . "/__default.php");
}

/******************************************************************
/* Implementing Hooks
******************************************************************/
if (is_admin()) {
	add_action('admin_head', 'webplayer_plugin_css');
  	add_action("admin_menu", "webplayer_plugin_menu");
	register_activation_hook(__FILE__,'webplayer_db_install');
	register_activation_hook(__FILE__,'webplayer_db_install_data');
	add_action('plugins_loaded', 'webplayer_update_db_check');
	register_uninstall_hook(__FILE__, 'webplayer_db_uninstall');
}

?>