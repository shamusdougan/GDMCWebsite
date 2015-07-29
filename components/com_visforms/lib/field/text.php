<?php
/**
 * Visforms field text class
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
 * Visforms field text
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsFieldText extends VisformsField
{
    /**
     * 
     * Constructor
     * 
     * @param object $field field object as extracted from database
     * @param object $form  form object as extracted from database
     */
    
    public function __construct($field, $form)
    {
        parent::__construct($field, $form);
        $this->queryValue = $this->input->get->get($field->name, null, 'STRING');
        $this->postValue = $this->input->post->get($field->name, '', 'STRING'); 
    }
    
    /**
     * Public method to get the field object
     * @return object VisformsFieldText
     */
    
    public function getField()
    {
        $this->setField();
        return $this->field;
    }
    
    /**
     * Preprocess field. Set field properties according to field definition, query params, user inputs
     */
    
    protected function setField()
    {
        //preprocessing field
        $this->extractDefaultValueParams();
        $this->extractRestrictions();
        $this->mendBooleanAttribs();
        $this->setIsConditional();
        $this->setFieldDefaultValue();
        $this->setDbValue();
    }
    
    /**
     * The the default value of the field which is displayed in the form according field defition, query params, user inputs
     */
    
    protected function setFieldDefaultValue()
    {
        $field = $this->field;
        //if we have a POST Value, we use this
        if ((count($_POST) > 0) && isset($_POST['postid']) && ($_POST['postid'] == $this->form->id))
        {
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
            $this->field->attribute_value = $this->queryValue;
            $this->field->dataSource = 'query';
            return;
        }
        //if we have a special default value set in field declaration we use this
        if ((isset($field->fillwith) && $field->fillwith != "")) 
        {
            $user = JFactory::getUser();
            $userId = $user->get('id');
            if($userId != 0)
            {
                if($field->fillwith == 1)
                {
                    $this->field->attribute_value = $user->get('name');
                    return;
                }
                if($field->fillwith == 2)
                {
                    $this->field->attribute_value = $user->get('username');
                    return;
                }
            }
        }
        //Nothing to do
        return;
    }
    
    /**
     * Method to convert post values into a string that can be stored in db and attach it as property to the field object
     */
    protected function setDbValue()
    {
        if (isset($this->field->dataSource) && $this->field->dataSource == 'post')
        {
            $this->field->dbValue = $this->postValue;
        }
    }
}