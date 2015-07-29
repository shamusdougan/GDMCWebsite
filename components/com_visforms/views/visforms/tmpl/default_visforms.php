<?php
/**
 * Visforms default view for Visforms
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

JHTMLVisforms::includeScriptsOnlyOnce();
	
if ($this->visforms->published != '1') {return;}
?>

<form action="<?php echo JRoute::_($this->formLink); ?>" method="post" name="visform" id="visform<?php echo $this->visforms->id; ?>" class="visform <?php echo $this->visforms->formCSSclass; ?>"<?php if($this->upload == true) { ?> enctype="multipart/form-data"<?php } ?>>
<fieldset>
		
<?php 
	//Explantion for * if at least one field is requiered at the top of the form
	if ($this->required == true && $this->visforms->required == 'top')
	{
    ?>
        <div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php          
    }
 
	//first hidden fields at the top of the form
	for ($i=0;$i < $this->nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if ($field->typefield == "hidden")
		{
            echo $field->controlHtml;
		}
	}

	//then inputs, textareas, selects and fieldseparators
	for ($i=0;$i < $this->nbFields; $i++)
	{ 
        $field = $this->visforms->fields[$i];
        if ($field->typefield != "hidden" && !isset($field->isButton))
        {

            //set focus to first visible field
            if (($this->firstControl == true) && ((!(isset($field->isDisabled))) || ($field->isDisabled == false)))
            {
                $script= '';
                $script .= 'jQuery(document).ready( function(){';
                $script .= 'jQuery("#'. $field->errorId.'").focus();';
                $script .= '});';
                $doc = JFactory::getDocument();
                $doc->addScriptDeclaration($script);
                $this->firstControl = false;
            }

            //display the control
            echo $field->controlHtml;
        }   	
    }

	//Explantion for * if at least one field is requiered above captcha
	if ($this->required == true && $this->visforms->required == 'captcha')
	{
    ?>
        <div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php  
    }
    
    //show the captcha if it is set in form settings
    if (isset($this->visforms->captcha) && ($this->visforms->captcha == 1 || $this->visforms->captcha == 2))
	{
             echo JHTML::_('visforms.getCaptchaHtml', $this->visforms);
	} 

	//Explantion for * if at least one field is requiered above submit
	if ($this->required == true && $this->visforms->required == 'bottom')
	{
    ?>
	<div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php   
    } 
    ?>
    
    <div class="visBtnCon">
	<?php 
	//all button on the bottom of the form
	for ($i=0;$i < $this->nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if (isset($field->isButton) && $field->isButton === true)
		{
			echo $field->controlHtml;
		}
	}


?>
	</div>
    </fieldset>
    <input type="hidden" value="<?php echo $this->visforms->id; ?>" name="postid" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>
