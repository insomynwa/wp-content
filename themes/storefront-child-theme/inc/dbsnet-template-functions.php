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

		$(".batch-buy-button").click(function(){
			var trParent = $(this).closest('tr');
			var idSib = trParent.children("td").children("input.batch-hidden-id");
			var priceSib = trParent.children("td").children("input.batch-hidden-price");
			var quantitySib = trParent.children("td").children("input.batch-hidden-quantity");
			
			$("#batch-modal-hidden-id").val(idSib.val());
			$("#batch-modal-hidden-price").val(priceSib.val());
			$("#batch-modal-quantity").attr('max', quantitySib.val());
			$("#batch-modal").modal("show");
		});

/*<!-- Bootstrap Core JavaScript -->*/
		$(".dropdown").hover(            
	        function() {
	            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
	            $(this).toggleClass('open');        
	        },
	        function() {
	            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
	            $(this).toggleClass('open');       
        	}
    	);

		/*
			var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
		*/
							
		$().UItoTop({ easingType: 'easeOutQuart' });

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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php _e($user_info->first_name); ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li>
								<a href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Kotak Surat <span class="badge">5</span></a></li>
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

// New header navigation
function dbsnet_header_navigation_v2(){
	?>
	<!-- header -->
	<div class="agileits_header">
		<div class="w3l_offers">
			<a href="<?php echo home_url( '/shop/' ) ?>">Today's special Offers !</a>
		</div>
		<div class="w3l_search">
			<form action="#" method="post">
				<input type="text" name="Product" value="Search a product..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search a product...';}" required="">
				<input type="submit" value=" ">
			</form>
		</div>
		<div class="product_list_header">  
			<form action="#" method="post" class="last">
                <fieldset>
                    <input type="hidden" name="cmd" value="_cart" />
                    <input type="hidden" name="display" value="1" />
                    <input type="submit" name="submit" value="View your cart" class="button" />
                </fieldset>
            </form>
		</div>
		<div class="w3l_header_right">
		<?php $user_info = get_userdata(get_current_user_id()); ?>
			<?php if(!is_user_logged_in()): ?>
				<ul>
					<li class="dropdown profile_details_drop">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
						<div class="mega-dropdown-menu" style="text-align: left">
							<div class="w3ls_vegetables">
								<ul class="dropdown-menu drp-mnu">
									<li><a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Login</a></li> 
									<li><a href="<?php echo wp_registration_url(); ?>">Register</a></li>
								</ul>
							</div>                  
						</div>	
					</li>
				</ul>
			<?php else: ?>
				<ul>
					<li class="dropdown profile_details_drop">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
						<div class="mega-dropdown-menu">
							<div class="w3ls_vegetables">
								<ul class="dropdown-menu drp-mnu" style="text-align: left">
									<li>
									<a href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Inbox <span class="badge">5</span></a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) );?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profile</a></li>
									<li><a href="<?php current_user_can('manage_options') ? _e(admin_url()) : _e('#'); ?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
								</ul>
							</div>                  
						</div>	
					</li>
				</ul>
			<?php endif; ?>
			
		</div>
		<div class="w3l_header_right1">
			<h2><a href="<?php echo home_url( '/contact-us/' ) ?>">Contact Us</a></h2>
		</div>
		<div class="clearfix"> </div>
	</div>
	<!-- script-for sticky-nav -->
	<script>
	jQuery(document).ready(function() {
		 var navoffeset=jQuery(".agileits_header").offset().top;
		 jQuery(window).scroll(function(){
			var scrollpos=jQuery(window).scrollTop(); 
			if(scrollpos >=navoffeset){
				jQuery(".agileits_header").addClass("fixed");
			}else{
				jQuery(".agileits_header").removeClass("fixed");
			}
		 });
		 
	});
	</script>
