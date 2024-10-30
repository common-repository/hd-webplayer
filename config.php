<?php

/******************************************************************
/*Bootstrap file for getting the ABSPATH constant to wp-load.php
/*This is requried when a plugin requires access not via the admin screen.
******************************************************************/
$path  = ''; 
if ( !defined('WP_LOAD_PATH') ) {
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
    if (file_exists( $classic_root . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $classic_root);
	} else if (file_exists( $path . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $path);
	} else {
    	exit("Could not find wp-load.php");
	}
}

require_once( WP_LOAD_PATH . 'wp-load.php');
global $wpdb;	
$config  = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."webplayer WHERE id=".$_GET['id']);
$license = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."webplayer_license WHERE id=1");
$siteurl = get_option('siteurl');
$br      = "\n";	

/******************************************************************
/*Cast Numeric values as Boolean
******************************************************************/
function castAsBoolean($val){
	if($val == 1) {
		return 'true';
	} else {
		return 'false';
	}
}

/******************************************************************
/*Write Data as XML
******************************************************************/
ob_clean();
header("content-type:text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>'.$br;
echo '<config>'.$br;
echo '<license>'.$license->licensekey.'</license>'.$br;
echo '<logo>'.$license->logo.'</logo>'.$br;
echo '<logoPosition>'.$license->logoposition.'</logoPosition>'.$br;
echo '<logoAlpha>'.$license->logoalpha.'</logoAlpha>'.$br;
echo '<logoTarget>'.$license->logotarget.'</logoTarget>'.$br;
echo '<skinMode>'.$config->skinmode.'</skinMode>'.$br;
echo '<autoStart>'.castAsBoolean($config->autoplay).'</autoStart>'.$br;
echo '<stretch>'.$config->stretchtype.'</stretch>'.$br;
echo '<buffer>'.$config->buffertime.'</buffer>'.$br;
echo '<volumeLevel>'.$config->volumelevel.'</volumeLevel>'.$br;

if($config->videoid){
	echo '<playListXml>'.$siteurl.'/wp-content/plugins/' . basename(dirname(__FILE__)) . '/playlist.php?videoid='.$config->videoid.'</playListXml>'.$br;
} else {
	echo '<playListXml>'.$siteurl.'/wp-content/plugins/' . basename(dirname(__FILE__)) . '/playlist.php?playlistid='.$config->playlistid.'</playListXml>'.$br;
}

echo '<playListAutoStart>'.castAsBoolean($config->playlistautoplay).'</playListAutoStart>'.$br;
echo '<playListOpen>'.castAsBoolean($config->playlistopen).'</playListOpen>'.$br;
echo '<playListRandom>'.castAsBoolean($config->playlistrandom).'</playListRandom>'.$br;
echo '<emailPhp>'.$siteurl.'/wp-content/plugins/' . basename(dirname(__FILE__)) . '/email.php</emailPhp>'.$br;
echo '<controlBar>'.castAsBoolean($config->controlbar).'</controlBar>'.$br;
echo '<playPauseDock>'.castAsBoolean($config->playpause).'</playPauseDock>'.$br;
echo '<progressBar>'.castAsBoolean($config->progressbar).'</progressBar>'.$br;
echo '<timerDock>'.castAsBoolean($config->timer).'</timerDock>'.$br;
echo '<shareDock>'.castAsBoolean($config->share).'</shareDock>'.$br;
echo '<volumeDock>'.castAsBoolean($config->volume).'</volumeDock>'.$br;
echo '<fullScreenDock>'.castAsBoolean($config->fullscreen).'</fullScreenDock>'.$br;
echo '<playDock>'.castAsBoolean($config->playdock).'</playDock>'.$br;
echo '<playList>'.castAsBoolean($config->playlist).'</playList>'.$br;
echo '</config>'.$br;
exit();

?>