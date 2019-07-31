<?php
/**
 * @package   Astroid Framework
 * @author    JoomDev https://www.joomdev.com
 * @copyright Copyright (C) 2009 - 2018 JoomDev.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

$usersConfig = JComponentHelper::getParams('com_users');

?>

<h3 class="text-center pt-3">Acesso à plataforma</h3>


<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
<div class="login-description text-center">
<?php endif; ?>

<?php if ($this->params->get('logindescription_show') == 1) : ?>
	<?php echo $this->params->get('login_description'); ?>
<?php endif; ?>

<?php if (($this->params->get('login_image') != '')) :?>
	<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image mx-auto d-block" alt="<?php echo JTEXT::_('COM_USERS_LOGIN_IMAGE_ALT')?>"/>
<?php endif; ?>

<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
</div>
<?php endif; ?>



<div class="row">

	<div class="col-md-6 offset-md-3">

		<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate">
			<?php /* Set placeholder for username, password and secretekey */
			$this->form->setFieldAttribute( 'username', 'hint', JText::_('COM_USERS_LOGIN_USERNAME_LABEL') );
			$this->form->setFieldAttribute( 'password', 'hint', JText::_('JGLOBAL_PASSWORD') );
			$this->form->setFieldAttribute( 'secretkey', 'hint', JText::_('JGLOBAL_SECRETKEY') );
			?>

			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="fas fa-user"></i></div>
					</div>
					<input id="username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="Usuário" />
				</div>

			</div>

			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="fas fa-key"></i></div>
					</div>
					<input id="password" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" />
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

			<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
		<br/>
		<center>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"  class="btn btn-outline-info"><?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a> 
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="btn btn-outline-info"><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
		</center>
		<br/>


		<?php if ($usersConfig->get('allowUserRegistration')) : ?>

			<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-secondary btn-block"> <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>

		<?php endif; ?>
	</div>

</div>