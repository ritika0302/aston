<?php
/**
 * Locrating iFrame
 *
 * @author      PropertyHive
 * @package     PropertyHive/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
error_reporting(0);
$pid = intval($_GET['pid']);
if(get_post_meta($pid,"_latitude",true) != '' &&  get_post_meta($pid,"_longitude",true) != ''){
	$lat = get_post_meta($pid,"_latitude",true);
	$lng = get_post_meta($pid,"_longitude",true);
	?>
	<iframe id="propertyhive_locrating_all_in_one_frame" width="800" height="600" noborder="true" frameborder="0" data-lat="<?php echo $lat;?>" data-lng="<?php echo $lng;?>"></iframe>
<?php
} else {
?>

<iframe id="propertyhive_locrating_all_in_one_frame" width="800" height="600" noborder="true" frameborder="0" data-lat="<?php echo $property_coords['lat'];?>" data-lng="<?php echo $property_coords['lng'];?>"></iframe>
<?php }