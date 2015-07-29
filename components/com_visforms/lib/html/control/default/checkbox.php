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
class VisformsHtmlControlVisformsCheckbox extends VisformsHtmlControl
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
        $html .= '<div class="';
        $html .= (isset($field->isConditional) && ($field->isConditional == true)) ? 'conditional field' . $field->id : 'field' . $field->id;
        $html .= (isset($field->attribute_required) && ($field->attribute_required == true)) ? ' required' : '';
        //closing quote for class attribute
        $html .= '"';
        $html .= (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;" ' : "";
        $html .= '>';
        //error container
        $html .= '<div class="fc-tbx' . $field->errorId . '"></div>';
        if (($ccustomtext != '') && (isset($field->customtextposition)) && (($field->customtextposition == 0) || ($field->customtextposition == 1)))
        {
            $html .= $ccustomtext;
        }
        //label
        $html .= $clabel;
        //input
        $html .= '<input ';
        if (!empty($field->attributeArray)) 
        {
             //add all attributes
             $html .= JArrayHelper::toString($field->attributeArray, '=',' ', true);
        } 

        $html .=  '/>';
        if (($ccustomtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))
        {
            $html .= $ccustomtext;
        }
        $html .= '<p class="visCSSclear"><!-- --></p>';
        $html .= '</div>';       
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
        $html .= '<label class=" ' . $labelClass . ' ' .$field->labelCSSclass . '" id="' . $field->name. 'lbl" for="field' . $field->id .'">';
        $html .= JHTML::_('visforms.createTip', $field);
        $html .= '</label>';
        return $html;
   }
}

        