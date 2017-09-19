<?php global $post; ?>

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
            do_action( 'dokan_dashboard_content_inside_before' );
            do_action( 'dokan_before_listing_product' );
            ?>

            <article class="dokan-product-listing-area">

                <div class="product-listing-top dokan-clearfix">
                    <?php if( ! woofreendor_is_user_tenant( get_current_user_id() ) ): ?>
                    <?php dokan_product_listing_status_filter(); ?>
                    <?php endif; ?>
                    <?php if ( woofreendor_is_user_tenant( get_current_user_id()) ): ?>
                        <span class="dokan-add-product-link">
                            <a href="<?php echo dokan_get_navigation_url( 'new-product' ); ?>" class="dokan-btn dokan-btn-theme dokan-right <?php echo ( 'on' == dokan_get_option( 'disable_product_popup', 'dokan_selling', 'off' ) ) ? '' : 'dokan-add-new-product'; ?>">
                                <i class="fa fa-briefcase">&nbsp;</i>
                                <?php _e( 'Tambah Produk', 'woofreendor' ); ?>
                            </a>
                        </span>
                    <?php else: ?>
                    <?php //if ( dokan_is_seller_enabled( get_current_user_id() )): ?>
                        <span class="dokan-add-product-link">
                            <a href="<?php echo dokan_get_navigation_url( 'new-product' ); ?>" class="dokan-btn dokan-btn-theme dokan-right dokan-add-new-product">
                                <i class="fa fa-briefcase">&nbsp;</i>
                                <?php _e( 'Tambah Produk', 'woofreendor' ); ?>
                            </a>
                        </span>
                    <?php endif; ?>
                </div>

                <?php dokan_product_dashboard_errors(); ?>

                <div class="dokan-w12">
                    <?php woofreendor_product_listing_filter(); ?>
                </div>

                <div class="dokan-dahsboard-product-listing-wrapper">
                    <table class="dokan-table dokan-table-striped product-listing-table">
                        <thead>
                            <tr>
                                <th><?php _e( 'Gambar', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Nama Produk', 'woofreendor' ); ?></th>
                                <?php if( ! woofreendor_is_user_tenant( get_current_user_id() ) ): ?>
                                <th><?php _e( 'Status', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Stok', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Harga', 'woofreendor' ); ?></th>
                                <th><?php _e( 'Dilihat', 'woofreendor' ); ?></th>
                                <?php else: ?>
                                <th><?php _e( 'Kategori', 'woofreendor' ); ?></th>
                                <?php endif; ?>
                                <th><?php _e( 'Tanggal', 'woofreendor' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

                            $post_statuses = array('publish', 'draft', 'pending');
                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => $post_statuses,
                                'posts_per_page' => 10,
                                'author'         => get_current_user_id(),
                                'orderby'        => 'post_date',
                                'order'          => 'DESC',
                                'paged'          => $pagenum,
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'product_type',
                                        'field'    => 'slug',
                                        'terms'    => apply_filters( 'dokan_product_listing_exclude_type', array() ),
                                        'operator' => 'NOT IN',
                                        ),
                                    ),
                                );

                            if ( isset( $_GET['post_status']) && in_array( $_GET['post_status'], $post_statuses ) ) {
                                $args['post_status'] = $_GET['post_status'];
                            }

                            if( isset( $_GET['date'] ) && $_GET['date'] != 0 ) {
                                $args['m'] = $_GET['date'];
                            }

                            if( isset( $_GET['product_cat'] ) && $_GET['product_cat'] != -1 ) {
                                $args['tax_query'][] = array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'id',
                                    'terms' => (int)  $_GET['product_cat'],
                                    'include_children' => false,
                                    );
                            }

                            if ( isset( $_GET['product_search_name']) && !empty( $_GET['product_search_name'] ) ) {
                                $args['s'] = $_GET['product_search_name'];
                            }


                            $original_post = $post;
                            $product_query = new WP_Query( apply_filters( 'dokan_product_listing_query', $args ) );

                            if ( $product_query->have_posts() ) {
                                while ($product_query->have_posts()) {
                                    $product_query->the_post();
                                    $tr_class = '';
                                    if( ! woofreendor_is_user_tenant( get_current_user_id() ) ){
                                    $tr_class = ($post->post_status == 'pending' ) ? ' class="danger"' : '';
                                    }
                                    $view_class = ($post->post_status == 'pending' ) ? 'dokan-hide' : '';
                                    $product = wc_get_product( $post->ID );
                                    if(! woofreendor_is_user_tenant( get_current_user_id() )){
                                        $product_parent = get_post_meta( $post->ID, 'product_parent', true);
                                        $parent_product = wc_get_product( $product_parent );
                                    }
                                    
                                    ?>
                                    <tr<?php echo $tr_class; ?>>
                                    <td data-title="<?php _e( 'Gambar', 'woofreendor' ); ?>">
                                        <?php if(woofreendor_is_user_tenant( get_current_user_id() )): ?>
                                        <a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php echo $product->get_image(); ?></a>
                                        <?php else: ?>
                                        <a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php echo $parent_product->get_image(); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td data-title="<?php _e( 'Nama', 'woofreendor' ); ?>">
                                        <p><a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php echo $product->get_title(); ?></a></p>

                                        <div class="row-actions">
                                            <span class="edit"><a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php _e( 'Ubah', 'woofreendor' ); ?></a> | </span>
                                            <span class="delete"><a onclick="return confirm('Are you sure?');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-delete-product', 'product_id' => $post->ID ), dokan_get_navigation_url('products') ), 'dokan-delete-product' ); ?>"><?php _e( 'Hapus Permanen', 'woofreendor' ); ?></a>  </span>
                                            <span class="view <?php echo $view_class ?>"> | <a href="<?php echo get_permalink( dokan_get_prop( $product, 'id' ) ); ?>" rel="permalink"><?php _e( 'Lihat', 'woofreendor' ); ?></a></span>
                                            <?php do_action( 'dokan_product_listin_row_action', $product ); ?>
                                        </div>
                                    </td>
                                    <?php if( ! woofreendor_is_user_tenant( get_current_user_id() ) ): ?>
                                    <td class="post-status" data-title="<?php _e( 'Status', 'woofreendor' ); ?>">
                                        <label class="dokan-label <?php echo dokan_get_post_status_label_class( $post->post_status ); ?>"><?php echo dokan_get_post_status( $post->post_status ); ?></label>
                                    </td>
                                    <td data-title="<?php _e( 'Stok', 'woofreendor' ); ?>">
                                        <?php
                                        if ( $product->is_in_stock() ) {
                                            echo '<mark class="instock">' . __( 'In stock', 'woofreendor' ) . '</mark>';
                                        } else {
                                            echo '<mark class="outofstock">' . __( 'Out of stock', 'woofreendor' ) . '</mark>';
                                        }

                                        if ( $product->managing_stock() ) :
                                            echo ' &times; ' . $product->get_stock_quantity();
                                        endif;
                                        ?>
                                    </td>
                                    <td data-title="<?php _e( 'Harga', 'woofreendor' ); ?>">
                                        <?php
                                        if ( $product->get_price_html() ) {
                                            echo $product->get_price_html();
                                        } else {
                                            echo '<span class="na">&ndash;</span>';
                                        }
                                        ?>
                                    </td>
                                    <td data-title="<?php _e( 'Dilihat', 'woofreendor' ); ?>">
                                        <?php echo (int) get_post_meta( $post->ID, 'pageview', true ); ?>
                                    </td>
                                    <?php else: ?>
                                    <td data-title="<?php _e( 'Kategori', 'woofreendor' ); ?>">
                                        <?php $product_cat = wp_get_post_terms( $post->ID, 'product_cat', array()); ?>
                                        <?php echo $product_cat[0]->name; ?>
                                    </td>
                                    <?php endif; ?>
                                    <td class="post-date" data-title="<?php _e( 'Date', 'woofreendor' ); ?>">
                                        <?php
                                        if ( '0000-00-00 00:00:00' == $post->post_date ) {
                                            $t_time = $h_time = __( 'Unpublished', 'woofreendor' );
                                            $time_diff = 0;
                                        } else {
                                            $t_time = get_the_time( __( 'Y/m/d g:i:s A', 'woofreendor' ) );
                                            $m_time = $post->post_date;
                                            $time = get_post_time( 'G', true, $post );

                                            $time_diff = time() - $time;

                                            if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
                                                $h_time = sprintf( __( '%s ago', 'woofreendor' ), human_time_diff( $time ) );
                                            } else {
                                                $h_time = mysql2date( __( 'Y/m/d', 'woofreendor' ), $m_time );
                                            }
                                        }

                                        echo '<abbr title="' . dokan_date_time_format( $t_time ) . '">' . apply_filters( 'post_date_column_time', dokan_date_time_format( $h_time, true ), $post, 'date', 'all' ) . '</abbr>';
                                        echo '<div class="status">';
                                            if ( 'publish' == $post->post_status ) {
                                                _e( 'Published', 'woofreendor' );
                                            } elseif ( 'future' == $post->post_status ) {
                                                if ( $time_diff > 0 ) {
                                                    echo '<strong class="attention">' . __( 'Missed schedule', 'woofreendor' ) . '</strong>';
                                                } else {
                                                    _e( 'Scheduled', 'woofreendor' );
                                                }
                                            } else {
                                                _e( 'Last Modified', 'woofreendor' );
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td class="diviader"></td>
                                </tr>

                                <?php } ?>

                                <?php } else { ?>
                                <tr>
                                    <td colspan="7"><?php _e( 'Produk tidak diketemukan.', 'woofreendor' ); ?></td>
                                </tr>
                                <?php } ?>

                            </tbody>

                        </table>
                    </div>
                    <?php
                    wp_reset_postdata();

                    $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                    $base_url = dokan_get_navigation_url('products');

                    if ( $product_query->max_num_pages > 1 ) {
                        echo '<div class="pagination-wrap">';
                        $page_links = paginate_links( array(
                            'current'   => $pagenum,
                            'total'     => $product_query->max_num_pages,
                            'base'      => $base_url. '%_%',
                            'format'    => '?pagenum=%#%',
                            'add_args'  => false,
                            'type'      => 'array',
                            'prev_text' => __( '&laquo; Previous', 'woofreendor' ),
                            'next_text' => __( 'Next &raquo;', 'woofreendor' )
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
            do_action( 'dokan_after_listing_product' );
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
