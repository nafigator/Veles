<?php
namespace Veles\Tests\Model;

use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Model\QueryBuilder;
use Veles\Model\User;
use Veles\Auth\UsrGroup;
use Veles\DataBase\Db;
use Veles\DataBase\Adapters\PdoAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 16:15:58.
 */
class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var QueryBuilder
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new QueryBuilder;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Model\QueryBuilder::insert
	 * @covers Veles\Model\QueryBuilder::sanitize
	 */
	public function testInsert()
	{
		$group = UsrGroup::GUEST;
		$hash = md5('lalala');

		$user = new UserCopy;
		$user->id = 1;
		$user->email = 'mail@mail.org';
		$user->hash = $hash;
		$user->group = $group;
		$user->money = 2.22;
		$user->date = '1080-12-12';

		$expected = "
			INSERT
				`users`
				(`id`, `email`, `hash`, `group`, `money`)
			VALUES
				(1, 'mail@mail.org', '$hash', $group, 2.22)
		";
		$result = $this->object->insert($user);

		$msg = 'QueryBuilder::insert() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\QueryBuilder::update
	 * @covers Veles\Model\QueryBuilder::sanitize
	 */
	public function testUpdate()
	{
		$group = UsrGroup::GUEST;
		$hash = md5('lalala');

		$user = new User;
		$user->id = 1;
		$user->email = 'mail@mail.org';
		$user->hash = $hash;
		$user->group = $group;

		$expected = "
			UPDATE
				`users`
			SET
				`email` = 'mail@mail.org', `hash` = '9aa6e5f2256c17d2d430b100032b997c', `group` = 16
			WHERE
				id = 1
		";
		$result = $this->object->update($user);

		$msg = 'QueryBuilder::update() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\QueryBuilder::getById
	 */
	public function testGetById()
	{
		$user = new User;
		$expected = "
			SELECT *
			FROM
				users
			WHERE
				id = 1
			LIMIT 1
		";

		$msg = 'QueryBuilder::getById() returns wrong result!';
		$result = $this->object->getById($user, 1);
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\QueryBuilder::delete
	 * @dataProvider deleteProvider
	 */
	public function testDelete($ids, $expected, $user)
	{
		$msg = 'QueryBuilder::delete() returns wrong result!';
		$result = $this->object->delete($user, $ids);
		$this->assertSame($expected, $result, $msg);
	}

	public function deleteProvider()
	{
		$user = new User;
		$user->id = 1;

		return [
			[1, "
			DELETE FROM
				users
			WHERE
				id IN (1)
		", $user],
			[[1,2,3], "
			DELETE FROM
				users
			WHERE
				id IN (1,2,3)
		", $user],
			[null, "
			DELETE FROM
				users
			WHERE
				id IN (1)
		", $user],
		];
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Не найден id модели!
	 */
	public function testDeleteException()
	{
		$user = new User;
		$result = $this->object->delete($user, false);
	}

	/**
	 * @covers Veles\Model\QueryBuilder::find
	 * @dataProvider findProvider
	 */
	public function testFind($filter, $expected)
	{
		$user = new User;
		$result = $this->object->find($user, $filter);
		$msg = 'QueryBuilder::find() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function findProvider()
	{
		$filter = new DbFilter;
		$filter->setWhere('id = 1');
		return [
			[null, "
			SELECT
				`id`, `email`, `hash`, `group`, `last_login`
			FROM
				`users`"],
			[$filter, "
			SELECT
				`id`, `email`, `hash`, `group`, `last_login`
			FROM
				`users`
			WHERE id = 1"]
		];
	}

	/**
	 * @covers Veles\Model\QueryBuilder::setPage
	 */
	public function testSetPage()
	{
		$pager = new DbPaginator;
		$news = new News;
		$expected = '
			SELECT SQL_CALC_FOUND_ROWS
				`id`, `title`, `content`, `author`
			FROM
				`news` LIMIT 0, 5';

		$sql = $this->object->find($news, false);
		$result = $this->object->setPage($sql, $pager);

		$msg = 'QueryBuilder::setPage returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}
