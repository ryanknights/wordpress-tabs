<?php

/**
* Plugin Name: Tabs - TMS Media
* Plugin URI: http://tms-media.co.uk
* Description: Adds shortcode for displaying Tabbed Areas
* Version: 1.0
* Author: Ryan Knights - TMS Media
* Author URI: http://ryanknights.co.uk
*/
	
	if (!defined( 'ABSPATH'))
	{
		exit();
	}
	
	require_once('inc/tms-tabs.class.php');

	new TmsTabs();
?>