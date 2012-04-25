
	jQuery(function() {
		jQuery("#add_position_link").click(function() {
			var last_position = parseInt(jQuery(this).attr('data-lastnum')) + 1;
			var def_text = jQuery(this).attr('data-deftext');
			var insert = '<label for="block_' + last_position + '">Position ' + last_position + ': <input class="social_adrotate_block_position" type="text" name="block_' + last_position + '" id="block_' + last_position + '" value="' + def_text + '" /></label><br />';
			jQuery(this).before(insert);
			jQuery(this).attr('data-lastnum',last_position);
		});
		jQuery(".social_adrotate_block_position").live("focus", function() {
			var def_text = jQuery("#add_position_link").attr("data-deftext");
			if(jQuery(this).val() == def_text) {
				jQuery(this).val('');
			}
		});
		jQuery(".social_adrotate_block_position").live("blur",function() {
			var def_text = jQuery("#add_position_link").attr("data-deftext");
			if(jQuery(this).val() == "") {
				jQuery(this).val(def_text);
			}
		});
	});