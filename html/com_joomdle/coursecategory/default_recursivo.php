<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); 
$user = JFactory::getUser();
$username = $user->username; ?>

<div class="filtros">
  <?php  if (is_array ($this->categories)){ ?>
  <div class="btn-group" role="group" data-filter-group="categoria">
    <button class="btn btn-secondary active" data-filter="">Qualquer categoria</button>
    <?php foreach ($this->categories as  $cat){
      $this->cursos = array_merge($this->cursos, JoomdleHelperContent::getCourseCategory($cat['id'], $username));
      ?>
    <button class="btn btn-secondary" data-filter=".cat<?php echo $cat['id'];?>"><?php echo $cat['name'];?></button>
    <?php } ?>
  </div>

<?php } ?>

  <div class="btn-group" role="group" data-filter-group="status">
    <button class="btn btn-secondary active" data-filter="">Qualquer Status</button>
    <button class="btn btn-secondary" data-filter=".aberto">Aberto</button>
    <button class="btn btn-secondary"  data-filter=".breve">Em breve</button>
    <button class="btn btn-secondary"  data-filter=".encerrado">Encerrado</button>
  </div>
</div>


<?php
  //var_dump($this->cursos);
  //if (is_array ($this->cursos) && count($this->cursos)>0): ?>
    <div class="grid row">

    </div>


<div class="grid row">
  <div class="grid-item col-sm-12 col-md-6 cat1 aberto">
    <div class="card mb-2">
      .mt.
    </div>
  </div>
  <div class="grid-item col-sm-12 col-md-6 cat2 breve">
    <div class="card mb-2">
      .m.
    </div>
  </div>
  <div class="grid-item col-sm-12 col-md-6 cat2 encerrado">
    <div class="card">
      .t.
    </div>
  </div>

</div>




<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script>
(function ($) {
  var $grid = $('.grid').isotope({
    // options
    itemSelector: '.grid-item',
    layoutMode: 'fitRows'
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