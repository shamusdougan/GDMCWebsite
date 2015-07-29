<?php 
/**
 * Visdata detail view for Visforms
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
 defined('_JEXEC') or die('Restricted access'); ?>
<?php 
    JHtml::_('behavior.keepalive');
    JHtml::_('behavior.formvalidation');

    if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif; ?>
        <script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'visdata.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			
			Joomla.submitform(task, document.getElementById('item-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_visforms&view=visdatas&fid=' . JFactory::getApplication()->input->getInt( 'fid', -1 ) . '&id=' . $this->item->id );?>" method="post" name="adminForm" id="item-form" class="form-validate">

    <div class="form-horizontal">
	<div class="row-fluid">
			<div class="span12">
				<fieldset class="adminform">
	<legend><?php echo JText::_('COM_VISFORMS_DATA_DETAIL'); ?></legend>
    <div class="control-group">
        <div class="control-label">
            <label id="id-lbl" title="" for="id"><?php echo JText::_( 'COM_VISFORMS_ID' ); ?>:
        </div>
        <div class="controls">
            <input type="text" class="readonly" size="10" value="<?php echo $this->item->id; ?>" readonly="" name="jform[id]"/>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label id="date-lbl" title="" for="date"><?php echo JText::_( 'COM_VISFORMS_DATE' ); ?>: 
        </div>
        <div class="controls">
            <input readonly="" class="readonly" size="10" type="text" value="<?php echo $this->item->created; ?>" name="jform[date]" />
        </div>
    </div>
              
	<?php	$k = 0;
		$n=count( $this->fields );
		for ($i=0; $i < $n; $i++)
		{
			$rowField = $this->fields[$i];
			if (!($rowField->showFieldInDataView === false))
			{
				$prop="F".$rowField->id;
				if (isset($this->item->$prop) == false)
				{
					$prop=$rowField->name;
				}
				
				if (isset($this->item->$prop))
				{
					$texte = $this->item->$prop;
				} else {
					$texte = "";
				}
                                
                if ($rowField->typefield == 'file')
                {
                    //info about uploaded files are stored in a JSON Object. Earlier versions just have a string.
                    $texte = JHTML::_('visforms.getUploadFileLink', $texte);
                }
							
 	?>
        <div class="control-group">
        <div class="control-label">
            <label id="F<?php echo $rowField->id; ?>-lbl" title="" for="F<?php echo $rowField->id; ?>"><?php echo  $rowField->label; ?>: 
        </div>
        <div class="controls">
            <?php 
			switch ($rowField->typefield)
			{
				case 'file' :
				?>
				<span class="inputbox"><?php echo  $texte; ?></span>
				<?php
				break;
				case 'textarea' :
			?>
				<textarea class="inputbox" type="text" value="<?php echo  $texte; ?>" name="jform[F<?php echo $rowField->id; ?>]">
                <?php echo  $texte; ?>
				</textarea>
			<?php
				break;
				default :			
			 ?>
            <input class="inputbox" type="text" value="<?php echo  $texte; ?>" name="jform[F<?php echo $rowField->id; ?>]" />
            <?php 
            }
            ?>
        </div>
    </div>
            
	<?php	
			}
		}
 	?>
        <div class="control-group">
        <div class="control-label">
            <label id="ip-lbl" title="" for="ip"><?php echo JText::_( 'COM_VISFORMS_IP' ); ?>:
        </div>
        <div class="controls">
            <input readonly="" class="readonly" size="10" type="text" value="<?php echo $this->item->ipaddress; ?>" name="jform[ip]" />
        </div>
    </div>
        </fieldset>
        </div>
    </div>
    </div>


<input type="hidden" name="task" value="" />

<?php echo JHtml::_('form.token'); ?>

</form>
    </div>
    </div>
<?php JHTML::_('visforms.creditsBackend'); ?>
