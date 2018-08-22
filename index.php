<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<title>Efekt paralaksy</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.2.1.js"
  		    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  		    crossorigin="anonymous"></script>

	<script>
		$(document).ready(function() {
			$('body').fadeIn(400, function() {
				$('#subt').fadeIn(500);
				$('#menu').fadeIn(500);
				// $('#menu').css('display', 'block');
			}
			);
		});
	</script>
</head>
<body>
	<div class="bg1"> 
		<div id="logomenu">
			<!-- <div id="logomenu1"> -->
				<div id="logo"><img src="img/foska.png" /></div>
				
				<div id="menucontainer">
					<ul id="menu">
						<li class="choice">
							<div class="choicediv">Start</div>
						</li>
						<li class="choice">
							<a href="animator/index.php">
								<div class="choicediv">Animatorzy</div>
							</a>
						</li>
						<li class="choice">
							<div class="choicediv">Page2</div>
						</li>
						<li class="choice">
							<div class="choicediv">Page3</div>
						</li>
						<li class="choice">
							<a href="logowanie/log.php">
								<div class="choicediv">Zaloguj się</div>
							</a>
						</li>
					</ul>
				</div>
				<div style="clear:both;"></div>
			<!-- </div> -->
		</div>

		<div id="subt">
			Janek
		</div>
	</div>
	<div id="break">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div class="bg2"> </div>
	<div id="break">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div class="bg3"> </div>

</body>
</html>