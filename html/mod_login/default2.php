<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

$usersConfig = JComponentHelper::getParams('com_users'); 
?>

<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<h3 class="modal-title">Acesso à plataforma</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="align-items-center">

					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fas fa-user"></i></div>
							</div>
							<input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="Usuário" />
						</div>
						
					</div>

					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fas fa-key"></i></div>
							</div>
							<input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" />
						</div>
						
					</div>


					<button type="submit" tabindex="0" name="Submit" class="btn btn-primary btn-block"><?php echo JText::_('JLOGIN'); ?></button>

					<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>

						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox"  id="modlgn-remember">
							<label class="form-check-label" for="autoSizingCheck">
								Manter conectado
							</label>
						</div>
						
					<?php endif; ?>

					<center>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"  class="btn btn-outline-info"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a> 
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="btn btn-outline-info"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
					</center>
					<br/>


					<?php if ($usersConfig->get('allowUserRegistration')) : ?>

						<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-secondary btn-block"> <?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>

					<?php endif; ?>






					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</div>
				<?php if ($params->get('posttext')) : ?>
					<div class="posttext">
						<p><?php echo $params->get('posttext'); ?></p>
					</div>
				<?php endif; ?>
			</form>

		</div>
	</div>
</div>
</div>
