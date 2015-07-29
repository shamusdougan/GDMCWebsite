<?php
/**
 * visdatas controller for Visforms
 *
 * @author       Aicha Vack
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Visdata controller class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsControllerVisdatas extends JControllerAdmin
{

	/**
	 * Class constructor.
	 *
	 * @param   array  $config  A named array of configuration variables.
	 *
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
            parent::__construct($config);
            $fid = JFactory::getApplication()->input->getInt('fid', 0);
            $this->view_list = 'visdatas&fid=' . $fid;
            $this->text_prefix = 'COM_VISFORMS_DATA';
	}
        
        /**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	JModel
	 * @since	1.6
	 */
	public function getModel($name = 'Visdata', $prefix = 'VisformsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	/**
	 * Method to export data saved in database to csv
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	public function export() {
        //form id
		$fid = JFactory::getApplication()->input->getInt('fid', -1);
        
        //get the data model
        $model = $this->getModel('visdatas');
        //return if user has no export permission
        if(!$model->canExport($fid))
        {
            JFactory::getApplication()->redirect('index.php?option=com_visforms&view=visdatas&fid='.$fid , 'COM_VISFORMS_EXPORT_NOT_PERMITTED', 'warning');
        }
        
        //get id's of selected datasets (if user checked them in data view)
        $cids = JFactory::getApplication()->input->get('cid', array(), 'ARRAY');
        JArrayHelper::toInteger($cids);
        
		//get the Formmodel and form settings
        $formModel = $this->getModel('visform');
        $form = $formModel->getItem($fid);
        foreach ($form->exportsettings as $name => $value) 
        {
            //make names shorter and set all exportsettings as properties of form object               
            $form->$name = $value;   
        }

        //delete exportsettings array
        unset($form->exportsettings);
		
		//get submitted form dataset
		$items = $model->getItems();
        
		//get fields to export from database
        //according to export parameters of field and form
        $where = ' and c.includefieldonexport = 1';
        $where .= ($form->exppublishfieldsonly == 1) ? ' and c.published = 1' : '';
		$fields = $model->getDatafields($where);
			
		header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Content-type: application/vnd.ms-excel"); 
		header("Content-disposition: attachment; filename=visforms_" . date("Ymd").".csv");  

		$data = "";
		$nbItems=count( $items );
		$nbFields=count( $fields );
        $separator = (isset($form->expseparator)) ? $form->expseparator : ";";
		
		//create tableheaders from fieldnames
        if (isset($form->expfieldid) && $form->expfieldid == 1)
        {
            $data .= JText::_( 'COM_VISFORMS_ID' ) . $separator;
        }
        if (isset($form->expfieldpublished) && $form->expfieldpublished == 1)
        {
            $data .= JText::_( 'COM_VISFORMS_PUBLISHED' ) . $separator;
        }
        if (isset($form->expfieldcreated) && $form->expfieldcreated == 1)
        {
            $data .= JText::_( 'COM_VISFORMS_FIELD_CREATED_LABEL' ) . $separator;
        }
        
		for ($i=0; $i < $nbFields; $i++)
		{
			$rowField = $fields[$i];
			if ($rowField->typefield != 'submit' && $rowField->typefield != 'image' && $rowField->typefield != 'reset' && $rowField->typefield != 'fieldsep')
			{
                $data .= $this->createExportCell($rowField, 'label', $form);
                //Add Separator
                if($i < ($nbFields - 1))
                {
                    $data .= $separator; 
                }				
			}			
		}
        $data = rtrim ( $data , $separator );
        if (isset($form->expfieldip) && $form->expfieldip == 1)
        {
            $data .= $separator .JText::_( 'COM_VISFORMS_IP' );
        }
        if (isset($form->expfieldismfd) && $form->expfieldismfd == 1)
        {
            $data .= $separator .JText::_( 'COM_VISFORMS_MODIFIED' );
        }
        //Add linebreak
		echo $data." \n";
		
        //create datasets from rows
		for ($i=0; $i < $nbItems; $i++)
		{
			$data = '';
            $row = $items[$i];
            //exclude unpublished datasets according to form settings
            if($form->exppublisheddataonly == 1 && !$row->published)
            {
                continue;
            }
            //Some datasets are checked, we export only those
            if(count($cids) > 0)
            {
                foreach($cids as $value) 
                {
                    if($row->id == $value) 
                    {
                        $data .= $this->createPreFields ($form, $row);
                        for ($j=0; $j < $nbFields; $j++) 
                        {
                            $rowField = $fields[$j];
                            if ($rowField->typefield != 'submit' && $rowField->typefield != 'image' && $rowField->typefield != 'reset' && $rowField->typefield != 'fieldsep')
                            {
                                $prop="F".$rowField->id;
                            
                                if ($rowField->typefield == "file")
                                {
                                    //we must decode JSON Object, get the file name and set it as value
                                    $row->$prop = JHTML::_('visforms.getUploadFileName', $row->$prop);
                                }
                                $data .= $this-> createExportCell($row, 'field', $form, $prop);
                                //Add Separator
                                if($j < ($nbFields - 1))
                                {
                                    $data .= $separator;
                                }
                            }
                        }
                        $data = rtrim ( $data , $separator );
                        $data .= $this->createPostFields ($form, $row);
                        
                         //Add linebreak
                        echo $data." \n";
                    }
                }
            }
            //No datasets checked, we export all datasets
            else
            {
                $data .= $this->createPreFields ($form, $row, $separator);
                for ($j=0; $j < $nbFields; $j++)
                {
                    $rowField = $fields[$j];   
                    if ($rowField->typefield != 'submit' && $rowField->typefield != 'image' && $rowField->typefield != 'reset' && $rowField->typefield != 'fieldsep')
                    {
                        $prop="F".$rowField->id;
                        if ($rowField->typefield == "file")
                        {
                         //we must decode JSON Object, get the file name and set it as value
                            $row->$prop = JHTML::_('visforms.getUploadFileName', $row->$prop);
                         }
                    
                        $data .= $this-> createExportCell($row, 'field', $form, $prop);
                        //Add Separator
                        if($j < ($nbFields - 1))
                        {
                            $data .= $separator;
                        }	 		
                    }
                }
               $data = rtrim ( $data , $separator );
               $data .= $this->createPostFields ($form, $row, $separator);
                 //Add linebreak
                echo $data." \n";
            }
		}
                
               JFactory::getApplication()->close();
	}
    
    /**
	 * Method create content of one export cell
	 *
     * @param object $row visforms field object
     * @param string $type  Export cell type (field/label)
     * @param object $form  visforms form object
     * @param string $prop  field property to be exported
	 * @return string   export cell content
	 *
	 * @since Joomla 1.6 
	 */
    public function createExportCell($row, $type = Null, $form = Null, $prop = Null )
    {
         $data = "";
        if($type == 'field')
        {
            $prop = $prop;
        }
        else if ($type == 'label')
        {
            $prop = $type;
        }
        else
        {
            return $data;
        }
            if (isset($form->usewindowscharset) && $form->usewindowscharset == 0) {
                $unicode_str_for_Excel = $row->$prop;
            }
            else
            {
                //convert characters into window characterset for easier using with excel
                $unicode_str_for_Excel = iconv("UTF-8", "windows-1250//TRANSLIT", $row->$prop);
            }

            $unicode_str_for_Excel = str_replace("\"", "\"\"", $unicode_str_for_Excel);

            $pos = strpos($unicode_str_for_Excel, ';');
            if ($pos === false) 
            {
                $data .= $unicode_str_for_Excel;
            } else {
                $data .= "\"".$unicode_str_for_Excel."\"";
            }				

        return $data;
    }
    
    /**
	 * Method create content of export cells for invariant form fields (id, published) placed at the front of each export row
	 *
     * @param object $form  visforms form object
     * @param object $row visforms field object
     * 
	 * @return string   export cell content
	 *
	 * @since Joomla 1.6 
	 */
    public function createPreFields ($form, $row, $separator = ";")
    {
        $data = "";
        if (isset($form->expfieldid) && $form->expfieldid == 1)
        {
            $data .= $row->id . $separator;
        }
        if (isset($form->expfieldpublished) && $form->expfieldpublished == 1)
        {
            $data .= $row->published . $separator;
        }
        if (isset($form->expfieldcreated) && $form->expfieldcreated == 1)
        {
            $data .= $row->created . $separator;
        }
        return $data;
    }
    
    /**
	 * Method create content of export cells for invariant form fields (ipaddress) placed at the end of each export row
	 *
     * @param object $form  visforms form object
     * @param object $row visforms field object
     * 
	 * @return string   export cell content
	 *
	 * @since Joomla 1.6 
	 */
    public function createPostFields ($form, $row, $separator = ";")
    {
        $data = "";
        if (isset($form->expfieldip) && $form->expfieldip == 1)
        {
            $data .= $separator .$row->ipaddress;
        }
        if (isset($form->expfieldismfd) && $form->expfieldismfd == 1)
        {
            $data .= $separator .$row->ismfd;
        }
        return $data;
    }
    
    /**
	 * Method to redirect to forms view
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
    public function forms()
    {
        $this->setRedirect('index.php?option=com_visforms');
    }
    
    protected function postDeleteHook(JModelLegacy $model, $cid = NULL)
    {
        foreach ($cid as $id)
        {
            $model->deleteOrgData($id);
        }
    }
    
    public function reset()
    {
        $model = $this->getModel('visdata');
        $cid = $this->input->get('cid', array(), 'array');
        foreach ($cid as $id)
        {
            $model->restoreToUserInputs($id);
            $model->deleteOrgData($id);
        }
        $ntext = $this->text_prefix . '_N_ITEMS_RESET';
        $this->setMessage(JText::plural($ntext, count($cid)));
        $this->setRedirect('index.php?option=com_visforms&view='. $this->view_list);
    }
}
?>