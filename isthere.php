<?php
header('Content-Type: text/plain');

if(!isset($_GET['chap']) || (int) $_GET['chap'] == 0)
	die('Usage: isthere.php?chap=<chap>');

if(file_exists('story/chap'.$_GET['chap'].'.txt'))
	echo 1;
else
	echo 0;
