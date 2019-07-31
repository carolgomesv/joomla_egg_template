<?php 

function course_modal($curso){
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
          <?php if ((!$user->guest) && (!$curso['enroled'])){ ?>
            <div class="inscrever-btn mr-3">
              <?php echo JoomdleHelperSystem::actionbutton ( $curso, 'enrol', '', "Confirmar Inscrição") ?>
            </div>
          <?php } ?>
          <?php echo JoomdleHelperSystem::fix_text_format($curso['summary']); ?>
        </div>

      </div>
    </div>
  </div>

<?php
 }
function status($curso){
  if ($curso['in_enrol_date']){
    return "aberto";
  }
  $enrolstartdate=0;
  $enrolenddate=0;
  $enrol_methods = JoomdleHelperContent::call_method ('course_enrol_methods', $curso['remoteid']);
  foreach ($enrol_methods as $method) {
    if ($method["enrol"]=="self"){
      $enrolstartdate= $method["enrolstartdate"];
      $enrolenddate= $method["enrolenddate"];
    }
  }
  $hoje=new DateTime();
  if ($enrolstartdate>0 && $enrolstartdate>$hoje->getTimestamp()){
    return "breve";
  }
  if ($enrolenddate>0 && $enrolenddate<$hoje->getTimestamp()){
    return "encerrado";
  }
  return "encerrado";
}

function enrol_btn($curso,$status,$btn_class=''){
  $user = JFactory::getUser();
  $url = JUri::base().'moodle/course/view.php?id='.$curso['remoteid'];
  course_modal($curso);
  if ((!$user->guest) && ($curso['enroled'])){
    //aluno está inscrito no curso
    ?>
    <a class="btn btn-primary btn-lg <?php echo $btn_class;?>" href="<?php echo $url ?>" target="_blank">Acessar</a>
  <?php }

  if ($status=="aberto") {
    // inscrições abertas
    // como bloquear inscrições de outros municípios?
    // bloquear inscrições de quem não finalizou outros cursos?
    $link_modal="#login-modal";

    if (!$user->guest){
      $link_modal= "#modal_".$curso['remoteid'];
      
    } ?>

    <button type="button" class="btn btn-secondary btn-lg <?php echo $btn_class;?>" data-toggle="modal" data-target="<?php echo $link_modal?>">
      Inscrever-se e Acessar
    </button>
  <?php  }
  else{
    if ($status=="breve"){
      $texto="Inscrições em breve";
    }
    if ($status=="encerrado"){
      $texto="Inscrições encerradas";
    }

    ?>

    <button type="button" class="btn btn-lg btn-dark <?php echo $btn_class;?>" disabled><?php echo $texto; ?></button>
  <?php  }
}


function get_parent_category($curso_id){
  $db = JFactory::getDbo();
  $sql = "select id, name  from mdl_course_categories where id in (select parent from mdl_course_categories where id = ".$curso_id." )";
  $db->setQuery($sql);  
  return $db->loadAssoc();
}

?>


