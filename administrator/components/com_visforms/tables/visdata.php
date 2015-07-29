<?php

/**
 * Visform table class
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
require_once(JPATH_ADMINISTRATOR . '/components/com_visforms/models/visdatas.php');
require_once(JPATH_SITE . '/components/com_visforms/lib/validate.php');
require_once(JPATH_SITE . '/components/com_visforms/lib/message.php');

/**
 * Data Table class
 *
 * @package    Joomla.Administrator
 * @subpackage com_visforms
 * 
 */

class VisformsTableVisdata extends JTable 
{
    public function __construct(&$db) 
    {
        $id = JFactory::getApplication()->input->getInt('fid', -1);
        parent::__construct('#__visforms_' . $id, 'id', $db);
    }
    
    public function check()
    {
        $model = new VisformsModelVisdatas();
        $fields = $model->getDatafields();
        $check = true;
        foreach ($fields as $field)
        {
            $fname = 'F'.$field->id;
            if (($field->typefield == 'date') && (isset($this->$fname)) && ($this->$fname != ""))
            {
                $formats = explode(';', $field->defaultvalue['f_date_format']);
                $format = $formats[0];
                if ((VisformsValidate::validate('date', array('value' => $this->$fname, 'format' => $format))) == false)
                {
                    JFactory::getApplication()->enqueueMessage(JText::sprintf('COM_VISFORMS_DATE_FORMAT_CANNOT_BE_CHANGED', $field->name, $format), 'warning');
                    $check = false;
                }
            }
        }
        return $check;
    }
    
}