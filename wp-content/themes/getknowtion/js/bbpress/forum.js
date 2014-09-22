	jQuery(document).ready(function(){
		jQuery(".lm_has_sub .lm_link").click(function(){
			jQuery(".lm_link_container").not(jQuery(this).parent("div")).each(function(){
				jQuery(this).removeClass("lm_active");
				if(jQuery(this).find(".language-subcategory").length >0){
					jQuery(this).find(".language-subcategory").slideUp(500);
				}
			});
			jQuery(this).parent("div").toggleClass("lm_active");
			jQuery(this).parent("div").find(".language-subcategory").slideToggle(500);
		});
		
		jQuery("#search-close").click(function(){
			jQuery(this).parents('div').find('#bbp_search').val('').focus();
		});
	});	