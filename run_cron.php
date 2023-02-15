<?php

set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0); 
ini_set('default_socket_timeout', 900000000000000000000000000000000000000); 
/*
ini_set("display_errors",1);*/
error_reporting(E_ALL); 
ini_set('display_errors', 1);

define('WP_USE_THEMES', false);

require('./wp-load.php'); 

global $wpdb;

$_ptype = (isset($_REQUEST["ptype"])?$_REQUEST["ptype"]:"");

if( trim($_ptype) == "jounral" ) {
	Get_Journal_Properties_Feed();
}
if( trim($_ptype) == "letting" ) { 
	//Get_Letting_Properties_Feed();
	//Add_properties('letting');
	global $wpdb;
    $tbl_search = $wpdb->prefix."cron_logs"; 	
    $ins = $wpdb->query("insert into $tbl_search (property_type) VALUES ('letting')");
    Get_Letting_Properties_Feed();
    Add_properties('letting');
    update_properties('letting');
    delete_properties('letting');
}
if( trim($_ptype) == "sales" ) {
	
	global $wpdb;
    $tbl_search = $wpdb->prefix."cron_logs"; 	
    $ins = $wpdb->query("insert into $tbl_search (property_type) VALUES ('sale')");
	Get_Sales_Properties_Feed();
	Add_properties('sales');
	update_properties('sales');
    delete_properties('sales');
	
}

die();

?>