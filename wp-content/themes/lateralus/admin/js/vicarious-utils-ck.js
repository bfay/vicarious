// LAST UPDATED AT 3AM ON SEPTEMBER 25TH, 2012
jQuery(document).ready(function() {
    jQuery(".display-categories ul.vicarious-group li a").live("click", function() {
        var e;
        jQuery(this).hasClass("vicarious-select") ? e = !0 : e = !1;
        jQuery(this).parent().parent().parent().find("input").each(function() {
            jQuery(this).attr("checked", e);
        });
        return !1;
    });
    jQuery("#vicarious-add-content-section a").click(function() {
        var e = jQuery(".vicarious-content-sections:eq(0)").clone();
        jQuery(".vicarious-content-sections:last").after(e);
        jQuery(".vicarious-content-sections:last input[type=text]").val("");
        jQuery(".vicarious-content-sections:last textarea").val("");
        jQuery(".vicarious-content-sections:last input[type=checkbox]").attr("checked", !1);
        var t = new Date;
        t = t.getTime();
        jQuery(".vicarious-content-sections:last .display-types select").attr("name", "vicarious-display-type-" + t).attr("id", "vicarious-display-type-" + t);
        jQuery(".vicarious-content-sections:last .display-titles input").attr("name", "vicarious-section-title-" + t).attr("id", "vicarious-section-title-" + t);
        jQuery(".vicarious-content-sections:last .display-captions textarea").attr("name", "vicarious-section-caption-" + t).attr("id", "vicarious-section-caption-" + t);
        jQuery(".vicarious-content-sections:last .display-posts input").attr("name", "vicarious-section-num-posts-" + t).attr("id", "vicarious-section-num-posts-" + t);
        jQuery(".vicarious-content-sections:last .categorychecklist input").each(function() {
            var e = jQuery(this);
            e.attr("name", "post_category-" + t + "[]");
            e.attr("id", e.attr("id") + "-" + t);
        });
        if (jQuery(".vicarious-content-sections").length > 1) {
            jQuery(".vicarious-handle").show();
            jQuery(".vicarious-handle:first").after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');
            jQuery("#vicarious-content-sections").sortable("refresh");
        } else jQuery(".vicarious-handle").hide();
        return !1;
    });
    jQuery("a.vicarious-content-section-delete").live("click", function() {
        if (confirm("Are you sure you want to delete this Content Section?")) {
            var e;
            e = jQuery(this).parent().parent();
            e.slideUp(function() {
                e.remove();
                if (jQuery(".vicarious-content-sections").length > 1) {
                    jQuery(".vicarious-handle").show();
                    jQuery(".vicarious-handle:first").after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');
                    jQuery("#vicarious-content-sections").sortable("refresh");
                } else jQuery(".vicarious-handle").hide();
            });
        }
        return !1;
    });
    jQuery(".vicarious-content-sections").each(function() {
        if (jQuery(this).attr("id") != "default" && !jQuery(this).hasClass("vicarious-content-section-default")) {
            vicarioushash = jQuery(this).attr("id").replace("vicarious-street-section-", "");
            jQuery(this).find(".categorychecklist input").each(function() {
                vicariouscat = jQuery(this);
                vicariouscat.attr("name", "post_category-" + vicarioushash + "[]");
                vicariouscat.attr("id", vicariouscat.attr("id") + "-" + vicarioushash);
            });
        }
    });
    if (jQuery(".vicarious-content-sections").length > 1) {
        jQuery(".vicarious-handle:first").after('<p class="dragdrop">&larr; (Drag & Drop Content Sections to Re-Order)</p>');
        jQuery(function() {
            jQuery("#settings-container").sortable({
                axis: "y",
                containment: "parent",
                forceHelperSize: !0,
                helper: "clone",
                opacity: .6
            });
            jQuery("#settings-container").disableSelection();
        });
    } else jQuery(".vicarious-handle").hide();
});