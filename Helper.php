<?php
/**
 * Useful functions
 *
 * @file      Helper.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Сбт Апр 21 20:59:37 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles;

/**
 * Useful functions
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Helper
{
	/**
	 * Generate random symbol sequence given length
	 *
	 * By default setting is for blowfish salt generate
	 *
	 * @param int    $length  String length
	 * @param string $letters Group of symbols
	 *
	 * @return string
	 */
	public static function genStr(
		$length  = 22,
		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./'
	) {
		return substr(str_shuffle(str_repeat($letters, 5)), 0, $length);
	}

	/**
	 * Email check
	 *
	 * @param string $email
	 * @return bool
	 */
	public static function validateEmail($email)
	{
		return (bool) preg_match(
			'/^(?:[a-zA-Z0-9]|_|\-|\.)+@(?:(?:[a-z0-9_]|\-)+\.)+[a-z]{2,6}$/', $email
		);
	}

	/**
	 * Check email-domain
	 *
	 * @param string $email
	 * @return bool
	 */
	public static function checkEmailDomain($email)
	{
		list(, $domain) = explode('@', $email);

		return checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
	}

	/**
	 * Translate cyrillic into translit by GOST 7.79-2000 standard
	 *
	 * @param string $string
	 * @return string
	 */
	public static function translit($string)
	{
		$symbols = [
			'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G',
			'Д'=>'D','Е'=>'E','Ё'=>'YO','Ж'=>'ZH','З'=>'Z','И'=>'I',
			'Й'=>'J','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N',
			'О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T',
			'У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'CZ','Ч'=>'CH',
			'Ш'=>'SH','Щ'=>'SHH','Ъ'=>'','Ы'=>'Y','Ь'=>'',
			'Э'=>'E','Ю'=>'YU','Я'=>'YA','а'=>'a','б'=>'b',
			'в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh',
			'з'=>'z','и'=>'i','й'=>'j','к'=>'k','л'=>'l',
			'м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r',
			'с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h',
			'ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'shh','ъ'=>'',
			'ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
			' '=>'-','"'=>'','.'=>'',','=>'','!'=>'','?'=>'',
			'('=>'',')'=>'','#'=>'','@'=>'','*'=>'','&'=>'',
			'['=>'',']'=>'',':'=>'',';'=>'','<'=>'','>'=>'',
			'+'=>''
		];
		return strtr(mb_strtolower($string, 'UTF-8'), $symbols);
	}

	/**
	 * Method for alias generation
	 *
	 * @param string $url URL для алиаса
	 *
	 * @return string
	 */
	public static function makeAlias($url)
	{
		$alias = htmlspecialchars_decode($url);
		$alias = preg_replace('/[^a-z^а-яё^\d^ ^-]/iu', '', $alias);
		$alias = Helper::translit($alias);
		$alias = preg_replace('/\-+/', '-', $alias);

		return $alias;
	}
}
