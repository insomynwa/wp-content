<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */
function dbsnettheme_enqueue_styles(){
	wp_register_style('bootstrap', '/wp-content/themes/' . get_stylesheet() . '/assets/bootstrap/css/bootstrap.min.css');
	$dependencies = array('bootstrap');
	wp_enqueue_style('dbsnettheme-style', get_stylesheet_uri(), $dependencies );
}

function dbsnettheme_enqueue_scripts(){
	$dependencies = array( 'jquery' );
	wp_enqueue_script('boot', '/wp-content/themes/' . get_stylesheet() . '/assets/bootstrap/js/bootstrap.min.js', $dependencies, '3.3.7', false );
}

add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_styles');
add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_scripts');

function dbsnettheme_wp_setup() {
	add_theme_support('title-tag');
}
add_action('after_setup_theme','dbsnettheme_wp_setup');

add_action('storefront_before_site', 'storefront_add_webfunction');
function storefront_add_webfunction(){
	?>
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
            <li><a href="#">Masuk</a></li>
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
                <li><a href="<?php echo wp_logout_url(home_url()); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
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
        <form class="col-md-6" role="search" method="get" action="<?php echo get_permalink( wc_get_page_id( 'search' ) );//esc_url( home_url( '/' ) ); //echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
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
	<?php
}

function storefront_add_topbar() {
    ?>

    <?php
}
add_action( 'storefront_before_header', 'storefront_add_topbar' );

add_action( 'storefront_header', 'jk_storefront_header_content', 40 );
function jk_storefront_header_content() { ?>
	<div style="clear: both; text-align: right;">
		Have questions about our products? <em>Give us a call:</em> <strong>0800 123 456</strong>
	</div>
	<?php
}

add_filter('show_admin_bar','__return_false');

add_action( 'init', 'jk_remove_storefront_header_search' );
function jk_remove_storefront_header_search() {
	remove_action( 'storefront_header', 'storefront_product_search', 	40 );
}

/*function dbsnet_product_subcategories($args = array()){
  $parentid = get_queried_object_id();

  $args = array( 'parent' => $parentid);

  $terms = get_terms('product_cat', $args);
  if ( $terms ) {
         
    echo '<ul class="product-cats">';

    foreach ( $terms as $term ) {

      echo '<li class="category">';                 

      woocommerce_subcategory_thumbnail( $term );

      echo '<h2>';
      echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
      echo $term->name;
      echo '</a>';
      echo '</h2>';
                                     
      echo '</li>';
                                   

    }

    echo '</ul>';

  }
}
add_action('woocommerce_before_shop_loop', 'dbsnet_product_subcategories', 100);
*/

function dbsnet_main_search_query($query){
  if($query->is_search()){
    if(isset($_GET['category']) && !empty($_GET['category'])){
      $query->set('tax_query', array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array($_GET['category'])
        )
      );
    }
  }
  return $query;var_dump($query);die;
}
add_action('pre_get_posts', 'dbsnet_main_search_query', 1000);