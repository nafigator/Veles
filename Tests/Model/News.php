<?php
/**
 * @file    News.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-27 17:51
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tests\Model;

use Veles\Model\ActiveRecord;

/**
 * Class News
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class News extends ActiveRecord
{
	const TBL_NAME = 'news';

	protected $map = [
		'id'         => 'int',
		'title'      => 'string',
		'content'    => 'string',
		'author'     => 'string'
	];
}
