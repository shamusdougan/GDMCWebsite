<?php
/**
 * visform model for Visforms
 *
 * @author       Aicha Vack
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

require_once (JPATH_SITE.'/administrator/components/com_visforms/models/visfield.php');

require_once (JPATH_SITE.'/administrator/components/com_visforms/tables/visfield.php');

/**
 * visform Model
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsModelVisform extends JModelAdmin
{
    /* The type alias for this content type (for example, 'com_content.article').
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_visforms.visform';
	
	/**
	 * Method to perform batch operations on an form or a set of forms.
	 *
	 * @param   array  $commands  An array of commands to perform.
	 * @param   array  $pks       An array of form ids.
	 * @param   array  $contexts  An array of form contexts.
	 *
	 * @return  boolean  Returns true on success, false on failure.
	 *
	 * @since   11.1
	 */
	public function batch($commands, $pks, $contexts)
	{
		// Sanitize user ids.
		$pks = array_unique($pks);
		JArrayHelper::toInteger($pks);

		// Remove any values of zero.
		if (array_search(0, $pks, true))
		{
			unset($pks[array_search(0, $pks, true)]);
		}

		if (empty($pks))
		{
			$this->setError(JText::_('JGLOBAL_NO_ITEM_SELECTED'));
			return false;
		}

		$done = false;

		$result = $this->batchCopy($commands, $pks, $contexts);
		if (is_array($result))
		{
			$pks = $result;
		}
		else
		{
			return false;
		}
			

		$done = true;
		

		if (!empty($commands['assetgroup_id']))
		{
			if (!$this->batchAccess($commands['assetgroup_id'], $pks, $contexts))
			{
				return false;
			}

			$done = true;
		}

		if (!empty($commands['language_id']))
		{
			if (!$this->batchLanguage($commands['language_id'], $pks, $contexts))
			{
				return false;
			}

			$done = true;
		}

		if (!$done)
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
			return false;
		}

		// Clear the cache
		$this->cleanCache();

		return true;
	}
	
	/**
	 * Batch copy form.
	 *
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of forms contexts.
	 *
	 * @return  mixed  An array of new IDs on success, boolean false on failure.
	 *
	 * @since	11.1
	 */
	protected function batchCopy($commands, $pks, $contexts)
	{
		$table = $this->getTable();
		$i = 0;

		// Check that the user has create permission for the component
		$extension = JFactory::getApplication()->input->get('option', '');
		$user = JFactory::getUser();
		if (!$user->authorise('core.create', $extension))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_CREATE'));
			return false;
		}

		// Parent exists so we let's proceed
		while (!empty($pks))
		{
			// Pop the first ID off the stack
			$pk = array_shift($pks);
			$saveresult = false;

			$table->reset();

			// Check that the row actually exists
			if (!$table->load($pk))
			{
				if ($error = $table->getError())
				{
					// Fatal error
					$this->setError($error);
					return false;
				}
				else
				{
					// Not fatal error
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}
			
			if ($table->saveresult == "1") {
				$saveresult = true;
			}
			
			// Alter the title & alias
			$data = $this->generateNewTitle( '', $table->name, $table->title);
			$table->title = $data['0'];
			$table->name = $data['1'];


			// Reset the ID because we are making a copy
			$table->id = 0;

			// Check the row.
			if (!$table->check())
			{
				$this->setError($table->getError());
				return false;
			}

			// Store the row.
			if (!$table->store())
			{
				$this->setError($table->getError());
				return false;
			}
			
			$cmd = JArrayHelper::getValue($commands, 'copy_fields', 'c');
			
			// Get the new item ID
			$newId = $table->get('id');
            
            //create a datatable for the copied form if necessary
			if ($saveresult === true) {
				$this->createDataTables($newId);
			}
			
			if ($cmd == "c") {
				//duplicate all fields of copied form
				$this->batchCopyFields ($pk, $newId, $context);
            }

			// Add the new ID to the array
			$newIds[$i]	= $newId;
			$i++;
		}

		// Clean the cache
		$this->cleanCache();

		return $newIds;
	}
	
	/**
	 * Batch copy fields to new forms.
	 *
	 * @param   int   $pk  form id of original form that is to be copied
     * @param int $newId form id of new form
	 * @param   array    $contexts  An array of forms contexts.
	 *
	 * @return  mixed  An array of new IDs on success, boolean false on failure.
	 *
	 * @since	11.1
	 */
	protected function batchCopyFields ($pk, $newId, $contexts)
	{
		$fieldsModel = new VisformsModelVisfield();
		$fieldsTable = $fieldsModel->getTable();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		//Select Ids of Fields of copied form in Table visfields		
		$query 
			->select('a.id')
			->from('#__visfields AS a')
			->where('a.fid = ' .$pk);
			
		$db->setQuery($query);
		
		$results = $db->loadColumn();
        $fieldsModel->batch(array('form_id' => $newId, 'unpublish' => false), $results, $contexts);
		
		// Clean the cache
		$this->cleanCache();
	}
	
	/**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function save($data)
	{
        $app = JFactory::getApplication();
        if (isset($data['exportsettings']) && is_array($data['exportsettings'])) { 
            $registry = new JRegistry;
            $registry->loadArray($data['exportsettings']);
            $data['exportsettings'] = (string)$registry;
        }
        if (isset($data['emailreceiptsettings']) && is_array($data['emailreceiptsettings'])) {
            $registry = new JRegistry;
            $registry->loadArray($data['emailreceiptsettings']);
            $data['emailreceiptsettings'] = (string)$registry;
        }
        if (isset($data['frontendsettings']) && is_array($data['frontendsettings'])) {
            $registry = new JRegistry;
            $registry->loadArray($data['frontendsettings']);
            $data['frontendsettings'] = (string)$registry;
        }
        if (isset($data['layoutsettings']) && is_array($data['layoutsettings'])) {
            $registry = new JRegistry;
            $registry->loadArray($data['layoutsettings']);
            $data['layoutsettings'] = (string)$registry;
        }
        if (isset($data['spamprotection']) && is_array($data['spamprotection'])) {
            $registry = new JRegistry;
            $registry->loadArray($data['spamprotection']);
            $data['spamprotection'] = (string)$registry;
        }
        if (isset($data['captchaoptions']) && is_array($data['captchaoptions'])) {
            $registry = new JRegistry;
            $registry->loadArray($data['captchaoptions']);
            $data['captchaoptions'] = (string)$registry;
        }
	
	// Alter the title for save as copy
	if ($app->input->get('task') == 'save2copy') {
		list($title, $name) = $this->generateNewTitle( '', $data['name'], $data['title']);
		$data['title']	= $title;
		$data['name']	= $name;
	}

	if (parent::save($data)) 
    {

		return true;
	}

	return false;
	}
	
	/**
	 * Method to change the title & name.
	 *
	 * @param   string   $name        The name.
	 * @param   string   $title        The title.
	 *
	 * @return	array  Contains the modified title and name.
	 *
	 * @since	11.1
	 */
	protected function generateNewTitle($catid, $name, $title)
	{
		// Alter the title & name
		$table = $this->getTable();
		while ($table->load(array('name' => $name)))
		{

			$title = JString::increment($title);
			$name = JString::increment($name, 'dash');
		}

		return array($title, $name);
	}

		
	/** Method to create a datatable if it doesn't allready exist
	 *
	 * @param int $fid formid
	 *
	 * @return boolean true
	 * @since 1.6
	 */
	 
	 public function createDataTables ($fid = Null) {
	 
		if (!$fid) 
		{
			//no formid given
			//ToDo throw an error
			return false;
		}
        if (!$this->createDataTable($fid))
        {
            //Throw an error
        }
        if (!$this->createDataTable($fid, true))
        {
            //Throw an error
        }
		

			return true;
		
	}


	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{	
		// Get the form.
		$form = $this->loadForm('com_visforms.visform', 'visform', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function getItem($pk = null)
	{

		if ($item = parent::getItem($pk)) {
			// Convert the exportssettings field to an array.
			$registry = new JRegistry;
			$registry->loadString($item->exportsettings);
			$item->exportsettings = $registry->toArray();
            //Convert receiptmailsettings field to an array
            $registry = new JRegistry;
            $registry->loadString($item->emailreceiptsettings);
            $item->emailreceiptsettings = $registry->toArray();
             //Convert frontendsettings field to an array
            $registry = new JRegistry;
            $registry->loadString($item->frontendsettings);
            $item->frontendsettings = $registry->toArray();
            //Convert layoutsettings field to an array
            $registry = new JRegistry;
            $registry->loadString($item->layoutsettings);
            $item->layoutsettings = $registry->toArray();
            //Convert spamprotection field to an array
            $registry = new JRegistry;
            $registry->loadString($item->spamprotection);
            $item->spamprotection = $registry->toArray();
            //Convert captchaoptions field to an array
            $registry = new JRegistry;
            $registry->loadString($item->captchaoptions);
            $item->captchaoptions = $registry->toArray();
		}
		return $item;
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{	
		// Check the session for previously entered form data.
        $app = JFactory::getApplication();
		$data = $app->getUserState('com_visforms.edit.visform.data', array());

		if (empty($data)) 
        {
			$data = $this->getItem();
		}

		return $data;
	}
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Visform', $prefix = 'VisformsTable', $config = array())
	{	
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 *
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		return $condition;
	}
	
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission for the component.
	 *
	 * @since   11.1
	 */	
	protected function canDelete($record)
	{
		if (!empty($record->id)) 
        {

			$user = JFactory::getUser();
			return $user->authorise('core.delete', 'com_visforms.visform.'.(int) $record->id);
		}
		else
		{
			return parent::canDelete($record);
		}
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param	object	$record	A record object.
	 *
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
		// Check for existing form.
		if (!empty($record->id)) {
			return $user->authorise('core.edit.state', 'com_visforms.visform.'.(int) $record->id);
		}
		// Default to component settings if neither article nor category known.
		else {
			return parent::canEditState($record);
		}
	}
    
    protected function createDataTable ($fid, $save = false)
    {
        $dba	= JFactory::getDbo(); 
        $tn = "#__visforms_".$fid;
		$tnfull = $dba->getPrefix(). 'visforms_'.$fid;
        if ($save === true)
        {
           $tn .= "_save" ;
           $tnfull .= "_save";
        }
		$tablesAllowed = $dba->getTableList(); 	

	 	// Create the table to save the data 
		if (!in_array($tnfull, $tablesAllowed)) 
		{
			// Create table
			$query = "create table ".$tn.
				" (id int(11) not null AUTO_INCREMENT,".
				"published tinyint, ".
				"created datetime, ".
                "checked_out int(10) NOT NULL default '0', ".
                "checked_out_time datetime NOT NULL default '0000-00-00 00:00:00', ".
                "ipaddress TEXT NULL, ".
                "articleid TEXT NULL, ";
            $query .= ($save === true) ? "mfd_id int(11) NOT NULL default 0, " :  "ismfd tinyint(4) NOT NULL default 0, ";
            $query .=    "primary key (id) ".
				") ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";
			
			$dba->SetQuery($query);
			$dba->execute();
		}
			
			// Add existing Fields
			$query = ' SELECT * from #__visfields c where c.fid='.$fid.' ';
			$fields = $this->_getList( $query );

			$tableFields = $dba->getTableColumns($tn,false);
			$n=count($fields );
			for ($i=0; $i < $n; $i++)
			{
				$rowField = $fields[$i];
				$fieldname = "F" . $rowField->id;
				
				if (!isset( $tableFields[$fieldname] )) 
				{
					$query = "ALTER TABLE ".$tn." ADD ".$fieldname." TEXT NULL";
					$dba->SetQuery($query);
					if (!$dba->execute()) 
					{
						echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
						return false;
					}
				}
				
			}

			return true;
    }

}
?>
