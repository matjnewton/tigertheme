<?php

if (get_sub_field( 'tour_pc-coltype--form_la' ) === 'pc--form__native') :

    $form_id = get_sub_field( 'tour_pc-coltype--form_ob' );
    $form_font = get_sub_field('tour_pc-coltype--form_font');
    $ff = (isset($form_font['font-family']) && $form_font['font-family']) ? "style='font-family:\"{$form_font['font-family']}\", Arial, sans-serif'" : '';

//     {$form_font["font-family"]}

    // print_r_html([$form_font]);

    ?>
        <div class="gravity-form-native-layout-wrapper" <?=$ff?>>
            <div class="gravity-form-native-layout">
                <?php echo do_shortcode("[gravityforms id={$form_id} ajax=1]"); ?>
            </div>
        </div>
    <?php

else :


$tour_content_content_classes .= ' pc--form';
$tour_content_content_classes .= ' ' . get_sub_field( 'tour_pc-coltype--form_la' );
$tour_content_content_classes .= ' ' . get_sub_field( 'tour_pc-coltype--form_ti' );
$tour_content_content_classes .= ' ' . get_sub_field( 'tour_pc-coltype--form_le' );

$titles = get_sub_field( 'tour_pc-coltype--form_ti' ) != 'pc--form__head-hide';
$titles = (string)$title;

$form_id = get_sub_field( 'tour_pc-coltype--form_ob' );
?>

