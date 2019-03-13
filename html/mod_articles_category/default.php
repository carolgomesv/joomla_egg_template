<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<div class="category-module<?php echo $moduleclass_sfx; ?> mod-list list-group">
	<?php foreach ($list as $item) : ?>
		<a class="list-group-item list-group-item-action" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
		<?php endforeach; ?>
</div>