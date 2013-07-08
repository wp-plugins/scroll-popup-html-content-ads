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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
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
			$sphca_success = __('Selected record was successfully deleted.', sphca_UNIQUE_NAME);
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
    <h2><?php echo sphca_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scroll-popup-html-content-ads&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".wp_scroll_popup_html_content_ads_table."` order by sphca_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/pages/setting.js"></script>
		<form name="frm_sphca_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="width:15px;"><input type="checkbox" name="sphca_group_item[]" /></th>
			<th scope="col" style="width:150px;">Short code</th>
			<th scope="col">Popup content</th>
            <th scope="col" style="width:200px;">Popup window title</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="height:15px;"><input type="checkbox" name="sphca_group_item[]" /></th>
			<th scope="col" style="width:150px;">Short code</th>
			<th scope="col">Popup content</th>
            <th scope="col" style="width:200px;">Popup window title</th>
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
						<td align="left"><input type="checkbox" value="<?php echo $data['sphca_id']; ?>" name="sphca_group_item[]"></th>
						<td>[scroll-popup-html id="<?php echo $data['sphca_id']; ?>"]
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scroll-popup-html-content-ads&amp;ac=edit&amp;did=<?php echo $data['sphca_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:sphca_delete('<?php echo $data['sphca_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
						</div>
						</td>
						<td><?php echo $data['sphca_text']; ?></td>
						<td><?php echo $data['sphca_title']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="4" align="center">No records available.</td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('sphca_form_show'); ?>
		<input type="hidden" name="frm_sphca_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scroll-popup-html-content-ads&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scroll-popup-html-content-ads&amp;ac=set">Plugin setting</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo sphca_FAV; ?>">Help</a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3>Plugin configuration option</h3>
	<ol>
		<li>Add the plugin in the posts or pages using short code.</li>
		<li>Add directly in to the theme using PHP code.</li>
	</ol>
	<p class="description"><?php echo sphca_LINK; ?></p>
	</div>
</div>