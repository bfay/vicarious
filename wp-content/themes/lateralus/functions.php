<?php
#add_action('wp_enqueue_scripts', 'vicarious_enqueue_scripts');
#add_action('wp_enqueue_scripts', 'vicarious_enqueue_scripts');

require_once('admin/lateralus-theme-options.php');
if (!is_admin()) {  
	add_action('init', 'vicarious_enqueue_scripts');
	add_action('init', 'vicarious_enqueue_styles');  
}  

function vicarious_init() {
	wp_deregister_script( 'l10n' );
}

function vicarious_devmode() {
	$vicarious_general = get_option( '_vicarious_options' );
	if($vicarious_general) return $vicarious_general['devmode'];
}

function vicarious_meta_keywords() {
	global $post;
	
	$keywords = array();
	$tags = get_the_tags();
	if($tags) {
		foreach($tags as $tag) { 
			array_push($keywords, $tag->name);
		}
	}

	$categories = get_the_category();
	if($categories) {
		foreach($categories as $category) { 
			array_push($keywords, $category->name);
		}
	}
	
	print(get_the_author());
	$meta = '<meta name="keywords" content="';
	$meta .= implode(',', $keywords);
	$meta .= '" />';
	echo $meta;

}

function vicarious_theme_options() {
	vicarious_build_settings_page();
}

function vicarious_enqueue_scripts() {
	
	global $wp_scripts;
	
	wp_register_script('lateralus', (get_stylesheet_directory_uri().'/js/lateralus.js'), false, '1.0', true);
	wp_enqueue_script('lateralus');
	
	$vicarious_general = get_option( '_vicarious_options' );
	if($vicarious_general['inject_js']) {
		add_action('wp_print_scripts', 'vicarious_remove_all_scripts', 100);
		add_action('wp_footer', 'vicarious_print_scripts');
	}
	
}

function vicarious_remove_all_scripts() {
    global $wp_scripts;
    global $vicarious_scripts;
    $scripts = $wp_scripts->queue;
    $vicarious_scripts = array();

    for($i=0; $i<count($scripts); $i++) {
			array_push($vicarious_scripts, $wp_scripts->registered[$scripts[$i]]->src);
		}
    
    $wp_scripts->queue = array();
}

function vicarious_print_scripts() {
	global $vicarious_scripts;

	global $wp_scripts;
	$scripts = $vicarious_scripts;
	echo '<script>';
	for($i=0; $i<count($scripts); $i++) {
		$url = parse_url($scripts[$i]);

		if($url['host']=='') {
			$url=site_url().$url['path'];
		} else {
			$url = $scripts[$i];
		}
		$js = wp_remote_get($url, array('timeout'=>300));
		$js_body = wp_remote_retrieve_body($js);
		echo $js_body;
	}
	echo '</script>';
}

function vicarious_enqueue_styles() {
	
	global $wp_styles;
	
	wp_register_style('vicarious_lateralus_stylesheet', get_stylesheet_directory_uri().'/style.css', null, '0.1', 'all' );
	
	wp_register_style('vicarious_lateralus_stylesheet_ie', get_stylesheet_directory_uri().'/ie.css', null, '0.1', 'all' );
	wp_register_style('vicarious_lateralus_stylesheet_ie7', get_stylesheet_directory_uri().'/ie7.css', null, '0.1', 'all' );
	
	$wp_styles->add_data('vicarious_lateralus_stylesheet_ie', 'conditional', 'IE');
	$wp_styles->add_data('vicarious_lateralus_stylesheet_ie7', 'conditional', 'IE 7');
	
	wp_enqueue_style('vicarious_lateralus_stylesheet');
	wp_enqueue_style('vicarious_lateralus_stylesheet_ie');
	wp_enqueue_style('vicarious_lateralus_stylesheet_ie7');
	
}

?>
