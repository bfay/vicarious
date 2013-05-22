<?php
/**
 * @package vicarious
 */
?>
<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	
	<title>
		<?php wp_title('&mdash;',true,'right'); ?>
 		<?php bloginfo('name'); ?>
	</title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Bitter:400,700|Karla:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37218996-1']);
  _gaq.push(['_setDomainName', 'rockinguitarlessons.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>	
</head>
<body id="page" <?php body_class(); ?>>
	<!--[if lt IE 9]>
		<div class="chromeframe">Your browser is out of date. Please <a href="http://browsehappy.com/">upgrade your browser </a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a>.</div>
	<![endif]-->
<div class="my_container">
<div class="content_bg twelve columns">
	<div class="red-topper">	
		<nav class="site-nav eight columns" role="navigation">
			<?php if ( !dynamic_sidebar("Navigation") ) : ?>
				<?php wp_nav_menu( array('theme_location' => 'vicarious_primary_navigation', 'container' => false ) ); ?>	
			<?php endif; ?> 
		</nav>
	<header id="page-header" class="row" role="banner">
	<div class="twelve columns header-bg">
		
		<hgroup id="site-title-description">
			<img class="logo seven columns offset-five" src="http://images.rockinguitarlessons.com/logo.png" alt="Rockin Guitar Lessons Logo"/>
		</hgroup>
		
		</div>


		<?php /*if ( is_active_sidebar("widget-subheader") ) : ?>
		<div id='sub_header' class='row'>
			<?php if ( !dynamic_sidebar("Sub Header") ) : ?>
			<?php endif; ?>
		</div>
		<?php endif; */?>
	</header>
