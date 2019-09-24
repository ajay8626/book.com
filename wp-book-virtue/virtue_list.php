<?php global $wpdb; session_start();$_SESSION['msg'] = "";$msg = "";if(isset($_POST['deletesubmit']) && isset($_POST['deletevirtue'])){	$deleteIds = $_POST['deletevirtue'];	if(!empty($deleteIds)){		foreach($deleteIds as $id){			$wpdb->delete( 'wp_book_virtue', array( 'id' => $id ) );		}		$msg = "Virtue removed successfully.";	}}$page = (int)(!isset($_GET["pn"]) ? 1 : $_GET["pn"]);$filtergender = (!isset($_POST["filtergender"]) ? '' : $_POST["filtergender"]);$filteralpha = (!isset($_POST["filteralphabate"]) ? '' : $_POST["filteralphabate"]);$where = '';if(($filtergender != '' && ($filtergender == 0 || $filtergender == 1)) || $filteralpha != ''){	wp_redirect('admin.php?page=virtue_list&alphabet='.$filteralpha.'&gender='.$filtergender);	//$where = " AND gender='".$filtergender."'";}$getgender = (!isset($_GET["gender"]) ? '' : $_GET["gender"]);$getalphabet = (!isset($_GET["alphabet"]) ? '' : $_GET["alphabet"]);$where = '';if($getgender != '' && ($getgender == 0 || $getgender == 1)){	$where .= " AND gender='".$getgender."'";}if($getalphabet != '' ){	$where .= " AND alphabet LIKE '".$getalphabet."'";}if ($page <= 0) $page = 1;$per_page = 16;$startpoint = ($page * $per_page) - $per_page;$statement = "wp_book_virtue WHERE 1 $where ORDER BY alphabet,priority ASC";$results = $wpdb->get_results("SELECT * FROM $statement LIMIT $startpoint , $per_page");?><div role="main" id="wpbody">	<div id="wpbody-content" aria-label="Main content" tabindex="0">				<div class="wrap">			<h1 class="wp-heading-inline">Virtues</h1>			<a href="admin.php?page=book_virtue" class="page-title-action">Add New</a>			<br>			<form name="filterform" class="filterform" action="" method="POST">			<strong>Filter</strong>			<br>			<select name="filteralphabate"><option value="">Select Aplhabet</option>				<option value="A" <?php if($getalphabet == 'A'){ ?>selected<?php } ?> >A</option><option value="B" <?php if($getalphabet == 'B'){ ?>selected<?php } ?>>B</option>				<option value="C" <?php if($getalphabet == 'C'){ ?>selected<?php } ?> >C</option><option value="D" <?php if($getalphabet == 'D'){ ?>selected<?php } ?>>D</option>				<option value="E" <?php if($getalphabet == 'E'){ ?>selected<?php } ?> >E</option><option value="F" <?php if($getalphabet == 'F'){ ?>selected<?php } ?>>F</option>				<option value="G" <?php if($getalphabet == 'G'){ ?>selected<?php } ?> >G</option><option value="H" <?php if($getalphabet == 'H'){ ?>selected<?php } ?>>H</option>				<option value="I" <?php if($getalphabet == 'I'){ ?>selected<?php } ?> >I</option><option value="J" <?php if($getalphabet == 'J'){ ?>selected<?php } ?>>J</option>				<option value="K" <?php if($getalphabet == 'K'){ ?>selected<?php } ?> >K</option><option value="L" <?php if($getalphabet == 'L'){ ?>selected<?php } ?>>L</option>				<option value="M" <?php if($getalphabet == 'M'){ ?>selected<?php } ?> >M</option><option value="N" <?php if($getalphabet == 'N'){ ?>selected<?php } ?>>N</option>				<option value="O" <?php if($getalphabet == 'O'){ ?>selected<?php } ?> >O</option><option value="P" <?php if($getalphabet == 'P'){ ?>selected<?php } ?>>P</option>				<option value="Q" <?php if($getalphabet == 'Q'){ ?>selected<?php } ?> >Q</option><option value="R" <?php if($getalphabet == 'R'){ ?>selected<?php } ?>>R</option>				<option value="S" <?php if($getalphabet == 'S'){ ?>selected<?php } ?> >S</option><option value="T" <?php if($getalphabet == 'T'){ ?>selected<?php } ?>>T</option>				<option value="U" <?php if($getalphabet == 'U'){ ?>selected<?php } ?> >U</option><option value="V" <?php if($getalphabet == 'V'){ ?>selected<?php } ?>>V</option>				<option value="W" <?php if($getalphabet == 'W'){ ?>selected<?php } ?> >W</option><option value="X" <?php if($getalphabet == 'X'){ ?>selected<?php } ?>>X</option>				<option value="Y" <?php if($getalphabet == 'Y'){ ?>selected<?php } ?> >Y</option><option value="Z" <?php if($getalphabet == 'Z'){ ?>selected<?php } ?>>Z</option>			</select>			<select name="filtergender"><option value="">Select Gender</option><option value="0" <?php if($getgender == '0'){ ?>selected<?php } ?>>Boy</option><option value="1" <?php if($getgender == '1'){ ?>selected<?php } ?>>Girl</option></select>			<input type="submit" name="filtersubmit" class="button button-primary" value="Filter">			</form>			<form id="virtuelistform" name="virtuelistform" action="" method="post">				<p class="submit">Select checkbox to and click on delete to remove virtue.<br><br><input type="submit" name="deletesubmit" id="submit" class="button button-primary" value="Delete"></p>				<p><?php echo $msg; ?></p>				<table class="wp-list-table widefat fixed striped posts">					<thead>						<tr>							<td id="cb" class="manage-column column-cb check-column">								<label class="screen-reader-text" for="checkAll">Select All</label>								<input id="checkAll" type="checkbox" />							</td>							<th scope="col" id="Image" class="manage-column">Image</th>							<th scope="col" id="Virtue" class="manage-column">Virtue</th>							<th scope="col" id="title" class="manage-column">Alphabet</th>							<th scope="col" id="Priority" class="manage-column">Priority</th>							<th scope="col" id="Priority" class="manage-column">Page Position</th>							<th scope="col" id="date" class="manage-column"><span>Gender</span></th>							<th scope="col" id="Code" class="manage-column">Code</th>						</tr>					</thead>					<tbody id="the-list">						<?php 						if (!empty($results)) {	     							// displaying records.							foreach($results as $row){																$virtue_id 	 = $row->id;								$alphabet 	 = $row->alphabet;								$virtueimage = $row->image;								$virtue 	 = $row->virtue;								$priority 	 = $row->priority;								$page_order  = $row->page_order;								$code 		 = $row->virtue_code;								$gender 	 = $row->gender;							?>							<tr>								<td><input type="checkbox" name="deletevirtue[]" value="<?php echo $virtue_id; ?>"/></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php if($virtueimage != ''){ ?><img id="imgadd" src="<?php echo $virtueimage; ?>" alt="Virtue Image" style="width:100px"/><?php } ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php echo $virtue; ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php echo $alphabet; ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php echo $priority; ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php if($page_order == 'L') { echo '1st Page'; }else{ echo '2nd Page'; } ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php if($gender == 0){ echo "Boy"; }else{ echo "Girl"; } ?></a></td>								<td><a href="<?php echo 'admin.php?page=book_virtue&virtue_id='.$virtue_id; ?>"><?php echo $code; ?></a></td>							</tr>							<?php } ?>						<?php }else{?>							<tr class="no-items"><td class="colspanchange" colspan="7">No virtue found.</td></tr>						<?php } ?>					</tbody>				</table>			</form>		</div>		<div class="clear"></div>	</div></div><?php  // displaying paginaiton.if($getgender == 0 || $getgender == 1){	echo pagination($statement,$per_page,$page,$url='admin.php?page=virtue_list&alphabet='.$getalphabet.'&gender='.$getgender.'&');}else{	echo pagination($statement,$per_page,$page,$url='admin.php?page=virtue_list&');}?><script>jQuery("document").ready(function($){	$("#checkAll").click(function(){		$('input:checkbox').not(this).prop('checked', this.checked);	});	$("#virtuelistform").submit(function(){		if(confirm("Are you sure?")) {			return true;		}		return false;	});});</script>