<?php
/**
 * Visdata controller for Visforms
 *
 * @author       Aicha Vack
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * Visformsdata Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */ 
class VisformsControllerVisformsdata extends JControllerLegacy
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	/**
	 * Method to display a data view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.6
	 */
	function display($cachable = false, $urlparams = false)
	{	
        JFactory::getApplication()->input->set('view', 'visformsdata');
		parent::display($cachable = false, $urlparams = false);
	}


	/**
	 * Method to display the detail view
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.6
	 */
	function detail($cachable = false, $urlparams = false)
	{
        JFactory::getApplication()->input->set('view', 'visformsdata');
        JFactory::getApplication()->input->set('layout', 'detail');
		
		parent::display($cachable = false, $urlparams = false);
	}	
}
?>
