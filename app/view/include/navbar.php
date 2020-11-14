<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" style="z-index: 2; position: relative;">
  	<a class="navbar-brand " href="<?php echo ROOT_PATH.'/user/'?>">
  		<span class="text-success">#USAP</span>
  		 <span>TAYO</span></a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
  		<span class="navbar-toggler-icon"></span>
  	</button>
  	<div class="collapse navbar-collapse" id="navbarNav">
  		<ul class="navbar-nav ml-auto">
  			<?php
  				use app\helper;

  				helper\SessionManager::start();
				if(!helper\SessionManager::has('id')){
					include_once'listItemGroup1.php';
				}else{
					include_once'listItemGroup2.php';
				}
  			?>
		</ul>
  	</div>
</nav>