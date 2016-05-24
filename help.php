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
							<h3>HOME</h3>
							<p>Some content.</p>
						</div>
						<div id="menu1" class="tab-pane fade">
							<h3>Menu 1</h3>
							<p>Some content in menu 1.</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Menu 2</h3>
							<p>Some content in menu 2.</p>
						</div>
						<div id="menu3" class="tab-pane fade">
							<h3>Menu 3</h3>
							<p>Some content in menu 3.</p>
						</div>
					</div>
					<h2>Opérateurs de recherche</h2>
				</div>
				<div class="col-md-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a data-toggle="pill" href="#home">Home</a></li>
						<li><a data-toggle="pill"  href="#menu1">Menu 1</a></li>
						<li><a data-toggle="pill"  href="#menu2">Menu 2</a></li>
						<li><a data-toggle="pill"  href="#menu3">Menu 3</a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>