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
 * Decorate HTML control for Bootstrap default layout
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlDecoratorBtDefault  extends VisformsHtmlControlDecorator
{
   /**
    * Decorate (wrap) html code with bootstrap default html code
    * @param object $field visforms form field
    * @return type
    */
   protected function decorate ()
    {
        //we wrap the control in a div if the field isCondtional, so that we can easily hide the whole control
        //the div class=control is part of the control because it's position divers, depending on the field type
        $control = $this->control;
        $field = $control->field->getField();
        $clabel = $control->createlabel();
        $ccontrol = $control->getControlHtml();
        $ccustomtext = $control->getCustomText();
        $html = "";
        if (($clabel != "") || ($ccontrol != "") || ($ccustomtext != ""))
        {
            $html .= '<div class="fc-tbx' . $field->errorId . '"></div>';
            $html .= '<div class="';
            $html .= (isset($field->isConditional) && ($field->isConditional == true)) ? 'conditional field' . $field->id : 'field' . $field->id;
            $html .= (isset($field->attribute_required) && ($field->attribute_required == true)) ? ' required' : '';
            //closing quote for class attribute
            $html .= '"';
            $html .= (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;" ' : "";
            $html .= '>';
            if (($ccustomtext != '') && (isset($field->customtextposition)) && ($field->customtextposition == 0))
            {
                $html .= $ccustomtext;
            }
            $html .= $clabel;
            if (($ccustomtext != '') && (isset($field->customtextposition)) && ($field->customtextposition == 1))
            {
                $html .= $ccustomtext;
            }
            $html .= $ccontrol;
            if (($ccustomtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))
            {
                $html .= $ccustomtext;
            }
            $html .= '</div>';
        }       
        return $html;
    }
}
?>