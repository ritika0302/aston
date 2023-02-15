<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* 
Description : Fetch API credential from the backend and define it.
*/

define('cll_api_url', get_field("reapit_api_url","option"));
define('cll_api_username', get_field("reapit_api_username","option"));
define('cll_api_password', get_field("reapit_api_password","option"));
if ( ! function_exists( 'post_exists' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
}
/*
 Method : getSoapClientAuthentication()
 Description :  We use this function for soap Authentication. 
*/

function getSoapClientAuthentication() {
	
	$authentication = new \stdClass();
	$authentication->ClientID = cll_api_username;
	$authentication->Password = cll_api_password;  

	return $authentication;

}

/*
 Method : GetGeneralProperties
 Description :  By using this function fetch all properties ID and TimeAmended that have sales criteria selected and have a property status that we mentioned on array of the "PropertyStatus" Tag.
 First we compare properties that already exists on database with property ID and  TimeAmended.
	1. We set flag is_update = 1  if property id is matched but timezone is different 
 	2. We insert the property ID and TimeAmended on database with set flag is_new = 1 if property id is not matched.
 	3. We set flag is_deleted = 1 if property id not found on reapit data but its exists on database.

*/

function Get_Sales_Properties_Feed() {
    global $wpdb;
    $tbl_name =  $wpdb->prefix."properties";

	$soapClient = new \SoapClient(cll_api_url);  
	$header = new \SoapHeader('http://webservice.reapit.com/', 'Auth', getSoapClientAuthentication() );
	$soapClient->__setSoapHeaders($header); 
	$_sales_proty_res =  $soapClient->__call('GetGeneralProperties', array(
	                  "Criteria" 		=> array(
	                  "PropertyField" 	=> "ID,TimeAmended",
	                  "SearchType"		=>  "sales",
	                  "PropertyStatus"	=>  array("for sale","completed","under offer","sold","exchanged"),
	                  ),
	              )); 
	
	$reapit_proty_id = array();
	$result_sales = $wpdb->get_results( "SELECT property_id FROM $tbl_name where property_type='sales'" ); 
	$exist_proty_id = array();
	foreach ($result_sales as $sales) {
		$exist_proty_id[] = $sales->property_id;
	}

	 foreach ($_sales_proty_res as $proty_data) {
	 	$results = $wpdb->get_results( "SELECT * FROM $tbl_name where property_id = '".trim(strtolower($proty_data->ID))."'" ); 

	 	$reapit_proty_id[] = $proty_data->ID;
	 	if( count($results) <= 0 ) {

	 		$wpdb->query( "INSERT INTO $tbl_name set property_id ='".$proty_data->ID."', property_created = '".$proty_data->TimeAmended."',  is_new = 1, property_type = 'sales'" );
	 	}else
	 	{
			$update_results = $wpdb->get_results( "SELECT * FROM $tbl_name where property_id = '".trim(strtolower($proty_data->ID))."' and property_created <> '".$proty_data->TimeAmended."'" );
			if( count($update_results) > 0 ) { 
	 			$wpdb->query( "update $tbl_name set property_created = '".$proty_data->TimeAmended."', is_update = 1 where property_id ='".$proty_data->ID."'" );
	 		}
	
	 	}
	 }
	 //echo "<pre>";
	// print_r($reapit_proty_id);
	// print_r($exist_proty_id);
	 //print_r(array_unique($exist_proty_id));
	 $non_exists_id = array_diff($exist_proty_id,$reapit_proty_id);
	 foreach ($non_exists_id as $_ids) {
	 	$wpdb->query( "update $tbl_name set is_deleted = 1 where property_id ='".$_ids."' and property_type = 'sales'" );
	 }
	 

}

/*
 Method : GetGeneralProperties
 Description :  By using this function fetch all properties ID and TimeAmended that have lettings criteria selected.
 First we compare properties that already exists on database with property ID and  TimeAmended.
	1. We set flag update = 1  if property id is matched but timezone is different 
 	2. We insert the property ID and TimeAmended on database with set flag is_new = 1 if property id is not matched.
 	3. We set flag is_deleted = 1 if property id not found on reapit data but its exists on database.

*/

function Get_Letting_Properties_Feed() {
    global $wpdb;
    $tbl_name =  $wpdb->prefix."properties";

	$soapClient = new \SoapClient(cll_api_url);  
	$header = new \SoapHeader('http://webservice.reapit.com/', 'Auth', getSoapClientAuthentication() );
	$soapClient->__setSoapHeaders($header); 
	$_letting_proty_res =  $soapClient->__call('GetGeneralProperties', array(
	                  "Criteria" => array(
	                  "PropertyField" => "ID,TimeAmended",
	                  "SearchType"	=>  "lettings",

	                  ),
	              )); 

	$reapit_proty_id = array();
	$result_letting = $wpdb->get_results( "SELECT property_id FROM $tbl_name where property_type='letting'" ); 
	$exist_proty_id = array();
	foreach ($result_letting as $letting) {
		$exist_proty_id[] = $letting->property_id;
	}

	 foreach ($_letting_proty_res as $proty_data) {
	 	
	 	$reapit_proty_id[] = $proty_data->ID;
	 	$results = $wpdb->get_results( "SELECT * FROM $tbl_name where property_id = '".trim(strtolower($proty_data->ID))."'" ); 
	 	if( count($results) <= 0 ) {

	 		$wpdb->query( "INSERT INTO $tbl_name set property_id ='".$proty_data->ID."', property_created = '".$proty_data->TimeAmended."',  is_new = 1, property_type = 'letting'" );
	 	}else
	 	{
	 		

	 		$update_results = $wpdb->get_results( "SELECT * FROM $tbl_name where property_id = '".trim(strtolower($proty_data->ID))."' and property_created <> '".$proty_data->TimeAmended."'" );
			if( count($update_results) > 0 ) { 
	 			$wpdb->query( "update $tbl_name set property_created = '".$proty_data->TimeAmended."', is_update = 1 where property_id ='".$proty_data->ID."'" );
	 		}

	 	}

	 }

	 $non_exists_id = array_diff($exist_proty_id,$reapit_proty_id);
	 foreach ($non_exists_id as $_ids) {
	 	$wpdb->query( "update $tbl_name set is_deleted = 1 where property_id ='".$_ids."' and property_type = 'letting'" );
	 }
}


/*
 Method : GetGeneralProperties
 Description :  By using the function fetch all properties ID that have NewHomes criteria selected and set is_newhome = 1 flag on table if we found property ID on table.
*/

function Get_Journal_Properties_Feed() {
    global $wpdb;
    $tbl_name =  $wpdb->prefix."properties";

	$soapClient = new \SoapClient(cll_api_url);  
	$header = new \SoapHeader('http://webservice.reapit.com/', 'Auth', getSoapClientAuthentication() );
	$soapClient->__setSoapHeaders($header); 
	$_jour_proty_res =  $soapClient->__call('GetGeneralProperties', array(
		                   "Criteria" 	 => array(
		                   "PropertyField" => "ID,TimeAmended",
		                   'NewHomes' => 1 , 
	                  ),
	              )); 


	 foreach ($_jour_proty_res as $proty_data) {
	 
	 	$results = $wpdb->get_results( "SELECT * FROM $tbl_name where property_id = '".	(strtolower($proty_data->ID))."'" ); 

	 	if( count($results)  > 0 ) {

 			$wpdb->query( "update $tbl_name set is_newhome = 1 where property_id ='".$proty_data->ID."'" );
 			update_post_meta( $results[0]->property_post_id, '_is_new_home_property', "yes" );

	 	}

	 }
}

/*
 Method : GetGeneralProperty
 Description : Insert property on site.
 			1. Fetch all properties ID from the database that have is_new = 1 flag. 
			2. On loop match property id with Paramater ID and fetch all the fields that we mentioned on "FieldList" array.
			3. Create property by using fields value.  
*/

function Add_properties($property_type)
{
	global $wpdb;

    $tbl_name 		 =  $wpdb->prefix."properties";
    
    $results = $wpdb->get_results( "SELECT * FROM $tbl_name where is_new = 1 and property_type='".$property_type."'");

    if( count($results) > 0 ) {

    	foreach ( $results as $result_item ) {
 			
 			$soapClient = new \SoapClient(cll_api_url);  
			$header = new \SoapHeader('http://webservice.reapit.com/', 'Auth', getSoapClientAuthentication());
			$soapClient->__setSoapHeaders($header);
			$response = $soapClient->__call('GetGeneralProperty', array(
                   "ID" => $result_item->property_id,
                    "FieldList" => array("Fields"=>array( 'ID','PriceString','SalePrice','SaleMaxPrice','SalePriceString','Currency','Size','SizeString','HouseNumber','Address1','Address2','Address3','Postcode','Area','MatchArea','Country','Latitude','Longitude','Available','TimeAmended','Tenure','Disposal','AgencyType','Description','AccommodationSummary','Image','Floorplan','PrintableDetails','Negotiator','Vendor','InternalSaleStatus','SaleStatus','Portals','DoubleBedrooms','SingleBedrooms','ReceptionRooms','Bathrooms','TotalBedrooms','Type','Style','Situation','Parking','Location','Special','IsDevelopment','IsSubPlot','SubPlots','Notes','PriceQualifier','Age','VTour','SaleCommission','RentalPeriod','WeeklyRent','Furnish','DepositAmount','AvailableFrom','InternalLettingStatus','EPC','Keywords')),
                    "GetUnavailable" => true,           
                   
              )); 
				
			$_title = array();
			if( ( is_array($response) || is_object($response) )) {	
					
					if(isset($response->Address1)) {
						$_title[] = $response->Address1;
					}
					
					if(isset($response->Address2)) {
						$_title[] = $response->Address2;
					}
					if(isset($response->Address3)) {
						$_title[] = $response->Address3;
					}
					if(isset($response->Address4)) {
						$_title[] = $response->Address4;
					}
					if( isset( $response->Postcode )) {
							$title = explode(" ",$response->Postcode);
							$_title[] = $title[0];
					}
					if( isset( $response->ID )) {
                        $_reapitid = $response->ID;
                    }
                    else{
                        $_reapitid = '';
                    }
					
					$_title = implode(", ",$_title); 	

					$property_post = array(
						'post_title' => $_title,
						'post_name' => $_reapitid,
					    'post_date' => date('Y-m-d'),
					    'post_status' => 'publish',
					    'post_excerpt' => $response->Description,
					    'post_type' => 'property'
					); 
					$_all_keyword = array();
					$property_post_id = wp_insert_post( $property_post ); 
					update_post_meta( $property_post_id, '_master_reapit_id', $response->ID);
					if($property_type == "sales")
					{
						update_post_meta( $property_post_id, '_price', intval($response->SalePrice) );
						update_post_meta( $property_post_id, '_department', "residential-sales" );
						$_price = intval($response->SalePrice);
					}else if($property_type == "letting")
					{
						if($response->RentalPeriod == "month")
						{
							$RentalPeriod = "pcm";
							$PriceString = explode(" ",$response->PriceString);
							
							$_rent_price = str_replace(",","",str_replace("&#163;","",$PriceString[0]));
							update_post_meta( $property_post_id, '_rent',$_rent_price);
							$_price = $_rent_price;
						}else{
							
							$RentalPeriod = "pw";
							update_post_meta( $property_post_id, '_rent', intval($response->WeeklyRent) );
							$_price = intval($response->WeeklyRent);
						}
						update_post_meta( $property_post_id, '_department', "residential-lettings" );
						update_post_meta( $property_post_id, '_rent_frequency',$RentalPeriod);

					}
					if(isset($response->PriceString) && $response->PriceString !='')
					{
						update_post_meta( $property_post_id, '_PriceString', $response->PriceString );
					}
					if(isset($response->SubPlots) && $response->SubPlots !='')
					{
						update_post_meta( $property_post_id, '_SubPlots','yes');
					}
					if(isset($response->HouseNumber) && $response->HouseNumber !='')
					{
						update_post_meta( $property_post_id, '_address_name_number',$response->HouseNumber ); 
					}
					if(isset($response->Address4) && $response->Address4 !='')
					{
						$add_street = $response->Address1.". ".$response->Address2;
						update_post_meta( $property_post_id, '_address_street',$add_street );
						update_post_meta( $property_post_id, '_address_two', $response->Address3 );
						update_post_meta( $property_post_id, '_address_three', $response->Address4 );
					}else if(isset($response->Address3) && $response->Address3 !='')
					{	
						update_post_meta( $property_post_id, '_address_street',$response->Address1 );
						update_post_meta( $property_post_id, '_address_two', $response->Address2 );
						update_post_meta( $property_post_id, '_address_three', $response->Address3 );
					}else
					{
						update_post_meta( $property_post_id, '_address_street',$response->Address1 );
						update_post_meta( $property_post_id, '_address_three', $response->Address2 );
					}
					
					if(isset($response->Country) && $response->Country !='')
					{
						update_post_meta( $property_post_id, '_address_four', $response->Country );
					}
					if(isset($response->Keywords) && $response->Keywords !='')
					{
						$Keywords = explode(",", $response->Keywords);
						update_post_meta( $property_post_id, '_amity_keywords', $Keywords );
						array_push($_all_keyword,$response->Keywords);
					}

					if(isset($response->Postcode) && $response->Postcode !='')
					{
						update_post_meta( $property_post_id, '_address_postcode', $response->Postcode ); 
					}
					if(isset($response->Latitude) && $response->Latitude !='')
					{
						update_post_meta( $property_post_id, '_latitude', $response->Latitude );
					}
					if(isset($response->Longitude) && $response->Longitude !='')
					{
						update_post_meta( $property_post_id, '_longitude', $response->Longitude );
					}
					if(isset($response->Currency) && $response->Currency !='')
					{
						update_post_meta( $property_post_id, '_currency', $response->Currency ); 
					}
					if(isset($response->TotalBedrooms) && $response->TotalBedrooms !='')
					{
						update_post_meta( $property_post_id, '_bedrooms', $response->TotalBedrooms );
					}
					if(isset($response->ReceptionRooms) && $response->ReceptionRooms !='')
					{
						update_post_meta( $property_post_id, '_reception_rooms', $response->ReceptionRooms );
					}
					if(isset($response->Bathrooms) && $response->Bathrooms !='')
					{
						update_post_meta( $property_post_id, '_bathrooms', $response->Bathrooms );
					}
					if(isset($response->TimeAmended) && $response->TimeAmended !='')
					{
						update_post_meta( $property_post_id, '_TimeAmended', $response->TimeAmended );
					}

					if(isset($response->EPC) && $response->EPC !='')
					{
						update_post_meta( $property_post_id, '_property_EPC', $response->EPC);
					}
					if(isset($response->Parking) && $response->Parking !='')
					{
						$parking = implode(",",$response->Parking);
						update_post_meta( $property_post_id, '_property_parking', $response->Parking );
						array_push($_all_keyword,$parking);
					}
					if(isset($response->Special) && $response->Special !='')
					{
						$special = implode(",",$response->Special);
						update_post_meta( $property_post_id, '_property_amenities', $response->Special );
						array_push($_all_keyword,$special);
					}
					if(isset($response->SizeString) && $response->SizeString !='')
					{
						preg_match_all('!\d+!', $response->SizeString, $matches);
						update_post_meta( $property_post_id, '_size_m', $matches[0][1]);
						update_post_meta( $property_post_id, '_size_string', $response->SizeString );
					}
					if(isset($response->Size) && $response->Size !='')
					{
						update_post_meta( $property_post_id, '_size', $response->Size );
					}
					if(isset($response->SaleStatus) && $response->SaleStatus !='')
					{
						update_post_meta( $property_post_id, '_SaleStatus', $response->SaleStatus );
					}
					if(isset($response->InternalSaleStatus) && $response->InternalSaleStatus !='')
					{
						update_post_meta( $property_post_id, '_InternalSaleStatus', $response->InternalSaleStatus );
						$_pstatus = $response->InternalSaleStatus;
					}
					if(isset($response->InternalLettingStatus) && $response->InternalLettingStatus !='')
					{
						update_post_meta( $property_post_id, '_InternalLettingStatus', $response->InternalLettingStatus );
						$_pstatus = $response->InternalLettingStatus;
					}
					if(isset($response->Style) && $response->Style !='')
					{
						update_post_meta( $property_post_id, '_property_style', $response->Style );
					}
					if(isset($response->Age) &&  !empty($response->Age))
					{
						update_post_meta( $property_post_id, '_property_age', $response->Age[0] );
					}
					if(isset($response->Type) &&  !empty($response->Type))
					{
						update_post_meta( $property_post_id, '_property_type', $response->Type[0] );
					}
					
					if(isset($response->DepositAmount) && $response->DepositAmount !='')
					{
						update_post_meta( $property_post_id, '_deposit', $response->DepositAmount );
					}
					if(isset($response->Negotiator->Name) && $response->Negotiator->Name !='')
					{
						update_post_meta( $property_post_id, '_negotiator_name', $response->Negotiator->Name );
					}
					if(isset($response->Negotiator->Telephone) && $response->Negotiator->Telephone !='')
					{
						update_post_meta( $property_post_id, '_negotiator_telephone', $response->Negotiator->Telephone );
					}
					if(isset($response->Negotiator->Mobile) && $response->Negotiator->Mobile !='')
					{
						update_post_meta( $property_post_id, '_negotiator_mobile', $response->Negotiator->Mobile );
					}
					if(isset($response->Negotiator->Email) && $response->Negotiator->Email !='')
					{
						update_post_meta( $property_post_id, '_negotiator_email_id', $response->Negotiator->Email );
					}
					if(isset($response->VTour) && $response->VTour !='')
					{
						update_post_meta( $property_post_id, '_property_video', $response->VTour );
					}
					if(isset($response->PriceQualifier) && $response->PriceQualifier !='')
					{
						update_post_meta( $property_post_id, '_price_qualifier', $response->PriceQualifier );
					}
					if(isset($response->MatchArea->ID) && $response->MatchArea->ID !='')
					{
						update_post_meta( $property_post_id, '_match_area', $response->MatchArea->ID );
					}
					if(isset($response->SaleCommission) && $response->SaleCommission !='')
					{
						update_post_meta( $property_post_id, '_SaleCommission', $response->SaleCommission );
					}
					if(isset($response->IsSubPlot) && $response->IsSubPlot !='')
					{
						update_post_meta( $property_post_id, '_IsSubPlot', $response->IsSubPlot );
					}
					if(isset($response->IsDevelopment) && $response->IsDevelopment !='')
					{
						update_post_meta( $property_post_id, '_IsDevelopment', $response->IsDevelopment );
					}
					if(isset($response->AvailableFrom) && $response->AvailableFrom !='')
					{
						update_post_meta( $property_post_id, '_available_date', $response->AvailableFrom );
					}
					
					
					if(isset($response->AccommodationSummary) && $response->AccommodationSummary !='')
					{
						$AccommodationSummary = implode(", ",$response->AccommodationSummary);
						update_post_meta( $property_post_id, '_room_description', $AccommodationSummary );
					}
					if(isset($response->Situation) && !empty($response->Situation))
					{
						$Situation = implode(", ",$response->Situation);
						update_post_meta( $property_post_id, '_property_situation', $Situation );
					}
					
					$_mrg_keyword = implode(",",$_all_keyword);
					if(isset($_mrg_keyword) && $_mrg_keyword != '')
					{
						$_dmrg_keyword =  explode(",",$_mrg_keyword);
						update_post_meta( $property_post_id, '_property_all_keywords', $_dmrg_keyword);
					}

					if( $response->Available == '1' )
					{
				 		update_post_meta( $property_post_id, '_on_market', 'yes' );
				 		update_post_meta( $property_post_id, '_available',1);	
				 	}else{
				 		update_post_meta( $property_post_id, '_on_market', '' );
				 		update_post_meta( $property_post_id, '_available',0);
				 	}

				 	/// Furnishing //
				 	if(isset($response->Furnish) && $response->Furnish != '')
				 	{
				 		
						$furn_id = 0;
						$furnish = explode(",", str_replace("or",",",$response->Furnish));

						$_fun_arr = array();
						foreach ($furnish as $_fun) {
							if(trim($_fun) == "Available Part Furnished" || trim($_fun) == "Part Furnished")
							{
								$_fun_arr[] = "Part Furnished";
							}else if(trim($_fun) == "Available Furnished")
							{
								$_fun_arr[] = "Furnished";
							}else if(trim($_fun) == "Unfurnished")
							{
								$_fun_arr[] = "Unfurnished";
							}
						}

						update_post_meta( $property_post_id, '_furnishing',$_fun_arr);
				 	}

				 	// End ///

					
					/// Status
					if(isset($response->InternalSaleStatus) && $response->InternalSaleStatus != '')
					{
						$status = explode(" - ",$response->InternalSaleStatus);
						if($status[0] == "Exchanged" || $status[0] == "Completed")
						{
							$_status = "Sold";
						}else
						{
							$_status = $status[0];
						}

					 	$status_args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$status_terms = get_terms( 'availability', $status_args );
						$status_id = 0;

						if ( !empty( $status_terms ) && !is_wp_error( $status_terms ) ) {

						    foreach ($status_terms as $_status_term) {    
						         if(strtolower($_status_term->name) == strtolower($_status))
						         {
						         	$status_id = $_status_term->term_id;
						         }
						    }

						    if( intval($status_id) > 0 )
						    {
								wp_set_object_terms( $property_post_id, $status_id, 'tenure' );
						    }
						}
					}
					if(isset($response->InternalLettingStatus) && $response->InternalLettingStatus != '')
					{
						$status = explode(" - ",$response->InternalLettingStatus);
						if($status[0] == "Exchanged" || $status[0] == "Completed")
						{
							$_status = "Sold";
						}else
						{
							$_status = $status[0];
						}

					 	$status_args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$status_terms = get_terms( 'availability', $status_args );
						$status_id = 0;

						if ( !empty( $status_terms ) && !is_wp_error( $status_terms ) ) {

						    foreach ($status_terms as $_status_term) {    
						         if(strtolower($_status_term) == strtolower($_status))
						         {
						         	$status_id = $_status_term->term_id;
						         }
						    }

						    if( intval($status_id) > 0 )
						    {
								wp_set_object_terms( $property_post_id, $status_id, 'tenure' );
						    }
						}
					}
					// End // 

				
			  		// Tenure // 
					if(isset($response->Tenure))
					{
						$args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$terms = get_terms( 'tenure', $args );
						$tenures_id = 0;
						$Tenure = '';
						if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
							if($response->Tenure == "Share of Freehold")
							{
								$Tenure = "Freehold";
							}else
							{
								$Tenure = $response->Tenure;
							}
						    foreach ($terms as $term) {    
						         if(strtolower($Tenure) == strtolower($term->name))
						         	$tenures_id = $term->term_id;
						    }

						    if( intval($tenures_id) > 0 )
								wp_set_object_terms( $property_post_id, $tenures_id, 'tenure' );
						}
					}
					/// End ///

					
					// Images 
					if(!empty($response->Image) && count($response->Image)> 0)
					{
						$io = 0; 
						$photo_import_ids = array();
						$photo_time_import_ids = array();					
	                	foreach ($response->Image as $img_value) { 
	                		$Filepath = $img_value->Filepath;
		            		$Caption = $img_value->Caption;
	                		$p_TimeAmended = $img_value->TimeAmended;
                			$photo_import_ids[$io] = uploadPostImg($Filepath,$Caption,$property_post_id);
	            			$photo_time_import_ids[$io] = $p_TimeAmended;
	            			$io++;
	                	}
	                	// photo images ====================================  
			   		 	if ( !empty($photo_import_ids))
					    { 
					    	$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_photos', meta_value = '".serialize($photo_import_ids)."', post_id = '".$property_post_id."'" ); 
						}
            			if ( !empty($photo_time_import_ids))
					    { 
					    	$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_photos_timeAmended', meta_value = '".serialize($photo_time_import_ids)."', post_id = '".$property_post_id."'" ); 
						}
                	}

                	 
					 


					// brochures ======================================
					if( isset( $response->PrintableDetails )) {
						$pdf_import_id = uploadPostImg($response->PrintableDetails,($_title),$property_post_id);
						$pdf_import_id = array($pdf_import_id);
						if ( ! get_post_meta( $property_post_id, '_brochures' ) ) 
					    	$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_brochures', meta_value = '".serialize($pdf_import_id)."', post_id = '".$property_post_id."'" ); 
						 	
					} 


					// floorplan ===================== 
					if(!empty($response->Floorplan) && count($response->Floorplan)> 0)
					{
						$io = 0; 
						$floorplan_import_ids = array();
			        	foreach ( $response->Floorplan as $img_value ) {  

			    			$Filepath = $img_value->Filepath;
			    			$Caption = $img_value->Caption;
			    			$f_TimeAmended = $img_value->TimeAmended;
			    			$floorplan_time_import_ids = array();        
			    			$floorplan_import_ids[$io] = uploadPostImg( $Filepath, $Caption, $property_post_id );
			    			$floorplan_time_import_ids[$io] = $f_TimeAmended;
							$io++;

			        	} 
			        	if ( !empty($floorplan_import_ids)) 
			        	{
					  	    $wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_floorplans', meta_value = '".serialize($floorplan_import_ids)."', post_id = '".$property_post_id."'" ); 
			        	}
			        	if ( !empty($floorplan_time_import_ids)) 
			        	{
					  	    $wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_floorplans_timeAmended', meta_value = '".serialize($floorplan_time_import_ids)."', post_id = '".$property_post_id."'" ); 
			        	}
		        	}
		        	
		        	// Update temp master record
					$wpdb->query( "update ".$wpdb->prefix."properties set is_new = 0, property_post_id = '".$property_post_id."' where property_id = '".$result_item->property_id."'" );
			}
 		}
    }
}

