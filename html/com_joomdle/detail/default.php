<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); ?>

<?php

$course_info = $this->course_info;
$itemid = JoomdleHelperContent::getMenuItem();


$user = JFactory::getUser();
$user_logged = $user->id;

include(dirname(__FILE__)."/../helper.php");

if (!array_key_exists ('cost',$course_info))
  $course_info['cost'] = 0;
?>

<div class="joomdle-coursedetails<?php echo $this->pageclass_sfx;?>">
  <div class="row">
    <div class="col-sm-12 col-md-6 offset-md-3">
      <div class="card mb-2">
        <?php if (!empty($course_info['summary_files'][0]['url'])){ ?>
          <div class="card-img">
            <img src="<?php echo $course_info['summary_files'][0]['url']; ?>" class="img-responsive">
          </div>
        <?php } ?>
        <div class="card-header text-center">
          <b class="nome_curso"><?php echo $course_info['fullname'] ?></b>
        </div>

        <div class="categorias mx-3 mb-1 text-center">
          <?php $parent_category= get_parent_category($course_info['cat_id']); ?>
          <span class="badge badge-info">
            <?php switch ($parent_category['id']) {
              case 12:
              echo '<i class="fas fa-chalkboard-teacher"></i>';
              break;
              case 13:
              echo '<i class="fas fa-laptop"></i>';
              break;
            }  ?>
            <?php echo $parent_category['name']; ?></span>
            <span class="badge badge-info cat_curso"><?php echo $course_info['cat_name']; ?></span>
          </div>
          <div class="mx-3 mb-3">
            <?php
            if ($user->guest){ ?>
              <div class="alert alert-light" role="alert">
                Acesse sua conta ou registre-se para acessar os cursos!!
                <a class="btn btn-primary" data-toggle="modal" data-target="#login-modal" >Login</a> OU 
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-info">Registre-se</a>
              </div>
            <?php }
            enrol_btn($course_info, status($course_info),'btn-block');   ?>
          </div>
        </div>
      </div>

    </div>



    <div class="badge badge-pill badge-primary">Ementa </div>

    <?php echo JoomdleHelperSystem::fix_text_format($course_info['summary']); ?>


  </div>
