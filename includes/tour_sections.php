<?php $site_layout = genesis_site_layout(); ?>
<div class="tour-nav visible-xs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 right-col<?php if( get_field('hero_area') ): echo " bear-banner"; else: echo " skip-banner"; endif;?>">


                        <?php if(have_rows('sidebar_1')): ?>
                        <?php while(have_rows('sidebar_1')): the_row(); ?>
                            <!-- button for mobile -->
                            <?php if( get_row_layout() == 'button' ): ?>
                                <?php
                                $bbt = get_sub_field('button_text');
                                $cta_onclick = get_sub_field('cta_onclick');
                                $button_type = get_sub_field('button_link_type');
                                $bbl = get_sub_field('custom_button_link');
                                $b_radius = get_sub_field('button_radius');
                                $third_party = get_sub_field('third_party');
                                $mobd = get_sub_field('multi_option_button_dropdown');
                                $click_to_call = get_field('click_to_call', 'option');
                                $phone_number = get_field('phone_number','option');
                                ?>

                        <?php if($click_to_call && $phone_number): ?>
                        <?php $phone = preg_replace('/\D+/', '', $phone_number); ?>
                        <div class="center-block center-booking">
                            <div id="booking2" class="book-tour-wrapper booking-sidebar">
                                <a href="tel:<?php echo $phone; ?>" class="book-btn2">
                                    Click to Call: <?php echo $phone_number; ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="center-block center-booking<?php if($click_to_call && $phone_number): ?> relative-pos<?php endif; ?>">
                                <div<?php if(!$click_to_call): ?> id="booking2"<?php endif; ?> class="book-tour-wrapper booking-sidebar">
                        <?php if($bbt && !$mobd): ?>
                            <?php include(locate_template('buttons/sidebar_xs_btn.php' )); ?>
                        <?php elseif($bbt && $mobd): ?>
                            <?php include(locate_template('buttons/sidebar_xs_mobd.php' )); ?>
                        <?php endif; ?><!-- end of button-->
                                </div>
                        </div>

                            <?php endif; ?>

                        <?php endwhile; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

