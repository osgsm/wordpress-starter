<?php
/**
 * The sidebar.
 *
 * @package plume
 */

?>

<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar widget-area scrollbar-fix" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
