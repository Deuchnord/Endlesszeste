<?php
    header('Content-type: application/pdf');

    require 'pdf.class.php';
    
    function normalizeText($text, $firstLetter)
    {
        $textModified = $text;
        
        $textModified = preg_replace('#( )?([?!;:])#', " $2", $textModified);
        $textModified = str_replace("« ", "« ", $textModified);
        $textModified = str_replace(" »", " »", $textModified);
        $textModified = preg_replace("#\"([^\"]+)\"#", "« $1 »", $textModified);
        $textModified = str_replace("'", "’", $textModified);
        $textModified = str_replace("...", "…", $textModified);
        
        return $textModified;
    }
    
    function generatePDF($nbChapToPDFize)
    {
        $pdf = new PDF();
        
        $pdf->SetTitle('Un Zeste sans Fin', true);
        $pdf->SetAuthor('La communauté de Zeste de Savoir', true);
        $pdf->SetMargins(20, 20);
        
        $pdf->AddFont('DejaVu', '', 'DejaVuSerifCondensed.ttf', true);
        
        // Page de garde
        $pdf->AddPage();
        $pdf->SetFillColor(8, 69, 97);
        $pdf->SetTextColor(200);
        $pdf->Rect(0, 0, 210, 297, 'F');
        $pdf->SetFont('DejaVu', '', 40);
        $pdf->Text(40, 100, "Un Zeste sans Fin");
        $pdf->SetFont('DejaVu', '', 16);
        $pdf->Text(80, 150, "Par la communauté de Zeste de Savoir");
        $pdf->Image("clem.png", 40, 120);
        
        $pdf->SetTextColor(50);
        
        // Histoire
        $chap = 1;
        
        $chapWriting = 1;
        while(file_exists('story/chap'.$chapWriting.'.txt'))
            $chapWriting++;
        
        $chapWriting--;
        
        $chapfile = @fopen('story/chap'.$chap.'.txt', 'r');
        
        for($chapPDF = 0; $chapPDF < $nbChapToPDFize; $chapPDF++)
        {
            $pdf->AddPage();
            if($pdf->PageNo != 2 && $pdf->PageNo() % 2 == 0)
                $pdf->AddPage();
            
            $text = "";
            $title = true;
            $firstLetter = true;
            do
            {
                $text = fgets($chapfile);
                if($text != "" && $text != "\n")
                {
                    $text = str_replace("\n", "", $text);
                    $text = normalizeText($text, $firstLetter);
                    if($title)
                    {
                        $pdf->SetFont('DejaVu', '', 30);
                        $pdf->Cell(0, 0, "Chapitre $chap :", 0, 2, "C");
                        $pdf->Ln(15);
                        $pdf->Cell(0, 0, "$text", 0, 2, "C");
                        $pdf->Ln(10);
                        $pdf->SetFont('DejaVu', '', 12);
                    }
                    
                    else if(preg_match("#\\[\\[IP :(.+)\\]\\]#", $text, $match))
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
                        if(preg_match('#^- (.+)$#', $text, $match))
                            $pdf->MultiCell(0, 5, "\n— ".$match[1]);
                        else
                            $pdf->MultiCell(0, 5, "\n".$text);
                        
                        $firstLetter = false;
                    }
                    
                    $title = false;
                }
            } while($text);
            
            fclose($chapfile);
            $chap++;
            if(file_exists('story/chap'.($chap+1).'.txt'))
                $chapfile = @fopen('story/chap'.$chap.'.txt', 'r');
            else
                $chapfile = false;
        }
        
        // Ajout d'une page invitant le lecteur à participer
        $pdf->AddPage();
        $pdf->Rect(0, 0, 210, 60, 'F');
        
        $pdf->SetFont('DejaVu', '', 55);
        $pdf->SetFillColor(8, 69, 97);
        $pdf->SetTextColor(200);
        $pdf->Ln(10);
        $pdf->Cell(0, 0, "Venez participer !", 0, 2, "C");
        $pdf->Ln(40);
        $pdf->SetFont('DejaVu', '', 20);
        $pdf->SetTextColor(50);
        $pdf->MultiCell(0, 10, "Le chapitre $chapWriting est en cours d'écriture. Il sera disponible dans ce PDF dès sa clôture* !\n\n");
        
        $pdf->SetFont('DejaVu', '', 30);
        $pdf->SetTextColor(8, 69, 97);
        $pdf->MultiCell(0, 15, "\n\nVenez imaginer avec nous la suite des aventures de Clem dans la joie et la bonne humeur !");
        
        $pdf->SetFont('DejaVu', '', 20);
        $pdf->Write(15, "\n                    ");
        $pdf->Write(15, "endlesszeste.tk", "http://endlesszeste.tk");
        
        $pdf->Image("clem.png", 150, 150);
        
        $pdf->SetFont('DejaVu', '', 8);
        $pdf->Ln(50);
        $pdf->MultiCell(0, 5, "* Un chapitre est considéré comme « clôturé » lorsque sa correction est terminée. Il est donc possible qu'un retard subsiste entre le nombre de chaptres sur ce document et le nombre de chapitres terminés sur le site.");
        
        $pdf->Output("Un Zeste sans Fin.pdf", "F");
        
        $fileNoChap = fopen('nochap.txt', 'w');
        fwrite($fileNoChap, $chapPDF);
        fclose($fileNoChap);
    }
    
    $nbChapToPDFize = 3;
    
    if($nbChapToPDFize != file_get_contents('nochap.txt'))
        generatePDF($nbChapToPDFize);
    
    echo file_get_contents('Un Zeste sans Fin.pdf');
    
