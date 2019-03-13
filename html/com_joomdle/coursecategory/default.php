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
?>
<div class="joomdle-coursecategory<?php echo $this->pageclass_sfx;?>">
  <h2>
    <?php echo $this->cat_name; ?>
  </h2>


  <?php
  if ($user->guest): ?>
    <div class="alert alert-warning" role="alert">
      Acesse sua conta ou registre-se para acessar os cursos!!
      <a class="btn btn-primary" data-toggle="modal" data-target="#login-modal" >Login</a> OU 
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-info">Registre-se</a>

    </div>

  <?php endif;   
  ?>


  <div class="joomdle_categories">

    <?php
    if (is_array ($this->categories))
      foreach ($this->categories as  $cat) : ?>

        <?
        if ($unicodeslugs == 1)
        {
          $cat_slug = JFilterOutput::stringURLUnicodeSlug($cat['name']);
        }
        else
        {
          $cat_slug = JFilterOutput::stringURLSafe($cat['name']);
        }
        ?>



        <?php $url = JRoute::_("index.php?option=com_joomdle&view=coursecategory&cat_id=".$cat['id'].'-'. $cat_slug .
          "&Itemid=$itemid"); 
        switch($cat['id']){
          default:
          $icon="fa-book";
        }

        ?>
        <a href="<?php echo $url?>" class="btn btn-primary btn-lg ">

          <i class="fa <?php echo $icon?>"></i>
          <?php echo $cat['name'] ?>

        </a>

      <?php endforeach; ?>
    </div>
    <br>
    <div class="joomdle_courses">


      <?php
      if (is_array ($this->cursos) && count($this->cursos)>0): ?>


        <div class="row">

          <?php $arrays = array_chunk($this->cursos, ceil(count($this->cursos) / 2));

          foreach ($arrays as  $cursos): ?>
            <div class="col-sm-12 col-md-6">
              <?php 
              foreach ($cursos as  $curso): ?>
                <div class="card mb-2">
                  <?php if (!empty($curso['summary_files'][0]['url'])){ ?>
                    <div class="card-img">
                      <img src="<?php echo $curso['summary_files'][0]['url']; ?>" class="img-responsive">
                    </div>
                  <?php } ?>
                  <div class="card-body">

                    <h4 class="text-center">
                      <?php echo $curso['fullname'] ?>
                    </h4>

                    <?php if ($curso['summary']) : ?>
                      <center>
                        <a class="badge badge-pill badge-primary" role="button" data-toggle="collapse" href="#collapse_<?php echo $curso['remoteid']?>" aria-expanded="false" aria-controls="collapse_<?php echo $curso['remoteid']?>"> Veja a Ementa </a>
                      </center>

                      <div class="collapse text-left" id="collapse_<?php echo $curso['remoteid']?>">
                        <div class="well">
                          <?php echo JoomdleHelperSystem::fix_text_format($curso['summary']); ?>
                          
                        </div>
                      </div>
                    <?php endif; ?>
                    <?php 
                    
                    $is_enroled = $curso['enroled'];
                    $url = JUri::base().'moodle/course/view.php?id='.$curso['remoteid'];
                    #$url = JoomdleHelperContent::get_course_url ($course_info['remoteid']);
                     if ((!$user->guest) && ($is_enroled)): ?>

                       <a class="btn btn-primary btn-lg btn-block" href="<?php echo $url ?>" target="_blank">Acessar</a>
                       <!-- nova janela window.open('<?php echo $url ?>') -->
                       <!-- mesma janela window.location.href='<?php echo $url ?>' -->


                       <?php 
                       elseif($curso['in_enrol_date']): 
                        $link_modal="#login-modal";

                        if (!$user->guest): 

                          $link_modal= "#modal_".$curso['remoteid'];
                          ?>
                        <!-- Modal -->
                        <div class="modal fade" id="modal_<?php echo $curso['remoteid']?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title"><?php echo $curso['fullname'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="float-right">
                                  <?php echo JoomdleHelperSystem::actionbutton ( $curso, $this->params->get( 'free_courses_button' ), '', "Confirmar Inscrição") ?>
                                </div>

                                <?php echo JoomdleHelperSystem::fix_text_format($curso['summary']); ?>
                              </div>

                            </div>
                          </div>
                        </div>

                        <?php endif;?>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="<?php echo $link_modal?>">
                          Inscrever-se e Acessar
                        </button>

                        <?php else: ?>
                          <?php
                          $start=(int)$curso['startdate'];
                          $hoje=new DateTime();
                          $texto="Inscrições em breve";
                          if ($curso['startdate']!=NULL && $hoje->getTimestamp()>$start && !$curso['in_enrol_date']){
                            $texto="Inscrições encerradas";
                          }

                          ?>
                          <button type="button" class="btn btn-lg btn-block btn-dark" disabled><?php echo $texto; ?></button>

                        <?php endif; ?>

                    </div>
                  </div>

                <?php endforeach; ?>
              </div>
            <?php endforeach;?>
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