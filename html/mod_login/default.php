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
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#login-modal" ><i class="fas fa-user-circle"></i> Área do aluno</button> 

<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-primary"> Criar conta</a>
