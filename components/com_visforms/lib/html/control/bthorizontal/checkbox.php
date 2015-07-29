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
 * create visforms default checkbox HTML control
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlBthorizontalCheckbox extends VisformsHtmlControl
{
   
    /**
    * Method to create the html string for control
    * @return string html
    */
   public function getControlHtml()
   {
        $field = $this->field->getField();
        $clabel = $this->createlabel();
        $ccustomtext = $this->getCustomText();
        $html = "";
        $html .= '<div class="fc-tbx' . $field->errorId . '"></div>';
        //we wrap the control in a div if the field isCondtional, so that we can easily hide the whole control
        //the div class=control is part of the control because it's position divers, depending on the field type
        $html .= '<div class="control-group ';
        $html .= (isset($field->isConditional) && ($field->isConditional == true)) ? ' conditional field' . $field->id : 'field' . $field->id;
        $html .= (isset($field->attribute_required) && ($field->attribute_required == true)) ? ' required' : '';
        //closing quote for class attribute
        $html .= '"';
        $html .= (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;" ' : "";
        $html .= '>';
        if (($ccustomtext != '') && (isset($field->customtextposition)) && (($field->customtextposition == 0) || ($field->customtextposition == 1)))
            {
                $html .= '<div class="controls">';
                $html .= $ccustomtext;
                $html .= '</div>';
            }
            $html .= $clabel;
        $html .= '<div class="controls">';
        $html .= '<label class="checkbox ' .$field->labelCSSclass . ' " id="' . $field->name. 'lbl" for="field'. $field->id . '">';
        $html .= '<input ';

        if (!empty($field->attributeArray)) 
        {
                //add all attributes
                $html .= JArrayHelper::toString($field->attributeArray, '=',' ', true);
        } 
        $html .= '/>';
        $html .= JHTML::_('visforms.createTip', $field);
        $html .= "</label>";
        $html .= '</div>';
         if (($ccustomtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))
            {
                $html .= '<div class="controls">';
                $html .= $ccustomtext;
                $html .= '</div>';
            }
        $html .= '</div>';
        return $html;     
   }
   
   /**
    * Method to create the html string for control label
    * @return string html
    */
   public function createLabel()
   {
        //label is part of the control but we add a span which can take the required asterix if the checkbox is required
        $field = $this->field->getField();
        $labelClass = $this->getLabelClass();
        $html = '';
        //create an empty span that can take on the required asterix
        if (isset($field->attribute_required) && ($field->attribute_required == 'required')) 
        {
            $html .= '<span class="' . $labelClass . '"></span>';
        }
        return $html;
   }
}

        