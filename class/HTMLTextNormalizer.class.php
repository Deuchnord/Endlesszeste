<?php
require_once 'AbstractTextNormalizer.class.php';

class HTMLTextNormalizer extends AbstractTextNormalizer
{
	public function nonBreakSpace($string)
	{
		$string = preg_replace('#( )?([?!;:])#', "&nbsp;$2", $string);
		$string = str_replace('?&nbsp;!', '?!', $string);
		$string = str_replace('?&nbsp;?', '??', $string);
		$string = str_replace("« ", "«&nbsp;", $string);

		return $string;
	}
	public function quotes($string)
	{
		return preg_replace("#\"([^\"]+)\"#", "«&nbsp;$1&nbsp;»", $string);
	}
	public function italic($string)
	{
		return preg_replace("#[*_]([^\"]+)[*_]#", "<span style=\"font-style:italic\">$1</span>", $string);
	}
	public function apostrophes($string)
	{
		return str_replace("'", "’", $string);
	}
	public function suspensionPoints($string)
	{
		return str_replace("...", "…", $string);
	}
	public function censured($string)
	{
		return str_replace("[censured]", '<span style="background:black;color:white;font-family:Arial;padding:2px;transform:rotate(15deg);">CENSURED</span>', $string);
	}
}
