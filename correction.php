<?php
    $chap = 1;
    if(isset($_GET['chap']) && (int)$_GET['chap'] >= 1)
        $chap = $_GET['chap'];

    $correctionMode = true;
    
    //if(!file_exists("story/chap".$chap-1 .".txt"))
        //header('Location: /chapitre-'.$chap-1);

    $cryptinstall="./crypt/cryptographp.fct.php";
    require $cryptinstall;
    
    function normalizeText($text, $firstLetter)
    {
	    require_once 'class/HTMLTextNormalizer.class.php';
	    $normalizer = new HTMLTextNormalizer();

	    return $normalizer->normalize($text);
    }
    
    $nbParticipants = 0;
    $ip = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Un Zeste sans Fin</title>
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="/book.css" />
        <link rel="shortcut icon" type="image/png" href="/favicon-clem.png">
	<style type="text/css">
		.parEdit {
			color: inherit;
		}
		.parEdit:hover {
			color: inherit;
			text-decoration: none;
			background: #5bc0de;
			cursor: pointer;
		}
	</style>
    </head>
    <body>

<div class="container">
    <header class="page-header">
        <img src="/clem.png" alt="" style="float:left;height:64px" />
        <h1>Un Zeste sans Fin</h1>
    </header>
<?php include 'menu.php';?>
    <div class="row chapter-content">
        <div class="col-md-12">
<?php
    $chapfile = @fopen('story/chap'.$chap.'.txt', 'r');
    $dontParseLine = false;
    
    if($chapfile)
    {
        $text = "";
        $title = true;
        $firstLetter = true;
	$noParagraph = 0;
        do
        {
            $text = fgets($chapfile);
            if($text != "")
            {
	    	$noParagraph++;
                if($title) {
                    echo "<h2>Chapitre $chap&nbsp;: $text</h2>";
		    $noParagraph--;
		}
                
                else if(preg_match("#^\\[\\[IP:(.+)\\]\\]$#", $text, $match))
                {
		    $noParagraph--;
                    $alreadyInArray = false;
                    for($pos = 0;$pos < count($ip); $pos++)
                        if($ip[$pos] == $match[1])
                            $alreadyInArray = true;
                            
                    if(!$alreadyInArray)
                        $ip[count($ip)] = $match[1];
                }
		
		else if($text == "[[DONT_PARSE]]\n")
                    $dontParseLine = true;
                
                else
                {
			if(!$normalizeText)
	                    $text = normalizeText($text, $firstLetter);
                    if($firstLetter) {
			$text = preg_replace('#^[^a-z]+#i', '', $text);
?>
		<p id="paragraph<?php echo $noParagraph;?>" class="firstParagraph"><a class="parEdit" onclick="paragraphClicked(document.getElementById('paragraph<?php echo $noParagraph;?>'), <?php echo $noParagraph;?>);"><?php echo $text;?></a></p>
<?php
		    }
                    else if(preg_match('#^- (.+)$#', $text, $match))
		    {?>
                <p id="paragraph<?php echo $noParagraph;?>" style="margin-left:20px"><a class="parEdit" onclick="paragraphClicked(document.getElementById('paragraph<?php echo $noParagraph;?>'), <?php echo $noParagraph;?>);">&mdash;&nbsp;<?php echo $match[1];?></a></p>
<?php
		    }
                    else
                    {?>
		<p id="paragraph<?php echo $noParagraph;?>"><a class="parEdit" onclick="paragraphClicked(document.getElementById('paragraph<?php echo $noParagraph;?>'), <?php echo $noParagraph;?>);"><?php echo $text;?></a></p>
<?php
		    }
                    
                    $firstLetter = false;
                }
                
                $title = false;
            }
        } while($text);
    }
?>
        </div>
    </div>
<?php    
    if($chap != 1)
    {?>

    <div class="row">
        <div class="col-md-12">
            <p style="text-align:right"><?php echo count($ip);?> participant<?php echo (count($ip)>1)?'s':'';?> sur ce chapitre \o/</p>
        </div>
    </div>
<?php
    }?>

    <div class="row well">
        <div class="col-md-9">
            <p style="text-align:center">
