<?php
/**
 * @package     Mywalks.Site
 * @subpackage  com_mywalks
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use LBC\Component\BaseComponent\Site\Helper\RouteHelper as BaseItemListHelperRoute;

?>
<div class="table-responsive">
  <table class="table table-striped">
  <caption><?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_TABLE_CAPTION'); ?></caption>
  <thead>
    <tr>
      <th scope="col" style="min-width:6rem;">
        <?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_LABEL_TITLE'); ?>
      </th>
      <th scope="col" style="min-width:10rem;">
        <?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_LABEL_DESCRIPTION'); ?>
      </th>
      <th scope="col" style="min-width:6rem;">
        <?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_LABEL_FIELD1'); ?>
      </th>
      <th scope="col" style="min-width:6rem;">
        <?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_LABEL_FIELD2'); ?>
      </th>
      <th scope="col" style="min-width:6rem;">
        <?php echo Text::_('COM_BASECOMPONENT_BASEITEMLIST_LABEL_FIELD3'); ?>
      </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->items as $id => $item) :
        $slug = preg_replace('/[^a-z\d]/i', '-', $item->title);
        $slug = strtolower(str_replace(' ', '-', $slug));
    ?>
    <tr>
        <td><a href="<?php /*$item->id;*/ echo Route::_(BaseItemListHelperRoute::getBaseItemRoute($item->id, $slug)); ?>">
        <?php echo $item->title; ?></a></td>
        <td><?php echo $item->description; ?></td>
        <td><?php echo $item->field_1; ?></td>
        <td><?php echo $item->field_2; ?></td>
        <td><?php echo $item->field_3; ?></td>
    </tr>
    <?php endforeach; ?><?php //endif; ?>
    </tbody>
  </table>
</div>