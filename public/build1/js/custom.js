// JavaScript Document.

// Just Added Products Carousal
(function() { 
  // store the slider in a local variable
  var $window = $(window),
      flexslider;
 
  // tiny helper function to add breakpoints
 function getGridSize() {
    	 return (window.innerWidth < 470) ? 1 :
		   	    (window.innerWidth < 800) ? 2 :
           		(window.innerWidth < 1200) ? 3 : 4;
  	}	
 
  $window.load(function() {
    $('.crflexslider').flexslider({
      animation: "slide",
	  slideshow: false,
      animationLoop: true,
      itemWidth: 250,
      itemMargin: 34,
	  move: 1,
      minItems: getGridSize(), // use function to pull in initial value
      maxItems: getGridSize() // use function to pull in initial value
    });
  });
 
  // check grid size on resize event
}());

// Recommended For You Carousal

(function() { 
  // store the slider in a local variable
  var $window = $(window),
      flexslider;
 
  // tiny helper function to add breakpoints
  function getGridSize1() {
    return (window.innerWidth < 470) ? 1 :
		   (window.innerWidth < 800) ? 2 :
           (window.innerWidth < 1200) ? 3 : 3;
  }
 
  $window.load(function() {
    $('.newflexslider').flexslider({
      animation: "slide",
      animationLoop: true,
	  slideshow: false,
      itemWidth: 270,
      itemMargin: 33,
	  move: 1,
      minItems: getGridSize1(), // use function to pull in initial value
      maxItems: getGridSize1() // use function to pull in initial value
    });
  });
 
  // check grid size on resize event


}());


// Brand Carousal full
(function() { 
  // store the slider in a local variable
  var $window = $(window),
      flexslider;
 
  // tiny helper function to add breakpoints
  function getGridSize2() {
    return (window.innerWidth < 470) ? 1 :
		   (window.innerWidth < 800) ? 2 :
           (window.innerWidth < 1200) ? 5 : 5;
  }
 
  $window.load(function() {
    $('.brandflexsliderfull').flexslider({
      animation: "slide",
      animationLoop: true,
      itemWidth: 270,
      itemMargin: 32,
      minItems: getGridSize2(), // use function to pull in initial value
      maxItems: getGridSize2() // use function to pull in initial value
    });
  });
 
  // check grid size on resize event

}());


$(document).ready(function(e) {
	
$ (".zoom" ).click( function () {
    var That =  this ;
    $( ".my-foto-container" ).fadeOut ( 100 , function (){
		 $(this).attr( "src" ,$ ( That).attr ( "src" ))            
	     . attr ("data-large", $ (That).attr ("data-large")).fadeIn (200 )
		 . attr ("data-title", $ (That).attr ("data-title"))
		 . attr ("data-help", $ (That).attr ("data-help"))
				
    }); 
});
       
// Scroll top
	$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#gotop').fadeIn(500);
							
			} else {
				$('#gotop').fadeOut(500);
			}
		});	
	$('#gotop').click(function()
			{
				
				$("html, body").animate({ scrollTop: 0 }, 600);
			})
		
});	






// Window load Events
$( window ).load(function() {	
	$widthscreen = $(window).width();
	if ($widthscreen > 801){
	// Mega Menu
	$('ul.mainnav li.dropdown').hover(function()
		{
			$(this).children('.dropdown-menu').fadeIn(0)
		},
		function()
		{
			$(this).children('.dropdown-menu').fadeOut(0)
		}
		)
	}

});	

$(function() {
	$(document).on('mouseover', '.yamm .dropdown-menu', function(e) {
		e.stopPropagation()
	})
})
