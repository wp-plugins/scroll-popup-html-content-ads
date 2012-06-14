<div class="wrap">
  <?php
 	global $wpdb;
	$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=scroll-popup-html-content-ads/content-management.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";
	if(@$AC <> "DEL" and trim(@$_POST['sphca_text']) <>"")
    {
			if(@$_POST['sphca_id'] == "" )
			{
					$sql = "insert into ".wp_scroll_popup_html_content_ads_table.""
					. " set `sphca_text` = '" . mysql_real_escape_string(trim($_POST['sphca_text']))
					. "', `sphca_title` = '" . $_POST['sphca_title']
					. "', `sphca_width` = '" . $_POST['sphca_width']
					. "', `sphca_height` = '" . $_POST['sphca_height']
					. "', `sphca_pos1` = '" . $_POST['sphca_pos1']
					. "', `sphca_pos2` = '" . $_POST['sphca_pos2']
					. "', `sphca_pos3` = '" . $_POST['sphca_pos3']
					. "'";	
			}
			else
			{
					$sql = "update ".wp_scroll_popup_html_content_ads_table.""
					. " set `sphca_text` = '" . mysql_real_escape_string(trim($_POST['sphca_text']))
					. "', `sphca_title` = '" . $_POST['sphca_title']
					. "', `sphca_width` = '" . $_POST['sphca_width']
					. "', `sphca_height` = '" . $_POST['sphca_height']
					. "', `sphca_pos1` = '" . $_POST['sphca_pos1']
					. "', `sphca_pos2` = '" . $_POST['sphca_pos2']
					. "', `sphca_pos3` = '" . $_POST['sphca_pos3']
					. "' where `sphca_id` = '" . $_POST['sphca_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".wp_scroll_popup_html_content_ads_table." where sphca_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".wp_scroll_popup_html_content_ads_table." where sphca_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $sphca_id_x = htmlspecialchars(stripslashes($data->sphca_id)); 
        if ( !empty($data) ) $sphca_text_x = htmlspecialchars(stripslashes($data->sphca_text));
        if ( !empty($data) ) $sphca_title_x = htmlspecialchars(stripslashes($data->sphca_title));
		if ( !empty($data) ) $sphca_width_x = htmlspecialchars(stripslashes($data->sphca_width));
		if ( !empty($data) ) $sphca_height_x = htmlspecialchars(stripslashes($data->sphca_height));
		if ( !empty($data) ) $sphca_pos1_x = htmlspecialchars(stripslashes($data->sphca_pos1));
		if ( !empty($data) ) $sphca_pos2_x = htmlspecialchars(stripslashes($data->sphca_pos2));
		if ( !empty($data) ) $sphca_pos3_x = htmlspecialchars(stripslashes($data->sphca_pos3));
        $submittext = "Update Message";
    }
 ?>
  <h2>Scrolling Popup</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/setting.js"></script>
  <script language="JavaScript" src="<?php //echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/noenter.js"></script>
  <form name="sphca_form" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return _sphca_submit()"  >
    <table width="100%" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="273">Popup Window Title</td>
        <td width="982">:
          <input name="sphca_title" type="text" id="sphca_title" value="<?php echo @$sphca_title_x; ?>" size="70" maxlength="1000" /> 
          </td>
      </tr>
      <tr>
        <td>Window Width</td>
        <td>:
          <input name="sphca_width" type="text" id="sphca_width" value="<?php echo @$sphca_width_x; ?>" size="20" maxlength="4" />
          (Ex: 330)</td>
      </tr>
      <tr>
        <td>Window Height</td>
        <td>:
          <input name="sphca_height" type="text" id="sphca_height" value="<?php echo @$sphca_height_x; ?>" size="20" maxlength="4" />
          (Ex: 270)</td>
      </tr>
      <tr>
        <td>Window Position 1</td>
        <td>:
		  <select name="sphca_pos1" id="sphca_pos1">
            <option value='rightSide' <?php if(@sphca_pos1_x=='rightSide') { echo 'selected' ; } ?>>rightSide</option>
            <option value='leftSide' <?php if(@$sphca_pos1_x=='leftSide') { echo 'selected' ; } ?>>leftSide</option>
          </select>
          </td>
      </tr>
      <tr>
        <td>Window Position 2</td>
        <td>:
          <select name="sphca_pos2" id="sphca_pos2">
            <option value='bottomCorner' <?php if(@sphca_pos2_x=='bottomCorner') { echo 'selected' ; } ?>>bottomCorner</option>
            <option value='topCorner' <?php if(@$sphca_pos2_x=='topCorner') { echo 'selected' ; } ?>>topCorner</option>
          </select>
          </td>
      </tr>
      <tr>
        <td>Window Position 3</td>
        <td>:
          <select name="sphca_pos3" id="sphca_pos3">
            <option value='rightLeft' <?php if(@sphca_pos3_x=='rightLeft') { echo 'selected' ; } ?>>rightLeft</option>
            <option value='bottopUp' <?php if(@$sphca_pos3_x=='bottopUp') { echo 'selected' ; } ?>>bottopUp</option>
			<option value='topDown' <?php if(@$sphca_pos3_x=='topDown') { echo 'selected' ; } ?>>topDown</option>
			<option value='leftRight' <?php if(@$sphca_pos3_x=='leftRight') { echo 'selected' ; } ?>>leftRight</option>
          </select>
          </td>
      </tr>
      <tr>
        <td colspan="2">Add The Popup Text In The Below TextBox (Can add HTML content) :</td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="sphca_text" id="sphca_text" cols="120" rows="10"><?php echo @$sphca_text_x; ?></textarea>
		<?php //wp_editor(@$sphca_text_x, "sphca_text");?></td>
      </tr>
      <tr>
        <td colspan="2"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onclick="_sphca_redirect()" value="Cancel" type="button" /> <?php include_once("button.php"); ?></td>
      </tr>
    </table>
    <input name="sphca_id" id="sphca_id" type="hidden" value="<?php echo @$sphca_id_x; ?>">
    
  </form>
  
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".wp_scroll_popup_html_content_ads_table." order by sphca_id");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="sphca_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
		  	<th width="4%" align="left" scope="col">ID</th>
            <th width="17%" align="left" scope="col">Short Code</th>
            <th align="left" scope="col">Popup Content</th>
            <th width="8%" align="left" scope="col">Action</th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		$displayisthere="True";
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
		  	<td align="left" valign="middle"><?php echo $data->sphca_id; ?></td>
            <td align="left" valign="middle">[scroll-popup-html id="<?php echo(stripslashes($data->sphca_id)); ?>"]</td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->sphca_text)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=scroll-popup-html-content-ads/content-management.php&DID=<?php echo($data->sphca_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_sphca_delete('<?php echo($data->sphca_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available</td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <?php //include_once("help.php"); ?>
</div>