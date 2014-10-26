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
	$textModified = str_replace('?&nbsp;?', '??', $textModified);
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
        <title>Un Zeste sans Fin</title>
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="/book.css" />
        <link rel="shortcut icon" type="image/png" href="/favicon-clem.png">
    </head>
    <body>

<div class="container">
<?php
if(isset($_GET['story']))
{?>
    <header class="page-header">
        <img src="/clem.png" alt="" style="float:left;height:64px" />
        <h1>
            Un Zeste sans Fin
            <small>Résumé</small>
        </h1>
    </header>
<?php include 'menu.php';?>
    <div class="row">
        <div class="col-md-12">
            <p style="text-align:center;font-size:1.5em">Histoire − <a href="/ecrivain/personnages">Personnages</a></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <iframe style="width:100%;height:600px;border:none" src="http://www.mindmeister.com/maps/public_map_shell/451484719/un-zeste-sans-fin?width=600&height=400&z=auto&scrollbars=1" scrolling="no" style="overflow:hidden">Your browser is not able to display frames. Please visit the <a rel="nofollow" href="http://www.mindmeister.com/451484719/un-zeste-sans-fin" target="_blank">mind map: Un Zeste sans Fin</a> on <a rel="nofollow" href="http://www.mindmeister.com" target="_blank">Mind Mapping - MindMeister</a>.</iframe>
        </div>
    </div>
<?php
}
else if(isset($_GET['characters']))
{?>
    <header class="page-header">
        <img src="/clem.png" alt="" style="float:left;height:64px" />
        <h1>
            Un Zeste sans Fin
            <small>Les personnages</small>
        </h1>
    </header>
<?php include 'menu.php';?>
    <div class="row">
        <div class="col-md-12">
            <p style="text-align:center;font-size:1.5em"><a href="/ecrivain/histoire">Histoire</a> − Personnages</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <p>Cette page rassemble les fiches de tous les personnages connus dans l'histoire. Elle est mise à jour fréquemment, n'hésitez pas à vous y référer en cas de besoin.<br />Une fiche de personnage ne donnant pas beaucoup de détails signifie généralement que l'histoire n'a pas donné beaucoup de précisions lors de la description. N'hésitez pas à leur donner de nouvelles caractéristiques (en restant cohérent avec l'histoire et ce que l'on sait déjà sur le personnage bien sûr&nbsp;!).</p>
            <p><strong>Attention&nbsp;:</strong> les fiches peuvent dévoiler des informations clés de l'intrigue. Il n'est pas recommandé de les lire sans avoir au préalable lu l'histoire.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p style="text-align:center;font-size:1.5em"><?php
                $capital = (isset($_GET['capital'])) ? $_GET['capital'] : 'A';
            
                if($capital != 1)
                    echo '<a href="/ecrivain/personnages/1">';
                else echo '<strong>';
                echo '#123';
                if($capital != 1)
                    echo '</a>';
                else echo '</strong>';
                echo ' ';
                for($i = 65; $i <= 90; $i++)
                {
                    if($capital != chr($i))
                        echo '<a href="/ecrivain/personnages/'.chr($i).'">';
                    else echo '<strong>';
                    echo chr($i);
                    if($capital != chr($i))
                        echo'</a>';
                    else echo '</strong>';
                    echo ' ';
                }
            ?></p>
        </div>
    </div>
<?php
    require 'personnages.php';
    
    ksort($personnages);
    
    $nbResults = 0;
    
    foreach($personnages as $name => $description)
    {
        if(strtoupper(substr($name, 0, 1)) == $capital)
        {
            $nbResults++;
?>
    <div class="row well">
        <div class="col-md-12">
            <h2><?php echo $name;?></h2>
            <ul>
<?php
        foreach($description as $key => $value)
        {
            if($value == "")
                $value = "<em>N/A</em>";
?>
                <li><strong><?php echo $key;?>&nbsp;:</strong> <?php echo $value;?></li>
<?php
        }?>
            </ul>
        </div>
    </div>
<?php
        }
    }
    if($nbResults == 0)
    {?>
    <div class="row">
        <div class="col-md-12">
            <p style="text-align:center">Aucun personnage à afficher.</p>
        </div>
    </div>
<?php
    }
}

