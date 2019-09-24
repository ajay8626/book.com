<?php 
global $wpdb;
$certi_arr = array();
	
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
		
		// word library
		foreach($static_word as $static){
			$query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$static."%' and gender='".$gender."' order by priority";
			$words = $wpdb->get_results( $query );
			
			foreach($words as $word){
				if($word->page_order == 'L'){
					$data_library[$static][]=$word->virtue;
					
				}
			} 
		}
		
		// smiliar words library
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
		//logic for the combination 
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
	
	// for combination
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
	
	$certi_name = '';
	$order_id = '';
	if(isset($_REQUEST['bu_name'])) {
		
		$result = array();
		$characterset = array();
		if(isset($_REQUEST['bu_name'])){
			$err = 0;
			$certi_name = $_REQUEST['bu_name'];
			$order_id = isset($_REQUEST['order_id'])?$_REQUEST['order_id']:'';
			if(strlen($_REQUEST['bu_name']) <= 12){
				
				$bu_gender = isset($_REQUEST['bu_gender'])?$_REQUEST['bu_gender']:'Boy';
				if($bu_gender == 'Boy' || $bu_gender == '0'){
					$gender = '0';
				}else{
					$gender = '1';					
				}
				
				$arr_name = isset($_REQUEST['arr_name'])?$_REQUEST['arr_name']:'';
				if($arr_name != ''){
					$new_arr = explode(',',$arr_name);
					if(!empty($new_arr)){
						foreach($new_arr as $val){
							$certi_arr[] = explode('-',$val);
						}
					}
				}else{
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
				}
			}else{
				$err = 4;
			}
		}
		
		//$gender_new = $_REQUEST['bu_name'];
		if (ctype_alpha(str_replace('', '', $_REQUEST['bu_name'])) === false)
		{
			$err = 5;
		}
		
		$data_result=similiar_words($bu_name_str,$gender);
		$result=$data_result['other_data']; 
		
		
		if(empty($certi_arr)){
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
		}
	}
	
