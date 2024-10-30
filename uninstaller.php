<?php

/******************************************************************
/* UnInstall the Webplayer Tables
******************************************************************/
function webplayer_db_uninstall() {
	global $wpdb;
	global $webplayer_version;

	$table_name = $wpdb->prefix . "webplayer";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
	$table_name = $wpdb->prefix . "webplayer_license";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
	$table_name = $wpdb->prefix . "webplayer_videos";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
	$table_name = $wpdb->prefix . "webplayer_playlist";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
	delete_option( "webplayer_version", $webplayer_version );
}
    
?>