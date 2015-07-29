<?php
/**
 * Visforms field select business class
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
 * Perform business logic on field select
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsBusinessSelect extends VisformsBusiness
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
        //rules for selects are: maxcount
        
        //update $this->field with value from $this->fields
        $this->updateField();
        
        $app = JFactory::getApplication();
        $valid = true;
       
        //check that we do not have to many selected values in user input
        if (!(isset($this->field->attribute_multiple)) || ($this->field->attribute_multiple == false))
        {
            $maxcount = 1;
            $count = 0;
            //get count ouf selected options
            foreach ($this->field->opts as $opt)
            {
                if (isset($opt['selected']) && ($opt['selected'] == true))
                {
                    $count++;
                }
            }
            if (VisformsValidate::validate('max', array('count' => $count, 'maxcount' => $maxcount)) == false)
            {
                //invalid value
                $valid = false;
                //set error message
                $app->enqueueMessage(JText::sprintf('COM_VISFORMS_FIELD_MAX_LENGTH_MULTICHECKBOX', $maxcount, $this->field->label));
                //only the last option will be displayed as selected in form
                //set selected to false except for the last selected option, 
                $optCount=count ($this->field->opts);
                for ($i = 0; $i < $optCount; $i++)
                {
                    //unselect option
                    if (isset($this->field->opts[$i]['selected']) && ($this->field->opts[$i]['selected'] == true) && $count != 1)
                    {
                        $this->field->opts[$i]['selected'] = false;
                        $count--;
                    }
                    //perform additional things, which may be necessary because of the wrong amount of selected values, when we reach the last option
                    if ($i == ($optCount - 1))
                    {
                        if (isset($this->field->isDisplayChanger) && ($this->field->isDisplayChanger == true))
                        {
                            //mend isDisabled property in all depending fields (setIsDisabeld() is recursive)
                            foreach ($this->fields as $child)
                            {
                                //only check for fields that are not $this->field
                                if($child->id != $this->field->id)
                                {
                                    $this->setIsDisabled($child);
                                }
                            }
                            break;
                        }
                        else
                        {
                            break;
                        }
                    }
                }
            }
        }
        
        //validate unique field value in database
            $this->validateUniqueValue();
        
        //at least one validation failed
       if (!$valid)
       {
           $this->field->isValid = false;
       }
    }
    
    /**
     * Methode to validate if a post value is set in a required field, if we deal with a post and the field is required and not disabled
     * @return object field
     */
    public function validateRequired()
    {
        if (isset($this->field->dataSource) && $this->field->dataSource == 'post')
        {
            $app = JFactory::getApplication();
        
            //check that on option is selected if field is required        
            if ((isset($this->field->attribute_required)) && ($this->field->attribute_required == true))
            {
                //only for fields that are not disabled
                if (!isset($this->field->isDisabled) || ($this->field->isDisabled === false))
                {
                    $optionSelected = false;
                    foreach ($this->field->opts as $opt)
                    {
                        if (isset($opt['selected']) && ($opt['selected'] == true))
                        {
                            $optionSelected = true;
                            break;
                        }
                    }
                    if ($optionSelected == false)
                    {
                        $this->field->isValid = false;
                        //set error message
                        $app->enqueueMessage(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_RADIO_SELECT', $this->field->label));
                    }
                }
            }
        }
        return $this->field;
    }
}