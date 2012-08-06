<?php

/*
Plugin Name: Scroll popup html content ads
Plugin URI: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
Description:  This wordpress plugin allows you to build and show a scrolling pop up using html divs. You can locate the scrolling pop up in a corner of a web page and choose the scrolling direction (i.e., left-to-right or top-down). and we have separate content management page to manage the popup content. using this plugin we can show our ads and special information to the user. for more help visit www.gopiplus.com
Author: Gopi.R
Version: 4.0
Author URI: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("wp_scroll_popup_html_content_ads_table", $wpdb->prefix . "scroll_popup_html_content_ads");

function sphca($scode=0)
{
	@$display = "";
	if(is_home() && get_option('sphca_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('sphca_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('sphca_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('sphca_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('sphca_On_Search') == 'YES') {	$display = "show";	}
	
	if(!is_numeric(@$scode)) { @$scode = 0 ;}
	if($display == "show")
	{
		scroll_popup_html_content_ads_show($scode);
	}
}

function scroll_popup_html_content_ads_show($scode=0)
{
	global $wpdb;
	
	$sSql = "select * from ".wp_scroll_popup_html_content_ads_table." where 1=1";
	
	if(!is_numeric(@$scode)) { @$scode = 0 ;}
	
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
	include_once("scroll-popup-activation.php");
}

function scroll_popup_html_content_ads_deactivate()
{
	
}

function scroll_popup_html_content_ads_add_to_menu()
{
	if (is_admin())
	{
		add_options_page('Scrolling Popup','Scrolling Popup','manage_options',__FILE__,'scroll_popup_html_content_ads_admin_options');  
		add_options_page('Scrolling Popup', '', 'manage_options', "scroll-popup-html-content-ads/content-management.php",'' );
	}
}

function scroll_popup_html_content_ads_admin_options()
{
	
	echo '<div class="wrap">';
	echo '<h2>Scrolling Popup</h2>';
    
	$sphca_On_Homepage = get_option('sphca_On_Homepage');
	$sphca_On_Posts = get_option('sphca_On_Posts');
	$sphca_On_Pages = get_option('sphca_On_Pages');
	$sphca_On_Archives = get_option('sphca_On_Archives');
	$sphca_On_Search = get_option('sphca_On_Search');
	$sphca_option = get_option('sphca_option');
	
	if (@$_POST['sphca_submit']) 
	{
		$sphca_On_Homepage = stripslashes(trim($_POST['sphca_On_Homepage']));
		$sphca_On_Posts = stripslashes(trim($_POST['sphca_On_Posts']));
		$sphca_On_Pages = stripslashes(trim($_POST['sphca_On_Pages']));
		$sphca_On_Archives = stripslashes(trim($_POST['sphca_On_Archives']));
		$sphca_On_Search = stripslashes(trim($_POST['sphca_On_Search']));
		$sphca_option = stripslashes(trim($_POST['sphca_option']));
		
		update_option('sphca_On_Homepage', $sphca_On_Homepage );
		update_option('sphca_On_Posts', $sphca_On_Posts );
		update_option('sphca_On_Pages', $sphca_On_Pages );
		update_option('sphca_On_Archives', $sphca_On_Archives );
		update_option('sphca_On_Search', $sphca_On_Search );
		update_option('sphca_option', $sphca_option );
	}
	
	echo '<form name="sphca_form" method="post" action="">';
	echo '<br>';
	echo 'Display mode (Global setting):';
	echo '<p><input  style="width: 200px;" maxlength="100" type="text" value="';
	echo $sphca_option . '" name="sphca_option" id="sphca_option" /> (showalways/oncepersession)</p>';
	echo '<br>';

	echo 'Popup display setting (This is not applicable for short code):';
	echo '<p>On Homepage:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sphca_On_Homepage . '" name="sphca_On_Homepage" id="sphca_On_Homepage" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Posts:&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sphca_On_Posts . '" name="sphca_On_Posts" id="sphca_On_Posts" /> (YES/NO) </p>';
	echo '<p>On Pages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sphca_On_Pages . '" name="sphca_On_Pages" id="sphca_On_Pages" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Search:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sphca_On_Archives . '" name="sphca_On_Archives" id="sphca_On_Archives" /> (YES/NO) </p>';
	echo '<p>On Archives:&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sphca_On_Search . '" name="sphca_On_Search" id="sphca_On_Search" /> (YES/NO) </p>';
	echo '<br>';	
	echo '<input type="submit" id="sphca_submit" name="sphca_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />';
	include_once("button.php");
	
	echo '</form>';
	
	include_once("help.php");
    
	echo '</div>';  
}

function scroll_popup_html_content_shortcode( $atts ) 
{
	global $wpdb;
	
	$scode = $matches[1];
	
	//[scroll-popup-html id="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$id = $atts['id'];
		
	$sSql = "select * from ".wp_scroll_popup_html_content_ads_table." where 1=1";
	
	if(!is_numeric(@$scode)) { @$scode = 0 ;}
	
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

	$sphca = "";
	$sphca = $sphca . '<script type="text/javascript"> ';
    $sphca = $sphca . "var html_code = '".$sphca_text."';";
    $sphca = $sphca . "sphca_loadpopup(".$sphca_width.", ".$sphca_height.", '".$sphca_title."', html_code);";
    $sphca = $sphca . '</script> ';
	$sphca = $sphca . '<script type="text/javascript">ShowTheBox('.$sphca_option.', '.$sphca_pos1.', '.$sphca_pos2.', '.$sphca_pos3.');</script> ';
	return $sphca;
}

function scroll_popup_html_content_ads_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'scroll-popup-html-content-ads-js', get_option('siteurl').'/wp-content/plugins/scroll-popup-html-content-ads/scroll-popup-html-content-ads.js');
		wp_enqueue_style( 'scroll-popup-html-content-ads-css', get_option('siteurl').'/wp-content/plugins/scroll-popup-html-content-ads/scroll-popup-html-content-ads.css');
	}	
}

add_shortcode( 'scroll-popup-html', 'scroll_popup_html_content_shortcode' );
add_action('wp_enqueue_scripts', 'scroll_popup_html_content_ads_add_javascript_files');
register_activation_hook(__FILE__, 'scroll_popup_html_content_ads_activation');
add_action('admin_menu', 'scroll_popup_html_content_ads_add_to_menu');
register_deactivation_hook( __FILE__, 'scroll_popup_html_content_ads_deactivate');
?>