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
$username = $user->username;

include(dirname(__FILE__)."/../helper.php");

?>
<div class="joomdle-coursecategory <?php echo $this->pageclass_sfx;?>">
  <h2>
    <?php echo $this->cat_name; ?>
  </h2>

  <?php
  if ($user->guest): ?>
    <div class="alert alert-light" role="alert">
       <a class="btn btn-outline-primary" data-toggle="modal" data-target="#login-modal" >Acesse sua conta</a> ou <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-outline-info">cadastre-se</a> para acessar os cursos

    </div>

  <?php endif;    ?>

  <?php if ($this->pageclass_sfx=="recursivo"){ ?>
    <b>Filtre por:</b> <br/>
<div class="filtros mb-4">
  <?php  if (is_array ($this->categories)){ ?>
    Categoria
    <div class="btn-group btn-group-sm m-2" role="group" data-filter-group="categoria">
      <button class="btn btn-primary active" data-filter="">Todas as categorias</button>
      <?php foreach ($this->categories as  $cat){
        $this->cursos = array_merge($this->cursos, JoomdleHelperContent::getCourseCategory($cat['id'], $username));
        ?>
        <button class="btn btn-primary" data-filter=".cat<?php echo $cat['id'];?>"><?php echo $cat['name'];?></button>
      <?php } ?>
    </div>

  <?php } ?>
  <br/>
  Inscrições
  <div class="btn-group btn-group-sm m-2" role="group" data-filter-group="status">
    <button class="btn btn-secondary active" data-filter="">Todas</button>
    <button class="btn btn-secondary" data-filter=".aberto">Abertas</button>
    <button class="btn btn-secondary"  data-filter=".breve">Em breve</button>
    <button class="btn btn-secondary"  data-filter=".encerrado">Encerradas</button>
  </div>
</div>
    <?php }
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

<?php if ($this->pageclass_sfx=="recursivo"){ ?>
<script src="http://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="http://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script>
  (function ($) {
// init Isotope
var $grid = $('.grid').isotope({
  // options
      itemSelector: '.grid-item',
      layoutMode: 'fitRows',
      sortBy: 'random',
      getSortData: {
        nome: '.nome_curso',
        categoria: '.cat_curso'
      }
});
// layout Isotope after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.isotope('layout');
});
  // filter functions
  var filters = {};

  // bind filter button click
  $('.filtros').on( 'click', '.btn', function( event ) {
    var $button = $( event.currentTarget );
    // get group key
    var $buttonGroup = $button.parents('.btn-group');
    var filterGroup = $buttonGroup.attr('data-filter-group');
    // set filter for group
    filters[ filterGroup ] = $button.attr('data-filter');
    // combine filters
    var filterValue = concatValues( filters );
    // set filter for Isotope
    $grid.isotope({ filter: filterValue });
  });

  // change is-checked class on buttons
  $('.btn-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function( event ) {
      $buttonGroup.find('.active').removeClass('active');
      var $button = $( event.currentTarget );
      $button.addClass('active');
    });
  });

  // flatten object by concatting values
  function concatValues( obj ) {
    var value = '';
    for ( var prop in obj ) {
      value += obj[ prop ];
    }
    return value;
  }
  })(jQuery);
</script>

<?php } ?>