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
 * create visforms default select HTML control
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlVisformsSelect extends VisformsHtmlControl
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
        $options = array();
        $checked = array();

        //Has select no default value? Then we need a supplementary 'default' option for selects that are not "multiple" or have a height < 1. Otherwise the first option can not be selected properly.

        if (((!(isset($field->attribute_multiple)) || ($field->attribute_multiple != 'multiple' && $field->attribute_multiple != '1' && $field->attribute_multiple != true)) && (!isset($field->attribute_size) || ($field->attribute_size == '' || $field->attribute_size <= 1)) && (!(isset($field->list_hidden))|| strpos($field->list_hidden,'listitemischecked') == false))) {
            $options[] = JHTML::_('select.option', '', JText::_('CHOOSE_A_VALUE'));
        }
        for ($j=0;$j < $k; $j++)
        {	
            if ($field->opts[$j]['selected'] != false) 
            {
                $checked[] = $field->opts[$j]['value'];
            }

            $options[] = JHTML::_('select.option', $field->opts[$j]['value'], $field->opts[$j]['label']);	
        }
        $html .= JHTML::_('select.genericlist', $options, $field->name . '[]', array('id'=>'field' . $field->id,'list.attr'=>$field->attributeArray, 'list.select'=>$checked));
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
        $html .= '<label class=" '. $labelClass . ' ' .$field->labelCSSclass . '" id="' . $field->name. 'lbl" for="field' . $field->id .'">';
        $html .= JHTML::_('visforms.createTip', $field); 
        $html .= '</label>';
        return $html;
   }
}