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
	<nav id="dbsnet-header-nav" class="navbar navbar-fixed-top">
		<div class="container">
			<!-- <div class="row">
				<div class="col-md-8"> -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#dbsnet-navbar-collapse" aria-expanded="false" aria-controls="navbar">
							<span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
						</button>
						<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#dbsnet-navbar-collapse" aria-expanded="false" aria-controls="navbar">
						<?php if(!is_user_logged_in()): ?>
							Daftar
						<?php else: ?>
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
						<?php endif; ?>
						</button>
						<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#dbsnet-navbar-collapse" aria-expanded="false" aria-controls="navbar">
						<?php if(!is_user_logged_in()): ?>
							Masuk
						<?php else: ?>
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
						<?php endif; ?>
						</button>
						<!-- <a class="navbar-brand" href="<?php //_e(home_url());?>">Dibuang Sayang</a> -->
					</div>
					<a class="navbar-brand" href="<?php _e(home_url());?>">Dibuang Sayang</a>
					<ul class="nav navbar-nav navbar-right">
					<?php if(!is_user_logged_in()): ?>
						<li><a href="#">Daftar</a></li>
						<li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>">Masuk</a></li>
					<?php else: ?>
						<?php $user_info = get_userdata(get_current_user_id()); ?>
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
					<div id="dbsnet-navbar-collapse" class="navbar-collapse collapse">
						
					</div><!--/.navbar-collapse -->
				<!-- </div> -->
				<!-- <div class="col-md-4"><a class="navbar-brand" href="<?php //_e(home_url());?>">Dibuang Sayang</a></div> -->
			<!-- </div> -->
		</div>
	</nav>
	<?php
}

function dbsnet_header_search(){
	?>
	<div id="dbsnet-header-search" class="container after-navbar bg-warning">
		<div class="row">
			<div class="col-xs-0 col-sm-0 col-md-2"></div>
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
					<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</span>
				</div> <!-- /input-group -->
			</form>
		</div>
	</div>
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

function dbsnet_product_info_list(){
	?>
	<div id="dbsnet-product-info-list" class="container-fluid bg-info">
		<div class="row">
			<div class="col-sm-12 col-lg-6 col-md-6 bg-warning">
				<div>
					<h3>Produk Terbaru</h3>
				</div>
				<ul class="row">
				<?php echo ( do_shortcode('[resent_products]') ); ?>
				</ul>
			</div>

			<div class="col-sm-12 col-lg-6 col-md-6 bg-info">
				<div>
					<h3>Produk Terlaris</h3>
				</div>
				<ul class="row">
				<?php echo ( do_shortcode('[best_sellers]') ); ?>
				</ul>
			</div>
		</div> <!-- /row -->
	</div> <!-- /container -->
	<?php
}

function dbsnet_products_list(){
	?>
	<div id="dbsnet-products-list" class="container-fluid bg-success">
		<div class="row">
			<div class="col-md-3 col-sm-4">
				<span class="thumbnail">
					<img src="http://placehold.it/500x400" alt="...">
					<h4>Product Tittle</h4>
					<div class="ratings">
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
					</div>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
					<hr class="line">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<p class="price">$29,90</p>
						</div>
						<div class="col-md-6 col-sm-6">
							<button class="btn btn-success right" > BUY ITEM</button>
						</div>
					</div>
				</span>
			</div>
		</div>
	</div>
	<?php
}