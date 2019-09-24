jQuery(document).ready(function() {
    var formfield;
    /* user clicks button on custom field, runs below code that opens new window */
    jQuery('.onetarek-upload-button').click(function() {
        formfield = jQuery(this).prev('input'); //The input field that will hold the uploaded file url
        tb_show('','media-upload.php?TB_iframe=true');
		
        return false;
 
    });
    /*
    Please keep these line to use this code snipet in your <span class="IL_AD" id="IL_AD4">project</span>
    Developed by oneTarek http://onetarek.com
    */
    //adding my custom function with Thick box close function tb_close() .
    window.old_tb_remove = window.tb_remove;
    window.tb_remove = function() {
        window.old_tb_remove(); // calls the tb_remove() of the Thickbox plugin
        formfield=null;
    };
 
    // user <span class="IL_AD" id="IL_AD12">inserts</span> file into post. only run custom if user started process using the above process
    // window.send_to_editor(html) is how wp would normally handle the received data
 
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        if (formfield) {
            fileurl = jQuery('img',html).attr('src');
            jQuery(formfield).val(fileurl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }		jQuery('#imgadd').show();
		jQuery('#imgadd').attr('src', jQuery("#virtueimage").val());
    };
 
});