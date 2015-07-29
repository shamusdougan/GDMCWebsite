<?php

/**
 * @author      Aicha Vack
 * @package     Joomla.Site
 * @subpackage  com_visforms
 * @link        http://www.vi-solutions.de
 * @copyright   2014 Copyright (C) vi-solutions, Inc. All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('hidden');
JHtml::_('bootstrap.framework');
JHtml::_('formbehavior.chosen', 'select');

class JFormFieldItemlistcreator extends JFormFieldHidden
{
	protected $type='itemlistcreator';
    
	protected function getInput()
	{
        $doc = JFactory::getDocument();
        $doc->addScript(JURI::root(true).'/administrator/components/com_visforms/js/itemlistcreator.js');
		$texts =  "{texts : {txtMoveUp: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_MOVE_UP' )). "',".
				"txtMoveDown: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_MOVE_DOWN' )). "',".
				"txtChange: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_CHANGE' )). "',".
				"txtDelete: '" . addslashes(JText::_( 'COM_VISFORMS_DEL' )). "',".
				"txtClose: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_CLOSE' )). "',".
				"txtAddItem: '" . addslashes(JText::_( 'COM_VISFORMS_ADD' )). "',".
                "txtCreateItem: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_CREATE_NEW_ITEM' )). "',".
				"txtReset: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_RESET' )). "',".
				"txtSave: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_SAVE' )). "',".
                "txtJYes: '" . addslashes(JText::_( 'JYES' )). "',".
                "txtJNo: '" . addslashes(JText::_( 'JNO' )). "',".
                "txtAlertRequired: '" . addslashes(JText::_( 'COM_VISFORMS_ITEMLISTCREATOR_REQUIRED_LABEL_VALUE' )). "',".
                "txtValue: '" . addslashes(JText::_( 'COM_VISFORMS_VALUE' )). "',".
                "txtLabel: '" . addslashes(JText::_( 'COM_VISFORMS_LABEL' )). "',".
                "txtDefault: '" . addslashes(JText::_( 'COM_VISFORMS_DEFAULT' )). "'".
			"},"
            . " params: {fieldName : '" . $this->fieldname . "'}"
            . "}";
		$script = 'var visformsItemlistCreator' . $this->fieldname. ' = jQuery(document).ready(function() {jQuery("#item-form").visformsItemlistCreator(' . $texts . ')});';
		$doc->addScriptDeclaration($script);
		
        $hiddenInput = parent::getInput();
		$html = $hiddenInput;
		
		return $html;
	}
	
}