<div role="main" id="wpbody">
	<div id="wpbody-content" aria-label="Main content" tabindex="0">		
		<div class="wrap">
			<form name="personalised_detail_frm" method="post" action="admin.php?page=csv_export" >
				<div class="personalised_detail_wrap">					
					<div class="kidsimage">
					<?php if($chk != ''){ ?>
						<h2 style="color:#698037"><?php echo $chk; ?></h2>
						<p><a href="post.php?post=<?php echo $order; ?>&action=edit" target="_blank">Click <?php echo "#".$order; ?></a>
					<?php } ?>
					<h3>Order Export</h3>
						<p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
							<label for="ordernumber">Order Date:</label>
							<input name="startdate" class="input-text " id="startdate" type="text" value="" placeholder="From" /> -
							<input name="enddate" class="input-text " id="enddate" type="text" value="" placeholder="To" />
						</p>
						<p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
							<label for="order_ids">Order IDs:</label>
							<textarea name="order_ids" class="input-text " id="order_ids" style="width:200px;height:200px;"></textarea>
						</p>
						<input class="button alt" name="exportorder" id="exportorder" value="Submit" type="submit" >
					</div>
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css' type='text/css' />
<script>
$('#startdate').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: "yy-mm-dd"
});

$('#enddate').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: "yy-mm-dd"
});
</script>
