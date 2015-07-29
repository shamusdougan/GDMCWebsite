<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.categories');

/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	1.5
 */
function VisformsBuildRoute(&$query)
{
	$segments	= array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_content');

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
		$menuItemGiven = false;
        if (!$menuItem)
        {
            $lang = JFactory::getLanguage();
            $menuItem = $menu->getDefault($lang->getTag());
        }
	}
	else {
		$menuItem = $menu->getItem($query['Itemid']);
		$menuItemGiven = true;
	}

	// if we are dealing with form or formdata which are linked to a menu that should be true!
    //view and id values are the same in $menuItem->query and in $query and we can unset the $query values
	if (($menuItem instanceof stdClass) && isset($query['view']) && $menuItem->query['view'] == $query['view'] && isset($menuItem->query['id']) && isset($query['id']) && $menuItem->query['id'] == intval($query['id'])) 
	{
		unset($query['view']);
        unset($query['id']);
	}
	
	// if the layout is specified and it is the same as the layout in the menu item, we
	// unset it so it doesn't go into the query string.
	// otherwise we put it into the first segment
	if (isset($query['layout'])) 
	{
		if ($menuItemGiven && isset($menuItem->query['layout'])) 
		{
			if ($query['layout'] == $menuItem->query['layout']) 
			{

				unset($query['layout']);
			}
			else
			{
				$segments[] = $query['layout'];
				unset($query['layout']);
			}
		}
		else 
		{
			if ($query['layout'] == 'default') 
			{
				unset($query['layout']);
			}
			else
			{
				$segments[] = $query['layout'];
				unset($query['layout']);
			}
		}
		
	}
	
	// an url should never contain both parameter(layout and task)
	// if we have a task we put it into the (as we asume) first segment
	if (isset($query['task'])) 
	{
		$segments[] = $query['task'];
		unset($query['task']);
        
	}

	// if we deal with a data detail view, there is a additional parameter cid which we put into $segments (on the last position)
	if (isset($query['cid']))
	{
		$segments[] = $query['cid'];
		unset($query['cid']);
	}
	// if we deal with a captcha there is an additional parameter sid which we put into $segments (on the last position)
    if (isset($query['sid']))
	{
		$segments[] = $query['sid'];
		unset($query['sid']);
	}
	return $segments;
}



/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	1.5
 */
function VisformsParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
    if(!$item)
    {
        //We deal with a form that is set as home menu
        $lang = JFactory::getLanguage();
        $item = $menu->getDefault($lang->getTag());
    }

	// Count route segments
	$count = count($segments);
	
	
	if (isset($item->query['id']))
	{
		$vars['id'] = $item->query['id'];
	}
	
	if (isset($item->query['view']))
	{
		$vars['view'] = $item->query['view'];
	}
	
	if (isset($item->query['layout']))
	{
		$vars['layout'] = $item->query['layout'];
	}


	// if there is only one segment, then it the task 'send', the task 'captcha' or a layout
	if ($count >= 1) 
	{
		// check if it is the task 'send'
		if (($segments[0] == "send") || ($segments[0] == "captcha"))
		{
			$vars['task'] = $segments[0];
		}
		else
		{
			$vars['layout'] = $segments[0];
		}
	}
	
	if ($count >= 2) 
	{
		// if we deal with a captcha this segment will be a guid
		if (strlen($segments[$count-1]) > 10)
		{
			$vars['sid'] = $segments[$count-1];
		}
		// we assume we have an url to a data detail view
		else
		{
			$vars['cid'] = $segments[$count-1];
		}
	}

	return $vars;
}
