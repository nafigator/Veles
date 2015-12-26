<?php
/**
 * Фабрика. Содержит алогритм выбора стратегии авторизации
 *
 * @file      UserAuthFactory.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:34:29 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth;

use Veles\Auth\Strategies\AbstractAuthStrategy;
use Veles\Auth\Strategies\CookieStrategy;
use Veles\Auth\Strategies\GuestStrategy;
use Veles\Auth\Strategies\LoginFormStrategy;
use Veles\Model\User;

/**
 * Class UserAuthFactory
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class UsrAuthFactory
{
	protected $cookie_definitions = [
		'id' => [
			'filter' => FILTER_VALIDATE_INT,
			'options' => [
				'min_range' => 1,
				'max_range' => PHP_INT_MAX
			]
		],
		'pw' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [
				'regexp' => '/^[a-z0-9_-]{1,20}$/i'
			]
		]
	];
	protected $post_definitions = [
		'ln' => FILTER_VALIDATE_EMAIL,
		'pw' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [
				'regexp' => '/^[a-z0-9_-]{1,20}$/i'
			]
		]
	];

	/**
	 * Algorithm for choosing auth strategy
	 *
	 * @todo Move validation and error handling into separate class
	 * @return AbstractAuthStrategy
	 */
	public function create()
	{
		$post    = $this->getPost();
		$cookies = $this->getCookies();

		switch (true) {
			case (isset($post['ln'], $post['pw'])):
				return new LoginFormStrategy(
					$post['ln'], $post['pw'], new User
				);
			case (isset($cookies['id'], $cookies['pw'])):
				return new CookieStrategy(
					$cookies['id'], $cookies['pw'], new User
				);
			default:
				return new GuestStrategy(new User);
		}
	}

	/**
	 * @codeCoverageIgnore
	 * @return mixed
	 */
	protected function getCookies()
	{
		$cookies = filter_input_array(INPUT_COOKIE, $this->cookie_definitions);

		return $cookies;
	}

	/**
	 * @codeCoverageIgnore
	 * @return mixed
	 */
	protected function getPost()
	{
		$post = filter_input_array(INPUT_POST, $this->post_definitions);

		return $post;
	}
}
