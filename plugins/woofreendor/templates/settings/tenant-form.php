<?php
/**
 * Dokan Dashboard Settings Store Form Template
 *
 * @since 2.4
 */
?>
<?php

    $gravatar       = isset( $tenant_profile['gravatar'] ) ? absint( $tenant_profile['gravatar'] ) : 0;
    $banner         = isset( $tenant_profile['banner'] ) ? absint( $tenant_profile['banner'] ) : 0;
    $tenantname      = isset( $tenant_profile['tenant_name'] ) ? esc_attr( $tenant_profile['tenant_name'] ) : '';
    $tenant_opp      = isset( $tenant_profile['tenant_opp'] ) ? esc_attr( $tenant_profile['tenant_opp'] ) : '';
    $phone          = isset( $tenant_profile['phone'] ) ? esc_attr( $tenant_profile['phone'] ) : '';
    $show_email     = isset( $tenant_profile['show_email'] ) ? esc_attr( $tenant_profile['show_email'] ) : 'no';
    $show_more_ptab = isset( $tenant_profile['show_more_ptab'] ) ? esc_attr( $tenant_profile['show_more_ptab'] ) : 'yes';

    $address         = isset( $tenant_profile['address'] ) ? $tenant_profile['address'] : '';
    $address_street1 = isset( $tenant_profile['address']['street_1'] ) ? $tenant_profile['address']['street_1'] : '';
    $address_street2 = isset( $tenant_profile['address']['street_2'] ) ? $tenant_profile['address']['street_2'] : '';
    $address_city    = isset( $tenant_profile['address']['city'] ) ? $tenant_profile['address']['city'] : '';
    $address_zip     = isset( $tenant_profile['address']['zip'] ) ? $tenant_profile['address']['zip'] : '';
    $address_country = isset( $tenant_profile['address']['country'] ) ? $tenant_profile['address']['country'] : '';
    $address_state   = isset( $tenant_profile['address']['state'] ) ? $tenant_profile['address']['state'] : '';

    $map_location   = isset( $tenant_profile['location'] ) ? esc_attr( $tenant_profile['location'] ) : '';
    $map_address    = isset( $tenant_profile['find_address'] ) ? esc_attr( $tenant_profile['find_address'] ) : '';

    if ( is_wp_error( $validate ) ) {
        $tenantname    = $_POST['woofreendor_tenant_name'];
        $map_location = $_POST['location'];
        $map_address  = $_POST['find_address'];

        $address_street1 = $_POST['dokan_address']['street_1'];
        $address_street2 = $_POST['dokan_address']['street_2'];
        $address_city    = $_POST['dokan_address']['city'];
        $address_zip     = $_POST['dokan_address']['zip'];
        $address_country = $_POST['dokan_address']['country'];
        $address_state   = $_POST['dokan_address']['state'];
    }

    $dokan_appearance = dokan_get_option( 'store_header_template', 'dokan_appearance', 'default' );

