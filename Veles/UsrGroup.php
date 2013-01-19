<?php
/**
 * Группы пользователей
 * @file    UsrGroup.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Ноя 04 08:18:08 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

/**
 * Класс UsrGroup
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UsrGroup
{
    // Группы пользователя
    const ADMIN      = 1;
    const MANAGER    = 2;
    const MODERATOR  = 4;
    const REGISTERED = 8;
    const GUEST      = 16;
    const DELETED    = 32;
}
