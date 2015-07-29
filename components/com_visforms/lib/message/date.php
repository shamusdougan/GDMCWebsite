<?php
/**
 * Visforms message date class
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
 * Visforms message date
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsMessageDate extends VisformsMessage
{
    /**
     * 
     * Constructor
     * 
     * @param string $name field name
     * @param array $args additional arguments
     */
    
       public function __construct($name, $args)
       {
           parent::__construct($name, $args);
           $this->text = 'COM_VISFORMS_FIELD_DATE_FORMAT';
           $this->args = $args;
       }
       
       /**
        * Method to set an error Message
        */
       protected function setMessage()
       {
           $format = (isset($this->args['format'])) ? $this->args['format'] : '';
           JFactory::getApplication()->enqueueMessage(JText::sprintf($this->text, $this->name, $format), $this->messageType);
       }
}