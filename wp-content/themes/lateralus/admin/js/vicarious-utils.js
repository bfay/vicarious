
// LAST UPDATED AT 3AM ON SEPTEMBER 25TH, 2012

jQuery(document).ready(function(){

    // SELECT & DESELECT FUNCTIONALITY
    jQuery('.display-categories ul.vicarious-group li a').live('click',function() {

	    var vicarious_value;
	    
	    // SETUP A CONDITIONAL IN VARIABLE TO USE FOR CHECKBOXES
        if(jQuery(this).hasClass('vicarious-select')) { vicarious_value = true; } else { vicarious_value = false; }

        jQuery(this).parent().parent().parent().find('input').each(function(){

            jQuery(this).attr('checked', vicarious_value);

        });

        return false;

    });

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
            jQuery('.vicarious-handle:first').after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');
            jQuery('#vicarious-content-sections').sortable('refresh');

        } else {

	        jQuery('.vicarious-handle').hide();

        }

        return false;

    });

    // DELETE SECTION BY CLICKING ON 'X' IN THE UPPER RIGHT HAND CORNER OF BLOCK
    jQuery('a.vicarious-content-section-delete').live('click',function(){
	    
	    // CONFIRMATION MESSAGE & FUNCTIONALITY TO DELETE CONTENT SECTIONS
        if(confirm('Are you sure you want to delete this Content Section?')) {

        	var vicarious_section;

            vicarious_section = jQuery(this).parent().parent();

            vicarious_section.slideUp(function() {

                vicarious_section.remove();

                if(jQuery('.vicarious-content-sections').length > 1){

                    jQuery('.vicarious-handle').show();
                    jQuery('.vicarious-handle:first').after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');
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

    	jQuery('.vicarious-handle:first').after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');

	    jQuery(function() {

		   jQuery('#settings-container').sortable({
	            axis: 'y',
	            containment: 'parent',
	            forceHelperSize: true,
	            helper: 'clone',
	            opacity: 0.6
	        });

	        jQuery('#settings-container').disableSelection();

	    });

    } else {

        jQuery('.vicarious-handle').hide();

    }

});