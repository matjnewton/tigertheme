<?php
 /**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * The template used for displaying page content in single.php
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */
?>

                <div class="col-sm-12">
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <strong><?php the_field('testimonial_quote'); ?></strong>
                            <p><?php the_field('full_testimonial'); ?></p>
                            <div class="t-author">
                                <?php 
                                $img_url = wp_get_attachment_url( get_field('photo'),'full');
                                $image = aq_resize( $img_url, 85, 84, true );
                                ?>
                                <?php if($img_url): ?>
                                <div class="author-img-wrapper">
                                    <img src="<?=$image?>" alt="<?=$image?>" class="img-circle" />
                                </div>
                                <?php endif; ?>
                                <div class="rate-about">
                                    
                                    <span>
                                    <?php the_title(); ?>
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="t-author">
                            <div class="triangle"></div>
                        </div>
                    </div>
                </div>
