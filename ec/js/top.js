/* LOADER */

$(window).load(function(){
  // var vid = document.getElementById("hero-video");

	// setTimeout(function() {
	// 	$('.loading').hide(300);
  // }, 2500);
  
  setTimeout(function() {
    $('.txt-desired').css('opacity',1);
    setInterval(function(){  }, 3000);
	}, 3000);
});


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

$(".nav-menu-button").click(function(){
  $(".nav-menu").slideToggle();
  $(".nav-menu-button").toggleClass("active");
  $("body").toggleClass("fixed");
});

var vW = $(window).width();
if(vW < 768) {
  $('.nav-menu a').click(function() {
    $(".nav-menu").slideUp(200);
  });
}


$('#pageTop').click(function() { $('body,html').animate({ scrollTop: 0 }, 800); });
