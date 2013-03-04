<?php
/**
 * @package vicarious
 */
?>
<?php get_header(); ?>
<div id="content" class="home">
	<?php
	$vicarious_sections = get_option( '_vicarious_options' );
	$vicarious_sections = $vicarious_sections['sections'];
	global $vicarious_section_type, $vicarious_section_header, $vicarious_section_title, $vicarious_section_caption, $vicarious_section_num_posts, $vicarious_section_categories;
	global $foo;
	$foo = "FOO!";
	if($vicarious_sections) {
		foreach($vicarious_sections as $section) {
			$vicarious_section_type=$section['display_type'];
			$vicarious_section_header=$section['header'];
			$vicarious_section_title=$section['title'];
			$vicarious_section_caption=$section['caption'];
			$vicarious_section_num_posts=$section['num_posts'];
			$vicarious_section_categories=$section['categories'];



			/* TODO: Clean this up */
			switch($vicarious_section_type) {
				case 'lateralus_loop':
					get_template_part('partials/loops/loop', 'lateralus');
					break;
				case 'one_up_reg':
					$wp_query = new WP_Query(array('posts_per_page' => $vicarious_section_num_posts, 'cat' => implode(",",array_filter($vicarious_section_categories))));
					get_template_part('partials/loops/loop', 'oneup');
					break;
				case 'one_up_lg':
					$wp_query = new WP_Query(array('posts_per_page' => $vicarious_section_num_posts, 'cat' => implode(",",array_filter($vicarious_section_categories))));
					get_template_part('partials/loops/loop', 'oneuplarge');
					break;
				case 'two_up':
					$wp_query = new WP_Query(array('posts_per_page' => $vicarious_section_num_posts, 'cat' => implode(",",array_filter($vicarious_section_categories))));
					get_template_part('partials/loops/loop', 'twoup');
					break;
				case 'three_up':
					$wp_query = new WP_Query(array('posts_per_page' => $vicarious_section_num_posts, 'cat' => implode(",",array_filter($vicarious_section_categories))));
					get_template_part('partials/loops/loop', 'threeup');
					break;
				case 'four_up':
					$wp_query = new WP_Query(array('posts_per_page' => $vicarious_section_num_posts, 'cat' => implode(",",array_filter($vicarious_section_categories))));
					get_template_part('partials/loops/loop', 'fourup');
					break;
				default :
					get_template_part('partials/loops/loop');
			}		
		}
	} else {
		//Insert default loop
		get_template_part('partials/loops/loop');
	}
	?>
	<?php get_template_part('partials/post-pagination'); ?>
</div>
<?php get_footer(); ?>