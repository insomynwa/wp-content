<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<button type="button" class="btn btn-warning" id="topBtn" title="Go to top">Top</button>
    <script>
    	jQuery(document).ready(function($){
    		$(window).scroll(function(){
    			scrollFunction();
    		});
    		$("#topBtn").click(function(e){
    			$(document.body).scrollTop(0);
    			$(document.documentElement).scrollTop(0);
    		});

    		function scrollFunction(){
				if($(document.body).scrollTop() > 60 || $(document.body).scrollTop() > 60) {
			  		$("#topBtn").css('display',"block");
				}
				else{
			  		$("#topBtn").css('display',"none");
				}
			}
    	});
    </script>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php _e(home_url());?>">Dibuang Sayang</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php if(!is_user_logged_in()): ?>
            <li><a href="#">Daftar</a></li>
            <li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>">Masuk</a></li>
            <?php else: ?>
            <?php $user_info = get_userdata(get_current_user_id()); ?>
            <li><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) );?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Keranjang <span class="badge">5</span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php _e($user_info->first_name); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Kotak Surat <span class="badge">5</span></a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profil</a></li>
                <li><a href="<?php current_user_can('manage_options') ? _e(admin_url()) : _e('#'); ?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
              </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <div class="container after-navbar bg-warning">
      <div class="row">
        <div class="col-xs-0 col-sm-0 col-md-3"></div>
        <form class="col-md-6" role="search" method="get" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) );//esc_url( home_url( '/' ) ); //echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
          <div class="input-group">
            <span class="input-group-btn">
              <select name="product_cat" class="form-control">
                <option value="">Semua Kategori</option>
              <?php
              //$parentid = get_queried_object_id();
              $args = array( 'hide_empty' => 0, 'parent' =>0);
              $terms = get_terms('product_cat', $args);//var_dump($parentid);
              if ( $terms ) {
                foreach ( $terms as $term ) {
                  echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
              }
              ?>
              </select>
            </span>
            <input type="text" class="form-control" aria-label="..." name="s">
            <input type="hidden" name="post_type" value="product" />
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
          </div> <!-- /input-group -->
        </form>
      </div>
    </div>