<!-- //script-for sticky-nav -->
	<div class="logo_products">
		<div class="container">
			<div class="w3ls_logo_products_left">
				<h1><a href="<?php echo home_url();?>"><span>DBS</span> Store</a></h1>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="special_items">
					<!-- <li><a href="events.html">Events</a><i>/</i></li> -->
					<li><a href="<?php echo home_url( '/shop/' ) ?>">Shop</a><i>/</i></li>
					<li><a href="<?php echo home_url( '/about-us/' ) ?>">About Us</a><i>/</i></li>
					<li><a href="<?php echo home_url( '/faq/' ) ?>">FAQ</a><i></i></li>
					
					<!-- <li><a href="services.html">Services</a></li> -->
				</ul>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>(+62) 234 567</li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:store@dbs.com">store@dbs.com</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->

	<script>
			// paypal.minicart.render();

			// paypal.minicart.cart.on('checkout', function (evt) {
			// 	var items = this.items(),
			// 		len = items.length,
			// 		total = 0,
			// 		i;

			// 	// Count the number of each item in the cart
			// 	for (i = 0; i < len; i++) {
			// 		total += items[i].get('quantity');
			// 	}

			// 	if (total < 3) {
			// 		alert('The minimum order quantity is 3. Please add more to your shopping cart before checking out');
			// 		evt.preventDefault();
			// 	}
			// });

		</script>

	<?php

}

function dbsnet_theme_breadcrumb_shop(){
	?>
		<div class="products-breadcrumb">
				<div class="container">
					<ul>
						<li><i class="fa fa-home" aria-hidden="true"></i><a href="index.html">Home</a><span>|</span></li>
						<li>Branded Foods</li>
					</ul>
				</div>
		</div>
	<?php
}

function dbsnet_theme_banner_shop(){
	?>
	<div class="w3l_banner_nav_right">
			<div class="w3l_banner_nav_right_banner3">
				<h3>Best Deals For New Products<span class="blink_me"></span></h3>
			</div>
			<div class="w3l_banner_nav_right_banner3_btm">
				<div class="col-md-4 w3l_banner_nav_right_banner3_btml">
					<div class="view view-tenth">
						<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/13.jpg', null )); ?> alt=" " class="img-responsive" />
						<div class="mask">
							<h4>Grocery Store</h4>
							<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>
						</div>
					</div>
					<h4>Utensils</h4>
					<ol>
						<li>sunt in culpa qui officia</li>
						<li>commodo consequat</li>
						<li>sed do eiusmod tempor incididunt</li>
					</ol>
				</div>
				<div class="col-md-4 w3l_banner_nav_right_banner3_btml">
					<div class="view view-tenth">
						<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/14.jpg', null )); ?> alt=" " class="img-responsive" />
						<div class="mask">
							<h4>Grocery Store</h4>
							<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>
						</div>
					</div>
					<h4>Hair Care</h4>
					<ol>
						<li>enim ipsam voluptatem officia</li>
						<li>tempora incidunt ut labore et</li>
						<li>vel eum iure reprehenderit</li>
					</ol>
				</div>
				<div class="col-md-4 w3l_banner_nav_right_banner3_btml">
					<div class="view view-tenth">
						<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/15.jpg', null )); ?> alt=" " class="img-responsive" />
						<div class="mask">
							<h4>Grocery Store</h4>
							<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>
						</div>
					</div>
					<h4>Cookies</h4>
					<ol>
						<li>dolorem eum fugiat voluptas</li>
						<li>ut aliquid ex ea commodi</li>
						<li>magnam aliquam quaerat</li>
					</ol>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="w3ls_w3l_banner_nav_right_grid">
				<h3>Popular Brands</h3>
				<div class="w3ls_w3l_banner_nav_right_grid1">
					<h6>food</h6>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/5.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>knorr instant soup (100 gm)</p>
											<h4>$3.00 <span>$5.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="knorr instant soup" />
													<input type="hidden" name="amount" value="3.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/6.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>chings noodles (75 gm)</p>
											<h4>$5.00 <span>$8.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="chings noodles" />
													<input type="hidden" name="amount" value="5.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/7.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>lahsun sev (150 gm)</p>
											<h4>$3.00 <span>$5.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="lahsun sev" />
													<input type="hidden" name="amount" value="3.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/8.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>premium bake rusk (300 gm)</p>
											<h4>$5.00 <span>$7.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="premium bake rusk" />
													<input type="hidden" name="amount" value="5.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="w3ls_w3l_banner_nav_right_grid1">
					<h6>vegetables & fruits</h6>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/9.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>fresh spinach (palak)</p>
											<h4>$2.00 <span>$3.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="fresh spinach" />
													<input type="hidden" name="amount" value="2.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/10.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>fresh mango dasheri (1 kg)</p>
											<h4>$5.00 <span>$8.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="fresh mango dasheri" />
													<input type="hidden" name="amount" value="5.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="tag"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/tag.png', null )); ?> alt=" " class="img-responsive" /></div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/11.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>fresh apple red (1 kg)</p>
											<h4>$6.00 <span>$8.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="fresh apple red" />
													<input type="hidden" name="amount" value="6.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/12.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>fresh broccoli (500 gm)</p>
											<h4>$4.00 <span>$6.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="fresh broccoli" />
													<input type="hidden" name="amount" value="4.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="w3ls_w3l_banner_nav_right_grid1">
					<h6>beverages</h6>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/13.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>mixed fruit juice (1 ltr)</p>
											<h4>$3.00 <span>$4.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="mixed fruit juice" />
													<input type="hidden" name="amount" value="3.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/14.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>prune juice - sunsweet (1 ltr)</p>
											<h4>$4.00 <span>$5.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="prune juice" />
													<input type="hidden" name="amount" value="4.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="tag"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/tag.png', null )); ?> alt=" " class="img-responsive" /></div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/15.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>coco cola zero can (330 ml)</p>
											<h4>$3.00 <span>$5.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="coco cola can" />
													<input type="hidden" name="amount" value="3.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-3 w3ls_w3l_banner_left">
						<div class="hover14 column">
						<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/16.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>sprite bottle (2 ltr)</p>
											<h4>$3.00 <span>$4.00</span></h4>
										</div>
										<div class="snipcart-details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="sprite bottle" />
													<input type="hidden" name="amount" value="3.00" />
													<input type="hidden" name="discount_amount" value="1.00" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button" />
												</fieldset>
											</form>
										</div>
									</div>
								</figure>
							</div>
						</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	<?php
}

