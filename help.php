<!DOCTYPE html>
<html>
	<head>		
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aide recherche web</title>
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
		<link href='css/help.css' rel='stylesheet' type='text/css'>
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
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<form class="navbar-form navbar-left" role="search" method="get" action="search.php">
	                    <div class="input-group">
	                        <input id="searchbar" name="query" type="text" class="form-control" placeholder="Entrez votre recherche" value="<?php echo $_GET["query"]; ?>" autofocus>
	                        <span class="input-group-btn">	                        
	                        	<button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	                        </span>
	                    </div>
					</form>
				</div>
				<a class="btn btn-red" href="">Recherche avancée</a>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-5 col-md-offset-1">
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<h2>Effectuer une recherche sur Google</h2>
							<p>Some content.</p>
						</div>
						<div id="menu1" class="tab-pane fade">
							<h2>Opérateurs de recherche</h2>
							<p>Vous pouvez utiliser des opérateurs de recherche et des signes de ponctuation pour obtenir des résultats de recherche plus précis. À l'exception des exemples ci-dessous, la plupart des signes de ponctuation ne sont pas pris en compte.</p>
							<h3>Signes de ponctuation et symboles</h3>
							<p>Même si vous pouvez utiliser les signes de ponctuation répertoriés ci-dessous dans vos recherches, les inclure n'améliore pas nécessairement les résultats. Si nous pensons que les signes de ponctuation ne vous permettront pas d'obtenir des résultats plus pertinents, nous vous suggérerons des termes de recherche sans ponctuation.</p>
							<table class="table-responsive table-bordered">
								<thead>
									<tr>
										<th>Symbole</th>
										<th>Utilisation</th>
									<tr>
								</thead>
								<tbody>
									<tr>
										<td class="green">$</td>
										<td>
											<p>Permet de rechercher des prix.
											<br>
											Exemple : <span class="green">nikon $400</span></p>
										</td>
									</tr>
									<tr>
										<td class="green">–</td>
										<td>
											<p>Pour exclure les résultats de recherche incluant un mot ou site précis, précédez ces derniers d'un tiret. Ce caractère est particulièrement utile pour des homonymes tels que "jaguar", qui peut faire référence à la marque de voiture ou à l'animal.
											<br>
											Exemple : <span class="green">vitesse jaguar -voiture</span></p>
										</td>
									</tr>
									<tr>
										<td class="green">"expression"</td>
										<td>
											<p>Si vous mettez des guillemets autour d'un mot ou d'une expression, les résultats n'incluent que les pages où ces mots s'affichent dans le même ordre. N'utilisez les guillemets que si vous souhaitez rechercher un mot ou une expression précise. Dans le cas contraire, vous risqueriez d'exclure des résultats de recherche utiles.
											<br>
											Exemple : <span class="green">"imagine all the people"</span></p>
										</td>
									</tr>
									<tr>
										<td class="green">*</td>
										<td>
											<p>Lorsque vous ne connaissez pas un terme ou que vous n'êtes pas sûr d'un terme dans votre requête, utilisez un astérisque comme substitut.
											<br>
											Exemple : <span class="green">"un * vaut mieux que deux *"</span></p>
										</td>
									</tr>
									<tr>
										<td class="green">..</td>
										<td>
											<p>Utilisez deux points sans espace entre des nombres pour voir les résultats qui contiennent les nombres inclus dans cette plage de valeurs.
											<br>
											Exemple : <span class="green">appareil photo 50 €..100 €</span></p>
										</td>
									</tr>									
								</tbody>
							</table>
							<h3>Opérateurs de recherche</h3>
							<p>Les opérateurs de recherche sont des termes qui vous permettent d'affiner vos résultats de recherche. Vous n'avez pas besoin de les mémoriser. La page <a href="advanced_search.php">Recherche avancée</a> vous permet, elle aussi, d'affiner vos résultats de recherche.</p>
							<table class="table-responsive table-bordered">
								<thead>
									<tr>
										<th>Opérateur</th>
										<th>Utilisation</th>
									<tr>
								</thead>
								<tbody>
									<tr>
										<td class="green">OR</td>
										<td>
											<p>Permet de rechercher des pages qui ne contiennent qu'un terme parmi plusieurs.
											<br>
											Exemple : <span class="green">marathon OR course</span></p>
										</td>
									</tr>		
								</tbody>
							</table>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h2>Recherche avancée</h2>
							<p>Utilisez la page "Recherche avancée" pour affiner les résultats lors de recherches complexes.</p>
							<h3>Effectuer une recherche avancée</h3>
							<ol>
								<li>Rendez-vous sur la page <a href="advanced_search.php">Recherche avancée</a>.</li>
								<li>Saisissez vos termes de recherche dans la section "Trouvez des pages avec".</li>
								<li>Choisissez les filtres à utiliser dans la section "Affinez ensuite la recherche par". Vous pouvez utiliser un ou plusieurs filtres.</li>
								<li>Cliquez sur Recherche avancée.</li>
							</ol>
							<p>Astuce : Vous pouvez également utiliser plusieurs de ces filtres dans le champ de recherche avec des opérateurs de recherche.</p>
						</div>
						<div id="menu3" class="tab-pane fade">
							<h2>Menu 3</h2>
							<p></p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a data-toggle="pill" href="#home">Effectuer une recherche sur Google</a></li>
						<li><a data-toggle="pill"  href="#menu1">Opérateurs de recherche</a></li>
						<li><a data-toggle="pill"  href="#menu2">Recherche avancée</a></li>
						<li><a data-toggle="pill"  href="#menu3">Page de résultats de recherche Google</a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>