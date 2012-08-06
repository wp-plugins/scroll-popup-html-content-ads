<?php
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
		  PRIMARY KEY  (`sphca_id`) )
		");
	
	$c1 = '<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="'.get_option('siteurl').'/wp-content/plugins/scroll-popup-html-content-ads/gopiplus.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	$t1 = 'Popup Title';
	$c2 = '<a href="http://www.gopiplus.com/work/" target="_blank"><img src="'.get_option('siteurl').'/wp-content/plugins/scroll-popup-html-content-ads/gopiplus.jpg" border="0"  /></a>';
	
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
?>