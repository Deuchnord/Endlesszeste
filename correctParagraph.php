<?php
if(empty($_POST['chap']) || empty($_POST['p']) || empty($_POST['correction']))
{
	header('Status: 400 Bad Request');
	exit();
}

$filename = 'corrections/chap'.$_POST['chap'].'par'.$_POST['p'].'.txt';

if(file_exists($filename))
{
	header('Status: 409: Conflict');
	exit();
}

$file = fopen($filename, 'w');
fwrite($file, $_POST['correction']);
fclose($file);

$file = fopen('corrections/chap'.$_POST['chap'].'.txt', 'a');
fwrite($file, $_POST['p']."\n");
fclose($file);
