<?php
/*
Plugin Name: Scroll popup html content ads
Plugin URI: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
Description:  This wordpress plugin allows you to build and show a scrolling pop up using html divs. You can locate the scrolling pop up in a corner of a web page and choose the scrolling direction (i.e., left-to-right or top-down). and we have separate content management page to manage the popup content. using this plugin we can show our ads and special information to the user. for more help visit www.gopiplus.com
Author: Gopi.R
Version: 6.1
Author URI: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("wp_scroll_popup_html_content_ads_table", $wpdb->prefix . "scroll_popup_html_content_ads");
define('sphca_FAV', 'http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/');

if ( ! defined( 'WP_sphca_BASENAME' ) )
	define( 'WP_sphca_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_sphca_PLUGIN_NAME' ) )
	define( 'WP_sphca_PLUGIN_NAME', trim( dirname( WP_sphca_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_sphca_PLUGIN_URL' ) )
	define( 'WP_sphca_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_sphca_PLUGIN_NAME );
	
if ( ! defined( 'WP_sphca_ADMIN_URL' ) )
	define( 'WP_sphca_ADMIN_URL', get_option('siteurl') . '/wp-admin/options-general.php?page=scroll-popup-html-content-ads' );

function sphca($scode=0)
{
	$display = "";
	if(is_home() && get_option('sphca_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('sphca_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('sphca_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('sphca_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('sphca_On_Search') == 'YES') {	$display = "show";	}
	
	if(!is_numeric($scode)) { $scode = 0 ;}
	if($display == "show")
	{
		scroll_popup_html_content_ads_show($scode);
	}
}

function scroll_popup_html_content_ads_show($scode=0)
{
	global $wpdb;
	
	$sSql = "select * from ".wp_scroll_popup_html_content_ads_table." where 1=1";
	
	if(!is_numeric($scode)) { $scode = 0 ;}
	
	if($scode <> 0)
	{
	 	$sSql = $sSql . " and sphca_id=$scode";
	}
	else
	{
		$sSql = $sSql . " Order by rand()";
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$data = $data[0];
		$sphca_text = $data->sphca_text;
		$sphca_title = $data->sphca_title;
		$sphca_width = $data->sphca_width;
		$sphca_height = $data->sphca_height;
		$sphca_pos1 = $data->sphca_pos1;
		$sphca_pos2 = $data->sphca_pos2;
		$sphca_pos3 = $data->sphca_pos3;
	}
	
	$sphca_option = get_option('sphca_option');

	if($sphca_option == "showalways")
	{
		$sphca_option = "false";
	}
	elseif($sphca_option == "oncepersession")
	{
		$sphca_option = "true";
	}
	else
	{
		$sphca_option = "false";
	}

	$sphca = $sphca . '<script type="text/javascript"> ';
    $sphca = $sphca . "var html_code = '".$sphca_text."';";
    $sphca = $sphca . "sphca_loadpopup(".$sphca_width.", ".$sphca_height.", '".$sphca_title."', html_code);";
    $sphca = $sphca . '</script> ';
	$sphca = $sphca . '<script type="text/javascript">ShowTheBox('.$sphca_option.', '.$sphca_pos1.', '.$sphca_pos2.', '.$sphca_pos3.');</script> ';
	echo $sphca;
	
}

function scroll_popup_html_content_ads_activation()
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". wp_scroll_popup_html_content_ads_table . "'") != wp_scroll_popup_html_content_ads_table) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". wp_scroll_popup_html_content_ads_table . "` (
			  `sphca_id` int(11) NOT NULL auto_increment,
			  `sphca_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `sphca_title` VARCHAR(1000) NOT NULL,
			  `sphca_width` int(4) NOT NULL,
			  `sphca_height` int(4) NOT NULL,
			  `sphca_pos1` VARCHAR(15) NOT NULL,
			  `sphca_pos2` VARCHAR(15) NOT NULL,
			  `sphca_pos3` VARCHAR(15) NOT NULL,
			  `sphca_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`sphca_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			");
		
		$c1 = '<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="'.WP_sphca_PLUGIN_URL.'/gopiplus.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
		$t1 = 'Popup Title';
		$c2 = '<a href="http://www.gopiplus.com/work/" target="_blank"><img src="'.WP_sphca_PLUGIN_URL.'/gopiplus.jpg" border="0"  /></a>';
		
		$iIns = "INSERT INTO `". wp_scroll_popup_html_content_ads_table . "` (`sphca_text`, `sphca_title`, `sphca_width`, `sphca_height`, `sphca_pos1`, `sphca_pos2`, `sphca_pos3`)"; 
		$sSql = $iIns . " VALUES ('$c1', '$t1', 250, 190, 'leftSide', 'topCorner', 'topDown');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$c2', '$t1', 330, 270, 'rightSide', 'bottomCorner', 'bottopUp');";
		$wpdb->query($sSql);
	}
	add_option('sphca_option', "showalways");
	add_option('sphca_On_Homepage', "YES");
	add_option('sphca_On_Posts', "YES");
	add_option('sphca_On_Pages', "YES");
	add_option('sphca_On_Archives', "NO");
	add_option('sphca_On_Search', "NO");
}

function scroll_popup_html_content_ads_deactivate()
{
	// No action required.
}

function scroll_popup_html_content_ads_add_to_menu()
{
	if (is_admin())
	{
		add_options_page( __('Scrolling Popup', 'scroll-popup'), __('Scrolling Popup', 'scroll-popup'),
								'manage_options', 'scroll-popup-html-content-ads','scroll_popup_html_content_ads_admin_options');  
	}
}

function scroll_popup_html_content_ads_admin_options()
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-edit.php');
			break;
		case 'add':
			include('pages/content-add.php');
			break;
		case 'set':
			include('pages/content-setting.php');
			break;
		default:
			include('pages/content-show.php');
			break;
	}
}

function scroll_popup_html_content_shortcode( $atts ) 
{
	global $wpdb;
	$scode = "";
	
	//[scroll-popup-html id="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$id = $atts['id'];
		
	$sSql = "select * from ".wp_scroll_popup_html_content_ads_table." where 1=1";
	
	if(!is_numeric($scode)) { $scode = 0 ;}
	
	if($id <> 0)
	{
	 	$sSql = $sSql . " and sphca_id=$id";
	}
	else
	{
		$sSql = $sSql . " Order by rand()";
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$data = $data[0];
		$sphca_text = $data->sphca_text;
		$sphca_title = $data->sphca_title;
		$sphca_width = $data->sphca_width;
		$sphca_height = $data->sphca_height;
		$sphca_pos1 = $data->sphca_pos1;
		$sphca_pos2 = $data->sphca_pos2;
		$sphca_pos3 = $data->sphca_pos3;
		
		$sphca_option = get_option('sphca_option');

		if($sphca_option == "showalways")
		{
			$sphca_option = "false";
		}
		elseif($sphca_option == "oncepersession")
		{
			$sphca_option = "true";
		}
		else
		{
			$sphca_option = "false";
		}
	
		$sphca = "";
		$sphca = $sphca . '<script type="text/javascript"> ';
		$sphca = $sphca . "var html_code = '".$sphca_text."';";
		$sphca = $sphca . "sphca_loadpopup(".$sphca_width.", ".$sphca_height.", '".$sphca_title."', html_code);";
		$sphca = $sphca . '</script> ';
		$sphca = $sphca . '<script type="text/javascript">ShowTheBox('.$sphca_option.', '.$sphca_pos1.', '.$sphca_pos2.', '.$sphca_pos3.');</script> ';
	}
	else
	{
		$sphca = "No record found.";
	}

	return $sphca;
}

function scroll_popup_html_content_ads_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'scroll-popup-html-content-ads-js', WP_sphca_PLUGIN_URL.'/scroll-popup-html-content-ads.js');
		wp_enqueue_style( 'scroll-popup-html-content-ads-css', WP_sphca_PLUGIN_URL.'/scroll-popup-html-content-ads.css');
	}	
}

function scroll_popup_html_content_textdomain() 
{
	  load_plugin_textdomain( 'scroll-popup', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'scroll_popup_html_content_textdomain');
add_shortcode( 'scroll-popup-html', 'scroll_popup_html_content_shortcode' );
add_action('wp_enqueue_scripts', 'scroll_popup_html_content_ads_add_javascript_files');
register_activation_hook(__FILE__, 'scroll_popup_html_content_ads_activation');
add_action('admin_menu', 'scroll_popup_html_content_ads_add_to_menu');
register_deactivation_hook( __FILE__, 'scroll_popup_html_content_ads_deactivate');
?>