<?php
/**
 * Dokan Admin Dashboard Seller Log Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<div class="wrap">
    <h2><?php _e( 'Tenant Listing', 'woofreendor' ); ?></h2>

    <form action="<?php echo admin_url( 'users.php' ); ?>" method="get" style="margin-top: 15px;">

        <input type="hidden" name="s" value="">
        <?php wp_nonce_field( 'bulk-users' ); ?>

        <table class="widefat withdraw-table">
            <thead>
                <tr>
                    <td class="check-column">
                        <input type="checkbox" class="dokan-withdraw-allcheck">
                    </td>
                    <th><?php _e( 'Username', 'woofreendor' ); ?></th>
                    <th><?php _e( 'Name', 'woofreendor' ); ?></th>
                    <th><?php _e( 'Shop Name', 'woofreendor' ); ?></th>
                    <th><?php _e( 'E-mail', 'woofreendor' ); ?></th>
                    <th><?php _e( 'Outlets', 'woofreendor' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $paged       = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                $limit       = 20;
                $count       = 0;
                $offset      = ( $paged - 1 ) * $limit;
                $user_search = new WP_User_Query( array( 'role' => 'woofreendor_tenant_role', 'number' => $limit, 'offset' => $offset ) );
                $tenants     = (array) $user_search->get_results();

                if ( $tenants ) {

                    foreach ($tenants as $user) {
                        $info = woofreendor_get_tenant_info( $user->ID );
                        $url = woofreendor_get_tenant_url($user->ID);
                        $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_user_link( $user->ID ) ) );
                        $outlet_counts = woofreendor_count_outlet_by_tenant( $user->ID );
                        ?>
                        <tr class="<?php echo ($count % 2 == 0) ? 'alternate' : 'odd'; ?> ">
                            <th class="check-column">
                                <input type="checkbox" class="dokan-withdraw-allcheck" value="<?php echo $user->ID; ?>" name="users[]">
                            </th>
                            <td>
                                <strong><a href="<?php echo $edit_link ?>"><?php echo $user->user_login; ?></a></strong>
                            </td>
                            <td><?php echo $user->display_name; ?></td>
                            <td><?php echo empty( $info['tenant_name'] ) ? '--' : '<a href= "' . $url . '" target="_BLANK" >' . $info['tenant_name'] . '</a>'; ?></td>
                            <td><?php echo $user->user_email; ?></td>
                            <td><?php echo $outlet_counts['count']; ?></td>
                        </tr>
                        <?php
                        $count++;
                    }
                } else {
                    echo '<tr><td colspan="9">' . __( 'No tenant found!', 'woofreendor' ) .'</td></tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="check-column">
                        <input type="checkbox" class="dokan-withdraw-allcheck">
                    </td>
                    <th><?php _e( 'Username', 'woofreendor' ); ?></th>
                    <th><?php _e( 'Name', 'woofreendor' ); ?></th>
                    <th><?php _e( 'E-mail', 'woofreendor' ); ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="tablenav bottom">
            <div class="alignleft actions bulkactions">
                <select name="action2">
                    <option value="-1" selected="selected"><?php _e( 'Bulk Actions', 'woofreendor' ); ?></option>
                    <option value="delete"><?php _e( 'Delete', 'woofreendor' ); ?></option>
                </select>

                <input type="submit" name="" id="doaction2" class="button button-primary" value="<?php esc_attr_e( 'Apply', 'woofreendor' ); ?>">
            </div>

            <?php
            $user_count = $user_search->total_users;
            $num_of_pages = ceil( $user_count / $limit );

            if ( $num_of_pages > 1 ) {
                $page_links = paginate_links( array(
                    'current' => $paged,
                    'total' => $num_of_pages,
                    // 'base' => admin_url( 'admin.php?page=dokan-sellers&amp;page=%#%' ),
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    'prev_text' => __( '&larr; Previous', 'woofreendor' ),
                    'next_text' => __( 'Next &rarr;', 'woofreendor' ),
                    'add_args'  => false,
                ) );

                if ( $page_links ) {
                    echo '<div class="tablenav-pages" style="margin: 1em 0"><span class="pagination-links">' . $page_links . '</span></div>';
                }
            }
            ?>
        </div>
    </form>

    <style type="text/css">
        
    </style>

    <script type="text/javascript">
    </script>


</div>