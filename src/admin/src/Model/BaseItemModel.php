<?php

namespace LBC\Component\BaseComponent\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;

class BaseItemModel extends AdminModel{


	protected $_context = 'com_basecomponent.baseitem';

    /**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $name     The table name. Optional.
	 * @param   string  $prefix   The class prefix. Optional.
	 * @param   array   $options  Configuration array for model. Optional.
	 *
	 * @return  Table  A Table object
	 *
	 * @since   3.0
	 * @throws  \Exception
	 */
	public function getTable($name = '', $prefix = '', $options = array())
	{
		$name = 'Baseitems';
		$prefix = 'Table';

		if ($table = $this->_createTable($name, $prefix, $options))
		{
			return $table;
		}

		throw new \Exception(Text::sprintf('JLIB_APPLICATION_ERROR_TABLE_NAME_NOT_SUPPORTED', $name), 0);
	}


    public function getForm($data = array(), $loadData = true){
		// Get the form.
		$form = $this->loadForm('com_basecomponent.baseitem', 'baseitem', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
    }
    

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app = Factory::getApplication();
		$data = $app->getUserState('com_basecomponent.edit.baseitem.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Article Manager: Articles
		}

		$this->preprocessData('com_basecomponent.baseitem', $data);

		return $data;
	}


	/**
	 * Method to change the published state of one or more records.
	 *
	 * @param   array    &$pks   A list of the primary keys to change.
	 * @param   integer  $value  The value of the published state.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   4.0.0
	 */
	public function publish(&$pks, $value = 1) {
		/* this is a very simple method to change the state of each item selected */
		$db = $this->getDbo();

		$query = $db->getQuery(true);

		$query->update('`#__base`');
		$query->set('state = ' . $value);
		$query->where('id IN (' . implode(',', $pks). ')');
		$db->setQuery($query);
		$db->execute();
	}
}