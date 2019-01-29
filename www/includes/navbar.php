<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 17/01/2019
 * Time: 14:05
 */
?>
<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark"> <!--<Navbar>-->

<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2"><!-- Left -->
	<ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a class="nav-link" href="../index.php"><span class="fas fa-film"></span> Your Recommendations</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="../TopFilms.php"><span class="fas fa-newspaper"></span> Top Films</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="../requests.php"><span class="fas fa-user"></span> Friends</a>
		</li>
	</ul>
</div>
<div class="mx-auto order-0"> <!-- Middle -->
	<a class="navbar-brand mx-auto" href="index.php">
		FilmIO
	  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
			<span class="navbar-toggler-icon"></span>
		</button>

</div>
<div class="navbar-collapse collapse w-100 order-3 dual-collapse2"> <!-- Right -->

	<ul class="navbar-nav ml-auto">
		<form class="form-inline my-2 my-lg-0" action="../searchBar.php" method="GET">
		  <input class="form-control mr-sm-2" type="search" name="text" placeholder="Find a film or friend" aria-label="Search"">
		  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>

	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <?php echo $_SESSION['thisUser']->getFullName();?>
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="/viewUser.php?username=<?php echo $_SESSION['thisUser']->getUsername(); ?>">My Profile</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="#">Settings</a>
		  <a class="dropdown-item" href="../logout.php">Log Out</a>
		</div>
	  </li>




	</ul>
</div>
</nav> <!-- </Navbar> -->