<?php
    $chap = 1;
    if(isset($_GET['chap']) && (int)$_GET['chap'] >= 1)
        $chap = $_GET['chap'];
    
    //if(!file_exists("story/chap".$chap-1 .".txt"))
        //header('Location: /chapitre-'.$chap-1);

    $cryptinstall="./crypt/cryptographp.fct.php";
    require $cryptinstall;
    
    function normalizeText($text, $firstLetter)
    {
        $textModified = $text;
        
        $textModified = preg_replace('#( )?([?!;:])#', "&nbsp;$2", $textModified);
        $textModified = str_replace('?&nbsp;!', '?!', $textModified);
        $textModified = str_replace("« ", "«&nbsp;", $textModified);
        $textModified = str_replace(" »", "&nbsp;»", $textModified);
        $textModified = preg_replace("#\"([^\"]+)\"#", "«&nbsp;$1&nbsp;»", $textModified);
        $textModified = preg_replace("#[*_]([^\"]+)[*_]#", "<span style=\"font-style:italic\">$1</span>", $textModified);
        $textModified = str_replace("'", "’", $textModified);
        $textModified = str_replace("...", "…", $textModified);
        $textModified = str_replace("[censured]", '<span style="background:black;color:white;font-family:Arial;padding:2px;transform:rotate(15deg);">CENSURED</span>', $textModified);
        
        return $textModified;
    }
    
    $nbParticipants = 0;
    $ip = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le bot IRC − Un Zeste sans Fin</title>
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="/book.css" />
        <link rel="shortcut icon" type="image/png" href="/favicon-clem.png">
    </head>
    <body>

<div class="container">
    <header class="page-header">
        <img src="/clem.png" alt="" style="float:left;height:64px" />
        <h1>
            Un Zeste sans Fin
        </h1>
    </header>
    
<?php include 'menu.php';?>
    
    <div class="row">
        <div class="col-md-12">
		<p>Un <em>bot</em> <abbr class="abbr" title="Internet Relay Chat">IRC</abbr> est un logiciel qui accède à un (ou plusieurs) canal(aux) IRC dans le but d'y fournir différents services répondant à certains besoins propres au canal. Cette page a pour but de fournir une aide pour utiliser les différentes commandes de Clem, le bot IRC du canal officiel d'<em>Un Zeste sans Fin</em>. Elles commencent tous par le symbole «&nbsp;!&nbsp;»</p>
		<p>Pour toute demande de nouvelle fonctionnalité, vous pouvez en faire la demande à Jérôme Deuchnord soit par le canal IRC, soit par MP via Zeste de Savoir, soit par <e href="mailto:contact@deuchord.tk?subject=Suggestion+Bot+IRC+Endlesszeste">e-mail</a>.</p>
		<hr />

		<h3>!chap</h3>
		<p>Demande au bot de fournir le lien pour accéder au chapitre demandé.</p>
		<p><strong>Usage&nbsp;:</strong> <span class="code">!chap &lt;numero_chapitre&gt;</span></p>
		<p><strong>Exemple&nbsp;:</strong> <span class="code">!chap 2</span></p>
		<p><strong>Remarque&nbsp;:</strong> si le chapitre n'existe pas, vous serez redirigé(e) vers la page de création de nouveau chapitre. Si le numéro du chapitre est 0 (zéro), vous serez renvoyé(e) au chapitre 1. Les chapitres négatifs ne sont pas pris en compte.</p>

		<h3>!rules</h3>
		<p>Demande au bot de fournir les liens permettant d'accéder aux règles ainsi qu'aux outils d'aide à l'écriture. Si des noms sont donnés en paramètres, le bot les citera dans son message.</p>
		<p><strong>Usage&nbsp;:</strong> <span class="code">!rules [dest1 [dest2 [...]]]</span></p>
		<p><strong>Exemple&nbsp;:</strong> <span class="code">!rules Deuchnord Florian Eskimon</span></p>

		<h3>!about</h3>
		<p>Affiche un message indiquant, entre autres, la version du programme.</p>
		<p><strong>Usage&nbsp;:</strong> <span class="code">!about</code></p>
		
		<h3>!help</h3>
		<p>Affiche un message invitant à se rendre sur cette page.</p>
		<p><strong>Usage&nbsp;:</strong> <span class="code">!help</span></p>
	</div>
    </div>
</div>

    </body>
</html>
