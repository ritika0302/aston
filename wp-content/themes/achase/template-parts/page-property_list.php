<?php // Template Name: Property List ?>
<?php 
if(!isset($_GET['dpt'])) {
	wp_redirect(home_url());
}
?>
<?php if(isset($_GET['style']) && $_GET['style'] != '') { ?>
<script type='text/javascript' src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
<script type='text/javascript' src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApIp2M7IlMuKoYe4DfY891V5iZs51K8WM&libraries=&v=weekly"></script>
<?php } ?>
<?php get_header(); ?>

<div id="content" class="push top-spacing">
	<section class="mobile-filter-row">
		<div class="container">
			<div class="wrap">
				<?php if(isset($_GET['dp']) && $_GET['dp'] != '') {
					echo '<div class="title">'.ucwords($_GET['dp']).'</div>';
				}?>
				<div class="filter-btn"><a href="javascript:void(0);">Filters</a></div>
			</div>
		</div>
	</section>
	<?php  
	$filter_opt = array();	

	if(isset($_GET['dpt']) && $_GET['dpt'] != '') {
		$filter_opt['dpt'] = $_GET['dpt'];
	}
	if(isset($_GET['psty']) && $_GET['psty'] != '') {
		$filter_opt['psty'] = $_GET['psty'];
	}
	if(isset($_GET['pstus']) && $_GET['pstus'] != '') {
		$filter_opt['pstus'] = $_GET['pstus'];
	}
	if(isset($_GET['bed']) && $_GET['bed'] != '') {
		$filter_opt['bed'] = $_GET['bed'];
	}
	if(isset($_GET['maxp']) && $_GET['maxp'] != '') {
		$filter_opt['maxp'] = $_GET['maxp'];
	}
	if(isset($_GET['minp']) && $_GET['minp'] != '') {
		$filter_opt['minp'] = $_GET['minp'];
	}
	if(isset($_GET['psq_ft']) && $_GET['psq_ft'] != '') {
		$filter_opt['psq_ft'] = $_GET['psq_ft'];
	}
	if(isset($_GET['psq_m']) && $_GET['psq_m'] != '') {
		$filter_opt['psq_m'] = $_GET['psq_m'];
	}
	if(isset($_GET['ptage']) && $_GET['ptage'] != '') {
		$filter_opt['ptage'] = $_GET['ptage'];
	}
	if(isset($_GET['pfun']) && $_GET['pfun'] != '') {
		$filter_opt['pfun'] = $_GET['pfun'];
	}
	if(isset($_GET['parea']) && $_GET['parea'] != '') {
		$filter_opt['parea'] = $_GET['parea'];
	}
	if(isset($_GET['pamty']) && $_GET['pamty'] != '') {
		$filter_opt['pamty'] = $_GET['pamty'];
	}
	if(isset($_GET['pamty']) && $_GET['pamty'] != '') {
		$filter_opt['pamty'] = $_GET['pamty'];
	}
	if(isset($_GET['ptype']) && $_GET['ptype'] != '') {
		$filter_opt['ptype'] = $_GET['ptype'];
	}
	if(isset($_GET['petfdy']) && $_GET['petfdy'] != '') {
		$filter_opt['petfdy'] = $_GET['petfdy'];
	}
	if(isset($_GET['area']) && $_GET['area'] != '') {
		$filter_opt['area'] = $_GET['area'];
	}
	if(isset($_GET['srtbyprice']) && $_GET['srtbyprice'] != '') {
		$filter_opt['srtbyprice'] = $_GET['srtbyprice'];
	}
	if(isset($_GET['cur']) && $_GET['cur'] != '') {
		$filter_opt['cur'] = $_GET['cur'];
	}
	if(isset($_GET['style']) && $_GET['style'] != '') {
		$filter_opt['style'] = $_GET['style'];

	}
	echo Property_Filter_data($filter_opt);
	
	?>
</div>
<div id="saved_search_confirmation" class="modal saved-search-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="close">
        </button>
        <h5 class="modal-title"><?php echo strtoupper(get_field("ask_ser_popup_heading","option")); ?></h5>
      </div>
      <div class="modal-body">
        <p><?php echo get_field("ask_ser_popup_content","option"); ?></p>
      </div>
      <div class="modal-footer">
      	<a href="javascript:void(0);" id="saved_search" class="btn btn-secondary left-btn">Yes</a>
      	<a href="javascript:void(0);" class="btn btn-secondary right-btn" data-dismiss="modal">No</a>
       
      </div>
    </div>

  </div>
</div>
<div id="saved_search_sucess" class="modal saved-search-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="close">
        </button>
        <h5 class="modal-title"><?php echo strtoupper(get_field("not_exi_ser_popup_heading","option")); ?></h5>
      </div>
      <div class="modal-body">
        <p><?php echo get_field("not_exi_ser_popup_content","option"); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div>
<div id="saved_search_error" class="modal saved-search-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="close">
        </button>
        <h5 class="modal-title"><?php echo strtoupper(get_field("exi_ser_popup_heading","option")); ?></h5>
      </div>
      <div class="modal-body">
        <p><?php echo get_field("exi_ser_popup_content","option"); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div>
<?php get_footer(); ?>