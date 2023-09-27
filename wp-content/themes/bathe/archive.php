<?php
/**
 * The template for displaying archive pages
 *
 * @package my-plugin
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/loop', 'archive' ); ?>

<?php
get_footer();
