<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::register('users.spacer', array('JHtmlUsers', 'spacer'));

$fieldsets = $this->form->getFieldsets();

if (isset($fieldsets['core']))
{
	unset($fieldsets['core']);
}

if (isset($fieldsets['params']))
{
	unset($fieldsets['params']);
}

$tmp          = isset($this->data->jcfields) ? $this->data->jcfields : array();
$customFields = array();
foreach ($tmp as $customField)
{
	$customFields[$customField->name] = $customField;
}

?>
<div class="profile<?php echo $this->pageclass_sfx; ?>">
	
	
	<h2>
		<?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?>

		<?php if (JFactory::getUser()->id == $this->data->id) : ?>
		<a class="btn btn-secondary btn-sm" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
					<i class="fas fa-user-edit"></i>
					<?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?>
				</a>
	<?php endif; ?>

	</h2>

	

	<div class='row'>
		<div class="col-sm-6">
			<!-- Campos padrão-->
			<div class="form-group">
				<label>
					<?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?>
				</label>
				<input type="text" class="form-control" value="<?php echo $this->escape($this->data->name); ?>" readonly>

			</div>
			<div class="form-group">
				<label>
					<?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?>
				</label>
				<input type="text" class="form-control" value="<?php echo $this->escape($this->data->username); ?>" readonly>

			</div>
			<div class="form-group">
				<label>
					E-mail
				</label>
				<input type="text" class="form-control" value="<?php echo $this->escape($this->data->email); ?>" readonly>

			</div>
			<div class="form-group">
				<label>
					<?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?>
				</label>
				<input type="text" class="form-control" value="<?php echo JHtml::_('date', $this->data->registerDate, JText::_('DATE_FORMAT_LC1')); ?>" readonly>

			</div>
			<div class="form-group">
				<label>
					<?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?>
				</label>
				<?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>

					<input type="text" class="form-control" value="<?php echo JHtml::_('date', $this->data->lastvisitDate, JText::_('DATE_FORMAT_LC1')); ?>" readonly>

					<?php else : ?>

						<input type="text" class="form-control" value="<?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>" readonly>

					<?php endif; ?>

				</div>
			</div>
			<div class="col-sm-6">
				<!-- Campos personalizados-->
				<?php foreach ($fieldsets as $group => $fieldset) : ?>
					<?php $fields = $this->form->getFieldset($group); ?>
					<?php if (count($fields)) : ?>

						<?php foreach ($fields as $field) : ?>
							<?php if (!$field->hidden && $field->type !== 'Spacer') : ?>
								<div class="form-group">
									<label>
										<?php echo $field->title; ?>
									</label>
									<?php $value="";
									if (key_exists($field->fieldname, $customFields)) : 
										$value= strlen($customFields[$field->fieldname]->value) ? $customFields[$field->fieldname]->value : JText::_('COM_USERS_PROFILE_VALUE_NOT_FOUND'); 
									elseif (JHtml::isRegistered('users.' . $field->id)) : 
										$value= JHtml::_('users.' . $field->id, $field->value); 
									elseif (JHtml::isRegistered('users.' . $field->fieldname)) :
										$value= JHtml::_('users.' . $field->fieldname, $field->value); 
									elseif (JHtml::isRegistered('users.' . $field->type)) : 
										$value=JHtml::_('users.' . $field->type, $field->value); 
									else : 
										$value= JHtml::_('users.value', $field->value); 
									endif; ?>
									<input id="<?php echo $field->fieldname;?>" type="text" class="form-control" value="<?php echo  $value;?>" readonly>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>

					<?php endif; ?>
				<?php endforeach; ?>

			</div>

		</div>

	</div>


<script type="text/javascript">
(function ($) {	
	$(document).ready(function() {

		
		$('#cpf').mask('000.000.000-00', {placeholder: "___.___.___-___"});

		var telMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		spOptions = {
			onKeyPress: function(val, e, field, options) {
				field.mask(telMaskBehavior.apply({}, arguments), options);
			}

		};

		$('#telefone').mask(telMaskBehavior, spOptions);


	});
})(jQuery);
</script>