function createCookie(name, value, hours) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function createCookie_fb(name, value, hours) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + value + expires + "; path=/";
}


function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}


function eraseCookie(name) { createCookie(name, "", -1); }

function listCookies() {
    var theCookies = document.cookie.indexOf('compare').split(';');
    var aString = '';
    for (var i = 1; i <= theCookies.length; i++) {
        aString += i + ' ' + theCookies[i - 1] + "\n";
    }
    return aString;
}


$(".ageChose").click(function(){
    var age = $(this).attr('data-age');
    if(age == 'under18') {
        alert('Sorry! You must be 18 to visit this website.');
    } else {
        createCookie('your_age',age, 12);
        $('.overlay').fadeOut(300);
        $('.age_rest').fadeOut(300);
    }
});

if (document.cookie.indexOf('your_age') >= 0) {
    $('.overlay').hide();
    $('.age_rest').hide();
} else {
    $('.overlay').fadeIn(100);
    $('.age_rest').fadeIn(100);
}
