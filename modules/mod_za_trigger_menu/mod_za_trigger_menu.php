<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2014 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 3/06/2014
# ------------------------------------------------------------------------
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( dirname(__FILE__) .DIRECTORY_SEPARATOR . 'helper.php' );

$list	= modTriggerMenuHelper::getList($params);
$app	= JFactory::getApplication();
$menu	= $app->getMenu();
$active	= $menu->getActive();
$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
$path	= isset($active) ? $active->tree : array();
$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

$loadJQuery = $params->get('loadJQuery');
$bgtrigger = $params->get('bgtrigger');
$fontcolor = $params->get('fontcolor');

modTriggerMenuHelper::SetScript($loadJQuery);
modTriggerMenuHelper::SetCSS();

if(count($list)) {
    require( JModuleHelper::getLayoutPath( 'mod_za_trigger_menu' , $params->get('layout', 'default')) );
}