<div id="pca_form_id-<?php echo $form_id; ?>" class="<?php echo $tour_content_content_classes; ?>"  style="color:#000;">

  <?php
  /**
   * Important form variables
   */
  $form            = GFAPI::get_form( $form_id );
  $form['counter'] = 1;
  ?>

  <form method="post" id="gform_<?=$form_id;?>">
    <div class="gform_heading">
      <?php if ( $form['title'] ) : ?><div class="gform_title"><?php echo $form['title']; ?></div><?php endif; ?>
      <?php if ( $form['description'] ) : ?><div class="gform_description"><?php echo $form['description']; ?></div><?php endif; ?>
    </div>

    <div class="gform_body">
      <ul
          id="gform_fields_<?=$form_id;?>"
          class="gform_fields <?=$form["labelPlacement"];?> description_<?=$form["descriptionPlacement"];?>">

        <?php
        /**
         * Print fields
         */
        foreach ( $form["fields"] as $field ) :
          ?>

          <li id="field_<?=$form_id;?>_<?=$form['counter'];?>" data-id="<?=$field['id']?>" class="gfield">

            <?php $label_class = $field['isRequired'] ? 'is-required' : '';

            $label_for = ( $field['type'] !== 'consent' ) ? 'for="field_' . $form_id . '_' . $form['counter'].'"' : '';

            ?>

            <label class="gfield_label <?=$label_class;?>" <?=$label_for;?>><?=$field['label'];?></label>

            <div class="ginput_container ginput_container_<?=$field['type'];?>">

              <?php
              /**
               * Set field attributes
               */
              $class = $field['type'] . ' gfield_' . $field['type'];
              $attr  = '';
              $attr .= $field['placeholder'] ? 'placeholder="' . $field['placeholder'] . '" ' : '';
              $attr .= 'data-field-label="' . $field['label'] . '" ';
              $attr .= $field['isRequired'] ? 'data-field-required="' . $field['isRequired'] . '" ' : '';

              /**
               * Conditional logic
               */
              $attr_conditional = '';
              if ( $field['conditionalLogic'] ) :
                $conditional = $field['conditionalLogic'];

                // Set type to know who to handle this field
                $attr_conditional .= 'data-conditional-type="' . $conditional['actionType'] . '" ';

                // Loop rules
                foreach ( $conditional['rules'] as $rule ) :
                  $attr_conditional .= 'data-conditional-id="' . $rule['fieldId'] . '" ';
                  $attr_conditional .= 'data-conditional-operator="' . $rule['operator'] . '" ';
                  $attr_conditional .= 'data-conditional-value="' . $rule['value'] . '" ';
                endforeach;
              endif;

              /**
               * Echo field template
               */
              switch ( $field['type'] ) :


                case 'name':
                case 'address':

                  $attr       .= 'class="' . $class . '" ';
                  $attr       .= 'disabled ';
                  $attr       .= $field['defaltValue'] ? 'value="' . $field['defaltValue'] . '" ' : '';
                  $attr       .= 'type="text" ';
                  $attr       .= $field['inputMask'] ? 'data-field-mask="' . $field['inputMaskValue'] . '" disabled ' : '';
                  $attr       .= $field['maxLength'] ? 'data-field-length="' . $field['maxLength'] . '"' : '';
                  $attr       .= 'data-field-input ';
                  $attr       .= $attr_conditional;

                  echo '<div class="ginput_container--common">';

                  foreach ( $field['inputs'] as $input ) :

                    if ( $input['isHidden'] != '1' ) :
                      $input_attr  = $attr;
                      $id          = explode('.', $input['id'])[1];
                      $input_attr .= 'name="input_' . $field['id'] . '_' . $id . '" ';
                      $input_attr .= 'id="input_' . $form_id . '_' . $field['id'] . '_' . $id . '" ';
                      ?>

                      <div class="ginput_name--wrap">
                        <input <?=$input_attr;?> />
                        <label class="ginput_common--label"><?=$input['label'];?></label>
                      </div>

                    <?php

                    endif;

                  endforeach;

                  echo '</div>';

                  break;

                /**
                 * Textarea field
                 */
                case 'textarea':
                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $attr .= 'disabled ';
                  $attr .= $field['maxLength'] ? 'data-field-length="' . $field['maxLength'] . '"' : '';
                  $attr .= 'class="' . $class . '" ';
                  $attr .= $attr_conditional;
                  echo "<textarea " . $attr . ">" . $field['defaltValue'] . "</textarea>";
                  break;


                /**
                 * Select & Multiselect
                 */
                case 'select':
                case 'multiselect':
                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $attr .= $field['type'] == 'multiselect' ? 'multiple' : '';
                  $attr .= 'class="' . $class . '" ';
                  $attr .= $attr_conditional;
                  echo "<select " . $attr . " data-size='8'>";

                  foreach ( $field['choices'] as $option ) :
                    $is_selected = $option['isSelected'] ? 'selected' : '';
                    echo '<option class="' . $option['value'] . '" ' . $is_selected . '>' . $option['text'] . '</option>';
                  endforeach;

                  echo "</select>";
                  break;


                /**
                 * Google reCaptcha
                 */
                case 'gf_no_captcha_recaptcha':
                case 'captcha':
                  $recaptcha = insert_recaptcha_html();
                  echo $recaptcha;
                  break;


                /**
                 * Radiobox and checkbox fields
                 */
                case 'radio':
                case 'checkbox':
                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $attr .= 'disabled ';
                  $attr .= 'class="' . $class . '" ';
                  /**
                   * Check extra options
                   */
                  $is_another_choice = (bool)$field['enableOtherChoice'];

                  /**
                   * div wrapper attributes
                   */
                  $div_attr  = '';
                  $div_attr .= 'class="gchoices_container ginput_container ginput_container_' . $field['type'] . '" ';

                  /**
                   * ul attributes
                   */
                  $ul_attr  = '';
                  $ul_attr .= 'id="input_' . $form_id . '_' . $form['counter'] . '" ';
                  $ul_attr .= 'class="' . $field['type'] . ' gfield_' . $field['type'] . ' gchoices_list" ';
                  $ul_attr .= 'data-field-required="' . $field['isRequired'] . '" ';
                  $ul_attr .= 'data-form-other-choice="' . $is_another_choice . '"';

                  $li_items = '';

                  $choices_count = count($field['choices']);

                  /**
                   * Loop each choice
                   */
                  for ( $choice_id = 0; $choice_id < $choices_count; $choice_id++ ) :
                    $choice = $field['choices'][$choice_id];
                    $attrName = $field['type'] == 'radio' ? 'input_' . $field['id'] : 'input_' . $field['id'] . '_' . ($choice_id + 1);

                    /**
                     * li attributes
                     */
                    $li_attr  = '';
                    $li_attr .= 'class="gchoice_item gchoice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';

                    /**
                     * Rewrite attributes completely
                     */
                    $attr  = '';
                    $attr .= 'type="' . $field['type'] . '" ';
                    $attr .= 'name="' . $attrName . '" ';
                    $attr .= 'id="gchoice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';
                    $attr .= 'class="' . $field['type'] . ' gfield_choice gfield_' . $field['type'] . '" ';
                    $attr .= 'data-field-label="' . $field['label'] . '" ';
                    $attr .= $choice['isSelected'] ? 'checked ' : '';
                    $attr .= 'value="' . $choice['value'] . '" ';
                    $attr .= $attr_conditional;

                    /**
                     * label attributes
                     */
                    $label_attr  = '';
                    $label_attr .= 'class="choice_label choice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';
                    $label_attr .= 'for="gchoice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';

                    $li_items .= "<li {$li_attr}><input {$attr} /><label {$label_attr}>{$choice['text']}</label></li>";
                  endfor;

                  /**
                   * Add another choice field
                   */
                  if ( $is_another_choice ) :
                    $choice_id++;

                    /**
                     * li attributes
                     */
                    $li_attr  = '';
                    $li_attr .= 'class="gchoice_item gchoice_item_more gchoice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';

                    /**
                     * Rewrite atributes completely
                     */
                    $attr  = '';
                    $attr .= 'type="' . $field['type'] . '" ';
                    $attr .= 'name="' . $attrName . '" ';
                    $attr .= 'id="gchoice_' . $form_id . '_' . $form['counter'] . '_' . $choice_id . '" ';
                    $attr .= 'class="' . $field['type'] . ' gfield_choice gfield_' . $field['type'] . '" ';
                    $attr .= $choice['isSelected'] ? 'checked ' : '';
                    $attr .= 'data-form-more="1" ';
                    $attr .= $attr_conditional;

                    /**
                     * Text input attrs
                     */
                    $more_attr  = '';
                    $more_attr .= 'data-form-more-field ';
                    $more_attr .= 'class="gfield_more" ';
                    $more_attr .= 'data-field-label="' . $field['label'] . '" ';
                    $more_attr .= 'type="text" ';

                    $li_items .= "<li {$li_attr}><input {$attr} /><input {$more_attr} /></li>";
                  endif;

                  echo "<div {$div_attr}><ul {$ul_attr}>{$li_items}</ul></div>";

                  break;


                /**
                 * Date
                 */
                case 'date':
                  switch ($field['dateFormat']) :
                    case 'dmy_dash':
                      $field['dateFormat'] = 'DD-MM-YYYY';
                      break;
                    case 'mdy_dash':
                      $field['dateFormat'] = 'MM-DD-YYYY';
                      break;
                    case 'dmy':
                      $field['dateFormat'] = 'DD/MM/YYYY';
                      break;
                    case 'dmy_dot':
                      $field['dateFormat'] = 'DD.MM.YYYY';
                      break;
                    case 'ymd_slash':
                      $field['dateFormat'] = 'YYYY/MM/DD';
                      break;
                    case 'ymd_dash':
                      $field['dateFormat'] = 'YYYY-MM-DD';
                      break;
                    case 'ymd_dot':
                      $field['dateFormat'] = 'YYYY.MM.DD';
                      break;
                    case 'mdy':
                    default;
                      $field['dateFormat'] = 'mm/dd/yyyy';
                      break;
                  endswitch;

                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $class .= ' pc--date';
                  $attr  .= 'disabled ';
                  $attr  .= $field['defaltValue'] ? 'value="' . $field['defaltValue'] . '" ' : '';
                  $attr  .= 'type="text" ';
                  $attr  .= "data-date-format='{$field['dateFormat']}' ";
                  $attr  .= $field['maxLength'] ? 'data-field-length="' . $field['maxLength'] . '" ' : '';
                  $attr  .= 'data-field-input ';
                  $attr  .= 'class="' . $class . '" ';
                  $attr  .= 'style="height:54px;" ';
                  $attr .= $attr_conditional;
                  $attr .= $field['limitDateRangeMinDate'] ? 'data-min-date="'.$field['limitDateRangeMinDate'].'"' : '';
                  $attr .= $field['limitDateRangeMaxDate'] ? 'data-max-date="'.$field['limitDateRangeMaxDate'].'"' : '';

                  echo "<input " . $attr . " /><style>#vinetrekker_piker.daterangepicker{margin-left:0!important;
										}</style>";

                  break;


                /**
                 * File
                 */
                case 'fileupload':
                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $attr .= 'class="' . $class . '" ';
                  $attr .= 'data-field-input ';

                  echo "<input type='hidden' name='MAX_FILE_SIZE' value='262144000'>";
                  echo "<input {$attr} type='file'>";

                  break;

                case 'email':

                  $attr .= 'disabled ';
                  $attr .= 'class="' . $class . '" ';
                  $attr .= $field['defaltValue'] ? 'value="' . $field['defaltValue'] . '" ' : '';
                  $attr .= 'type="email" ';
                  $attr .= $field['inputMask'] ? 'data-field-mask="' . $field['inputMaskValue'] . '" disabled ' : '';
                  $attr .= $field['maxLength'] ? 'data-field-length="' . $field['maxLength'] . '"' : '';
                  $attr .= 'data-field-input ';
                  $attr .= $attr_conditional;

                  if (isset($field['inputs']) && count($field['inputs'])) :

                    echo '<div class="ginput_container--common">';

                    foreach ( $field['inputs'] as $input ) :

                      if ( $input['isHidden'] != '1' ) :
                        $input_attr  = $attr;
                        $id          = explode('.', $input['id'])[1];
                        $input_attr .= $id ? 'name="input_' . $field['id'] . '_' . $id . '" ' : 'name="input_' . $field['id'] . '" ';
                        $input_attr .= $id ? 'id="input_' . $form_id . '_' . $field['id'] . '_' . $id . '" ' : 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                        ?>

                        <div class="ginput_name--wrap">
                          <input <?=$input_attr;?> />
                          <label class="ginput_common--label"><?=$input['label'];?></label>
                        </div>

                      <?php

                      endif;

                    endforeach;

                    echo '</div>';
                  else :

                    if ( $field['cssClass'] == 'user_email' ) $attr .= 'data-user-email="1"';
                    $attr .= $attr_conditional;

                    $attr .= 'name="input_' . $field['id'] . '" ';
                    $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';

                    echo "<input " . $attr . " />";

                  endif;
                  break;


                case 'consent':

                    ?>
                    <div style='color:orangered; width:80vw'>

                        <h4>Please use "Native Form Layout" in "Form layout" setting in order to make this field work correctly.</h4>
                        <h4>Note: this will display styles in original gravity-form way.</h4>

                    </div>
                    <?php

                    break;

                case 'consent-1st-attempt-not-working':    // TODO: might be completed in future

                    // print_r_html($field);

                    $i = $field['inputs'];

                    // print_r_html($field['inputs']);


                    $at = 'placeholder="" data-field-label="'. $field['label'] .'" ';
                    $at .= $field['isRequired'] ? '" data-field-required="true"' : '';
                    $at .= 'name="input_' . $i[0]['id'] . '" ';
                    $at .= 'id="input_' . $form_id . '_' . $field['id'] . '_1" ';
                    $at .= 'class="' . $class . ' ' . $field['cssClass'] . '" ';
                    $at .= 'type="checkbox" ';
                    $at .= 'value="1" ';
                    $at .= 'aria-describedby="gfield_consent_description_' . $form_id . '_' . $field['id'] . '" ';
                    $at .= 'aria-invalid="false" ';
                    $at .= $field['isRequired'] ? 'aria-required="true"' : '';
                    $at .= 'data-field-input tabindex="0" data-handled="1"';

                    $label_text = $field['checkboxLabel'];
                    $label_attr = 'for="input_'. $form_id . '_' . $field['id'] . '_1"';

                     // echo "Attr: $attr";


                    ?>

                    <input <?=$at;?>>
                    <label class="gfield_consent_label" <?=$label_attr;?>><?=$label_text;?></label>
                    <input type="hidden" name="input_<?=$i[1]['id'];?>" value="<?=$label_text?>" class="gform_hidden">
                    <input type="hidden" name="input_<?=$i[2]['id'];?>" value="<?=$field['id'];?>" class="gform_hidden">

                    <?php
                    break;


                /**
                 * Text, number, email, url
                 */
                default:
                  $attr .= 'name="input_' . $field['id'] . '" ';
                  $attr .= 'id="input_' . $form_id . '_' . $field['id'] . '" ';
                  $attr .= 'class="' . $class . '" ';
                  $attr .= 'disabled ';
                  $attr .= $field['defaltValue'] ? 'value="' . $field['defaltValue'] . '" ' : '';

                  if ( $field['type'] == 'phone' ) :
                    $field['type'] = 'text';
                    $attr         .= 'data-field-mask="(000) 000-0000" disabled ';
                  endif;

                  $attr .= 'type="' . $field['type'] . '" ';
                  $attr .= $field['inputMask'] ? 'data-field-mask="' . $field['inputMaskValue'] . '" disabled ' : '';
                  $attr .= $field['maxLength'] ? 'data-field-length="' . $field['maxLength'] . '"' : '';
                  $attr .= 'data-field-input ';

                  if ( $field['cssClass'] == 'user_email' ) $attr .= 'data-user-email="1"';
                  $attr .= $attr_conditional;

                  echo "<input " . $attr . " />";
                  break;


              endswitch;
              ?>

            </div>

          <?php if ($field['type'] === 'consent-test') : ?>

          <div class="gfield_description gfield_consent_description" id="gfield_consent_description_<?php echo $form_id . '_' . $field['id'];?>">
              <?php echo nl2br($field['description']);?>
          </div>

          <?php endif; ?>

          </li>

          <?php
          $form['counter'] += 1;
        endforeach;
        ?>

      </ul>
    </div>

    <div class="gform_footer <?=$form["labelPlacement"];?>">

      <?php
      /**
       * Print footer fields
       */
      if ( $form["button"]["type"] == 'text' ) :
        echo '<button 
						id="gform_submit_button_'.$form_id.'" 
						class="gform_button button"
						disabled
						type="submit">'.$form["button"]["text"].'</button>';
      endif;
      ?>

      <!-- Common values -->
      <input type="hidden" name="is_submit_<?=$form_id;?>" value="1">
      <input type="hidden" name="gform_submit" value="<?=$form_id;?>">
      <input type="hidden" name="gform_field_values">

      <!-- Notifivations -->
      <?php
      $notify_id = 0;
      foreach ( $form["notifications"] as $notification ) :

        if ( $notification["to"] == '{admin_email}' ) :
          $notification["to"] = get_bloginfo('admin_email');
        elseif ( $notification["to"] == '{user_email}' ) :
          $notification["to"] = 'user_email';
        endif;
        ?>

        <div class="gform_notify_group">
          <input type="hidden" name="gform_notify_name_<?=$notify_id;?>" value="<?=$notification["name"];?>">
          <input type="hidden" name="gform_notify_event_<?=$notify_id;?>" value="<?=$notification["event"];?>">
          <input type="hidden" name="gform_notify_to_<?=$notify_id;?>" value="<?php echo $notification["to"]; ?>">
          <input type="hidden" name="gform_notify_to_type_<?=$notify_id;?>" value="<?=$notification["toType"];?>">
          <input type="hidden" name="gform_notify_subject_<?=$notify_id;?>" value="<?=$notification["subject"];?>">
          <input type="hidden" name="gform_notify_from_<?=$notify_id;?>" value="<?php echo $notification["from"] == '{admin_email}' ? get_bloginfo('admin_email') : $notification["from"];?>">
          <input type="hidden" name="gform_notify_from_name_<?=$notify_id;?>" value="<?=$notification["fromName"];?>">
          <input type="hidden" name="gform_notify_message_<?=$notify_id;?>" value="<?=$notification["message"];?>">
        </div>

        <?php
        $notify_id++;
      endforeach;
      ?>

      <!-- Confirmations -->
      <?php
      foreach ( $form["confirmations"] as $confirmation ) :
        ?>
        <input type="hidden" name="gform_conf_name" value="<?=$confirmation["name"];?>">
        <input type="hidden" name="gform_conf_is_default" value="<?=$confirmation["isDefault"];?>">
        <input type="hidden" name="gform_conf_type" value="<?=$confirmation["type"];?>">
        <input type="hidden" name="gform_conf_message" value="<?php echo htmlentities($confirmation["message"]);?>">
        <input type="hidden" name="gform_conf_url" value="<?=$confirmation["url"];?>">
        <input type="hidden" name="gform_conf_page_id" value="<?=$confirmation["pageId"];?>">
        <input type="hidden" name="gform_conf_home_url" value="<?php bloginfo('url'); ?>">
      <?php
      endforeach;
      ?>

    </div>
  </form>

</div>


<?php endif;
