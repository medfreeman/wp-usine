<?php
/**
 * Header file common to all
 * templates
 *
 * @package @@name
 */

?>
<!doctype html>
<html class="site no-js" <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php // <body> closes in footer.php. ?>



<?php // Common header content goes here. ?>
	<div class="container-fluid">
	<?php // <div> .container-fluid closes in footer.php ?>

		<div class="row wrapper--header">
			<div class="header__container vertical-align-cols center">
				<div class="col-md-2 col-sm-spacer">
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
				<div class="col-md-10 col-sm-spacer">
						<div class="menu--primary__container visible-md-block visible-lg-block">
							<?php MOZ_Menu::nav_menu( 'primary', array( 'walker' => new MInc_Walker_Nav_Menu_Description ) ); ?>
						</div>
						<div class="menu--primary__container hidden-md hidden-lg">
							<?php MInc_Menu::nav_menu_dropdown( 'primary', array(
								'wrap_class' => 'dropdown-menu-center',
							) ); ?>
						</div>
				</div>
			</div>
		</div>

		<div class="row">
		<?php // <div> .row closes in footer.php ?>
			<div class="col-md-2 col-sm-spacer wrapper--left">
				<div class="sidebar">
					<div class="menu--left__container visible-md-block visible-lg-block">
						<h4 class="widget__header"><?php MInc_Menu::nav_menu_name( 'left' ); ?></h4>
						<?php MOZ_Menu::nav_menu( 'left' ); ?>
					</div>
					<div class="menu--left__container hidden-md hidden-lg">
						<?php MInc_Menu::nav_menu_dropdown( 'left', array(
							'wrap_class' => 'dropdown-menu-center',
						) ); ?>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-spacer col-md-offset-2 col-md-push-8 wrapper--right">
				<div class="widgetbar--right__container">
					<?php MInc_Utils::sidebar( 'right' ); ?>
				</div>
			</div>
			<div class="col-md-8 col-sm-spacer col-md-offset-4 col-md-pull-2 wrapper--content">
			<?php // <div> .col-md-8 closes in footer.php ?>
				<div class="content__container">
				<?php // <div> .content__container closes in footer.php ?>
<?php
