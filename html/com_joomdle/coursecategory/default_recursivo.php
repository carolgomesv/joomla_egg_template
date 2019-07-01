<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); 
$user = JFactory::getUser();
$username = $user->username; ?>

 <?php
  if ($user->guest): ?>
    <div class="alert alert-light" role="alert">
      Acesse sua conta ou registre-se para acessar os cursos
      <a class="btn btn-outline-primary" data-toggle="modal" data-target="#login-modal" >Login</a> OU 
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-outline-info">Registre-se</a>

    </div>

  <?php endif;    ?>

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


<?php

if (is_array ($this->cursos) && count($this->cursos)>0): ?>
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
          <div class="card-header nome_curso">
            <b><?php echo $curso['fullname'] ?></b>
          </div>
          <div class="categorias mx-3 mb-1">
            <span class="badge badge-info"><?php echo $this->cat_name; ?></span> <span class="badge badge-info cat_curso"><?php echo $curso['cat_name']; ?></span>
          </div>
          <div class="mx-3 mb-3">
            <?php enrol_btn2($curso, status($curso)); ?>
            <?php if ($curso['summary']) : ?>
                <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal_<?php echo $curso['remoteid'];?>"> Veja a Ementa </a>
            <?php endif; ?>
          </div>
          
        </div>
      </div>

    <?php endforeach ?>

  </div>
<?php endif; ?>



<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script>
  (function ($) {

  var $grid = $('.grid').imagesLoaded( function() {
    // init Isotope after all images have loaded
    $grid.isotope({
      // options
      itemSelector: '.grid-item',
      layoutMode: 'fitRows',
      getSortData: {
        nome: '.nome_curso',
        categoria: '.cat_curso'
      }
    });
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