/*
 Method : GetGeneralProperty
 Description : Update property on site.
 			1. Fetch all properties ID from the database that have is_update = 1 flag. 
			2. On loop match property id with Paramater ID and fetch all the fields that we mentioned on "FieldList" array.
			3. Update property data by using fields value.  
*/

function update_properties($property_type)
{
	global $wpdb;

    $tbl_name 		 =  $wpdb->prefix."properties";
    
    $results = $wpdb->get_results( "SELECT * FROM $tbl_name where is_update = 1 and property_type='".$property_type."'");


    if( count($results) > 0 ) {

    	foreach ( $results as $result_item ) {
 			
 			$soapClient = new \SoapClient(cll_api_url);  
			$header = new \SoapHeader('http://webservice.reapit.com/', 'Auth', getSoapClientAuthentication());
			$soapClient->__setSoapHeaders($header);
			$response = $soapClient->__call('GetGeneralProperty', array(
                   "ID" => $result_item->property_id,
                    "FieldList" => array("Fields"=>array( 'ID','PriceString','SalePrice','SaleMaxPrice','SalePriceString','Currency','Size','SizeString','HouseNumber','Address1','Address2','Address3','Postcode','Area','MatchArea','Country','Latitude','Longitude','Available','TimeAmended','Tenure','Disposal','AgencyType','Description','AccommodationSummary','Image','Floorplan','PrintableDetails','Negotiator','Vendor','InternalSaleStatus','SaleStatus','Portals','DoubleBedrooms','SingleBedrooms','ReceptionRooms','Bathrooms','TotalBedrooms','Type','Style','Situation','Parking','Location','Special','IsDevelopment','IsSubPlot','SubPlots','Notes','PriceQualifier','Age','VTour','SaleCommission','RentalPeriod','WeeklyRent','Furnish','DepositAmount','AvailableFrom','InternalLettingStatus','EPC','Keywords')),
                    "GetUnavailable" => true,           
                   
              )); 
			$wp_post_id = $result_item->property_post_id;
			$_title = array();
			if( ( is_array($response) || is_object($response) )) {	
					
					if(isset($response->Address1)) {
						$_title[] = $response->Address1;
					}
					
					if(isset($response->Address2)) {
						$_title[] = $response->Address2;
					}
					if(isset($response->Address3)) {
						$_title[] = $response->Address3;
					}
					if(isset($response->Address4)) {
						$_title[] = $response->Address4;
					}
					if( isset( $response->Postcode )) {
							$title = explode(" ",$response->Postcode);
							$_title[] = $title[0];
					}
					
					$_title = implode(", ",$_title); 	

					$property_post = array(
						'ID' => $wp_post_id,   
					    'post_title' => $_title,
					    'post_date' => date('Y-m-d'),
					    'post_status' => 'publish',
					    'post_excerpt' => $response->Description,
					    'post_type' => 'property'
					); 

					$property_post_id = wp_update_post( $property_post ); 
					update_post_meta( $property_post_id, '_master_reapit_id', intval($response->ID) );
					if($property_type == "sales")
					{
						update_post_meta( $property_post_id, '_price', intval($response->SalePrice) );
						update_post_meta( $property_post_id, '_department', "residential-sales" );
						$_price = intval($response->SalePrice);
						
					}else if($property_type == "letting")
					{
						if($response->RentalPeriod == "month")
						{
							$RentalPeriod = "pcm";
							$PriceString = explode(" ",$response->PriceString);
							$_rent_price = str_replace(",","",str_replace("&#163;","",$PriceString[0]));
							update_post_meta( $property_post_id, '_rent',$_rent_price);
							$_price = $_rent_price;
						}else{
							$RentalPeriod = "pw";
							update_post_meta( $property_post_id, '_rent', intval($response->WeeklyRent) );
							$_price = intval($response->WeeklyRent);
						}
						update_post_meta( $property_post_id, '_department', "residential-lettings" );
						update_post_meta( $property_post_id, '_rent_frequency',$RentalPeriod);

					}
					if(isset($response->PriceString) && $response->PriceString !='')
					{
						update_post_meta( $property_post_id, '_PriceString', $response->PriceString );
					}
					if(isset($response->SubPlots) && $response->SubPlots !='')
					{
						update_post_meta( $property_post_id, '_SubPlots','yes');
					}
					if(isset($response->HouseNumber) && $response->HouseNumber !='')
					{
						update_post_meta( $property_post_id, '_address_name_number',$response->HouseNumber ); 
					}
					if(isset($response->Address4) && $response->Address4 !='')
					{
						$add_street = $response->Address1.". ".$response->Address2;
						update_post_meta( $property_post_id, '_address_street',$add_street );
						update_post_meta( $property_post_id, '_address_two', $response->Address3 );
						update_post_meta( $property_post_id, '_address_three', $response->Address4 );
					}else if(isset($response->Address3) && $response->Address3 !='')
					{	
						update_post_meta( $property_post_id, '_address_street',$response->Address1 );
						update_post_meta( $property_post_id, '_address_two', $response->Address2 );
						update_post_meta( $property_post_id, '_address_three', $response->Address3 );
					}else
					{
						update_post_meta( $property_post_id, '_address_street',$response->Address1 );
						update_post_meta( $property_post_id, '_address_three', $response->Address2 );
					}
					
					if(isset($response->Country) && $response->Country !='')
					{
						update_post_meta( $property_post_id, '_address_four', $response->Country );
					}
					if(isset($response->Keywords) && $response->Keywords !='')
					{
						$Keywords = explode(",", $response->Keywords);
						update_post_meta( $property_post_id, '_amity_keywords', $Keywords );
					}

					if(isset($response->Postcode) && $response->Postcode !='')
					{
						update_post_meta( $property_post_id, '_address_postcode', $response->Postcode ); 
					}
					if(isset($response->Latitude) && $response->Latitude !='')
					{
						update_post_meta( $property_post_id, '_latitude', $response->Latitude );
					}
					if(isset($response->Longitude) && $response->Longitude !='')
					{
						update_post_meta( $property_post_id, '_longitude', $response->Longitude );
					}
					if(isset($response->Currency) && $response->Currency !='')
					{
						update_post_meta( $property_post_id, '_currency', $response->Currency ); 
					}
					if(isset($response->TotalBedrooms) && $response->TotalBedrooms !='')
					{
						update_post_meta( $property_post_id, '_bedrooms', $response->TotalBedrooms );
					}
					if(isset($response->ReceptionRooms) && $response->ReceptionRooms !='')
					{
						update_post_meta( $property_post_id, '_reception_rooms', $response->ReceptionRooms );
					}
					if(isset($response->Bathrooms) && $response->Bathrooms !='')
					{
						update_post_meta( $property_post_id, '_bathrooms', $response->Bathrooms );
					}
					if(isset($response->TimeAmended) && $response->TimeAmended !='')
					{
						update_post_meta( $property_post_id, '_TimeAmended', $response->TimeAmended );
					}

					if(isset($response->EPC) && $response->EPC !='')
					{
						update_post_meta( $property_post_id, '_property_EPC', $response->EPC);
					}
					if(isset($response->Parking) && $response->Parking !='')
					{
						update_post_meta( $property_post_id, '_property_parking', $response->Parking );
					}
					if(isset($response->Special) && $response->Special !='')
					{
						update_post_meta( $property_post_id, '_property_amenities', $response->Special );
					}
					if(isset($response->SizeString) && $response->SizeString !='')
					{
						preg_match_all('!\d+!', $response->SizeString, $matches);
						update_post_meta( $property_post_id, '_size_m', $matches[0][1]);
						update_post_meta( $property_post_id, '_size_string', $response->SizeString );
					}
					if(isset($response->Size) && $response->Size !='')
					{
						update_post_meta( $property_post_id, '_size', $response->Size );
					}
					if(isset($response->SaleStatus) && $response->SaleStatus !='')
					{
						update_post_meta( $property_post_id, '_SaleStatus', $response->SaleStatus );
					}
					if(isset($response->InternalSaleStatus) && $response->InternalSaleStatus !='')
					{
						update_post_meta( $property_post_id, '_InternalSaleStatus', $response->InternalSaleStatus );
						$_pstatus = $response->InternalSaleStatus;
					}
					if(isset($response->InternalLettingStatus) && $response->InternalLettingStatus !='')
					{
						update_post_meta( $property_post_id, '_InternalLettingStatus', $response->InternalLettingStatus );
						$_pstatus = $response->InternalLettingStatus;
					}
					if(isset($response->Style) && $response->Style !='')
					{
						update_post_meta( $property_post_id, '_property_style', $response->Style );
					}
					if(isset($response->Age) &&  !empty($response->Age))
					{
						update_post_meta( $property_post_id, '_property_age', $response->Age[0] );
					}
					if(isset($response->Type) &&  !empty($response->Type))
					{
						update_post_meta( $property_post_id, '_property_type', $response->Type[0] );
					}
					
					if(isset($response->DepositAmount) && $response->DepositAmount !='')
					{
						update_post_meta( $property_post_id, '_deposit', $response->DepositAmount );
					}
					if(isset($response->Negotiator->Name) && $response->Negotiator->Name !='')
					{
						update_post_meta( $property_post_id, '_negotiator_name', $response->Negotiator->Name );
					}
					if(isset($response->Negotiator->Telephone) && $response->Negotiator->Telephone !='')
					{
						update_post_meta( $property_post_id, '_negotiator_telephone', $response->Negotiator->Telephone );
					}
					if(isset($response->Negotiator->Mobile) && $response->Negotiator->Mobile !='')
					{
						update_post_meta( $property_post_id, '_negotiator_mobile', $response->Negotiator->Mobile );
					}
					if(isset($response->Negotiator->Email) && $response->Negotiator->Email !='')
					{
						update_post_meta( $property_post_id, '_negotiator_email_id', $response->Negotiator->Email );
					}
					if(isset($response->VTour) && $response->VTour !='')
					{
						update_post_meta( $property_post_id, '_property_video', $response->VTour );
					}
					if(isset($response->PriceQualifier) && $response->PriceQualifier !='')
					{
						update_post_meta( $property_post_id, '_price_qualifier', $response->PriceQualifier );
					}
					if(isset($response->MatchArea->ID) && $response->MatchArea->ID !='')
					{
						update_post_meta( $property_post_id, '_match_area', $response->MatchArea->ID );
					}
					if(isset($response->SaleCommission) && $response->SaleCommission !='')
					{
						update_post_meta( $property_post_id, '_SaleCommission', $response->SaleCommission );
					}
					if(isset($response->IsSubPlot) && $response->IsSubPlot !='')
					{
						update_post_meta( $property_post_id, '_IsSubPlot', $response->IsSubPlot );
					}
					if(isset($response->IsDevelopment) && $response->IsDevelopment !='')
					{
						update_post_meta( $property_post_id, '_IsDevelopment', $response->IsDevelopment );
					}
					if(isset($response->AvailableFrom) && $response->AvailableFrom !='')
					{
						update_post_meta( $property_post_id, '_available_date', $response->AvailableFrom );
					}
					
					
					if(isset($response->AccommodationSummary) && $response->AccommodationSummary !='')
					{
						$AccommodationSummary = implode(", ",$response->AccommodationSummary);
						update_post_meta( $property_post_id, '_room_description', $AccommodationSummary );
					}
					if(isset($response->Situation) && !empty($response->Situation))
					{
						$Situation = implode(", ",$response->Situation);
						update_post_meta( $property_post_id, '_property_situation', $Situation );
					}


					if( $response->Available == '1' )
					{
				 		update_post_meta( $property_post_id, '_on_market', 'yes' );
				 		update_post_meta( $property_post_id, '_available',1);	
				 	}else{
				 		update_post_meta( $property_post_id, '_on_market', '' );
				 		update_post_meta( $property_post_id, '_available',0);
				 	}

				 	/// Furnishing //
				 	if(isset($response->Furnish) && $response->Furnish != '')
				 	{
				 		
						$furn_id = 0;
						$furnish = explode(",", str_replace("or",",",$response->Furnish));

						$_fun_arr = array();
						foreach ($furnish as $_fun) {
							if(trim($_fun) == "Available Part Furnished" || trim($_fun) == "Part Furnished")
							{
								$_fun_arr[] = "Part Furnished";
							}else if(trim($_fun) == "Available Furnished")
							{
								$_fun_arr[] = "Furnished";
							}else if(trim($_fun) == "Unfurnished")
							{
								$_fun_arr[] = "Unfurnished";
							}
						}

						update_post_meta( $property_post_id, '_furnishing',$_fun_arr);
				 	}

				 	// End ///

					
					/// Status
					if(isset($response->InternalSaleStatus) && $response->InternalSaleStatus != '')
					{
						$status = explode(" - ",$response->InternalSaleStatus);
						if($status[0] == "Exchanged" || $status[0] == "Completed")
						{
							$_status = "Sold";
						}else
						{
							$_status = $status[0];
						}

					 	$status_args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$status_terms = get_terms( 'availability', $status_args );
						$status_id = 0;

						if ( !empty( $status_terms ) && !is_wp_error( $status_terms ) ) {

						    foreach ($status_terms as $_status_term) {    
						         if(strtolower($_status_term->name) == strtolower($_status))
						         {
						         	$status_id = $_status_term->term_id;
						         }
						    }

						    if( intval($status_id) > 0 )
						    {
								wp_set_object_terms( $property_post_id, $status_id, 'tenure' );
						    }
						}
					}
					if(isset($response->InternalLettingStatus) && $response->InternalLettingStatus != '')
					{
						$status = explode(" - ",$response->InternalLettingStatus);
						if($status[0] == "Exchanged" || $status[0] == "Completed")
						{
							$_status = "Sold";
						}else
						{
							$_status = $status[0];
						}

					 	$status_args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$status_terms = get_terms( 'availability', $status_args );
						$status_id = 0;

						if ( !empty( $status_terms ) && !is_wp_error( $status_terms ) ) {

						    foreach ($status_terms as $_status_term) {    
						         if(strtolower($_status_term) == strtolower($_status))
						         {
						         	$status_id = $_status_term->term_id;
						         }
						    }

						    if( intval($status_id) > 0 )
						    {
								wp_set_object_terms( $property_post_id, $status_id, 'tenure' );
						    }
						}
					}
					// End // 

				
			  		// Tenure // 
					if(isset($response->Tenure))
					{
						$args = array(
			                'hide_empty' => false,
			                'parent' => 0
			            );
						$terms = get_terms( 'tenure', $args );
						$tenures_id = 0;
						$Tenure = '';
						if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
							if($response->Tenure == "Share of Freehold")
							{
								$Tenure = "Freehold";
							}else
							{
								$Tenure = $response->Tenure;
							}
						    foreach ($terms as $term) {    
						         if(strtolower($Tenure) == strtolower($term->name))
						         	$tenures_id = $term->term_id;
						    }

						    if( intval($tenures_id) > 0 )
								wp_set_object_terms( $property_post_id, $tenures_id, 'tenure' );
						}
					}
					/// End ///

					// Images 
					
					if(!empty($response->Image) && count($response->Image)> 0)
					{
						$io = 0; 
						$photo_import_ids = array();
						$photo_time_import_ids = array();
						$_photo_time = get_post_meta($property_post_id, '_photos_timeAmended',true);
						foreach ($response->Image as $img_value) {
							$Caption = $img_value->Caption;
							$Filepath = $img_value->Filepath;
							$p_TimeAmended = $img_value->TimeAmended;
							if($_photo_time[$io] == $p_TimeAmended)
							{
								/* Nothing to do*/
							}else
							{
								
		            			$photo_import_ids[$io] = uploadPostImg($Filepath,$Caption,$property_post_id);
		            			$photo_time_import_ids[$io] = $p_TimeAmended;
		            			
							}
							$io++;
						}
						// photo images ====================================  
					    if ( !empty($photo_import_ids))
					    { 
					    	$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_photos', meta_value = '".serialize($photo_import_ids)."', post_id = '".$property_post_id."'" ); 
						}
						if ( !empty($photo_time_import_ids))
					    { 
					    	$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_photos_timeAmended', meta_value = '".serialize($photo_time_import_ids)."', post_id = '".$property_post_id."'" ); 
						}
					}
                	// brochures ======================================
					if( isset( $response->PrintableDetails )) {

							if(post_exists($_title,"","","attachment"))
							{
								/* Nothing to do*/
							}else
							{
								
								$pdf_import_ids = array();
								$pdf_import_id = uploadPostImg($response->PrintableDetails,($_title),$property_post_id);
								$pdf_import_ids = array($pdf_import_id);
								
								if (!empty($pdf_import_ids))
								{ 
									$wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_brochures', meta_value = '".serialize($pdf_import_ids)."', post_id = '".$property_post_id."'" ); 
						    	}
							}
						 	
					} 
					
					// floorplan ===================== 
					if(!empty($response->Floorplan) && count($response->Floorplan)> 0)
					{
						
						$io = 0; 
						$floorplan_import_ids = array();
						$floorplan_time_import_ids = array();
						$_flo_time = get_post_meta($property_post_id, '_floorplans_timeAmended',true);
						foreach ( $response->Floorplan as $img_value ) {  

			    			$Filepath = $img_value->Filepath;
			    			$Caption = $img_value->Caption;        
			    			$f_TimeAmended = $img_value->TimeAmended;
			    			if($f_TimeAmended == $_flo_time[0])
							{
								/* Nothing to do*/
							}else
							{
								$floorplan_import_ids[$io] = uploadPostImg( $Filepath, $Caption, $property_post_id );
								$floorplan_time_import_ids[$io] = $f_TimeAmended;
								
							}
							$io++;
			        	} 
			        	if ( !empty($floorplan_import_ids)) 
			        	{
					  	    $wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_floorplans', meta_value = '".serialize($floorplan_import_ids)."', post_id = '".$property_post_id."'" ); 
			        	}
			        	if ( !empty($floorplan_time_import_ids)) 
			        	{
					  	    $wpdb->query( "insert into ".$wpdb->prefix."postmeta set meta_key = '_floorplans_timeAmended', meta_value = '".serialize($floorplan_time_import_ids)."', post_id = '".$property_post_id."'" ); 
			        	}
		        	} 


		        	// Update temp master record
					$wpdb->query( "update ".$wpdb->prefix."properties set is_update = 0, property_post_id = '".$property_post_id."' where property_id = '".$result_item->property_id."'" );
			} 
 		}
    }
}