<section class="tour-page-content">
        <div class="container">
            <div class="row">
                <div class="<?php if ( 'content-sidebar' == $site_layout ): ?>col-sm-8<?php elseif( 'full-width-content' == $site_layout ): ?>col-sm-12<?php endif; ?> left-col">

                    <?php if(have_rows('sections_area')): ?>
                            <?php
                            //$numm = 0;
                            //$section_count = (int)$numm; ?>
                            <?php while(have_rows('sections_area')): the_row(); ?>
                            <?php
                                $headline = get_sub_field('section_headline');
                                $headline_align = get_sub_field('headline_text_align');
                            ?>
                            <section class="section-item">
                    <?php $section_count++; ?>
                    <?php if($headline): ?>
                        <h2<?php if($headline_align == 'Center'): echo ' class="text-center"'; endif;?>>
                            <?php echo $headline; ?>
                        </h2>
                    <?php endif; ?>
                    <?php if(have_rows('section_elements')): ?>
                        <?php while(have_rows('section_elements')): the_row(); ?>


                            <?php if( get_row_layout() == 'section_subheadline'): ?>
                                <?php $subheadline = get_sub_field('subheadline'); ?>
                                    <?php if($subheadline): ?>
                        <h3>
                            <?php echo $subheadline; ?>
                        </h3>
                                    <?php endif; ?>
                            <?php endif; ?>

                            <?php if( (get_row_layout() == 'image') || (get_row_layout() == 'content_editor')): ?>
                                <div>
                                <?php
                                $img_embed = get_sub_field('image_embed_options');
                                $img_url = wp_get_attachment_url( get_sub_field('image'),'full');
                                $image = aq_resize( $img_url, 279, 158, true );
                                $content = get_sub_field('content');
                                $linked_to_button = get_sub_field('linked_to_button');
                                ?>
                                <?php if($img_url && ($img_embed == 'embed on the Side')): ?>
                                <img src="<?=$image?>" alt="<?=$image?>" class="side-embed img-responsive" />
                                <?php elseif($img_url && ($img_embed == 'embed to the full width')): ?>
                                <img src="<?=$img_url?>" alt="<?=$img_url?>" class="full-embed img-responsive" />
                                <?php endif; ?>
                                <div class="c-editor"<?php if($linked_to_button): ?> data-scroll-index='100'<?php endif; ?>>
                                <?php if($content): echo $content; endif; ?>
                                </div>
                                </div>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'classic_details'): ?>
                                <?php if(have_rows('details_list')): ?>
                                <ul class="classic-details-list">
                                <?php while(have_rows('details_list')): the_row(); ?>
                                <?php
                                $label = get_sub_field('label');
                                $text = get_sub_field('text');
                                ?>
                                <li class="row">
                                    <div class="col-xs-3 details-label">
                                        <span>
                                    <?php if($label): echo $label; endif; ?>
                                        </span><i class="fa fa-chevron-right"></i>
                                    </div>
                                    <div class="col-xs-9">
                                    <?php if($text): echo $text; endif; ?>
                                    </div>
                                </li>
                                <?php endwhile; ?>
                                </ul>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'classic_itinerary'): ?>
                            <?php
                            $num = 1;
                            $i = (int)$num; ?>
                                <?php if(have_rows('itinerary_list')): ?>
                                <div class="classic-itinerary-list">
                                <?php while(have_rows('itinerary_list')): the_row(); ?>
                                <?php
                                $title = get_sub_field('title');
                                $img_url = wp_get_attachment_url( get_sub_field('image'),'full');
                                $image = aq_resize( $img_url, 600, 258, true );
                                $paragraph = get_sub_field('paragraph');
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 itinerary-inner-offset">
                                    <div class="row itinerary-inner-wrapper">
                                    <div class="vert-line"></div>

                                  <div class="col-xs-12 itinerary-inner">
                                    <div class="num-wrapper">
                                    <div class="top-line"></div>
                                        <div class="itinery-num"><span><?php echo $i; ?></span></div>
                                    <div class="bottom-line"></div>

                                  </div>
                                  <?php if($title): ?>
                                    <h4 class="itinerary-title"><span><?php echo $title; ?></span></h4>
                                  <?php endif; ?>
                                  <?php if($image): ?>
                                      <img src="<?=$image?>" alt="<?=$image?>" class="img-featured img-responsive" />
                                  <?php endif; ?>
                                  <?php if($paragraph): ?><p><?php echo $paragraph; ?></p><?php endif; ?>
                                  </div>
                                    </div><!-- end .itinerary-inner-->
                                    </div>
                                </div><!-- end .row -->
                                <?php $i++; ?>
                                <?php endwhile; ?>
                                </div><!-- end .classic-itinerary-list-->
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'multiple_trip_details'): ?>
                                <?php
                                $gal_num = 0;
                                $gn = (int)$gal_num; ?>
                                <?php if(have_rows('trip_list')): ?>
                                <div class="trip-list">
                                <?php while(have_rows('trip_list')): the_row(); ?>
                                <?php
                                $title = get_sub_field('title');
                                $img_url = wp_get_attachment_url( get_sub_field('image'),'full');
                                $image = aq_resize( $img_url, 715, 303, true );
                                $images = get_sub_field('gallery');
                                $paragraph = get_sub_field('paragraph');
                                $custom_options = get_sub_field('custom_options');
                                ?>
                                    <div class="trip-item">
                                    <?php if($image): ?>
                                        <img src="<?=$image?>" alt="<?=$image?>" class="center-block img-featured img-responsive" />
                                    <?php endif; ?>
                                <?php if( $images ): ?>
                                <div class="gallery">
                                    <div class="photo-gallery gallery-one gallery-<?php echo $gn; ?>">
                                        <?php foreach( $images as $image ): ?>
                            <?php
                                $img_url = $image['url'];
                                $thumbnail = aq_resize( $img_url, 250, 250, true );
                            ?>
                                        <a href="<?php echo $img_url; ?>" class="w-inline-block photo-thumbnail">
                                            <img src="<?php echo $thumbnail; ?>" alt="<?php echo $image['alt']; ?>" class="image-thumb img-responsive" />
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                    <?php if($title): ?>
                                        <h4 class="trip-title text-center"><span><?php echo $title; ?></span></h4>
                                    <?php endif; ?>
                                    <?php if($paragraph): ?>
                                        <?php if(is_array($custom_options) && in_array('Show button to hide description', $custom_options) ): ?>
                                            <p style="max-height: 50px; overflow: hidden;"><?php echo $paragraph; ?></p>
                                        <?php else: ?>
                                            <p><?php echo $paragraph; ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(have_rows('details_list')): ?>
                                        <?php if(is_array($custom_options) && in_array('Show button to hide description', $custom_options) ): ?>
                                            <ul class="details-row-wrapper" style="display: none">
                                        <?php else: ?>
                                            <ul class="details-row-wrapper">
                                        <?php endif; ?>
                                    <?php while(have_rows('details_list')): the_row(); ?>
                                    <?php
                                    $label = get_sub_field('label');
                                    $text = get_sub_field('text');
                                    ?>
                                        <li class="row details-row">
                                            <div class="col-sm-3 details-label">
                                            <?php if($label): echo $label; endif; ?>
                                            </div>
                                            <div class="col-sm-9">
                                            <?php if($text): echo $text; endif; ?>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if( is_array($custom_options) && in_array('Show button to hide description', $custom_options) ): ?>
                                        <div class="tour-see-more">
                                          <p>see details...</p>
                                        </div>
                                    <?php endif ?>
                                    </div><!-- end .trip-item-->
                                    <?php $gn++; ?>
                                <?php endwhile; ?>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'icons_list'): ?>
                                <?php if(have_rows('list_item')): ?>
                        <ul class="td-list">
                        <?php while(have_rows('list_item')): the_row(); ?>
                        <?php
                            $icon = get_sub_field('icons');
                            $description = get_sub_field('description');
                        ?>
                        <li class="row">
                            <div class="col-md-4 col-lg-4">
                                <?php if($icon): ?>
                                <span>
                                <?php if($icon == 'Accommodation'): ?>
                                <i class="fa fa-home"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Activities'): ?>
                                <i class="fa fa-spoon"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Ages'): ?>
                                <i class="fa fa-child"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Carbon Offset'): ?>
                                <i class="fa fa-leaf"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Departure Time'): ?>
                                <i class="fa fa-clock-o"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Difficulty'): ?>
                                <i class="fa fa-signal"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Duration'): ?>
                                <i class="fa fa-play"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Finish'): ?>
                                <i class="fa fa-flag-checkered"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Group size'): ?>
                                <i class="fa fa-group"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Highlights'): ?>
                                <i class="fa fa-camera"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Inclusions'): ?>
                                <i class="fa fa-list-ol"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Languages'): ?>
                                <i class="fa fa-globe"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Meals'): ?>
                                <i class="fa fa-cutlery"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Meeting Place'): ?>
                                <i class="fa fa-map-marker"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Options'): ?>
                                <i class="fa fa-file-text-o"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Places Visited'): ?>
                                <i class="fa fa-picture-o"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Price'): ?>
                                <i class="fa fa-tag"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Start'): ?>
                                <i class="fa fa-flag"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Transport'): ?>
                                <i class="fa fa-cab"></i>
                                <?php endif; ?>

                                <?php if($icon == 'Travel Style'): ?>
                                <i class="fa fa-tachometer"></i>
                                <?php endif; ?>

                                <?php if($icon == 'When'): ?>
                                <i class="fa fa-calendar"></i>
                                <?php endif; ?>
                                </span>
                                <strong><?php echo $icon; ?>:</strong>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <?php if($description): echo $description; endif; ?>
                            </div>
                        </li>
                        <?php endwhile; ?>
                        </ul>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'table'): ?>
                                <?php if(have_rows('table_row')): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                        <?php while(have_rows('table_row')): the_row(); ?>
                            <?php
                                $cell_1 = get_sub_field('cell_1');
                                $cell_2 = get_sub_field('cell_2');
                                $cell_3 = get_sub_field('cell_3');
                                $cell_4 = get_sub_field('cell_4');
                                $cell_5 = get_sub_field('cell_5');
                            ?>
                            <tr>
                                    <th><?php if($cell_1): echo $cell_1; else: echo '&nbsp;'; endif; ?></th>
                                    <td><?php if($cell_2): echo $cell_2; else: echo '&nbsp;'; endif; ?></td>
                                    <td><?php if($cell_3): echo $cell_3; else: echo '&nbsp;'; endif; ?></td>
                                    <td><?php if($cell_4): echo $cell_4; else: echo '&nbsp;'; endif; ?></td>
                                    <td><?php if($cell_5): echo $cell_5; else: echo '&nbsp;'; endif; ?></td>
                                </tr>
                        <?php endwhile; ?>
                            </table>
                        </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'subsection'): ?>
                            <?php
                                $subheadline = get_sub_field('headline');
                                $subcontent = get_sub_field('content_editor');
                            ?>
                            <div class="item">
                                <?php if($subheadline): ?>
                                <h3>
                                <?php echo $subheadline; ?>
                                </h3>
                                <?php endif; ?>
                                <?php
                                $img_embed = get_sub_field('image_embed_options');
                                $img_url = wp_get_attachment_url( get_sub_field('image'),'full');
                                $image = aq_resize( $img_url, 279, 158, true );

                                ?>
                                <?php if($img_url && ($img_embed == 'embed on the Side')): ?>
                                <img src="<?=$image?>" alt="<?=$image?>" class="side-embed img-responsive" />
                                <?php elseif($img_url && ($img_embed == 'embed to the full width')): ?>
                                <img src="<?=$img_url?>" alt="<?=$img_url?>" class="full-embed img-responsive" />
                                <?php endif; ?>

                                <div class="c-editor">
                                <?php if($subcontent): echo $subcontent; endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'booking_button'): ?>
                            <?php
                                $bbt = get_sub_field('booking_button_text');
                                $text_align = get_sub_field('text_align');
                                $bbl = get_sub_field('booking_button_link');
                                $cta_onclick = get_sub_field('cta_onclick');
                                $bb_radius = get_sub_field('booking_button_radius');
                                $rb1 = get_sub_field('reason_to_book_1');
                                $rb2 = get_sub_field('reason_to_book_2');
                                $third_party = get_sub_field('third_party');
                                $use_as_integration_link = get_sub_field('use_as_third_party_integration_link');
                                $mobd = get_sub_field('multi_option_button_dropdown');
                            ?>
                            <div class="book-tour-wrapper<?php if($text_align == 'Center'): echo ' text-center'; endif;?>">
                            <?php if($bbt && !$mobd): ?>
                                <?php include(locate_template('buttons/leftcol_btn.php' )); ?>
                            <?php elseif($bbt && $mobd): ?>
                                <?php include(locate_template('buttons/leftcol_mobd.php' )); ?>
                            <?php endif; ?>
                            <?php if($rb1 || $rb2): ?>
                            <ul class="book-tour-list">
                                <?php if($rb1): ?>
                                <li>
                                    <i class="fa fa-check"></i><?php echo $rb1; ?>
                                </li>
                                <?php endif; ?>
                                <?php if($rb2): ?>
                                <li>
                                    <i class="fa fa-check"></i><?php echo $rb2; ?>
                                </li>
                                <?php endif; ?>
                            </ul>
                            <?php if($text_align == 'Left'): ?><br clear="both" /><?php endif; ?>
                            <?php endif; ?>
                        </div>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'map'): ?>
                                <?php $custom_headline = get_sub_field('custom_headline'); ?>
                                <?php
                                    $center = get_sub_field('map_center_address');
                                    $zoom = get_sub_field('zoom');
                                 ?>
                                <?php $content = '[bgmp-map center="'.$center.'" zoom="'.$zoom.'"]'; ?>
                            <div class="map">
                                <?php if($custom_headline): ?>
                                <h2>
                                    <?php echo $custom_headline; ?>
                                </h2>
                                <?php endif; ?>
                                <?php echo do_shortcode( $content ) ?>

                            </div>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'image_gallery'): ?>
                                <?php $images = get_sub_field('gallery');
                                ?>
                                <?php
                                $gal_num2 = 0;
                                $gn2 = (int)$gal_num2; ?>
                                <?php if( $images ): ?>
                                <div class="gallery">
                                    <div class="photo-gallery gallery-two gallery2-<?php echo $gn2; ?>">
                                        <?php foreach( $images as $image ): ?>
                            <?php
                                $img_url = $image['url'];
                                $thumbnail = aq_resize( $img_url, 250, 250, true );
                            ?>
                                        <a href="<?php echo $img_url; ?>" class="w-inline-block photo-thumbnail">
                                            <img src="<?php echo $thumbnail; ?>" alt="<?php echo $image['alt']; ?>" class="image-thumb img-responsive" />
                                        </a>
                                        <?php $gn2++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; /*end image_gallery*/ ?>

                            <?php if( get_row_layout() == 'tour_boxes'): ?>
                                <div class="featured-tours featured-tours-section">
                                <div class="row-eq-height">
                                    <?php global $post; ?>
                                    <?php
                    $number_of_columns = get_sub_field('number_of_columns');
                    $col = 0;
                    if($number_of_columns):
                    switch ($number_of_columns) {
                        case 1:
                            $col = 12;
                            break;
                        case 2:
                            $col = 6;
                            break;
                        case 3:
                            $col = 4;
                            break;
                        case 4:
                            $col = 3;
                            break;
                        case 5:
                            $col = 5;
                            break;
                    }
                    endif;
                    ?>
                    <?php if( have_rows('boxes_set') ): ?>
                    <?php while ( have_rows('boxes_set') ) : the_row(); ?>

                    <?php if( get_row_layout() == 'tours'): ?>
                    <?php
                        $pulled_specific = get_sub_field('pull_specific_from');
                        if($pulled_specific):
                        $post = $pulled_specific;
                        setup_postdata( $post );
                    ?>
                        <div class="<?php if($col==5): ?>five-cols <?php else: ?>col-xs-12 col-sm-<?php echo $col; ?><?php endif; ?> col-eq-height">
                            <?php include(locate_template('content-feat_tours.php' )); ?>
                        </div>
                    <?php
                       wp_reset_postdata();
                       endif;/*end if pulled_specific*/
                    ?>

                    <?php elseif(get_row_layout() == 'categories'): ?>
                    <div class="<?php if($col==5): ?>five-cols <?php else: ?>col-xs-12 col-sm-<?php echo $col; ?><?php endif; ?> col-eq-height">
                            <?php include(locate_template('content-feat_cats_11.php' )); ?>
                            </div>
                    <?php endif; ?>

                    <?php endwhile; ?>

                    <?php endif; ?>
                                </div>
                                </div><!-- end .featured-tours-->

                            <?php endif; ?>

                            <?php if( get_row_layout() == 'testimonials_boxes'): ?>
                            <?php global $post; ?>
                            <?php $testimonials_type = get_field('testimonials_type', 'option'); ?>
                            <?php
                            $number_of_tstm_columns = get_sub_field('number_of_tstm_columns');
                            $tcol = 0;
                            if($number_of_tstm_columns):
                            switch ($number_of_tstm_columns) {
                                case 1:
                                    $tcol = 12;
                                    break;
                                case 2:
                                    $tcol = 6;
                                    break;
                                case 3:
                                    $tcol = 4;
                                    break;
                                case 4:
                                    $tcol = 3;
                                    break;
                                case 5:
                                    $tcol = 5;
                                    break;
                            }
                            endif;
                            ?>
                            <?php
                                if(have_rows('boxes_set') && $testimonials_type == 'Scrolling'): ?>
                                <div class="row testimonials">
                            <div class="col-sm-12">
                                <div class="testimonials-slider-wrapper">
                                    <div class="testimonials-slider">
                                        <ul class="slides">
                                        <?php while(have_rows('boxes_set')): the_row(); ?>
                                        <?php if( get_row_layout() == 'testimonials' ):
                                        $pulled_specific = get_sub_field('pull_specific_from');

                                        if($pulled_specific):
                                            $post = $pulled_specific;
                    				        setup_postdata( $post ); ?>

                    				        <?php //get_template_part( 'content', 'scrltstmls' ); ?>
                    				        <?php include(locate_template('content-scrltstmls.php' )); ?>

                    				        <?php
                    				        wp_reset_postdata();
                                        endif;
                                    endif;
                                    ?>
                                        <?php endwhile; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                </div><!-- end .row-->
                            <?php
                            else:
                            ?>
                            <div class="row even-grid testimonials">
                            <?php
                            while(have_rows('boxes_set')): the_row();
                            if( get_row_layout() == 'testimonials' ):
                            $pulled_specific = get_sub_field('pull_specific_from');
                            if($pulled_specific):
                                $post = $pulled_specific;
        				        setup_postdata( $post ); ?>
        				        <div class="<?php if($tcol==5): ?>five-cols <?php else: ?>col-xs-12 col-sm-<?php echo $tcol; ?><?php endif; ?>">
        				        <?php get_template_part( 'content', 'home_tstmls' ); ?>
        				        </div>
        				        <?php
        				        wp_reset_postdata();
                            endif;
                            endif;
                            endwhile; ?>
                            </div><!-- end .row.even-grid.testimonials-->
                            <?php
                            endif;
                            ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'blog_boxes'): ?>
                            <div class="row even-grid testimonials front-blog-wrapper">
                            <?php
                                $number_of_blog_columns = get_sub_field('number_of_blog_columns');
                                $number_of_posts = get_sub_field('number_of_posts');
                                $bcol = 0;
                                if($number_of_columns):
                                switch ($number_of_blog_columns) {
                                    case 1:
                                        $bcol = 12;
                                        break;
                                    case 2:
                                        $bcol = 6;
                                        break;
                                    case 3:
                                        $bcol = 4;
                                        break;
                                }
                                endif;
                                $args = array(
                        'post_type' => 'post',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'nopaging' => true,
                        'post_status' => 'publish'
                        );

                        $i = 0;
                        global $wp_query;
                        $wp_query = new WP_Query( $args );

                        if ( have_posts() ) :

                        while ( have_posts() ) : the_post();

                        $i++; ?>
                        <div<?php if($bcol): ?> class="col-xs-12 col-sm-<?php echo $bcol; ?> s-item"<?php endif; ?>>
                        <?php
                        get_template_part( 'content', 'front_blog' );
                        ?>
                        </div>
                        <?php
                        if($i == $number_of_posts):
                        break;
                        endif;
                        endwhile;

                        do_action( 'genesis_after_endwhile' );
                        endif;

                        wp_reset_query();
                                ?>
                            </div><!-- .row-->
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'sitewide_modules'): ?>
                                <?php if(have_rows('section_module')): ?>
                                <?php global $post; ?>

                                <?php while(have_rows('section_module')): the_row(); ?>
                                    <?php $pulled_specific = get_sub_field('pull_specific_from');

                                    if($pulled_specific):
                                        $post = $pulled_specific;
                				        setup_postdata( $post ); ?>

                				        <?php get_template_part( 'content', 'sitewide_sections' ); ?>

                				        <?php
                				        wp_reset_postdata();
                                    endif;

                                ?>
                                <?php endwhile; ?>

                                <?php endif; ?>
                            <?php endif; ?>



                        <?php endwhile; ?>
                    <?php endif; /*end section_elements*/ ?>

                            </section>
                            <?php endwhile; ?>
                    <?php endif; ?>


                    <?php global $post; ?>
                    <?php $testimonials_type = get_field('testimonials_type', 'option');
                        $testimonials = get_field('testimonials');
                    ?>
                    <?php if($testimonials && ($testimonials_type == 'Scrolling')): ?>
                    <section class="testimonials">
                        <div class="testimonials-slider-wrapper">
                        <div class="testimonials-slider">
                            <ul class="slides">
                            <?php while(has_sub_field('testimonials')): ?>
                                <?php $pulled_specific = get_sub_field('pull_specific_from');

                                    if($pulled_specific):
                                        $post = $pulled_specific;
                				        setup_postdata( $post ); ?>

                				        <?php get_template_part( 'content', 'scrltstmls' ); ?>

                				        <?php
                				        wp_reset_postdata();
                                    endif;

                                ?>
                            <?php endwhile; ?>
                            </ul>
                        </div>
                        </div>
                    </section>
                    <?php elseif($testimonials): ?>
                    <section class="testimonials">
                        <h2>
                            <span>Testimonials</span>
                        </h2>

                        <div class="row multi-columns-row even-grid">
                            <?php while(has_sub_field('testimonials')): ?>
                                <?php $pulled_specific = get_sub_field('pull_specific_from');

                                    if($pulled_specific):
                                        $post = $pulled_specific;
                				        setup_postdata( $post ); ?>

                				        <?php get_template_part( 'content', 'tour_tstmls' ); ?>

                				        <?php
                				        wp_reset_postdata();
                                    endif;

                                ?>
                            <?php endwhile; ?>
                        </div>
                    </section>
                        <?php endif; ?>

                </div>
                <?php if ( 'content-sidebar' == $site_layout ): ?>
                <div class="col-sm-4 right-col<?php if( get_field('hero_area') ): echo " bear-banner"; else: echo " skip-banner"; endif;?>">



                    <?php if(have_rows('sidebar_1')): ?>
                        <div class="center-block center-booking hidden-xs">
                                <div id="booking" class="book-tour-wrapper booking-sidebar">
                        <?php while(have_rows('sidebar_1')): the_row(); ?>

                            <?php if( get_row_layout() == 'button' ): ?>
                                <?php
                                $bbt = get_sub_field('button_text');
                                $cta_onclick = get_sub_field('cta_onclick');
                                $button_type = get_sub_field('button_link_type');
                                $bbl = get_sub_field('custom_button_link');
                                $b_radius = get_sub_field('button_radius');
                                $rb1 = get_sub_field('reason_to_book_1');
                                $rb2 = get_sub_field('reason_to_book_2');
                                $third_party = get_sub_field('third_party');
                                $mobd = get_sub_field('multi_option_button_dropdown');
                                ?>

                        <?php if($bbt && !$mobd): ?>
                            <?php include(locate_template('buttons/sidebar_btn.php' )); ?>
                        <?php elseif($bbt && $mobd): ?>
                            <?php include(locate_template('buttons/sidebar_mobd.php' )); ?>
                        <?php endif; /*end of last button condition*/ ?>
                            <?php if($rb1 || $rb2): ?>
                            <div class="hidden-xs text-left">
                                <?php if($rb1): ?>
                              <div class="trigger-txt"><?php echo $rb1; ?></div>
                              <div class="separator2"></div>
                              <?php endif; ?>
                              <?php if($rb2): ?>
                              <div class="trigger-txt"><?php echo $rb2; ?></div>
                              <div class="separator2"></div>
                              <?php endif; ?>
                            </div>
                            <?php endif; /*end reasons to book*/ ?>

                            <?php endif; /*end button layout*/ ?>

                            <?php if( get_row_layout() == 'content_editor' ):
                                $content = get_sub_field('content');
                            ?>
                            <div class="widget-item">
                                <?php echo $content; ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'text_area' ):
                                $content = get_sub_field('content');
                            ?>
                            <div class="widget-item">
                                <?php echo $content; ?>
                            </div>
                            <?php endif; ?>

                        <?php endwhile; /*end while sidebar_1*/ ?>
                        </div><!-- end #booking-->
                            </div><!-- end .center-booking -->
                    <?php endif; /*end if sidebar_1*/ ?>

                    <?php if(have_rows('sidebar_2')): ?>
                        <?php while(have_rows('sidebar_2')): the_row(); ?>

                            <?php if( get_row_layout() == 'content_editor' ): ?>
                            <?php
                                $content = get_sub_field('content');
                                $linked_to_button = get_sub_field('linked_to_button');
                            ?>
                           <div<?php if($linked_to_button): ?> data-scroll-index='100'<?php endif; ?>>
                           <?php
                               echo $content;
                           ?>
                           </div>
                           <?php endif; ?>

                           <?php if( get_row_layout() == 'text_area' ): ?>
                           <div class="widget-item"><div class="row"><div class="col-sm-10 col-sm-offset-1">
                           <?php $content = get_sub_field('content');
                               echo $content;
                           ?>
                           </div></div></div>
                           <?php endif; ?>

                    <section class="testimonials">
                        <?php if( get_row_layout() == 'testimonials' ): ?>
                        <div class="row even-grid">
                                <?php $pulled_specific = get_sub_field('pull_specific_from');

                                    if($pulled_specific):
                                        $post = $pulled_specific;
                				        setup_postdata( $post ); ?>

                				        <?php get_template_part( 'content', 'tour_tstml' ); ?>

                				        <?php
                				        wp_reset_postdata();
                                    endif;

                                ?>
                        </div>
                        <?php endif; ?>
                    </section>

                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <?php global $post; ?>

            <?php if(get_field('tiles_area')): ?>

            <?php while(has_sub_field('tiles_area')): ?>
            <?php
                $section_headline = get_sub_field('section_headline');
                $custom_headline = get_sub_field('custom_headline');
                $number_of_columns = get_sub_field('number_of_columns');
                $linked_to_hero_cta = get_sub_field('linked_to_hero_cta');
                if ( 'content-sidebar' == $site_layout ):
                $col_def = "col-md-";
                elseif( 'full-width-content' == $site_layout ):
                $col_def = "col-sm-";
                endif;
            ?>
    <section class="<?php if($section_headline == 'Featured tours'): ?>featured-tours<?php else: ?>testimonials<?php endif; ?>"<?php if($linked_to_hero_cta): ?> data-scroll-index='110'<?php endif; ?>>
        <div class="container<?php if ( 'content-sidebar' == $site_layout ): ?> no-bg<?php endif; ?>">
        <div class="row">
                <div class="<?php if ( 'content-sidebar' == $site_layout ): ?>col-sm-8 left-col<?php elseif( 'full-width-content' == $site_layout ): ?>col-sm-12<?php endif; ?>">
            <?php if($custom_headline): ?>
            <div class="row">
                <div class="col-sm-12">
                    <h2>
                        <?php echo $custom_headline; ?>
                    </h2>
                </div>
            </div>
            <?php endif; ?>
            <div class="row-eq-height">
                <?php
                    $col = 0;
                    switch ($number_of_columns) {
                        case 1:
                            $col = 12;
                            break;
                        case 2:
                            $col = 6;
                            break;
                        case 3:
                            $col = 4;
                            break;
                        case 4:
                            $col = 3;
                            break;
                        case 5:
                            $col = 5;
                            break;
                    }
                    ?>

                    <?php
                        if (have_rows('tiles')):
                        while(have_rows('tiles')): the_row();

                        if( get_row_layout() == 'tours' ):
                            $pulled_specific = get_sub_field('pull_specific_from');
                            if($pulled_specific):
                            $post = $pulled_specific;
                            setup_postdata( $post );
                            ?>
                            <div class="<?php if($col==5): ?>five-cols <?php else: ?><?php echo $col_def.$col; ?> col-eq-height<?php endif; ?>">
                            <?php //get_template_part( 'content', 'feat_tours' ); ?>
                            <?php include(locate_template('content-feat_tours.php' )); ?>
                            </div>
                            <?php
                            wp_reset_postdata();
                            endif;/*end if pulled_specific*/
                        endif;/*end if get_row_layout tours*/
                        if( get_row_layout() == 'categories' ): ?>
                            <div class="<?php if($col==5): ?>five-cols <?php else: ?><?php echo $col_def.$col; ?> col-eq-height<?php endif; ?>">
                            <?php //get_template_part( 'content', 'feat_cats' ); ?>
                            <?php include(locate_template('content-feat_cats.php' )); ?>
                            </div>
                        <?php
                        endif;

                        if( get_row_layout() == 'testimonials' ):
                            $pulled_specific = get_sub_field('pull_specific_from');

                            if($pulled_specific):
                                $post = $pulled_specific;
        				        setup_postdata( $post ); ?>
        				        <div class="<?php if($col==5): ?>five-cols <?php else: ?>col-sm-<?php echo $col; ?> col-eq-height<?php endif; ?>">
        				        <?php get_template_part( 'content', 'home_tstmls' ); ?>
        				        </div>
        				        <?php
        				        wp_reset_postdata();
                            endif;
                        endif;

                        endwhile;
                        endif;
                       ?>


                </div>
                </div>
        </div>
            </div><!-- .container-->
    </section>
                <?php endwhile; ?>

            <?php endif; ?>
