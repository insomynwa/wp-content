<?php
	$outlet = $paramData['outlet']['object'];
	//var_dump($outlet->user_pass);
	if(isset($_POST['outlet-submit'])){
		$email = sanitize_text_field($_POST['outlet-email']);
		$password = sanitize_text_field($_POST['outlet-password']);

		$message = "";
		$status = true;
		$outlet_data = array();
		$outlet_data['ID'] = $outlet->ID;

		$status_dif = false;
		if(!empty($email) && !is_null($email) && !(strlen($email) < 6) && ($email != $outlet->user_email)){
			$status_dif = true;
			$outlet_data['user_email'] = $email;
		}
		if(!empty($password) && !is_null($password) && !(strlen($password) < 5) && wp_check_password( $password, $outlet->user_pass) ){
			$status_dif = true;
			$outlet_data['user_pass'] = $password;
		}

		if($status_dif){
			$updated_outlet_id = wp_update_user($outlet_data);
			if($updated_outlet_id){
				//update_user_meta($new_outlet_id,'binder_group',$_POST['outlet-group']);
				$message = "berhasil update outlet";
			}
			else{
				$message = "gagal update outlet";
			}
		}
	}
?>

<form id="form-outlet-update" action="#" method="post">
	<div>
		<?php if(isset($message)) echo $message; ?>
	</div>
	<div>
		<label for="outlet-username">Username: <?php echo $outlet->user_login; ?></label>
	</div>
	<div>
		<label for="outlet-email">Email:</label>
		<input type="email" name="outlet-email" placeholder="email outlet" value="<?php if(isset($_POST['outlet-email'])){ echo $_POST['outlet-email'];} else{ echo $outlet->user_email;} ?>">
	</div>
	<div>
		<label for="outlet-password">Password Baru:</label>
		<input type="password" name="outlet-password">
	</div>
	<div>
		<input type="hidden" name="group-id" value="<?php echo $paramData['outlet']['group']; ?>">
		<input type="submit" name="outlet-submit" value="Simpan">
	</div>
</form>
<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet' ?>">Kembali ke daftar outlet</a>