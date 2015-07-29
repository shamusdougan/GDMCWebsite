<?php
/**
 * Visforms create control HTML class
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
 * create visforms default radio HTML control
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlBtdefaultRadio extends VisformsHtmlControl
{
   
    /**
    * Method to create the html string for control
    * @return string html
    */
   public function getControlHtml ()
   {
        $field = $this->field->getField();
        $html = '';
        $k=count($field->opts);
        $checked = "";
        $inputAttributes = (!empty($field->attributeArray)) ? JArrayHelper::toString($field->attributeArray, '=',' ', true) : '';

        if (isset($field->display) && $field->display == 'LST')
        {
            $labelClass = "radio";
        }
		else 
        {
            $labelClass ="radio inline";
        }
        for ($j=0;$j < $k; $j++)
        {	
            if ($field->opts[$j]['selected'] != false) 
            {
                $checked = 'checked="checked" ';
            }
            else
            {
                $checked = "";
            }
            $html .= '<label class="'.  $labelClass . ' ' . $field->labelCSSclass . '" id="' . $field->name . 'lbl_' . $j .'" for="field' . $field->id . '_' . $j .'">' . $field->opts[$j]['label'];
            $html .= '<input id="field' . $field->id . '_' . $j . '" name="' . $field->name .'" value="' . $field->opts[$j]['value'] .'" ' . $checked  . $inputAttributes . ' aria-labelledby="' . $field->name . 'lbl ' . $field->name . 'lbl_' . $j . '" />';
            $html .= '</label>';
        }
        return $html;
   }
   
   /**
    * Method to create the html string for control label
    * @return string html
    */
   public function createLabel()
   {
        $field = $this->field->getField();
        $labelClass = $this->getLabelClass();
        //label
        $html = '';
        

        //label
        $html .= '<label class=" '. $labelClass .$field->labelCSSclass . '" id="' . $field->name. 'lbl">';
        $html .= JHTML::_('visforms.createTip', $field);  
        $html .= '</label>';
        return $html;
   }
   
   /**
    * 
    * @param object $field field object
    * @return string errorId
    */
   public function getErrorId($field)
   {
       return 'field' . $field->id . '_0';
   }
   
   /**
    * Method to create class attribute value for label tag according to layout
    * @return string class attribute value
    */
   protected function getLabelClass ()
   {
       $labelClass = '';
       switch ($this->layout)
       {
           case 'bthorizontal' :
               $labelClass = ' control-label ' ;
               break;
           default :
               break;
       }
       return $labelClass;
   }
}