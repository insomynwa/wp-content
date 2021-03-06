<?php //global $post; ?>

<div class="dokan-dashboard-wrap">

    <?php

        /**
         *  dokan_dashboard_content_before hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
        ?>

        <div class="dokan-dashboard-content dokan-product-listing">

            <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            //do_action( 'dokan_dashboard_content_inside_before' );
            //do_action( 'dokan_before_listing_product' );
            ?>

            <article class="dokan-product-listing-area">

                <div class="product-listing-top dokan-clearfix">
                    <?php //dokan_product_listing_status_filter(); ?>

                    <span class="dokan-add-product-link">
                        <a data-outlet_action='create_new' id="woofreendor-add-new-outlet-btn" href="<?php echo woofreendor_get_navigation_url( 'new-outlet' ); ?>" class="dokan-btn dokan-btn-theme dokan-right <?php echo ( 'on' == dokan_get_option( 'disable_product_popup', 'dokan_selling', 'off' ) ) ? '' : 'woofreendor-add-new-outlet'; ?>">
                            <i class="fa fa-briefcase">&nbsp;</i>
                            <?php _e( 'Tambah Outlet', 'woofreendor' ); ?>
                        </a>
                    </span>
                </div>

                <?php //dokan_product_dashboard_errors(); ?>

                <div class="dokan-w12">
                    <?php// woofreendor_outlet_listing_filter(); ?>
                </div>

                <div class="dokan-dahsboard-product-listing-wrapper">
                    <table id="table_outlets" class="dokan-table dokan-table-striped product-listing-table">
                        <thead>
                            <tr>
                                <th><?php _e( 'Gambar', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Nama Outlet', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Username', 'woofreendor' ); ?></th>
                                <th><?php _e( 'E-mail', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Manage', 'woofreendor' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ( isset( $_GET['outlet_search_name']) && !empty( $_GET['outlet_search_name'] ) ) {
                                $args['s'] = $_GET['outlet_search_name'];
                            }
                            // $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

                            // $no = 10;
                            // //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            // if($pagenum==1) $offset=0;
                            // else $offset = ($pagenum-1)*$no;
                            //$binder_group = woofreendor_get_binder_group( get_current_user_id());
                            $paged       = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                            $limit       = 10;
                            $offset      = ( $paged - 1 ) * $limit;
                            $count       = 0;
                            $args = array(
                                'role' => 'seller', 
                                'number' => $limit, 
                                'offset' => $offset,
                                'order'          => 'ASC',
                                'orderby'        => 'display_name',
                                'meta_key'       => 'tenant_id',
                                'meta_value'     => get_current_user_id()
                                );
                            // var_dump(woofreendor_get_binder_group( get_current_user_id()));
                            $user_search = new WP_User_Query( $args );
                            $outlets     = (array) $user_search->get_results();


                            if ( $outlets ) {
                                foreach ($outlets as $outlet) {
                                    ?>
                                <tr>
                                    <td><a href="<?php echo dokan_get_store_url( $outlet->ID ); ?>"><?php echo get_avatar($outlet->ID); ?></a></td>
                                    <td><a href="<?php echo dokan_get_store_url( $outlet->ID ); ?>"><?php echo $outlet->display_name; ?></a>
                                        <input type="hidden" name="outlet_displayname_<?php echo $outlet->ID; ?>" value="<?php echo $outlet->display_name; ?>">
                                    </td>
                                    <td><?php echo $outlet->user_login; ?>
                                        <input type="hidden" name="outlet_username_<?php echo $outlet->ID; ?>" value="<?php echo $outlet->user_login; ?>">
                                    </td>
                                    <td><?php echo $outlet->user_email; ?>
                                        <input type="hidden" name="outlet_email_<?php echo $outlet->ID; ?>" value="<?php echo $outlet->user_email; ?>">
                                    </td>
                                    <td>
                                        <a href="#" data-outlet_action='update_outlet' class="dokan-btn dokan-btn-theme woofreendor_update_outlet" data-outlet_id="<?php echo $outlet->ID; ?>"><?php _e( 'Update', 'woofreendor' ) ?></a>
                                    </td>
                                    <td>
                                        <a href="#" class="dokan-btn dokan-btn-default dokan-btn-sm woofreendor_delete_outlet" data-outlet_id="<?php echo $outlet->ID; ?>"><?php _e( 'Hapus', 'woofreendor' ) ?></a>
                                    </td>
                                    <td class="diviader"></td>
                                </tr>

                                <?php $count++; } ?>

                                <?php } 
                                else { ?>
                                <tr>
                                    <td colspan="5"><?php _e( 'Outlet tidak diketemukan.', 'woofreendor' ); ?></td>
                                </tr>
                                <?php } ?>

                            </tbody>

                        </table>
                    </div>
                    <?php
                    

                    $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                    $base_url = woofreendor_get_navigation_url('outlets');

                    $user_count = $user_search->total_users;
                    $num_of_pages = ceil( $user_count / $limit );
                    // $total_outlet = $outlet_query->total_users;
                    if ( $num_of_pages > 1 ) {
                        echo '<div class="pagination-wrap">';
                        $page_links = paginate_links( array(
                            'current' => $paged,
                            'total' => $num_of_pages,
                            'base' => $base_url. '%_%',
                            'prev_text' => __( '&laquo; Previous', 'woofreendor' ),
                            'next_text' =>  __( 'Next &raquo;', 'woofreendor' ),
                            'add_args'  => false,
                            'type'      => 'array',
                            'format'    => '?pagenum=%#%',
                        ) );

                        echo '<ul class="pagination"><li>';
                        echo join("</li>\n\t<li>", $page_links);
                        echo "</li>\n</ul>\n";
                        echo '</div>';
                    }
                    ?>
                </article>

                <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_after' );
            do_action( 'woofreendor_after_listing_outlet' );
            ?>

        </div><!-- #primary .content-area -->

        <?php

        /**
         *  dokan_dashboard_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
        ?>

    </div><!-- .dokan-dashboard-wrap -->
