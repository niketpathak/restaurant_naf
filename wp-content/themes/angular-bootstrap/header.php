<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package _tk
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?> ng-app="wp">
<head>
<base href="/">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>
	<div id="masthead" class="menu navbar navbar-static-top header-logo-left-menu-right oxy-mega-menu navbar-sticky  text-none" role="banner">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php $header_image = get_header_image();
				if ( ! empty( $header_image ) ) { ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
					</a>
				<?php } // end if ( ! empty( $header_image ) ) ?>
				<div class="navbar-brand">
					<a href="<?php echo esc_url( home_url( '/#/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<span>
						<?php bloginfo( 'description' ); ?>
					</span>
				</div>
			</div>
			<div class="nav-container">
				<nav class="collapse navbar-collapse main-navbar logo-navbar navbar-right" role="navigation">
					<div class="menu-container"><ul id="menu-main" class="nav navbar-nav">
							<!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only"><?php _e('Toggle navigation','_tk') ?> </span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<!-- The WordPress Menu goes here -->
							<?php wp_nav_menu(
								array(
									'theme_location' 	=> 'primary',
									'depth'             => 2,
									'container'         => 'div',
									'container_class'   => 'collapse navbar-collapse',
									'menu_class' 		=> 'nav navbar-nav',
									'fallback_cb' 		=> 'wp_bootstrap_navwalker::fallback',
									'menu_id'			=> 'main-menu',
									'walker' 			=> new wp_bootstrap_navwalker()
								)
							); ?>
						</ul></div>
					<div class="menu-sidebar">
						<div id="oxywidgetsocial-5" class="sidebar-widget  widget_social">
							<ul class="unstyled inline social-icons social-simple social-normal">
								<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>

<div class="main-content outermost">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>
	<div class="container-fluid">
		<div class="row">
			<div id="content_out" class="main-content-inner">
