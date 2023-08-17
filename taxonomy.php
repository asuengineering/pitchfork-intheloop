<?php
/**
 * In the loop template for displaying most custom post taxonomies.
 *
 * @package pitchfork-innercircle
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', function( $classes ) {
    return array_merge( $classes, array( 'tag' ) );
} );

get_header();

?>
<main id="skip-to-content">

    <?php get_template_part( 'templates-global/category' , 'header'); ?>

	<div class="container pb-6">
        <?php

        if ( have_posts() ) {

            // Start the loop.
            while ( have_posts() ) {
                the_post();

                get_template_part( 'templates-loop/loop-category');
            }
        }
        ?>

        <div class="row">
            <div class="col">
                <!-- The pagination component -->
                <?php pitchfork_pagination(); ?>
            </div>
        </div>
    </div><!-- end .container -->

</main><!-- #main -->

<?php
get_footer();