$dir = plugin_dir_path( __FILE__ );	
	if(!empty($certi_arr)) {
		ob_clean(); 
		require($dir.'fpdf/fpdf.php');
		$kidsname = $certi_name;
		$length = strlen($kidsname);
		$Heading_X = getHeadingXDimension($length);
		$meaning = getMeaningDimension($length);

		$Heading_Y = 91;
		$Line_X = 54.23;
		$topLine_Y = 138;
		$nameFirstChar_X = 78;
		$meaningDash_X = 95.51;
		$meaning_X = 109;
		$meaning_Y = $meaning['meaning_Y'];
		$dashPos = $meaning['dashPos'];
		$pdf = new FPDF('p','mm',array(250,371.73));
		$pdf->Addpage();
		$pdf->AddFont('KelmscottRegular','','KelmscottRegular.php');
		$pdf->AddFont('TrajanBold','','TrajanBold.php');		
		$pdf->SetFont('KelmscottRegular','',50);
		$pdf->SetXY($Heading_X,$Heading_Y);
		$pdf->Write(5,trim(ucfirst(strtolower($kidsname))));
		$pdf->SetXY($Line_X,$topLine_Y);
		$pdf->Image($dir.'getpdf/top-line.png',null,null,145.52,null);
		foreach($certi_arr as $kname){
			$pdf->SetXY($nameFirstChar_X,$meaning_Y);
			$pdf->SetFont('KelmscottRegular','',$meaning['singleFontSize']);
			$pdf->Write(8,$kname[0]);
			$pdf->SetXY($meaningDash_X,$meaning_Y);
			$pdf->SetFont('KelmscottRegular','',$meaning['dashFontSize']);
			$pdf->Image($dir.'getpdf/dot.png',null,$dashPos,5,null);
			$pdf->SetXY($meaning_X,$meaning_Y);
			$pdf->SetFont('KelmscottRegular','',$meaning['meaningFontSize']);
			$pdf->Write(8,trim(ucfirst(strtolower($kname[1]))));
			$meaning_Y = $meaning_Y + $meaning['gap'];
			$dashPos = $dashPos + $meaning['gap'];
		}
		$pdf->SetXY($Line_X,$meaning_Y+$meaning['Line_Y']);
		$pdf->Image($dir.'getpdf/bottom-line.png',null,null,145.52,null);
		$pdf->Output($order_id.'_'.$certi_name.'_certi.pdf',D);
	}
	
	
	function getHeadingXDimension($length = 0){
		$x = 0;
		if($length != '' && $length != 0){
			
			switch($length){
				case 3:
					$x = 111;
					break;
				case 4:
					$x = 107;
					break;
				case 5:
					$x = 100;
					break;
				case 6:
					$x = 97;
					break;
				case 7:
					$x = 92;
					break;
				case 8:
					$x = 89;
					break;
				case 9:
					$x = 83;
					break;
				case 10:
					$x = 85;
					break;
				case 11:
					$x = 80;
					break;
				case 12:
					$x = 77;
					break;				
			}
		}
		return $x;
	}
	
	function getMeaningDimension($length = 0){		
		$meaning = array();
		$meaning['singleFontSize'] = 26;
		$meaning['dashFontSize'] = 18;
		$meaning['meaningFontSize'] = 26;
		$meaning['dashPos'] = 147;
		$meaning['meaning_Y'] = 145;
		$meaning['gap'] = 12;
		$meaning['Line_Y'] = 12;
		if($length != '' && $length != 0){
			switch($length){
				case 3:
					$meaning['singleFontSize'] = 36;
					$meaning['dashFontSize'] = 22;
					$meaning['meaningFontSize'] = 36;
					$meaning['dashPos'] = 150;
					$meaning['meaning_Y'] = 148;
					$meaning['gap'] = 18;
					$meaning['Line_Y'] = -2;
					break;
				case 4:
					$meaning['singleFontSize'] = 36;
					$meaning['dashFontSize'] = 22;
					$meaning['meaningFontSize'] = 36;
					$meaning['dashPos'] = 150;
					$meaning['meaning_Y'] = 148;
					$meaning['gap'] = 18;
					$meaning['Line_Y'] = -2;
					break;
				case 5:
					$meaning['singleFontSize'] = 36;
					$meaning['dashFontSize'] = 22;
					$meaning['meaningFontSize'] = 36;
					$meaning['dashPos'] = 150;
					$meaning['meaning_Y'] = 148;
					$meaning['gap'] = 18;
					$meaning['Line_Y'] = -2;
					break;
				case 6:
					$meaning['singleFontSize'] = 36;
					$meaning['dashFontSize'] = 22;
					$meaning['meaningFontSize'] = 36;
					$meaning['dashPos'] = 150;
					$meaning['meaning_Y'] = 148;
					$meaning['gap'] = 18;
					$meaning['Line_Y'] = -2;
					break;
				case 7:
					$meaning['singleFontSize'] = 34;
					$meaning['dashFontSize'] = 20;
					$meaning['meaningFontSize'] = 34;
					$meaning['dashPos'] = 150;
					$meaning['meaning_Y'] = 148;
					$meaning['gap'] = 16;
					$meaning['Line_Y'] = -2;
					break;
				case 8:
					$meaning['singleFontSize'] = 26;
					$meaning['dashFontSize'] = 18;
					$meaning['meaningFontSize'] = 26;
					$meaning['dashPos'] = 147;
					$meaning['meaning_Y'] = 145;
					$meaning['gap'] = 12;
					$meaning['Line_Y'] = 0;
					break;
				case 9:
					$meaning['singleFontSize'] = 26;
					$meaning['dashFontSize'] = 18;
					$meaning['meaningFontSize'] = 26;
					$meaning['dashPos'] = 147;
					$meaning['meaning_Y'] = 145;
					$meaning['gap'] = 12;
					$meaning['Line_Y'] = 0;
					break;
				case 10:
					$meaning['singleFontSize'] = 22;
					$meaning['dashFontSize'] = 14;
					$meaning['meaningFontSize'] = 22;
					$meaning['dashPos'] = 147;
					$meaning['meaning_Y'] = 145;
					$meaning['gap'] = 10;
					$meaning['Line_Y'] = 0;
					break;
				case 11:
					$meaning['singleFontSize'] = 22;
					$meaning['dashFontSize'] = 14;
					$meaning['meaningFontSize'] = 22;
					$meaning['dashPos'] = 147;
					$meaning['meaning_Y'] = 145;
					$meaning['gap'] = 10;
					$meaning['Line_Y'] = 0;
					break;
				case 12:
					$meaning['singleFontSize'] = 19;
					$meaning['dashFontSize'] = 12;
					$meaning['meaningFontSize'] = 19;
					$meaning['dashPos'] = 147;
					$meaning['meaning_Y'] = 145;
					$meaning['gap'] = 9;
					$meaning['Line_Y'] = 0;
					break;				
			}
		}
		return $meaning;
	}
?>