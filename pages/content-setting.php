<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo sphca_TITLE; ?></h2>
	<h3>Plugin setting</h3>
    <?php
	$sphca_On_Homepage = get_option('sphca_On_Homepage');
	$sphca_On_Posts = get_option('sphca_On_Posts');
	$sphca_On_Pages = get_option('sphca_On_Pages');
	$sphca_On_Archives = get_option('sphca_On_Archives');
	$sphca_On_Search = get_option('sphca_On_Search');
	$sphca_option = get_option('sphca_option');
	
	if (isset($_POST['sphca_form_submit']) && $_POST['sphca_form_submit'] == 'yes')
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
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scroll-popup-html-content-ads/pages/setting.js"></script>
	<form name="sphca_form" method="post" action="">
		
		<label for="tag-title">Display mode (Global setting)</label>
		<select name="sphca_option" id="sphca_option">
			<option value='showalways' <?php if($sphca_option == 'showalways') { echo "selected='selected'" ; } ?>>Show always</option>
			<option value='oncepersession' <?php if($sphca_option == 'oncepersession') { echo "selected='selected'" ; } ?>>Once per session</option>
		</select>
		<p>Display popup Always (or) Once per session</p>
		
		<label for="tag-title">Display on home page</label>
		<select name="sphca_On_Homepage" id="sphca_On_Homepage">
			<option value='YES' <?php if($sphca_On_Homepage == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Homepage == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>This option is to display the popup on home page.</p>
		
		<label for="tag-title">Display on wp posts</label>
		<select name="sphca_On_Posts" id="sphca_On_Posts">
			<option value='YES' <?php if($sphca_On_Posts == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Posts == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>This option is to display the popup on wp posts</p>
		
		<label for="tag-title">Display on wp pages</label>
		<select name="sphca_On_Pages" id="sphca_On_Pages">
			<option value='YES' <?php if($sphca_On_Pages == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Pages == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>This option is to display the popup on wp pages.</p>
		
		<label for="tag-title">Display on wp archives</label>
		<select name="sphca_On_Archives" id="sphca_On_Archives">
			<option value='YES' <?php if($sphca_On_Archives == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Archives == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>This option is to display the popup on wp archives pages.</p>
		
		<label for="tag-title">Display on wp search</label>
		<select name="sphca_On_Search" id="sphca_On_Search">
			<option value='YES' <?php if($sphca_On_Search == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Search == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>This option is to display the popup on wp search pages.</p>
		
		<div style="height:5px;"></div>
		<input type="hidden" name="sphca_form_submit" value="yes"/>
		<input name="sphca_submit" id="sphca_submit" class="button add-new-h2" value="Submit" type="submit" />&nbsp;
		<input name="publish" lang="publish" class="button add-new-h2" onclick="sphca_redirect()" value="Cancel" type="button" />&nbsp;
		<input name="Help" lang="publish" class="button add-new-h2" onclick="sphca_help()" value="Help" type="button" />
		<div style="height:5px;"></div>
		<?php wp_nonce_field('sphca_form_setting'); ?>
    </form>
	 </div>
  <p class="description"><?php echo sphca_LINK; ?></p>
</div>