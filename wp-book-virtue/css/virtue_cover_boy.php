<?phpglobal $wpdb;session_start();$frontimage	= get_option('frontimage')?get_option('frontimage'):"";$backimage	= get_option('backimage')?get_option('backimage'):"";if(isset($_POST['submit_coverform'])){	if(get_option('frontimage', 'default') == 'default'){		add_option('frontimage');	}	if(get_option('backimage', 'default') == 'default'){		add_option('backimage');	}		$frontimage	= $_POST['frontimage'];	$backimage	= $_POST['backimage'];	update_option('frontimage', $frontimage);	update_option('backimage', $backimage);}?>
<div role="main" id="wpbody">	<div tabindex="0" aria-label="Main content" id="wpbody-content">		<div class="wrap">			<h1 class="wp-heading-inline">Cover Images</h1>			<br><br>			<?php echo isset($_SESSION['msg'])?$_SESSION['msg']:""; ?>			<div class="option">				<form name="coverform" action="" method="POST" enctype="multipart/form-data">					<table class="form-table virtue-table">						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="frontimage">Boy's Front Cover</label></th>							<td><input id="frontimage" type="hidden" name="frontimage" value="<?php if($frontimage != ''){ ?><?php echo $frontimage; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="backimage">Boy's Back Cover</label></th>							<td><input id="backimage" type="hidden" name="backimage" value="<?php if($backimage != ''){ ?><?php echo $backimage; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>					</table>					<p class="submit"><input type="submit" name="submit_coverform" id="submit_coverform" class="button button-primary" value="Save"></p>					<div class="sidebar-image" style="float: left;">					<h2>Boy's Cover Images</h2>						<img id="imgadd" src="<?php if($frontimage != ''){ ?><?php echo $frontimage; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />												<img id="imgadd" src="<?php if($backimage != ''){ ?><?php echo $backimage; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />					</div>									</form>				
			</div>
		</div>
	</div>
</div>