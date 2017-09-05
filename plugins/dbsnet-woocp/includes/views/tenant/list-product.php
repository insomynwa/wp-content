<?php //var_dump($paramData['product']['list']); ?>
<?php //print_r($paramData['product']['list']); ?>
<?php if(count($paramData['product']['list']) > 0): ?>
<table>
	<thead>
		<td>#</td>
		<td></td>
		<td>Produk</td>
		<td>Outlet</td>
	</thead>
	<?php $num=1; foreach ($paramData['product']['list'] as $item): ?>
	<tr>
		<td><?php echo $num; ?></td>
		<td>
			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'thumbnail' ); ?>
			<?php //echo woocommerce_get_product_thumbnail('shop_catalog'); ?>
			<img src="<?php echo $image[0] ?>" style="max-width: 40px;max-height: 40px" />
		</td>
		<td><?php //var_dump($item); ?>
			<?php echo $item->post_title; ?>
		</td>
		<td>
			<?php echo DBSnet_Woocp_Outlet::Data($item->post_author)->display_name; ?>
		</td>
	</tr>
	<?php $num+=1; endforeach; ?>
</table>
<?php endif; ?>