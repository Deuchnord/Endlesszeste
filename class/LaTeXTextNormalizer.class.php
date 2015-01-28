<?php
require_once 'AbstractTextNormalizer.class.php';

class LaTeXTextNormalizer extends AbstractTextNormalizer
{
	public function nonBreakSpace($string)
	{
		$string = preg_replace('#( )?([?!;:])#', "~$2", $string);
		$string = str_replace('?~!', '?!', $string);
		$string = str_replace('?~?', '??', $string);
		$string = str_replace("«", "«~", $string);
		$string = str_replace("»", "~»", $string);
		$string = str_replace("%", '~\%', $string);

		$string = str_replace("~ ", "~", $string);
		$string = str_replace(" ~", "~", $string);

		return $string;
	}
	public function quotes($string)
	{
		return preg_replace("#\"([^\"]+)\"#", "«~$1~»", $string);
	}
	public function italic($string)
	{
		return preg_replace("#[*_]([^\"]+)[*_]#", '\textit{$1}', $string);
	}
	public function apostrophes($string)
	{
		return $string;
	}
	public function suspensionPoints($string)
	{
		return str_replace("...", "…", $string);
	}
	public function censured($string)
	{
		return str_replace("[censured]", '\\textbf{CENSURED}', $string);
	}
}
