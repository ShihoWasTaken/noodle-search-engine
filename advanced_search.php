<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
	<head>		
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recherche avancée</title>
        <link rel="shortcut icon" href="favicon.png" />
        <!-- JQuery 2 -->
        <script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- Font Awesome -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

		<link href='https://fonts.googleapis.com/css?family=Product+Sans' rel='stylesheet' type='text/css'>
		<link href='css/main.css' rel='stylesheet' type='text/css'>
		<link href='css/search.css' rel='stylesheet' type='text/css'>
		<link href='css/advanced-search.css' rel='stylesheet' type='text/css'>
		<!-- Plug in Pagination -->
		<script src="js/jquery.twbsPagination.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">							
						<div class="logo text-center">
							<span class="blue-letter">N</span><span class="red-letter">o</span><span class="yellow-letter">o</span><span class="blue-letter">d</span><span class="green-letter">l</span><span class="red-letter">e</span>
						</div></a>
				</div>
			</div>
			<!-- /.container-fluid -->
		</nav>
		<div class="container-fluid">
			<div class="ro w">
				<h1 id="advanced-search-title">Recherche avancée</h1>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<hr>
			</div>
		</div>
		<div class="container-fluid form-container">
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal" role="form" method="get" action="advanced_search_process.php">
						<div class="row">
							<div class="col-md-2">
							Trouvez des pages avec…
							</div>
							<div class="col-md-6">
							</div>
							<div class="col-md-4">
							Pour effectuer cette opération dans le champ de recherche
							</div>
						</div>
						<div class="row">
							<label class="control-label col-sm-2" for="allWords">Tous les mots suivants :</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="allWords" name="allWords">
							</div>
							<div class="col-md-4">
							Saisissez les mots importants : <code>terrier</code> <code>tricolore</code>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-sm-2" for="thisWordExactly">Ce mot ou cette expression exact(e) :</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="thisWordExactly" name="thisWordExactly">
							</div>
							<div class="col-md-4">
							Ajoutez des guillemets autour des mots exacts : <code>"terrier"</code>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-sm-2" for="oneOfThisWords">L'un des mots suivants :</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="oneOfThisWords" name="oneOfThisWords">
							</div>
							<div class="col-md-4">
							Saisissez OR entre tous les mots à inclure : <code>miniature OR standard</code>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-sm-2" for="noneOfThisWords">Aucun des mots suivants :</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="noneOfThisWords" name="noneOfThisWords">
							</div>
							<div class="col-md-4">
							Placez un signe - (moins) devant les mots à exclure :  <code>-rongeur, -"Jack Russell"</code>
							</div>
						</div>
						<div class="row">
							<hr>
						</div>
						<div class="row">
							<div class="col-md-2">
								Affinez ensuite la recherche par…
							</div>
							<div class="col-md-6">
							</div>
							<div class="col-md-4">							
							</div>
						</div>
						<div class="row">
							<label class="control-label col-sm-2" for="whereToSearch">Termes apparaissant :</label>
							<div class="col-md-6">
								<select class="form-control" id="whereToSearch" name="whereToSearch" disabled>
									<option>N'importe où dans la page</option>
									<option>Dans le titre de la page</option>
									<option selected>Dans le texte de la page</option>
									<option>Dans l'URL de la page</option>
								</select>
							</div>
							<div class="col-md-4">
							Rechercher des termes dans la page entière, dans le titre d'une page, dans une adresse Web ou dans des liens vers la page recherchée
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-6 text-right">
								<input class="btn btn-primary" type="submit" value="Recherche avancée">
							</div>
							<div class="col-md-4">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>