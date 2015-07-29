<?php
/**
 * @author       Aicha Vack
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 

// No direct access
defined('_JEXEC') or die;

/**
 * Content component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHelper
{
	public static $extension = 'com_visforms';

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_VISFORMS_SUBMENU_FORMS'),
			'index.php?option=com_visforms&view=visforms',
			$vName == 'visforms'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_VISFORMS_SUBMENU_HELP'),
			'index.php?option=com_visforms&view=vishelp',
			$vName == 'vishelp');
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @param	int		The article ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($formId = 0, $fieldId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($formId) && empty($fieldId)) {
			$assetName = 'com_visforms';
		}
		else if (empty($fieldId)){
			$assetName = 'com_visforms.visform.'.(int) $formId;
		}
		else
		{
			$assetName = 'com_visforms.visform.'.(int) $formId.'.visfield.'. (int) $fieldId;
		}

       $actions = JAccess::getActionsFromFile(JPath::clean(JPATH_ADMINISTRATOR . '/components/com_visforms/access.xml'), "/access/section[@name='component']/");

		foreach ($actions as $action) {
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}
