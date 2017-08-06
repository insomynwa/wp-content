<?php

function dbsnet_scripts_global(){
	?>
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
	<?php
}

function dbsnet_go_top_navigation(){
	?>
	<button type="button" class="btn btn-warning" id="topBtn" title="Go to top">Top</button>
	<?php
}

function dbsnet_header_navigation(){
	?>
	<nav id="dbsnet-header-nav" class="navbar">
		<div class="container-fluid">
			<!-- <div class="row">
				<div class="col-md-8"> -->
					<?php $user_info = get_userdata(get_current_user_id()); ?>
					<div class="navbar-header">
						<button type="button" class="dropdown navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="navbar">
							<?php if(!is_user_logged_in()): ?>
							Daftar
							<?php else: ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php _e($user_info->first_name); ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Kotak Surat <span class="badge">5</span></a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profil</a></li>
								<li><a href="<?php current_user_can('manage_options') ? _e(admin_url()) : _e('#'); ?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
							</ul>
							<?php endif; ?>
						</button>
						<button type="button" class="dropdown navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="navbar">
							<?php if(!is_user_logged_in()): ?>
							Masuk
							<?php else: ?>
							<a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) );?>" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Keranjang <span class="badge">5</span></a>
							<ul class="dropdown-menu">
								<li>belanjaan pertama</li>
								<li>belanjaan kedua</li>
								<li>belanjaan ketiga</li>
							</ul>
							<?php endif; ?>
						</button>
						<button type="button" class="navbar-toggle collapsed pull-left" aria-expanded="false" aria-controls="navbar">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-search" aria-hidden="true"></a>
							<div class="dropdown-menu">
								<form class="col-md-8" role="search" method="get" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) );//esc_url( home_url( '/' ) ); //echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									<div class="input-group">
										<span class="input-group-btn">
											<select name="product_cat" class="form-control">
												<option value="">Semua Kategori</option>
											<?php
											$args = array( 'hide_empty' => 0, 'parent' =>0);
											$terms = get_terms('product_cat', $args);
											if ( $terms ):
												foreach ( $terms as $term ): ?>
												<option value="<?php _e($term->slug); ?>"><?php _e($term->name); ?></option>;
											<?php
												endforeach;
											endif;
											?>
											</select>
										</span>
										<input type="text" class="form-control" aria-label="..." name="s">
										<input type="hidden" name="post_type" value="product" />
										<span class="input-group-btn">
										<input class="btn btn-default" type="submit" value="Cari">
										</span>
									</div> <!-- /input-group -->
								</form>
							</div>
						</button>
					</div>
					<a class="navbar-brand" href="<?php _e(home_url());?>">Dibuang Sayang</a>
					
					<div id="dbsnet-navbar-collapse" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li>
								<form class="navbar-form navbar-search" role="search" method="get" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) );//esc_url( home_url( '/' ) ); //echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
									<div class="input-group">
										<span class="input-group-btn">
											<select name="product_cat" class="form-control">
												<option value="">Semua Kategori</option>
											<?php
											$args = array( 'hide_empty' => 0, 'parent' =>0);
											$terms = get_terms('product_cat', $args);
											if ( $terms ):
												foreach ( $terms as $term ): ?>
												<option value="<?php _e($term->slug); ?>"><?php _e($term->name); ?></option>;
											<?php
												endforeach;
											endif;
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
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<?php if(!is_user_logged_in()): ?>
							<li><a href="#">Daftar</a></li>
							<li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>">Masuk</a></li>
							<?php else: ?>
							<li><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) );?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Keranjang <span class="badge">5</span></a></li>
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php _e($user_info->first_name); ?> <span class="caret"></span></a>
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
				<!-- </div> -->
				<!-- <div class="col-md-4"><a class="navbar-brand" href="<?php //_e(home_url());?>">Dibuang Sayang</a></div> -->
			<!-- </div> -->
		</div>
	</nav>
	<?php
}

