<?php
$home_url = home_url();
$active_class = ' class="active"'
?>

<div class="dokan-dash-sidebar">
    <?php
    if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {
        echo woofreendor_dashboard_nav( $active_menu ); 
    }else{
    	echo dokan_dashboard_nav( $active_menu ); 
    }
    
    ?>
</div>