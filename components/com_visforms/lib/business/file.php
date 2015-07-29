<?php
/**
 * Visforms field file business class
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
defined('_JEXEC') or die('Restricted access');

/**
 * Perform business logic on field file
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsBusinessFile extends VisformsBusiness
{  
    /**
    * Public method to get the field object
    * @return object field
    */
   public function getFields()
    {
        $this->setField();
        return $this->fields;
    }

    /**
    * Process business logic on field
    */
   protected function setField()
    {
       $this->setIsDisabled();
       if (isset($this->field->dataSource) && $this->field->dataSource == 'post')
       {
            $this->validatePostValue();
       }
       $this->addShowWhenForForm();
    }
    
    /**
     * Method to validate values set by post according to business logic
     * Invalid post values can have effects on the disabled state of other fields
     * Therefor we do not validate for required yet!
     */
    protected function validatePostValue()
    {
        //upload fields do not have a post value
        return true;
    }
    
    /**
     * Methode to validate if a post value is set in field, if we deal with a post and the field is required and not disabled
     * @return object field
     */
    public function validateRequired()
    {
        if (isset($this->field->dataSource) && $this->field->dataSource == 'post')
        {
            $app = JFactory::getApplication();

            //check that a value is set if field is required
            if ((isset($this->field->attribute_required)) && ($this->field->attribute_required == true))
            {
                if (!(isset($this->field->isDisabled)) || ($this->field->isDisabled === false))
                {
                    if ((isset($_FILES[$this->field->name]['name']) === false) || (isset($_FILES[$this->field->name]['name']) && $_FILES[$this->field->name]['name'] ==''))
                    //if (VisformsValidate::validate('notempty', array('value' => $this->field->attribute_value)) == false)
                    {
                        $this->field->isValid = false;
                        //set error message
                        $app->enqueueMessage(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_UPLOAD', $this->field->label));
                    }
                }
            }
        }
        return $this->field;
    }
}
