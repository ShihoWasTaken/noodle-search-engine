<?php 
	session_start();

	// Parsing de la query
	echo "Query = " . $_GET['query'] . '<br>';	
	echo '<br>';

	$normalWordsToRemove = array();
	$composedWordsToRemove = array();
	$normalWords = array();
	$composedWords = array();
	$orWords = array();


	// D'abord on split par les OR
	$words = split(' ', $_GET['query']);

	$into_quote = false;
	$into_minus_quote = false;
	$last_word = null;
	$word_to_add_to_OR = false;
	foreach($words as $word)
	{
		$first_letter = substr($word, 0, 1);
		$second_letter = substr($word, 1, 1);
		$last_letter = substr($word, -1);

		if($word_to_add_to_OR)
		{
			if(!in_array($last_word, $orWords))
				$orWords[] = $word;
			$word_to_add_to_OR = false;
		}
		else
		{
			switch($first_letter)
			{
				case '-':
					if($second_letter == '"')
					{
						echo "commence par un guillemet (moins) | ";
						$composed = array(substr($word, 2));
						$into_minus_quote = true;
					}
					else
					{
						echo "commence par un - | ";
						$normalWordsToRemove[] = substr($word, 1);
					}
				break;
				case '"':
					echo "commence par un guillemet | ";
					$into_quote = true;
					$composed = array(substr($word, 1));
				break;
				case 'O':
					if($word == 'OR')
					{
						if(!in_array($last_word, $orWords))
						{
							unset($normalWords[array_search($last_word ,$normalWords)]);
							$orWords[] = $last_word;
						}
						$word_to_add_to_OR = true;
						echo "c'est un OU | ";
					}
				break;
				default:
					if( ($last_letter == '"') && (!$into_minus_quote))
					{
						echo "Fini par un guillemet | ";
						$composed[] = substr($word, 0, -1);
						$composedWords[] = $composed;
						$into_quote = false;
					}
					else if($into_quote)
					{
						echo "Mot dans un guillemet | ";
						$composed[] = $word;
					}
					else if( ($last_letter == '"') && ($into_minus_quote))
					{
						echo "Fini par un guillemet (moins) | ";
						$composed[] = substr($word, 0, -1);
						$composedWordsToRemove[] = $composed;
						$into_minus_quote = false;
					}
					else if($into_minus_quote)
					{
						$composed[] = $word;
						echo "Mot dans un guillemet (moins) | ";
					}
					else
					{
						$normalWords[] = $word;
						echo "mot normal | ";
					}
				break;
			}
		}


		echo "Word = " . $word . '<br>';	
		$last_word = $word;
	}

	echo "NORMAL WORDS:" . "<br>";
	foreach($normalWords as $word)
	{
		echo $word . "<br>";
	}
	echo "COMPOSED WORDS:" . "<br>";
	foreach($composedWords as $composed)
	{
		echo '"';
		echo join(' ', $composed);
		echo '"<br>';
	}
	echo "NORMAL WORDS TO REMOVE:" . "<br>";
	foreach($normalWordsToRemove as $word)
	{
	echo $word . "<br>";
	}
		echo "COMPOSED WORDS TO REMOVE:" . "<br>";
	foreach($composedWordsToRemove as $composed)
	{
		echo '"';
		echo join(' ', $composed);
		echo '"<br>';
	}
	echo "ORWORDS:" . "<br>";
	foreach($orWords as $or)
	{
		echo $or . "<br>";
	}

	//exit();

	$args[] = 'nw=' . join(' ', $normalWords);
	if(count($composedWords) > 0)
	{
		foreach($composedWords as $cw)
		{
			$temp_args[] = '"' . join(' ',$cw) . '"';
		}
		$args[] = 'cw=' . join('',$temp_args); 
	}
	$args[] = 'nwtr=' . join(' ', $normalWordsToRemove);
	if(count($composedWordsToRemove) > 0)
	{
		foreach($composedWordsToRemove as $cw)
		{
			$temp_args[] = '"' . join(' ',$cw) . '"';
		}
		$args[] = 'cwtr=' . join('',$temp_args); 
	}
	$args[] = 'ow=' . join(' ', $orWords);

	//system('./query-manager.py ' . $_GET['query']);
	$_SESSION['query'] = $_GET['query'];
	header('Location: search.php?' . join('&',$args)); 