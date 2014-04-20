<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_sphca_display']) && $_POST['frm_sphca_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$sphca_success = '';
	$sphca_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".wp_scroll_popup_html_content_ads_table."
		WHERE `sphca_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'scroll-popup'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('sphca_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".wp_scroll_popup_html_content_ads_table."`
					WHERE `sphca_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$sphca_success_msg = TRUE;
			$sphca_success = __('Selected record was successfully deleted.', 'scroll-popup');
		}
	}
	
	if ($sphca_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $sphca_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Scroll popup html content ad', 'scroll-popup'); ?>
	<a class="add-new-h2" href="<?php echo WP_sphca_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'scroll-popup'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".wp_scroll_popup_html_content_ads_table."` order by sphca_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_sphca_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_sphca_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="width:15px;"><input type="checkbox" name="sphca_group_item[]" /></th>
			<th scope="col" style="width:180px;"><?php _e('Short code', 'scroll-popup'); ?></th>
			<th scope="col"><?php _e('Popup content', 'scroll-popup'); ?></th>
            <th scope="col" style="width:200px;"><?php _e('Popup window title', 'scroll-popup'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="height:15px;"><input type="checkbox" name="sphca_group_item[]" /></th>
			<th scope="col" style="width:180px;"><?php _e('Short code', 'scroll-popup'); ?></th>
			<th scope="col"><?php _e('Popup content', 'scroll-popup'); ?></th>
            <th scope="col" style="width:200px;"><?php _e('Popup window title', 'scroll-popup'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['sphca_id']; ?>" name="sphca_group_item[]"></td>
						<td>[scroll-popup-html id="<?php echo $data['sphca_id']; ?>"]
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_sphca_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['sphca_id']; ?>"><?php _e('Edit', 'scroll-popup'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:sphca_delete('<?php echo $data['sphca_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'scroll-popup'); ?></a></span> 
						</div>
						</td>
						<td><?php echo stripslashes($data['sphca_text']); ?></td>
						<td><?php echo stripslashes($data['sphca_title']); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="4" align="center"><?php _e('No records available.', 'scroll-popup'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('sphca_form_show'); ?>
		<input type="hidden" name="frm_sphca_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_sphca_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'scroll-popup'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_sphca_ADMIN_URL; ?>&amp;ac=set"><?php _e('Plugin Setting', 'scroll-popup'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo sphca_FAV; ?>"><?php _e('Help', 'scroll-popup'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'scroll-popup'); ?></h3>
	<ol>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'scroll-popup'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'scroll-popup'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'scroll-popup'); ?>
		<a target="_blank" href="<?php echo sphca_FAV; ?>"><?php _e('click here', 'scroll-popup'); ?></a>
	</p>
	</div>
</div>