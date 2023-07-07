<?php
/**
 * The template for displaying all single posts.
 *
 * Contains additional markup for event information related to Inner Circle. 
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="skip-to-content">

	<?php

	while ( have_posts() ) {

		the_post();

		get_template_part( 'templates-global/global-banner' );
		
		?>
		<section id="single-hero">
			<div class="title-wrap">
				<?php the_title( '<h1 class="article entry-title">', '</h1>' ); ?>
			</div>
			<div class="tag-wrap">
				<p class="meta entry-meta"><?php echo pitchfork_posted_on(); ?></p>
				<?php innercircle_print_tags(); ?>
			</div>
			<div class="category-wrap">
				<span class="fa-solid fa-folder-open"></span>
				<?php innercircle_print_categories(); ?>
			</div>
		</section>
		
		<section <?php post_class('container content-wrap'); ?> id="post-<?php the_ID(); ?>">
			
			<div class="row">

				<div class="col-lg-8">
					<?php 
					if ( has_post_thumbnail() ) {
						echo '<figure class="wp-block-image wp-post-image size-large is-style-drop-shadow">';
						the_post_thumbnail('large', array( 'class' => 'img-fluid' ));
						echo '</figure>';
					}
					
					the_content();

					get_template_part( 'templates-global/event-attachment' );
					?>
				</div>

				<aside class="col-lg-4">
					<?php
					
					// Count the number of event cards attached to this post.
					$event_count = 0;
					$events = get_field('ic_event_meta_entry');
					if (is_array($events)) {
						$event_count = count($events);
					}
					
					do_action('qm/debug', $event_count);

					if ( $event_count > 0 ) {
						
						echo '<section id="events">';

						if ( $event_count <= 3 ) {

							echo '<h3><span class="highlight-gold">On the calendar</span></h3>';
							get_template_part( 'templates-global/event-meta' );
						} else {
							echo '<h3><span class="highlight-gold">Calendar entries</span></h3>';
							echo '<p>This post has multiple entries on the Inner Circle calendar.</p>';
							echo '<a href="#event-breakout" class="btn btn-maroon">View all ' . $event_count . ' events</a>';
						}

						echo '</section>';

					}
					
					?>
				</aside>

			</div>

			<div class="row">

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'uds-wordpress-theme' ),
						'after'  => '</div>',
					)
				);

				?>

				<footer class="entry-footer">
				
					<?php
					// Edit post link, scraped from parent tempalte-tags.php
					edit_post_link(
						sprintf(
							/* translators: %s: Name of current post */
							esc_html__( 'Edit %s', 'uds-wordpress-theme' ),
							the_title( '<span class="sr-only">"', '"</span>', false )
						),
						'<div class="edit-link my-1">',
						'</div>'
					);
					?>

				</footer><!-- .entry-footer -->
			</div><!-- end .row -->
		</section><!-- #post-## -->

		<?php 
		if ( $event_count > 3 ) {
			echo '<section id="event-breakout">';
			echo '<div class="container"><div class="row"><div class="col-md-12">';
			echo '<h2><span class="highlight-gold">On the calendar</span></h2>';
			echo '<div class="event-card-container">';
			get_template_part( 'templates-global/event-meta' );
			echo '</div></div></div></div></section>';
		}
    }

?>
</main><!-- #main -->

<?php get_footer(); ?>
