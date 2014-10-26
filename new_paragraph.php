<?php
    // Liste d'IP bannies
    $IP_BLOCKED = array(
        '2.2.217.116' => "Votre anatomie ne nous intéresse pas."
    );
    
    if(isset($IP_BLOCKED[$_SERVER['REMOTE_ADDR']]))
    {
        die('Vous avez été banni pour la raison suivante : '.$IP_BLOCKED[$_SERVER['REMOTE_ADDR']]);
    }
    
    $cryptinstall="./crypt/cryptographp.fct.php";
    require $cryptinstall;
    
    if(!empty($_POST['paragraph']) && !empty($_POST['captcha']))
    {
        $title = '';
        if(!empty($_POST['titlechap']))
            $title = $_POST['titlechap'];
        $paragraph = strip_tags($_POST['paragraph']);
        $captcha = $_POST['captcha'];
        
        if(chk_crypt($captcha))
        {
            $i = 1;
            while(file_exists('story/chap'.$i.'.txt'))
                $i++;
            
            // Création d'un nouveau chapitre si le titre n'est pas vide.
            if($title == '')
                $i--;
            
            $filechap = fopen('story/chap'.$i.'.txt', 'a');
            fwrite($filechap, $title."\n".$paragraph."\n[[IP:".$_SERVER['REMOTE_ADDR'].']]');
            fclose($filechap);
            
            $_SESSION['title'] = '';
            $_SESSION['paragraph'] = '';
            
            $dateChange = fopen('lastchange.txt', 'w');
            fwrite($dateChange, time());
            fclose($dateChange);
            
            header('Location: /chapitre-'.$i);
        }
        else
        {
            $i = 1;
            while(file_exists('story/chap'.$i.'.txt'))
                $i++;
            
            if($title == '')
                $i--;
            
            if($title != '')
                $_SESSION['title'] = $title;
            $_SESSION['paragraph'] = $paragraph;
            $_SESSION['error'] = "Erreur de captcha. Veuillez réessayer.";
            header('Location: /chapitre-'.$i.'#form');
        }
    }
    else
    {
        header('Location: /');
    }
