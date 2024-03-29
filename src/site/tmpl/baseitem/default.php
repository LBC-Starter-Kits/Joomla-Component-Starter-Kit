<?php
/**
 * @package     Mywalks.Site
 * @subpackage  com_mywalks
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<div class="page-header">
	<h1><?php echo $this->item->title; ?></h1>
</div>

<p><?php echo $this->item->description; ?>!</p>

<h2><?php echo Text::_('COM_BASECOMPONENT_BASEITEM_INFO'); ?></h2>

<div class="table-resposive">
	<table class="table table-stripped">
		<caption><?php echo Text::_('COM_BASECOMPONENT_BASEITEM_INFO'); ?></caption>
		<thead>
			<tr>
				<th scope="col" style="min-width:6rem;">
					<?php echo Text::_('COM_BASECOMPONENT_BASEITEM_FIELD1'); ?>
				</th>
				<th scope="col" style="min-width:6rem;">
					<?php echo Text::_('COM_BASECOMPONENT_BASEITEM_FIELD2'); ?>
				</th>
				<th scope="col" style="min-width:6rem;">
					<?php echo Text::_('COM_BASECOMPONENT_BASEITEM_FIELD3'); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $this->item->field_1; ?></td>
				<td><?php echo $this->item->field_2; ?></td>
				<td><?php echo $this->item->field_3; ?></td>
			</tr>
		</tbody>
	</table>
</div>


<!-- <h2><?php echo Text::_('COM_MYWALKS_WALK_REPORTS'); ?></h2>

<div class="table-responsive">
  <table class="table table-striped">
  <caption><?php echo Text::_('COM_MYWALKS_WALK_REPORTS'); ?></caption>
  <thead>
    <tr>
 		<th scope="col"><?php echo Text::_('COM_MYWALKS_WALK_DATE'); ?></th>
		<th scope="col"><?php echo Text::_('COM_MYWALKS_WALK_WEATHER'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php //foreach ($this->reports as $id => $report) : ?>
	<tr>
		<td><?php //echo $report->date; ?></td>
		<td><?php //echo $report->weather; ?></td>
	</tr>
	<?php //endforeach; ?><?php //endif; ?>
	</tbody>
  </table>
</div> -->