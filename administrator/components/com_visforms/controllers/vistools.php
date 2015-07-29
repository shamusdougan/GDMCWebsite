<?php
/**
 * vistools controller for Visforms
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
 * vistools Controller
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsControllerVistools extends JControllerLegacy
{
	/**
	 * constructor (Register some extra tasks)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	public function __construct($config = array())
	{	
		parent::__construct($config = array());
		
		$this->registerTask('apply', 'save');
				
	}
    
    /**
	 * Method for closing the CSS file list view.
	 *
	 * @return  void.
	 *
	 * @since   3.2
	 */
    public function cancel()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_visforms', false));
	}
    
    /**
	 * Method for closing a file.
	 *
	 * @return  void.
	 *
	 * @since   3.2
	 */
	public function close()
	{
        $this->setRedirect(JRoute::_('index.php?option=com_visforms&view=vistools', false));
	}
    
    /**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional (note, the empty array is atypical compared to other models).
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   3.2
	 */
	public function getModel($name = 'Vistools', $prefix = 'VisformsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
    
    /**
	 * Method to check if you can add a new record.
	 *
	 * @return  boolean
	 *
	 * @since   3.2
	 */
	protected function allowEdit()
	{
		return JFactory::getUser()->authorise('core.edit.css', 'com_visforms');
	}

	/**
	 * Method to check if you can save a new or existing record.
	 *
	 * @return  boolean
	 *
	 * @since   3.2
	 */
	protected function allowSave()
	{
		return $this->allowEdit();
	}

	/**
	 * display the visforms CSS
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function editCSS()
	{	
		// Initialise variables.
		$app = JFactory::getApplication();
		$context = 'com_visforms.edit.css';		
		$model = $this->getModel();
		$id = $model->getExtension()->extension_id;
        $this->setRedirect("index.php?option=com_visforms&view=vistools&layout=default&id=" . $id);
        
	}

	/**
	 * Save visforms CSS
	 *
	 * @return void
	  * @since Joomla 1.6
	 **/
	function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialise variables.
		$app		= JFactory::getApplication();
        $data         = $this->input->post->get('jform', array(), 'array');
		$task		= $this->getTask();
		$model		= $this->getModel();
        $fileName     = $app->input->get('file');
		$explodeArray = explode(':', base64_decode($fileName));

		// Access check.
		if (!$this->allowSave())
		{
			$app->enqueueMessage(JText::_('JERROR_SAVE_NOT_PERMITTED'), 'error');

			return false;
		}

		// Match the stored id's with the submitted.
		if (empty($data['extension_id']) || empty($data['filename'])) {
			$app->enqueueMessage(JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'), 'error');
            return false;
		}
		elseif ($data['extension_id'] != $model->getState('extension.id')) {
			$app->enqueueMessage(JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'), 'error');
            return false;
		}
		elseif ($data['filename'] != end($explodeArray)) {
			$app->enqueueMessage(JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'), 'error');
            return false;
		}
        
        // Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');

			return false;
		}

		$data = $model->validate($form, $data);
        
        // Check for validation errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Redirect back to the edit screen.
			$url = 'index.php?option=com_visforms&view=vistools&layout=default&id=' . $model->getState('extension.id') . '&file=' . $fileName;
			$this->setRedirect(JRoute::_($url, false));

			return false;
		}
		
		// Attempt to save the data.
		if (!$model->save($data))
		{
			// Save the data in the session.
			$app->setUserState($context.'.data', $data);

			// Redirect back to the edit screen.
			$app->enqueueMessage(JText::sprintf('JERROR_SAVE_FAILED', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=vistools&layout=default&id='. $model->getState('extension.id') . '&file=' . $fileName, false));
			return false;
		}
		$app->enqueueMessage(JText::_('COM_VISFORMS_FILE_SAVED'));
		
		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=vistools&layout=default&id='. $model->getState('extension.id') . '&file=' . $fileName, false));
				break;

			default:

				// Redirect to the list screen.
				$this->setRedirect(JRoute::_('index.php?option=com_visforms', false));
				break;
		}
	}
}
?>
