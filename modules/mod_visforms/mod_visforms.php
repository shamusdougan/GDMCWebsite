<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_visforms
 * @copyright	Copyright (C) vi-solutions, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$base_dir = JPATH_SITE . '/components/com_visforms';
JLoader::register('JHTMLVisforms', JPATH_ADMINISTRATOR . '/components/com_visforms/helpers/html/visforms.php');
JLoader::register('VisformsEditorHelper', $base_dir . '/helpers/editor.php');
//load Visforms library main classes
JLoader::discover('Visforms', $base_dir . '/lib/', $force = true, $recurse = false);

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$lang = JFactory::getLanguage();
$extension = 'com_visforms';

$language_tag = $lang->getTag();
$reload = true;
$lang->load($extension, $base_dir, null, $language_tag, $reload);

$visforms = modVisformsHelper::getForm($params);
//check if user access level allows view
$user = JFactory::getUser();
$groups = $user->getAuthorisedViewLevels();
$access = (isset($visforms->access) && in_array($visforms->access, $groups)) ? true : false;
if ($access == false)
{
    $app->setUserState('com_visforms.form' . $visforms->id . '.fields', null);
    $app->setUserState('com_visforms.form' . $visforms->id , null);
    echo JText::_('COM_VISFORMS_ALERT_NO_ACCESS');
    return false;
}
$menu_params = $params;
$formLink = "index.php?option=com_visforms&view=visforms&task=send&id=".$visforms->id;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$_SESSION['vis_send_once'.$params->get('catid')] = "1";

require JModuleHelper::getLayoutPath('mod_visforms');