function dbsnet_homepage_banner_top_start(){
	?>
	<!-- banner start -->
	<div class="banner">

	<?php
}

function dbsnet_homepage_banner_top_left(){

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

	?>
	<div class="w3l_banner_nav_left">
				<nav class="navbar nav_bottom">
				 <!-- Brand and toggle get grouped for better mobile display -->
				  <div class="navbar-header nav_2">
					  <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
				   </div> 
				   <!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
						<ul class="nav navbar-nav nav_1">
						<?php foreach($all_categories as $category): ?>
							<li><a href="<?php echo get_term_link( $category->slug, 'product_cat' );?>">
								<?php echo $category->name;?></a>
							</li>
						<?php endforeach;?>
						</ul>
					 </div><!-- /.navbar-collapse -->
				</nav>
			</div>
	<?php
}

function dbsnet_homepage_banner_top_right(){
	?>
	<div class="w3l_banner_nav_right">
		<section class="slider">
			<div class="flexslider">
				<ul class="slides">
					<li>
						<div class="w3l_banner_nav_right_banner">
							<h3>Make your <span>food</span> with Spicy.</h3>
							<div class="more">
								<a href="products.html" class="button--saqui button--round-l button--text-thick" data-text="Shop now">Shop now</a>
							</div>
						</div>
					</li>
					<li>
						<div class="w3l_banner_nav_right_banner1">
							<h3>Make your <span>food</span> with Spicy.</h3>
							<div class="more">
								<a href="products.html" class="button--saqui button--round-l button--text-thick" data-text="Shop now">Shop now</a>
							</div>
						</div>
					</li>
					<li>
						<div class="w3l_banner_nav_right_banner2">
							<h3>upto <i>50%</i> off.</h3>
							<div class="more">
								<a href="products.html" class="button--saqui button--round-l button--text-thick" data-text="Shop now">Shop now</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</section>
		<!-- flexSlider -->
			<!-- <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" />
			<script defer src="js/jquery.flexslider.js"></script> -->
			<script type="text/javascript">
			jQuery(window).load(function(){
			  jQuery('.flexslider').flexslider({
				animation: "slide",
				start: function(slider){
				  jQuery('body').removeClass('loading');
				}
			  });
			});
		  </script>
		<!-- //flexSlider -->
	</div>
	
	<?php
}