function dbsnet_homepage_slideshow(){
	?>
	<div id="dbsnet-slideshow" class="container-fluid bg-danger">
		<div id="dbsnetCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
			<ol class="carousel-indicators">
				<li data-target="#dbsnetCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#dbsnetCarousel" data-slide-to="1"></li>
				<li data-target="#dbsnetCarousel" data-slide-to="2"></li>
			</ol>

			<div class="carousel-inner">
				<div class="item active">
					<img alt="nature" src="https://images-na.ssl-images-amazon.com/images/G/01/kindle/merch/2017/SMP/ftvs/popcorngws/1500x300_Lifestyle_v1._CB503869808_.jpg" style="width: 100%">
				</div>
				<div class="item">
					<img alt="fjords" src="https://images-na.ssl-images-amazon.com/images/G/01/AMAZON_FASHION/2017/EDITORIAL/SUMMER_3/GATEWAY/DESKTOP/1x/HERO_W_xCat_ShoppingList2_1x._CB504779749_.jpg" style="width: 100%">
				</div>
				<div class="item">
					<img alt="mountains" src="https://images-na.ssl-images-amazon.com/images/G/01/digital/video/merch/gateway/superhero/Amazon_GW_DesktopHero_AVD-6545_SpongebobSwap_GWAcquisitionTopStreamGrid_V1_1500x300._CB506302663_.jpg" style="width: 100%">
				</div>
			</div>

			<a class="left carousel-control" data-slide="prev" href="#dbsnetCarousel">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" data-slide="next" href="#dbsnetCarousel">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div> <!-- /container -->
	<?php
}

/*function dbsnet_recent_products_shortcode( $args ) {
  if ( storefront_is_woocommerce_activated() ) {
    $args = apply_filters( 'storefront_recent_products_args', array(
        'limit'       => 4,
        'columns'       => 4,
        'title'       => __( 'New In', 'storefront' ),
      ) );
    echo storefront_do_shortcode( 'recent_products', apply_filters( 'storefront_recent_products_shortcode_args', array(
        'per_page' => intval( $args['limit'] ),
        'columns'  => intval( $args['columns'] ),
      ) ) );
  }
}*/

function dbsnet_product_hot(){
	$args = array(
		'post_type' => 'product',
		'stock' => 1,
		'posts_per_page' => 3,
		'orderby' =>'date',
		'order' => 'DESC' 
	);
	$loop = new WP_Query( $args );
	?>
	<div id="dbsnet-products-hot" class="container bg-info">
		<div>
			<h3>Produk Terbaru</h3>
		</div>
		<div class="row">
			<?php
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product;
			?>
			<div class="col-md-3">
				<span class="thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail( $loop->post->ID )) : ?>
						<?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
						<?php else: ?>
						<img src="<?php echo woocommerce_placeholder_img_src(); ?>">
						<?php endif; ?>
						<h4><?php the_title(); ?></h4>
						<div>
							
						</div>
						<div>
							
						</div>
					</a>
				</span>
			</div>
			<?php endwhile;wp_reset_query(); ?>
		</div>
	</div>
	<?php
}

/*function dbsnet_best_selling_products_shortcode( $args ) {

  if ( storefront_is_woocommerce_activated() ) {
    $args = apply_filters( 'storefront_best_selling_products_args', array(
      'limit'   => 4,
      'columns' => 4,
      'title'      => esc_attr__( 'Best Sellers', 'storefront' ),
    ) );
    echo storefront_do_shortcode( 'best_selling_products', array(
      'per_page' => intval( $args['limit'] ),
      'columns'  => intval( $args['columns'] ),
    ) );
  }
}*/

function dbsnet_product_best_seller(){
	$args = array(
	    'post_type' => 'product',
	    'meta_key' => 'total_sales',
	    'orderby' => 'meta_value_num',
	    'posts_per_page' => 3,
	);
	$loop = new WP_Query( $args );
	?>
	<div id="dbsnet-products-best-seller" class="container bg-info">
		<div>
			<h3>Produk Terlaris</h3>
		</div>
		<div class="row">
			<?php
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product;
			?>
			<div class="col-md-3">
				<span class="thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail( $loop->post->ID )) : ?>
						<?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
						<?php else: ?>
						<img src="<?php echo woocommerce_placeholder_img_src(); ?>">
						<?php endif; ?>
						<h4><?php the_title(); ?></h4>
						<div>
							
						</div>
						<div>
							
						</div>
					</a>
				</span>
			</div>
			<?php endwhile;wp_reset_query(); ?>
		</div>
	</div>
	<?php
}

function dbsnet_homepage_tenant(){ 
	$tenants = get_users(array('role__in' => 'tenant_role'));
	// var_dump($tenant);
	?>
	<div id="dbsnet-products-tenant" class="container bg-success">
		<div class="row">
			<div>
				<h3>Tenant</h3>
			</div>
			<?php foreach($tenants as $tenant): ?>

			<div class="col-md-3">
				<a href="#">
					<span class="thumbnail">
						<!-- <img src=" --><?php echo get_avatar($tenant->ID, '500'); ?><!-- " alt="..."> -->
						<h3><?php echo $tenant->display_name; ?></h3>
					</span>
				</a>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<?php
}

