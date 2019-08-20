<?php
	include('./service/callAPI.php');
	include('./functions/createCard.php');
	if(!isset($_GET['page'])){
		$page = 1;
	}else{
		$page = $_GET['page'];
	}
	$response = createCard($page, 10)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Alura Motors</title>

	<style>
		/*Regra para a animacao*/
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		/*Mudando o tamanho do icone de resposta*/
		div.glyphicon {
			color:#6B8E23;
			font-size: 38px;
		}
		/*Classe que mostra a animacao 'spin'*/
		.loader {
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 80px;
			height: 80px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
		}
	</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css" media="all">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script>
		requisitar("https://alura-scraping.herokuapp.com/produtos?_page="+<?=$page?>+"&_limit=10")
	</script>

</head>
<body cz-shortcut-listen="true">
    <noscript>You need to enable JavaScript to run this app.</noscript>
	
	<div class="modal fade" data-backdrop="static" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="loadingModal_label">
						<span class="glyphicon glyphicon-refresh"></span>Aguarde...
					</h5>
				</div>
				<div class="modal-body">
					<div class='alert' role='alert'>
						<center>
							<div class="loader" id="loader"></div><br>
							<h4><b id="loadingModal_content"></b></h4>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div id="root">
		<header>
			<nav class="navbar navbar-inverse" style="margin-bottom: 0;">
				<div class="container" style="margin-bottom: -20px;">
					<div class="navbar">
						<a href="./index" class="navbar-brand" title="Alura Motors">
							<img src="img/alura-logo.svg" class="d-inline-block align-top" alt="Alura">Motors
						</a>
						<ul class="nav navbar-nav" style="margin-top: 35px;">
							<li><a href="./hello-world">Hello World</a></li>
							<li><a href="./index">Anúncios</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		
		<div class="container">
			<h1 class="sub-header">Veículos de Luxo Novos e Usados - Todas as Marcas</h1>
			<div class="row">
				<div class="col-md-12">
					<div class="container" style="width: 100%">
						<div class="type-select"><?php echo $response[1].' veículos encontrados'?></div>
							<div class="container-pagination" style="float: right">
								<span class="info-pages"><?='Página ' . $page . ' de ' . ceil($response[1] / 10)?></span>
							</div>
						</div>
						<div id="container-cards" style="height: 100%">
							<?php echo $response[0]?>
						</div>
						<div class="type-select"><?php echo $response[1].' veículos encontrados'?></div>
							<div class="container-pagination" style="float: right">
								<span class="info-pages"><?='Página ' . $page . ' de ' . ceil($response[1] / 10)?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer>
			<nav class="navbar navbar-inverse">
				<div class="container" style="margin-bottom: 10px;">
					<div class="navbar">
						<a href="./index" class="navbar-brand" title="Alura Motors">
							<img src="img/alura-logo.svg" class="d-inline-block align-top" alt="Alura">Motors
						</a>
						<p style="color: #fff; text-align: center; margin-top: 40px;">Aplicação para treinamento de web scraping</p>
					</div>
				</div>
			</nav>
		</footer>

	</div>
	
</body>
</html>