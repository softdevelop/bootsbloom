$(document).ready(function(){
  var currentPosition_new =0;
  var slideWidth_new = 230;
  var slides_new = $('.slide_new');
  
  var numberOfSlides_new = slides_new.length;

  // Remove scrollbar in JS
  $('#slidesContainer_new').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides_new
    .wrapAll('<div id="slideInner_new"></div>')
    // Float left to display horizontally, readjust .slides width
	.css({
      'float' : 'left',
      'width' : slideWidth_new
    });

  // Set #slideInner width equal to total width of all slides
  $('#slideInner_new').css('width', slideWidth_new * numberOfSlides_new);

  // Insert controls in the DOM
  $('#slideshow_new')
    .prepend('<span class="control_new " id="leftControl_new">Clicking moves left</span>')
    .append('<span class="control_new" id="rightControl_new">Clicking moves right</span>');

  // Hide left arrow control on first load
  manageControls(currentPosition_new);

  // Create event listeners for .controls clicks
  $('.control_new')
    .bind('click', function(){
    // Determine new position
	currentPosition_new = ($(this).attr('id')=='rightControl_new') ? currentPosition_new+1 : currentPosition_new-1;
  
	// Hide / show controls
    manageControls(currentPosition_new);
    // Move slideInner using margin-left
    $('#slideInner_new').animate({
      'marginLeft' : slideWidth_new*(-currentPosition_new)
    });
  });

  // manageControls: Hides and Shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ $('#leftControl_new').hide() } else{ $('#leftControl_new').show() }
	// Hide right arrow if position is last slide
    if(position >= numberOfSlides_new -4){ $('#rightControl_new').hide() } else{ $('#rightControl_new').show() }
  }	
});