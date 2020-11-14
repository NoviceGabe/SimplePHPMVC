<!DOCTYPE html>

<html>
	<?php 
	chdir(dirname(__DIR__));
	include_once'include/head.php';
	?>
	<body>
		<img src="<?php echo ASSETS.'/image/b2.jpg'?>" id="wallpaper" style="filter: blur(3px);">
		<?php include_once'include/navbar.php';?>

		<div class="container-fluid " style="height: 100%;">
			<div class="row" style="height: 100%">
				<div class="col-lg-12"  style="height: 100%">

					<h1 class="text-center" style="margin-top: 20px">What is Usap Tayo?</h1>
					
					<div class="row section" >
						<div class="col-lg-1"></div>
						<div class="col-lg-3" >
							<img src="<?php echo ASSETS.'/image/b3.png'?>" />
						</div>

						<div class="col-lg-7" >
							<p>Usap Tayo!  is a personal opportunity to receive support and experience growth during challenging times in life. Individual counseling can help one deal with many personal topics in life such as anger, depression, anxiety, substance abuse, marriage and relationship challenges, parenting problems, school difficulties, career changes, etc.
							</p>
						</div>
					</div>

					<div class="row section">
						<div class="col-lg-1"></div>

						<div class="col-lg-5" >
								<img src="<?php echo ASSETS.'/image/b4-nobg.png'?>" height="250" width="430" />
						</div>

						<div class="col-lg-5">
								<h2>COUNSELLING</h2>
								<p>The UK’s NHS website defines counseling as a helping approach that highlights the emotional and intellectual experience of a client, how a client is feeling and what they think about the problem they have sought help for.
								</p>
						</div>
					</div>

					<div class="row section">
						<div class="col-lg-1" ></div>

						<div class="col-lg-5" >
							<img src="<?php echo ASSETS.'/image/b5.png'?>" height="250" width="450"/>
						</div>

						<div class="col-lg-5" >
							<h2>COUNSELLING</h2>
							<P>The counselling process is a continuous, cyclical series of interactions in which the counselor and
							client collaboratively set goals, formulate and implement action plans, and assess progress
							toward the goal(s). Throughout the process, new information is integrated, the counselor-client
							relationship is developed, and progress toward counseling goals is reassessed.</P>
						</div>
					</div>

					<div class="row section">
						<div class="col-lg-1" ></div>
						<div class="col-lg-5" >
							<iframe width="100%" height="300" src="https://www.youtube.com/embed/NQcYZplTXnQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>

						<div class="col-lg-5" >
							<h2>Mental Health</h2>
							<P>Mental health refers to cognitive, behavioral, and emotional well-being.
							It is all about how people think, feel, and behave.
							People sometimes use the term “mental health” to mean the absence of a mental disorder.
							</P>
						</div>
					</div>

					<div class="row section ">
						<div class="col-lg-1" ></div>
						<div class="col-lg-4" >
							<address>
								<strong>#USAP TAYO</strong><br>
								Anonas, Sta. Mesa, Maynila, 1008 Kalakhang Maynila<br>
								<abbr title="Phone">P:</abbr> +63 906-111-6681
							</address>

							<address>
								<strong>Email Us:</strong><br>
								<a href="mailto:#">usaptayo@gmail.com</a>
							</address>
						</div>
						<div class="col-lg-1" ></div>
						<div class="col-lg-4" >
							<p>&nbsp;&nbsp;&nbsp; We appreciate your interest in our  <b>#Usap Tayo</b> website. If you would like to contact us, use the contact information. We will critique your concerns that can expertly attend to your requirements.</p>

							<p>&nbsp;&nbsp;&nbsp; We can't guarantee that all of you will receive an individual response, but rest assured that your submission was collected, and examined. We additionally regret that we can't answer individual medical and pharmaceutical issues through email, If you may have a medical emergency, we advise you to go to your doctor or call  911 immediately.</p> 
						</div>
					</div>
					<div class="row" style="margin-top: 20px; margin-bottom: 100px;">
							<div class="col-lg-12">
									<div class="center">
										<form action="<?php echo ROOT_PATH.'/subscribe'?>" method="POST" class="border border-light p-5 " style="background: #ffffff; width: 40%;">
											<p class="h4 mb-4 text-center">Get our update in your inbox</p>

											<div class="input-group mb-3">
												<input type="email" class="form-control" name="email" required="" value="<?php echo isset($_POST['email'])?$_POST['email']:''?>">
											    <div class="input-group-append">
											    	<button class="btn btn-outline-secondary" type="submit">Submit</button>
											    </div>
											</div>
											 <span class="error"><?php echo $data['error']['emailError']?></span>
										</form>
									</div>
							</div>
						</div>

					<footer class="center">
						<p class="text-center">&copy;Copyright 2020 - #USAPTAYO. All rights reserved.</p>
					</footer>

				</div>
			</div>
		</div>
		
		<script src="<?php echo VENDOR.'/bootstrap/js/bootstrap.min.js';?>"></script>
	</body>
</html>