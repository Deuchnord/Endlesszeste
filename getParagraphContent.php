<?php
	if(!isset($_GET['chap']) || (int) $_GET['chap'] < 1 || !isset($_GET['p']) || (int) $_GET['p'] < 1)
		die('Usage: getParagraphContent.php?chap=&lt;nochap&gt;&amp;p=&lt;noparagraph&gt;');
	
	$chapfile = @fopen('story/chap'.$_GET['chap'].'.txt', 'r');

	if(!$chapfile)
		die('Could not open chapter.');
	
	$line = '';

	for($i = 0; $i <= $_GET['p']; $i++) {

		$line = fgets($chapfile);
		if($line == '')
			$i--;
		else if(preg_match('#^\[\[IP:(.+)\]\]$#', $line))
			$i--;
	}

	echo $line;
