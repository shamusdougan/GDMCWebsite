<?php
/**
 * Mod Visforms Form
 *
 * @author       Aicha Vack
 * @package      Joomla.Site
 * @subpackage   mod_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

JHTMLVisforms::includeScriptsOnlyOnce();
	
if ($visforms->published != '1') 
{
    return;
}

//retrieve helper variables from params
$nbFields=$params->get('nbFields');
$required = $params->get('required');
$upload = $params->get('upload');
$textareaRequired = $params->get('textareaRequired');
$hasHTMLEditor = $params->get('hasHTMLEditor');
//helper, used to set focus on first visible field
$firstControl = true;

?>

<form action="<?php echo JRoute::_($formLink); ?>" method="post" name="visform" id="mod-visform<?php echo $visforms->id; ?>" class="visform <?php echo $visforms->formCSSclass; ?>"<?php if($upload == true) { ?> enctype="multipart/form-data"<?php } ?>>
<fieldset>
		
<?php 
	//Explantion for * if at least one field is requiered at the top of the form
	if ($required == true && $visforms->required == 'top')
	{
    ?>
        <div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php          
    }
 
	//first hidden fields at the top of the form
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $visforms->fields[$i];
		if ($field->typefield == "hidden")
		{
            echo $field->controlHtml;
		}
	}

	//then inputs, textareas, selects and fieldseparators
	for ($i=0;$i < $nbFields; $i++)
	{ 
        $field = $visforms->fields[$i];
        if ($field->typefield != "hidden" && !isset($field->isButton))
        {
            //display the control
            echo $field->controlHtml;
        }   	
    }

	//Explantion for * if at least one field is requiered above captcha
	if ($required == true && $visforms->required == 'captcha')
	{
    ?>
        <div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php  
    }
    
    //show the captcha if it is set in form settings
    if (isset($visforms->captcha) && ($visforms->captcha == 1 || $visforms->captcha == 2))
	{
             echo JHTML::_('visforms.getCaptchaHtml', $visforms);
	} 

	//Explantion for * if at least one field is requiered above submit
	if ($required == true && $visforms->required == 'bottom')
	{
    ?>
	<div class="vis_mandatory visCSSbot10 visCSStop10"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</div>
    <?php   
    } 
    ?>
    
    <div class="visBtnCon">
	<?php 
	//all button on the bottom of the form
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $visforms->fields[$i];
		if (isset($field->isButton) && $field->isButton === true)
		{
			echo $field->controlHtml;
		}
	}


?>
	</div>
    </fieldset>
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
	<input type="hidden" value="<?php echo $visforms->id; ?>" name="postid" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>
