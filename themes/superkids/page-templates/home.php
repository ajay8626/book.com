<?php
/**
* Template Name: Home Page
*
*/
get_header();
session_start();
/*
* Form submission
*/
function generateRandomString($length = 7) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  	$charactersLength = strlen($characters);
  	$randomString = '';
  	for ($i = 0; $i < $length; $i++) {
    	$randomString .= $characters[rand(0, $charactersLength - 1)];
  	}
  	return $randomString;
}
if((isset($_REQUEST['pn'])) && (!empty($_REQUEST['pn']))){
	global $wpdb;
	$user_id = $_REQUEST['pn'];
	$data_array = array('key'=>'007', 'ids'=>$user_id);
	$url = 'http://www.parentingnation.in/SuperKids.asmx/getTransferDataByID';
	$make_call = wp_remote_post($url, array(
	    'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
	    'body'        => json_encode($data_array),
	    'method'      => 'POST',
	    'data_format' => 'body',
	));
	$data = json_decode($make_call['body'], true);
    $response = json_decode($data['d'],true);
    if((isset($response)) && (!empty($response['result']['babyList'][0]))){
    	$babyListdata = $response['result']['babyList'][0];
    	$babyname = $babyListdata['babyname'];
        $kidsname = explode(' ', $babyname);
        $firstname = $kidsname[0];

        $firstname = str_replace(array('\'', '"'), '', $firstname);
        $gender = $babyListdata['gender'];
        $dob = date("Y-m-d", strtotime($babyListdata['birthdate1']));
        $registerdate = date("Y-m-d", strtotime($babyListdata['registerdate1']));
        $phone = $babyListdata['phonenumber'];
        $parentsname = $babyListdata['customername'];
        $parentsemail = $babyListdata['email'];
        $city = $babyListdata['city'];
        $ucode = generateRandomString(7);
    	$insdata = array(
            'kidsname' => $firstname,
            'gender' => $gender,
            'dob' => $dob,
            'phone' => $phone,
            'parentsname' => $parentsname,
            'email' => $parentsemail,
            'ucode' => $ucode,
            'registerdate' => $registerdate,
            'city'			=> $city,
            'status' => 1
      	);
        if($wpdb->insert("wp_general_contacts", $insdata)){
      		$message = "Name : ".$kidsname. "<br> Phone: " . $phone. "<br> DOB: " . $dob. "<br> parentsname: " . $parentsname. "<br> email: " . $parentsemail. "<br> city: " . $city. "<br> registerdate: " . $registerdate;
	        $subject = $kids_name.' : From HOMEPAGE';
	        $loc_email = 'ajaykumar@webtechsystem.com';
	        //$email = array('ajaykumar@webtechsystem.com');
	        //foreach ($email as $key => $loc_email) {
	        	$headers = "From: Skids <asingh@skids.in> \r\n" . 
					"Content-type: text/html; charset=UTF-8 \r\n"; 
				$ok = wp_mail($loc_email, $subject, $message, $headers);
				if($ok){
					$lastId = $wpdb->get_results("SELECT `id` FROM `wp_general_contacts` ORDER BY 'DESC' LIMIT 1 ");
					$wpdb->query("UPDATE `wp_general_contacts` SET flag = 1 WHERE id = $lastId ");
				}
	        //}
          }
    }
}
if(isset($_REQUEST['bu_name']) && $_REQUEST['bu_name'] != '' && isset($_REQUEST['bu_gender']) && $_REQUEST['bu_gender'] != '')
{
	$kids_name=$_REQUEST['bu_name'];
	$gender=$_REQUEST['bu_gender'];
	$visitors_phone=isset($_REQUEST['visitors_phone'])?$_REQUEST['visitors_phone']:"";
	//$_SESSION['sess_visitors_email'] = isset($_REQUEST['visitors_email'])?$_REQUEST['visitors_email']:"";
	//$_SESSION['sess_visitors_dob'] = isset($_REQUEST['visitors_dob'])?$_REQUEST['visitors_dob']:"";		
	$datenum = isset($_REQUEST['daynum'])?$_REQUEST['daynum']:"";
	$monthnumber = isset($_REQUEST['monthnumber'])?$_REQUEST['monthnumber']:"";
	$yearnum = isset($_REQUEST['yearnum'])?$_REQUEST['yearnum']:"";
	$_SESSION['sess_visitors_dob'] = $datenum.'/'.$monthnumber.'/'.$yearnum;
	$_SESSION['sess_campaign'] = isset($_REQUEST['campaign'])?$_REQUEST['campaign']:"";
	$_SESSION['sess_phonenumber'] = $visitors_phone;
    if($visitors_phone != ""){
        require("class.phpmailer.php");
            $message = "Name : " .$kids_name. "<br> Phone: " . $visitors_phone. "<br> DOB: " . $_SESSION['sess_visitors_dob'];
            $subject = $kids_name.' : From HOMEPAGE';
            $Host = get_option('smtp_hostname');
            $Username = get_option('smtp_username');
            $Password = get_option('smtp_password');
            if($Host != '' && $Username != '' && $Password != ''){
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = $Host;
                $mail->Username = $Username;
                $mail->Password = $Password;
                $mail->SMTPAuth = true;
                $mail->Debug = true;
                $mail->From = 'asingh@skids.in';
                $mail->FromName = "Skids";
                $mail->IsHTML(true);
                $loc_email = 'dipakskids@gmail.com';
                $mail->AddAddress($loc_email);
                $mail->Subject = $subject;
                $mail->Body = $message;
                $ok=$mail->Send();
            }
    }
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

if(isset($_REQUEST['uc']) && $_REQUEST['uc'] != ''){
    $_SESSION['sess_bcode'] = $_REQUEST['uc'];
}
$parameter = explode('?', $_SERVER['REQUEST_URI']);
if(isset($parameter[1])) {
	$campaign = $parameter[1];
} else {
	$campaign = "";
}
// Start the loop.
if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<!--<?php
echo $_SERVER['REQUEST_URI']."---".$_SESSION['sess_visitors_email'];
?>-->
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
		
	/* 	if($('#visitors_emailid').val() == ''){
			$('#visitors_emailid').focus();			
			sweetAlert("Please enter email.", "", "error");
			return false;
		}
		if (!ValidateEmail($('#visitors_emailid').val())) {
			$('#visitors_emailid').focus();			
			sweetAlert("Please enter valid email.", "What’s the E-mail?", "error");
			return false;
		} */
		
		//swal("Done", "", "success");
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
            <div class="mid mobile-mid">
                <strong>A journey Of A Superkid is the most innovative personalized storybook (design and printed) uniquely for each kid based on his/her NAME.</strong>                
            </div>
			<div class="mid" id="createbook">
				<div class="hm_bk2img1"><img src="<?php echo get_template_directory_uri(); ?>/images/hmleft.png" alt=""/></div>
				<h3>Know the Magical Story behind your Kid's Name</h3>
				<form name="homepageform" class="homepageform" action="" method="get">
				    <input type="hidden" name="campaign" value="<?php echo $campaign;?>">
                    <?php if(isset($_REQUEST['rakhi'])){ ?>
                        <input type="hidden" name="rakhi" value="1" />
                    <?php } ?>
					<!-- <div class="inputbox">
						<input onfocus="if (this.value == 'What’s the name?') { this.value='';} " onblur="if (this.value == '') { this.value='What’s the name?'; }" value="What’s the name?" type="text" class="fname" name="bu_name" maxlength="14" /><div id="charNum"></div>
					</div> -->
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
							<input type="text" placeholder="Enter Your Kid's Date of Birth" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your Kid\'s Date of Birth'" class="" id="datepicker" name="visitors_dob" maxlength="40" /><div id=""></div>
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
            <div class="mid mobile-mid">
                <p>The storybook contains a magical journey having your kid as the main character of the story who discovers the hidden SUPER POWERS (positive value/good habits traits) and becomes a SUPERKID.</p>
            </div>
		</div>
	</div> 
</div>

<div class="certificate-img">
	<img src="<?php echo get_template_directory_uri(); ?>/images/CERTIFICATE-arradhya.jpg" alt="">
    <p>The special certificate accompanied the book lists all the alphabets of kid’s name with corresponding positive qualities in one place which can be framed and put on the wall. It helps the kid in imbibing those positive qualities by visualization. </p>
</div>
<?php /* 
	<h2>A Sample Book</h2>
		<div class="">
	<div class="flipbook-bg">
	<div id="flipbook">
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-frnt.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/vedansh105823_boy_certificate.jpg" alt="" />
		</div>	
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/vedansh503757_prologue.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/welcome.jpg"/>
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-openingscene.jpg"/>
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-opening-scene-02.jpg"/>
		</div>		
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-VERSATILE-01.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-VERSATILE-02.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-energetic-01.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-energetic-02.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-discipline-01.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-discipline-02.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-adventurousv2.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-adventurousv2-02.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-noble-01.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-noble-02.jpg" alt="Vedansh" title="Vedansh" /> 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-STRONG-01.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-STRONG-02.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-honest01.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-honest02.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-ENDING-01.jpg" alt="" /> 		 
		</div>
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/vedansh556061_enging_boy.jpg" alt="" />		 
		</div>			
		<div class="slide">
			<img src="<?php echo get_template_directory_uri(); ?>/images/sample/boy-COVER-BACK.jpg"/>
		</div>
	</div>
</div>
	</div>
	<div class="cntwrap">
		<div class="leftimg"><img src="<?php echo get_template_directory_uri(); ?>/images/block3.png" alt=""/></div>
		<div class="right-cnt">
			<?php the_content(); ?>
			<?php if(get_field('buy_now_link')){ ?><a class="buylink" href="<?php echo get_field('buy_now_link'); ?>">Buy now</a><?php } ?>
		</div>
	</div>*/ ?>
	
<?php endwhile; endif; ?>
<div class="hm_blk3">
<div class="testimonialwrap">
<h2 class="testimain-title">Super Moments of Super Parents</h2>
<?php 
	query_posts( array( 'post_type' => 'testimonials', 'showposts' => -1,'meta_query' => array(
					array('key' => 'show_on','value' => 'home','compare' => '==')), 'orderby' => 'date', 'order' => 'DESC' ) ); 
	if ( have_posts() ) :  
?>
  <ul class="testi-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<li>
			<div class="testi-cnt">
				<p><?php echo wp_trim_words(get_the_content(),40,'...'); ?></p>
				<span class="testi-title"><?php the_title(); ?><?php if(get_field('location') != "") { ?>, <?php echo get_field('location'); ?><?php } ?></span>
			</div>
		</li>
	<?php endwhile; ?>
  </ul>
<?php endif; wp_reset_query(); ?>
</div>

</div>

<?php if(isset($_GET['kidname']) && $_GET['kidname'] != ''){ ?>
<div class="popupparent homepopup">
	<span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a>
	<div style="text-align: center; line-height: 20px; margin-bottom: 10px; ">
		<h3>Please select <?php echo ucfirst(strtolower(trim($_GET['kidname']))); ?>'s gender.</h3>
	</div>
	<form style="width:100%" id="trydiffname" name="trydiffname" action="" method="get">
		<ul class="frst_frm">
			<li>
				<input class="txt_flip" placeholder="Name" id="bu_name" name="bu_name" value="<?php echo ucfirst(strtolower(trim($_GET['kidname']))); ?>" maxlength="13" type="text">
			</li>
			<li class="genderli">
				<div class="nw_fld">
					<div class="rd_dv">
						<label class="active"><input type="radio" name="bu_gender" value="Boy" class="rd_btn" checked="checked" />Boy</label>
						<label class="grl"><input type="radio" name="bu_gender" value="Girl" class="rd_btn" />Girl</label>
					</div>
					
				</div>
			</li>
			<li>
				<a href="javascript:void(0)" class="a_cnt" id="tryfiffcontinue">OK</a>
			</li>
		</ul>
		<input name="skidurl" value="<?php echo site_url(); ?>" type="hidden" />
	</form>
	</div>
</div>
<?php } ?>
<script>
  function countChar(val) {
	var len = val.value.length;
	if (len >= 12) {
	  val.value = val.value.substring(0, 12);
	} else {
		alert(len);
	}
  };
  function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	
	jQuery(document).ready(function($){
		$('#tryfiffcontinue').click(function(){
			if($('#bu_name').val() == ''){
				$('#bu_name').focus();			
				sweetAlert("Please enter name.", "", "error");
				return false;
			}			
			$("#trydiffname").submit();
			return true;
		});	
		
		$('.a_cls').click(function() {
			$(".popupparent").fadeOut();
	});
	$("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
		dateFormat: "dd/mm/yy",
    });
});	
</script>
<?php get_footer(); ?>