<?php
    if($chap > 1)
    {?>
                <a href="/chapitre-<?php echo $chap - 1;?>" class="btn btn-default">&lt;</a>
<?php
    }
    $i = 1;
    while(file_exists('story/chap'.$i.'.txt'))
    {?>
                <a href="/chapitre-<?php echo $i;?>" class="btn btn-<?php echo ($chap == $i) ? 'info' : 'default';?>"><?php echo $i;?></a>
<?php
        $i++;
    }
    if(file_exists('story/chap'.$chap.'.txt'))
    {?>
                <a href="/chapitre-<?php echo $chap + 1;?>" class="btn btn-default"><?php
                    if(file_exists('story/chap'.($chap+1).'.txt'))
                        echo "&gt;";
                    else
                        echo "Nouveau chapitre";?></a>
<?php
    }?>
            </p>
        </div>
        <div class="col-md-2">
            <a href="/Un_Zeste_sans_Fin.pdf" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;Télécharger le PDF (bêta)</a>
        </div>
    </div>

</div>

<script type="text/javascript">

	function getParagraphContent(noParagraph)
        {
        	if(window.XMLHttpRequest) {
			
			var request = new XMLHttpRequest();
			request.open("GET", "/getParagraphContent.php?chap=<?php echo $chap;?>&p="+noParagraph, false);
			request.send();
			if(request.readyState === 4 && request.status === 200) {
				var response = request.responseText;
				return response;
			}
			else
				return null;
                }
		else
			alert("Il semble que votre navigateur ne prenne pas en charge la technologie AJAX. Cette dernière est nécessaire pour utiliser correctement la fonctionnalité de correction. Votre navigateur est-il à jour ?");
        }

	function paragraphClicked(paragraph, noParagraph) {

		var paragraphContent = getParagraphContent(noParagraph);

		paragraph.innerHTML = "<textarea class=\"form-control\" style=\"height:100px\" id=\"textCorrect"+noParagraph+"\">"+paragraphContent+"</textarea></p><p style=\"text-align:right\" id=\"btn-editPar"+noParagraph+"\"><button id=\"valid-modif"+noParagraph+"\" onclick=\"sendCorrection("+noParagraph+")\" class=\"btn btn-default\">Enregistrer</button></p>";

		paragraph.className = "";

	}

	function sendCorrection(noParagraph) {

		var btnPar = document.getElementById("btn-editPar"+noParagraph);
		var paragraph = document.getElementById("paragraph"+noParagraph);
		var textarea = document.getElementById("textCorrect"+noParagraph);

		var request = new XMLHttpRequest();
		var params = "chap=<?php echo $chap;?>&p="+noParagraph+"&correction="+textarea.value;
		request.open("POST", "/correctParagraph.php", false);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.setRequestHeader("Content-length", params.length);
		request.setRequestHeader("Connection", "close");
		request.send(params);

		var closeCorrection = false;

		if(request.readyState === 4) {
			switch(request.status) {
			case 200: // Tout s'est bien passé
				btnPar.innerHTML = "Votre correction a bien été envoyée. Elle sera modérée dans les plus brefs délais. Merci pour votre participation :-)";
				btnPar.className = "alert alert-success";
				btnPar.style.textAlign = "left";

				closeCorrection = true;
				break;
			case 409: // Une autre correction est disponible
				alert("Quelqu'un d'autre a proposé une correction pour ce paragraphe. Vous trouverez la correction proposée dans la zone de modération."); 
				break;
			default:
				alert("Une erreur inconnue s'est produite. Veuillez réessayer plus tard.\nErreur : "+request.status);
			}

			if(closeCorrection) {

				textarea.disabled = true;
				if(document.getElementById('valid-modif'+noParagraph) != NULL)
					document.getElementById('valid-modif'+noParagraph).disabled = true;

			}
		}

	}
</script>

    </body>
</html>
