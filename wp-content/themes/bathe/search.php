<?php
/**
 * The template for displaying search results pages
 *
 * @package my-plugin
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/loop', 'search' ); ?>

<?php
get_footer();
