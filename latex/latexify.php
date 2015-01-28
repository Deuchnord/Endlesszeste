<?php
    $chap = 0;
    if(isset($_GET['chap']) && (int)$_GET['chap'] >= 1)
	    $chap = $_GET['chap'];

    if($chap == 0)
    {
	    header('Content-Type: text/plain');
	    die("Missing required argument.\nUsage: latexify?chap=<no_chap>");
    }
    
    function normalizeText($text, $firstLetter)
    {
	    require_once '../class/LaTeXTextNormalizer.class.php';
	    $normalizer = new LaTeXTextNormalizer();

	    return $normalizer->normalize($text);
    }
    
    $nbParticipants = 0;
    $ip = array();
    
    $chapfile = @fopen('../story/chap'.$chap.'.txt', 'r');
    $dontParseLine = false;
    
    if($chapfile)
    {
	    header('Content-Type: text/x-tex');

        $text = "";
        $title = true;
	$firstLetter = true;
	$inDialog = false;
        do
        {
            $text = fgets($chapfile);
            if($text != "")
	    {
                if($title)
                    echo '\chapter{'.str_replace("\n", '', $text).'}'."\n\n";
                
                else if(preg_match("#^\\[\\[IP:(.+)\\]\\]$#", $text, $match))
                {
                    $alreadyInArray = false;
                    for($pos = 0;$pos < count($ip); $pos++)
                        if($ip[$pos] == $match[1])
                            $alreadyInArray = true;
                            
                    if(!$alreadyInArray)
                        $ip[count($ip)] = $match[1];
                }
                else if($text == "[[DONT_PARSE]]\n")
                    $dontParseLine = false;
                
                else if($text != "\n")
                {
                    if(!$dontParseLine)
                        $text = normalizeText($text, $firstLetter)."\n";
                    else
                        $dontParseLine = false;
                    if($firstLetter) {
			    $text = preg_replace('#^[^a-z]+#i', '', $text);
			    $text = preg_replace('#^([a-z]\'?)#i', '\lettrine{$1}{}', $text);
    			    echo $text;
		    }
		    else if(preg_match('#^- (.+)#', $text, $match))
		    {
			    if(!$inDialog)
			    {
				    echo '\begin{itemize}'."\n";
				    $inDialog = true;
			    }
			    
			    echo "\t\\item ".$match[1];
		    }
		    else
		    {
			    if($inDialog)
			    {
				    echo '\end{itemize}'."\n\n";
				    $inDialog = false;
			    }

			    echo $text;
		    }

		    echo "\n";
                    
                    $firstLetter = false;
                }
                
                $title = false;
            }
            
	} while($text);

	if($inDialog)
	{
		echo '\end{itemize}';
		$inDialog = false;
	}
    }
    else
    {
	    header('Content-Type: text/plain');
	    die('No such chapter');
    }
