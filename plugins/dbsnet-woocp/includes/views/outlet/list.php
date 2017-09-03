<?php //var_dump($paramData); ?>
<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet-new' ?>">Tambah Outlet</a>
<?php if($paramData['list']): ?>
<table>
	<thead>
		<td>#</td>
		<td>Outlet</td>
		<td>Username</td>
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
				<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet-update' ?>&outlet=<?php echo $item->ID ?>">Edit</a> | 
				<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet-delete' ?>&outlet=<?php echo $item->ID ?>">Hapus</a>
			</div>
		</td>
		<td><?php echo $item->user_login; ?></td>
		<td><?php echo $item->user_email; ?></td>
	</tr>
	<?php $num+=1; endforeach; ?>
</table>
<?php endif; ?>