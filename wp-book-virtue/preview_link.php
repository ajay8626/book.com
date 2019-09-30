<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<?php
global $wpdb;
if(isset($_POST['submit'])){
	$kname = isset($_POST['kids_name'])?$_POST['kids_name']:"";
	$gender = isset($_POST['gender'])?$_POST['gender']:"";
	$nameAttribute = isset($_POST['name_attribute'])?$_POST['name_attribute']:"";
	$data = array('kids_name' => $kname, 'gender' => $gender, 'name_attribute' => $nameAttribute, 'created_on' => date('Y-m-d H:i:s'));
	if($wpdb->insert('wp_preview_pages',$data)){
		$query = "SELECT id FROM `wp_preview_pages` ORDER BY `id` DESC LIMIT 0,1";
	    $result = $wpdb->get_results($query);
	    $id = $result[0]->id;
	    $site_url =  site_url().'/demo'.'?succ='.$id;
      $data = $wpdb->update('wp_preview_pages', array( 'site_url' => $site_url),array('id'=>$id));
      if ($data) {
        echo "successs";
      }else{
        echo "error";
      }
      
	}
}
?>
<body>

<div class="container">
  <form name="preview_form" action="" method="post">
  <fieldset class="block">
	<legend>Preview Form</legend>
    <div class="form-group">
        <label for="text">Kid's Name :</label>
        <input type="text" class="form-control" name="kids_name" placeholder="Enter Kids Name" required="required">
    </div>
    <div class="form-group">
        <label class="control-label">Gender : </label>
		<div class="form-check form-check-inline">
		    <input class="form-check-input" id="boy" type="radio" name="gender" value="boy" required="required">
		    <label class="form-check-label" for="boy">Boy</label>
		</div>
		<div class="form-check form-check-inline">
		    <input class="form-check-input" id="girl" type="radio" name="gender" value="girl" required="required">
		    <label class="form-check-label" for="girl">Girl</label>
		</div><br>
		</div>

    <div class="form-group">
        <strong>[Enter comma saperated Alphabet-Meaning to generate custom link 
      (eg. A - ADVENTUROUS,B - BRAVE,C - COURAGEOUS)]</strong>
    </div>
    <div class="form-group">
        <label for="text">Name Attribute :</label>
        <textarea class="form-control" name="name_attribute" placeholder="Name Attribute" required="required"></textarea>
    </div>
    <div class="form-group">
		<input type="submit" class="btn btn-primary" name="submit" value="Submit" />
	</div>
	</fieldset>
  </form>
  <hr>
</div>

<?php
$previewTable = $wpdb->prefix.'preview_pages';
$previewData = $wpdb->get_results("SELECT * FROM `$previewTable`");
?>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Attribute</th>
      <th>Link</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $number = 1;
    foreach($previewData as $previewDataKey => $previewDataVal){  ?>
      <tr>
        <td><?php echo $number; ?></td>
        <td><?php echo $previewDataVal->kids_name; ?></td>
        <td><?php echo $previewDataVal->name_attribute; ?></td>
        <td>
          <a href="<?php echo $previewDataVal->site_url; ?>" target="_blank">Page Link</a>
        </td>
      </tr>
    <?php $number++;
    } ?>
  </tbody>
</table>

<style>
fieldset.block {
    border: 5px solid #1F497D!important;
    background: #eee!important;
    border-radius: 5px!important;
    padding: 15px!important;
}
</style>
