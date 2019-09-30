<?php
/**
* Template Name: Ignored Words Algo
*
*/
get_header(); 
 $schedule = wp_get_schedule( 'change_woo_order_status_hook' );
echo 'sfsd-'.$schedule;
/* $Whole_word='bina';
$page_order='L';
$gender=1;
$jumbled_words=array();
$jumbled_words = similiar_words($Whole_word,$gender);
echo 'Jumbled Words <pre>';
print_r($jumbled_words);
echo '</pre>';
function similiar_words($Whole_word,$gender){
global $wpdb;
$static_word1=str_split($Whole_word);
$data_library=array();
$meaning=array();
$used=array();
$checked=array();

$page_orderleftpriority=array();
$page_orderrightpriority=array();
$static_word=array_unique($static_word1);

// word library
foreach($static_word as $static){
	$query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$static."%' and gender='".$gender."' order by priority";
	$words = $wpdb->get_results( $query );
	
	foreach($words as $word){
		if($word->page_order == 'L'){
			$data_library[$static][]=$word->virtue;
			$page_orderleftpriority[$static]=$word->page_order.$word->priority;
			
		}
		else{
			$page_orderrightpriority[$static]=$word->page_order.$word->priority;
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

return $meaning;

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
        // $string =  "+" . $key;
       //  echo $string . '<br/>'; 
          if(count($array)> 0){

              displayArrayByKey($string, $array);
          }
    }
	return $list;

}
 */

 get_footer(); ?>