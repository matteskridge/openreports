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
    "OPEN_REPORTS" => "%s Open Report(s)",
    "OPEN_PM_REPORTS" => "%s Open PM Report(s)",
));