else
{?>
    <header class="page-header">
        <img src="/clem.png" alt="" style="float:left;height:64px" />
        <h1>Un Zeste sans Fin</h1>
    </header>
<?php include 'menu.php';?>
    <div class="row chapter-content">
        <div class="col-md-12">
<?php
    $chapfile = @fopen('story/chap'.$chap.'.txt', 'r');
    
    if($chapfile)
    {
        $text = "";
        $title = true;
        $firstLetter = true;
        do
        {
            $text = fgets($chapfile);
            if($text != "")
            {
                if($title)
                    echo "<h2>Chapitre $chap&nbsp;: $text</h2>";
                
                else if(preg_match("#^\\[\\[IP:(.+)\\]\\]$#", $text, $match))
                {
                    $alreadyInArray = false;
                    for($pos = 0;$pos < count($ip); $pos++)
                        if($ip[$pos] == $match[1])
                            $alreadyInArray = true;
                            
                    if(!$alreadyInArray)
                        $ip[count($ip)] = $match[1];
                }
                
                else
                {
                    $text = normalizeText($text, $firstLetter);
                    if($firstLetter)
                        echo "<p class=\"firstParagraph\">$text</p>";
                    else if(preg_match('#^- (.+)$#', $text, $match))
                        echo "<p style=\"margin-left:20px\">&mdash;&nbsp;{$match[1]}</p>";
                    else
                        echo "<p>$text</p>";
                    
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
    if(!file_exists('story/chap'.($chap+1).'.txt'))
    {?>
    <div class="row" id="form">
        <script type="text/javascript">
            var timeLoad = <?php echo time();?>;
            function getInfo()
            {
                if(window.XMLHttpRequest)
                {
                    var request = new XMLHttpRequest();
                    request.open("GET", "/lastchange", true);
                    request.onreadystatechange = function() {
                        if(request.readyState === 4)
                        {
                            if(request.status === 200)
                            {
                                var timeLastChange = request.responseText;
                                if(timeLastChange > timeLoad)
                                {
                                    document.getElementById("alert-change").style.display = "block";
                                    document.title = "/!\\ Un Zeste sans Fin";
                                }
                            }
                        }
                    };
                    request.send();
                    setTimeout("getInfo()", 5000);
                }
            }
            setTimeout("getInfo()", 5000);
        </script>
        <p id="alert-change" class="alert alert-warning" style="display:none">Un nouveau paragraphe a été ajouté&nbsp;! Pensez à en prendre connaissance avant de publier le vôtre.</p>
<?php
    if(!empty($_SESSION['error']))
    {?>
        <p class="alert alert-danger"><?php echo $_SESSION['error'];?></p>
<?php
        $_SESSION['error'] = '';
    }?>
        <form method="post" action="new_paragraph.php">
<?php
    if(!$chapfile)
    {?>
            <input type="text" name="titlechap" class="form-control" placeholder="Titre du nouveau chapitre" required<?php if(!empty($_SESSION['title'])) echo ' value="'.$_SESSION['title'].'"';?> />
<?php
    }?>
            <textarea name="paragraph" class="form-control" placeholder="Entrez ici un nouveau paragraphe. Les lignes de dialogues doivent commencer par un tiret (-) suivi d'une espace." required style="height:200px"><?php if(!empty($_SESSION['paragraph'])) echo $_SESSION['paragraph'];?></textarea>
            <div class="col-md-5 col-md-offset-3 well" style="text-align:center">
                <p>Recopiez le texte&nbsp;:</p>
                <p><?php dsp_crypt(0,1);?></p>
                <input type="text" name="captcha" class="form-control" required />
                <p style="text-align:left"><em>Avant de publier, vérifiez que votre texte ne contient pas d'erreur d'orthographe, de grammaire ou de frappe.</em><br /><a href="/ecrivain/histoire">Des outils</a> sont à votre disposition pour vous aider à garder une certaine cohérence.</p>
                <p style="text-align:right"><button type="submit" class="btn btn-default">Publier</button></p>
            </div>
        </form>
    </div>
<?php
    }
    
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
<?php
}?>

</div>

    </body>
</html>
