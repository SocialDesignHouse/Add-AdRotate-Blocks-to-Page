<?php
	/*
	Plugin Name: Add AdRotate Block to Page by Social
	Plugin URI: http://apps.socialdesignhouse.com/plugins/adrotate-block-to-page/
	Description: Add AdRotate Blocks to specific pages, modifies the page editor with a custom meta box. NOTE: AdRotate plug-in must be active for this plug-in to work.
	Version: 1.5b
	Author: Eric Allen of Social Design House
	Author URI: http://socialdesignhouse.com/
	License: GPL2
	*/
	
	/*--------------------------------------------------- Change Log -----------------------------------------------------
		
	 +	2012-04-23		v1.5b		Added Options Page and Dynamic creation of AdRotate Block Positions.
	
	 +	2012-04-18		v1.0b		Made AdRotate Block to Page metabox show up on all pages. Added custom post meta
									for the block of large ads and the block of small ads.
									
	--------------------------------------------------------------------------------------------------------------------*/
	
	
	//set up custom metabox
	function add_adrotate_meta_box_to_page(){
		add_meta_box("page_adrotate_block-meta", "AdRotate Block", "page_adrotate_block", "page", "side", "high");
	}
	//run this funciton when initializing the admin area
	add_action('admin_init','add_adrotate_meta_box_to_page');

	//output custom meta box to page
	function page_adrotate_block() {
		global $post;
		global $wpdb;
		$added_positions = get_option('social_add_adrotate_to_page_blocks');
		$added_position_array = explode(',',$added_positions); 
		$custom = get_post_custom($post->ID);
		$blocks = $wpdb->get_results("SELECT * FROM `wp_adrotate_blocks`"); ?>
		
		<table cellpadding="0" cellspacing="0" border="0">
			
		<?php //itereate through blocks and output information
		$pos_counter = 0;
		foreach($added_position_array as $key => $position) {
			$block_display = $block_counter + 1;
			$word_array = explode('_',$position);
			foreach($word_array as $key2 => $word) {
				$word_array[$key2] = ucfirst($word);
			}
			$position_name = implode(' ',$word_array);
			$pos_counter++;
			$options_output = '<option id="block-none" value="0">Select a ' . $position_name . ' Block</option>';
			$pos_block_id = $custom[$position][0];
			foreach($blocks as $block) {
				if($block->id == $pos_block_id) {
					$selected = ' selected';
				} else {
					$selected = '';
				}
				$options_output .= '<option id="block-' . $block->id . '" value="' . $block->id . '"' . $selected . '>' . $block->name . '</option>';
			} ?>
			
			<tr>
				<td>
					<label><?php echo $position_name; ?>:</label>
				</td>
			</tr>
				<td>
					<select id="adrotate_block_<?php echo $position; ?>" name="adrotate_block_<?php echo $position; ?>">
	
						<?php echo $options_output; //output options ?>
				
					</select>
				</td>
			</tr>
			
		<?php } ?>
		
		</table>
	
	<?php }

	//save custom post data to db on post save
	function save_adrotate_blocks_to_page() {
		global $post;
		foreach($_POST as $key => $value) {
			if(substr($key,0,15) == 'adrotate_block_') {
				$block_position = substr($key,15);
				update_post_meta($post->ID,$block_position,$value);
			}
		}
	}
	//run this function on page save
	add_action('save_post', 'save_adrotate_blocks_to_page');

	//set up back-end js for adrotate block position editor and enqueue it
	function load_social_adrotate_to_page_admin_js() {
		wp_register_script('social_adrotate_block_to_page_js',plugins_url('/social-adrotate-block-to-page/js/admin-social-adrotate.js'),array('jquery'),'',true);
		wp_enqueue_script('social_adrotate_block_to_page_js');
	}
	//run this when queueing up scripts
	add_action('admin_enqueue_scripts','load_social_adrotate_to_page_admin_js');

	//set up options for when plug-in is activated
	function social_adrotate_to_page_activate() {
		add_option('social_add_adrotate_to_page_blocks','ad_rotate_block');
		add_option('social_add_adrotate_to_page_position_default','Name this Block Position');
	}
	//run when plug-in is activated
	register_activation_hook(__FILE__,'social_adrotate_to_page_activate');

	//remove options for when plug-in is deactivated
	function social_adrotate_to_page_deactivate() {
		delete_option('social_add_adrotate_to_page_blocks');
		delete_option('social_add_adrotate_to_page_position_default');
	}
	//run when plug-in is deactivated
	register_deactivation_hook(__FILE__,'social_adrotate_to_page_deactivate');

	//include options page
	require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/options.php");

	//add the item to the admin menu
	function social_adrotate_to_page_menu() {
		add_submenu_page('adrotate','AdRotate to Page','AdRotate to Page','administrator','adrotate-to-page-options','social_adrotate_to_page_options_page');
	//	add_submenu_page('options-general.php','AdRotate to Page','AdRotate to Page','administrator','adrotate-to-page-options','social_adrotate_to_page_options_page');
	}
	//run when admin menu is being created
	add_action('admin_menu','social_adrotate_to_page_menu');
		
	
?>