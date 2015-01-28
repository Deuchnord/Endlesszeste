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
        <title>Canal IRC − Un Zeste sans Fin</title>
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
           Canal IRC
        </h1>
    </header>
    
    <div class="row">
        <div class="col-md-12">
		<iframe src="http://smoothirc.net/qwebchat/?channels=Endlesszeste" style="width:100%;height:400px;border:none"></iframe>
        </div>
    </div>
</div>

    </body>
</html>
