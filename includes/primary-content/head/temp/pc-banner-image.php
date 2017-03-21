
<div class="flxslider-wrapper">
    <div id="slider">
        <ul class="slides">

            <?php
                $image = get_sub_field( 'pc_hero_image' );
                $simage = aq_resize( $image['url'], 1440, $hero_height_n, true ); ?>

                <li style="
                    background-image: url(<?php echo $simage; ?>); 
                    background-repeat: no-repeat; 
                    background-size: 100% auto; 
                    background-position: center center; 
                    width: 100%; 
                    <?php echo get_sub_field( 'pc_ha_image-fixed' ) == 'yes' ? 'background-attachment: fixed;' : ''; ?>">

                    <?php include ( get_stylesheet_directory() . '/includes/primary-content/head/temp/pc-elements.php' ); ?>

                </li>

        </ul>
    </div>
</div>