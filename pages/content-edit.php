<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

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
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$sphca_errors = array();
	$sphca_success = '';
	$sphca_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".wp_scroll_popup_html_content_ads_table."`
		WHERE `sphca_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'sphca_text' => $data['sphca_text'],
		'sphca_title' => $data['sphca_title'],
		'sphca_width' => $data['sphca_width'],
		'sphca_height' => $data['sphca_height'],
		'sphca_pos1' => $data['sphca_pos1'],
		'sphca_pos2' => $data['sphca_pos2'],
		'sphca_pos3' => $data['sphca_pos3'],
		'sphca_id' => $data['sphca_id']
	);
}
// Form submitted, check the data
if (isset($_POST['sphca_form_submit']) && $_POST['sphca_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('sphca_form_edit');
	
	$form['sphca_text'] = isset($_POST['sphca_text']) ? $_POST['sphca_text'] : '';
	if ($form['sphca_text'] == '')
	{
		$sphca_errors[] = __('Please enter the message.', sphca_UNIQUE_NAME);
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_width'] = isset($_POST['sphca_width']) ? $_POST['sphca_width'] : '';
	if ($form['sphca_width'] == '')
	{
		$sphca_errors[] = __('Please enter window width, only number.', sphca_UNIQUE_NAME);
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_height'] = isset($_POST['sphca_height']) ? $_POST['sphca_height'] : '';
	if ($form['sphca_height'] == '')
	{
		$sphca_errors[] = __('Please enter window height, only number.', sphca_UNIQUE_NAME);
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_title'] = isset($_POST['sphca_title']) ? $_POST['sphca_title'] : '';
	$form['sphca_pos1'] = isset($_POST['sphca_pos1']) ? $_POST['sphca_pos1'] : '';
	$form['sphca_pos2'] = isset($_POST['sphca_pos2']) ? $_POST['sphca_pos2'] : '';
	$form['sphca_pos3'] = isset($_POST['sphca_pos3']) ? $_POST['sphca_pos3'] : '';


	//	No errors found, we can add this Group to the table
	if ($sphca_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".wp_scroll_popup_html_content_ads_table."`
				SET `sphca_text` = %s,
				`sphca_title` = %s,
				`sphca_width` = %s,
				`sphca_height` = %s,
				`sphca_pos1` = %s,
				`sphca_pos2` = %s,
				`sphca_pos3` = %s
				WHERE sphca_id = %d
				LIMIT 1",
				array($form['sphca_text'], $form['sphca_title'], $form['sphca_width'], $form['sphca_height'], $form['sphca_pos1'], $form['sphca_pos2'], $form['sphca_pos3'], $did)
			);
		$wpdb->query($sSql);
		
		$sphca_success = 'Details was successfully updated.';
	}
}

if ($sphca_error_found == TRUE && isset($sphca_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $sphca_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($sphca_error_found == FALSE && strlen($sphca_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $sphca_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scroll-popup-html-content-ads">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/pages/setting.js"></script>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/pages/noenter.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo sphca_TITLE; ?></h2>
	<form name="sphca_form" method="post" action="#" onsubmit="return sphca_submit()"  >
      <h3>Update details</h3>
	  
		<label for="tag-title">Popup window title</label>
		<input name="sphca_title" type="text" id="sphca_title" value="<?php echo $form['sphca_title']; ?>" size="70" maxlength="1000" /> 
		<p>Enter your popup window title.</p>
		
		<label for="tag-title">Window width</label>
		<input name="sphca_width" type="text" id="sphca_width" value="<?php echo $form['sphca_width']; ?>" maxlength="4" />
		<p>Enter your popup window width.</p>
		
		<label for="tag-title">Window height</label>
		<input name="sphca_height" type="text" id="sphca_height" value="<?php echo $form['sphca_height']; ?>" maxlength="4" />
		<p>Enter your popup window height.</p>
	  
	  	<label for="tag-title">Window position 1</label>
		<select name="sphca_pos1" id="sphca_pos1">
            <option value='rightSide' <?php if($form['sphca_pos1'] == 'rightSide') { echo "selected='selected'" ; } ?>>Right Side</option>
            <option value='leftSide' <?php if($form['sphca_pos1'] == 'leftSide') { echo "selected='selected'" ; } ?>>Left Side</option>
          </select>
		<p>Select your window position.</p>
		
		<label for="tag-title">Window position 2</label>
		<select name="sphca_pos2" id="sphca_pos2">
            <option value='bottomCorner' <?php if($form['sphca_pos2'] == 'bottomCorner') { echo "selected='selected'" ; } ?>>Bottom Corner</option>
            <option value='topCorner' <?php if($form['sphca_pos2'] == 'topCorner') { echo "selected='selected'" ; } ?>>Top Corner</option>
          </select>
		<p>Select your window position.</p>
		
		<label for="tag-title">Scroll direction</label>
		<select name="sphca_pos3" id="sphca_pos3">
            <option value='rightLeft' <?php if($form['sphca_pos3'] == 'rightLeft') { echo "selected='selected'" ; } ?>>Right Left</option>
            <option value='bottopUp' <?php if($form['sphca_pos3'] == 'bottopUp') { echo "selected='selected'" ; } ?>>Bottom Up</option>
			<option value='topDown' <?php if($form['sphca_pos3'] == 'topDown') { echo "selected='selected'" ; } ?>>Top Down</option>
			<option value='leftRight' <?php if($form['sphca_pos3'] == 'leftRight') { echo "selected='selected'" ; } ?>>Left Right</option>
          </select>
		<p>Select your scroll direction.</p>
		
		<label for="tag-title">Popup message</label>
		<textarea name="sphca_text" id="sphca_text" cols="120" rows="10"><?php echo $form['sphca_text']; ?></textarea>
		<p>Add your popup test here, your can add HTML content.</p>
	  
      <input name="sphca_id" id="sphca_id" type="hidden" value="<?php echo $form['sphca_id']; ?>">
      <input type="hidden" name="sphca_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Update Details" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="sphca_redirect()" value="Cancel" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="sphca_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('sphca_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo sphca_LINK; ?></p>
</div>