<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); ?>

<?php
$itemid = JoomdleHelperContent::getMenuItem();
$free_courses_button = $this->params->get( 'free_courses_button' );
$paid_courses_button = $this->params->get( 'paid_courses_button' );
$show_buttons = $this->params->get( 'coursecategory_show_buttons' );

$unicodeslugs = JFactory::getConfig()->get('unicodeslugs');

$user = JFactory::getUser();

include(dirname(__FILE__)."/../helper.php");

?>
<div class="joomdle-coursecategory <?php echo $this->pageclass_sfx;?>">
  <h2>
    <?php echo $this->cat_name; ?>
  </h2>

  <?php
  if ($user->guest): ?>
    <div class="alert alert-light" role="alert">
      Acesse sua conta ou registre-se para acessar os cursos
      <a class="btn btn-outline-primary" data-toggle="modal" data-target="#login-modal" >Login</a> OU 
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-outline-info">Registre-se</a>

    </div>

  <?php endif;    ?>

  <?php if ($this->pageclass_sfx=="recursivo"){
    echo $this->loadTemplate('recursivo');
    }
    else { ?>
      <div class="joomdle_categories">

        <?php    if (is_array ($this->categories)):
          foreach ($this->categories as  $cat) : 
            if ($unicodeslugs == 1) {
              $cat_slug = JFilterOutput::stringURLUnicodeSlug($cat['name']);
            }
            else  {
              $cat_slug = JFilterOutput::stringURLSafe($cat['name']);
            }

            $url = JRoute::_("index.php?option=com_joomdle&view=coursecategory&cat_id=".$cat['id'].'-'. $cat_slug .
              "&Itemid=$itemid"); 
            switch($cat['id']){
              default:
              $icon="fa-book";
            } ?>
            <a href="<?php echo $url?>" class="btn btn-primary btn-lg ">
              <i class="fa <?php echo $icon?>"></i>
              <?php echo $cat['name'] ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif;
    } ?>
    <div class="joomdle_courses">
      <?php  if (is_array ($this->cursos) && count($this->cursos)>0): ?>
        <div class="grid row">
          <?php foreach ($this->cursos as  $curso): 
            $status=status($curso); ?>
            <div class="grid-item col-sm-12 col-md-6 cat<?php echo $curso['cat_id'];?> <?php echo $status;?>">
              <div class="card mb-4">
                <?php if (!empty($curso['summary_files'][0]['url'])){ ?>
                  <div class="card-img">
                    <img src="<?php echo $curso['summary_files'][0]['url']; ?>" class="img-responsive">
                  </div>
                <?php } ?>
                <div class="card-header">
                  <b class="nome_curso"><?php echo $curso['fullname'] ?></b>
                </div>
                <div class="categorias mx-3 mb-1">
                  <?php $parent_category= get_parent_category($curso['cat_id']); ?>
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
                    <span class="badge badge-info cat_curso"><?php echo $curso['cat_name']; ?></span>
                  </div>
                  <div class="mx-3 mb-3">
                    <?php enrol_btn($curso, status($curso)); ?>
                    <?php if ($curso['summary']) : ?>
                      <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal_<?php echo $curso['remoteid'];?>"> Veja a Ementa </a>
                    <?php endif; ?>
                  </div>

                </div>
              </div>

            <?php endforeach ?>

          </div>
        <?php endif; ?>



      </div>
      <?php

      if (count($this->cursos)==0):?>

        <div class="alert alert-info">

          Aguarde em breve novos cursos
        </div>

      <?php endif ?>

    </div>