function dbsnet_product_categories(){
	$taxonomy     = 'product_cat';
	$orderby      = 'name';  
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no  
	$title        = '';  
	$empty        = 0;

	$args = array(
	     'taxonomy'     => $taxonomy,
	     'orderby'      => $orderby,
	     'show_count'   => $show_count,
	     'pad_counts'   => $pad_counts,
	     'hierarchical' => $hierarchical,
	     'title_li'     => $title,
	     'hide_empty'   => $empty,
	     'parent'		=> 0,
	     'number'		=> 3
	);
	$all_categories = get_categories( $args );
	
	// var_dump($all_categories[0]);
	?>
	<div id="dbsnet-products-categories" class="container bg-info">
		<div>
			<h3>Kategori</h3>
		</div>
		<div class="row">
			<?php foreach($all_categories as $category): ?>
			<?php 
				$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); // Get Category Thumbnail
				$image = wp_get_attachment_url( $thumbnail_id ); 
				
			?>
			<div class="col-md-3">
				<a href="<?php echo get_term_link( $category->slug, 'product_cat' );?>">
					<span class="thumbnail thumbnail-mini">
						<img src="<?php if ( $image ) {echo $image;} ?>" alt="...">
						<h4><?php echo $category->name;?></h4>
	                </span>
                </a>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<?php
	
}

function dbsnet_product_batch(){
	global $product;

	$batches = get_posts( array(
	    'post_type'	=> 'batch',
	    'meta_query'	=> array(
	    	'relation'	=> 'AND',
	    	'meta_product_parent_clause' => 
		    	array(
		    		'key'	=> 'meta_product_parent',
		    		'value'	=> $product->get_id(),
		    		'compare'	=> '='
		    		),
		    'meta_batch_stock_clause' =>
		    	array(
		    		'key'	=> 'meta_batch_stock',
		    		'value'	=> 0,
		    		'compare'	=> '>'
		    		) ,
		    'meta_batch_price_clause' =>
		    	array(
		    		'key'	=> 'meta_batch_price',
		    		'value'	=> 0,
		    		'compare'	=> '>'
		    		) ,
		    	),
	    'orderby' => array('meta_batch_price_clause'=>'ASC'),
	) );//var_dump($batches[0]);
	if($batches):
	?>
	<table>
		<thead>
			<tr>
				<td>Batch</td>
				<td>Produksi</td>
				<td>Kadaluarsa</td>
				<td>Stok</td>
				<td>Harga</td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<?php $i=1; foreach($batches as $batch): ?>
			<?php $batch_production = get_post_meta( $batch->ID, 'meta_batch_startdate', true ); ?>
			<?php $batch_expired = get_post_meta( $batch->ID, 'meta_batch_endate', true ); ?>
			<?php $batch_stock = get_post_meta( $batch->ID, 'meta_batch_stock', true ); ?>
			<?php $batch_price = get_post_meta( $batch->ID, 'meta_batch_price', true ); ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $batch_production; ?></td>
			<td><?php echo $batch_expired; ?></td>
			<td><?php echo $batch_stock; ?></td>
			<td><?php echo $batch_price; ?></td>
			<td></td>
			<td></td>
		</tr>
		<?php $i++; endforeach; ?>
	</table>
	<?php
	endif;
}

/*function dbsnet_product_categories_shortcode(){
	if ( storefront_is_woocommerce_activated() ) {
	    $args = apply_filters( 'storefront_product_categories_args', array(
			'limit' 			=> 3,
			'columns' 			=> 3,
			'child_categories' 	=> 0,
			'orderby' 			=> 'name',
			'title'				=> __( 'Shop by Category', 'storefront' ),
		) );
    	echo storefront_do_shortcode( 'product_categories', apply_filters( 'storefront_product_categories_shortcode_args', array(
			'number'  => intval( $args['limit'] ),
			'columns' => intval( $args['columns'] ),
			'orderby' => esc_attr( $args['orderby'] ),
			'parent'  => esc_attr( $args['child_categories'] ),
		) ) );
	}
}*/

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
  return $query;//var_dump($query);die;
}

function dbsnet_batch_get_price($price, $post){
	var_dump($price);
	var_dump($_GET['jumlah']);
	var_dump($post->post->post_type);die;
	if($post->post->post_type === 'product'){
		$price = get_post_meta($post->post_id, "meta_batch_price", true);
	}
	return $price;
}