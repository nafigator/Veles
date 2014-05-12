<?php
/**
 * Class for test purpose
 */

namespace Veles\Tests\Tools;


class UploadFile extends \Veles\Tools\UploadFile
{
	/**
	 * Method created for test purpose
	 *
	 * @param string $filename File name
	 * @param string $destination Save destination
	 * @return bool
	 */
	protected function moveUploadedFile($filename, $destination)
	{
		return rename($filename, $destination);
	}
}