function dbsnet_homepage_banner_top_end(){
	?>
		<div class="clearfix"></div>
		</div>
	<!-- banner -->

	<?php
}

function dbsnet_homepage_banner_bottom(){
	$tenants = get_users(
		array(
			'role__in' => 'tenant_role'
			)
		);
	$column_size = 12 / count($tenants);
	?>
	<div class="banner_bottom">
		<div class="wthree_banner_bottom_left_grid_sub">
		</div>
		<div class="wthree_banner_bottom_left_grid_sub1">
			<?php foreach($tenants as $tenant): ?>
			<div class="col-md-<?php echo $column_size; ?> wthree_banner_bottom_left">
				<div class="wthree_banner_bottom_left_grid">
					<!-- <img src=<?php //_e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/4.jpg', null )); ?> alt=" " class="img-responsive" /> -->
					<?php echo get_avatar($tenant->ID, '500', '','', array('class' => 'img-responsive')); ?>
					<!-- <div class="wthree_banner_bottom_left_grid_pos">
						<h4>Discount Offer <span>25%</span></h4>
					</div> -->
				</div>
			</div>
			<?php endforeach; ?>
			<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
	</div>
	<?php
}

 function dbsnet_product_hot_v2(){
 	$args = array(
		'post_type' => 'product',
		'stock' => 1,
		'posts_per_page' => 4,
		'orderby' =>'date',
		'order' => 'DESC' 
	);
	$loop = new WP_Query( $args );
 	?>
<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
			<h3>Hot Product</h3>
			<div class="agile_top_brands_grids">
				<?php
				while ( $loop->have_posts() ) : $loop->the_post(); 
				global $product;
				?>
					<div class="col-md-3 top_brand_left">
						<div class="hover14 column">
							<div class="agile_top_brand_left_grid">
								<div class="agile_top_brand_left_grid1">
									<figure>
										<div class="snipcart-item block" >
											<div class="snipcart-thumb">
											<a href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail( $loop->post->ID )) : ?>
											<?php echo get_the_post_thumbnail($loop->post->ID,array('140','140'), 'shop_catalog'); ?>
											<?php else: ?>
											<img style="height: 140px; width: 140px" src="<?php echo woocommerce_placeholder_img_src(); ?>">
											<?php endif; ?>	
												<p><?php the_title(); ?></p>
											</a>
											</div>
											<div class="snipcart-details top_brand_home_details">
												<form action="<?php the_permalink(); ?>" method="post">
													<fieldset>
														<input type="hidden" name="cmd" value="_cart" />
														<input type="hidden" name="add" value="1" />
														<input type="hidden" name="business" value=" " />
														<input type="hidden" name="item_name" value="Fortune Sunflower Oil" />
														<input type="hidden" name="amount" value="7.99" />
														<input type="hidden" name="discount_amount" value="1.00" />
														<input type="hidden" name="currency_code" value="USD" />
														<input type="hidden" name="return" value=" " />
														<input type="hidden" name="cancel_return" value=" " />
														<input type="submit" name="submit" value="Details" class="button" />
													</fieldset>
														
												</form>
										
											</div>
										</div>
									</figure>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile;wp_reset_query(); ?>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //top-brands -->
 	<?php
 }

 function dbsnet_product_best_seller_v2(){
 	$args = array(
	    'post_type' => 'product',
	    'meta_key' => 'total_sales',
	    'orderby' => 'meta_value_num',
	    'posts_per_page' => 4,
	);
	$loop = new WP_Query( $args );

 	?>
 	<!-- fresh-vegetables -->
	<div class="fresh-vegetables">
		<div class="container">
			<h3>Best Seller Products</h3>
			<div class="w3l_fresh_vegetables_grids">
				<div class="w3l_fresh_vegetables_grid_right">
				<?php
				while ( $loop->have_posts() ) : $loop->the_post(); 
				global $product;
				?>
					<div class="col-md-3 top_brand_left">
						<div class="hover14 column">
							<div class="agile_top_brand_left_grid">
								<div class="agile_top_brand_left_grid1">
									<figure>
										<div class="snipcart-item block" >
											<div class="snipcart-thumb">
											<a href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail( $loop->post->ID )) : ?>
											<?php echo get_the_post_thumbnail($loop->post->ID,array('140','140'), 'shop_catalog'); ?>
											<?php else: ?>
											<img style="height: 140px; width: 140px" src="<?php echo woocommerce_placeholder_img_src(); ?>">
											<?php endif; ?>	
												<p><?php the_title(); ?></p>
											</a>
											</div>
											<div class="snipcart-details top_brand_home_details">
												<form action="<?php the_permalink(); ?>" method="post">
													<fieldset>
														<input type="hidden" name="cmd" value="_cart" />
														<input type="hidden" name="add" value="1" />
														<input type="hidden" name="business" value=" " />
														<input type="hidden" name="item_name" value="Fortune Sunflower Oil" />
														<input type="hidden" name="amount" value="7.99" />
														<input type="hidden" name="discount_amount" value="1.00" />
														<input type="hidden" name="currency_code" value="USD" />
														<input type="hidden" name="return" value=" " />
														<input type="hidden" name="cancel_return" value=" " />
														<input type="submit" name="submit" value="SHOP NOW" class="button" />
													</fieldset>
														
												</form>
										
											</div>
										</div>
									</figure>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile;wp_reset_query(); ?>
					<div class="clearfix"> </div>
					<div class="agileinfo_move_text">
						<div class="agileinfo_marquee">
							<h4>get <span class="blink_me">25% off</span> on first order and also get gift voucher</h4>
						</div>
						<div class="agileinfo_breaking_news">
							<span> </span>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //fresh-vegetables -->
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
					<img alt="cake" src=<?php _e(home_url( '/wp-content/uploads/2017/08/placeholder-o2.png', null )); ?> style="width: 100%">
				</div>
				<div class="item">
					<img alt="fjords" src=<?php _e(home_url( '/wp-content/uploads/2017/08/l2-slide3-bg.jpeg', null )); ?> style="width: 100%">
				</div>
				<div class="item">
					<img alt="mountains" src=<?php _e(home_url( '/wp-content/uploads/2017/08/cake.jpg', null )); ?> style="width: 100%">
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

