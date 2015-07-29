<?php

/**
 * Visdata model for visforms
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

class VisformsModelVisdata extends JModelAdmin
{
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
		$form = $this->loadForm('com_visforms.visdata', 'visdata', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}   
        
         /**
	 * Method to get the visdatas model
	 *
	 * @return array Array of objects containing the data from the database
	 * @since	1.6
	 */
    public function getVisdatasModel()
    {
        $model = JModelLegacy::getInstance('Visdatas', 'VisformsModel', array('ignore_request' => true));
        if (!$model)
        {
            //todo throw an error
            return false;
        }
        else
        {
            return $model;
        }
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
	public function getTable($type = 'Visdata', $prefix = 'VisformsTable', $config = array())
	{	
		return JTable::getInstance($type, $prefix, $config);
	}
    
    /**
	 * Method to test whether a record state can be changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission for the component.
	 *
	 * @since   11.1
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
        $fid = JFactory::getApplication()->input->getInt('fid', -1);

		// Check form settings.
		if ($fid != -1) 
        {
			return $user->authorise('core.edit.state', 'com_visforms.visform.' . (int) $fid);
		}
		// Default to component settings 
		else {
			return parent::canEditState($record);
		}
	}
	
    /**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission for the component.
	 *
	 * @since   11.1
	 */
	protected function canDelete($record)
	{
        $fid = JFactory::getApplication()->input->getInt('fid', -1);
        $user = JFactory::getUser();

		// Check form settings.
		if ($fid != -1) 
        {
			return $user->authorise('core.delete.data', 'com_visforms.visform.' . (int) $fid);
		}
		else
		{
			//use component settings
            return $user->authorise('core.delete.data', 'com_visforms');
		}
	}
    
    public function setIsmfd($id, $state = true)
    {
        $table = $this->getTable();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName($table->getTableName('name')))
            ->set($db->quoteName('ismfd') . ' = ' . $state )
            ->where($db->quoteName('id') . ' = ' . $id);
        $db->setQuery($query);
        $db->execute();
    }
    
    public function restoreToUserInputs($id)
    {
        if ($this->checkIsmfd ($id))
        {
            $table = $this->getTable();
            $tableName = $table->getTableName('name');
            $saveTableName = $tableName . "_save";
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName($saveTableName))
                ->where($db->quoteName('mfd_id') . ' = ' . $id);
            $db->setQuery($query);
            if ($orgData = $db->loadObject())
            {
                $orgData->id = $id;
                unset($orgData->mfd_id);
                $orgData->ismfd = false;
                $db->updateObject($tableName, $orgData, 'id');
            }
        }
    }
    
    public function copyOrgData($data)
    {
        $id = $data['id'];
        $ismfd = false;
        $table = $this->getTable();
        $tableName = $table->getTableName('name');
        $saveTableName = $tableName . "_save";
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
            ->from($db->quoteName($tableName))
            ->where($db->quoteName('id') . ' = ' . $id);
        $db->setQuery($query);
        if ($orgData = $db->loadObject())
        {
            //check if data has really been modified
            foreach ($data as $dataname => $datavalue)
            {
                //only real formfield can be modified not the overhead fields. Fieldname of formfields in datatable starts with "F"
                if (($dataname === "" || strpos($dataname, "F") === 0) &&($datavalue !== $orgData->$dataname))
                {
                    $ismfd = true;
                    break;
                }
            }
            if (($ismfd == true) && ($orgData->ismfd == false))
            {
                //recordset is modified for the first time. We save the original user inputs in the save-table
                unset($orgData->id);
                $orgData->mfd_id = $id;
                $orgData->checked_out = 0;
                $orgData->checked_out_time = '0000-00-00 00:00:00';
                unset($orgData->ismfd);
                $db->insertObject($saveTableName, $orgData);
            }
        }
        return $ismfd;
    }
    
    public function deleteOrgData($id)
    {
        $table = $this->getTable();
        $saveTableName = $table->getTableName('name') . "_save";
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->delete($db->quoteName($saveTableName))
            ->where($db->quoteName('mfd_id') . ' = ' . $id);
        $db->setQuery($query);
        try
        {
            $db->execute();
        }
        catch (RuntimeException $e)
        {
            JError::raiseWarning(500, $e->getMessage);
           return false;
        }
        return true;
    }
    
    public function checkIsmfd ($id)
    {
        $table = $this->getTable();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('ismfd'))
            ->from($db->quoteName($table->getTableName('name')))
            ->where($db->quoteName('id') . ' = ' . $id);
        $db->setQuery($query);
        return $db->loadResult();
    }
}