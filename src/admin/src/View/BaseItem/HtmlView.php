<?php
/**
 * @package     BaseComponent.Administrator
 * @subpackage  com_basecomponent
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace LBC\Component\BaseComponent\Administrator\View\BaseItem;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View to edit an article.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The \JForm object
	 *
	 * @var  \JForm
	 */
	protected $form;

	/**
	 * The active item
	 *
	 * @var  object
	 */
	protected $item;

	/**
	 * The model state
	 *
	 * @var  object
	 */
	protected $state;

	/**
	 * The actions the user is authorised to perform
	 *
	 * @var  \JObject
	 */
	protected $canDo;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @throws \Exception
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');

		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @throws \Exception
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);
		$isNew      = ($this->item->id == 0);

		$canDo = ContentHelper::getActions('com_basecomponent');

		$toolbar = Toolbar::getInstance();

		ToolbarHelper::title(
			Text::_('COM_BASECOMPONENT_BASEITEM_PAGE_TITLE_' . ($isNew ? 'ADD_ITEM' : 'EDIT_ITEM'))
		);

		if ($canDo->get('core.create'))
		{
			if ($isNew)
			{
				$toolbar->apply('baseitem.save');
			}
			else
			{
				$toolbar->apply('baseitem.apply');
			}

			$saveGroup = $toolbar->dropdownButton('save-group');

			$saveGroup->configure(
				function (Toolbar $childBar) /*use ($user)*/
				{
					$childBar->save('baseitem.save');

					// if ($user->authorise('core.create', 'com_menus.menu'))
					// {
					// 	$childBar->save('baseitem.save2menu', 'JTOOLBAR_SAVE_TO_MENU');
					// }

					$childBar->save2new('baseitem.save2new');
					$childBar->save2copy('baseitem.save2copy');
				}
			);

		}
		
		$toolbar->cancel('baseitem.cancel', 'JTOOLBAR_CLOSE');		
	}
}