function dbsnet_single_product(){
	?>
		<div class="agileinfo_single">
				<h5>charminar pulao basmati rice 5 kg</h5>
				<div class="col-md-4 agileinfo_single_left">
					<img id="example" src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/76.png', null )); ?>  alt=" " class="img-responsive" />
				</div>
				<div class="col-md-8 agileinfo_single_right">
					<div class="rating1">
						<span class="starRating">
							<input id="rating5" type="radio" name="rating" value="5">
							<label for="rating5">5</label>
							<input id="rating4" type="radio" name="rating" value="4">
							<label for="rating4">4</label>
							<input id="rating3" type="radio" name="rating" value="3" checked>
							<label for="rating3">3</label>
							<input id="rating2" type="radio" name="rating" value="2">
							<label for="rating2">2</label>
							<input id="rating1" type="radio" name="rating" value="1">
							<label for="rating1">1</label>
						</span>
					</div>
					<div class="w3agile_description">
						<h4>Description :</h4>
						<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui 
							officia deserunt mollit anim id est laborum.Duis aute irure dolor in 
							reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
							pariatur.</p>
					</div>
					<div class="snipcart-item block">
						<div class="snipcart-thumb agileinfo_single_right_snipcart">
							<h4>$21.00 <span>$25.00</span></h4>
						</div>
						<div class="snipcart-details agileinfo_single_right_details">
							<form action="#" method="post">
								<fieldset>
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" />
									<input type="hidden" name="business" value=" " />
									<input type="hidden" name="item_name" value="pulao basmati rice" />
									<input type="hidden" name="amount" value="21.00" />
									<input type="hidden" name="discount_amount" value="1.00" />
									<input type="hidden" name="currency_code" value="USD" />
									<input type="hidden" name="return" value=" " />
									<input type="hidden" name="cancel_return" value=" " />
									<input type="submit" name="submit" value="Add to cart" class="button" />
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
	<?php
}

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
			</tr>
		</thead>
		<?php $i=1; foreach($batches as $batch): ?>
			<?php $batch_production = get_post_meta( $batch->ID, 'meta_batch_startdate', true ); ?>
			<?php $batch_expired = get_post_meta( $batch->ID, 'meta_batch_endate', true ); ?>
			<?php $batch_stock = get_post_meta( $batch->ID, 'meta_batch_stock', true ); ?>
			<?php $batch_price = get_post_meta( $batch->ID, 'meta_batch_price', true ); ?>
		<tr>
			<td><?php echo $i; ?><input class="batch-hidden-id" type="hidden" value="<?php echo $batch->ID; ?>" /></td>
			<td><?php echo $batch_production; ?></td>
			<td><?php echo $batch_expired; ?></td>
			<td><?php echo $batch_stock; ?><input class="batch-hidden-quantity" type="hidden" value="<?php echo $batch_stock; ?>" /></td>
			<td><?php echo $batch_price; ?><input class="batch-hidden-price" type="hidden" value="<?php echo $batch_price; ?>" /></td>
			<td>
				<button class="batch-buy-button" class="btn btn-info" type="button">Beli</button>
			</td>
		</tr>
		<?php $i++; endforeach; ?>
	</table>
	<!-- Modal -->
	<div id="batch-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 id="batch-modal-header" class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="batch-quantity">Jumlah</label>
							<input type="number" min="1" max="100" name="batch-quantity" value="1" id="batch-modal-quantity">
						</div>
						<div class="form-group">
							<input type="hidden" name="batch-price" value="" id="batch-modal-hidden-price">
							<input type="hidden" name="batch-id" value="" id="batch-modal-hidden-id">
							<button id="batch-modal-submit" type="submit" name="add-to-cart" value="<?php echo $product->get_id(); ?>">Add to cart</button>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>	
	</div>
	<?php
	endif;
}

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
	// echo "GET:";
	//var_dump($_GET);
	// echo "POST";
	//var_dump($_POST);die;
	// var_dump($price);
	// var_dump($_GET['jumlah']);
	// var_dump($post->post->post_type);die;
	if($post->post->post_type === 'product'){
		$price = get_post_meta($_POST['batch-id'], "meta_batch_price", true);
	}
	//var_dump($price);die;
	return $price;
}

