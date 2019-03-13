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

        <div class="card-body">
          <h4 class="text-center">
            <?php echo $course_info['fullname']; ?>
          </h4>
          <?php
          if ($user->guest): ?>
            <div class="alert alert-warning" role="alert">
              Acesse sua conta ou registre-se para acessar os cursos!!
              <a class="btn btn-primary" data-toggle="modal" data-target="#login-modal" >Login</a> OU 
              <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-info">Registre-se</a>

            </div>

          <?php endif;   
          ?>

          <?php 

          $is_enroled = $course_info['enroled'];
          $url = JUri::base().'moodle/course/view.php?id='.$course_info['remoteid'];
                      #$url = JoomdleHelperContent::get_course_url ($course_info['remoteid']);
          if (!$user->guest):
            if ($is_enroled): ?>

             <a class="btn btn-primary btn-lg btn-block" href="<?php echo $url ?>" target="_blank">Acessar</a>
             <!-- nova janela window.open('<?php echo $url ?>') -->
             <!-- mesma janela window.location.href='<?php echo $url ?>' -->

             <?php 
             elseif($course_info['in_enrol_date']): ?>

              <!-- Button trigger modal -->
              <button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#modal_<?php echo $course_info['remoteid']?>">
                Inscrever-se e Acessar
              </button>

              <!-- Modal -->
              <div class="modal fade" id="modal_<?php echo $course_info['remoteid']?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"><?php echo $course_info['fullname'] ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="float-right">
                        <?php echo JoomdleHelperSystem::actionbutton ( $course_info, $this->params->get( 'free_courses_button' ), '', "Confirmar Inscrição") ?>
                      </div>

                      <?php echo JoomdleHelperSystem::fix_text_format($course_info['summary']); ?>
                    </div>

                  </div>
                </div>
              </div>


            <?php else: // inscricao fechadas ?>
              <?php
                          $temp=(int)$course_info['startdate'];
                          
                          $hoje=new DateTime();
                          $texto="Inscrições encerradas";
                          if ($course_info['startdate']!=NULL && $hoje->getTimestamp()<$temp){
                            $texto="Inscrições em breve ";
                          }?>
                          <button type="button" class="btn btn-lg btn-block btn-dark" disabled><?php echo $texto; ?></button>

        

            <?php endif;
          endif; ?>
        </div>
      </div>
    </div>

  </div>



  <div class="badge badge-pill badge-primary">Ementa </div>

  <?php echo JoomdleHelperSystem::fix_text_format($course_info['summary']); ?>


</div>
