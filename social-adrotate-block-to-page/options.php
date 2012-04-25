<?php //display options page
function social_adrotate_to_page_options_page() { ?>
	
	<div class="wrap">
		<h2>Add AdRotate Block to Page Options</h2>
		
		<?php if($_REQUEST['submit']) {
			social_adrotate_to_page_update_options();
		}
		social_adrotate_to_page_options_form(); ?>
	
	</div>
	
<?php }

//display options form
function social_adrotate_to_page_options_form() { 
	$blocks = get_option('social_add_adrotate_to_page_blocks');
	$block_def_text = get_option('social_add_adrotate_to_page_position_default');
	$block_array = explode(',',$blocks); 
	$block_counter = 0; ?>
	
	<form method="post">
		<h3>Block Positions</h3>
	
		<?php foreach($block_array as $key => $block) {
			$block_display = $block_counter + 1;
			$word_array = explode('_',$block);
			foreach($word_array as $key => $word) {
				$word_array[$key] = ucfirst($word);
			}
			$block_name = implode(' ',$word_array); ?>
		
			<label for="block_<?php echo $block_counter; ?>">Position <?php echo $block_display; ?>:
				<input class="social_adrotate_block_position" type="text" name="block_<?php echo $block_counter; ?>" id="block_<?php echo $block_counter; ?>" value="<?php echo $block_name; ?>" />
			</label><br />
		
		<?php $block_counter++;
		} ?>
	
		<a href="javascript: void(0)" id="add_position_link" data-lastnum="<?php echo $block_counter; ?>" data-deftext="<?php echo $block_def_text; ?>">+ Add Another Block Position</a><br />
		<input type="submit" name="submit" value="Update" />
	</form>
	
<?php }

//update options
function social_adrotate_to_page_update_options() {
	$ok = false;
	$new_block = "";
	$block_def_text = get_option('social_add_adrotate_to_page_position_default');
	
	if($_REQUEST) {
		foreach($_REQUEST as $key => $request) {
			if(substr($key,0,6) == 'block_' && $request != $block_def_text) {
				$new_block .= strtolower(str_replace(" ","_",$request)) . ",";
			}
		}
		if($new_block) {
			$new_block = substr($new_block,0,-1);
			update_option('social_add_adrotate_to_page_blocks',$new_block);
			$ok = true;
		}
	}

	if($ok) { ?>
		
		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div>
	
	<?php } else { ?>
		
		<div id="message" class="error fade">
			<p>Failed to save options.</p>
		</div>
	
	<?php }	
} ?>