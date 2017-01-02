<?php 

$tour_column_content_classes .= ' ' . $fc_style . ' ';

if ( get_row_layout() == 'tour_pc-flexi' ) {

	$tour_flexi_content = 'tour_pc-flexi';
	$tour_column_content_classes .= ' pc--c__flexi'; 
	$tour_flexiprod_image_url = get_sub_field( 'tour_pc-flexi--image-add' );
	$tour_flexiprod_tag_url = get_sub_field( 'tour_pc-flexi--url' );

} elseif ( get_row_layout() == 'tour_pc-product' ) {

	$tour_flexi_content = 'tour_pc-product';
	$tour_column_content_classes .= ' pc--c__product'; 

	if( get_sub_field( 'tour_pc-product--object' ) ) : 
		$post = get_sub_field( 'tour_pc-product--object' );
		setup_postdata( $post ); 

		$tour_flexiprod_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(),'full', true);
		$tour_flexiprod_tag_url = get_permalink();

		$title = get_the_title();
		$desc  = the_excerpt_max_charlength();
		$price = '$199';
		$label = 'View more';

		wp_reset_postdata();
	endif;

}

?>

<div
	class="<?php echo $tour_column_content_classes; ?>" 
	style="<?php echo $tour_column_content_styles; ?>">
	
		<?php  if ( have_rows( $tour_flexi_content . '--content' ) ) :
		
			while ( have_rows( $tour_flexi_content . '--content' ) ) : the_row();

				if ( get_row_layout() ==  $tour_flexi_content . '--content--image' ) :
				
					include( get_stylesheet_directory() . '/includes/primary-content/column/flexiprod-card/pc-flexiprod-card-image.php' );

				elseif ( get_row_layout() ==  $tour_flexi_content . '--content_first' ) : 

					include( get_stylesheet_directory() . '/includes/primary-content/column/flexiprod-card/pc-flexiprod-card-first.php' );

				elseif ( get_row_layout() ==  $tour_flexi_content . '--content_second' ) : 

					include( get_stylesheet_directory() . '/includes/primary-content/column/flexiprod-card/pc-flexiprod-card-second.php' );

				endif;

			endwhile;

		endif; ?>

</div>
