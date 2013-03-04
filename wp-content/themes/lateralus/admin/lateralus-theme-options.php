<?php

// LAST UPDATED AT 3AM ON SEPTEMBER 25TH, 2012

//add_action( 'admin_menu', 'vicariousSettingsPageInit' );

// REGISTER NEW SETTINGS PAGE WITH WORDPRESS
/*
function vicariousSettingsPageInit() {

	$vicariousSettings = add_menu_page( 'Theme Settings', 'Theme Settings', 'edit_theme_options', 'vicarious-settings', 'vicarious_build_settings_page' );

	add_action( "load-{$vicariousSettings}", 'vicariousLoadSettingsPage' );

}
*/

// CREATE THE SETTINGS TABS IN WP ADMIN
function vicarious_admin_tabs($current = 'general') {

	$tabs = array( 'general' => 'General Settings', 'home' => 'Home Page Settings');

	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';

	foreach($tabs as $tab => $name) {

		$class = ($tab == $current) ? ' nav-tab-active' : '';

        echo "<a class='nav-tab$class' href='?page=vicarious-settings&tab=$tab'>$name</a>";

    }

    echo '</h2>';

}

// BUILD THE CONTENT THAT DISPLAYS IN THEME SETTINGS
function vicarious_build_settings_page() {
	global $pagenow;

	// SET FILE DIRECTORY
	$file_dir = get_bloginfo('template_directory');
	
	// SETUP NEEDED STYLES & SCRIPTS FOR OPTIONS PAGE
	//wp_enqueue_script('jquery-ui-sortable' );
	//wp_enqueue_script('vicarious-admin', $file_dir . '/admin/js/vicarious-utils.js', 'jquery', NULL, TRUE);
	//wp_enqueue_style('vicarious-admin', $file_dir . '/admin/css/vicarious-options.css', NULL, NULL, NULL);

	// SET DEFAULT DATA FOR FIRST RUN
	$vicarious_defaults = array(
		'title'             => 'Section Title',
		'caption'           => 'Section Caption',
		'num_posts'         => 10
	);

	?>

	<div class="wrap">

		<h2>vicarious Theme Settings</h2>

		<?php if (isset($_GET['tab'])) { vicarious_admin_tabs($_GET['tab']); } else { vicarious_admin_tabs('general'); } ?>

		<form method="post" action="">

			<div id="settings-container"> <?php
			wp_nonce_field( 'vicarious_update_general', 'vicarious_general_key' );
			
			if ($pagenow == 'themes.php' && $_GET['page'] == 'vicarious-settings') {

				if (isset($_GET['tab'])) { $tab = $_GET['tab']; } else { $tab = 'general'; }

				switch ($tab) {

					// SETUP OPTIONS FOR GENERAL TAB
					case 'general' : ?>

					<h3 class="type-title">General Settings</h3>

					<?php

					$vicarious_updated = false;

					// PULL EXISTING SECTIONS, IF PRESENT
					$vicarious_general = get_option('_vicarious_options');

					if (!empty($_POST) && wp_verify_nonce($_POST['vicarious_general_key'], 'vicarious_update_general')) {

						$vicarious_general['header']					= $_POST['vicarious-general-header'];
						$vicarious_general['footer']					= $_POST['vicarious-general-footer'];
						$vicarious_general['devmode']					= $_POST['vicarious-general-devmode'];
						$vicarious_general['inject_js']					= $_POST['vicarious-general-inject-js'];
						$vicarious_general['tweet_post_button']			= $_POST['vicarious-general-tweet-post-button'];
						$vicarious_general['tweet_post_attribution']	= $_POST['vicarious-general-tweet-post-attribution'];

						update_option( '_vicarious_options', $vicarious_general );

						$vicarious_updated = true;

					}

					// IF THERES NOTHING, SET DEFAULTS
					if(empty($vicarious_general)) {

						$vicarious_general[] = array(
							'header'      					=> '',
							'footer'            			=> '',
							'tweet_post_button' 			=> false,
							'tweet_post_attribution' 		=> '',
							'devmode'						=> '',
							'inject_js'						=> ''
						);

					} ?>

					<div class="button-container">

						<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious'); ?>" />

						<?php

						if ($vicarious_updated) {

							echo '<h4 class="saved-success">';
							echo '<img src="/wp-content/themes/vicarious/admin/images/success.png" /> vicariouslin Street Theme Settings Have Been Updated.';
							echo '</h4>';

						} else {

							echo '<h4 class="info">';
							echo 'Make Changes And Use The Update Settings Button To Save! &rarr;';
							echo '</h4>';

						}

						?>

					</div><!-- // BUTTON CONTAINER -->

					<!-- CUSTOM HEADER CODE -->
					<div id="first-option" class="option-container">
						<h3 class="feature-title"><?php _e('Custom Header Code', 'vicarious'); ?></h3>
						<div class="feature">
							<textarea name="vicarious-general-header" class="textarea"><?php echo stripslashes($vicarious_general['header']); ?></textarea>
						</div>
						<div class="feature-desc">
							This features allows you to write or copy & paste your own code straight
							into the header. Many people use this feature to include their Google Analytics
							code, or other small bits of Javascript. Feel free to use this as you wish!
						</div>
						<div style="clear:both;"></div>
					</div>


					<!-- CUSTOM FOOTER CODE -->
					<div class="option-container">
						<h3 class="feature-title"><?php _e('Custom Footer Code', 'vicarious'); ?></h3>
						<div class="feature">
							<textarea name="vicarious-general-footer" class="textarea"><?php echo stripslashes($vicarious_general['footer']); ?></textarea>
						</div>
						<div class="feature-desc">
							This feature allows you to write or copy & paste your own code directly
							to the footer. A lot of people use this feature to include external & internal
							Javascript files, for plugins and things of the sort. Use it as you wish!
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- TWEET THIS OPTION -->
					<div class="option-container">
						<h3 class="feature-title"><?php _e('Tweet This', 'vicarious'); ?></h3>
						<div class="feature">
							<input type="checkbox"
								   name="vicarious-general-tweet-post-button"
								   class="checkbox"
								   value="tweet_post_button" 
									<?php checked( $vicarious_general['tweet_post_button'], "tweet_post_button" ); ?>
								/>

							<label for="vicarious-general-tweet-post-button">
								<?php _e('Add a "Tweet This Post" Button to Post Templates.', 'vicarious'); ?>
							</label>
						</div>
						<div class="feature-desc">
							This feature gives you the option to integrate a little bit of social
							networking directly into your posts. By turning this feature on, we'll automatically
							create a "Tweet" Button people can use to share your content!
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- TWEET THIS HANDLE -->
					<div class="option-container">
						<h3 class="feature-title"><?php _e('Twitter Handle', 'vicarious'); ?></h3>
						<div class="feature">
							<input type="text"
								   name="vicarious-general-tweet-post-attribution"
								   class="text"
								   value="<?php echo stripslashes($vicarious_general['tweet_post_attribution']); ?>" />
						</div>
						<div class="feature-desc">
							By entering your handle once right here, you can easily reference
							this setting throughout the theme and change it later with ease, if needed.
							Refrain from using the '@' sign. An example handle: 'lateralus'
						</div>
						<div style="clear:both;"></div>
					</div>

					<!-- INJECT JS -->
					<div id="inject-js" class="option-container">
						<h3 class="feature-title"><?php _e('Inject JS Into Footer', 'vicarious'); ?></h3>
						<div class="feature">
							<input type="checkbox"
								   name="vicarious-general-inject-js"
								   class="checkbox"
									value="inject-js"
									<?php checked( $vicarious_general['inject_js'], "inject-js" ); ?>
								/>
							<label for="vicarious-general-inject-js"><?php _e('Inject Javascript Into Footer', 'vicarious'); ?></label>
						</div>
						<div class="feature-desc">
							Adds your Javascript code directly into the HTML above the closing body tag. This will save you a file request and potentially lower page load times. <strong>This setting should only be activated if you have very few unique pages and/or your Javascript file is less than 15Kb in size.</strong>
						</div>
						<div style="clear:both;"></div>	
					</div>				

					<!-- DEVELOPER MODE -->
					<div id="devmode" class="option-container">
						<h3 class="feature-title"><?php _e('Developer Mode', 'vicarious'); ?></h3>
						<div class="feature">
							<input type="checkbox"
								   name="vicarious-general-devmode"
								   class="checkbox"
									value="devmode"
									<?php checked( $vicarious_general['devmode'], "devmode" ); ?>
								/>
							<label for="vicarious-general-devmode"><?php _e('Turn Developer Mode On', 'vicarious'); ?></label>
						</div>
						<div class="feature-desc">
							I'm not exactly sure what this feature does, but of course you can
							edit this feature description, as well as all the feature descriptions
							above ^.
						</div>
						<div style="clear:both;"></div>
					</div> <?php
						
					break;

					case 'home' : ?>

					<h3 class="type-title">Home Page Settings</h3> <?php

					wp_nonce_field('vicarious_update_home_sections', 'vicarious_key');

					// GET EXISTING SECTIONS, IF PRESENT
					$vicarious_sections = get_option('_vicarious_options');

					if (!empty($_POST) && wp_verify_nonce($_POST['vicarious_key'], 'vicarious_update_home_sections')) {

						$vicarious_updated 	= false;
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
									'display_type'      => $_POST['vicarious-display-type-' . $vicarious_section_flag],
									'header'             => $_POST['vicarious-section-header-' . $vicarious_section_flag],
									'title'             => $_POST['vicarious-section-title-' . $vicarious_section_flag],
									'caption'           => $_POST['vicarious-section-caption-' . $vicarious_section_flag],
									'num_posts'         => intval( $_POST['vicarious-section-num-posts-' . $vicarious_section_flag]),
									'categories'        => $_POST['post_category' . $vicarious_post_category_flag]
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
							'num_posts'         => '',
							'categories'        => array(),
							'default'           => true
						);

					} ?>

					<div class="button-container">

						<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious'); ?>" />

						<?php

						if ($vicarious_updated) {

							echo '<h4 class="saved-success">';
							echo '<img src="/wp-content/themes/vicarious/admin/images/success.png" /> vicariouslin Street Theme Settings Have Been Updated.';
							echo '</h4>';

						} else {

							echo '<h4 class="info">';
							echo 'Make Changes And Use The Update Settings Button To Save! &rarr;';
							echo '</h4>';

						}

						?>

					</div><!-- // BUTTON CONTAINER --> 
					
					<div class="helper-container">
						<p class="section-helper">
							Content Sections give you the opportunity to create a dynamic homepage 
							for you to keep your readers engaged. With a vast variety of different layouts,
							you have the choice to select a look that works best for you.
						</p>
					</div>

					<div style="clear:both;"></div>

											
					<?php

					foreach($vicarious_sections as $vicarious_section_id => $vicarious_section) : ?>

					<div class="vicarious-content-sections" id="vicarious-street-section-<?php echo $vicarious_section_id; ?>">

						<h3 class="content-titles">
							<?php _e('Content Section', 'vicarious'); ?>
							<span class="vicarious-handle"></span>
							<a class="vicarious-content-section-delete" href="#">X</a>
						</h3>

						<div class="content-group">

							<div class="top-options-container">
	
								<?php $the_type = $vicarious_section['display_type']; ?>
								

								<!-- // SECTION HEADER TOGGLE -->
								<div class="display-headers">
									<input type="checkbox"
								   name="vicarious-section-header-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
									class="checkbox"
									value="section_header"
									<?php 
									$value = !isset($vicarious_section['default']) ? stripslashes($vicarious_section['header']) : $vicarious_defaults['header'];
									checked( $value, "section_header" ); 
									?>
									/>
									<label>Display section header</label>
								</div>

								<!-- // SECTION TITLE -->
								<div class="display-titles">
									<h3 class="section-title"><?php _e('Section Title:', 'vicarious'); ?></h3>
									<input type="text"
										   class="text text-title"
										   name="vicarious-section-title-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
										   value="<?php echo !isset($vicarious_section['default']) ? stripslashes($vicarious_section['title']) : $vicarious_defaults['title']; ?>" />
								</div>
								
								<!-- // POSTS TO DISPLAY -->
								<div class="display-posts">
									<h3 class="section-title"><?php _e('Number of Posts:', 'vicarious'); ?></h3>
									<input type="text"
										   class="text"
										   name="vicarious-section-num-posts-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>"
										   value="<?php echo !isset($vicarious_section['default']) ? stripslashes($vicarious_section['num_posts']) : $vicarious_defaults['num_posts']; ?>" />
								</div>
								
								<!-- // DISPLAY TYPES -->
								<div class="display-types">
									<h3 class="section-title"><?php _e('Display Type:', 'vicarious'); ?></h3>
									<select name="vicarious-display-type-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>" class="dropmenu">
										<option<?php if($the_type == 'default_loop') { ?> selected="selected"<?php } ?> value="default_loop"><?php _e('Default Loop', 'vicarious'); ?></option>
										<option<?php if($the_type == 'one_up_reg' ) { ?> selected="selected"<?php } ?> value="one_up_reg"><?php _e('One Up (Regular)', 'vicarious'); ?></option>
										<option<?php if($the_type == 'one_up_lg' ) { ?> selected="selected"<?php } ?> value="one_up_lg"><?php _e('One Up (Large)', 'vicarious'); ?></option>
										<option<?php if($the_type == 'two_up' ) { ?> selected="selected"<?php } ?> value="two_up"><?php _e('Two Up', 'vicarious'); ?></option>
										<option<?php if($the_type == 'three_up' ) { ?> selected="selected"<?php } ?> value="three_up"><?php _e('Three Up', 'vicarious'); ?></option>
										<option<?php if($the_type == 'four_up' ) { ?> selected="selected"<?php } ?> value="four_up"><?php _e('Four Up', 'vicarious'); ?></option>
										<option<?php if($the_type == 'lateralus_loop' ) { ?> selected="selected"<?php } ?> value="lateralus_loop"><?php _e('Some Random Dude Loop', 'vicarious'); ?></option>
									</select>
								</div>

							</div><!-- // END TOP OPTIONS CONTAINER -->
	
							<div style="clear:both;"></div>
	
							<div class="bottom-options-container">
								
								<!-- // SECTION CAPTIONS -->
								<div class="display-captions">
									<h3 class="section-title"><?php _e('Section Caption:', 'vicarious'); ?></h3>
									<textarea name="vicarious-section-caption-<?php echo (isset($vicarious_section['default']) ? 'default' : $vicarious_section_id); ?>" class="textarea"><?php echo !isset($vicarious_section['default']) ? stripslashes($vicarious_section['caption']) : $vicarious_defaults['caption']; ?></textarea>
								</div>
								
								
								<!-- // CATEGORIES TO DISPLAY -->
								<div class="display-categories">
									<h3 class="section-title"><?php _e('Categories to Display', 'vicarious'); ?></h3>
									<div class="categories-container">
										<ul class="categorychecklist">
											<?php wp_terms_checklist(); ?>
										</ul>
										
										<div style="clear:both;"></div>
										
										<ul class="vicarious-group">
											<li><a class="select-button vicarious-select" href="#"><?php _e('Select All', 'vicarious'); ?></a></li>
											<li><a class="select-button vicarious-deselect" href="#"><?php _e('Deselect All', 'vicarious'); ?></a></li>
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
	
						</div>
	
						<div style="clear:both;"></div>
	
					</div><!-- // vicarious CONTENT SECTIONS --> <?php 
					
					endforeach; ?>

					<div id="vicarious-add-content-section">
						<a href="#"><?php _e('+ Add New Section +', 'vicarious'); ?></a>
					</div> <?php 
					
					break;

					} // END CASE "HOME"

				} /* END SWITCH STATEMENT */ ?>

				<div class="button-container bottom">

					<input type="submit" name="submit"  class="save-settings" value="<?php _e('Update Settings', 'vicarious'); ?>" />

					<?php

					if ($vicarious_updated) {

						echo '<h4 class="saved-success">';
						echo '<img src="/wp-content/themes/vicarious/admin/images/success.png" /> vicariouslin Street Theme Settings Have Been Updated.';
						echo '</h4>';

					} else {

						echo '<h4 class="info">';
						echo 'Make Changes And Use The Update Settings Button To Save! &rarr;';
						echo '</h4>';

					}

					?>

				</div><!-- // BUTTON CONTAINER -->

			</div><!-- // SETTINGS CONTAINER -->

		</form><!-- // END FORM -->

	</div><!-- // WRAP -->

<?php } ?>