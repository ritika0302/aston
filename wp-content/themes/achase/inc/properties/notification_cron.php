<?php 

add_action( 'sales_properties_new_function', 'fn_Sales_property', 10);

function fn_Sales_Property() {
    global $wpdb;
    $tbl_search = $wpdb->prefix."cron_logs"; 	
    $ins = $wpdb->query("insert into $tbl_search (property_type) VALUES ('sale')");

    Get_Sales_Properties_Feed();
	Add_properties('sales');
    update_properties('sales');
    delete_properties('sales');
}
function fn_Letting_Property() {
    global $wpdb;
    $tbl_search = $wpdb->prefix."cron_logs"; 	
    $ins = $wpdb->query("insert into $tbl_search (property_type) VALUES ('letting')");
    Get_Letting_Properties_Feed();
    Add_properties('letting');
    update_properties('letting');
    delete_properties('letting');
}

add_action( 'letting_properties_new_function', 'fn_Letting_Property', 10, 0 );

function fn_New_home_Property() {
    global $wpdb;
    $tbl_search = $wpdb->prefix."cron_logs"; 	
    $ins = $wpdb->query("insert into $tbl_search (property_type) VALUES ('new_home')");

   Get_Journal_Properties_Feed();
}

add_action( 'newhomes_properties_new_function', 'fn_New_home_Property', 10, 0 );

function cron_Property_Email_Alert() {
    Property_Email_Alert_To_User();
}

add_action( 'property_email_alert_new', 'cron_Property_Email_Alert', 10, 0 );

?>