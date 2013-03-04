
// LAST UPDATED ON NOVEMBER 13TH, 2012 (FH)

function setContainerEnabledState(container, enabled) {
    container.css({ opacity: enabled ? 1.0 : 0.5 });
    var formElems = container.find("input");
    if (enabled){
        formElems.removeAttr("disabled");
    } else {
        formElems.attr("disabled", "disabled");
    }
}

function registerEnableStateCallback(container, checkboxSelector) {
    jQuery(checkboxSelector).click(function(){
        var checked = jQuery(this).is(':checked');
        setContainerEnabledState(container, checked);
    });
}

jQuery(document).ready(function(){

    var optionalContainers = jQuery.find('.optional-container');
    jQuery.each(optionalContainers, function(index, value) {
        var container = jQuery(value);
        var controllingCheckboxName = container.attr("controlling-checkbox")
        var controllingCheckboxSelector = 'input[name=\"' + controllingCheckboxName + '\"]';
        var checked = jQuery(controllingCheckboxSelector).is(':checked');
        setContainerEnabledState(container, checked);
        registerEnableStateCallback(container, controllingCheckboxSelector);
    });

    // SELECT ALL & DESELECT ALL (IN "Categories to display" BOX)
    jQuery('.display-categories a.select-button').click(function() {

	    var vicarious_value = jQuery(this).hasClass('vicarious-select')
        jQuery(this).closest(".categories-container").find('input').each(function(){

            jQuery(this).attr('checked', vicarious_value);

        });

        return false;

    });

	jQuery('.option-display-type').change(function() {
		var section = jQuery(this).parents('.vicarious-content-sections');
		if(jQuery(this).find("option:selected").val()=="default_loop") {
			jQuery(section).find('.display-categories').hide();
			jQuery(section).find('.display-posts').hide();
		} else {
			jQuery(section).find('.display-categories').show();
			jQuery(section).find('.display-posts').show();
		}
	})

    // APPEND NEW SECTION TO THE LIST
    jQuery('#vicarious-add-content-section a').click(function() {

        // WE'LL FIRST CLONE IT, THEN APPEND IT TO THE LIST
        var clonedItem = jQuery('.vicarious-content-sections:eq(0)').clone();
        
        // MAKE SURE NEW CONTENT SECTION LOADS BENEATH OTHERS & ABOVE THE "ADD NEW" BUTTON
        jQuery('.vicarious-content-sections:last').after(clonedItem);

        // NOW WE NEED TO CLEAR OUT ANY INPUT THAT CAME WITH THE CLONE
        jQuery('.vicarious-content-sections:last input[type=text]').val('');
        jQuery('.vicarious-content-sections:last textarea').val('');
        jQuery('.vicarious-content-sections:last input[type=checkbox]').attr('checked', false);

        // WE ALSO NEED TO MANAGE OUR INPUT ID'S TO PREVENT COLLISION
        var vicarioushash = new Date();
        	vicarioushash = vicarioushash.getTime();

        // DISPLAY TYPE TO USE
        jQuery('.vicarious-content-sections:last .display-types select')
        	.attr('name','vicarious-display-type-' + vicarioushash)
            .attr('id','vicarious-display-type-' + vicarioushash);

        // SECTION TITLE TO DISPLAY
        jQuery('.vicarious-content-sections:last .display-titles input')
	        .attr('name','vicarious-section-title-' + vicarioushash)
	        .attr('id','vicarious-section-title-' + vicarioushash);

        // SECTION CAPTION TO DISPLAY
        jQuery('.vicarious-content-sections:last .display-captions textarea')
		    .attr('name','vicarious-section-caption-' + vicarioushash)
		    .attr('id','vicarious-section-caption-' + vicarioushash);

        // NUMBER OF POSTS TO DISPLAY
        jQuery('.vicarious-content-sections:last .display-posts input')
	        .attr('name','vicarious-section-num-posts-' + vicarioushash)
	        .attr('id','vicarious-section-num-posts-' + vicarioushash);

        // CATEGORIES TO DISPLAY
        jQuery('.vicarious-content-sections:last .categorychecklist input').each(function() {

            var vicariouscat = jQuery(this);

            vicariouscat.attr('name', 'post_category-' + vicarioushash + '[]');
            vicariouscat.attr('id', vicariouscat.attr('id') + '-' + vicarioushash);

        });
        
        // MAKE SURE SORTABLE FUNCTIONALITY ACTIVATES IMMEDIATLY IF THERE ARE MORE THAN ONE CONTENT SECTIONS
        if(jQuery('.vicarious-content-sections').length > 1) {

            jQuery('.vicarious-handle').show();
            jQuery('.vicarious-handle:first').after('<p class="dragdrop">' + admin_strings.drag_section_instruction + '</p>');
            jQuery('#vicarious-content-sections').sortable('refresh');

        } else {

	        jQuery('.vicarious-handle').hide();

        }

        return false;

    });

    // DELETE SECTION BY CLICKING ON 'X' IN THE UPPER RIGHT HAND CORNER OF BLOCK
    jQuery('a.vicarious-content-section-delete').click(function(){
	    
	    // CONFIRMATION MESSAGE & FUNCTIONALITY TO DELETE CONTENT SECTIONS
        if(confirm(admin_strings.delete_section_alert)) {

        	var vicarious_section;

            vicarious_section = jQuery(this).parent().parent();

            vicarious_section.slideUp(function() {

                vicarious_section.remove();

                if(jQuery('.vicarious-content-sections').length > 1){

                    jQuery('.vicarious-handle').show();
                    jQuery('.vicarious-handle:first').after('<p class="dragdrop">' + admin_strings.drag_section_instruction + '</p>');
                    jQuery('#vicarious-content-sections').sortable('refresh');

                } else {

                    jQuery('.vicarious-handle').hide();

                }

            });

        }

        return false;

    });

    // IF WE'RE LOADING SAVED SECTIONS, THE CATEGORY ID'S / NAMES AREN'T GOING TO WORK SOO...
    jQuery('.vicarious-content-sections').each(function(){
		
		if(jQuery(this).find(".option-display-type option:selected").val()=="default_loop") {
			jQuery(this).find('.display-categories').hide();
			jQuery(this).find('.display-posts').hide();
		} else {
			jQuery(this).find('.display-categories').show();
			jQuery(this).find('.display-posts').show();
		}
		
		
        if(jQuery(this).attr('id') != 'default' && !jQuery(this).hasClass('vicarious-content-section-default')) {

            vicarioushash = jQuery(this).attr('id').replace('vicarious-street-section-','');

            jQuery(this).find('.categorychecklist input').each(function(){

                vicariouscat = jQuery(this);
                vicariouscat.attr('name','post_category-' + vicarioushash + '[]');
                vicariouscat.attr('id',vicariouscat.attr('id') + '-' + vicarioushash);

            });

        }

    });

    // ACTIVATE HELPER TEXT & JQUERY SORTABLE IF THERE IS MORE THAN ONE CONTENT SECTION
    if(jQuery('.vicarious-content-sections').length > 1) {

    	jQuery('.vicarious-handle:first').after('<p class="dragdrop">' + admin_strings.drag_section_instruction + '</p>');

	    jQuery(function() {
		   jQuery('#vicarious-content-sections').sortable({
	            axis: 'y',
	            containment: 'parent',
	            forceHelperSize: true,
	            helper: 'clone',
	            opacity: 0.6
	        });

	        jQuery('#vicarious-content-sections').disableSelection();

	    });

    } else {

        jQuery('.vicarious-handle').hide();

    }

});