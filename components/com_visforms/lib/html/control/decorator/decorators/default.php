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
 * Decorate HTML control for default Visforms layout
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsHtmlControlDecoratorDefault  extends VisformsHtmlControlDecorator
{
    /**
    * Decorate (wrap) html code with visforms default html code
    * @param object $field visforms form field
    * @return type
    */
    protected function decorate ()
    {
        //we wrap the control in a div in visforms default layout
        $control = $this->control;
        $field = $control->field->getField();
        $clabel = $control->createlabel();
        $ccontrol = $control->getControlHtml();
        $ccustomtext = $control->getCustomText();
        $html = "";
        $class = (isset($field->isConditional) && ($field->isConditional == true)) ? 'conditional field' . $field->id  : 'field' . $field->id;
        $required = (isset($field->attribute_required) && ($field->attribute_required == true)) ? ' required' : '';
        $style = (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;"' : "";
        if (($clabel != "") || ($ccontrol != "") || ($ccustomtext != ""))
        {
            $html .= '<div class="';   
            //$html .= (isset($field->isConditional) && ($field->isConditional == true)) ? ' class="conditional field' . $field->id . '"' : '';
            //$html .= (isset($field->isDisabled) && ($field->isDisabled == true)) ? ' style="display:none;"' : "";
            $html .= $class;
            $html .= $required;
            $html .='"';
            $html .= $style;
            $html .= '>';
            if (($ccustomtext != '') && (isset($field->customtextposition)) && (($field->customtextposition == 0) || ($field->customtextposition == 1)))
            {
                $html .= $ccustomtext;
            }
            $html .= '<div class="fc-tbx' . $field->errorId . '"></div>';
            $html .= $clabel;
            $html .= $ccontrol;
            if (($ccustomtext != '') && (((isset($field->customtextposition)) && ($field->customtextposition == 2)) || !(isset($field->customtextposition))))
            {
                $html .= $ccustomtext;
            }
            $html .= '<p class="visCSSclear"><!-- --></p>';
            $html .= '</div>';
        }        
        return $html;
    }
}
?>