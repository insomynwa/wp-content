<?php
	if(isset($_POST['outlet-submit'])){
		$username = sanitize_text_field($_POST['outlet-username']);
		$email = sanitize_text_field($_POST['outlet-email']);
		$password = sanitize_text_field($_POST['outlet-password']);

		$message = "";
		$status = true;

		if(empty($username) || is_null($username)){
			$message .= "<p>username harus diisi</p>";
			$status = false;
		}
		if(empty($email) || is_null($email)){
			$message .= "<p>email harus diisi</p>";
			$status = false;
		}
		if(empty($password) || is_null($password)){
			$message .= "<p>password harus diisi</p>";
			$status = false;
		}
		if($status){
			if(username_exists($username)){
				$message .= "<p>username telah digunakan</p>";
				$status = false;
			}
			if(strlen($username) < 6){
				$message .= "<p>username minimal enam karakter</p>";
				$status = false;
			}
			if(email_exists($email)){
				$message .= "<p>email telah digunakan</p>";
				$status = false;
			}
			if(strlen($email) < 6){
				$message .= "<p>isikan email dengah benar</p>";
				$status = false;
			}
			if(strlen($password) < 5){
				$message .= "<p>password minimal enam karakter</p>";
				$status = false;
			}
			if($status){
				//$password = wp_hash_password( $password );

				$outlet_data = array(
					'user_login'	=> $username,
					'user_pass'		=> $password,
					'user_email'	=> $email,
					'role'			=> 'outlet_role',
					'display_name'	=> ucfirst($username)
					);

				$new_outlet_id = wp_insert_user($outlet_data);
				if($new_outlet_id){
					//update_user_meta($new_outlet_id,'binder_group',$_POST['outlet-group']);
					$message = "berhasil membuat outlet baru";
				}else{
					$message = "gagal membuat outlet baru";
				}
			}
		}
	}
?>

<form id="form-outlet" action="#" method="post">
	<div>
		<?php if(isset($message)) echo $message; ?>
	</div>
	<div>
		<label for="outlet-username">Username:</label>
		<input type="text" name="outlet-username" placeholder="username outlet">
	</div>
	<div>
		<label for="outlet-email">Email:</label>
		<input type="email" name="outlet-email" placeholder="email outlet">
	</div>
	<div>
		<label for="outlet-password">Password:</label>
		<input type="password" name="outlet-password">
	</div>
	<div>
		<input type="hidden" name="group-id" value="<?php echo $paramData['outlet']['group']; ?>">
		<input type="submit" name="outlet-submit" value="Tambah">
	</div>
</form>
<a href="<?php echo admin_url().'admin.php?page=dbsnet-outlet' ?>">Kembali ke daftar outlet</a>