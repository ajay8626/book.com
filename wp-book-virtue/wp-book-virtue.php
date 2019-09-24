<?php
/*
Plugin Name: Book Virtue
Description: Book Virtue
Version: 1.1
Author: Vivek
*/

function virtue_list_function() {
    include('bookvirtue.php');  
}

function wp_book_virtue_admin() {
    include('virtue_list.php');  
}

function wp_book_virtue_cover_boy_admin() {
    include('virtue_cover_boy.php');  
}

function wp_book_virtue_prologue_admin() {
    include('prologue.php');  
}

function wp_book_virtue_cover_girl_admin() {
    include('virtue_cover_girl.php');  
}

function wp_chk_name_admin() {    
	include('check-name.php');
}

function wp_book_upload_photo_admin() {
    include('upload_photo.php');  
}

function wp_order_export_admin() {
    include('order_export.php');  
}

function wp_csv_export_admin() {
    include('csv_export.php');  
}
function wp_getCertiPdf_admin() {
    include('getCertiPdf.php');
}
function wp_docpdf_admin() {
    include('docpdf.php');
}

function wp_express_order_export_admin() {
    include('express_order_export.php');  
}
function wp_express_csv_export_admin() {
    include('express_csv_export.php');  
}
function wp_endCertiPdf_admin() {
    include('endCertiPdf.php');
}

function wp_enddocpdf_admin() {
    include('enddocpdf.php');
}
function wp_prologueCertiPdf_admin() {
    include('prologueCertipdf.php');
}
function wp_mergepdf_admin() {
    include('front_page_pdf.php');
}
function wp_prologuedocpdf_admin() {
    include('prologuedocpdf.php');
}
function wp_change_payment_method_admin() {
    include('ordertype.php');
}
function wp_change_paymentlog_admin() {
    include('paymentlog.php');
}
function wp_check_postal_code_admin() {
    include('postalcodechk.php');  
}

function wp_change_page_photo_admin() {
    include('pagephoto.php');
}
function wp_change_order_page_photo_admin() {
    include('orderpagephoto.php');
}
function wp_change_hardboundcover_admin() {
    include('hardboundcover.php');
}
function wp_shipping_delivery_admin() {
    include('shipping_delivery.php');
}
function wp_change_payment_status_admin() {
    include('change_payment_status.php');
}

function wp_change_message_admin() {
    include('change_message.php');
}
function wp_preview_link_admin() {
    include('preview_link.php');
}

function wp_height_chart_admin() {
    include('heightchartimage.php');  
}

