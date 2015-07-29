<?php
/**
 * Visformsdata view for Visforms
 *
 * @author       Aicha Vack
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
jimport( 'joomla.html.parameter' );
JHTML::_('behavior.framework');


/**
 * Visdata view class for Visforms
 *
 * @package      Joomla.Site
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsViewVisformsdata extends JViewLegacy
{
    /**
     *
     * @var object $form visforms formular object
     */
	protected $form;
    
    /**
     *
     * @var array $items array of form data from user input
     */
	protected $items;
    
    /**
     *
     * @var Object $state state
     */
	protected $state;
    
    /**
     *
     * @var object $menu_params Menu parameter
     */
    protected $menu_params;
    
    /**
     *
     * @var Object $field object of visforms fields
     */
	protected $fields;
    
    /**
     * 
     * @param integer  $itemid Menu Item id
     */
    protected $itemid;
	
	function display($tpl = null)
	{
        $this->state = $this->get('State');
        $this->form	= $this->get('Form');
        
         //check if user access level allows view
        $user = JFactory::getUser();
		$groups = $user->getAuthorisedViewLevels();
        $access = (isset($this->form->frontendaccess) && in_array($this->form->frontendaccess, $groups)) ? true : false;
        if ($access == false)
		{
			JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return;
		}
        
		// get params from menu 
        $this->menu_params = $this->state->get('params');
		
		if ($this->menu_params['menu-meta_description'])
		{
			$this->document->setDescription($this->menu_params['menu-meta_description']);
		}

		if ($this->menu_params['menu-meta_keywords'])
		{
			$this->document->setMetadata('keywords', $this->menu_params['menu-meta_keywords']);
		}
		
		
				
		
		//get Item id d
        $this->itemid = $this->state->get('itemid', '0');
		
		//get form id
		$this->id = JFactory::getApplication()->input->getInt('id', -1);

		if ($this->_layout == "detail")
		{

			// Get data from the model
			$this->item = $this->get('Detail');	
		} 
		
		// Get data from the model
		$this->form	= $this->get('Form');
		$this->items = $this->get('Items');
		
		
		$this->pagination = $this->get('Pagination');	
		
		$this->fields = $this->get('Datafields');
		
		parent::display($tpl);
		
	}
}
?>