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
<div class="category-module<?php echo $moduleclass_sfx; ?> mod-list row">
	<?php foreach ($list as $item) : ?>
		<div class="col-md-6">
		<div class="card border-light mb-1">
			<div class="card-header">
				<b>
					<?php if ($params->get('link_titles') == 1) : ?>
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>
				</b>
					
				</div>
				<div class="card-body">

<small>
				<?php if ($item->displayDate) : ?>
						<span class="mod-articles-category-date">
							<i class="far fa-calendar-alt"></i> 
							<?php echo $item->displayDate; ?>
						</span>
					<?php endif; ?>

					<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
						<div class="mod-articles-category-tags">
							<i class="fas fa-tags"></i>
							<?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
						</div>
					<?php endif; ?>
				</small><br/>
					<?php if ($params->get('show_introtext')) : ?>
						<p class="mod-articles-category-introtext">
							<?php echo $item->displayIntrotext; ?>
						</p>
					<?php endif; ?>

					<?php if ($params->get('show_readmore')) : ?>
						<p class="mod-articles-category-readmore">
							<a class="btn btn-outline-secondary btn-sm" href="<?php echo $item->link; ?>">
								<?php if ($item->params->get('access-view') == false) : ?>
									<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?php echo $readmore; ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
										<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
											<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
											<?php else : ?>
												<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php endif; ?>
										</a>
									</p>
								<?php endif; ?>
							</div>
						</div>
</div>
					<?php endforeach; ?>
				</div>
