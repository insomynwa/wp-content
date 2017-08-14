<ul>
	<?php foreach($products as $product):?>
	<li><?php _e($product->post_title); ?></li>
	<?php endforeach; ?>
</ul>