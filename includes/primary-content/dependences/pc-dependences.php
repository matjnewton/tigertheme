<?php 

/**
  *  Resizes an image and returns the resized URL. 
  */
add_action('delete_attachment', 'mr_delete_resized_images');

function mr_image_resize($url, $width=null, $height=null, $crop=true, $align='c', $retina=false) {
  global $wpdb;
  // Get common vars (func_get_args() only get specified values)
  $common = mr_common_info($url, $width, $height, $crop, $align, $retina);
  
  // Unpack vars if got an array...
  if (is_array($common)) extract($common);
  // ... Otherwise, return error, null or image
  else return $common;
  if (!file_exists($dest_file_name)) {
    // We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
    $query = $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE guid='%s'", $url);
    $get_attachment = $wpdb->get_results($query);
    // Load WordPress Image Editor
    $editor = wp_get_image_editor($file_path);
    
    // Print possible wp error
    if (is_wp_error($editor)) {
      if (is_user_logged_in()) print_r($editor);
      return null;
    }
    if ($crop) {
      $src_x = $src_y = 0;
      $src_w = $orig_width;
      $src_h = $orig_height;
      $cmp_x = $orig_width / $dest_width;
      $cmp_y = $orig_height / $dest_height;
      // Calculate x or y coordinate and width or height of source
      if ($cmp_x > $cmp_y) {
        $src_w = round ($orig_width / $cmp_x * $cmp_y);
        $src_x = round (($orig_width - ($orig_width / $cmp_x * $cmp_y)) / 2);
      } else if ($cmp_y > $cmp_x) {
        $src_h = round ($orig_height / $cmp_y * $cmp_x);
        $src_y = round (($orig_height - ($orig_height / $cmp_y * $cmp_x)) / 2);
      }
      // Positional cropping. Uses code from timthumb.php under the GPL
      if ($align && $align != 'c') {
        if (strpos ($align, 't') !== false) {
          $src_y = 0;
        }
        if (strpos ($align, 'b') !== false) {
          $src_y = $orig_height - $src_h;
        }
        if (strpos ($align, 'l') !== false) {
          $src_x = 0;
        }
        if (strpos ($align, 'r') !== false) {
          $src_x = $orig_width - $src_w;
        }
      }
      
      // Crop image
      $editor->crop($src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height);
    } else {
     
      // Just resize image
      $editor->resize($dest_width, $dest_height);
     
    }
    // Save image
    $saved = $editor->save($dest_file_name);
    
    // Print possible out of memory error
    if (is_wp_error($saved)) {
      if (is_user_logged_in()) {
        print_r($saved);
        unlink($dest_file_name);
      }
      return null;
    }
    // Add the resized dimensions and alignment to original image metadata, so the images
    // can be deleted when the original image is delete from the Media Library.
    if ($get_attachment) {
      $metadata = wp_get_attachment_metadata($get_attachment[0]->ID);
      if (isset($metadata['image_meta'])) {
        $md = $saved['width'] . 'x' . $saved['height'];
        if ($crop) $md .= ($align) ? "_${align}" : "_c";
        $metadata['image_meta']['resized_images'][] = $md;
        wp_update_attachment_metadata($get_attachment[0]->ID, $metadata);
      }
    }
    // Resized image url
    $resized_url = str_replace(basename($url), basename($saved['path']), $url);
  } else {
    // Resized image url
    $resized_url = str_replace(basename($url), basename($dest_file_name), $url);
  }
  // Return resized url
  return $resized_url;
}

// Returns common information shared by processing functions
function mr_common_info($url, $width, $height, $crop, $align, $retina) {
  // Return null if url empty
  if (empty($url)) {
    return is_user_logged_in() ? "image_not_specified" : null;
  }
  // Return if nocrop is set on query string
  if (preg_match('/(\?|&)nocrop/', $url)) {
    return $url;
  }
  
  // Get the image file path
  $urlinfo = parse_url($url);
  $wp_upload_dir = wp_upload_dir();
  
  if (preg_match('/\/[0-9]{4}\/[0-9]{2}\/.+$/', $urlinfo['path'], $matches)) {
    $file_path = $wp_upload_dir['basedir'] . $matches[0];
  } else {
    $pathinfo = parse_url( $url );
    $uploads_dir = is_multisite() ? '/files/' : '/wp-content/';
    $file_path = ABSPATH . str_replace(dirname($_SERVER['SCRIPT_NAME']) . '/', '', strstr($pathinfo['path'], $uploads_dir));
    $file_path = preg_replace('/(\/\/)/', '/', $file_path);
  }
  
  // Don't process a file that doesn't exist
  if (!file_exists($file_path)) {
    return null; // Degrade gracefully
  }
  
  // Get original image size
  $size = is_user_logged_in() ? getimagesize($file_path) : @getimagesize($file_path);
  // If no size data obtained, return error or null
  if (!$size) {
    return is_user_logged_in() ? "getimagesize_error_common" : null;
  }
  // Set original width and height
  list($orig_width, $orig_height, $orig_type) = $size;
  // Generate width or height if not provided
  if ($width && !$height) {
    $height = floor ($orig_height * ($width / $orig_width));
  } else if ($height && !$width) {
    $width = floor ($orig_width * ($height / $orig_height));
  } else if (!$width && !$height) {
    return $url; // Return original url if no width/height provided
  }
  // Allow for different retina sizes
  $retina = $retina ? ($retina === true ? 2 : $retina) : 1;
  // Destination width and height variables
  $dest_width = $width * $retina;
  $dest_height = $height * $retina;
  // Some additional info about the image
  $info = pathinfo($file_path);
  $dir = $info['dirname'];
  $ext = $info['extension'];
  $name = wp_basename($file_path, ".$ext");
  // Suffix applied to filename
  $suffix = "${dest_width}x${dest_height}";
  // Set align info on file
  if ($crop) {
    $suffix .= ($align) ? "_${align}" : "_c";
  }
  // Get the destination file name
  $dest_file_name = "${dir}/${name}-${suffix}.${ext}";
  
  // Return info
  return array(
    'dir' => $dir,
    'name' => $name,
    'ext' => $ext,
    'suffix' => $suffix,
    'orig_width' => $orig_width,
    'orig_height' => $orig_height,
    'orig_type' => $orig_type,
    'dest_width' => $dest_width,
    'dest_height' => $dest_height,
    'file_path' => $file_path,
    'dest_file_name' => $dest_file_name,
  );
}

