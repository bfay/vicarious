<?php
function childtheme_favicon() { ?>
    <link rel="shortcut icon" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/smashingMultiMediaBrown/images/favicon.ico" />
<?php }
 
add_action('wp_head', 'childtheme_favicon');

function childtheme_iefix() { ?>
	<!--[if IE]> 
		<link rel="stylesheet" media="all" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/smashingMultiMediaBrown/main_ie.css" /> 
	<![endif]-->
	<!--[if lte IE 6]> 
		<link rel="stylesheet" media="all" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/smashingMultiMediaBrown/main_lte_ie6.css" /> 
	<![endif]-->
<?php }
 
add_action('wp_head', 'childtheme_iefix');