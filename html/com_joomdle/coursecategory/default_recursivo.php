<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); 
$user = JFactory::getUser();
$username = $user->username; ?>

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

<script src="http://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="http://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script>
  (function ($) {

  var $grid = $('.grid').imagesLoaded( function() {
    // init Isotope after all images have loaded
    $grid.isotope({
      // options
      itemSelector: '.grid-item',
      layoutMode: 'fitRows',
      sortBy: 'random',
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