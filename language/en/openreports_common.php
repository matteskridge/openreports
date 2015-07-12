<?php
/**
 *
 * Open Reports
 *
 * @copyright (c) 2015 Matt Eskridge
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'OPEN_REPORTS'     => array(
        1   => '%1$d Open Report',
        2   => '%1$d Open Reports',
    ),
    'OPEN_PM_REPORTS'       => array(
        1   => '%1$d Open PM Report',
        2   => '%1$d Open PM Reports',
    ),
));