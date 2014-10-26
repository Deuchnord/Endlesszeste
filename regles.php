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
        <title>Règles − Un Zeste sans Fin</title>
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
			<p><em>Un Zeste sans Fin</em> est une histoire communautaire pour le site <a href="//zestedesavoir.com">Zeste de Savoir</a>. Le but est d'écrire une histoire dont Clem, la mascotte de Zeste de Savoir, est le héro.</p>
			<p>Cette page explique les règles du site et fournit un mode d'emploi pour participer. Elle peut être mise à jour à tout moment, sans préavis.</p>
			
			<h3>Quelques règles</h3>
			<p>Les règles suivantes doivent impérativement être respectées pour que tout se passe bien&nbsp;</p>
			<ul>
				<li>Faites un effort sur l'orthographe&nbsp;: tout le monde peut faire des erreurs, mais essayez de ne pas trop en faire. Le SMS n'est pas admis.</li>
				<li>Votre participation est anonyme. Merci de ne pas la signer.</li>
				<li>Comme le titre le laisse penser, l'histoire n'a pas vocation à se terminer.</li>
				<li>Veillez à rester cohérent avec ce qui a été écrit précédemment. <a href="/ecrivain/histoire">Des outils</a> sont à votre disposition pour vous aider à continuer l'histoire.</li>
				<li>Toute forme d'insulte est strictement interdite et punie d'une interdiction d'écrire <strong>définitive</strong> sur le site.</li>
				<li>Afin de garder une bonne ambiance, merci de ne pas dénigrer d'autres membres. L'auto-dérision est tolérée, à la condition de le signaler au préalable sur <a href="http://zestedesavoir.com/forums/sujet/1206/un-zeste-sans-fin/">le sujet du forum</a> dédié à l'histoire.</li>
			</ul>
			<p>Notez que votre adresse IP est recueillie lors de l'enregitrement de votre participation. Elle est utilisée uniquement dans le cadre de la modération et pour afficher le nombre total de participant en bas de chaque chapitre.</p>
			
			<h3>Quelques bonnes pratiques et aide sur la syntaxe</h3>
			<p>Les temps principaux utilisés pour la rédaction de l'histoire sont les suivants&nbsp;:</p>
			<ul>
				<li>L'imparfait de l'indicatif pour la description. Pour décrite des événements passés, le plus-que-parfait de l'indicatif est à utiliser.</li>
				<li>Le passé simple de l'indicatif pour la description d'actions.</li>
			</ul>
			
			<p>Les éléments de syntaxe suivants peuvent être utiles. D'autres peuvent apparaître au fur et à mesure de l'avancée de l'histoire, en fonction des besoins.</p>
			<p>Chaque paragraphe commence sur une nouvelle ligne. Les lignes vides sont ignorées.</p>
			
			<p>Les dialogues rapportés au style direct sont sur une nouvelle ligne commençant par un tiret (celui du 6 sur un clavier AZERTY ou du 8 sur un clavier BEPO). La partie indiquant la personne qui prend la parole est donnée au passé simple de l'indicatif et commence par une lettre minuscule dans le cas où la phrase précédente se termine par un point d'interrogation ou d'exclamation. Par exemple&nbsp;:</p>
			
			<pre>- Ca sent la clémentine, non ? demanda-t-il soudain.</pre>
			<p>Résultat&nbsp;:</p>
			<p class="chapter-content" style="margin-left:20px">&mdash;&nbsp;Ca sent la clémentine, non&nbsp;? demanda-t-il soudain.</p>
			
			<p>Les <a href="https://fr.wikipedia.org/wiki/Onomatop%C3%A9e">onomatopées</a> sont à mettre en italique. Pour cela, il suffit de les mettres entre étoiles ou entre tiret bas (underscores), exactement comme en Markdown&nbsp;:</p>
			<pre>*Plouf* !
_Splash_ !</pre>
			<p>Résultat&nbsp;:</p>
			<p class="chapter-content"><?php echo normalizeText("*Plouf* !", false);?></p>
			<p class="chapter-content"><?php echo normalizeText("_Splash_ !", false);?></p>
			
			<p>Il est possible d'ajouter la mention «&nbsp;[censured]&nbsp;» pour marquer une censure. Cela est très utile pour censurer des injures, par exemple. <strong>À utiliser avec parcimonie</strong>. Par exemple&nbsp;:</p>
			<pre>- Tu vas me répondre, oui, espèce de [censured]?!!</pre>
			<p>Résultat&nbsp;:</p>
			<p class="chapter-content" style="margin-left:20px">&mdash;&nbsp;<?php echo normalizeText("Tu vas me répondre, oui, espèce de [censured]?!!", false);?></p>
        </div>
    </div>
</div>

    </body>
</html>
