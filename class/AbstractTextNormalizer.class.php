<?php
abstract class AbstractTextNormalizer
{
	public abstract function nonBreakSpace($string);
	public abstract function quotes($string);
	public abstract function italic($string);
	public abstract function apostrophes($string);
	public abstract function suspensionPoints($string);
	public abstract function censured($string);

	public function normalize($string)
	{
		$string = $this->nonBreakSpace($string);
		$string = $this->quotes($string);
		$string = $this->italic($string);
		$string = $this->apostrophes($string);
		$string = $this->suspensionPoints($string);
		$string = $this->censured($string);

		return strip_tags($string);
	}
}
