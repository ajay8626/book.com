<?php 
	global $wpdb;
	/* $dir = plugin_dir_path( __FILE__ );	
	function similiar_words($Whole_word,$gender){
		global $wpdb,$err;
		
		$static_word1=str_split(strtoupper($Whole_word));
		$data_library=array();
		$meaning=array();
		$used=array();
		$checked=array();
		
		$page_orderleftpriority=array();
		$$page_ids=array();
		$page_orderrightpriority=array();
		$static_word=array_unique($static_word1);
		
		foreach($static_word as $static){
			$query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$static."%' and gender='".$gender."' order by priority";
			$words = $wpdb->get_results( $query );
			
			foreach($words as $word){
				if($word->page_order == 'L'){
					$data_library[$static][]=$word->virtue;
					
				}
			} 
		}
		
		$ignore_query = "SELECT * FROM `wp_words_ignore` ";
		$ignore_words = $wpdb->get_results( $ignore_query );
		foreach($ignore_words  as $ignore_word){
			$str =$ignore_word->similiar_words;
			$str_splode = explode(',',$str);
			$combos[] = showCombo(array(), $str_splode);
			
		}
		
		foreach($combos as $key=>$array){
			$all_list=displayArrayByKey($key, $array);
			foreach($all_list as $k=>$a){
				$similiar[$k]=$a;
			}
		} 
		
		foreach($static_word1 as $static){
			if($data_library[$static][0] !=''){
				$wr=$data_library[$static][0];
				if(count($used) ==0){
					$meaning[]=$static.'-'.$wr;
					$used[]=$wr;
				}
				else{
					foreach($used as $use){
						if(isset($similiar[$use])){
							if(in_array($wr,$similiar[$use]) && !in_array($wr,$checked)){
								$name = $data_library[$static][0];
								array_push($checked,$name);
								array_push($data_library[$static],$name);
								array_shift($data_library[$static]);
							}
						}
					}
					$meaning[]=$static.'-'.$data_library[$static][0];
					$used[]=$data_library[$static][0];
				}
				
				$name = $data_library[$static][0];
				array_push($data_library[$static],$name);
				array_shift($data_library[$static]);
			}
			
		}
		foreach($meaning as $mean){
			$single_word=explode('-',$mean);
			$single_query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$single_word[1]."' and gender='".$gender."' order by priority";
			$singlewords = $wpdb->get_results( $single_query );
			foreach($singlewords as $singleword){
				$other_data[]=$singleword->id;
			}
			
		}
		$all_data_array=array('initial'=>$meaning,'other_data'=>$other_data);
		
		return $all_data_array;
	}
	
	
	function showCombo($str_arr, $arr){
		$ret = array();
		foreach($arr as $val){
			if(!in_array($val, $str_arr)){
				$temp = $str_arr;
				$temp[] = $val;
				$ret[$val] = showCombo($temp, $arr);
			}
		}
		return $ret;
	}
	function displayArrayByKey($str, $arr){
		foreach($arr as $key=>$array){
			if(!empty($array)){
				$list[$key]=array_keys($array);
			}
			if(count($array)> 0){
				displayArrayByKey($string, $array);
			}
		}
		return $list;
		
	}
	
	
	if(isset($_REQUEST['submit'])) {
		
		$result = array();
		$characterset = array();
		if(isset($_REQUEST['bu_name'])){
			$err = 0;
			if(strlen($_REQUEST['bu_name']) <= 12){
				
				$gender = isset($_REQUEST['bu_gender'])?$_REQUEST['bu_gender']:'0';
				$bu_name_str = $_REQUEST['bu_name'];
				$bu_name_arr = str_split(strtoupper($bu_name_str));
				$bu_name= implode("','",$bu_name_arr);
				
				
				$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name') AND gender = '$gender' ORDER BY priority, FIELD(alphabet, '$bu_name')";
				
				$result = $wpdb->get_results($sql);
				if(!empty($result)){
					foreach($result as $res){
						$characterset[$res->alphabet][$res->priority.$res->page_order] = $res->id;
					}
				}
				$resultval = array();
				$resultvalR = array();
				$result = array();
				$priority = array();
				foreach($bu_name_arr as $bun){
					if(isset($characterset[$bun])){
						if(!isset($priority[$bun])){
							$occ = 1;
							
							}else{
							$occ = $priority[$bun] + 1;
							$total = count($characterset[$bun])/2;
							if($occ > $total){
								$occ = 1;
								$err = 1;
							}
							
						}
						$priority[$bun] = $occ;
						
						$resultval = $characterset[$bun][$occ.'L'];
						$resultvalR = $characterset[$bun][$occ.'R'];
						$result[] = $resultval;
						$result[] = $resultvalR;
						}else{
						$err = 2;
					}
				}
				
				if(empty($resultval)){
					$err = 3;
				}
				}else{
				$err = 4;
			}
		}
		
		if (ctype_alpha(str_replace('', '', $_REQUEST['bu_name'])) === false)
		{
			$err = 5;
		}
		
		$data_result=similiar_words($bu_name_str,$gender);
		$result=$data_result['other_data']; 
		
		
		$certi_arr = array();
		if(!empty($result) && $err == 0){
			foreach($result as $res1){
				$sql = "SELECT alphabet,virtue,page_order,gender,virtue_code,priority FROM `wp_book_virtue` WHERE id = $res1";
				$resVirtue = $wpdb->get_results($sql);
				foreach($resVirtue as $virtue){
					
					if($virtue->page_order == 'L'){
						$certi_arr[] = array($virtue->alphabet,$virtue->virtue,$virtue->virtue_code,$virtue->gender,$virtue->priority);
					}
				}
			}
		}	
		header('Location: admin.php?page=docpdf&bu_name='.$_REQUEST['bu_name'].'&bu_gender='.$_REQUEST['bu_gender']);
		exit();
	} */
?>
<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Check meaning of kid's name</h2>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				
				<div class="option">
					<form name="bookvirtueform" action="admin.php?page=docpdf" method="post" enctype="multipart/form-data">
						<input type="hidden" name="page" value="getCertiPdf" />					
						<table class="form-table virtue-table">
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="bu_name">Enter Name</label></th>
								<td><input type="text" id="bu_name" name="bu_name" value="" class="regular-text" required /></td>
							</tr>
							
							
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="boy">Select Gender</label></th>
								<td>
									<fieldset>
										<legend class="screen-reader-text"><span>Select Gender</span></legend>
										<label for="boy"><input name="bu_gender" type="radio" id="boy" value="0">Boy</label>
									</fieldset>
									<fieldset>
										<label for="girl"><input name="bu_gender" type="radio" id="girl" value="1">Girl</label>
									</fieldset>
								</td>
							</tr>
							
							<tr class="user-rich-editing-wrap">
								<td scope="row" colspan="2">
									<center><h2>Enter comma saperated Alphabet-Meaning to generate custom pdf <br>(eg. A-ADVENTUROUS,B-BRAVE,C-COURAGEOUS)</h2></center>
								</td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="bu_name">Alphabet-Meaning</label></th>
								<td><textarea id="arr_name" name="arr_name" class="regular-text" style="height: 150px;"></textarea></td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit"></p>
						
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>