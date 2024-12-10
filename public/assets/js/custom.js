
$('.gallery_carousel').owlCarousel({ 
    loop:true,
    center: true,
    margin:0,
	dots:true,
    autoplay:false,
    autoplayTimeout:5000,
    nav:false,
    responsive:{
        0:{
            items:1
        },
		480:{
            items:1
        },
        600:{
            items:2
        },
        1024:{
            items:4
        },
        1025:{
            items:4
        }
    }
});
  
// Manually trigger the Owl Carousel navigation
$(".owl-prev").click(function() {
  $(".gallery_carousel").trigger("prev.owl.carousel");
});

$(".owl-next").click(function() {
  $(".gallery_carousel").trigger("next.owl.carousel");
});












	$(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroll').fadeIn(); 
        } else { 
            $('#scroll').fadeOut(); 
        } 
    }); 
    $('#scroll').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 1500); 
        return false; 
    }); 
});









