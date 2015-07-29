<?php
/**
 * Visforms decorator class for HTML controls
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
 * Decorate HTML control for Bootstrap horizontal layout
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlDecoratorBtHorizontal  extends VisformsHtmlControlDecorator
{
      
   /**
    * Decorate (wrap) html code with bootstrap horizontal html code
    * @param object $field visforms form field
    * @return type
    */
   protected function decorate ()
   {
        //we can only decorate the outer bootstrap horizontal div class=control group, 
        //the inner div class=control is part of the control because it's position divers, depending on the field type
        $control = $this->control;
        $field = $control->field->getField();
        $clabel = $control->createlabel();
        $ccontrol = $control->getControlHtml();
        $ccustomtext = $control->getCustomText();
        $html = "";
        if (($clabel != "") || ($ccontrol != "") || ($ccustomtext != ""))
        {
            $html .= '<div class="fc-tbx' . $field->errorId . '"></div>';
            //Extra Markup for Bootstrap horizontal layout)
            $html .= ' <div class="control-group';
            $html .= (isset($field->isConditional) && ($field->isConditional == true)) ? ' conditional field' . $field->id : '';
            $html .= (isset($field->attribute_required) && ($field->attribute_required == true)) ? ' required' : '';
            //closing quote for class attribute
            $html .= '"';
            $html .= (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;">' : '>';
            if (($ccustomtext != '') && (isset($field->customtextposition)) && (($field->customtextposition == 0) || ($field->customtextposition == 1)))
            {
                $html .= '<div class="controls">';
                $html .= $ccustomtext;
                $html .= '</div>';
            }
            $html .= $clabel;
            $html .= '<div class="controls">';
            $html .= $ccontrol;
            $html .= '</div>';
            if (($ccustomtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))
            {
                $html .= '<div class="controls">';
                $html .= $ccustomtext;
                $html .= '</div>';
            }
            $html .= '</div>';
        }  
        return $html;
    }
}
?>