<?php
/**
 * The site header.
 *
 * @package plume
 */

?>

<header class="site-header">

<div class="w-32">
<?php if ( is_front_page() || is_home() ) : ?>
	<h1>
	<svg width="112" height="54" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#site-logo"></use>
	</svg>
	</h1>
<?php else : ?>
	<div>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<svg width="112" height="54" fill="none" xmlns="http://www.w3.org/2000/svg">
				<use xlink:href="#site-logo"></use>
			</svg>
		</a>
	</div>
<?php endif; ?>
</div>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<div class="menu-button-container scrollbar-fix">
	<button type="button" id="menu-button" class="menu-button" aria-controls="primary-menu-list" aria-expanded="false">
		<span>Menu</span>
	</button>
	</div>
	<nav id="site-navigation" class="primary-navigation" role="navigation" aria-expanded="false">

	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'menu_class'      => 'menu-wrapper',
			'container_class' => 'primary-menu-container',
			'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
			'fallback_cb'     => false,
		)
	);
	?>
	</nav>
	<div class="backdrop"></div>
<?php endif; ?>


</header>
