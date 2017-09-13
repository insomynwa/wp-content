<?php
$home_url = home_url();
$active_class = ' class="active"'
?>

<div class="dokan-dash-sidebar">
    <?php
    // var_dump("DASBOARD_NAV LOCAL".woofreendor_is_tenant_dashboard());
    //if ( woofreendor_is_tenant_dashboard() ) {
        echo woofreendor_dashboard_nav( $active_menu ); 
    // }else{
    // 	echo dokan_dashboard_nav( $active_menu ); 
    // }
    
    ?>
</div>