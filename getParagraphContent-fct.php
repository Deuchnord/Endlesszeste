<?php
function getParagraphContent($chap, $paragraph)
{
	$chapfile = @fopen('story/chap'.$chap.'.txt', 'r');

	if(!$chapfile)
		die('Could not open chapter.');
	
	$line = '';

	for($i = 0; $i <= $paragraph; $i++) {

		$line = fgets($chapfile);
		if($line == '')
			$i--;
		else if(preg_match('#^\[\[IP:(.+)\]\]$#', $line))
			$i--;
	}

	return $line;
}
