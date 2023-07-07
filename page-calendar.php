<?php
/**
 * The template in use by a page with the slug of /calendar.
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_template_part( 'templates-global/calendar' );

get_header();
?>

	<main id="skip-to-content" <?php post_class(); ?>>

		<?php

		while ( have_posts() ) {

			the_post();

            ?>
            <!-- <section class="uds-background-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar-wrapper" class="grid">
                                <div id="calendar"></div>
                                <div id="event-preview">
                                    <div class="event-details">
                                        <h3>Explore our events!</h3>
                                        <p>Select an event on the calendar to see the event details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
                
            <?php

			the_content();

			// Display the edit post button to logged in users.
			echo '<footer class="entry-footer"><div class="container"><div class="row"><div class="col-md-12">';
			edit_post_link( __( 'Edit', 'uds-wordpress-theme' ), '<span class="edit-link">', '</span>' );
			echo '</div></div></div></footer><!-- end .entry-footer -->';
		}

		?>

	</main><!-- #main -->

<?php
get_footer();
