<?php 
	ini_set("memory_limit","2048M");
	define('MAX_RESULT_PER_PAGE', 6);
	session_start();

	require 'classes/Result.php';

	// Parsing de la query
	//echo $_GET['query'];	
	//exit();
	$args = array();
	if(isset($_GET['nw']))
		$args['nw'] = $_GET['nw'];
	if(isset($_GET['cw']))
		$args['cw'] = $_GET['cw'];
	if(isset($_GET['nwtr']))
		$args['nwtr'] = $_GET['nwtr'];
	if(isset($_GET['cwtr']))
		$args['cwtr'] = $_GET['cwtr'];
	if(isset($_GET['ow']))
		$args['ow'] = $_GET['ow'];
	foreach($args as $key => $value)
	{
		$arguments[] = $key . '=' . $value;
	}

	//echo './query-manager.py ' . join(' ', $arguments);
	//exit();
	system('./query-manager.py ' . join(' ', $arguments));




	$results = array();
	// Fichier documents
	$handle = fopen("output/documentPerFile.txt", "r");
	if ($handle) 
	{
		$fileOfDocument = array();
	    while (($line = fgets($handle)) !== false) 
	    {
	        // process the line read.
	        $splitted = explode("|", $line);
	        $fileOfDocument[trim($splitted[0])] = trim($splitted[1]);
	    }
	    fclose($handle);
	} 
	else 
	{
		echo "Erreur à la lecture du fichier de documents par fichier";
		exit();
	}

	// Résumé documents
	$handle = fopen("output/documentAbstract.txt", "r");
	if ($handle) 
	{
		$abstracts = array();
	    while (($line = fgets($handle)) !== false) 
	    {
	        // process the line read.
	        $splitted = explode("|", $line);
	        $abstracts[trim($splitted[0])] = trim($splitted[1]);
	    }
	    fclose($handle);
	} 
	else 
	{
		echo "Erreur à la lecture du fichier de résumés";
		exit();
	}

	// Résultats recherche
	$handle = fopen("output/results.txt", "r");
	if ($handle) 
	{
	    while (($line = fgets($handle)) !== false) 
	    {
	        // process the line read.
	        $splitted = explode("|", $line);
	        $results[] = new Result(trim($splitted[0]), $fileOfDocument[trim($splitted[0])], $abstracts[trim($splitted[0])] . '...', $splitted[1]);
	    }
	    fclose($handle);
	    // Tri du tableau par TFIDF
	    /* DEBUG TRI
		foreach($results as $result)
		{
			echo "Nom = " . $result->getTitle() . " | TFIDF = " . $result->getTFIDF() . '<br>';
		}
		exit();
		*/
	} 
	else 
	{
		echo "Erreur à la lecture du fichier de résultats";
		exit();
	}

	// Positions mots
	$handle = fopen("output/indexedStem.txt", "r");
	if ($handle) 
	{
		// $positions[stem][document][position]
		$positions = array();
	    while (($line = fgets($handle)) !== false) 
	    {
	        // process the line read.
	        $splittedLine = explode("|", $line);
	        $splittedReferences = explode(" ", trim($splittedLine[1]));	
	        foreach($splittedReferences as $reference)
	        {
	        	$splittedPositionInfos = explode(":", $reference);	
	        	//echo $splittedPositionInfos[0] . " + " . $splittedPositionInfos[1] . '<br>';
	        	if(!isset($positions[trim($splittedLine[0])]))
	        	{
	        		$positions[trim($splittedLine[0])] = array();
	        	}
        		if(!isset($positions[trim($splittedLine[0])][$splittedPositionInfos[0]]))
        		{
        			$positions[trim($splittedLine[0])][$splittedPositionInfos[0]] = array();
        		}
        		array_push($positions[trim($splittedLine[0])][$splittedPositionInfos[0]], $splittedPositionInfos[1]);
	        }        
	    }
	    fclose($handle);
	} 
	else 
	{
		echo "Erreur à la lecture du fichier de positions";
		exit();
	}
	
/*
	// Debug
	foreach($positions as $keyPos => $valuePos)
	{
		echo "Le mot " . $keyPos . " est présent dans:<br>";
		foreach($positions[$keyPos] as $key1 => $value1)
		{
			echo "- le document " . $key1 . " aux positions {";
			echo join(",",$value1);
			echo '}<br>';
		}
		echo '<br>';
	}

	exit();
	*/
 ?>
<!DOCTYPE html>
<html>
	<head>		
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Résultats de la recherche</title>        
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
					<form class="navbar-form navbar-left" role="search" method="get" action="query_parsing.php">
	                    <div class="input-group">
	                        <input id="searchbar" name="query" type="text" class="form-control" placeholder="Entrez votre recherche" value="<?php echo htmlspecialchars($_SESSION['query']); ?>" autofocus>
	                        <span class="input-group-btn">	                        
	                        	<button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	                        </span>
	                    </div>
					</form>
					<p class="navbar-text navbar-right">
						<a class="btn btn-red" href="advanced_search.php">Recherche avancée</a>
						<a class="btn btn-red" href="help.php" id="help-link" title="Aide"><i class="fa fa-question-circle" aria-hidden="true" id="help-link-icon"></i></a>
					</p>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php echo "Environ " . count($results) . " résultats (" . round(( microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),6) . " secondes)"; ?>
				</div>
			</div>
			<div id="paginated-results"></div>
			<div id="hidden-results" class="hidden">	
				<?php
					foreach($results as $result)
					{
						echo "<div class='row result'>";
							echo "<div class='col-md-12'>";
								echo "<a target=\"_blank\" href=\"data/" . $result->getFilename() . "\"><h3 class='result-title'>" . $result->getTitle() . "</h3></a>";
								echo "<div class='result-link'>" . $result->getFilename() . "</div>";
								echo "<div class='result-summary'>" . $result->getSummary() . "</div>";
							echo "</div>";
						echo "</div>";
					}
				?>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<ul id="pagination-demo" class="pagination-lg"></ul>
				</div>
			</div>
		</div>
		<script>
			$( document ).ready(function() {
			    var retrievePaginatedResult = function(page) {
			    	var results = "";
			    	var debut = <?php echo MAX_RESULT_PER_PAGE; ?>*(page-1)-1;
			    	var fin = <?php echo MAX_RESULT_PER_PAGE; ?>*(page-1)+<?php echo MAX_RESULT_PER_PAGE; ?>-1;
			    	$('#hidden-results').children().each(function(index, element) {
			    		if( (index > debut) && (index <= fin))
			    			results += $(this).html();
					});
		     		//var results =  $('#hidden-results').html();
		            return results;

			     };
				// Initialisation du plugin de pagination
    		    $('#pagination-demo').twbsPagination({
			        totalPages: <?php echo ceil(count($results)/MAX_RESULT_PER_PAGE); ?>,
			        visiblePages: 8,
			        first: 'Première page',
			        last: 'Dernière page',
			        prev: false,
			        next: false,
			        onPageClick: function (event, page) {
			            $('#paginated-results').html(retrievePaginatedResult(page));
			        }
			    });
			});
		</script>
	</body>
</html>