// ABOUT US 
function dbsnet_about_us(){
	?>
	<div class="privacy about">
			<h3>About Us</h3>
			<p class="animi">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis 
				praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias 
				excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui 
				officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem 
				rerum facilis est et expedita distinctio.</p>
			<div class="agile_about_grids">
				<div class="col-md-6 agile_about_grid_right">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/31.jpg', null )); ?> alt=" " class="img-responsive" />
				</div>
				<div class="col-md-6 agile_about_grid_left">
					<ol>
						<li>laborum et dolorum fuga</li>
						<li>corrupti quos dolores et quas</li>
						<li>est et expedita distinctio</li>
						<li>deleniti atque corrupti quos</li>
						<li>excepturi sint occaecati cupiditate</li>
						<li>accusamus et iusto odio</li>
					</ol>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //about -->
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="team">
		<div class="container">
			<h3>Meet Our Amazing Team</h3>
			<div class="agileits_team_grids">
				<div class="col-md-3 agileits_team_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/32.jpg', null )); ?> alt=" " class="img-responsive" />
					<h4>Martin Paul</h4>
					<p>Manager</p>
					<ul class="agileits_social_icons agileits_social_icons_team">
						<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<div class="col-md-3 agileits_team_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/33.jpg', null )); ?> alt=" " class="img-responsive" />
					<h4>Michael Rick</h4>
					<p>Supervisor</p>
					<ul class="agileits_social_icons agileits_social_icons_team">
						<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<div class="col-md-3 agileits_team_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/34.jpg', null )); ?> alt=" " class="img-responsive" />
					<h4>Thomas Carl</h4>
					<p>Supervisor</p>
					<ul class="agileits_social_icons agileits_social_icons_team">
						<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<div class="col-md-3 agileits_team_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/35.jpg', null )); ?> alt=" " class="img-responsive" />
					<h4>Laura Lee</h4>
					<p>CEO</p>
					<ul class="agileits_social_icons agileits_social_icons_team">
						<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<?php
}

