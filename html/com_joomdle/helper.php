<?php 
/*
implementar listar cursos das subcategorias
 $user = JFactory::getUser();
        $username = $user->username;
        $this->cursos = JoomdleHelperContent::getCourseCategory ($id, $username);

*/


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
          <div class="float-right">
            <?php echo JoomdleHelperSystem::actionbutton ( $curso, 'enrol', '', "Confirmar Inscrição") ?>
          </div>

          <?php echo JoomdleHelperSystem::fix_text_format($curso['summary']); ?>
        </div>

      </div>
    </div>
  </div>

<?php }

function enrol_btn($curso){
  $url = JUri::base().'moodle/course/view.php?id='.$curso['remoteid'];
  if ((!$user->guest) && ($curso['enroled'])){
    //aluno está inscrito no curso
    ?>
    <a class="btn btn-primary btn-lg btn-block" href="<?php echo $url ?>" target="_blank">Acessar</a>
  <?php }
  elseif ($curso['in_enrol_date']){
    // inscrições abertas
    // como bloquear inscrições de outros municípios?
    // bloquear inscrições de quem não finalizou outros cursos?
    $link_modal="#login-modal";

    if (!$user->guest){
      $link_modal= "#modal_".$curso['remoteid'];
      course_modal($curso);
    } ?>

    <button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="<?php echo $link_modal?>">
      Inscrever-se e Acessar
    </button>
  <?php  }
  else{
      // incrições fechadas
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
    $texto="Inscrições encerradas";
    if ($enrolstartdate>0 && $enrolstartdate>$hoje->getTimestamp()){
      $texto="Inscrições em breve";
    }
    if ($enrolenddate>0 && $enrolenddate<$hoje->getTimestamp()){
      $texto="Inscrições encerradas";
    }

    ?>

    <button type="button" class="btn btn-lg btn-block btn-dark" disabled><?php echo $texto; ?></button>
  <?php  }
}
?>
