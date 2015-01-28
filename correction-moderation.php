<?php
require_once 'finediff.php';
require_once 'getParagraphContent-fct.php';
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
			background: yellow;
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
<?php include 'menu.php';
?>
	<h2>Les corrections proposées</h2>
	<p>Cette page récapitule l'ensemble des corrections proposées par les contributeurs.</p>
	<p>Les paragraphes correspondant ne peuvent plus être corrigés tant que leur correction proposée n'a pas été acceptée ou refusée. Si vous trouvez une erreur dans une correction, patientez simplement, le temps que le verrou est ôté.</p>
<?php

for($chap = 1; file_exists('story/chap'.$chap.'.txt'); $chap++)
{
	if(file_exists('corrections/chap'.$chap.'.txt'))
	{
?>
	<h3><a href="/chapitre-<?php echo $chap;?>">Chapitre <?php echo $chap;?></a></h3>
	<table class="table table-bordered">
		<tr>
			<th>Version actuelle</th>
			<th>Correction proposée</th>
		</tr>
<?php
		$fileChap = fopen('corrections/chap'.$chap.'.txt', 'r');
		while(($paragraph = str_replace("\n", "", fgets($fileChap))) != '')
		{
			$filePar = fopen('corrections/chap'.$chap.'par'.$paragraph.'.txt', 'r');
			$correction = str_replace("\r", "", fgets($filePar));
			fclose($filePar);
?>
		<tr>
			<td class="chapter-content"><?php $original = str_replace("\r", "", getParagraphContent($chap, $paragraph)); echo $original?></td>
			<td class="chapter-content"><?php
				$diff = FineDiff::getDiffOpCodes($original, $correction);
				echo FineDiff::renderDiffToHTMLFromOpcodes($original, $diff);?></td>
		</tr>
<?php
		}
		fclose($fileChap);
?>
	</table>
<?php
	}
}
?>

</div>

</script>

    </body>
</html>
