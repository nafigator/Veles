<?php
/**
 * @file    News.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-12-27 17:51
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Model;

use Veles\Model\ActiveRecord;

/**
 * Class News
 * @author  Yancharuk Alexander <alex@itvault.info>
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