/*
 Method : GetGeneralProperty
 Description : Delete property from the site.
 			1. Fetch all properties ID from the database that have is_delete = 1 flag. 
			2. Delete property data from the site.
*/

function delete_properties($property_type)
{
	global $wpdb;

    $tbl_name 		 =  $wpdb->prefix."properties";
    $results = $wpdb->get_results( "SELECT * FROM $tbl_name where is_deleted = 1 and property_post_id != '' ");

    if(count($results))
    {
    	foreach ($results as $result_item) {
    		$property_post_id = $result_item->property_post_id;

    		delete_post_meta( $property_post_id, '_master_reapit_id');
    		delete_post_meta( $property_post_id, '_price');
    		delete_post_meta( $property_post_id, '_department');
    		delete_post_meta( $property_post_id, '_rent');
    		delete_post_meta( $property_post_id, '_rent_frequency');
    		delete_post_meta( $property_post_id, '_address_name_number');
    		delete_post_meta( $property_post_id, '_address_two');
    		delete_post_meta( $property_post_id, '_address_three');
    		delete_post_meta( $property_post_id, '_address_four');
    		delete_post_meta( $property_post_id, '_amity_keywords');
    		delete_post_meta( $property_post_id, '_address_postcode');
    		delete_post_meta( $property_post_id, '_latitude');
    		delete_post_meta( $property_post_id, '_longitude');
    		delete_post_meta( $property_post_id, '_currency');
    		delete_post_meta( $property_post_id, '_bedrooms');
    		delete_post_meta( $property_post_id, '_reception_rooms');
    		delete_post_meta( $property_post_id, '_bathrooms');
    		delete_post_meta( $property_post_id, '_TimeAmended');
    		delete_post_meta( $property_post_id, '_property_EPC');
    		delete_post_meta( $property_post_id, '_property_parking');
    		delete_post_meta( $property_post_id, '_property_amenities');
    		delete_post_meta( $property_post_id, '_size_m');
    		delete_post_meta( $property_post_id, '_size_string');
    		delete_post_meta( $property_post_id, '_size');
    		delete_post_meta( $property_post_id, '_SaleStatus');
    		delete_post_meta( $property_post_id, '_property_style');
    		delete_post_meta( $property_post_id, '_InternalSaleStatus');
    		delete_post_meta( $property_post_id, '_InternalLettingStatus');
    		delete_post_meta( $property_post_id, '_property_age');
    		delete_post_meta( $property_post_id, '_property_type');
    		delete_post_meta( $property_post_id, '_deposit');
    		delete_post_meta( $property_post_id, '_negotiator_name');
    		delete_post_meta( $property_post_id, '_negotiator_telephone');
    		delete_post_meta( $property_post_id, '_negotiator_mobile');
    		delete_post_meta( $property_post_id, '_negotiator_email_id');
    		delete_post_meta( $property_post_id, '_property_video');
    		delete_post_meta( $property_post_id, '_price_qualifier');
    		delete_post_meta( $property_post_id, '_match_area');
    		delete_post_meta( $property_post_id, '_SaleCommission');
    		delete_post_meta( $property_post_id, '_IsSubPlot');
    		delete_post_meta( $property_post_id, '_IsDevelopment');
    		delete_post_meta( $property_post_id, '_available_date');
    		delete_post_meta( $property_post_id, '_room_description');
    		delete_post_meta( $property_post_id, '_property_situation');
    		delete_post_meta( $property_post_id, '_on_market');
    		delete_post_meta( $property_post_id, '_available');
    		delete_post_meta( $property_post_id, '_furnishing');
    		delete_post_meta( $property_post_id, '_on_market');

    		/* delete old photos start */ 
			$_photos = get_post_meta( $property_post_id, '_photos', true );   
			if(!empty($_photos))
			{
				foreach ($_photos as $k_photos) {
					wp_delete_attachment( $k_photos );
				}
				delete_post_meta( $property_post_id, '_photos');
				delete_post_meta( $property_post_id, '_photos_timeAmended');
			}

			
			// delete master floorplan
			$_floorplan = get_post_meta( $property_post_id, '_floorplans', true ); 
			if(!empty($_floorplan))
			{
				foreach ($_floorplan as $k__floorplan_property ) {
					wp_delete_attachment( $k__floorplan_property );
				}
				delete_post_meta( $property_post_id, '_floorplans');
				delete_post_meta( $property_post_id, '_floorplans_timeAmended');
			}
			/* start delete old brochures */
			$_brochures = get_post_meta( $property_post_id, '_brochures', true );  
			if(!empty($_brochures))
			{
				foreach ($_brochures as $k_brochures ) {
					wp_delete_attachment( $k_brochures );
				}
				delete_post_meta( $property_post_id, '_brochures');
			}
			/* end delete old brochures */

			// DELETE MASTER PROPERTIES
			wp_delete_post($property_post_id, true); 

			// DELETE MASTER PROPERTY FROM TEMP RECORD
			$wpdb->query( "delete from ".$wpdb->prefix."properties where ID = '".$result_item->ID."' and property_post_id= '".$property_post_id."'" );
			
    	}
    }


}
/*
	Description : Fetch image name from the image url.	
*/

