<div id="dokan-seller-listing-wrap">
    <div class="seller-listing-content">
        <?php if ( $tenants['users'] ) : ?>
            <ul class="dokan-seller-wrap">
                <?php
                foreach ( $tenants['users'] as $tenant ) {
                    $tenant_info = woofreendor_get_tenant_info( $tenant->ID );
                    $banner_id  = isset( $tenant_info['banner'] ) ? $tenant_info['banner'] : 0;
                    $tenant_name = isset( $tenant_info['tenant_name'] ) ? esc_html( $tenant_info['tenant_name'] ) : __( 'N/A', 'woofreendor' );
                    $tenant_url  = woofreendor_get_tenant_url( $tenant->ID );
                    $store_address  = woofreendor_get_tenant_short_address( $tenant->ID );
                    $banner_url = ( $banner_id ) ? wp_get_attachment_image_src( $banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
                    ?>

                    <li class="dokan-single-seller woocommerce coloum-<?php echo $per_row; ?> <?php echo ( ! $banner_id ) ? 'no-banner-img' : ''; ?>">
                        <div class="store-wrapper">
                            <div class="store-content">
                                <div class="store-info" style="background-image: url( '<?php echo is_array( $banner_url ) ? $banner_url[0] : $banner_url; ?>');">
                                    <div class="store-data-container">

                                        <div class="store-data">
                                            <h2><a href="<?php echo $tenant_url; ?>"><?php echo $tenant_name; ?></a></h2>

                                            <?php if ( $store_address ): ?>
                                                <p class="store-address"><?php echo $store_address; ?></p>
                                            <?php endif ?>

                                            <?php if ( !empty( $tenant_info['phone'] ) ) { ?>
                                                <p class="store-phone">
                                                    <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html( $tenant_info['phone'] ); ?>
                                                </p>
                                            <?php } ?>

                                            <?php do_action( 'dokan_seller_listing_after_store_data', $tenant, $tenant_info ); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="store-footer">
                                <div class="seller-avatar">
                                    <?php echo get_avatar( $tenant->ID, 150 ); ?>
                                </div>
                                <a href="<?php echo $tenant_url; ?>" class="dokan-btn dokan-btn-theme"><?php _e( 'Visit', 'woofreendor' ); ?></a>

                                <?php do_action( 'dokan_seller_listing_footer_content', $tenant, $tenant_info ); ?>
                            </div>
                        </div>
                    </li>

                <?php } ?>
                <div class="dokan-clearfix"></div>
            </ul> <!-- .dokan-seller-wrap -->

            <?php
            $user_count   = $tenants['count'];
            $num_of_pages = ceil( $user_count / $limit );

            if ( $num_of_pages > 1 ) {
                echo '<div class="pagination-container clearfix">';

                $pagination_args = array(
                    'current'   => $paged,
                    'total'     => $num_of_pages,
                    'base'      => $pagination_base,
                    'type'      => 'array',
                    'prev_text' => __( '&larr; Previous', 'woofreendor' ),
                    'next_text' => __( 'Next &rarr;', 'woofreendor' ),
                );

                if ( ! empty( $search_query ) ) {
                    $pagination_args['add_args'] = array(
                        'woofreendor_tenant_search' => $search_query,
                    );
                }

                $page_links = paginate_links( $pagination_args );

                if ( $page_links ) {
                    $pagination_links  = '<div class="pagination-wrap">';
                    $pagination_links .= '<ul class="pagination"><li>';
                    $pagination_links .= join( "</li>\n\t<li>", $page_links );
                    $pagination_links .= "</li>\n</ul>\n";
                    $pagination_links .= '</div>';

                    echo $pagination_links;
                }

                echo '</div>';
            }
            ?>

        <?php else:  ?>
            <p class="dokan-error"><?php _e( 'No vendor found!', 'woofreendor' ); ?></p>
        <?php endif; ?>
    </div>
</div>