?>
<?php do_action( 'dokan_settings_before_form', $current_tenant, $tenant_profile ); ?>

    <form method="post" id="tenant-form"  action="" class="dokan-form-horizontal">

        <?php wp_nonce_field( 'woofreendor_tenant_settings_nonce' ); ?>

            <div class="dokan-banner">

                <div class="image-wrap<?php echo $banner ? '' : ' dokan-hide'; ?>">
                    <?php $banner_url = $banner ? wp_get_attachment_url( $banner ) : ''; ?>
                    <input type="hidden" class="dokan-file-field" value="<?php echo $banner; ?>" name="dokan_banner">
                    <img class="dokan-banner-img" src="<?php echo esc_url( $banner_url ); ?>">

                    <a class="close dokan-remove-banner-image">&times;</a>
                </div>

                <div class="button-area<?php echo $banner ? ' dokan-hide' : ''; ?>">
                    <i class="fa fa-cloud-upload"></i>

                    <a href="#" class="woofreendor-upload-banner dokan-btn dokan-btn-info dokan-theme"><?php _e( 'Upload banner', 'woofreendor' ); ?></a>
                    <p class="help-block">
                        <?php
                        /**
                         * Filter `dokan_banner_upload_help`
                         *
                         * @since 2.4.10
                         */
                        $general_settings = get_option( 'dokan_general', [] );
                        $banner_width = ! empty( $general_settings['store_banner_width'] ) ? $general_settings['store_banner_width'] : 625;
                        $banner_height = ! empty( $general_settings['store_banner_height'] ) ? $general_settings['store_banner_height'] : 300;

                        $help_text = sprintf(
                            __('Upload a banner for your store. Banner size is (%sx%s) pixels.', 'woofreendor' ),
                            $banner_width, $banner_height
                        );

                        echo apply_filters( 'dokan_banner_upload_help', $help_text );
                        ?>
                    </p>
                </div>
            </div> <!-- .dokan-banner -->

            <?php do_action( 'dokan_settings_after_banner', $current_tenant, $tenant_profile ); ?>

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="dokan_gravatar"><?php _e( 'Profile Picture', 'woofreendor' ); ?></label>

            <div class="dokan-w5 dokan-gravatar">
                <div class="dokan-left gravatar-wrap<?php echo $gravatar ? '' : ' dokan-hide'; ?>">
                    <?php $gravatar_url = $gravatar ? wp_get_attachment_url( $gravatar ) : ''; ?>
                    <input type="hidden" class="dokan-file-field" value="<?php echo $gravatar; ?>" name="dokan_gravatar">
                    <img class="dokan-gravatar-img" src="<?php echo esc_url( $gravatar_url ); ?>">
                    <a class="dokan-close dokan-remove-gravatar-image">&times;</a>
                </div>
                <div class="gravatar-button-area<?php echo $gravatar ? ' dokan-hide' : ''; ?>">
                    <a href="#" class="woofreendor-upload-photo dokan-btn dokan-btn-default"><i class="fa fa-cloud-upload"></i> <?php _e( 'Upload Photo', 'woofreendor' ); ?></a>
                </div>
            </div>
        </div>

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="woofreendor_tenant_name"><?php _e( 'Tenant Name', 'woofreendor' ); ?></label>

            <div class="dokan-w5 dokan-text-left">
                <input id="woofreendor_tenant_name" required value="<?php echo $tenantname; ?>" name="woofreendor_tenant_name" placeholder="<?php _e( 'tenant name', 'woofreendor'); ?>" class="dokan-form-control" type="text">
            </div>
        </div>

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="woofreendor_tenant_opp"><?php _e( 'Outlet Per Page', 'woofreendor' ); ?></label>

            <div class="dokan-w5 dokan-text-left">
                <input id="woofreendor_tenant_opp" value="<?php echo $tenant_opp; ?>" name="woofreendor_tenant_opp" placeholder="10" class="dokan-form-control" type="number">
            </div>
        </div>
         <!--address-->

        <?php
        $verified = false;

        if ( isset( $tenant_profile['dokan_verification']['info']['dokan_address']['v_status'] ) ) {
            if ( $tenant_profile['dokan_verification']['info']['dokan_address']['v_status'] == 'approved' ){
                $verified = true;
            }
        }

        woofreendor_tenant_address_fields( $verified );

        ?>
        <!--address-->

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="setting_phone"><?php _e( 'Phone No', 'woofreendor' ); ?></label>
            <div class="dokan-w5 dokan-text-left">
                <input id="setting_phone" value="<?php echo $phone; ?>" name="setting_phone" placeholder="<?php _e( '+123456..', 'woofreendor' ); ?>" class="dokan-form-control input-md" type="text">
            </div>
        </div>

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label"><?php _e( 'Email', 'woofreendor' ); ?></label>
            <div class="dokan-w5 dokan-text-left">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="setting_show_email" value="no">
                        <input type="checkbox" name="setting_show_email" value="yes"<?php checked( $show_email, 'yes' ); ?>> <?php _e( 'Show email address in store', 'woofreendor' ); ?>
                    </label>
                </div>
            </div>
        </div>

        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label"><?php _e( 'More product', 'woofreendor' ); ?></label>
            <div class="dokan-w5 dokan-text-left">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="setting_show_more_ptab" value="no">
                        <input type="checkbox" name="setting_show_more_ptab" value="yes"<?php checked( $show_more_ptab, 'yes' ); ?>> <?php _e( 'Enable tab on product single page view', 'woofreendor' ); ?>
                    </label>
                </div>
            </div>
        </div>


        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="setting_map"><?php _e( 'Map', 'woofreendor' ); ?></label>

            <div class="dokan-w6 dokan-text-left">
                <input id="dokan-map-lat" type="hidden" name="location" value="<?php echo $map_location; ?>" size="30" />

                <div class="dokan-map-wrap">
                    <div class="dokan-map-search-bar">
                        <input id="dokan-map-add" type="text" class="dokan-map-search" value="<?php echo $map_address; ?>" name="find_address" placeholder="<?php _e( 'Type an address to find', 'woofreendor' ); ?>" size="30" />
                        <a href="#" class="dokan-map-find-btn" id="dokan-location-find-btn" type="button"><?php _e( 'Find Address', 'woofreendor' ); ?></a>
                    </div>

                    <div class="dokan-google-map" id="dokan-map"></div>
                </div>
            </div> <!-- col.md-4 -->
        </div> <!-- .dokan-form-group -->


        <?php do_action( 'dokan_settings_form_bottom', $current_tenant, $tenant_profile ); ?>

        <div class="dokan-form-group">

            <div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
                <input type="submit" name="woofreendor_update_tenant_settings" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Settings', 'woofreendor' ); ?>">
            </div>
        </div>
    </form>

    <?php do_action( 'dokan_settings_after_form', $current_tenant, $tenant_profile ); ?>

