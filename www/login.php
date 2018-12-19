<?php
require_once( $_SERVER['DOCUMENT_ROOT']. "/www/includes/functions.php");
if(loginCheck()){
    header("Location: /index.php");
}
?>
<!doctype html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FilmIO</title>
<link href="css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
	<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark"> <!--<Navbar>-->

<div class="mx-auto order-0"> <!-- Middle --> 
	<a class="navbar-brand mx-auto" href="#">
		FilmIO
	  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
			<span class="navbar-toggler-icon"></span>
		</button>

</div>

</nav> <!-- </Navbar> -->

	
	
	<div class="container-fluid " style="padding-top: 70px;">
	<div class="row">
		<?php if(isset($_GET['success']) && $_GET['success'] == 1){
		      echo'<div class="alert alert-success" role="alert">
            			        You\'ve signed up! Please now sign in.
            			        </div>';
		      
		}else if(isset($_GET['error']) && $_GET['error'] == 'inputInc'){
		    
		    echo'<div class="alert alert-danger" role="alert">
            			        Them details don\'t seem correct. Please double check them!
            			        </div>';
		    
		}

		
		
		?>
	
	</div>
		
		
		<div class="row">
			<div class="col-6">
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
			<h1 class="display-6">Welcome to FilmIO!</h1>
			<p class="lead">The site to find new films from your friends.</p>
			  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
                  Sign Up
              </button>
		  </div>
		</div>
		</div>
		<div class="col-md-6">
		<div class="card card-outline-secondary">
                        <div class="card-header">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="includes/doLogin.php">
                                <div class="form-group">
                                    <label for="email">Username</label>
                                    <input type="text" class="form-control" name="Luname" id="Luname" required></div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="Lpass" id="Lpass" required autocomplete="new-password"/>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" >Login</button>
                            </form>
                        </div>
                        <!--/card-body-->
                    </div>
                    <!-- /form card login -->
		</div>
		</div>
	</div>
	
		<!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center" id="registerModalLabel">Sign Up</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            			<?php 
            			if(isset($_GET['error'])){
            			    if($_GET['error'] == 'blankField'){
            			        
            			        echo'<div class="alert alert-warning" role="alert">
            			        Please complete all fields.
            			        </div>';
            			    }
            			    else if($_GET['error'] == 'usernameTaken'){
            			        echo '<div class="alert alert-warning" role="alert">
            			        Username taken. Please choose another one.</div>';
            			    }
            			    else if($_GET['error'] == 'matchPW'){
            			        echo '<div class="alert alert-warning" role="alert">
            			        Please check your passwords match.
            			        </div>';
            			    }
            			    else if($_GET['error'] == 'weakPW'){
            			        echo '<div class="alert alert-warning" role="alert">
            			        Please use a more secure password.</div>';
            			    }else if($_GET['error'] != 'inputInc'){
            			        echo '<div class="alert alert-danger" role="alert">
            			        There has been an error.</div>';
            			    }
            			}
            			
            			
            			?>
            			<form class="form-horizontal" method="post" action="includes/db_create_user.php">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="rfullName" id="rfullName"  placeholder="Enter your Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remail" id="remail"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="rusername" id="rusername"  placeholder="Enter your Username"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="rdob" class="cols-sm-2 control-label">Date Of Birth</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="rdob" id="rdob"  placeholder="dd/mm/yyyy"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" name="rpassword" id="rpassword"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" name="rconfirm" id="rconfirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block" >Register</button>
						</div>
					</form>
            
            
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
	
	<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
    
    
	<?php 		if(isset($_GET['error']) && $_GET['error'] != "inputInc"){
		    echo ' <script type="text/javascript">
                        $(window).on("load",function(){
                            $("#registerModal").modal("show");
                        });
                    </script>';
		}?>
</body>
</html>
