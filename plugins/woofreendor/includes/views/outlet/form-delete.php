<?php
	$outlet = $paramData['outlet']['object'];

	if(isset($_POST['outlet-submit'])){
		if(! isset( $_POST['dbsnet_delete_outlet_nonce'] ) || ! wp_verify_nonce( $_POST['dbsnet_delete_outlet_nonce'], 'dbsnet_delete_outlet_nonce_action' )){
			echo "proses menghapus gagal";
			return;
		}

		require_once(ABSPATH.'wp-admin/includes/user.php');
		if(wp_delete_user($outlet->ID)){
			echo "berhasil menghapus outlet";
		}
		else{
			echo "gagal menghapus outlet";
		}
	}
	else{
?>
<form id="form-outlet-delete" action="#" method="post">
	<div class="form-group">
		<label for="outlet-name">Outlet:</label>
		<input type="text" readonly="readonly" name="outlet-name" class="form-control" value="<?php if(isset($_POST['outlet-name'])){ echo $_POST['outlet-name'];} else{ echo $outlet->display_name;} ?>">
	</div>
	<div class="form-group">
		<span>Semua produk yang dibuat oleh outlet ini juga akan dihapus.</span>
	</div>
	<?php wp_nonce_field( 'dbsnet_delete_outlet_nonce_action', 'dbsnet_delete_outlet_nonce' ); ?>
	<button type="submit" class="btn btn-danger" name="outlet-submit">Hapus</button>
</form>
<?php
	}
?>
<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet' ?>">Kembali ke daftar outlet</a>