function wp_book_virtue_admin_actions()
{

	
	add_menu_page('Book Virtue', 'Book Virtue', 0,'virtue_list','wp_book_virtue_admin'/* , plugin_dir_url( __FILE__ ) . 'booking.png' */ );
	
	add_submenu_page('virtue_list', 'Add Virtue', 'Add Virtue',0,'book_virtue','virtue_list_function' );
	
	add_submenu_page('virtue_list', 'Boy\'s Cover Image', 'Boy\'s Cover Image',0,'virtue_cover_boy','wp_book_virtue_cover_boy_admin' );
	
	add_submenu_page('virtue_list', 'Girl\'s Cover Image', 'Girl\'s Cover Image',0,'virtue_cover_girl','wp_book_virtue_cover_girl_admin' );
	
	add_submenu_page('virtue_list', 'prologue & Back Image', 'prologue & Back Image',0,'prologue','wp_book_virtue_prologue_admin' );
	
	add_submenu_page('virtue_list', 'Check Name', 'Check Name',0,'chk_name','wp_chk_name_admin' );	
	
	add_submenu_page('virtue_list', 'Upload Kid\'sphoto', 'Upload Kid\'sphoto' , 0,'upload_photo','wp_book_upload_photo_admin' );
	
	add_submenu_page('virtue_list', 'Order Export', 'Order Export' , 0,'order_export','wp_order_export_admin' );
	
	add_submenu_page(NULL, 'Export CSV', 'Export CSV' , 0,'csv_export','wp_csv_export_admin' );
	
	add_submenu_page('virtue_list', 'Main Certi PDF', 'Main Certi PDF',0,'getCertiPdf','wp_getCertiPdf_admin' );
	add_submenu_page(NULL, 'docpdf', 'docpdf',0,'docpdf','wp_docpdf_admin' );
	
	add_submenu_page('virtue_list', 'End Certi PDF', 'End Certi PDF',0,'endCertiPdf','wp_endCertiPdf_admin' );
	add_submenu_page(NULL, 'End docpdf', 'End docpdf',0,'enddocpdf','wp_enddocpdf_admin' );
	
	add_submenu_page('virtue_list', 'Prologue Certi PDF', 'Prologue Certi PDF',0,'prologueCertiPdf','wp_prologueCertiPdf_admin' );
	add_submenu_page(NULL, 'End docpdf', 'Prologue docpdf',0,'prologuedocpdf','wp_prologuedocpdf_admin' );
	
	add_submenu_page('virtue_list', 'Express Order Export', 'Express Order Export' , 0,'express_order_export','wp_express_order_export_admin' );
	add_submenu_page(Null, 'Express Export CSV', 'Express Export CSV' , 0,'express_csv_export','wp_express_csv_export_admin' );
	
	add_submenu_page('virtue_list', 'Change Payment Method', 'Change Payment Method' , 0,'change_payment_method','wp_change_payment_method_admin' );

    add_submenu_page('virtue_list', 'Height Chart Image', 'Height Chart Image' , 0,'heightchartimage','wp_height_chart_admin' );
	
	add_submenu_page(Null, 'Check Order Payment Log', 'Check Order Payment Log' , 0,'check_opm_log','wp_change_paymentlog_admin' );
	
	add_submenu_page('virtue_list', 'Allow COD', 'Allow COD' , 0,'restrict_post_code','wp_check_postal_code_admin' );
	
	add_submenu_page('virtue_list', 'Kid\'s Photo', 'Kid\'s Photo' , 0,'kids_photo','wp_change_page_photo_admin' );
	
	add_submenu_page(Null, 'Kid\'s Photo', 'Kid\'s Photo' , 0,'kidsorder_photo','wp_change_order_page_photo_admin' );
	
	add_submenu_page(Null, 'Change Payment Status', 'Change Payment Status' , 0,'change_pay_status','wp_change_payment_status_admin' );
	
	add_submenu_page('virtue_list', 'Change Message', 'Change Message' , 0,'change_message','wp_change_message_admin' );

    add_submenu_page('virtue_list', 'Preview Link', 'Preview Link' , 0,'preview_link','wp_preview_link_admin' );

    add_submenu_page(Null, 'Hard Bound Cover', 'Hard Bound Cover' , 0,'hardboundcover','wp_change_hardboundcover_admin' );

    add_submenu_page(Null, 'Shipping Delivery', 'Shipping Delivery' , 0,'shipping_delivery','wp_shipping_delivery_admin' );

    add_submenu_page(NULL, 'front page pdf', 'front page pdf',0,'front_page_pdf','wp_mergepdf_admin' );
	
	
	/*add_submenu_page('book_virtue', 'Add Virtue', 'Add Virtue',0,'add_booking','add_booking_function' ); */
	
	/*add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );*/	
}
add_action( 'admin_menu', 'wp_book_virtue_admin_actions' );

/* upload media */
function wp_book_virtue_admin_scripts()
{	
	//if ($_GET['page'] == 'virtue_list' || $_GET['page'] == 'book_virtue' || $_GET['page'] == 'virtue_cover_boy' || $_GET['page'] == 'virtue_cover_girl' || $_GET['page'] == 'prologue' || $_GET['page'] == 'kidsorder_photo' || $_GET['page'] == 'hardboundcover' || $_GET['page'] == 'shipping_delivery' || $_GET['page'] == 'heightchartimage')
	//{
		//wp_register_script('jquery_min', plugins_url().'/wp-book-virtue/js/jquery.min.js');
		//wp_enqueue_script('jquery_min');
		wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('my-upload', plugins_url('js/wp-media-upload.js',__FILE__ ), array('jquery','media-upload','thickbox'));
        wp_enqueue_script('my-upload');
        wp_register_script('Jcrop_js', plugins_url('js/jquery.Jcrop.min.js',__FILE__ ), array('jquery'));
		wp_enqueue_script('jquery.Jcrop.min');
	//}	
}
function wp_book_virtue_admin_styles()
{	
	//if ($_GET['page'] == 'virtue_list' || $_GET['page'] == 'book_virtue' || $_GET['page'] == 'virtue_cover_boy' || $_GET['page'] == 'virtue_cover_girl' || $_GET['page'] == 'prologue' || $_GET['page'] == 'kidsorder_photo' || $_GET['page'] == 'hardboundcover' || $_GET['page'] == 'shipping_delivery'  || $_GET['page'] == 'heightchartimage')
	//{	
		wp_register_style('jquery_ui', plugins_url().'/wp-book-virtue/css/jquery-ui.min.css');
		wp_enqueue_style('jquery_ui');	
        wp_enqueue_style('thickbox');
        
	//}
	
}
add_action('admin_print_scripts', 'wp_book_virtue_admin_scripts');
add_action('admin_print_styles', 'wp_book_virtue_admin_styles');








/*Pagination*/


function pagination($query,$per_page=10,$page=1,$url='?'){   
	global $wpdb;
    $query = "SELECT COUNT(*) as `num` FROM $query";
    $row = $wpdb->get_results($query);
    $total = $row[0]->num;
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}pn={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}pn={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pn={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}pn={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}pn={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}pn=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}pn=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pn={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}pn={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}pn={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}pn=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}pn=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}pn={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}pn={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}pn=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
}
?>