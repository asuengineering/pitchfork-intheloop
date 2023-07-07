<?php
/**
 * Displays information associated with a tag. Captured via ACF fields on the tag creation page.
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$term = get_queried_object();

$description = get_field('ic_tag_description', $term);
$link = get_field('ic_tag_cta_button', $term);
$button_color = get_field('ic_tag_cta_button_color' , $term);
$featured_image = get_field( 'ic_tag_featured_image', $term);
?>

<section id="tag-hero">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <?php 
                echo '<h3><span class="highlight-gold">Tag:</span></h3>';
                the_archive_title( '<h1 class="page-title">', '</h1>' ); 
                
                echo '<div class="term-description">' . wp_kses_post($description) . '</div>';

                if( $link ) {
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';

                    ?>
                    <a class="btn btn-lg <?php echo $button_color; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                <?php } ?>
            </div>

            <?php
            if( $featured_image ) {
                echo '<div class="col-md-5">';

                $size = 'medium_large';
                $full_image = wp_get_attachment_image( $featured_image, $size, false, array( "class" => "img-fluid" ));
                $trim_image = preg_replace( '/(width|height)="\d+"\s/', '', $full_image );

                echo $trim_image;

                echo '</div>';
            }
            ?>  
        </div>
    </div>
</section>