// Empty JS for your own code to be here
var  $ = jQuery;

function admin_validateEmail(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}jQuery/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
};

var sidebar_menu = getCookie( 'sidebar_menu' );
if( sidebar_menu === 'show' ){        
    $('body').removeClass('sidebar-collapse');    
} else if( sidebar_menu === 'hide' ){
    $('body').addClass('sidebar-collapse');    
} else {
    setCookie('sidebar_menu', 'show', 1);    
}

$('.sidebar-toggle').click(function(){
    var sidebar_menu = getCookie('sidebar_menu');
    //alert( sidebar_menu );
    if( sidebar_menu === 'show' ){
        setCookie('sidebar_menu', 'hide', 1);        
    } else {    
        setCookie('sidebar_menu', 'show', 1);        
    }    
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}


function DigitOnly(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode !== 8 && unicode !== 9){
        if (unicode < 46 || unicode > 57 || unicode === 47) //If not a number or decimal point
            return false; //Disable key press
    }
}

function photoPreview(input, target) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(target + ' img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
    $(target).show();
}

$(document).ready(function() {
    $('.select2').select2();
});


$(document).ready(function () {
    $(".js_datepicker").keydown(function(event) {
        return false;
    });
});

$(document).ready(function () {
    $('.js_datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
        
    $('.js_datepicker_limit').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        startDate: "+0d",                
        endDate: "+90d"
    }); 
});

$(document).ready(function () {
    $('.icheckbox').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    $('.icheck-radio').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
});