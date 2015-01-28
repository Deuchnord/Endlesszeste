<?php
function normalizeText($text, $firstLetter)
{
	require_once "class/HTMLTextNormalizer.class.php";
	$normalizer = new HTMLTextNormalizer();

	return $normalizer->normalize($text);
}
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
?>
</div>

    </body>
</html>
