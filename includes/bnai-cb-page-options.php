<?php
    add_action( 'add_meta_boxes', 'bnai_cb_add_page_meta_box' );

    function bnai_cb_add_page_meta_box() {
        add_meta_box( 'bnai_cb_page_options', // ID attribute of metabox
                          __('Chatbot Botnation Options', 'chatbot-botnation'),       // Title of metabox visible to user
                          'bnai_cb_draw_page_options', // Function that prints box in wp-admin
                          'page',              // Show box for posts, pages, custom, etc.
                          'side',            // Where on the page to show the box
                          'default' );
    }

    add_action('load-post.php', 'bnai_cb_enable_help');

    function bnai_cb_generate_help_line($name, $desc) {
        return  '<p><strong>' . $name . '</strong>' . $desc . '</p>';
    }

    // Add help tab on edit page.
    function bnai_cb_enable_help() {
        // Add help tab
        $screen = get_current_screen();
        if ($screen->id != 'page') return;
        $screen->add_help_tab( array(
           'id' => 'bnai_cb_page_help_tab',            //unique id for the tab
           'title' =>  __('Chatbot Botnation', 'chatbot-botnation'),      //unique visible title for the tab
           'content' => bnai_cb_generate_help_line(__('Open automatically the chat (force)', 'chatbot-botnation'), __(' - If enabled, the chat will start automatically on this page.', 'chatbot-botnation'))
                 . bnai_cb_generate_help_line(__('Restart the conversation on sequence', 'chatbot-botnation'), __(' - You can start a specific sequence for this page by :', 'chatbot-botnation'))
                 . '<ul>'
                 . '<li>' . sprintf(__('Setting &laquo;%s&raquo; to restart your welcome sequence.','chatbot-botnation'), '<strong>restart</strong>') . '</li>'
                 . '<li>' . __('copying / pasting the ID of the sequence you want to start :','chatbot-botnation')
                 . '<div><img src="' .  esc_url(plugins_url('images/bnai-cb-help-ref.png', dirname(__FILE__))) . '" title="' . __('How to start a specific sequence', 'chatbot-botnation') . '"/></div>'
                 . '</li>'
                 . '</ul>'
        ) );
    }

    function bnai_cb_draw_page_options($post) {
        $values = get_post_custom( $post->ID );
        $auto_start = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_AUTO_START] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_AUTO_START][0] : 0;
        $ref = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_REF] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_REF][0] : '';
        $websiteId = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID][0] : '';
        $language = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE][0] : '';
        $containerId = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID][0] : '';
        $fullscreen = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_FULLSCREEN] ) ? $values[BNAI_CB_POST_CUSTOM_FIELD_FULLSCREEN][0] : 0;
        $externalVarsName = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME] ) ? explode(";", $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME][0]) : [];
        $externalVarsValue = isset( $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE] ) ? explode(";", $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE][0]) : [];

        wp_nonce_field( 'bnai_cb_page_meta_box_nonce_name', 'bnai_cb_nonce' );
        ?>
            <div class="wrap">
                  <strong><?php esc_html_e( 'Auto start', 'chatbot-botnation' ); ?></strong>
                  <br />
                  <input id="bnai_cb_page_auto_start_input" name="bnai_cb_page_auto_start_input" value="1" type="hidden" />
                  <label for="bnai_cb_page_auto_start">

                      <input id="bnai_cb_page_auto_start"
                             name="bnai_cb_page_auto_start"
                             type="checkbox"
                             value="1"
                             <?php echo isset( $auto_start ) ? ( checked( $auto_start, "1", true )) : ( '' ); ?> />
                     <?php esc_html_e( 'Enable this option to start automatically the chat.', 'chatbot-botnation' ); ?>
                  </label>
              </div>
              <div class="wrap">
                                  <strong><?php esc_html_e( 'Fullscreen', 'chatbot-botnation' ); ?></strong>
                                  <br />
                                <input id="bnai_cb_page_fullscreen_input" name="bnai_cb_page_fullscreen_input" value="1" type="hidden" />
                                <label for="bnai_cb_page_fullscreen">

                                    <input id="bnai_cb_page_fullscreen"
                                           name="bnai_cb_page_fullscreen"
                                           type="checkbox"
                                           value="1"
                                           <?php echo isset( $fullscreen ) ? ( checked( $fullscreen, "1", true )) : ( '' ); ?> />
                                   <?php esc_html_e( 'Set the fullscreen mod', 'chatbot-botnation' ); ?>
                                </label>
                            </div>
                <div class="wrap">
                                    <strong><?php esc_html_e( 'Website ID', 'chatbot-botnation' ); ?></strong>
                                    <input id="bnai_cb_page_website_id"
                                       class="regular-text"
                                       name="bnai_cb_page_website_id"
                                       type="text"
                                       style="width: 100%;"
                                       value="<?php echo $websiteId; ?>" />

              <div class="wrap">
                    <strong><?php esc_html_e( 'Ref.', 'chatbot-botnation' ); ?></strong>
                    <br />
                    <label for="bnai_cb_page_ref">
                       <?php esc_html_e( 'You can set a reference to start the bot at a specific sequence or fill with "restart" to restart the welcome sequence.', 'chatbot-botnation' ); ?>
                    </label>

                    <input id="bnai_cb_page_ref"
                       class="regular-text"
                       name="bnai_cb_page_ref"
                       type="text"
                       style="width: 100%;"
                       value="<?php echo $ref; ?>" />
                </div>
                <div class="wrap">
                    <strong><?php esc_html_e( 'Language', 'chatbot-botnation' ); ?></strong>
                    <br />
                    <label for="bnai_cb_page_language">
                       <?php esc_html_e( 'Choose the Chatbot language', 'chatbot-botnation' ); ?>
                    </label>

                    <select id="bnai_cb_page_language" name="bnai_cb_page_language" style="width: 90%;">
                          <option value="" <?php echo $language == "" ? "selected": "" ?>></option>
                          <option value="fr" <?php echo $language == "fr" ? "selected": "" ?>>Français</option>
                          <option value="en" <?php echo $language == "en" ? "selected": "" ?>>English</option>
                    </select>
                </div>
                <div class="wrap">
                    <strong><?php esc_html_e( 'Container Id', 'chatbot-botnation' ); ?></strong>
                    <br />
                    <label for="bnai_cb_page_container_id">
                       <?php esc_html_e( 'Allow to show the chatbot module in existing html tag. Must be the id of a HTML element.', 'chatbot-botnation' ); ?>
                    </label>

                    <input id="bnai_cb_page_container_id"
                       class="regular-text"
                       name="bnai_cb_page_container_id"
                       type="text"
                       style="width: 100%;"
                       value="<?php echo $containerId; ?>" />
                </div>

              <div class="wrap">
                <strong><?php esc_html_e( 'Variables', 'chatbot-botnation' ); ?></strong>
                 <br />
                  <label for="bnai_cb_page_container_id">
                     <?php esc_html_e( 'Add variables (name and value) to your Chatbot' ); ?>
                  </label>
                    <br />
                  <?php
                  for($i=0; $i<3; $i++){
                        ?>
                      <input id="bnai_cb_page_external_vars_name_<?php echo $i; ?>"
                         class="regular-text"
                         style="width:45%"
                         placeholder="<?php esc_html_e( 'Var. name', 'chatbot-botnation' ); ?>"
                         name="bnai_cb_page_external_vars_name[]"
                         type="text"
                         value="<?php echo $externalVarsName[$i]; ?>" />
                         :
                       <input id="bnai_cb_page_external_vars_value_<?php echo $i; ?>"
                         class="regular-text"
                         style="width:45%"
                         placeholder="<?php esc_html_e( 'Var. value', 'chatbot-botnation' ); ?>"
                         name="bnai_cb_page_external_vars_value[]"
                         type="text"
                         value="<?php echo $externalVarsValue[$i]; ?>" />
                         <?php
                   }
                   ?>
                </div>
        <?php
    }

    add_action( 'save_post', 'bnai_cb_meta_box_post_save' );

    function bnai_cb_meta_box_post_save($post_id) {
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['bnai_cb_nonce'] ) || !wp_verify_nonce( $_POST['bnai_cb_nonce'], 'bnai_cb_page_meta_box_nonce_name' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        if( isset( $_POST['bnai_cb_page_auto_start_input']) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_AUTO_START, $_POST['bnai_cb_page_auto_start'] );
        if( isset( $_POST['bnai_cb_page_ref'] ) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_REF, $_POST['bnai_cb_page_ref'] );
        if( isset( $_POST['bnai_cb_page_website_id'] ) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID, $_POST['bnai_cb_page_website_id'] );
        if( isset( $_POST['bnai_cb_page_language'] ) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE, $_POST['bnai_cb_page_language'] );
        if( isset( $_POST['bnai_cb_page_container_id'] ) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID, $_POST['bnai_cb_page_container_id'] );
        if( isset( $_POST['bnai_cb_page_fullscreen_input']) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_FULLSCREEN, $_POST['bnai_cb_page_fullscreen'] );

        if( isset( $_POST['bnai_cb_page_external_vars_name']) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME, implode(";", $_POST['bnai_cb_page_external_vars_name']));
        if( isset( $_POST['bnai_cb_page_external_vars_value']) ) update_post_meta( $post_id, BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE, implode(";", $_POST['bnai_cb_page_external_vars_value']));
    }
?>
