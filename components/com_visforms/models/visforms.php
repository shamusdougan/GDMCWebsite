<?php
/**
 * Visforms model for Visforms
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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.utilities.arrayhelper');


/**
 * Visforms modell
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsModelVisforms extends JModelLegacy
{

	 /**
	 * The form id.
	 *
	 * @var    int
	 * @since  11.1
	 */
       private $_id;
         
    /**
      
     /**
	 * Input from request.
	 *
	 * @var    int
	 * @since  11.1
	 */
         private $input;
         
    /**
	 * The fields object or null.
	 *
	 * @var    mixed
	 * @since  11.1
	 */
         private $fields;
         
     /**
	 * The form object or null.
	 *
	 * @var    mixed
	 * @since  11.1
	 */
         private $form;
         
    /**
     
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JModel
	 * @since   11.1
	 */
    public function __construct($config = array()) 
    {
        $this->input = JFactory::getApplication()->input;
        if (isset($config['id']))
        {
            $this->setId($config['id']);
        }
        else
        {
           $this->setId();
        }
        parent::__construct($config);

    }
         
     /**
	 * Method store the form id in _id.
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
    public function setId($id = null) 
    {
         if (is_null($id))
         {
            $id = $this->input->getInt('id',  0);
         }
         $this->_id = $id;
     }
         
     /**
	 * Method to get the form dataset
	 *
	 * @return  object with form data
	 *
	 * @since   11.1
	 */
         public function getForm()
         {
             $app = JFactory::getApplication();
             $form = $app->getUserState('com_visforms.form' . $this->_id);
             if (!isset($form) || is_null($form))
             {
                $query = ' SELECT * FROM #__visforms where id='.$this->_id ;				
                $this->_db->setQuery( $query );
                $form = $this->_db->loadObject();
                $registry = new JRegistry;
                //Convert receiptmailsettings field to an array
                $registry->loadString($form->emailreceiptsettings);
                $form->emailreceiptsettings = $registry->toArray();
                foreach ($form->emailreceiptsettings as $name => $value) 
                {
                   //make names shorter and set all emailreceiptsettings as properties of form object               
                   $form->$name = $value;   
                }
                $registry = new JRegistry;
                //Convert frontendsettings field to an array
                $registry->loadString($form->frontendsettings);
                $form->frontendsettings = $registry->toArray();
                foreach ($form->frontendsettings as $name => $value) 
                {
                   //make names shorter and set all frontendsettings as properties of form object               
                   $form->$name = $value;   
                }
                $registry = new JRegistry;
                //Convert layoutsettings field to an array
                $registry->loadString($form->layoutsettings);
                $form->layoutsettings = $registry->toArray();
                foreach ($form->layoutsettings as $name => $value) 
                {
                   //make names shorter and set all layoutsettings as properties of form object               
                   $form->$name = $value;   
                }
                $registry = new JRegistry;
                //Convert layoutsettings field to an array
                $registry->loadString($form->captchaoptions);
                $form->captchaoptions = $registry->toArray();
                foreach ($form->captchaoptions as $name => $value) 
                {
                   //make names shorter and set all captchaoptions as properties of form object               
                   $form->$name = $value;   
                }
                //create property for information about validity of user inputs
                $form->isValid = true;
                $app->setUserState('com_visforms.form' . $this->_id, $form);
             }
             $this->form = $form;
             return $this->form;
         }
         
    /**
    * Method to get the form fields definition from database
    *
    * @return  array of form fields
    *
    * @since   11.1
    */

     public function getItems()
     {
        $visform = $this->getForm();
        $query = ' SELECT * FROM #__visfields where fid='.$this->_id." and published=1 order by ordering asc" ;
        $items = $this->_getList( $query );
        return $items;
     }
         
    /**
    * Method to build the field item list
    *
    * @return  array of form fields
    *
    * @since   11.1
    */
     public function getFields() 
     {  
        $app = JFactory::getApplication();
        $this->fields = $app->getUserState('com_visforms.form' . $this->_id . '.fields');
         if (!is_array($this->fields))
         {
            $fields = $this->getItems();
            $visform = $this->getForm();
            $n=count($fields );
            //get basic field definition
            for ($i=0; $i < $n; $i++)
            { 
                $ofield = VisformsField::getInstance($fields[$i], $visform);
                if(is_object($ofield))
                {
                    $fields[$i] = $ofield->getField();
                }
            }
            // perform business logic
            for ($i=0; $i < $n; $i++)
            {
                $ofield = VisformsBusiness::getInstance($fields[$i], $visform, $fields);
                if(is_object($ofield))
                {
                    //as there may be interactions between the field processed and the rest of the form fields we always return the fields array
                    $fields = $ofield->getFields();
                }
            }

            //only after we have performed the business logic on all fields we know which fields are disabled
            //we can validate the "required" only then, because we have to omit the required validation for disabled fields!
            //we use the business class for this as well
             for ($i=0; $i < $n; $i++)
            {
                $ofield = VisformsBusiness::getInstance($fields[$i], $visform, $fields);
                if(is_object($ofield))
                {
                    $fields[$i] = $ofield->validateRequired();
                }
            }

            //prepare HTML
            for ($i=0; $i < $n; $i++)
            {
                $html = VisformsHtml::getInstance($fields[$i]);
                if (is_object($html))
                {
                    $ofield = VisformsHtmllayout::getInstance($visform->formlayout, $html);
                    if (is_object($ofield))
                    {
                        $fields[$i] = $ofield->prepareHtml();
                    }
                }
            }

            $this->fields = $fields;
        }
        $app->setUserState('com_visforms.form' . $this->_id . '.fields', $this->fields);
        return $this->fields;
     }  
	
    public function clearPostValue ($field)
    {
        //Form was send, but php validation failed. We use submitted values from post and show them as field values
        //In truth this will not work for selects but they are handle seperatly anyway
       if (isset($_POST[$field->name]))
       {
           if ($field->typefield == "select" || $field->typefield == "multicheckbox")
           {
               $this->input->post->set($field->name, array());
           }
           else
           {
               $this->input->post->set($field->name, '');                      
           }
       } 
     }
	
	/**
	 * Method to add 1 to hits
	 * @return void
	 */
	function addHits()
	{
		$dba	= JFactory::getDbo();
		$visform = $this->getForm();
		
		if (isset($visform->id))
		{
			$query = " update #__visforms set hits = ".($visform->hits + 1). " where id = ".$visform->id;

			$dba->SetQuery($query);		
			$dba->execute();
		}
	}
	
	/**
	 * Method to save data user input
	 *
	 * @paran array $post user input from $_POST
	 * @return void
	 * @since Joomla 1.6
	 */
	function saveData()
	{		
		//Form and Field structure and info from db
		$visform = $this->getForm();
        $fields = $this->getFields();
        $visform->fields = $fields;
        $folder	= $visform->uploadpath;
        
        //time zone
        $config = JFactory::getConfig();
        $offset = $config->get('offset', 'UTC');
        if ($offset)
        {
            date_default_timezone_set($offset);
        }
                
		if ($this->uploadFiles($visform) === false)
        {
            return false;
        }
		
		if ($visform->saveresult == 1) 
		{	
            if ($this->storeData($visform) === false)
            {
                return false;
            }						
		}		
		
		/* ************************* */
		/*     Send Email Result     */
		/* ************************* */
		if ($visform->emailresult == 1) 
		{
			$this->sendResultMail($visform);			
		}		
		
		/* ************************** */
		/*     Send Email Receipt     */
		/* ************************** */
		if ($visform->emailreceipt == 1) 
		{	
            $this->sendReceiptMail($visform);
		}		
		return true;
	}
	
	
	/**
	  * Method to retrieve menu params
	  *
	  * @return array Array of objects containing the params from active menu
	  * @since Joomla 1.6
	  */
	
	function getMenuparams () 
	{
		$app = JFactory::getApplication();
		$menu_params = $app->getParams();
		$this->setState('menu_params', $menu_params);		
		return $menu_params;
	}
	
	/**
	 * Checks if the file can be uploaded
	 *
	 * @param array File information
	 * @param string An error message to be returned
	 *
	 * @return boolean
	 * @since Joomla 1.6
	 */
	public function canUpload($file, &$err, $maxfilesize, $allowedextensions)
	{

		if (empty($file['name'])) {
			$err = 'COM_VISFORMS_ERROR_UPLOAD_INPUT';
			return false;
		}

		jimport('joomla.filesystem.file');
		if ($file['name'] !== JFile::makesafe($file['name'])) {
			$err = 'COM_VISFORMS_ERROR_WARNFILENAME';
			return false;
		}

		$format = strtolower(JFile::getExt($file['name']));
		$allowable = explode(',', $allowedextensions);		
		if ($format == '' || $format == false || (!in_array($format, $allowable)))
		{
			$err = 'COM_VISFORMS_ERROR_WARNFILETYPE';
			return false;
		}

		$maxSize = (int) ($maxfilesize  * 1024);
		if ($maxSize > 0 && (int) $file['size'] > $maxSize)
		{
			$err = 'COM_VISFORMS_ERROR_WARNFILETOOLARGE';
			return false;
		}

		$imginfo = null;

		$images = explode(',', "bmp,gif,jpg,jpeg,png");
		if (in_array($format, $images)) { // if its an image run it through getimagesize
			// if tmp_name is empty, then the file was bigger than the PHP limit
			if (!empty($file['tmp_name'])) {
				if (($imginfo = getimagesize($file['tmp_name'])) === FALSE) {
					$err = 'COM_VISFORMS_ERROR_WARNINVALID_IMG';
					return false;
				}
			} else {
				$err = 'COM_VISFORMS_ERROR_WARNFILETOOLARGE';
				return false;
			}
		}

		$xss_check =  JFile::read($file['tmp_name'], false, 256);
		$html_tags = array('abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink', 'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext', 'link', 'listing', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object', 'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar', 'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title', 'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--');
		foreach($html_tags as $tag) {
			// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
			if (stristr($xss_check, '<'.$tag.' ') || stristr($xss_check, '<'.$tag.'>')) {
				$err = 'COM_VISFORMS_ERROR_WARNIEXSS';
				return false;
			}
		}
		return true;
	}
        
        /**
	 * Deletes linebreaks in MySQL Database
	 *
	 * @param id formId Id if submitted form
	 * @param array fields Formfields
	 *
	 * @return boolean
	 * @since Joomla 1.6
	 */
        public function cleanLineBreak ($formId, $fields)
        {
            $db = JFactory::getDbo();
            $id = $db->insertid();
            $query = $db->getQuery(true);
            $updatefields = array();
            for ($i = 0; $i<count($fields); $i++)
            {
                $updatefields[] = $db->quoteName('F' . $fields[$i]->id) . ' = replace (F' . $fields[$i]->id . ', CHAR(13,10), \' \')';
            }
            $conditions = array( $db->quoteName('id') . ' = ' .$id);
            $query->update($db->quoteName('#__visforms_' . $formId))->set($updatefields)->where($conditions);
            $db->setQuery($query);
            $result = $db->execute();
        }
        
        /**
         * Upload files
         * 
         * @param object $visform Form Object with attached field information
         */
        
        private function uploadFiles(&$visform)
        {
            // set some parameters
            $maxfilesize = $visform->maxfilesize;
            $allowedextensions = $visform->allowedextensions;
            //upload files
            $n=count($visform->fields );
            for ($i=0; $i < $n; $i++)
            {
                $field = $visform->fields[$i];
                
                //Request has an fileupload with values
                if ($field->typefield == 'file' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='')
                {
                    //only upload if field is not disabled
                    if (!isset($field->isDisabled) || ($field->isDisabled == false))
                    {
                        $file = $this->input->files->get($field->name);
                        $folder		= $visform->uploadpath;	
                        if (!file_exists ($folder))
                        {
                            JError::raiseWarning(100, JText::_('COM_VISFORMS_UPLOAD_DIRECTORY_DOES_NOT_EXIST'));
                            return false;
                        }
                        else
                        {                     

                            // Set FTP credentials, if given
                            JClientHelper::setCredentialsFromRequest('ftp');

                            // Make the filename safe
                            $file['name_org'] = $file['name'];
                            $file['name']	= JFile::makeSafe($file['name']);

                            // Check upload conditions
                            $err = null;
                            if (!$this->canUpload($file, $err, $maxfilesize, $allowedextensions))
                            {
                                    // The file can't be upload
                                    JError::raiseNotice(100, JText::sprintf($err, $file['name_org'], $maxfilesize));
                                    return false;
                            }
                            else
                            {
                                //get a unique id to rename uploadfiles
                                $fileuid = uniqid('');

                                //rename file
                                $pathInf = pathinfo($file['name']);
                                $ext = $pathInf['extension'];
                                $file['new_name'] = basename($file['name'],".".$ext) . "_" . $fileuid . "." . $ext;
                                $file['new_name'] = strtolower($file['new_name']);

                                //get complete upload path with filename of renamed file
                                $filepath = JPath::clean(JPATH_SITE . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file['new_name']);
                                $file['filepath'] = $filepath;
                                $file['filelink'] = JUri::base() . $folder . '/' . $file['new_name'];


                                //try to upload file
                                if (JFile::exists($file['filepath']))
                                {
                                    // File exists
                                    JError::raiseWarning(100, JText::sprintf('COM_VISFORMS_ERROR_FILE_EXISTS', $file['name_org']));
                                    return false;
                                }
                                else
                                {
                                    if (!JFile::upload($file['tmp_name'], $file['filepath']))
                                    {
                                            // Error in upload
                                            JError::raiseWarning(100, JText::sprintf('COM_VISFORMS_ERROR_UNABLE_TO_UPLOAD_FILE', $file['name_org']));
                                            return false;
                                    }
                                }
                            }
                        }
                        foreach ($file as $name => $value)
                        {
                            $visform->fields[$i]->file[$name] = $value;
                        }
                    }
                }
            }
            return true;
        }
        
         /**
         * store data in db
         * 
         * @param object $visform Form Object with attached field information
         */
        private function storeData($visform)
        {
            $folder	= $visform->uploadpath;	
            $dba	= JFactory::getDbo();
			$query = ' insert into #__visforms_'.$visform->id."(" ;
			
			$n=count($visform->fields );
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				if (!(isset($field->isButton) && $field->isButton === true) && ($field->typefield != 'fieldsep') && (!isset($field->isDisabled) || ($field->isDisabled == false)))
				{
					$query = $query."F".$field->id.",";
				}
			}

			$query = $query."created,ipaddress,published,articleid) values(";
     
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				if (!(isset($field->isButton) && $field->isButton === true) && ($field->typefield != 'fieldsep') && (!isset($field->isDisabled) || ($field->isDisabled == false)))
				{				
					if ($field->typefield == 'file' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{ 
                        //save folder and filename
                        $data = new stdClass();
                        $data->folder = $folder;
                        $data->file = $field->file['new_name'];
                        $registry = new JRegistry($data);
                        $fieldValue = $registry->toString();

					} 
                    else if (isset($field->dbValue))
					{
						$fieldValue = $field->dbValue;
					} 
					else 
					{
						$fieldValue = '';
					}
					
					
					$query = $query."'".addslashes($fieldValue)."',";
				}
			}
			
			$autopublish = "0";
			if($visform->autopublish == 1) 
			{
				$autopublish = "1";
			}
			
			$query = $query."'".date("Y-m-d H:i:s")."','".$_SERVER['REMOTE_ADDR']."',".$autopublish.",";

			$articleid = $this->input->get('articleid');
			if (isset($articleid) && ($articleid != ''))
			{
				$query = $query."'".$articleid."'";
			} else {
				$query = $query."null";
			}
			
			$query = $query.")";
			$dba->setQuery($query);
			
			if (!$dba->execute()) 
			{
				$errMsg = JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")"."<br />". $dba->getErrorMsg();
                JError::raiseWarning($errMsg);

					return false;
				
			}
                        
            //Linebreaks confound data structure on export to excels. So we delete them in Database 
            $this->cleanLineBreak ($visform->id, $visform->fields);
            return true;
        }
        
        /**
         * Send Receipt Mail
         * @param object $visform Form Object with attached field information
         */
        private function sendReceiptMail($visform)
        {
            //we can only send a mail, if the form has a field of type email, that contains an email
            $isSendMail = false;
			$emailReceiptTo = '';
			
			$mail = JFactory::getMailer();
			$mail->CharSet = "utf-8";
            
            //Do some replacements in email text
            $fixedLinks = JHTMLVisforms::fixLinksInMail($visform->emailreceipttext);
			$mailBody = JHTMLVisforms::replacePlaceholder($visform, $fixedLinks);
			if ($visform->emailreceiptincformtitle == 1)
            {
                $mailBody .= "<br/>" .JText::_('COM_VISFORMS_FORM') . " : ".$visform->title."<br />";
            }
            if ($visform->emailreceiptinccreated == 1)
            {
                $mailBody .= JText::_( 'COM_VISFORMS_REGISTERED_AT' )." ".date("Y-m-d H:i:s")."<br />";
            }

			$n=count($visform->fields );
            //Do we have an e-mail field with value? Then get to mail address to which to send the mail to
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				
				if ($field->typefield == 'email')
				{					
                    if (isset($field->dbValue))
                    {
                        $isSendMail = true;
                        $emailReceiptTo = $field->dbValue;
                        break;
                    }
				}
			}
			
            //Include user inputs if parameter is set to true
			if ($visform->emailreceiptincfield == 1) {				
				for ($i=0; $i < $n; $i++)
				{	
					$field = $visform->fields[$i];
					if (!(isset($field->isButton) && $field->isButton === true) && $field->typefield != 'fieldsep' && (!isset($field->isDisabled) || ($field->isDisabled == false)))
					{
							
						if ($field->typefield == 'file' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
						{
                            if (isset($visform->emailrecipientincfilepath) && ($visform->emailrecipientincfilepath == true) && isset($field->file['filelink']))
                            {
                                $fieldValue = $field->file['filelink'];
                            }
                            else
                            {
                                $fieldValue = $field->file['name_org'];
                            }
						} 
						else if (isset($field->dbValue))
						{
							$fieldValue = $field->dbValue;
						}
						else 
						{
							$fieldValue = '';
						}

						
						$mailBody .= $field->label . " : " . $fieldValue . "<br />";
					}
					
				}	
				if (!isset($visform->emailreceiptincip) || (isset($visform->emailreceiptincip) && ($visform->emailreceiptincip == 1)))
                {
                    $mailBody .= JText::_( 'COM_VISFORMS_IP_ADDRESS' ) . " : " . $_SERVER['REMOTE_ADDR'] . "<br />";
                }
				
			}
			
			//Attach filed to email
			if ($visform->emailreceiptincfile == 1)
			{
				for ($i=0; $i < $n; $i++) {
					$field = $visform->fields[$i];
					if ($field->typefield == 'file' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{
						if ($field->file['filepath'] != '') 
						{
							$mail->addAttachment($field->file['filepath']);
						}
					} 
				}
			}
			
			//send the mail
			if (strcmp($emailReceiptTo,"") != 0 && $isSendMail == true)
			{
				$emailreceiptsubject = JHTMLVisforms::replacePlaceholder($visform, $visform->emailreceiptsubject);
				$mail->addRecipient($emailReceiptTo);
						
				$mail->setSender( array( $visform->emailreceiptfrom, $visform->emailreceiptfromname ) );
				$mail->setSubject( $emailreceiptsubject );
				$mail->IsHTML (true);
				$mail->Encoding = 'base64';
				$mail->setBody( $mailBody );
		
				JPluginHelper::importPlugin( 'visforms' ); 
				$dispatcher = JDispatcher::getInstance();
				$dispatcher->trigger('onVisformsEmailPrepare', array('com_visforms.form.receiptmail', &$mail, $visform));
                $sent = $mail->Send();
			}
        }
        
		/**
         * Send Result Mail
         */
        private function sendResultMail($visform)
        {
            $mail = JFactory::getMailer();
			$mail->CharSet = "utf-8";
		
			$mailBody = JText::_('COM_VISFORMS_FORM') . " : ".$visform->title." [".$visform->name."]<br />";
			$mailBody .= JText::_('COM_VISFORMS_REGISTERED_AT'). " ".date("Y-m-d H:i:s")."<br /><br />";
			$emailSender = "";

			$n=count($visform->fields );
            //Add user inputs to mail
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				
				if ($field->typefield == 'email')
				{					
					if (isset($field->dbValue))
					{
						$emailSender = $field->dbValue;
					}
				}
			
				if (!(isset($field->isButton) && $field->isButton === true) && ($field->typefield != 'fieldsep') &&(!isset($field->isDisabled) || ($field->isDisabled == false)))
				{
					if ($field->typefield == 'file' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{
                        if (isset($field->file['filelink']))
                        {
                            $fieldValue = $field->file['filelink'];
                        }
                        else
                        {
                            $fieldValue = $field->file['filepath'];
                        }
						//Attach file to email
						if ($field->file['filepath'] != "" && $visform->emailresultincfile == "1") 
						{
							$mail->addAttachment($field->file['filepath']);
						}

					}
					else if (isset($field->dbValue))
					{
						$fieldValue = $field->dbValue;
					} 
					else 
					{
						$fieldValue = '';
					}
					
					if ($field->typefield == 'email') 
					{
						$fieldValue = '<a href="mailto:'.$fieldValue.'">'.$fieldValue.'</a>';
					} 
				
					$mailBody .= $field->label . " : " . $fieldValue . "<br />";
				}
			}
			
			$mailBody .= JText::_( 'COM_VISFORMS_IP_ADDRESS' ) . " : " . $_SERVER['REMOTE_ADDR'] . "<br />";
			
			$articleid = $this->input->get('articleid');
			if (isset($articleid) && ($articleid != ''))
			{
				$mailBody .= JText::_( 'COM_VISFORMS_ARTICLE_ID' ) . " : " . $articleid . "<br />";
			}
			
			if (strcmp($visform->emailto,"") != 0)
			{
				$mail->addRecipient( explode(",", $visform->emailto) );
			}
			if (strcmp($visform->emailcc,"") != 0)
			{
				$mail->addCC( explode(",", $visform->emailcc) );
			}
			if (strcmp($visform->emailbcc,"") != 0)
			{
				$mail->addBCC( explode(",", $visform->emailbcc) );
			}
			
			$mail->setSender( array( $visform->emailfrom, $visform->emailfromname ) );
			$subject = JHTMLVisforms::replacePlaceholder($visform, $visform->subject);
			$mail->setSubject( $subject );
            if ($emailSender != "")
			{
				$mail->addReplyTo($emailSender);
			}
			$mail->IsHTML (true);
			$mail->Encoding = 'base64';
			$mail->setBody( $mailBody );

			JPluginHelper::importPlugin( 'visforms' ); 
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger('onVisformsEmailPrepare', array('com_visforms.form.resultmail', &$mail, $visform));			
			$sent = $mail->Send();
        }
}
