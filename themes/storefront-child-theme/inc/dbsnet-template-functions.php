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
			<a href="products.html">Today's special Offers !</a>
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
			<h2><a href="mail.html">Contact Us</a></h2>
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
				<h1><a href="index.html"><span>Grocery</span> Store</a></h1>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="special_items">
					<li><a href="events.html">Events</a><i>/</i></li>
					<li><a href="about.html">About Us</a><i>/</i></li>
					<li><a href="products.html">Best Deals</a><i>/</i></li>
					<li><a href="services.html">Services</a></li>
				</ul>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>(+0123) 234 567</li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:store@grocery.com">store@grocery.com</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->

	<script>
			paypal.minicart.render();

			paypal.minicart.cart.on('checkout', function (evt) {
				var items = this.items(),
					len = items.length,
					total = 0,
					i;

				// Count the number of each item in the cart
				for (i = 0; i < len; i++) {
					total += items[i].get('quantity');
				}

				if (total < 3) {
					alert('The minimum order quantity is 3. Please add more to your shopping cart before checking out');
					evt.preventDefault();
				}
			});

		</script>

	<?php

}

function dbsnet_homepage_banner_top(){
	?>
	<!-- banner -->
	<div class="banner">
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
						<li><a href="products.html">Branded Foods</a></li>
						<li><a href="household.html">Households</a></li>
						<li class="dropdown mega-dropdown active">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Veggies & Fruits<span class="caret"></span></a>				
							<div class="dropdown-menu mega-dropdown-menu w3ls_vegetables_menu">
								<div class="w3ls_vegetables">
									<ul>	
										<li><a href="vegetables.html">Vegetables</a></li>
										<li><a href="vegetables.html">Fruits</a></li>
									</ul>
								</div>                  
							</div>				
						</li>
						<li><a href="kitchen.html">Kitchen</a></li>
						<li><a href="short-codes.html">Short Codes</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Beverages<span class="caret"></span></a>
							<div class="dropdown-menu mega-dropdown-menu w3ls_vegetables_menu">
								<div class="w3ls_vegetables">
									<ul>
										<li><a href="drinks.html">Soft Drinks</a></li>
										<li><a href="drinks.html">Juices</a></li>
									</ul>
								</div>                  
							</div>	
						</li>
						<li><a href="pet.html">Pet Food</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Frozen Foods<span class="caret"></span></a>
							<div class="dropdown-menu mega-dropdown-menu w3ls_vegetables_menu">
								<div class="w3ls_vegetables">
									<ul>
										<li><a href="frozen.html">Frozen Snacks</a></li>
										<li><a href="frozen.html">Frozen Nonveg</a></li>
									</ul>
								</div>                  
							</div>	
						</li>
						<li><a href="bread.html">Bread & Bakery</a></li>
					</ul>
				 </div><!-- /.navbar-collapse -->
			</nav>
		</div>
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
		<div class="clearfix"></div>
	</div>
<!-- banner -->

 <?php
}

