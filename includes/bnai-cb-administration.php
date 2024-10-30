<?php
/*
 * Insert an administration menu to configure the plugin.
 */
    $chatbot_botnation_options = 'bnai_cb_options';

    // Hook the 'admin_menu' action hook, run the function named 'bnai_cb_Add_My_Admin_Link()'
    add_action( 'admin_menu', 'bnai_cb_create_menu' );

    // Add a new top level menu link to the ACP
    function bnai_cb_create_menu() {
        add_options_page(
            'Chatbot Botnation Options',
            'Chatbot Botnation',
            'manage_options',
            'bnai_cb',
            'bnai_cb_options_build_page_html_cb'
        );
    }

    /**
     * register our bnai_cb_settings_init to the admin_init action hook
     */
    add_action( 'admin_init', 'bnai_cb_register_settings' );

    /**
     * custom option and settings
     */
    function bnai_cb_register_settings() {
        // register a new setting for page
        register_setting( 'bnai_cb', 'bnai_cb_options' );

        // register a new section in the page
        add_settings_section(
            'bnai_cb_section_developers',
            __( 'Chatbot Botnation.', 'chatbot-botnation' ),
            'bnai_cb_section_developers_cb',
            'bnai_cb'
        );

        // WEBSITE ID
        add_settings_field(
            'bnai_cb_field_website_id',
            __( 'Website ID', 'chatbot-botnation' ),
            'bnai_cb_field_website_id_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_website_id',
                'class' => 'bnai_cb_row',
            ]
        );

        // AUTO START
        add_settings_field(
            'bnai_cb_field_auto_start',
            __( 'Auto start', 'chatbot-botnation' ),
            'bnai_cb_field_auto_start_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_auto_start',
                'class' => 'bnai_cb_row',
            ]
        );

        // FULLSCREEN
                add_settings_field(
                    'bnai_cb_field_fullscreen',
                    __( 'Fullscreen', 'chatbot-botnation' ),
                    'bnai_cb_field_fullscreen_cb',
                    'bnai_cb',
                    'bnai_cb_section_developers',
                    [
                        'label_for' => 'bnai_cb_field_fullscreen',
                        'class' => 'bnai_cb_row',
                    ]
                );

        // LAUNCH AT END
        add_settings_field(
            'bnai_cb_field_launch_at_end',
            __( 'Launch on loaded page', 'chatbot-botnation' ),
            'bnai_cb_field_launch_at_end_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_launch_at_end',
                'class' => 'bnai_cb_row',
            ]
        );

        // REF
        add_settings_field(
            'bnai_cb_field_ref',
            __( 'Ref.', 'chatbot-botnation' ),
            'bnai_cb_field_ref_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_ref',
                'class' => 'bnai_cb_row',
            ]
        );

        // LANGUAGE
        add_settings_field(
            'bnai_cb_field_language',
            __( 'Language', 'chatbot-botnation' ),
            'bnai_cb_field_language_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_language',
                'class' => 'bnai_cb_row',
            ]
        );

        // CONTAINER ID
        add_settings_field(
            'bnai_cb_field_container_id',
            __( 'Container Id', 'chatbot-botnation' ),
            'bnai_cb_field_container_id_cb',
            'bnai_cb',
            'bnai_cb_section_developers',
            [
                'label_for' => 'bnai_cb_field_container_id',
                'class' => 'bnai_cb_row',
            ]
        );


    }

    /**
     * custom option and settings:
     * callback functions
     */

    // developers section cb

    // section callbacks can accept an $args parameter, which is an array.
    // $args have the following keys defined: title, id, callback.
    // the values are defined at the add_settings_section() function.
    function bnai_cb_section_developers_cb( $args ) {
     ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Configure form above from your web project on ', 'chatbot-botnation' ); ?><a href="https://botnation.ai"><?php esc_html_e('Botnation AI', 'chatbot-botnation' ); ?></a></p>
     <?php
    }

    // WEBSITE ID field cb
    function bnai_cb_field_website_id_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
               name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               type="text"
               class="regular-text"
               required
               value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>" />
        <span class="description">
            <?php esc_html_e( 'This field is required.', 'chatbot-botnation' ); ?>
        </span>
        <?php
    }

    // AUTO START field cb
    function bnai_cb_field_auto_start_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
            <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
                           name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                           type="checkbox"
                           value="1"
                           <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, true )) : ( '' ); ?> />
           <?php esc_html_e( 'Enable this option to start automatically the chat.', 'chatbot-botnation' ); ?>
        </label>
        <?php
    }

    // LAUNCH AT END field cb
    function bnai_cb_field_launch_at_end_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
            <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
                           name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                           type="checkbox"
                           value="1"
                           <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, true )) : ( '' ); ?> />
           <?php esc_html_e( 'Enable this option to launch the Chatbot as soon as the page is fully loaded.', 'chatbot-botnation' ); ?>
        </label>
        <?php
    }

    // REFERENCE field cb
    function bnai_cb_field_ref_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
               name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               class="regular-text"
               type="text"
               value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>" />
        <span class="description">
            <?php esc_html_e( 'You can set a reference to start the bot at a specific sequence or fill with "restart" to restart the welcome sequence.', 'chatbot-botnation' ); ?>
        </span>
        <?php
    }

    // LANGUAGE field cb
    function bnai_cb_field_language_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
       <select 
            id="<?php echo esc_attr( $args['label_for'] ); ?>" 
            name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="" <?php echo (!isset( $options[ $args['label_for'] ] ) || $options[ $args['label_for'] ] == "") ? "selected": "" ?>></option>
            <option value="fr" <?php echo (isset( $options[ $args['label_for'] ] ) && $options[ $args['label_for'] ] == "fr") ? "selected": "" ?>>Français</option>
            <option value="en" <?php echo (isset( $options[ $args['label_for'] ] ) && $options[ $args['label_for'] ] == "en") ? "selected": "" ?>>English</option>
        </select>

        <span class="description">
            <?php esc_html_e( 'Choose the Chatbot language', 'chatbot-botnation' ); ?>
        </span>
        <?php
    }

    // CONTAINER ID field cb
    function bnai_cb_field_container_id_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
               name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               class="regular-text"
               type="text"
               value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>" />
        <span class="description">
            <?php esc_html_e( 'Allow to show the chatbot module in existing html tag. Must be the id of a HTML element.', 'chatbot-botnation' ); ?>
        </span>
        <?php
    }

    // FULLSCREEN field cb
    function bnai_cb_field_fullscreen_cb( $args ) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option( 'bnai_cb_options' );
        // output the field
        ?>
        <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
            <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
                           name="bnai_cb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                           type="checkbox"
                           value="1"
                           <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, true )) : ( '' ); ?> />
           <?php esc_html_e( 'Set the fullscreen mod', 'chatbot-botnation' ); ?>
        </label>
        <?php
    }


    function bnai_cb_options_build_page_html_cb() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        // check if the user have submitted the settings

        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'bnai_cb_messages', 'bnai_cb_message', __( 'Settings Saved', 'chatbot-botnation' ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'bnai_cb_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "bnai_cb"
                settings_fields( 'bnai_cb' );
                // output setting sections and their fields
                // (sections are registered for "bnai_cb", each field is registered to a specific section)
                do_settings_sections( 'bnai_cb' );
                // output save settings button
                submit_button( __('Save Settings', 'chatbot-botnation') );
                ?>
            </form>
        </div>
        <?php
    }
?>
