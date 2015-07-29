<?php
/**
 * Visforms field number class
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
require_once(__DIR__ . '/text.php');

/**
 * Visforms field number
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsFieldNumber extends VisformsFieldText
{
    /**
     * The the default value of the field which is displayed in the form according to field defition, query params, user inputs
     */
    
    protected function setFieldDefaultValue()
    {
        $field = $this->field;
        //if we have a POST Value, we use this
        if ((count($_POST) > 0) && isset($_POST['postid']) && ($_POST['postid'] == $this->form->id))
        {
            $this->validateUserInput('postValue');
            if (isset($_POST[$field->name]))
            {
                $this->field->attribute_value = $this->postValue;
            }
            else
            {
                $this->field->attribute_value = "";
            }
            $this->field->dataSource = 'post';
            return;
        }
        
        //if we have a GET Value and field may use GET values, we uses this
        if (isset($field->allowurlparam) && ($field->allowurlparam == true) && isset($this->queryValue) && !(is_null($this->queryValue)))
        {
            $this->validateUserInput('queryValue');
            $this->field->attribute_value = $this->queryValue;
            $this->field->dataSource = 'query';
            return;
        }
       
        //Nothing to do
        return;
    }
    
    /**
     * 
     * Method to validate user inputs, if not: set field property isValid to false and set error message
     * @param string $inputType user input type (postValue, queryValue)
     */
    protected function validateUserInput($inputType)
    {
        $type = $this->type;
        $value = $this->$inputType;
        //Empty value is valid
        if ($value == "")
        {
            return;
        }
        //if a value is set we test it is a valid number (which still may have dots and commas
        if (VisformsValidate::validate($type, array('value' => $value)))
        {
            return;
        }
        else
        {
            //invalid user inputs - set field->isValid to false
            $this->field->isValid = false;
            //set the Error Message
            VisformsMessage::getMessage($this->field->name, $type);
            return;
        }
    }
}