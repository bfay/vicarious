<?php

// CREATE THE SETTINGS TABS IN WP ADMIN
if (!function_exists('vicarious_admin_tabs')) {
function vicarious_admin_tabs($current = 'general') {

	$tabs = array( 'general' => __('General Settings', 'vicarious_theme'),
	                'home' => __('Home Page Settings', 'vicarious_theme'));

	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';

	foreach($tabs as $tab => $name) {

		$class = ($tab == $current) ? ' nav-tab-active' : '';

        echo "<a class='nav-tab$class' href='?page=vicarious-settings&tab=$tab'>$name</a>";

    }

    echo '</h2>';

}
}

// OPTIONS HELPER FUNCTIONS

if(!function_exists('vicarious_add_warning')) {
  $vicarious_warnings = array();
  function vicarious_add_warning($warning_message) {
    global $vicarious_warnings;
    $vicarious_warnings[] = $warning_message;
  }
}

if(!function_exists('vicarious_post_value_or_default')) {
  function vicarious_post_value_or_default($val_name, $default) {

    $val = isset($_POST[$val_name]) ? $_POST[$val_name] : $default;
    switch (gettype($default)) {
      case "boolean":
        if (is_string($val)) {
          return $val != "";
        }
        return (bool)$val; // boolval() only exists in PHP >= 5.5.0
      case "integer":
        return intval($val);
      case "string":
        return strval($val);
      case "double":
        return doubleval($val);
      case "array":
        return is_array($val) ? $val : $default;
    }
    // We should never reach this point
    vicarious_add_warning("The type of option '" . $val_name . "' couldn't be determined.");
    return $val;
  }
}

if(!function_exists('vicarious_update_settings_button')) {
  function vicarious_update_settings_button($updated) {
		if ($updated) {
    	echo '<h4 class="saved-success">';
    	  echo '<img src="/wp-content/themes/vicarious/admin/images/success.png" />';
    	  _e('vicarious\'s Settings Have Been Updated.', 'vicarious_theme');
    	echo '</h4>';

    } else {

    	echo '<h4 class="info">';
    	  _e('Make Changes And Use The Update Settings Button To Save!', 'vicarious_theme');
    	  echo ' &rarr;';
    	echo '</h4>';
    }
  }
}

