<?php
/**
* Template Name: Calling Team Page
*
*/
get_header();
session_start();
/*
* Form submission
*/
global $wpdb;
if(isset($_REQUEST['bu_name']) && $_REQUEST['bu_name'] != '' && isset($_REQUEST['bu_gender']) && $_REQUEST['bu_gender'] != '')
{
	$kids_name=$_REQUEST['bu_name'];
	$gender=$_REQUEST['bu_gender'];
	$visitors_phone=isset($_REQUEST['visitors_phone'])?$_REQUEST['visitors_phone']:"";
	//$_SESSION['sess_visitors_email'] = isset($_REQUEST['visitors_email'])?$_REQUEST['visitors_email']:"";	
	$datenum = isset($_REQUEST['daynum'])?$_REQUEST['daynum']:"";
	$monthnumber = isset($_REQUEST['monthnumber'])?$_REQUEST['monthnumber']:"";
	$yearnum = isset($_REQUEST['yearnum'])?$_REQUEST['yearnum']:"";
	$_SESSION['sess_visitors_dob'] = $datenum.'/'.$monthnumber.'/'.$yearnum;
	$_SESSION['sess_campaign'] = isset($_REQUEST['campaign'])?$_REQUEST['campaign']:"";
	$_SESSION['sess_phonenumber'] = $visitors_phone;
    
	if(isset($_REQUEST['skidurl']) && $_REQUEST['skidurl'] != ''){
		$skidurl = $_REQUEST['skidurl'];
        
		if (strpos($skidurl, 'skids.in') !== false) {			
			$kidgen = 'B';
			if($gender == 'Girl' || $gender == 'girl'){
				$kidgen = 'G';
			}
			
			wp_redirect($skidurl.'/'.$kidgen.'_'.$kids_name);
			exit;
		}else{
			wp_redirect(get_permalink(8).'?bu_name='.$kids_name.'&bu_gender='.$gender);	
			exit;	
		}
	}
	
	wp_redirect(get_permalink(8).'?bu_name='.$kids_name.'&bu_gender='.$gender);	
	exit;
}
?>
<script>
jQuery(document).ready(function($) {	
	$('.rd_dv label input:radio').click(function() {
		$('.rd_dv label input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	
	
	$('.homepageform').submit(function(){
		if($('.fname').val() == ''){
			$('.fname').focus();			
			sweetAlert("Please enter name.", "What’s the name?", "error");
			return false;
		}
		var a=document.getElementById('fnameid');
		var aexp = /^[a-zA-Z]+$/;
		if(!a.value.match(aexp))
		{
			$('.fname').focus();
			sweetAlert("Sorry! Name should not contain special characters and space.","","");
			return false;
		}
		return true;
	});
	$(".fname").on("keypress", function(e) {
		if (e.which === 32 && !this.value.length)
			e.preventDefault();		
	});
	
	$('.fname').keydown(function (e) {
          
		var key = e.keyCode;
		if (!((key == 8) || (key == 9) || (key == 13) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		  e.preventDefault();
		}
		var key = e.keyCode;
		var len = $('.fname').val().length;
		if(len == 12){
			if (key >= 65 && key <= 90){
				sweetAlert("Sorry! The name should be less than or equals to 12 characters.","","");
				e.preventDefault();
			}
		}
		
      });
	  
		
});
</script>
<div class="hm_blk2">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<div class="blkbg"><img src="<?php echo get_template_directory_uri(); ?>/images/blk.png" alt=""/></div>
	<div class="hmcnt">
		<div class="main">
            
			<div class="mid" id="createbook">
				<div class="hm_bk2img1"><img src="<?php echo get_template_directory_uri(); ?>/images/hmleft.png" alt=""/></div>
				<h3>Know the Magical Story behind your Kid's Name</h3>
				<form name="homepageform" class="homepageform" action="" method="get">
				    <input type="hidden" name="campaign" value="<?php echo $campaign;?>">					
					<div class="inputbox">
						<input type="text" value="" placeholder="Enter kid’s name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter kid’s name'" class="fname" name="bu_name" id="fnameid" maxlength="14" /><div id="charNum"></div>
					</div>
					
					<div class="nw_fld">
						<div class="rd_dv">
							<label class="active"><input type="radio" name="bu_gender" value="Boy" class="rd_btn" checked="checked"/>Boy</label>
							<label class="grl"><input type="radio" name="bu_gender" value="Girl" class="rd_btn" />Girl</label>
						</div>
                        <?php /* <div class="inputbox">
							<input type="text" placeholder="Enter Your E-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your E-mail'" class="" id="visitors_emailid" name="visitors_email" maxlength="40" /><div id=""></div>
						</div> 
						<div class="inputbox">
							<input type="text" placeholder="Enter Your Date of Birth" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your Date of Birth'" class="" id="datepicker" name="visitors_dob" maxlength="40" /><div id=""></div>
						</div>
						*/ ?>
						<div class="dob">Enter Your Kid's Date of Birth</div>
						<select name="daynum">
							<option> Date </option>
							    <?php
							    	$rangeDate = range(1,31);
							    	foreach($rangeDate  as $day_of_month ) {
							    		$daynumber = str_pad($day_of_month, 2, '0', STR_PAD_LEFT);
							    	?>
							        <option value='<?php echo $daynumber; ?>'><?php echo $daynumber; ?></option>
							    <?php } ?>
					    </select>
					    <select name="monthnumber">
					    	<option>Month </option>
							    <?php 
							    //$rangeMonth = range(1,12);
							    $rangeMonth = ['01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=> 'May', '06'=> 'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11' => 'November', '12'=>'December'];
							    foreach($rangeMonth  as $monthKey => $month_of_year ) : ?>
							        <option  value='<?php echo $monthKey; ?>'><?php echo $month_of_year; ?></option>
							    <?php endforeach; ?>
					    </select>
					    <select name="yearnum">
				    		<option>Year</option>
							    <?php 
							    $startYear = 2007;
							    $endYear = date('Y');
							    $rangeYear = range($startYear,$endYear);
							    foreach( $rangeYear as $year ) : ?>
							        <option  value='<?php echo $year; ?>'><?php echo $year; ?></option>
							    <?php endforeach; ?>
				    	</select>
						
						<div class="inputbox" style="margin-top: 15px;">
							<input type="text" placeholder="Enter Your Phone Number." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your Phone Number.'" class="" id="visitors_phone" name="visitors_phone" maxlength="10" /><div id=""></div>
						</div>
						
						
						<input type="submit" name="submit" class="btn_nm" value="Create book"/>
					</div>
				</form>
				<div class="hm_bk2img2"><img src="<?php echo get_template_directory_uri(); ?>/images/hmright.png" alt=""/></div>
			</div>
           
		</div>
	</div> 
</div>
<script type="text/javascript">
	$("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
		dateFormat: "dd/mm/yy",
    });
</script>>
<?php get_footer(); ?>