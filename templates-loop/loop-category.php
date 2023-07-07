<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>">

	<?php
	// if ( has_post_thumbnail() ) {
	// 	echo '<div class="col-lg-4">';
	// 	the_post_thumbnail('medium-large', ['class' => 'img-fluid mt-2']);
	// 	echo '</div>';
	// }
	?>

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h3>'
		);
		?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<p><?php the_excerpt(); ?></p>
	</div>
	
	<?php 

	$entryfooter = innercircle_event_line( get_the_ID(), false);
	if (! empty($entryfooter)) {
		echo '<footer class="entry-footer">';
		echo $entryfooter;
		echo '</footer>';
	}

	?>

</article><!-- #post-## -->

