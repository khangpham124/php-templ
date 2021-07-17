$(window).scroll(function() {
    var offset_about = $('#about-us').offset().top;
    var offset_menu = $('#menu-section').offset().top;
    var offset_location = $('#location-section').offset().top;
    var offset_contact = $('#contact-section').offset().top;
if ($(this).scrollTop() >= 600) {
    $('#pageTop').css('opacity', 1);
    $('#pageTop').css('bottom', '30px');
    $('.dot-navi').css('opacity', 1);
} else {
    $('#pageTop').css('opacity', 0);
    $('.dot-navi').css('opacity', 0);
    $('#pageTop').css('bottom', '50px');
}
if ($(this).scrollTop() >= 100) {
    $('#header').addClass('fix-header');
} else {
    $('#header').removeClass('fix-header');
}
var scroll = $(window).scrollTop() + 80;
if((scroll >= offset_about)&&(scroll < offset_menu)) {
    $('.dot-navi li').removeClass('active');
    $('#dot_about').addClass('active');
} else if((scroll >= offset_menu)&&(scroll < offset_location)) {
    $('#dot_about').removeClass('active');
    $('.dot-navi li').removeClass('active');
    $('#dot_menu').addClass('active');
} else if((scroll >= offset_location)&&(scroll < offset_contact)) {
    $('#dot_menu').removeClass('active');
    $('.dot-navi li').removeClass('active');
    $('#dot_location').addClass('active');
} else if(scroll >= offset_contact) {
    $('#dot_location').removeClass('active');
    $('.dot-navi li').removeClass('active');
    $('#dot_contact').addClass('active');
} else if(scroll < offset_about) {
    $('.dot-navi li').removeClass('active');
}
});
$('.dot-navi li a').click(function() {
    $('.dot-navi li').removeClass('active');
    $(this).parent().addClass('active');
});