function getFileNameFrom($fileurl){
	$tmp1 = $fileurl;
	$path=explode("?",$tmp1);
	$_final_path = $fileurl;
	if( count($path) > 1 ) {
		$_final_path = $path[0];
	}  
	$_fph = $_final_path;

	$filename = basename($_fph);
	$tmp2 = $_final_path;
	$tmp3 = explode('.',$tmp2);
	$ext = end($tmp3);
	if($ext != ""){
		return array($ext,$filename,basename($_final_path,'.'.$ext));
	} else {
		return array("",$filename,$filename);
	}
	
}

/*
	Description : Upload property image on site by property id.	
*/

function uploadPostImg($image_url,$Caption,$post_id) { 

 	$_file_info = getFileNameFrom($image_url);
	$image_name = $_file_info[1];
	if($_file_info[0] == "php"){
		$image_name = sanitize_title($Caption).".pdf";
	}

    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url); 
    $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); 
    $filename = time()."-".$image_name; 

    if( wp_mkdir_p( $upload_dir['path'] ) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }
 
    file_put_contents( $file, $image_data );

    // Check image file type
    $wp_filetype = wp_check_filetype( $filename, null );

    // Set attachment data
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => $Caption,
        'post_content' => '',
        'post_status' => 'inherit'
    );

    // Create the attachment
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

    // Assign metadata to attachment
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;

}
?>