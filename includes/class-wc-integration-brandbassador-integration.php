<?php
/**
 * Integration Brandbassador Integration.
 *
 * @package  WC_Integration_Brandbassador_Integration
 * @category Brandbassador
 * @author   WooThemes
 */

if ( ! class_exists( 'WC_Integration_Brandbassador_Integration' ) ) :

    class WC_Integration_Brandbassador_Integration extends WC_Integration {


        /**
         * Init and hook in the integration.
         */
        public function __construct() {
            global $woocommerce;

            $this->id                 = 'integration-brandbassador';
            $this->method_title       = __( 'Brandbassador', 'woocommerce-integration-brandbassador' );
            $this->method_description = __( 'Integratino Brandbassador in WooCommerce.', 'woocommerce-integration-brandbassador' );

            // Load the settings.
            $this->init_form_fields();
            $this->init_settings();

            // Define user set variables.
            $this->api_key          = $this->get_option( 'api_key' );
            $this->api_key_back          = $this->get_option( 'api_key_back' );

            // Actions.
            add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );

            // Filters.
            add_filter( 'woocommerce_settings_api_sanitized_fields_' . $this->id, array( $this, 'sanitize_settings' ) );
        }
        /**
         * Initialize integration settings form fields.
         *
         * @return void
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'api_key' => array(
                    'title'             => __( 'API Key', 'woocommerce-integration-brandbassador' ),
                    'type'              => 'text',
                    'description'       => __( 'Enter with your API Key. You can find out in your personal cabinet https://www.brandbassador.com', 'woocommerce-integration-brandbassador' ),
                    'desc_tip'          => true,
                    'default'           => ''
                ),
                'api_key_back' => array(
                    'title'             => __( 'API Key Brandbassador', 'woocommerce-integration-brandbassador' ),
                    'type'              => 'text',
                    'description'       => __( 'API Key Brandbassador', 'woocommerce-integration-brandbassador' ),
                    'desc_tip'          => true,
                    'default'           => ''

                ),
            );
        }


        /**
         * Generate Button HTML.
         */
        public function generate_button_html( $key, $data ) {
            $field    = $this->plugin_id . $this->id . '_' . $key;
            $defaults = array(
                'class'             => 'button-secondary brandbassadorinit',
                'css'               => '',
                'custom_attributes' => array(),
                'desc_tip'          => false,
                'description'       => '',
                'title'             => '',
            );

            $data = wp_parse_args( $data, $defaults );

            ob_start();
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $field ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
                    <?php echo $this->get_tooltip_html( $data ); ?>
                </th>
                <td  class="forminp">
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo wp_kses_post( $data['title'] ); ?></span></legend>
                        <button class="<?php echo esc_attr( $data['class'] ); ?>" type="button" name="<?php echo esc_attr( $field ); ?>" id="<?php echo esc_attr( $field ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>" <?php echo $this->get_custom_attribute_html( $data ); ?>><?php echo wp_kses_post( $data['title'] ); ?></button>
                        <?php echo $this->get_description_html( $data ); ?>
                    </fieldset>
                </td>
            </tr>
            <?php
            return ob_get_clean();
        }
        /**
         * Santize our settings
         * @see process_admin_options()
         */
        public function sanitize_settings( $settings ) {
            // We're just going to make the api key all upper case characters since that's how our imaginary API works
            if ( isset( $settings ) && isset( $settings['api_key'] ) ) {
                //$settings['api_key'] = strtoupper( $settings['api_key'] );
                $api_key =  $settings['api_key'];
            }
            return $settings;

        }


        /**
         * Validate the API key
         * @see validate_settings_fields()
         */
        /*public function validate_api_key_field( $key ) {
            // get the posted value
            $value = $_POST[ $this->plugin_id . $this->id . '_' . $key ];

            // check if the API key is longer than 20 characters. Our imaginary API doesn't create keys that large so something must be wrong. Throw an error which will prevent the user from saving.
            if ( isset( $value ) && 20 < strlen( $value ) ) {
                $this->errors[] = $key;
            }
            return $value;
        }*/


        /**
         * Display errors by overriding the display_errors() method
         * @see display_errors()
         */
        public function display_errors( ) {

            // loop through each error and display it
            foreach ( $this->errors as $key => $value ) {
                ?>
                <div class="error">
                    <p><?php _e( 'Looks like you made a mistake with the ' . $value . ' field. Make sure it isn&apos;t longer than 20 characters', 'woocommerce-integration-brandbassador' ); ?></p>
                </div>
                <?php
            }
        }
        /**
         * Checking the filled fields
         * @see fields
         */
        // Api Key ********** [-_-] **********
        function fields_api_key_Checking() {
            $fields_api_key_Checking = '';
            if ($this->get_option( 'api_key' )) {
                $fields_api_key_Checking = $this->get_option( 'api_key' );
            }
            return $fields_api_key_Checking;
        }
        // Api Key Return AJAX ********** [-_-] **********
        function fields_api_key_back_Checking() {
            $fields_api_key_back_Checking = '';
            if ($this->get_option( 'api_key_back' )) {
                $fields_api_key_back_Checking = '&key='.$this->get_option( 'api_key_back' );
            }
            return $fields_api_key_back_Checking;
        }
    }

    /*****************************************************/



    function add_coupon_revenue_coupon_authorkey() {
        woocommerce_wp_text_input(array('id' => 'coupon_authorkey', 'readonly' => '', 'label' => __('Auth key', 'woocommerce'), 'placeholder' => __('None', 'woocommerce'), 'description' => __('Auth key', 'woocommerce')));
    }
    add_action( 'woocommerce_coupon_options', 'add_coupon_revenue_coupon_authorkey', 10, 0 );

    function save_coupon_revenue_coupon_authorkey( $post_id ) {
        $coupon_authorkey = $_POST['coupon_authorkey'];
        if ( isset($coupon_authorkey)) {
            update_post_meta( $post_id, 'coupon_authorkey', stripslashes( $coupon_authorkey ) );
        }
    }
    add_action( 'woocommerce_coupon_options_save', 'save_coupon_revenue_coupon_authorkey');

    /**
     * Url for brandbassador page
     * @see page
     */
    function plagi_WooCommerce_Brandbassador_version() {
        if($_SERVER["REQUEST_URI"] == '/brandbassador/discountCodeCreate') {
            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            $all_plugins = get_plugins();
            error_log( print_r($all_plugins, true ));
            echo '{"name":"'.$all_plugins['woocommerce-integration-brandbassador-master/woocommerce-integration-brandbassador.php']['Name'].'","version":"'.$all_plugins['woocommerce-integration-brandbassador-master/woocommerce-integration-brandbassador.php']['Version'].'"}';
            exit;
        }
    }
    add_action('init', 'plagi_WooCommerce_Brandbassador_version');

    /**
     * Url for brandbassador page checkaut
     * @see page
     */
    // Return number order (url GET) ********** [-_-] **********
    function order_number_url () {
        global $wp;
        return $wp->query_vars['order-received'];
    }
            /**
             * Extracting field data, writing in variables
             * @see fields
             */
            $WC_Integration_Brandbassador_Integration = new WC_Integration_Brandbassador_Integration;

            $fields_api_key_Checking = $WC_Integration_Brandbassador_Integration->{'fields_api_key_Checking'}(); // api_key
            $fields_api_key_back_Checking = $WC_Integration_Brandbassador_Integration->{'fields_api_key_back_Checking'}(); // api_key_back

            function isa_order_received_text()
            {
                $WC_Integration_Brandbassador_Integration = new WC_Integration_Brandbassador_Integration;

                /**
                 * Extracting data from the order basket
                 * @see fields
                 */


                // Return pixel Function ********** [-_-] **********
                function brandbassador_pixel_url()
                {
                    // Base url ********** [-_-] **********
                    function brandbassador_url()
                    {
                        $get_site_url = '';
                        if (get_site_url()) {
                            $get_site_url = get_site_url();
                        }
                        return $get_site_url;
                    }

                    // Brandbassador_url ********** [-_-] **********
                    function brandbassador_brandbassador_url()
                    {
                        $brandbassador_brandbassador_url = 'https://api.brandbassador.com';
                        return $brandbassador_brandbassador_url;
                    }

                    function fields_api_key_back_Checking()
                    {
                        $WC_Integration_Brandbassador_Integration = new WC_Integration_Brandbassador_Integration;
                        $fields_api_key_back_Checking = $WC_Integration_Brandbassador_Integration->{'fields_api_key_back_Checking'}(); // api_key_back
                        return $fields_api_key_back_Checking;
                    }

                    // Currency ********** [-_-] **********
                    function brandbassador_currency()
                    {
                        $brandbassador_currency = '';
                        if (get_woocommerce_currency()) {
                            $brandbassador_currency = '&currency=' . get_woocommerce_currency();
                        }
                        return $brandbassador_currency;
                    }

                    global $woocommerce, $post;

                    $order = new WC_Order(order_number_url());

                    // ORDER ID ********** [-_-] **********
                    if (order_number_url()) {
                        $order_id_pixel = 'order_id=' . order_number_url();
                    }

                    // Total ********** [-_-] **********
                    if ($order->get_total()) {
                        $order_totalbr_pixel = '&total=' . $order->get_total();
                    }

                    //Cupon Name ********** [-_-] **********
                    if ($order->get_used_coupons()) {
                        foreach ($order->get_used_coupons() as $coupon) {
                            $discountUsed_pixel = '&code=' . mb_strtoupper($coupon);
                        }

                    } else {
                        $discountUsed_pixel = '';
                    }

                    // Link referal ********** [-_-] **********
                    if(!isset($_COOKIE['ref'])) {
                        $tracking_link = '';
                    } else {
                        $tracking_link = 'tracking_link=true&ref='.$_COOKIE['ref'].'&';
                    }

                    // Return pixel ********** [-_-] **********

                    if (fields_api_key_back_Checking()){
                        if (!$discountUsed_pixel == '') {
                            echo '<img src="' . brandbassador_brandbassador_url() . '/tracking/pixel.gif?' . $tracking_link . '' . $order_id_pixel . '' . $order_totalbr_pixel . '' . fields_api_key_back_Checking() . '' . brandbassador_currency() . '' . $discountUsed_pixel . '" height="1" width="1">';
                        }
                    }
                }

                add_action('woocommerce_thankyou', 'brandbassador_pixel_url');
            }

            add_action('init', 'isa_order_received_text');


    add_action( 'admin_footer', 'my_header_scripts' );


    function my_header_scripts() {
        $get_site_url = '';
        if (get_site_url()) {
            $get_site_url = get_site_url();
        }
        $brandbassador_brandbassador_url = 'https://api.brandbassador.com';
        ?>
        <script type="text/javascript">
            jQuery( document ).ready(function() {
                if ( jQuery(".form-table input").is("#woocommerce_integration-brandbassador_api_key") ) {
                    var get_site_url = '<?php  echo $get_site_url ?>'+"/brandbassador/discountCodeCreate";
                    var brandbassador_brandbassador_url = '<?php  echo $brandbassador_brandbassador_url ?>';
                    var fields_api_key_Checking = jQuery("input#woocommerce_integration-brandbassador_api_key").val();

                    ajax_get_key (get_site_url, fields_api_key_Checking, brandbassador_brandbassador_url);
                }
                if ( jQuery("#coupon_options .coupon_authorkey_field input").is("#coupon_authorkey") ) {
                    jQuery("input#coupon_authorkey").prop("readonly",true);
                }

            });

            /**
             * Get the key with https://api.brandbassador.com
             * @see key
             */
            function ajax_get_key (api, authKey, brandbassador_brandbassador_url) {
                jQuery.ajax({
                    type: "GET",
                    url: 'https://api.brandbassador.com/admin/brands/registerWebshopPlugin?authKey='+authKey+'&api='+api+'',
                    success: function(data, textStatus, jqXHR)
                    {
                        if (jQuery("input#woocommerce_integration-brandbassador_api_key_back").val() == '') {
                            jQuery("input#woocommerce_integration-brandbassador_api_key").css('background','#00e64d');
                            jQuery("input#woocommerce_integration-brandbassador_api_key_back").val(data);
                            jQuery(".button-primary.woocommerce-save-button").click();

                        } else {
                            if (jQuery("input#woocommerce_integration-brandbassador_api_key_back").val() == data) {
                                jQuery("input#woocommerce_integration-brandbassador_api_key").css('background','#00e64d');
                            } else {
                                jQuery("input#woocommerce_integration-brandbassador_api_key").css('background','#00e64d');
                                jQuery("input#woocommerce_integration-brandbassador_api_key_back").val(data);
                                jQuery(".button-primary.woocommerce-save-button").click();
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        if (jQuery("input#woocommerce_integration-brandbassador_api_key_back").val() == '') {
                            jQuery("input#woocommerce_integration-brandbassador_api_key").css('background','#ff9999');
                        } else {
                            jQuery("input#woocommerce_integration-brandbassador_api_key").css('background','#ff9999');
                            jQuery("input#woocommerce_integration-brandbassador_api_key_back").val('');
                            jQuery(".button-primary.woocommerce-save-button").click();
                        }
                    }
                });
                jQuery("input#woocommerce_integration-brandbassador_api_key_back").prop("readonly",true);
            }
        </script>
        <?php
    }
    /*Create cookies*/

    add_action( 'init', 'my_setcookie_example' );
    function my_setcookie_example() {
        if( isset($_GET['ref']) )
        {
            if(!isset($_COOKIE['ref'])) {
                $visitor_username = 'ref';
                $username_value = $_GET['ref'];
                setcookie( $visitor_username, $username_value/*, time()+3600*/);
            } else {
              $referals_bb =   explode('||', $_COOKIE['ref']);
                $referals_bb_upd = false;
                foreach ($referals_bb as $value) {
                    if ($_GET['ref'] == $value) {
                        $referals_bb_upd = true;
                    }
                }
                if ($referals_bb_upd) {

                } else {
                    $value = $_COOKIE['ref'].'||'.$_GET['ref'];
                    setcookie('ref', $value);
                }
            }
        }

        /*delete coolie*/
        //unset( $_COOKIE['ref'] );
        //setcookie( 'ref', '', time() - ( 15 * 60 ) );
    }

   /*plagin_checkbox_all*/
    function plagin_checkbox_all()
    {
        $coupons = get_posts( array(
            'posts_per_page'   => -1,
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        ) );
        $plaginis = false;
        if (is_plugin_active('woocommerce-product-price-based-on-countries/woocommerce-product-price-based-on-countries.php')) {
            $plaginis = true;
        }
        if ($plaginis) {
            foreach ($coupons as $coupon) {
                if (!($coupon->coupon_authorkey == '')) {
                    if ($coupon->discount_type == 'fixed_cart') {
                        update_post_meta($coupon->ID, 'zone_pricing_type', 'exchange_rate');
                    }
                }
            }
        }
    }

    add_action( 'woocommerce_coupon_options_save', 'plagin_checkbox_all');

    /**
     * Cupon
     * @see page
     */
    add_action('parse_request', 'plagi_WooCommerce_Brandbassador_Cupon');

    function plagi_WooCommerce_Brandbassador_Cupon() {
        $url_page_cupon = explode("?", $_SERVER['REQUEST_URI']);
        if (is_array($url_page_cupon)) {
            if($url_page_cupon[0] == '/brandbassador/discountCodeCreate') {
                if (isset ($url_page_cupon[1])){
                    $url_page_cupon_params = explode("&", urldecode($url_page_cupon[1]));
                    foreach ($url_page_cupon_params as $value){
                        $cupon_params = explode("=", $value);
                        if (isset ($cupon_params[1])) {
                            $arrCuponParamsId[$cupon_params[0]] = $cupon_params[1];
                        } else {
                            status_header( 404 );
                            nocache_headers();
                            include( get_query_template( '404' ) );
                            die();
                            /* echo '{"status":"error","details":"Code already used"}';
                             exit;*/
                        }
                    }
                    $code = '';
                    $description = '';
                    $amount = '';
                    $percent = '';
                    $totime = '';
                    $days_active = '';
                    $auth = '';

                    if (isset($arrCuponParamsId['code'])){
                        $codeb = $arrCuponParamsId['code'];
                    } else {
                        $codeb = '';
                    }

                    if (isset($arrCuponParamsId['description'])){
                        $descriptionb = $arrCuponParamsId['description'];
                    } else {
                        $descriptionb = '';
                    }

                    if (isset($arrCuponParamsId['amount'])){
                        $amountb = $arrCuponParamsId['amount'];
                    } else {
                        $amountb = '';
                    }

                    if (isset($arrCuponParamsId['percent'])){
                        $percentb = $arrCuponParamsId['percent'];
                    } else {
                        $percentb = '';
                    }

                    if (isset($arrCuponParamsId['totime'])){
                        $totimeb = $arrCuponParamsId['totime'];
                    } else {
                        $totimeb = '';
                    }

                    if (isset($arrCuponParamsId['days_active'])){
                        $days_activeb = $arrCuponParamsId['days_active'];
                    } else {
                        $days_activeb = '';
                    }

                    if (isset($arrCuponParamsId['auth'])){
                        $authb = $arrCuponParamsId['auth'];
                    } else {
                        $authb = '';
                    }

                    if (isset($arrCuponParamsId['auth_key'])){
                        $auth_key = $arrCuponParamsId['auth_key'];
                    } else {
                        $auth_key = '';
                    }

                    if (isset($arrCuponParamsId['u_limit'])){
                        $u_limit = $arrCuponParamsId['u_limit'];
                    } else {
                        $u_limit = '';
                    }
                    if (isset($arrCuponParamsId['expire'])){
                        $expire = $arrCuponParamsId['expire'];
                    } else {
                        $expire = '';
                    }
                    if (isset($arrCuponParamsId['percentage'])){
                        $percentage = $arrCuponParamsId['percentage'];
                    } else {
                        $percentage = '';
                    }


                    function add_cupon_get ($codeb, $descriptionb, $amountb, $percentb, $totimeb, $days_activeb, $auth, $u_limit, $expire, $percentage, $auth_key){
                        if (!$totimeb == '') {
                            $totimeb = $totimeb;
                        }
                        if (!$expire == '') {
                            $totimeb = $expire;
                        }
                        //default date (this date)
                        if (($totimeb == '') and ($expire == '')) {
                            $totimeb = date("Y-m-d");
                        }

                        $days_activeb = $days_activeb;

                        if (!$auth == '') {
                            $authb = $auth;
                        }
                        if (!$auth_key == '') {
                            $authb = $auth_key;
                        }
                        //defaul code
                        if (($auth == '') and ($auth_key == '')) {
                            $authb = 'None code';
                        }

                        $coupon_code = $codeb; // Код
                        $discount_type ='';
                        if (!$amountb=='') {
                            $amountb = $amountb;
                            $discount_type = 'fixed_cart';
                        }
                        if (!$percentb=='') {
                            $amountb = $percentb;
                            $discount_type = 'percent';
                        }
                        if (!$percentage=='') {
                            $amountb = $percentage;
                            $discount_type = 'percent';
                        }
                        if ($discount_type==''){
                            echo '{"status":"error","details":"discount_type"}';
                            exit();
                        }
                        if ($amountb==''){
                            echo '{"status":"error","details":"amount"}';
                            exit();
                        }
                        if ($coupon_code==''){
                            echo '{"status":"error","details":"coupon_code"}';
                            exit();
                        }
                        if ($auth_key==''){
                            echo '{"status":"error","details":"auth_key"}';
                            exit();
                        }

                        $coupons = get_posts( array(
                            'posts_per_page'   => -1,
                            'post_type'        => 'shop_coupon',
                            'post_status'      => 'publish',
                        ) );

                        foreach ( $coupons as $coupon ){
                            if ($coupon->post_title == $coupon_code) {
                                echo '{"status":"error","details":"Code already used"}';
                                exit();
                            }
                        }

                        $plaginis = false;
                        if ( is_plugin_active( 'woocommerce-product-price-based-on-countries/woocommerce-product-price-based-on-countries.php' ) ) {
                            if ($discount_type == 'fixed_cart') {
                                $plaginis = true;
                            }
                        }

                        $coupon = array (
                            'post_title' => $coupon_code,
                            'post_excerpt' => $descriptionb,
                            'post_content' => '',
                            'post_status' => 'publish',
                            'post_author' => 1,
                            'post_type' => 'shop_coupon'
                        );

                        $new_coupon_id = wp_insert_post ($coupon);
                        // add meta
                        update_post_meta ($new_coupon_id, 'discount_type', $discount_type);
                        update_post_meta ($new_coupon_id, 'coupon_amount', $amountb);
                        update_post_meta ($new_coupon_id, 'individual_use', 'no');
                        update_post_meta ($new_coupon_id, 'product_ids', '');
                        update_post_meta ($new_coupon_id, 'exclude_product_ids', '');
                        update_post_meta ($new_coupon_id, 'usage_limit', $u_limit);
                        update_post_meta ($new_coupon_id, 'expiry_date', $totimeb);
                        update_post_meta ($new_coupon_id, 'apply_before_tax', 'yes');
                        update_post_meta ($new_coupon_id, 'free_shipping', 'no');
                        update_post_meta ($new_coupon_id, 'coupon_authorkey', $auth_key);
                        if ($plaginis){
                            update_post_meta ($new_coupon_id, 'zone_pricing_type', 'exchange_rate');
                        }
                    }
                    add_cupon_get ($codeb, $descriptionb, $amountb, $percentb, $totimeb, $days_activeb, $auth, $u_limit, $expire, $percentage, $auth_key);

                    echo  '{"status": "success"}';
                    exit();
                }
            }
        }
    }
endif;