// BUILD THE CONTENT THAT DISPLAYS IN THEME SETTINGS
if (!function_exists('vicarious_build_settings_page')) {
function vicarious_build_settings_page() {
	global $pagenow;

	// SET FILE DIRECTORY
	$file_dir = get_template_directory_uri();
	
	// SETUP NEEDED STYLES & SCRIPTS FOR OPTIONS PAGE
	//wp_enqueue_script('jquery-ui-sortable' );
	//wp_enqueue_script('vicarious-admin', $file_dir . '/admin/js/vicarious-utils.js', 'jquery', NULL, TRUE);
	//wp_enqueue_style('vicarious-admin', $file_dir . '/admin/css/vicarious-options.css', NULL, NULL, NULL);

	// SET DEFAULT DATA FOR FIRST RUN
	$vicarious_defaults = array(
		'header'						=> true,
		'title'             => 'Section Title',
		'caption'           => 'Section Caption',
		'num_posts'         => 10
	);

	?>

	<div class="wrap">

		<h2>
		  <?php _e('vicarious Theme Settings', 'vicarious_theme'); ?>
		</h2>

		<?php if (isset($_GET['tab'])) { vicarious_admin_tabs($_GET['tab']); } else { vicarious_admin_tabs('general'); } ?>

		<form method="post" action="">

			<div id="settings-container"> <?php
			wp_nonce_field( 'vicarious_update_general', 'vicarious_general_key' );
			
			if ($pagenow == 'themes.php' && $_GET['page'] == 'vicarious-settings') {

				if (isset($_GET['tab'])) { $tab = $_GET['tab']; } else { $tab = 'general'; }

				switch ($tab) {

					// SETUP OPTIONS FOR GENERAL TAB
					case 'general' : ?>

					<h3 class="type-title"><?php _e('General Settings', 'vicarious_theme'); ?></h3>

					<?php

					$vicarious_updated = false;

					// PULL EXISTING SECTIONS, IF PRESENT
					$vicarious_general = get_option('_vicarious_options');

					if (!empty($_POST) && wp_verify_nonce($_POST['vicarious_general_key'], 'vicarious_update_general')) {
					  $vicarious_general['header'] = vicarious_post_value_or_default('vicarious-general-header', '');
					  $vicarious_general['footer'] = vicarious_post_value_or_default('vicarious-general-footer', '');
					  $vicarious_general['tweet_post_button'] = vicarious_post_value_or_default('vicarious-general-tweet-post-button', false);
					  $vicarious_general['tweet_post_attribution'] = vicarious_post_value_or_default('vicarious-general-tweet-post-attribution', '');

						update_option( '_vicarious_options', $vicarious_general );
						$vicarious_updated = true;

					}

					// IF THERE'S NOTHING, SET DEFAULTS
					if(empty($vicarious_general)) {

						$vicarious_general = array(
							'header'      					=> '',
							'footer'            			=> '',
							'tweet_post_button' 			=> false,
							'tweet_post_attribution' 		=> '',
						);

					} ?>

					<div class="button-container">

						<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious_theme'); ?>" />

						<?php vicarious_update_settings_button($vicarious_updated); ?>

					</div><!-- // BUTTON CONTAINER -->

					<!-- CUSTOM HEADER CODE -->
					<div id="first-option" class="option-container">
						<label class="feature-title"><?php _e('Custom Header Code', 'vicarious_theme'); ?></label>
						<div class="feature">
							<textarea name="vicarious-general-header" class="textarea"><?php echo esc_html(stripslashes($vicarious_general['header'])); ?></textarea>
						</div>
						<div class="feature-desc">
							<?php
							  _e('This feature allows you to write or copy and paste your own code straight into the header. Many people use this feature to include their Google Analytics code, or other small bits of Javascript. Feel free to use this as you wish!', 'vicarious_theme');
							?>
						</div>
						<div style="clear:both;"></div>
					</div>


					<!-- CUSTOM FOOTER CODE -->
					<div class="option-container">
						<label class="feature-title"><?php _e('Custom Footer Code', 'vicarious_theme'); ?></label>
						<div class="feature">
							<textarea name="vicarious-general-footer" class="textarea"><?php echo esc_html(stripslashes($vicarious_general['footer'])); ?></textarea>
						</div>
						<div class="feature-desc">
						<?php
							_e('This feature allows you to write or copy and paste your own code directly to the footer. A lot of people use this feature to include external and internal Javascript files, for plugins and things of the sort. Use it as you wish!', 'vicarious_theme');
						?>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- TWEET THIS OPTION -->
					<div class="option-container">
						<label class="feature-title"><?php _e('Tweet This', 'vicarious_theme'); ?></label>
						<div class="feature">
							<input type="checkbox"
								   name="vicarious-general-tweet-post-button"
								   class="checkbox"
								   value="tweet_post_button" 
									<?php checked( $vicarious_general['tweet_post_button']); ?>
								/>

							<label for="vicarious-general-tweet-post-button">
								<?php _e('Add a "Tweet This Post" Button to Post Templates.', 'vicarious_theme'); ?>
							</label>
						</div>
						<div class="feature-desc">
						  <?php
							  _e('This feature gives you the option to integrate a little bit of social networking directly into your posts. By turning this feature on, we\'ll automatically create a "Tweet" Button people can use to share your content!', 'vicarious_theme');
							?>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- TWEET THIS HANDLE -->
					<div class="option-container optional-container" controlling-checkbox="vicarious-general-tweet-post-button">
						<label class="feature-title"><?php _e('Twitter Handle', 'vicarious_theme'); ?></label>
						<div class="feature">
							<input type="text"
								   name="vicarious-general-tweet-post-attribution"
								   class="text"
								   value="<?php echo esc_attr(stripslashes($vicarious_general['tweet_post_attribution'])); ?>" />
						</div>
						<div class="feature-desc">
							<?php
							  _e('By entering your handle once right here, you can easily reference this setting throughout the theme and change it later with ease, if needed. Refrain from using the \'@\' sign. An example handle: \'lateralus\'.', 'vicarious_theme');
							?>
						</div>
						<div style="clear:both;"></div>
					</div>			

					 <?php
						
					break;

					case 'home' : ?>

					<h3 class="type-title">
					  <?php _e('Home Page Settings', 'vicarious_theme'); ?>
					</h3>
					<?php

					wp_nonce_field('vicarious_update_home_sections', 'vicarious_key');

					// GET EXISTING SECTIONS, IF PRESENT
					$vicarious_sections = get_option('_vicarious_options');
					$vicarious_updated 	= false;
					if (!empty($_POST) && wp_verify_nonce($_POST['vicarious_key'], 'vicarious_update_home_sections')) {

						$sections 		= array();

						foreach($_POST as $key => $value) {

							$keyflag = 'vicarious-display-type-';

							if(substr($key, 0, strlen($keyflag)) == $keyflag) {

								// FIND ID FLAG
								$vicarious_section_flag = substr($key, strlen($keyflag), strlen($key));

								// SINCE WE'RE PIGGY-BACKING SOME WP CORE FUNCTIONALTITY, THE POST
								// CATEGORIES HAVE A SLIGHTLY DIFFERENT ID DEPENDING ON WHAT WAS FIRST

								if($vicarious_section_flag == 'default') {

									echo $vicarious_post_category_flag = '';

								} else {

									$vicarious_post_category_flag = '-' . $vicarious_section_flag;

								}

								// ADD OUR DATA
								$sections[] = array(
                  'display_type'      => vicarious_post_value_or_default('vicarious-display-type-' . $vicarious_section_flag, 'default_loop'),
                  'header'      => vicarious_post_value_or_default('vicarious-section-header-' . $vicarious_section_flag, false),
                  'title'      => vicarious_post_value_or_default('vicarious-section-title-' . $vicarious_section_flag, ''),
                  'caption'      => vicarious_post_value_or_default('vicarious-section-caption-' . $vicarious_section_flag, ''),
                  'num_posts'      => vicarious_post_value_or_default('vicarious-section-num-posts-' . $vicarious_section_flag, 10),
                  'categories'      => vicarious_post_value_or_default('post_category-' . $vicarious_section_flag, array()),
								);

							}

						} // END FOREACH LOOP

						$vicarious_sections['sections'] = $sections;
						update_option('_vicarious_options', $vicarious_sections);
						$vicarious_updated = true;

					}

					$vicarious_sections = $vicarious_sections['sections'];

					// IF NOTHING'S SET, SET DEFAULTS
					if(empty($vicarious_sections)) {

						$vicarious_sections['sections'] = array(
							'display_type'      => 'default_loop',
							'header'             => false,
							'title'             => '',
							'caption'           => '',
							'num_posts'         => 10,
							'categories'        => array(),
							'default'           => true
						);

					} ?>

					<div class="button-container">

						<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious_theme'); ?>" />

					<?php vicarious_update_settings_button($vicarious_updated); ?>

					</div><!-- // BUTTON CONTAINER --> 
					
					<div class="helper-container">
						<p class="section-helper">
						  <?php
							  _e('Content Sections give you the opportunity to create a dynamic homepage for you to keep your readers engaged. With a vast variety of different layouts, you have the choice to select a look that works best for you.', 'vicarious_theme');
							?>
						</p>
					</div>

					<div style="clear:both;"></div>

					<div id="vicarious-content-sections">						
					<?php

					foreach($vicarious_sections as $vicarious_section_id => $vicarious_section) : ?>

					<div class="vicarious-content-sections" id="vicarious-street-section-<?php echo $vicarious_section_id; ?>">

						<h3 class="content-titles">
							<?php _e('Content Section', 'vicarious_theme'); ?>
							<span class="vicarious-handle"></span>
							<a class="vicarious-content-section-delete" href="#">&times;</a>
						</h3>

						<div class="content-group">
							<?php
							$the_type = $vicarious_section['display_type'];
							$checkbox_name = "vicarious-section-header-" . (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id);
							?>
							<div class="main-options-container">
								<!-- // DISPLAY TYPES -->
								<div class="display-types">
									<label class="section-title"><?php _e('Display Type:', 'vicarious_theme'); ?></label>
									<select name="vicarious-display-type-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>" class="dropmenu option-display-type">
										<option<?php if($the_type == 'default_loop') { ?> selected="selected"<?php } ?> value="default_loop"><?php _e('Default Loop', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'one_up_reg' ) { ?> selected="selected"<?php } ?> value="one_up_reg"><?php _e('One Up (Regular)', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'one_up_lg' ) { ?> selected="selected"<?php } ?> value="one_up_lg"><?php _e('One Up (Large)', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'two_up' ) { ?> selected="selected"<?php } ?> value="two_up"><?php _e('Two Up', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'three_up' ) { ?> selected="selected"<?php } ?> value="three_up"><?php _e('Three Up', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'four_up' ) { ?> selected="selected"<?php } ?> value="four_up"><?php _e('Four Up', 'vicarious_theme'); ?></option>
										<option<?php if($the_type == 'lateralus_loop' ) { ?> selected="selected"<?php } ?> value="lateralus_loop"><?php _e('Some Random Dude Loop', 'vicarious_theme'); ?></option>
									</select>
								</div>
								<div style="clear:both;"></div>
							</div>
							
							<div class="top-options-container">
	
								

								<!-- // SECTION HEADER TOGGLE -->
								<div class="display-headers">
									<input type="checkbox"
								   name=<?php echo $checkbox_name ?>
									class="checkbox"
									value="section_header"
									<?php 
									$value = !isset($vicarious_section['default']) ? stripslashes($vicarious_section['header']) : $vicarious_defaults['header'];
									checked($value); 
									?>
									/>
									<label class="section-title inline">
									<?php
									  _e('Display section header', 'vicarious_theme');
									?>
									</label>
								</div>

								<!-- // SECTION TITLE -->
								<div class="display-titles optional-container" controlling-checkbox=<?php echo $checkbox_name ?> >
									<label class="section-title"><?php _e('Section Title:', 'vicarious_theme'); ?></label>
									<input type="text"
										   class="text text-title"
										   name="vicarious-section-title-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
										   <?php
                        $val_str = isset($vicarious_section['default']) ?  $vicarious_defaults['title'] : stripslashes($vicarious_section['title']);
                        echo 'value="' . esc_attr($val_str) . '"';
										   ?>
									/>
								</div>
								
								<!-- // POSTS TO DISPLAY -->
								<div class="display-posts">
									<label class="section-title"><?php _e('Number of Posts:', 'vicarious_theme'); ?></label>
									<input type="text"
										   class="text"
										   name="vicarious-section-num-posts-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
										   <?php
                        $val_str = isset($vicarious_section['default']) ?  $vicarious_defaults['num_posts'] : stripslashes($vicarious_section['num_posts']);
                        echo 'value="' . esc_attr($val_str) . '"';
										   ?>
     						  />
								</div>

							</div><!-- // END TOP OPTIONS CONTAINER -->
							</div>
							<div style="clear:both;"></div>
	
							<div class="bottom-options-container">
								
								<!-- // SECTION CAPTIONS -->
								<div class="display-captions optional-container" controlling-checkbox=<?php echo $checkbox_name ?> >
									<label class="section-title"><?php _e('Section Caption:', 'vicarious_theme'); ?></label>
									<textarea name="vicarious-section-caption-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
									  <?php
									    $caption_txt = isset($vicarious_section['default']) ? $vicarious_defaults['caption'] : stripslashes($vicarious_section['caption']);
									    echo 'class="textarea">' . esc_textarea($caption_txt);
									  ?>
									</textarea>
								</div>
								
								
								<!-- // CATEGORIES TO DISPLAY -->
								<div class="display-categories">
									<label class="section-title"><?php _e('Categories to Display', 'vicarious_theme'); ?></label>
									<div class="categories-container">
										<ul class="categorychecklist">
											<?php wp_terms_checklist(); ?>
										</ul>
										
										<div style="clear:both;"></div>
										
										<ul class="vicarious-group">
											<li><a class="select-button vicarious-select" href="#"><?php _e('Select All', 'vicarious_theme'); ?></a></li>
											<li><a class="select-button vicarious-deselect" href="#"><?php _e('Deselect All', 'vicarious_theme'); ?></a></li>
										</ul>
										<div style="clear:both;"></div>
									</div>
	
									<div style="clear:both;"></div>
	
									<?php $categories = $vicarious_section['categories']; ?>
									
									<script type="text/javascript">
									jQuery(document).ready(function() {
										<?php if (is_array($categories)) : ?>
										<?php foreach($categories as $category) : ?>

											jQuery('#vicarious-street-section-<?php echo $vicarious_section_id; ?> .categorychecklist input').each(function(){

												if(jQuery(this).val() == <?php echo $category; ?>) {

													jQuery(this).attr('checked', true);

												}

											});

										<?php endforeach; ?>
										<?php endif; ?>

									});
									</script>
	
								</div>
	
							</div><!-- //  END BOTTOM OPTIONS CONTAINER -->
	
							<div style="clear:both;"></div>
	
						
	
						<div style="clear:both;"></div>
	
					</div><!-- // vicarious CONTENT SECTIONS --> <?php 
					
					endforeach; ?>
				</div>
					<div id="vicarious-add-content-section">
						<a href="#"><?php _e('+ Add New Section +', 'vicarious_theme'); ?></a>
					</div> <?php 
					
					break;

					} // END CASE "HOME"

				} /* END SWITCH STATEMENT */ ?>

				<div class="button-container bottom">

					<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious_theme'); ?>" />

				<?php vicarious_update_settings_button($vicarious_updated); ?>

				</div><!-- // BUTTON CONTAINER -->

			</div><!-- // SETTINGS CONTAINER -->

		</form><!-- // END FORM -->
		
    <?php
      global $vicarious_warnings;
      if (defined('WP_DEBUG')  && (WP_DEBUG == true)) {
        if (isset($vicarious_warnings)) {
          foreach ($vicarious_warnings as $warning) {
            echo "<p><b>Warning from vicarious:</b> " . $warning . "</p>";
          }
        }
      }
    ?>

	</div><!-- // WRAP -->

<?php } } ?>