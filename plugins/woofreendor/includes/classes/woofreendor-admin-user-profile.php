<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Admin_User_Profile{

	public function __construct() {
        add_action( 'show_user_profile', array( $this, 'add_meta_fields' ), 20 );
        add_action( 'edit_user_profile', array( $this, 'add_meta_fields' ), 20 );

        add_action( 'personal_options_update', array( $this, 'save_meta_fields' ) );
        add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ) );

    }

    function add_meta_fields( $user ) {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }
        
        if ( ! user_can( $user, 'woofreendor_tenant' ) ) {
            return;
        }

        $tenant_settings    = woofreendor_get_tenant_info( $user->ID );
        $banner            = isset( $tenant_settings['banner'] ) ? absint( $tenant_settings['banner'] ) : 0;

        $social_fields     = dokan_get_social_profile_fields();

        $address           = isset( $tenant_settings['address'] ) ? $tenant_settings['address'] : '';
        $address_street1   = isset( $tenant_settings['address']['street_1'] ) ? $tenant_settings['address']['street_1'] : '';
        $address_street2   = isset( $tenant_settings['address']['street_2'] ) ? $tenant_settings['address']['street_2'] : '';
        $address_city      = isset( $tenant_settings['address']['city'] ) ? $tenant_settings['address']['city'] : '';
        $address_zip       = isset( $tenant_settings['address']['zip'] ) ? $tenant_settings['address']['zip'] : '';
        $address_country   = isset( $tenant_settings['address']['country'] ) ? $tenant_settings['address']['country'] : '';
        $address_state     = isset( $tenant_settings['address']['state'] ) ? $tenant_settings['address']['state'] : '';

        $country_state     = array(
            'country' => array(
                'label'       => __( 'Country', 'woofreendor' ),
                'description' => '',
                'class'       => 'js_field-country',
                'type'        => 'select',
                'options'     => array( '' => __( 'Select a country&hellip;', 'woofreendor' ) ) + WC()->countries->get_allowed_countries()
            ),
            'state' => array(
                'label'       => __( 'State/County', 'woofreendor' ),
                'description' => __( 'State/County or state code', 'woofreendor' ),
                'class'       => 'js_field-state'
            ),
        );
        ?>
        <h3><?php _e( 'Woofreendor Options', 'woofreendor' ); ?></h3>

        <table class="form-table">
            <tbody>
                <tr>
                    <th><?php _e( 'Banner', 'woofreendor' ); ?></th>
                    <td>
                        <div class="dokan-banner">
                            <div class="image-wrap<?php echo $banner ? '' : ' dokan-hide'; ?>">
                                <?php $banner_url = $banner ? wp_get_attachment_url( $banner ) : ''; ?>
                                <input type="hidden" class="dokan-file-field" value="<?php echo $banner; ?>" name="woofreendor_banner">
                                <img class="dokan-banner-img" src="<?php echo esc_url( $banner_url ); ?>">

                                <a class="close dokan-remove-banner-image">&times;</a>
                            </div>

                            <div class="button-area<?php echo $banner ? ' dokan-hide' : ''; ?>">
                                <a href="#" class="dokan-banner-drag button button-primary"><?php _e( 'Upload banner', 'woofreendor' ); ?></a>
                                <p class="description"><?php _e( '(Upload a banner for your tenant. Banner size is (825x300) pixels. )', 'woofreendor' ); ?></p>
                            </div>
                        </div> <!-- .dokan-banner -->
                    </td>
                </tr>

                <tr>
                    <th><?php _e( 'Tenant name', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_name" class="regular-text" value="<?php echo esc_attr( $tenant_settings['tenant_name'] ); ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php _e( 'Address 1', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_address[street_1]" class="regular-text" value="<?php echo esc_attr( $address_street1 ) ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php _e( 'Address 2', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_address[street_2]" class="regular-text" value="<?php echo esc_attr( $address_street2 ) ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php _e( 'Town/City', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_address[city]" class="regular-text" value="<?php echo esc_attr( $address_city ) ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php _e( 'Zip Code', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_address[zip]" class="regular-text" value="<?php echo esc_attr( $address_zip ) ?>">
                    </td>
                </tr>

                <?php foreach ( $country_state as $key => $field ) : ?>
                    <tr>
                        <th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
                        <td>
                            <?php if ( ! empty( $field['type'] ) && 'select' == $field['type'] ) : ?>
                                <select name="woofreendor_tenant_address[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : '' ); ?>" style="width: 25em;">
                                    <?php
                                        if ( $key == 'country') {
                                            $selected = esc_attr( $address_country );
                                        } else {
                                            $selected = esc_attr( $address_state );
                                        }
                                        foreach ( $field['options'] as $option_key => $option_value ) : ?>
                                        <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected, $option_key, true ); ?>><?php echo esc_attr( $option_value ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?php
                                if ( $key == 'country') {
                                    $value = esc_attr( $address_country );
                                } else {
                                    $value = esc_attr( $address_state );
                                }
                                ?>
                                <input type="text" name="woofreendor_tenant_address[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" value="<?php echo $value; ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : 'regular-text' ); ?>" />
                            <?php endif; ?>

                            <span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>


                <tr>
                    <th><?php _e( 'Phone Number', 'woofreendor' ); ?></th>
                    <td>
                        <input type="text" name="woofreendor_tenant_phone" class="regular-text" value="<?php echo esc_attr( $tenant_settings['phone'] ); ?>">
                    </td>
                </tr>

                <?php foreach ($social_fields as $key => $value) { ?>

                    <tr>
                        <th><?php echo $value['title']; ?></th>
                        <td>
                            <input type="text" name="woofreendor_social[<?php echo $key; ?>]" class="regular-text" value="<?php echo isset( $tenant_settings['social'][$key] ) ? esc_url( $tenant_settings['social'][$key] ) : ''; ?>">
                        </td>
                    </tr>

                <?php } ?>

                <tr>
                    <th><?php _e( 'Payment Options : ', 'woofreendor' ); ?></th>
                </tr>

                <?php if( isset( $tenant_settings['payment']['paypal']['email'] ) ) { ?>
                    <tr>
                        <th><?php _e( 'Paypal Email ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo esc_attr( $tenant_settings['payment']['paypal']['email'] ); ?>">
                        </td>
                    </tr>
                <?php } ?>
                <?php if( isset( $tenant_settings['payment']['skrill']['email'] ) ) { ?>
                    <tr>
                        <th><?php _e( 'Skrill Email ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo esc_attr( $tenant_settings['payment']['skrill']['email'] ); ?>">
                        </td>
                    </tr>
                <?php } ?>

                <?php if( isset( $tenant_settings['payment']['bank'] ) ) { ?>
                    <tr>
                        <th><?php _e( 'Bank name ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo isset( $tenant_settings['payment']['bank']['bank_name'] ) ? esc_attr( $tenant_settings['payment']['bank']['bank_name'] ) : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Account Name ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo isset( $tenant_settings['payment']['bank']['ac_name'] ) ? esc_attr( $tenant_settings['payment']['bank']['ac_name'] ) : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Account Number ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo isset( $tenant_settings['payment']['bank']['ac_number'] ) ? esc_attr( $tenant_settings['payment']['bank']['ac_number'] ) : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Bank Address ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo isset( $tenant_settings['payment']['bank']['bank_addr'] ) ? esc_attr( $tenant_settings['payment']['bank']['bank_addr'] ) : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Bank Swift ', 'woofreendor' ); ?></th>
                        <td>
                            <input type="text" disabled class="regular-text" value="<?php echo isset( $tenant_settings['payment']['bank']['swift'] ) ? esc_attr( $tenant_settings['payment']['bank']['swift'] ) : ''; ?>">
                        </td>
                    </tr>
                <?php } ?>

                <?php //do_action( 'dokan_seller_meta_fields', $user ); ?>

            </tbody>
        </table>

        <style type="text/css">
        .dokan-hide { display: none; }
        .button-area { padding-top: 100px; }
        .dokan-banner {
            border: 4px dashed #d8d8d8;
            height: 255px;
            margin: 0;
            overflow: hidden;
            position: relative;
            text-align: center;
            max-width: 700px;
        }
        .dokan-banner img { max-width:100%; }
        .dokan-banner .dokan-remove-banner-image {
            position:absolute;
            width:100%;
            height:270px;
            background:#000;
            top:0;
            left:0;
            opacity:.7;
            font-size:100px;
            color:#f00;
            padding-top:70px;
            display:none
        }
        .dokan-banner:hover .dokan-remove-banner-image {
            display:block;
            cursor: pointer;
        }
        </style>

        <script type="text/javascript">
        jQuery(function($){
            var Dokan_Settings = {

                init: function() {
                    $('a.dokan-banner-drag').on('click', this.imageUpload);
                    $('a.dokan-remove-banner-image').on('click', this.removeBanner);
                },

                imageUpload: function(e) {
                    e.preventDefault();

                    var file_frame,
                        self = $(this);

                    if ( file_frame ) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: jQuery( this ).data( 'uploader_title' ),
                        button: {
                            text: jQuery( this ).data( 'uploader_button_text' )
                        },
                        multiple: false
                    });

                    file_frame.on( 'select', function() {
                        var attachment = file_frame.state().get('selection').first().toJSON();

                        var wrap = self.closest('.dokan-banner');
                        wrap.find('input.dokan-file-field').val(attachment.id);
                        wrap.find('img.dokan-banner-img').attr('src', attachment.url);
                        $('.image-wrap', wrap).removeClass('dokan-hide');

                        $('.button-area').addClass('dokan-hide');
                    });

                    file_frame.open();

                },

                removeBanner: function(e) {
                    e.preventDefault();

                    var self = $(this);
                    var wrap = self.closest('.image-wrap');
                    var instruction = wrap.siblings('.button-area');

                    wrap.find('input.dokan-file-field').val('0');
                    wrap.addClass('dokan-hide');
                    instruction.removeClass('dokan-hide');
                },
            };

            Dokan_Settings.init();
        });
        </script>
        <?php
    }


    function save_meta_fields( $user_id ) {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        $tenant_settings = woofreendor_get_tenant_info( $user_id );

        $social         = $_POST['woofreendor_social'];
        $social_fields  = dokan_get_social_profile_fields();

        $tenant_settings['banner']     = intval( $_POST['woofreendor_banner'] );
        $tenant_settings['tenant_name'] = sanitize_text_field( $_POST['woofreendor_tenant_name'] );
        $tenant_settings['address']    = isset( $_POST['woofreendor_tenant_address'] ) ? $_POST['woofreendor_tenant_address'] : array();
        $tenant_settings['phone']      = sanitize_text_field( $_POST['woofreendor_tenant_phone'] );

        // social settings
        if ( is_array( $social ) ) {
            foreach ($social as $key => $value) {
                if ( isset( $social_fields[ $key ] ) ) {
                    $tenant_settings['social'][ $key ] = filter_var( $social[ $key ], FILTER_VALIDATE_URL );
                }
            }
        }

        update_user_meta( $user_id, 'woofreendor_profile_settings', $tenant_settings );
        update_user_meta( $user_id, 'woofreendor_tenant_name', $tenant_settings['tenant_name'] );

        //do_action( 'dokan_process_seller_meta_fields', $user_id );
    }
}