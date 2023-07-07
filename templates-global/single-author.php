<?php 

$author_name = get_field( 'name' );
$author_title = get_field( 'title' );
$author_email = get_field( 'email' );
$author_phone = get_field( 'phone' );
if ( $author_name || $author_title || $author_email || $author_phone ) {
    echo '<div class="author_info">';
    if ( $author_name ) {
        echo '<h4><span class="highlight-gold">' . $author_name . '</span></h4>';
    }
    if ( $author_title ) {
        echo '<p>' . $author_title . '</p>';
    }
    if ( $author_email || $author_phone ) {
        echo '<p>';
        if ( $author_email ) {
            echo '<span class="fas fa-envelope-square"></span><a href="mailto:' . $author_email . '">' . $author_email . '</a>';
        }
        echo '</br>';
        if ( $author_phone ) {
            echo '<span class="fas fa-phone-square"></span><a href="tel:' . $author_phone . '">' . $author_phone . '</a>';
        }
        echo '</p>';
    }
    echo '</div>';
}