<?php 
$msg = '';
if( isset($_POST['postalcodechk'])){
	
		global $wpdb;
		$postal_code = $_POST['postal_code'];
		$postal_code = str_replace(array("\n", "\r\n"), ",", $postal_code);	
		update_option( 'restricted_postal_code', $postal_code , 'yes' );
		$msg = 'Postcodes added successfully.';
		 
}
$get_postal_code = get_option('restricted_postal_code');
?>

<div role="main" id="wpbody">
	<div id="wpbody-content" aria-label="Main content" tabindex="0">		
		<div class="wrap">
			<form name="restrictpostalcode" method="post" action="" >
				<div class="personalised_detail_wrap">					
					<div class="kidsimage">
					<h3>Allow COD payment method to postal code</h3>
						<p><?php echo $msg; ?></p>
						<p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
							<label for="ordernumber">Postal Code:</label><br>
							<textarea name="postal_code" class="input-text " id="postal_code" style="width:100%;height:300px;"><?php if($get_postal_code != ""){ echo $get_postal_code;  } ?></textarea>
						</p>
						<input class="button alt" name="postalcodechk" id="postalcodechk" value="Submit" type="submit" >
					</div>
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>