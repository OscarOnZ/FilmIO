
<input type="text" id="filmID" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
<button type="button" class="btn btn-primary btn1">Submit</button>
<p id="msg"></p>

<br>
<p> User Likes </p>
<input type="text" id="username" class="form-control" placeholder="username" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
<input type="text" id="filmID2" class="form-control" placeholder="FilmID" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
<button type="button" class="btn btn-primary btn2">Submit</button>
<p id="msg"></p>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.0.0.js"></script>

<script>

$('.btn1').click(function() {
	var count = 0;
	 $.ajax({
	  type: "POST",
	  url: "addFilm2.php",
	  data: { filmID: document.getElementById("filmID").value}
	}).success(function() {
	});    
		$('msg').innerHTML = "Done" + count + result;
		count++;
	    });

$('.btn2').click(function() {
	var count = 0;
	 $.ajax({
	  type: "POST",
	  url: "addFilm2.php",
	  data: { username: document.getElementById("username").value ,filmID: document.getElementById("filmID2").value}
	}).success(function() {
	});    
		$('msg').innerHTML = "Done" + count + result;
		count++;
	    });

</script>