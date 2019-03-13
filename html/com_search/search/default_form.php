<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
$state      = $this->get('state');

?>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search'); ?>" method="post">
	<div class="form-row align-items-center">
		<div class="input-group mb-3">
			<input type="text" class="inputbox form-control" name="searchword" title="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" />
			<div class="input-group-append">
				<button class="btn btn-primary hasTooltip" name="Search" onclick="this.form.submit()" title="<?php echo JHtml::_('tooltipText', 'COM_SEARCH_SEARCH');?>">
					<i class="fas fa-search"></i>
					<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
				</button>
			</div>
		</div>
		<input type="hidden" name="task" value="search" />
		<div class="clearfix"></div>
	</div>
	
	<?php if ($this->params->get('search_phrases', 1)) : ?>
		<div class="btn-group">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMatch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo JText::_('COM_SEARCH_FOR'); ?>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMatch">
				<?php 
				$match_values= ['all'=> 'COM_SEARCH_ALL_WORDS', 'any'=> 'COM_SEARCH_ANY_WORDS', 'exact'=>'COM_SEARCH_EXACT_PHRASE'];
				foreach ($match_values as $id => $text){
					$check='';
					if($state->get('match')!=null && $state->get('match')==$id){
						$check='checked="checked"';
					}?>

					<div class="dropdown-item"> <input type="radio" name="searchphrase" id="searchphrase<?php echo $id; ?>" value="<?php echo $id; ?>" <?php echo $check; ?> ><?php echo JText::_($text); ?></div>
				<?php }
				?>

			</div>
		</div>
		<div class="btn-group">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownOrdering" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo JText::_('COM_SEARCH_ORDERING'); ?>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownOrdering">
				<?php 
				$ordering_values= ['newest'=> 'COM_SEARCH_NEWEST_FIRST', 'oldest'=> 'COM_SEARCH_OLDEST_FIRST', 'popular'=>'COM_SEARCH_MOST_POPULAR', 'alpha'=>'COM_SEARCH_ALPHABETICAL','category'=>'JCATEGORY'];
				foreach ($ordering_values as $id => $text){
					$check='';
					if($state->get('ordering')!=null && $state->get('ordering')==$id){
						$check='checked="checked"';
					}?>

					<div class="dropdown-item"> <input type="radio" name="ordering" id="ordering<?php echo $id; ?>" value="<?php echo $id; ?>" <?php echo $check; ?> ><?php echo JText::_($text); ?></div>
				<?php }
				?>

			</div>
		</div>

	<?php endif; ?>
	<?php if ($this->params->get('search_areas', 1)) : ?>
		<div class="btn-group">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownSearchareas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo JText::_('COM_SEARCH_SEARCH_ONLY'); ?>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownSearchareas">
				<?php foreach ($this->searchareas['search'] as $val => $txt) { ?>
					<?php $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : ''; ?>
					<div class="dropdown-item">
						<input type="checkbox" name="areas[]" value="<?php echo $val; ?>" id="area-<?php echo $val; ?>" <?php echo $checked; ?> />
						<?php echo JText::_($txt);?>
					</div>
				<?php } ?>

			</div>
		</div>
	<?php endif; ?>

	<table class="table mt-4 mb-0">
		<thead>
			<tr>
				<th>
					<?php if (!empty($this->searchword)) { 
						echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="badge badge-info">' . $this->total . '</span>');  
					} ?>
				</th>
				<th class="text-right">
					<?php if ($this->total > 0) { 
						echo JText::_('JGLOBAL_DISPLAY_NUM');
						echo $this->pagination->getLimitBox();
					} ?>

				</th>
			</tr>
		</thead>
	</table>
</form>
