<?php 
	session_start();

	$args = array();
	$query = $_GET['allWords'] . ' '  . '"' . $_GET['thisWordExactly'] . '"' ;
	if(isset($_GET['allWords']))
	{
		if($_GET['allWords'] != "")
		{
			$args[] = $_GET['allWords'];
		}
	}
	if(isset($_GET['thisWordExactly']))
	{
		if($_GET['thisWordExactly'] != "")
		{
			$exploded = explode(',',$_GET['thisWordExactly']);
			$thisWordExactly = array();
			foreach($exploded as $token)
			{
				$thisWordExactly[] = '"' . trim($token) . '"';
			}
			$args[] = join(' ', $thisWordExactly);
		}
	}
	if(isset($_GET['oneOfThisWords']))
	{
		$args[] = join(' OR ', explode(' ',$_GET['oneOfThisWords']));
	}
	if(isset($_GET['noneOfThisWords']))
	{
		if($_GET['noneOfThisWords'] != "")
		{
			$exploded = explode(',',$_GET['noneOfThisWords']);
			$noneOfThisWords = array();
			foreach($exploded as $token)
			{
				$nbWords = count(explode(' ',$token));
				if($nbWords > 1)
					$noneOfThisWords[] = '-"' . trim($token) . '"';
				else
					$noneOfThisWords[] = '-' . trim($token);
			}
			$args[] = join(' ', $noneOfThisWords);
		}

	}
	$query = join(' ',$args);

	//echo $query;
	//exit();

	$_SESSION['query'] = $query;
	header('Location: query_parsing.php?query=' . $query); 