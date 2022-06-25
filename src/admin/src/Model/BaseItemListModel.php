<?php
/**
 * @package     Mywalks.Administrator
 * @subpackage  com_mywalks
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace LBC\Component\BaseComponent\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Workflow\Workflow;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Utilities\ArrayHelper;
use Joomla\Database\ParameterType;

/**
 * Methods supporting a list of mywalks records.
 *
 * @since  1.6
 */
class BaseItemListModel extends ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @since   1.6
	 * @see     \Joomla\CMS\MVC\Controller\BaseController
	 */
	public function __construct($config = array())
	{
        // This is where the filter fields added to the mywalks_filter.xml must be declared to make them appear in the output. The parent ListModel has a lot of code not mentioned here. See the API documentation when it appears. Or just look for the file containing the ListModel class and its parent too.
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'description', 'a.description',
				'field_1', 'a.field_1',
				'field_2', 'a.field_2',
				'field_3', 'a.field_3',
				'state', 'a.state',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = 'a.id', $direction = 'asc')
	{
        // When a page is first loaded no filters are set. When a filter is set the next page load has the new filter setting in the form submission. We need to save that setting as state variable for use when filtering is actually used in the getQuery function. Notice the default values for ordering and direction if none are passed to this function.

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
        // Tricky to explain! This function puts together a string from which a hash is calculated that is used to cache part of an SQL query to avoid clashes with another extension, such as a module, that may be executed in the same page load.
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  \Joomla\Database\DatabaseQuery
	 *
	 * @since   1.6
	 */
/*
    This where you need to know about sql! You need to be able to write queries and debug them. To start we need a database object in the $db variable and a database query object in $query. Passing true to $db->getQuery(true) returns a new object. If true is omitted an existing query is returned that is already populated, usually resulting in disaster. In Joomla, parts of a query can be chained together, which tends to make for tricky understanding. So here the parts are assembled separately.

	The 'select' statement: the part that says $this->getState will either get the query using the storeId hash or create a new query and store it in the hash for later in this page load. The query itself selects all fields from table 'a' and a count of the number of walk visits for each walk returned. ToDo: add a where clause to count only published walk visits.

	The 'from' statement: this simply says which table to use. The #__ part gets replaced by the table prefix, which varies from site to site.

	The 'where' clauses use any filters set. They are complicated because they may be integers or strings or null.

	The 'order' clause adds the ordering statements.

	The query is then returned to the caller where page limit statements are added.

	If there is an error in your sql syntax you may just see a 500 Internal Error message. If so, before the return statement you can insert echo $query->__tostring();die(); to see what your query contains at that stage.
*/

	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			// $this->getState(
			// 	'list.select',
			// 	'a.*, (SELECT count(`date`) from #__mywalk_dates WHERE walk_id = a.id) AS nvisits'
			// )
            $this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('#__base AS a');

		// Filter by published state
		$published = (string) $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where($db->quoteName('a.state') . ' = :published');
			$query->bind(':published', $published, ParameterType::INTEGER);
		}
		elseif ($published === '')
		{
			$query->where('(' . $db->quoteName('a.state') . ' = 0 OR ' . $db->quoteName('a.state') . ' = 1)');
		}

		// Filter by search in title.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
			$query->where('(a.title LIKE ' . $search . ')');
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}

	/**
	 * Method to get a list of walks.
	 * Overridden to add a check for access levels.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   4.0.0
     * 
     * You only need this if you want to add access code or as a step in debugging. If the function is left out the parent getIems function will be callsed.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		return $items;
	}

}