// Contact Us

function dbsnet_contact_us(){
	?>
	<div class="mail">
			<h3>Mail Us</h3>
			<div class="agileinfo_mail_grids">
				<div class="col-md-4 agileinfo_mail_grid_left">
					<ul>
						<li><i class="fa fa-home" aria-hidden="true"></i></li>
						<li>address<span>868 1st Avenue NYC.</span></li>
					</ul>
					<ul>
						<li><i class="fa fa-envelope" aria-hidden="true"></i></li>
						<li>email<span><a href="mailto:info@example.com">info@example.com</a></span></li>
					</ul>
					<ul>
						<li><i class="fa fa-phone" aria-hidden="true"></i></li>
						<li>call to us<span>(+62) 234 567 826</span></li>
					</ul>
				</div>
				<div class="col-md-8 agileinfo_mail_grid_right">
					<form action="#" method="post">
						<div class="col-md-6 wthree_contact_left_grid">
							<input type="text" name="Name" value="Name*" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name*';}" required="">
							<input type="email" name="Email" value="Email*" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email*';}" required="">
						</div>
						<div class="col-md-6 wthree_contact_left_grid">
							<input type="text" name="Telephone" value="Telephone*" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Telephone*';}" required="">
							<input type="text" name="Subject" value="Subject*" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Subject*';}" required="">
						</div>
						<div class="clearfix"> </div>
						<textarea  name="Message" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message...';}" required="">Message...</textarea>
						<input type="submit" value="Submit">
						<input type="reset" value="Clear">
					</form>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //mail -->
		</div>
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<!-- map -->
	<div class="map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d96748.15352429623!2d-74.25419879353115!3d40.731667701988506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sshopping+mall+in+New+York%2C+NY%2C+United+States!5e0!3m2!1sen!2sin!4v1467205237951" style="border:0"></iframe>
	</div>
<!-- //map -->
	<?php
}

// FAQ
function dbsnet_faq(){
	?>
	<div class="faq">
			<h3>FAQ's</h3>
			<div class="panel-group w3l_panel_group_faq" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
				  <h4 class="panel-title asd">
					<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>assumenda est cliche reprehenderit
					</a>
				  </h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				  <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Itaque earum rerum
					</a>
				  </h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>autem accusamus terry quibusdam
					</a>
				  </h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFour">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>excepturi sint cliche reprehenderit
					</a>
				  </h4>
				</div>
				<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			   <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFive">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>dolorem eum fugiat quo voluptas nulla pariatur
					</a>
				  </h4>
				</div>
				<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			   <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingSix">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>terry eiusmod high life accusamus 
					</a>
				  </h4>
				</div>
				<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			   <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingSeven">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>quasi architecto beatae vitae dicta
					</a>
				  </h4>
				</div>
				<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			   <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingEight">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>iure reprehenderit qui in ea voluptate velit esse
					</a>
				  </h4>
				</div>
				<div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			   <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingNine">
				  <h4 class="panel-title asd">
					<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>reprehenderit qui in ea voluptate velit esse quam nihil 
					</a>
				  </h4>
				</div>
				<div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine">
				   <div class="panel-body panel_text">
					Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
				  </div>
				</div>
			  </div>
			</div>
		</div>
<!-- //faq -->
		</div>
		<div class="clearfix"></div>
	<?php
}