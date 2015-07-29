<?php
/**
 * Visformsdata model for Visforms
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

/**
 * Visdata model class for Visforms
 *
 * @package      Joomla.Site
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsModelVisformsdata extends JModelList
{
	/*
	* visdata fields array
	* @var array
	*/
	var $_datafields;
	
	/**
	* form id
	* @var int
	*/
	var $_id;
	
	/**
	* Single Form Dataset object
	* @var object
	*/
	var $_detail;
    
    /**
     * Alternative params set by plugin
     * @var array
     */
    var $pparams;
    
    /**
     * Dot free string to use as requestprefix and contenxt for pagination
     * @var string
     */
    var $paginationcontext;
	
	/*
	 * Constructor
     * Note the model is used in component, plugins and modules!
	 *
	 */
	function __construct($config = array())
	{
        if (!empty($config['formid']))
        {
            $id = $config['formid'];
        }
        else
        {
            $id = JFactory::getApplication()->input->getInt('id', -1);
        }
		$this->setId($id);
        if (isset($config['context']) && $config['context'] != "") 
        {
            $this->context = $config['context'];
        }
        
        if (isset($config['pparams']) && is_array($config['pparams']))
        {
            $this->pparams = $config['pparams'];
        }

		//get an array of fieldnames that can be used to sort data in datatable
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'ipaddress', 'published', 'ismfd'
			);
		}
		
		//get all form field id's from database
		$db	= JFactory::getDbo();
		$tn = "#__visforms_".$id;	
		$query = ' SELECT c.id from #__visfields as c where c.fid='.$id.' AND (c.frontdisplay is null or c.frontdisplay = 1) ';
		$db->setQuery( $query );
		$fields = $db->loadObjectList();
		
		//add field id's to filter_fields
		foreach ($fields as $field) {
			$config['filter_fields'][] = "F" . $field->id;
		}
		
		parent::__construct($config);
        $this->paginationcontext = str_replace('.', '_', $this->context);
	}
	
	/**
	 * Method to set the form identifier
	 *
	 * @param	int form identifier
	 * @return	void
	 * @since        Joomla 1.6
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
	}
	
	/**
	 * Method to get the form identifier
	 *
	 * @param	int form identifier
	 * @return	int id
	 * @since        Joomla 1.6
	 */
	function getId()
	{
		return $this->_id;
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	 
	protected function populateState($ordering = null, $direction = null)
	{
        // Initialise variables.
		$app = JFactory::getApplication();
        $lang = JFactory::getLanguage();
        $itemid = 0;
        if(isset($this->pparams) && is_array($this->pparams))
        {
            $params = new JRegistry;
            $params->loadArray($this->pparams);
        }
        else
        {
            $params = new JRegistry;
            if ($menu = $app->getMenu()->getActive())
            {
                    $params->loadString($menu->params);
                    $itemid = ($menu->id) ? $menu->id : 0;
            }
            else if ($menu = $app->getMenu()->getDefault($lang->getTag()))
            {
                    $params->loadString($menu->params);
                    $itemid = ($menu->id) ? $menu->id : 0;
            }
        }
        $this->setState('params', $params);
        $this->setState('itemid', $itemid);
        $count = $params->get('count');
        $limit = (isset($count) && is_numeric($count)) ? intval($count) : $params->get('display_num', 20);
        $value = $app->input->get($this->paginationcontext.'limit', $limit, 'uint');
		$this->setState('list.limit', $value);

		$value = $app->getUserStateFromRequest($this->paginationcontext. '.limitstart', $this->paginationcontext.'limitstart', 0, 'uint');
        $app->setUserState($this->paginationcontext.'.limitstart', $value);
		$this->setState('list.start', $value);
        
        //With Joomla! it is not possible to have more than on sortable table on a page (no prefix supported as for pagination), so one request can only handle one value for each parameter
        //In principle we just make sure that data tables created by plugins do not set filter_order and filter_order_Dir in post, but only the component
        //and that the plugins always sets sort order and direction from plugin params
        if ($this->context == "com_visforms.visformsdata")
        {
            $ordering = $app->input->get('filter_order', $app->getUserStateFromRequest($this->paginationcontext. '.ordering', 'filter_order', $params->get('sortorder', 'id'), 'string'));
            $this->setState('list.ordering', $ordering);

            $direction = $app->input->get('filter_order_Dir', $app->getUserStateFromRequest($this->paginationcontext. '.direction', 'filter_order_Dir', $params->get('sortdirection', 'ASC'), 'string'));
            $this->setState('list.direction', $direction);
        }
        else
        {
            $ordering = $params->get('sortorder','id');
            $this->setState('list.ordering', $ordering);
            
            $direction = $params->get('sortdirection', 'ASC');
            $this->setState('list.direction', $direction);
        }
	}
    
    /**
	 * Method to get a JPagination object for the data set.
	 *
	 * @return  JPagination  A JPagination object for the data set.
	 *
	 * @since   12.2
	 */
	public function getPagination()
	{
		// Get a storage key.
		$store = $this->getStoreId('getPagination');

		// Try to load the data from internal storage.
		if (isset($this->cache[$store]))
		{
			return $this->cache[$store];
		}

		// Create the pagination object.
		$limit = (int) $this->getState('list.limit') - (int) $this->getState('list.links');
		$page = new JPagination($this->getTotal(), $this->getStart(), $limit, $this->paginationcontext);

		// Add the object to the internal cache.
		$this->cache[$store] = $page;

		return $this->cache[$store];
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		return parent::getStoreId($id);
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
        $fields = $this->getDatafields();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'*'
			)
		);
		$tn = "#__visforms_" . $this->_id;
		$query->from($tn . ' AS a');
		$query->where('(published = 1)');
         //only use the items specified in the fieldselect list
        if (isset($this->pparams['fieldselect']) && is_array($this->pparams['fieldselect']))
        {   
            foreach ($this->pparams['fieldselect'] as $name => $value)
            {
                if (is_numeric($name))
                {
                    $name = "F" . $name;
                }
                $query->where($db->quoteName($name) ." = " . $db->quote($value), "AND");
            }
        }    

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'id');
        if (is_numeric($orderCol))
        {
            $orderCol = "F" . $orderCol;
        }
        $this->setState('list.ordering', $orderCol);
		$orderDirn	= $this->state->get('list.direction', 'asc');
        //we store dates as strings in database. If sort order field is of type date we have to convert the strings before we order the recordsets
        foreach ($fields as $field)
        {
            $fname = 'F'.$field->id;
            if (($field->typefield == 'date') && (($orderCol == $fname) || ($orderCol == 'a.' . $fname)))
            {
                $formats = explode(';', $field->format);
                $format = $formats[1];
                $orderCol = ' STR_TO_DATE(' . $orderCol . ', '. $db->quote($format).  ') ';
                break; 
            }
        }
        $query->order($orderCol.' '.$orderDirn);
		return $query;
	}


	/**
	 * Method to retrieve the field list of a given form
	 * 
	 * @return array Array of objects containing the data from the database
	 * @since        Joomla 1.6
	 */
	function getDatafields()
	{
        $db	= JFactory::getDbO();
		// Lets load the data if it doesn't already exist
        //exclude all fieldtypes that should not be published in frontend (submits, resets, fieldseparator)
		if (empty( $this->_datafields ))
		{
			$query = ' SELECT * from #__visfields c where c.fid='.$this->_id." and (c.published = '1') and ".
                " !(c.typefield = 'reset') and !(c.typefield = 'submit') and !(c.typefield = 'image') and !(c.typefield = 'fieldsep') ORDER BY c.ordering asc";	
			$datafields = $this->_getList($query);
			$n = count($datafields);
			for ($i=0; $i < $n; $i++)
			{ 
				$registry = new JRegistry;
				$registry->loadString($datafields[$i]->defaultvalue);
				$datafields[$i]->defaultvalue = $registry->toArray();
				
				foreach ($datafields[$i]->defaultvalue as $name => $value) 
				{
					//make names shorter and set all defaultvalues as properties of field object
					$prefix =  'f_' . $datafields[$i]->typefield . '_';
					if (strpos($name, $prefix) !== false) {
							$key = str_replace($prefix, "", $name);
							$datafields[$i]->$key = $value;
					}
				}
				
				//delete defaultvalue array
				unset($datafields[$i]->defaultvalue);
			}
		}
		
		

		return $datafields;
	}
	
	/**
	* Method get the details of one dataset for a given form
	* @return object with data
	* @since        Joomla 1.6
	*/
	function getDetail()
	{
        $db	= JFactory::getDbO();
        $array = JFactory::getApplication()->input->get('cid', array(), 'ARRAY');
        JArrayHelper::toInteger($array);
        
		$id=(int)$array[0];
		if (is_numeric($id) == false) 
		{
			return null;
		}
		
		$query = ' SELECT * FROM #__visforms_'.$this->_id.
				'  WHERE id = '.$id;
		$db->setQuery( $query );
		$detail = $db->loadObject();
		
		return $detail;
	}

	
	/**
	* Method to get the form
	* @return object with data
	* @since        Joomla 1.6
	*/
	function getForm()
	{
        $db	= JFactory::getDbO();
		$query = ' SELECT * FROM #__visforms '.
				'  WHERE id = '.$this->_id;
		$db->setQuery( $query );
		$form = $db->loadObject();		
        $registry = new JRegistry;
        //Convert frontendsettings field to an array
        $registry->loadString($form->frontendsettings);
        $form->frontendsettings = $registry->toArray();
        foreach ($form->frontendsettings as $name => $value) 
        {
           //make names shorter and set all frontendsettings as properties of form object               
           $form->$name = $value;   
        }
		
		return $form;
	}
}
