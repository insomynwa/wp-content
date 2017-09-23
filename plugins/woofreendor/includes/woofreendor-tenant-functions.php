<?php

function woofreendor_get_tenants( $args = array() ) {

    $defaults = array(
            'role'       => 'woofreendor_tenant_role',
            'number'     => 9,
            'offset'     => 0,
            'orderby'    => 'registered',
            'order'      => 'ASC'
        );

    $args = wp_parse_args( $args, $defaults );

    $user_query = new WP_User_Query( $args );
    $sellers    = $user_query->get_results();
    // var_dump($args);
    return array( 'users' => $sellers, 'count' => $user_query->total_users );
}

function woofreendor_get_tenant_ids(){
    $outlet_args = array(
        'fields'    => 'ids',
        'role'      => 'woofreendor_tenant_role',
        'orderby'   => 'ID',
        'order'     => 'ASC'
        );

    return get_users($outlet_args);
}

function woofreendor_tenant_get_active_outlet( $paramTenantId ){
    $args = array(
            'role'       => 'seller',
            'orderby'    => 'registered',
            'order'      => 'ASC',
            'meta_query' => array(
                'relation'  => 'AND',
                    array(
                        'key'   => 'has_tenant',
                        'value' => true,
                        'compare'=> '='
                        ),
                    array(
                        'key'   => 'tenant_id',
                        'value' => $paramTenantId,
                        'compare'=> '='
                        )
                    )
                
                );

    $user_query = new WP_User_Query( $args );
    $sellers    = $user_query->get_results();

    return array( 'users' => $sellers, 'count' => $user_query->total_users );
}
