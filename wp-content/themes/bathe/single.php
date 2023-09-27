<?php
/**
 * The template for displaying all single posts
 *
 * @package my-plugin
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/loop', 'single' ); ?>

<?php
get_footer();
