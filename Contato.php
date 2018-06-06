<?php
	include('include/config.php');
	include('include/general_security.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TL Concursos | Ensinando para o futuro | Ensinando para o futuro</title>

		<link rel="shortcut icon" href="img/favicon.png">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/footer.css" rel="stylesheet">
		<link href="css/font-awesome.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
				
		<style>
				#map {
				width: 500px;
				height: 400px;
				background-color: #CCC;
				float: right;
				}
				
				div.contato_left{
					
					float: left;
				}
				
				.contato_page_header{
					padding-bottom: 9px;
					margin: 40px 0 20px;
					border-bottom: 1px solid #eee;
				}
				
				
				
		</style>
		
		<script src="js/map.js"></script>
		
		<script>
			function initialize() {
				var myLatLng = {lat: -26.289096, lng: -48.812525};
				var mapCanvas = document.getElementById('map');
				var mapOptions = {
					center: myLatLng,
					zoom: 18,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				var map = new google.maps.Map(mapCanvas, mapOptions);
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				title: 'TL CONCURSOS'
				});
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
				
	</head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="contato_page_header">
				<h2>Contato & SAC</h2>
			</div>
			
				<ol class="breadcrumb">
			
					<li><a href="home">TL Concursos</a></li>
					<li class="active">Contato & SAC</li>
						
				</ol>
				
			
				<p style="font-size: 17px;" class="text-justify"><br>		
					
					<div class="row">
			
						<div class="contato_left">
							
								<div class="contato_left">
								
									<img class="media-object" src="img/Phone.png" style="width: 60px; height: 60px"><br><font style="font-size: 20px; font-family: Times New Roman"> (47) 9647-7447 / (47) 3433-2701</font>
								
									<hr>
								
									<img class="media-object" src="img/Email.png" style="width: 60px; height: 60px"><br><font style="font-size: 20px; font-family: Times New Roman"> tlconcursos@geral.com / tlconcursos@suporte.com</font>
								
									<hr>
								
									<img class="media-object" src="img/Address.png" style="width: 60px; height: 60px"><br><font style="font-size: 20px; font-family: Times New Roman"> Rua Albano Schimidt 580, Boa Vista - Joinville, SC.</font>
								
									<hr>

								</div>			
				
						</div>
					
						<div id="map">
				
					</div>
			
				</p>
								
			</div>
			
			
		</div>

	<?php include('include/footer.php'); ?>   

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	
	</body>
</html>