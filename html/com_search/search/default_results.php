<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>


<div class="search-results<?php echo $this->pageclass_sfx; ?>">

<table class="table table-striped">
  <tbody>

<?php foreach ($this->results as $result) : ?>

	<tr>
      <th scope="row"><?php echo $this->pagination->limitstart + $result->count . '. '; ?></th>
      <td><?php if ($result->href) : ?>
			<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) : ?> target="_blank"<?php endif; ?>>
				<b><?php echo $result->title; ?></b>
			</a>
		<?php else : ?>
			<b><?php echo $result->title; ?></b>
		<?php endif; ?>

		<?php if ($result->section) : ?>
			<span class="badge badge-secondary">
				(<?php echo $this->escape($result->section); ?>)
			</span>
		
	<?php endif; ?>
	
		<p><?php echo $result->text; ?></p>
	
	<?php if ($this->params->get('show_date')) : ?>
		<span class="result-created<?php echo $this->pageclass_sfx; ?>">
			<?php echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
		</span>
	<?php endif; ?>


	</td>
    </tr>
<?php endforeach; ?>

</tbody>
</table>
</div>
<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
