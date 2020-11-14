<!DOCTYPE html>
<html>
	<?php 
	chdir(dirname(__DIR__));
	include_once'include/head.php';
	?>

	<body class="hide-scrollbar-y">
		<?php include_once'include/navbar.php';?>

		<div class="container-fluid">

			<img src="<?php echo ASSETS.'/image/b2.jpg'?>" id="wallpaper">

			<div class="row" style="margin-top: 30px">

				<div class="col-lg-3"></div>

				<div class="col-lg-6" >
					<div id="main" class="center">
						<form action="<?php echo ROOT_URL.'/register'?>" class=" border border-light p-5" id="view-form" method="POST">
							<p class="h4 mb-4 text-center">Register</p>
							<input type="name" name="name" class="form-control mb-4" placeholder="Full Name" value="<?php echo isset($_POST['name'])?$_POST['name']:''?>" required="">
							<span class="error"><?php echo $data['error']['nameError']?></span>
							<input type="email" name="email" class="form-control mb-4" placeholder="Email" value="<?php echo isset($_POST['email'])?$_POST['email']:''?>" required="">
							<span class="error"><?php echo $data['error']['emailError']?></span>
							<input type="password" name="password" class="form-control mb-4" placeholder="Password" value="<?php echo isset($_POST['password'])?$_POST['password']:''?>" required="">
							<span class="error"><?php echo $data['error']['passwordError']?></span>
							<button class="btn btn-info btn-block my-4" type="submit">Submit</button>
						</form>
					</div>
					<p class="text-center">Already registered? <a href="<?php echo ROOT_URL.'/login'?>">Sign in</a></p>
				</div>

				<div class="col-lg-3"></div>
			</div>
		</div>

		<footer class="center" style="position: absolute;bottom: 0;">
			<p class="text-center">&copy;Copyright 2020 - #USAPTAYO. All rights reserved.</p>
		</footer>

		<script src="<?php echo VENDOR.'/bootstrap/js/bootstrap.min.js';?>"></script>
	</body>
</html>