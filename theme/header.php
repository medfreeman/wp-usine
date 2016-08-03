<?php
/**
 * Header file common to all
 * templates
 *
 */
?>
<!doctype html>
<html class="site no-js" <?php language_attributes(); ?>>
<head>
	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
	<![endif]-->

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<?php // replace the no-js class with js on the html element ?>
	<script>document.documentElement.className=document.documentElement.className.replace(/\bno-js\b/,'js')</script>

	<?php // load the core js polyfills ?>
	<script async defer src="<?php esc_attr_e( get_template_directory_uri() ); ?>/assets/js/core.js"></script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php // <body> closes in footer.php ?>



<?php // common header content goes here ?>
	<div class="container-fluid">
	<?php // <div> .container-fluid closes in footer.php ?>

		<div class="row wrapper--header">
			<div class="header__container vertical-align-cols center">
				<div class="col-md-2">
						<?php
						$logo_attrs = array(
							'class' => 'header__logo link__location',
							'data-href' => get_option( 'home' ),
							'src' => get_template_directory_uri() . '/assets/img/usine_logo.png',
							'width' => 218,
							'height' => 56,
						);
						?>
						<?php MOZ_Html::sc_element( 'img', $logo_attrs ); ?>
				</div>
				<div class="col-md-10">
					<?php MOZ_Menu::nav_menu( 'primary', array( 'walker' => new MInc_Walker_Nav_Menu_Description ) ); ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 wrapper--left">
				<div class="menu--left__container">
					<h4 class="widget__header"><?php MInc_Utils::nav_menu_name( 'primary-menu' ); ?></h4>
					<?php MOZ_Menu::nav_menu( 'left' ); ?>
				</div>
			</div>
			<div class="col-md-8 col-md-offset-2 wrapper--content">
			<?php // <div> .col-md-8 closes in footer.php ?>
				<div class="content__container">
				<?php // <div> .content__container closes in footer.php ?>