function dbsnet_homepage_banner_bottom(){
	?>
	<div class="banner_bottom">
		<div class="wthree_banner_bottom_left_grid_sub">
		</div>
		<div class="wthree_banner_bottom_left_grid_sub1">
			<div class="col-md-4 wthree_banner_bottom_left">
				<div class="wthree_banner_bottom_left_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/4.jpg', null )); ?> alt=" " class="img-responsive" />
					<div class="wthree_banner_bottom_left_grid_pos">
						<h4>Discount Offer <span>25%</span></h4>
					</div>
				</div>
			</div>
			<div class="col-md-4 wthree_banner_bottom_left">
				<div class="wthree_banner_bottom_left_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/5.jpg', null )); ?> alt=" " class="img-responsive" />
					<div class="wthree_banner_btm_pos">
						<h3>introducing <span>best store</span> for <i>groceries</i></h3>
					</div>
				</div>
			</div>
			<div class="col-md-4 wthree_banner_bottom_left">
				<div class="wthree_banner_bottom_left_grid">
					<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/6.jpg', null )); ?> alt=" " class="img-responsive" />
					<div class="wthree_banner_btm_pos1">
						<h3>Save <span>Upto</span> $10</h3>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
	</div>
	<?php
}

 function dbsnet_product_hot_v2(){
 	?>
<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
			<h3>Hot Product</h3>
			<div class="agile_top_brands_grids">
				<div class="col-md-3 top_brand_left">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="tag"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/tag.png', null )); ?> alt=" " class="img-responsive" /></div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block" >
										<div class="snipcart-thumb">
											<a href="single.html"><img title=" " alt=" " src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/1.png', null )); ?> /></a>		
											<p>fortune sunflower oil</p>
											<h4>$7.99 <span>$10.00</span></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<form action="checkout.html" method="post">
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
				<div class="col-md-3 top_brand_left">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block" >
										<div class="snipcart-thumb">
											<a href="single.html"><img title=" " alt=" " src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/3.png', null )); ?> /></a>		
											<p>basmati rise (5 Kg)</p>
											<h4>$11.99 <span>$15.00</span></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="basmati rise" />
													<input type="hidden" name="amount" value="11.99" />
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
				<div class="col-md-3 top_brand_left">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/2.png', null )); ?> alt=" " class="img-responsive" /></a>
											<p>Pepsi soft drink (2 Ltr)</p>
											<h4>$8.00 <span>$10.00</span></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="Pepsi soft drink" />
													<input type="hidden" name="amount" value="8.00" />
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
				<div class="col-md-3 top_brand_left">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid_pos">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/offer.png', null )); ?> alt=" " class="img-responsive" />
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block">
										<div class="snipcart-thumb">
											<a href="single.html"><img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/4.png', null )); ?>  alt=" " class="img-responsive" /></a>
											<p>dogs food (4 Kg)</p>
											<h4>$9.00 <span>$11.00</span></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<form action="#" method="post">
												<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="dogs food" />
													<input type="hidden" name="amount" value="9.00" />
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
<!-- //top-brands -->
 	<?php
 }

 function dbsnet_product_best_seller_v2(){
 	?>
 	<!-- fresh-vegetables -->
	<div class="fresh-vegetables">
		<div class="container">
			<h3>Best Seller Products</h3>
			<div class="w3l_fresh_vegetables_grids">
				<div class="col-md-3 w3l_fresh_vegetables_grid w3l_fresh_vegetables_grid_left">
					<div class="w3l_fresh_vegetables_grid2">
						<ul>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="products.html">All Brands</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="vegetables.html">Vegetables</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="vegetables.html">Fruits</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="drinks.html">Juices</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="pet.html">Pet Food</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="bread.html">Bread & Bakery</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="household.html">Cleaning</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="products.html">Spices</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="products.html">Dry Fruits</a></li>
							<li><i class="fa fa-check" aria-hidden="true"></i><a href="products.html">Dairy Products</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-9 w3l_fresh_vegetables_grid_right">
					<div class="col-md-4 w3l_fresh_vegetables_grid">
						<div class="w3l_fresh_vegetables_grid1">
							<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/8.jpg', null )); ?>  alt=" " class="img-responsive" />
						</div>
					</div>
					<div class="col-md-4 w3l_fresh_vegetables_grid">
						<div class="w3l_fresh_vegetables_grid1">
							<div class="w3l_fresh_vegetables_grid1_rel">
								<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/7.jpg', null )); ?>  alt=" " class="img-responsive" />
								<div class="w3l_fresh_vegetables_grid1_rel_pos">
									<div class="more m1">
										<a href="products.html" class="button--saqui button--round-l button--text-thick" data-text="Shop now">Shop now</a>
									</div>
								</div>
							</div>
						</div>
						<div class="w3l_fresh_vegetables_grid1_bottom">
							<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/10.jpg', null )); ?>  alt=" " class="img-responsive" />
							<div class="w3l_fresh_vegetables_grid1_bottom_pos">
								<h5>Special Offers</h5>
							</div>
						</div>
					</div>
					<div class="col-md-4 w3l_fresh_vegetables_grid">
						<div class="w3l_fresh_vegetables_grid1">
							<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/9.jpg', null )); ?>  alt=" " class="img-responsive" />
						</div>
						<div class="w3l_fresh_vegetables_grid1_bottom">
							<img src=<?php _e(home_url( '/wp-content/themes/storefront-child-theme/assets/images/8.jpg', null )); ?>  alt=" " class="img-responsive" />
						</div>
					</div>
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

function dbsnet_homepage_advertisement(){
	?>
	<div class="kdz--emotion-leiste-wrapper">
        <div class="container-advertisement">
            <div class="box-bundle">
                <img src="https://laguna-onlineshop.de/media/image/24/1a/0e/icon-leistungen_langlebige_produkte.png">
                <div class="box-inhalt">
                    <h1>Langlebige Produkte</h1>
                    <p>Wir achten bei unseren Produkten auf besonders lange Haltbarkeit.</p>
                </div>
            </div>
            <div class="box-bundle">
                <img src="https://laguna-onlineshop.de/media/image/e3/a6/60/icon-leistungen_ohne_giftstoffe.png">
                <div class="box-inhalt">
                    <h1>Ohne Gift- und Schadstoffe</h1>
                    <p>Frei von Schad- und Giftstoffen, BPA-frei und umweltfreundlich.</p>
                </div>
            </div>
            <div class="box-bundle">
                <img src="https://laguna-onlineshop.de/media/image/ba/f0/92/icon-leistungen_gewissenhafte_produktherstellung.png">
                <div class="box-inhalt">
                    <h1>Gewissenhafte Produktherstellung</h1>
                    <p>Bei der Auswahl unserer Produkte achten wir auf faire Arbeitsbedingungen der Hersteller.</p>
                </div>
            </div>
            <div class="box-bundle">
                <img src="https://laguna-onlineshop.de/media/image/05/02/10/icon-leistungen_umweltfreundliche_materialien.png">
                <div class="box-inhalt">
                    <h1>Umweltfreundliche Materialien</h1>
                    <p>Produkte ohne Plastik die helfen Mutter Erde ein Stück nachhaltiger zu gestalten.</p>
                </div>
            </div>
        </div>
    </div>
	<?php
}

function dbsnet_homepage_promotion(){
	?>
	<div class="kdz--emotion-promotion-wrapper" style="background: url(https://laguna-onlineshop.de/media/image/99/32/d9/abeego_bienwachsfolie_startbanner.png); background-repeat: no-repeat; background-size: cover !important; background-position: center center; ">
        <div class="kdz--emotion-promotion-extended-content">
                <p style="position: absolute; bottom: 10px; left: 10px;"><span style="color: #ffffff;">In verschiedenen Größen erhältlich!</span></p>
        </div>
        <div class="kdz--emotion-promotion-inner">
            <div class="kdz--emotion-promotion-headline" style="position: absolute; top: 0; left: 0;background: #535353; margin: 20px 0 0 0; padding: 10px 10px 10px 10px; color: #ffffff">Frisch verpackt ohne Alufolie und Plastik</div>
            <a href="#" target="_self">
	            <div class="kdz--emotion-promotion-action" style="position: absolute; right: 0; bottom: 0; background: #9abf00; margin: 0 20px 20px 20px; padding: 10px 10px 10px 10px; color: #ffffff;">Jetzt kaufen</div>
	        </a>
            <div class="kdz--emotion-promotion-kreis" style="position: absolute; top: 0; right: 0; background: #ffffff; margin: 20px 20px 20px 20px; text-align: center; border-radius: 200px; min-width: 80px; min-height: 80px;">
	            <div class="kdz--emotion-promotion-kreis-oben" style="color: #535254">ab</div>
	            <div class="kdz--emotion-promotion-kreis-unten" style="color: #9abf00">18,95 €</div>
	        </div>
         </div>
    </div>
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