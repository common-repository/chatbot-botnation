<?php
/*
 * Inject the chatbot widget in the end of <head> tag.
 */
    add_action( 'wp_head', 'bnai_cb_inject_Chat' );

    function bnai_cb_inject_Chat() {
        if ( null == get_option('bnai_cb_options') ) return;
        if ( null == get_option('bnai_cb_options')['bnai_cb_field_website_id'] || "" == get_option('bnai_cb_options')['bnai_cb_field_website_id'] ) return;

        // then get the post data
        $values = array();
        $current_user = null;
        if( is_page() ) {
            $post = get_post();

            $values = get_post_custom( $post->ID );
            $current_user = wp_get_current_user();


        }

        // Auto start
        $auto_start = (isset(get_option("bnai_cb_options")["bnai_cb_field_auto_start"]) && (get_option("bnai_cb_options")["bnai_cb_field_auto_start"] == "1" || get_option("bnai_cb_options")["bnai_cb_field_auto_start"] == 1)) ? "true" : "false";
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_AUTO_START]) && $values[BNAI_CB_POST_CUSTOM_FIELD_AUTO_START][0] == "1") $auto_start = "true";

        // Launch at end
        $launch_at_end = (isset(get_option("bnai_cb_options")["bnai_cb_field_launch_at_end"]) && (get_option("bnai_cb_options")["bnai_cb_field_launch_at_end"] == "1" || get_option("bnai_cb_options")["bnai_cb_field_launch_at_end"] == 1)) ? true : false;

        // Ref
        $ref = isset(get_option("bnai_cb_options")["bnai_cb_field_ref"]) ? get_option("bnai_cb_options")["bnai_cb_field_ref"] : null;
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_REF]) && $values[BNAI_CB_POST_CUSTOM_FIELD_REF][0] != "") $ref = $values[BNAI_CB_POST_CUSTOM_FIELD_REF][0];

        // WebsiteId
        $websiteId = isset(get_option("bnai_cb_options")["bnai_cb_field_website_id"]) ? get_option("bnai_cb_options")["bnai_cb_field_website_id"] : null;
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID]) && $values[BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID][0] != "") $websiteId = $values[BNAI_CB_POST_CUSTOM_FIELD_WEBSITE_ID][0];


        // Language
        $language = isset(get_option("bnai_cb_options")["bnai_cb_field_language"]) ? get_option("bnai_cb_options")["bnai_cb_field_language"] : null;
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE]) && $values[BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE][0] != "") $language = $values[BNAI_CB_POST_CUSTOM_FIELD_LANGUAGE][0];

        // Container id
        $containerId = isset(get_option("bnai_cb_options")["bnai_cb_field_container_id"]) ? get_option("bnai_cb_options")["bnai_cb_field_container_id"] : null;
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID]) && $values[BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID][0] != "") $containerId = $values[BNAI_CB_POST_CUSTOM_FIELD_CONTAINER_ID][0];

        // Fullscreen
        $fullscreen = (isset(get_option("bnai_cb_options")["bnai_cb_field_fullscreen"]) && (get_option("bnai_cb_options")["bnai_cb_field_fullscreen"] == "1" || get_option("bnai_cb_options")["bnai_cb_field_fullscreen"] == 1)) ? "true" : "false";
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_FULLSCREEN]) && $values[BNAI_CB_POST_CUSTOM_FIELD_FULLSCREEN][0] == "1") $fullscreen = "true";

        //External Variables
        $externalVarNames = "";
        $externalVarValues = "";
        if ( isset($values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME]) && $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME][0] != "" &&
         isset($values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE]) && $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE][0] != ""){

            $externalVarNames = $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_NAME][0];
            $externalVarValues = $values[BNAI_CB_POST_CUSTOM_FIELD_EXTERNAL_VARS_VALUE][0];
        }


        ?>
        <script type="text/javascript">
            <?php echo ($launch_at_end?"window.onload = function() {":""); ?>
                if (window.location.href.indexOf("/wp-admin/") === -1) {
                    window.chatboxSettings = {
                        preventMessengerPreload: true,
                        appKey: '<?php echo BNAI_CB_APP_KEY; ?>'
                        <?php echo (null == $websiteId || "" == $websiteId ? "" : ", websiteId: '" . $websiteId . "'"); ?>
                        , autoStart: <?php echo $auto_start; ?>
                        , fullscreen: <?php echo $fullscreen; ?>
                        <?php echo (null == $ref || "" == $ref ? "" : ", ref: '" . $ref . "'"); ?>
                        <?php echo (null == $language || "" == $language ? "" : ", language: '" . $language . "'"); ?>
                        <?php echo (null == $containerId || "" == $containerId ? "" : ", containerId: '" . $containerId . "'"); ?>
                        <?php echo (null == $current_user || 0 == $current_user->ID ? "" : ", userId: '" . $current_user->ID . "'"); ?>
                        <?php echo (null == $current_user || 0 == $current_user->ID || "" == $current_user->first_name ? "" : ", firstName: '" . $current_user->first_name . "'"); ?>
                        <?php echo (null == $current_user || 0 == $current_user->ID || "" == $current_user->last_name ? "" : ", lastName: '" . $current_user->last_name . "'"); ?>
                        <?php
                            if(null != $externalVarNames && "" != $externalVarNames && null != $externalVarValues && "" != $externalVarValues){
                                $names = explode(";", $externalVarNames);
                                $values = explode(";", $externalVarValues);

                                echo ", externalDatas: {";
                                $externalVars = array();
                                foreach($names as $index => $name){
                                    if($name != "")
                                        $externalVars[] = $name.": '".$values[$index]."'";
                                }
                                echo join(", ", $externalVars);
                                echo "}";
                             }
                             ?>
                    };
                    (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement(s);
                        js.id = id;
                        js.src = '<?php echo BNAI_CB_WIDGET_JS_PATH; ?>';
                        js.async = true;
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'chatbox-jssdk'));
                }
            <?php echo ($launch_at_end?"}":""); ?>
        </script>
        <?php
    }
?>
