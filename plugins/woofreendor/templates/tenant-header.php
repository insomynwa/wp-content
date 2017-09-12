<?php
$tenant_user    = get_userdata( get_query_var( 'author' ) );
$tenant_info    = woofreendor_get_tenant_info( $tenant_user->ID );
$store_tabs    = woofreendor_get_tenant_tabs( $tenant_user->ID );
$social_fields = dokan_get_social_profile_fields();

$dokan_appearance = get_option( 'dokan_appearance' );
$profile_layout = empty( $dokan_appearance['store_header_template'] ) ? 'default' : $dokan_appearance['store_header_template'];
$tenant_address = woofreendor_get_tenant_short_address( $tenant_user->ID, false );

$general_settings = get_option( 'woofreendor_general', [] );
$banner_width = ! empty( $general_settings['store_banner_width'] ) ? $general_settings['store_banner_width'] : 625;

if ( ( 'default' === $profile_layout ) || ( 'layout2' === $profile_layout ) ) {
    $profile_img_class = 'profile-img-circle';
} else {
    $profile_img_class = 'profile-img-square';
}

if ( 'layout3' === $profile_layout ) {
    unset( $tenant_info['banner'] );

    $no_banner_class = ' profile-frame-no-banner';
    $no_banner_class_tabs = ' dokan-store-tabs-no-banner';

} else {
    $no_banner_class = '';
    $no_banner_class_tabs = '';
}
?>
<div class="profile-frame<?php echo $no_banner_class; ?>">

    <div class="profile-info-box profile-layout-<?php echo $profile_layout; ?>">
        <?php if ( isset( $tenant_info['banner'] ) && !empty( $tenant_info['banner'] ) ) { ?>
            <img src="<?php echo wp_get_attachment_url( $tenant_info['banner'] ); ?>"
                 alt="<?php echo isset( $tenant_info['tenant_name'] ) ? esc_html( $tenant_info['tenant_name'] ) : ''; ?>"
                 title="<?php echo isset( $tenant_info['tenant_name'] ) ? esc_html( $tenant_info['tenant_name'] ) : ''; ?>"
                 class="profile-info-img">
        <?php } else { ?>
            <div class="profile-info-img dummy-image">&nbsp;</div>
        <?php } ?>

        <div class="profile-info-summery-wrapper dokan-clearfix">
            <div class="profile-info-summery">
                <div class="profile-info-head">
                    <div class="profile-img <?php echo $profile_img_class; ?>">
                        <?php echo get_avatar( $tenant_user->ID, 150 ); ?>
                    </div>
                    <?php if ( isset( $tenant_info['tenant_name'] ) && 'default' === $profile_layout ) { ?>
                        <h1 class="store-name"><?php echo esc_html( $tenant_info['tenant_name'] ); ?></h1>
                    <?php } ?>
                </div>

                <div class="profile-info">
                    <?php if ( isset( $tenant_info['tenant_name'] ) && 'default' !== $profile_layout ) { ?>
                        <h1 class="store-name"><?php echo esc_html( $tenant_info['tenant_name'] ); ?></h1>
                    <?php } ?>

                    <ul class="dokan-store-info">
                        <?php if ( isset( $tenant_address ) && !empty( $tenant_address ) ) { ?>
                            <li class="dokan-store-address"><i class="fa fa-map-marker"></i>
                                <?php echo $tenant_address; ?>
                            </li>
                        <?php } ?>

                        <?php if ( isset( $tenant_info['phone'] ) && !empty( $tenant_info['phone'] ) ) { ?>
                            <li class="dokan-store-phone">
                                <i class="fa fa-mobile"></i>
                                <a href="tel:<?php echo esc_html( $tenant_info['phone'] ); ?>"><?php echo esc_html( $tenant_info['phone'] ); ?></a>
                            </li>
                        <?php } ?>

                        <?php if ( isset( $tenant_info['show_email'] ) && $tenant_info['show_email'] == 'yes' ) { ?>
                            <li class="dokan-store-email">
                                <i class="fa fa-envelope-o"></i>
                                <a href="mailto:<?php echo antispambot( $tenant_user->user_email ); ?>"><?php echo antispambot( $tenant_user->user_email ); ?></a>
                            </li>
                        <?php } ?>
                    </ul>

                    <?php if ( $social_fields ) { ?>
                        <div class="store-social-wrapper">
                            <ul class="store-social">
                                <?php foreach( $social_fields as $key => $field ) { ?>
                                    <?php if ( isset( $tenant_info['social'][ $key ] ) && !empty( $tenant_info['social'][ $key ] ) ) { ?>
                                        <li>
                                            <a href="<?php echo esc_url( $tenant_info['social'][ $key ] ); ?>" target="_blank"><i class="fa fa-<?php echo $field['icon']; ?>"></i></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>

                </div> <!-- .profile-info -->
            </div><!-- .profile-info-summery -->
        </div><!-- .profile-info-summery-wrapper -->
    </div> <!-- .profile-info-box -->
</div> <!-- .profile-frame -->

<?php if ( $store_tabs ) { ?>
    <div class="dokan-store-tabs<?php echo $no_banner_class_tabs; ?>">
        <ul class="dokan-list-inline">
            <?php foreach( $store_tabs as $key => $tab ) { ?>
                <li><a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo $tab['title']; ?></a></li>
            <?php } ?>
            <?php do_action( 'dokan_after_store_tabs', $tenant_user->ID ); ?>
        </ul>
    </div>
<?php } ?>