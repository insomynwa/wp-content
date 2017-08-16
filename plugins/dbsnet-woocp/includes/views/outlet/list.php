<?php //var_dump($paramData); ?>
<?php if($paramData['list']): ?>
<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet-new' ?>">Tambah Outlet</a>
<table>
	<thead>
		<td>#</td>
		<td>Outlet</td>
		<td>Email</td>
	</thead>
	<?php $num=1; foreach ($paramData['list'] as $item): ?>
	<tr>
		<td><?php echo $num; ?></td>
		<td>
			<div>
				<a href="#"><?php echo $item->display_name ?></a>
			</div>
			<div>
				<a href="#">Edit</a> | 
				<a href="#">Hapus</a>
			</div>
		</td>
		<td><?php echo $item->user_email; ?></td>
	</tr>
	<?php $num+=1; endforeach; ?>
</table>
<?php endif; ?>