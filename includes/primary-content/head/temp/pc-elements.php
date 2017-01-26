
    <div class="
        pc-hero-content 
        pc-hero-content__<?php echo $hero_height; ?>
        pc-hero-content__<?php echo $hero_width; ?>
        pc-hero-content__<?php echo $hero_align_v; ?>
        pc-hero-content__<?php echo $hero_align_h; ?>
    "> 

        <?php 
            for ( $i = 1; $i < 4; $i++ ) {
                $title = get_sub_field( 'pc_ha_' . $i . '-tit' );
                $tag = get_sub_field( 'pc_ha_' . $i . '-tit_seo' );
                $hr = get_sub_field( 'pc_ha_' . $i . '-tit_hr' );
                $hr_c = get_sub_field( 'pc_ha_' . $i . '-tit_hr-c' ) ? get_sub_field( 'pc_ha_' . $i . '-tit_hr-c' ) : '#333';
                $hr_w = get_sub_field( 'pc_ha_' . $i . '-tit_hr-w' );
                $hr_i = get_sub_field( 'pc_ha_' . $i . '-tit_hr-i' ) ? get_sub_field( 'pc_ha_' . $i . '-tit_hr-i' ) : '';

                echo $title ? '<' . $tag . '>' . $title . '</' . $tag . '>' : '';
                echo $hr && !$hr_i ? '<hr class="pc_ha_hr pc_ha_hr-' . $hr_w . '" style="color:' . $hr_c . ';">' : '';
                echo $hr && $hr_i ? '<img class="pc_ha_hr-img" src="'. $hr_i . '" alt="" />' : $hr_i;
            }
        ?>

        <?php if ( $cta_button_text ) include( get_stylesheet_directory() . '/includes/primary-content/head/temp/pc-elements-button.php' ); ?>
    </div>

<?php include( get_stylesheet_directory() . '/includes/primary-content/head/temp/pc-elements-addons.php' ); ?>