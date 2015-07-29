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
 * create visforms default submit HTML control
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlVisformsSubmit extends VisformsHtmlControl
{
   
    /**
    * Method to create the html string for control
    * @return string html
    */
   public function getControlHtml ()
   {
        $field = $this->field->getField();
        $html = '';
        if (($field->customtext != '') && (isset($field->customtextposition)) && (($field->customtextposition == 0) || ($field->customtextposition == 1)))  
        {
			JPluginHelper::importPlugin('content');
			$customtext =  JHtml::_('content.prepare', $field->customtext);
            $html .= '<div class="visCustomText ">' . $customtext. '</div>';
        }
        $html .=  '<input ';
        if (!empty($field->attributeArray)) 
        {
            //add all attributes
            $html .= JArrayHelper::toString($field->attributeArray, '=',' ', true);
        } 
        $html .= '/>&nbsp;';
        if (($field->customtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))  
        {
			JPluginHelper::importPlugin('content');
			$customtext =  JHtml::_('content.prepare', $field->customtext);
            $html .= '<div class="visCustomText ">' . $customtext. '</div>';
        }

       return $html;
   }
   
   public function getCustomText()
   {
       return '';
   }
}