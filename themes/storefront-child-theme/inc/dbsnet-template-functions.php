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
		</div>
	</nav>
	<?php
}