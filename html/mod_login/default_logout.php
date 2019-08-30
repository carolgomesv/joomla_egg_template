<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>


<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-vertical">


<div class="btn-group d-lg-none" role="group">
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php if ($params->get('greeting', 1)) : ?>

					<?php echo JText::sprintf('TPL_LOGIN_HINAME', htmlspecialchars('')); ?>

					<?php endif; ?>
			</button>
			<div class="dropdown-menu " aria-labelledby="dropdownMenuButton">


				<?php if ($params->get('profilelink', 0)) : ?>
				<a class="dropdown-item" href="<?php echo JRoute::_('index.php?option=com_users&view=profile'); ?>">
					<i class="fas fa-user-circle"></i> Perfil</a>

				<?php endif; ?>



				<button type="submit" name="Submit" class="dropdown-item"> <i class='fas fa-sign-out-alt'></i> <?php echo JText::_('JLOGOUT'); ?></button> 
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.logout" />
				<input type="hidden" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>

			</div>
			
		</div>
		<a href="http://egg.seplag.niteroi.rj.gov.br/moodle/my/" class="btn btn-primary btn-sm" target="_blank">Meus Cursos</a>
	</div>

	<div class="btn-group d-none d-lg-block" role="group">
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php if ($params->get('greeting', 1)) : ?>

					<?php if (!$params->get('name', 0)) : ?>
						<?php echo JText::sprintf('TPL_LOGIN_HINAME', htmlspecialchars($user->get('name'), ENT_COMPAT, 'UTF-8')); ?>
						<?php else : ?>
							<?php echo JText::sprintf('TPL_LOGIN_HINAME', htmlspecialchars($user->get('username'), ENT_COMPAT, 'UTF-8')); ?>
						<?php endif; ?>

					<?php endif; ?>
			</button>
			<div class="dropdown-menu " aria-labelledby="dropdownMenuButton">


				<?php if ($params->get('profilelink', 0)) : ?>
				<a class="dropdown-item" href="<?php echo JRoute::_('index.php?option=com_users&view=profile'); ?>">
					<i class="fas fa-user-circle"></i> Perfil</a>

				<?php endif; ?>



				<button type="submit" name="Submit" class="dropdown-item"> <i class='fas fa-sign-out-alt'></i> <?php echo JText::_('JLOGOUT'); ?></button> 
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.logout" />
				<input type="hidden" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>

			</div>
		</div>
		<a href="/moodle/" class="btn btn-primary" target="_blank">Meus Cursos</a>
	</div>



</form>