// Deletes the resized images when the original image is deleted from the WordPress Media Library.
function mr_delete_resized_images($post_id) {
  // Get attachment image metadata
  $metadata = wp_get_attachment_metadata($post_id);
  
  // Return if no metadata is found
  if (!$metadata) return;
  // Return if we don't have the proper metadata
  if (!isset($metadata['file']) || !isset($metadata['image_meta']['resized_images'])) return;
  
  $wp_upload_dir = wp_upload_dir();
  $pathinfo = pathinfo($metadata['file']);
  $resized_images = $metadata['image_meta']['resized_images'];
  
  // Delete the resized images
  foreach ($resized_images as $dims) {
    // Get the resized images filename
    $file = $wp_upload_dir['basedir'] . '/' . $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $dims . '.' . $pathinfo['extension'];
    // Delete the resized image (if it has not yet been deleted)
    @unlink($file);
  }
}

function thumb_crop_etrange($url, $width, $height=0, $align='') {
  return mr_image_resize($url, $width, $height, true, $align, false);
}

function the_excerpt_max_charlength($charlength) {
        $excerpt = get_the_excerpt();
        $charlength++;

        if ( mb_strlen( $excerpt ) > $charlength ) {
                $subex = mb_substr( $excerpt, 0, $charlength - 5 );
                $exwords = explode( ' ', $subex );
                $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
                if ( $excut < 0 ) {
                        echo mb_substr( $subex, 0, $excut );
                } else {
                        echo $subex;
                }
                echo '[...]';
        } else {
                echo $excerpt;
        }
}

add_action("wp_footer", "add_primary_area_show_rows", 100);
 
function add_primary_area_show_rows() { ?>

  <style>
    [data-aload] { background-image: none !important; }

    .banner-top .flxslider-wrapper {
      min-height: auto!important;
    }
  </style>

  <script type="text/javascript">
    jQuery(window).load(function () {
      jQuery('.pc--r').removeClass('hidden-load');
    });

    function aload(t){"use strict";var e="data-aload";return t=t||window.document.querySelectorAll("["+e+"]"),void 0===t.length&&(t=[t]),[].forEach.call(t,function(t){t["LINK"!==t.tagName?"src":"href"]=t.getAttribute(e),t.removeAttribute(e)}),t}

    window.onload = function () {
      aload();
    };

    jQuery(function(){
      jQuery('.pc--crop__thumb').each(function(index, thisItem){
        var blog_thumb_w = jQuery(this).width();
        var blog_thumb_h = '';

        if ( jQuery(this).hasClass('pc--c__b-image--tall') ) {
          blog_thumb_h = blog_thumb_w * 1.35;
        } else {
          if ( jQuery(this).hasClass('pc--c__b-image--normal') ) {
            blog_thumb_h = blog_thumb_w / 1.35;
          } else { 
            if ( jQuery(this).hasClass('pc--c__b-image--square') ) {
              blog_thumb_h = blog_thumb_w;
            } else { 
              if ( jQuery(this).hasClass('pc--c__b-image--really-tall') ) {
                blog_thumb_h = blog_thumb_w * 2;
              } else {
                blog_thumb_h = blog_thumb_w / 1.35;
              }
            }
          }
        }

        jQuery(this).css( 'min-height', blog_thumb_h );
      });

      jQuery('.pc--crop__video').each(function(index, thisItem){
        var blog_thumb_w = jQuery(this).width();
        var blog_thumb_h = blog_thumb_w / 1.75;

        jQuery(this).css( 'max-height', blog_thumb_h );
      });
    });

    !(function(){
        jQuery(function(){
            var section = jQuery('.pc--s__img--eqvival');

            section.each(function(){
              var href = jQuery(this).attr('style'),
                  match_url = href.match(/http:\/\/[^\s\Z]+/i)[0].split( ');' ),
                  img = new Image();

                  img.src = match_url[0];

              var img_percent = img.height / img.width * 100;
              var img_height = screen.width / 100 * img_percent;

                  $(this).css('min-height', img_height);
                  console.log(img_height);
            });
        });
    })();
  </script>

<?php } ?>
