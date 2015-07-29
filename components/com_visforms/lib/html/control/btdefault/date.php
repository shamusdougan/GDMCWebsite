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
 * create btdefault date HTML control
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlBtdefaultDate extends VisformsHtmlControl
{
   
    /**
    * Method to create the html string for control
    * @return string html
    */
   public function getControlHtml ()
   {
        $field = $this->field->getField();
        $html = '';
        //date control is displayed in a div without usable css class (Joomla! core)
        //we inclose the control in a div class="asterix-ancor"
        if (isset($field->attribute_required) && ($field->attribute_required == 'required') && (isset($field->show_label) && ($field->show_label == 1))) 
        {
            $html .= '<div class="asterix-ancor">';
        }
        //input
        $html .= JHTML::calendar($field->attribute_value, $field->name, 'field' . $field->id, $field->dateFormatJs, $field->attributeArray);
        //close additional div
        if (isset($this->field->attribute_required) && ($this->field->attribute_required == 'required') && (isset($this->field->show_label) && ($this->field->show_label == 1))) 
        {
            $html .= '</div>';
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
        //hide label with css if this option is set, so we can still use it in aria-labelledby
        $style = (isset($field->show_label) && ($field->show_label == 1)) ? ' style="display: none;"' : '';        
        $html .= '<label class=" ' . $labelClass . ' '  .$field->labelCSSclass . '" id="' . $field->name. 'lbl" for="field' . $field->id .'"' . $style . '>';
        $html .= JHTML::_('visforms.createTip', $field);
        $html .= '</label>';
        return $html;
   }
}