<style>
    .dokan-settings-content .dokan-settings-area .dokan-banner {
        width: <?php echo $banner_width . 'px'; ?>;
        height: <?php echo $banner_height . 'px'; ?>;
    }

    .dokan-settings-content .dokan-settings-area .dokan-banner .dokan-remove-banner-image {
        height: <?php echo $banner_height . 'px'; ?>;
    }
</style>
<script type="text/javascript">

    (function($) {
        var dokan_address_wrapper = $( '.dokan-address-fields' );
        var dokan_address_select = {
            init: function () {

                dokan_address_wrapper.on( 'change', 'select.country_to_state', this.state_select );
            },
            state_select: function () {
                var states_json = wc_country_select_params.countries.replace( /&quot;/g, '"' ),
                    states = $.parseJSON( states_json ),
                    $statebox = $( '#dokan_address_state' ),
                    input_name = $statebox.attr( 'name' ),
                    input_id = $statebox.attr( 'id' ),
                    input_class = $statebox.attr( 'class' ),
                    value = $statebox.val(),
                    selected_state = '<?php echo $address_state; ?>',
                    input_selected_state = '<?php echo $address_state; ?>',
                    country = $( this ).val();

                if ( states[ country ] ) {

                    if ( $.isEmptyObject( states[ country ] ) ) {

                        $( 'div#dokan-states-box' ).slideUp( 2 );
                        if ( $statebox.is( 'select' ) ) {
                            $( 'select#dokan_address_state' ).replaceWith( '<input type="text" class="' + input_class + '" name="' + input_name + '" id="' + input_id + '" required />' );
                        }

                        $( '#dokan_address_state' ).val( 'N/A' );

                    } else {
                        input_selected_state = '';

                        var options = '',
                            state = states[ country ];

                        for ( var index in state ) {
                            if ( state.hasOwnProperty( index ) ) {
                                if ( selected_state ) {
                                    if ( selected_state == index ) {
                                        var selected_value = 'selected="selected"';
                                    } else {
                                        var selected_value = '';
                                    }
                                }
                                options = options + '<option value="' + index + '"' + selected_value + '>' + state[ index ] + '</option>';
                            }
                        }

                        if ( $statebox.is( 'select' ) ) {
                            $( 'select#dokan_address_state' ).html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
                        }
                        if ( $statebox.is( 'input' ) ) {
                            $( 'input#dokan_address_state' ).replaceWith( '<select type="text" class="' + input_class + '" name="' + input_name + '" id="' + input_id + '" required ></select>' );
                            $( 'select#dokan_address_state' ).html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
                        }
                        $( '#dokan_address_state' ).removeClass( 'dokan-hide' );
                        $( 'div#dokan-states-box' ).slideDown();

                    }
                } else {


                    if ( $statebox.is( 'select' ) ) {
                        input_selected_state = '';
                        $( 'select#dokan_address_state' ).replaceWith( '<input type="text" class="' + input_class + '" name="' + input_name + '" id="' + input_id + '" required="required"/>' );
                    }
                    $( '#dokan_address_state' ).val(input_selected_state);

                    if ( $( '#dokan_address_state' ).val() == 'N/A' ){
                        $( '#dokan_address_state' ).val('');
                    }
                    $( '#dokan_address_state' ).removeClass( 'dokan-hide' );
                    $( 'div#dokan-states-box' ).slideDown();
                }
            }
        }

        $(function() {
            dokan_address_select.init();

            $('#setting_phone').keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 91, 107, 109, 110, 187, 189, 190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
                    return;
                }

                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            <?php
            $locations = explode( ',', $map_location );
            $def_lat = isset( $locations[0] ) ? $locations[0] : 90.40714300000002;
            $def_long = isset( $locations[1] ) ? $locations[1] : 23.709921;
            ?>
            var def_zoomval = 12;
            var def_longval = '<?php echo $def_long; ?>';
            var def_latval = '<?php echo $def_lat; ?>';

            try {
                var curpoint = new google.maps.LatLng(def_latval, def_longval),
                    geocoder   = new window.google.maps.Geocoder(),
                    $map_area = $('#dokan-map'),
                    $input_area = $( '#dokan-map-lat' ),
                    $input_add = $( '#dokan-map-add' ),
                    $find_btn = $( '#dokan-location-find-btn' );

                $find_btn.on('click', function(e) {
                    e.preventDefault();

                    geocodeAddress( $input_add.val() );
                });

                var gmap = new google.maps.Map( $map_area[0], {
                    center: curpoint,
                    zoom: def_zoomval,
                    mapTypeId: window.google.maps.MapTypeId.ROADMAP
                });

                var marker = new window.google.maps.Marker({
                    position: curpoint,
                    map: gmap,
                    draggable: true
                });

                window.google.maps.event.addListener( gmap, 'click', function ( event ) {
                    marker.setPosition( event.latLng );
                    updatePositionInput( event.latLng );
                } );

                window.google.maps.event.addListener( marker, 'drag', function ( event ) {
                    updatePositionInput(event.latLng );
                } );

            } catch( e ) {
                console.log( 'Google API not found.' );
            }

            autoCompleteAddress();

            function updatePositionInput( latLng ) {
                $input_area.val( latLng.lat() + ',' + latLng.lng() );
            }

            function updatePositionMarker() {
                var coord = $input_area.val(),
                    pos, zoom;

                if ( coord ) {
                    pos = coord.split( ',' );
                    marker.setPosition( new window.google.maps.LatLng( pos[0], pos[1] ) );

                    zoom = pos.length > 2 ? parseInt( pos[2], 10 ) : 12;

                    gmap.setCenter( marker.position );
                    gmap.setZoom( zoom );
                }
            }

            function geocodeAddress( address ) {
                geocoder.geocode( {'address': address}, function ( results, status ) {
                    if ( status == window.google.maps.GeocoderStatus.OK ) {
                        updatePositionInput( results[0].geometry.location );
                        marker.setPosition( results[0].geometry.location );
                        gmap.setCenter( marker.position );
                        gmap.setZoom( 15 );
                    }
                } );
            }

            function autoCompleteAddress(){
                if (!$input_add) return null;

                $input_add.autocomplete({
                    source: function(request, response) {
                        // TODO: add 'region' option, to help bias geocoder.
                        geocoder.geocode( {'address': request.term }, function(results, status) {
                            response(jQuery.map(results, function(item) {
                                return {
                                    label     : item.formatted_address,
                                    value     : item.formatted_address,
                                    latitude  : item.geometry.location.lat(),
                                    longitude : item.geometry.location.lng()
                                };
                            }));
                        });
                    },
                    select: function(event, ui) {

                        $input_area.val(ui.item.latitude + ',' + ui.item.longitude );

                        var location = new window.google.maps.LatLng(ui.item.latitude, ui.item.longitude);

                        gmap.setCenter(location);
                        // Drop the Marker
                        setTimeout( function(){
                            marker.setValues({
                                position    : location,
                                animation   : window.google.maps.Animation.DROP
                            });
                        }, 1500);
                    }
                });
            }

        });
    })(jQuery);
</script>
