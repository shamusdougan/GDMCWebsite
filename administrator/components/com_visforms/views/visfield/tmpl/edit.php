<?php 
/**
 * Visfield field view for Visforms
 *
 * @author       Aicha Vack
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */
 
//no direct access
 defined('_JEXEC') or die('Restricted access');  
    
	JHtml::_('behavior.formvalidation');
	JHtml::_('behavior.keepalive');?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'visfield.cancel') {
				Joomla.submitform(task, document.getElementById('item-form'));
		} else if (document.formvalidator.isValid(document.id('item-form'))) {
            //make sure the typefield has a selected value
            var ft = document.getElementById('jform_typefield');
            var idx = ft.selectedIndex;
            var sel = ft[idx].value;
            switch (sel)
            { 
                case '0' :
                    alert('<?php echo $this->escape(JText::_('COM_VISFORMS_TYPE_FIELD_REQUIRED'));?>');
                    break;
                case 'checkbox' :
                    var cbval = document.getElementById('jform_defaultvalue_f_checkbox_attribute_value');
                    if (cbval.value == "")
                    {
                        alert('<?php echo $this->escape(JText::_('COM_VISFORMS_CHECKBOX_VALUE_REQUIRED'));?>');
                    }
                    else
                    {
                        Joomla.submitform(task, document.getElementById('item-form'));
                    }
                    break;
                case 'multicheckbox' :
                case 'radio' :
                    var grpel = document.getElementById('jform_defaultvalue_f_' + sel + '_list_hidden');
                    var countDefOpts = document.getElementById('jform_defaultvalue_f_' + sel + '_countDefaultOpts').value;
                    if (grpel.value == "" || grpel.value == "{}")
                    {
                        alert('<?php echo $this->escape(JText::_('COM_VISFORMS_OPTIONS_REQUIRED'));?>');
                    }
                    else if (countDefOpts > 1)
                    {
                        alert('<?php echo $this->escape(JText::_('COM_VISFORMS_ONLY_ONE_DEFAULT_OPTION_POSSIBLE'));?>');
                    }
                    else
                    {
                        Joomla.submitform(task, document.getElementById('item-form'));
                    }
                    break;
                case 'select' :
                    var grpel = document.getElementById('jform_defaultvalue_f_' + sel + '_list_hidden');
                    var countDefOpts = document.getElementById('jform_defaultvalue_f_' + sel + '_countDefaultOpts').value;
                    var isMultiple = document.getElementById('jform_defaultvalue_f_' + sel + '_attribute_multiple').checked;
                    if (grpel.value == "" || grpel.value == "{}")
                    {
                        alert('<?php echo $this->escape(JText::_('COM_VISFORMS_OPTIONS_REQUIRED'));?>');
                    }
                    else if ((countDefOpts > 1) && (isMultiple == false))
                    {
                        alert('<?php echo $this->escape(JText::_('COM_VISFORMS_ONLY_ONE_DEFAULT_OPTION_POSSIBLE'));?>');
                    }
                    else
                    {
                        Joomla.submitform(task, document.getElementById('item-form'));
                    }
                    break;
                    case 'image':
                        var altt = document.getElementById('jform_defaultvalue_f_image_attribute_alt');
                        var image = document.getElementById('jform_defaultvalue_f_image_attribute_src');
                        if ((altt.value == "") || (image.value == ""))
                        {
                            if (altt.value == "")
                            {
                                alert('<?php echo $this->escape(JText::_('COM_VISFORMS_ALT_TEXT_REQUIRED'));?>');
                            }
                            else
                            {
                                alert('<?php echo $this->escape(JText::_('COM_VISOFORMS_FIELD_IMAGE_IMAGE_REQUIRED'));?>');
                            }
                        }
                        else
                        {
                            Joomla.submitform(task, document.getElementById('item-form'));
                        }
                    break;
                default :
                    Joomla.submitform(task, document.getElementById('item-form'));
                    break;
            }
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_visforms&view=visfields&fid=' . $this->item->fid); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="form-inline form-inline-header">
        <?php
        echo $this->form->getControlGroup('label');
        echo $this->form->getControlGroup('name');
        ?>
    </div>
    <div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'basicfieldinfo')); ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'basicfieldinfo', JText::_('COM_VISFORMS_FIELD_BASIC_INFO')); ?>
                <div class="row-fluid form-horizontal-desktop">
                    <div class="span6">
                        <?php foreach ($this->form->getFieldset('basicfieldinfo') as $field) 
                        { ?>
                            <?php if($field->fieldname != 'ordering')
                            { ?>
                                <div class="control-group">
                                    <div class="control-label">
                                        <?php echo $field->label; ?>
                                    </div>
                                    <div class="controls">
                                        <?php echo $field->input; ?>
                                    </div>
                                </div>
                            <?php 
                            } ?>
                        <?php 
                        } ?>
                    </div>
                    <div class="span6">
                        <?php  $groupFieldSets = $this->form->getFieldsets('defaultvalue'); ?>
                           <?php foreach ($groupFieldSets as $name => $fieldSet) : 
                               $fieldsetId = $name;
                           ?>						
                                <div id="<?php echo $name; ?>">
                                   <?php foreach ($this->form->getFieldset($name) as $field) { ?>
                                           <?php
                                           //if we have a Calender field we have to set default dateformat for Calender
                                           if ($field->fieldname === "f_date_attribute_value") {
                                               $dateformatfield = $this->form->getField('f_date_format', 'defaultvalue');
                                               if ($dateformatfield->value != "") {
                                                   // get dateformat for javascript	
                                                   $dformat = explode(";", $dateformatfield->value);
                                                   if (isset($dformat[1])) 
                                                    {
                                                        $this->form->setFieldAttribute("f_date_attribute_value", "format", $dformat[1], 'defaultvalue');
                                                   }							
                                               }
                                           }
                                           ?>
                                            <div class="control-group">
                                                
                                                <div class="control-label">
                                                    <?php echo $field->label; ?>
                                                </div>
                                                <div class="controls">
                                                    <?php echo $field->input; ?>
                                                </div>
                                           </div>
                                   <?php } ?>
                               </div>
                         <?php endforeach; ?>
                    </div>
                </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'visfield-advanced-detailso', JText::_('COM_VISFORMS_TAB_ADVANCED')); ?>
            <div class="row-fluid form-horizontal-desktop">
                <div class="span6">
                    <?php $fslayout = $this->form->getFieldset('visfield-layout-details'); ?>
                    <?php foreach ($fslayout as $field) { ?>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo $field->label; ?>
                            </div>
                            <div class="controls">
                                <?php echo $field->input; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="span6">
                    <?php $fsadvanced = $this->form->getFieldset('visfield-advanced-details'); ?>
                    <?php foreach ($fsadvanced as $field) { ?>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo $field->label; ?>
                            </div>
                            <div class="controls">
                                <?php echo $field->input; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>		
					
	<?php if ($this->canDo->get('core.admin'))
    {
        echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_VISFORMS_FIELDSET_FIELD_RULES', true)); 
        echo $this->form->getInput('rules'); 
        JHtml::_('bootstrap.endTab');
    }
     
     echo JHtml::_('bootstrap.endTabSet');
     ?>
		<input type="hidden" name="option" value="com_visforms" />
		<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="fid" value="<?php echo $this->fid; ?>" />
		<input type="hidden" name="ordering" value="<?php echo $this->item->ordering; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="visfields" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
   
</form>
 <div id="formMaster" class="itemForm well" style=" display: none;">
     <h2 data-original-title="<?php echo JText::_('COM_VISFORMS_ITEMLISTCREATOR_TITLE'); ?>"><?php echo JText::_('COM_VISFORMS_ITEMLISTCREATOR_TITLE'); ?></h2>
     <div class="control-group listitemid">
         <div class="controls">
            <input class="listitemid" type="hidden" value="" name="listitemid">
         </div>
     </div>
    <div class="control-group listitemvalue">
        <div class="control-label">
            <label class="listitemvalue-lbl" class="" for="listitemvalue" data-original-title="<?php echo JText::_('COM_VISFORMS_SELECT_VALUE_DESC');?>"><?php echo JText::_('COM_VISFORMS_VALUE'); ?> *</label>
        </div>
        <div class="controls">
            <input class="listitemvalue" type="text" value="" name="listitemvalue">
        </div>
    </div>
    <div class="control-group listitemlabel">
        <div class="control-label">
            <label class="listitemlabel-lbl" class="" for="listitemlabel" data-original-title="<?php echo JText::_('COM_VISFORMS_SELECT_LABEL_DESC');?>"><?php echo JText::_('COM_VISFORMS_LABEL'); ?> *</label>
        </div>
        <div class="controls">
            <input class="listitemlabel" type="text" value="" name="listitemlabel" >
        </div>
    </div>
    <div class="control-group listitemischecked">
        <div class="control-label">
            <label class="listitemischecked-lbl" class="" for="listitemlabel" data-original-title="<?php echo JText::_('COM_VISFORMS_SELECT_DEFAULT_DESC');?>"><?php echo JText::_('COM_VISFORMS_DEFAULT'); ?></label>
        </div>
        <div class="controls">
            <input class="listitemischecked" type="checkbox" value="1" name="listitemischecked">
        </div>
    </div>
 </div>