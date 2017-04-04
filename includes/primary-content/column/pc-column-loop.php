<?php while ( have_rows( 'tour_pc-col' ) ) : the_row();	

	$tour_column_content_classes = 'pc--c ';
	$tour_column_content_styles = '';

	if ( $include_margins ) echo '<div class="pc--c__margin_div">';

	if ( get_row_layout() == 'tour_pc-content' ) {

		include( get_stylesheet_directory() . '/includes/primary-content/column/content-card/pc-content-card.php' );

	} else {

		include( get_stylesheet_directory() . '/includes/primary-content/column/flexiprod-card/pc-flexiprod-card.php' );
	
	}

	if ( $include_margins ) echo '</div>';

endwhile; ?>