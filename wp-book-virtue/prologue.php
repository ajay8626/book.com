<?php$prologue	= get_option('prologue')?get_option('prologue'):"";$boys_back1	= get_option('boys_back1')?get_option('boys_back1'):"";$boys_back2	= get_option('boys_back2')?get_option('boys_back2'):"";$girls_back1	= get_option('girls_back1')?get_option('girls_back1'):"";$girls_back2	= get_option('girls_back2')?get_option('girls_back2'):"";if(isset($_POST['submit_coverform'])){	if(get_option('prologue', 'default') == 'default'){		add_option('prologue');	}	$prologue	= $_POST['prologue'];	update_option('prologue', $prologue);		if(get_option('boys_back1', 'default') == 'default'){		add_option('boys_back1');	}	if(get_option('boys_back2', 'default') == 'default'){		add_option('boys_back2');	}	if(get_option('girls_back1', 'default') == 'default'){		add_option('girls_back1');	}	if(get_option('girls_back2', 'default') == 'default'){		add_option('girls_back2');	}	$boys_back1	= $_POST['boys_back1'];	$boys_back2	= $_POST['boys_back2'];	$girls_back1	= $_POST['girls_back1'];	$girls_back2	= $_POST['girls_back2'];	update_option('boys_back1', $boys_back1);	update_option('boys_back2', $boys_back2);	update_option('girls_back1', $girls_back1);	update_option('girls_back2', $girls_back2);}?>
<div role="main" id="wpbody">	<div tabindex="0" aria-label="Main content" id="wpbody-content">		<div class="wrap">			<h1 class="wp-heading-inline">Upload Prologue And Back Images</h1>			<br><br>			<?php echo isset($_SESSION['msg'])?$_SESSION['msg']:""; ?>			<div class="option">				<form name="coverform" action="" method="POST" enctype="multipart/form-data">					<table class="form-table virtue-table">						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="prologue">Prologue Image</label></th>							<td><input id="prologue" type="hidden" name="prologue" value="<?php if($prologue != ''){ ?><?php echo $prologue; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="boys_back1">Back Images 1 (Boy)</label></th>							<td><input id="boys_back1" type="hidden" name="boys_back1" value="<?php if($boys_back1 != ''){ ?><?php echo $boys_back1; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="boys_back2">Back Images 2 (Boy)</label></th>							<td><input id="boys_back2" type="hidden" name="boys_back2" value="<?php if($boys_back2 != ''){ ?><?php echo $boys_back2; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="girls_back1">Back Images 1 (Girl)</label></th>							<td><input id="girls_back1" type="hidden" name="girls_back1" value="<?php if($girls_back1 != ''){ ?><?php echo $girls_back1; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>						<tr class="user-rich-editing-wrap">							<th scope="row"><label for="girls_back2">Back Images 2 (Girl)</label></th>							<td><input id="girls_back2" type="hidden" name="girls_back2" value="<?php if($girls_back2 != ''){ ?><?php echo $girls_back2; ?><?php } ?>" /><input class="onetarek-upload-button button staff_button" type="button" value="Upload Image" /></td>						</tr>					</table>					<p class="submit"><input type="submit" name="submit_coverform" id="submit_coverform" class="button button-primary" value="Save"></p>					<div class="sidebar-image" style="float: left;">					<h2>Prologue Images</h2>						<img id="imgadd" src="<?php if($prologue != ''){ ?><?php echo $prologue; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />						<br>						<br>						<br>						<h2>Back Images (Boy)</h2>						<img id="imgadd" src="<?php if($boys_back1 != ''){ ?><?php echo $boys_back1; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />						<img id="imgadd" src="<?php if($boys_back2 != ''){ ?><?php echo $boys_back2; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />						<br>						<h2>Back Images (Girl)</h2>						<img id="imgadd" src="<?php if($girls_back1 != ''){ ?><?php echo $girls_back1; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />						<img id="imgadd" src="<?php if($girls_back2 != ''){ ?><?php echo $girls_back2; ?><?php }else{ echo plugins_url().'/wp-book-virtue/noimage.png'; } ?>" alt="Virtue Image" />											</div>									</form>			</div>
		</div>
	</div>
</div>