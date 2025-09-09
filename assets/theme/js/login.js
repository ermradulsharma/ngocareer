$('#candidatesignin').on('click', function(e){
    e.preventDefault();    
    var credential = $('#credential').serialize();
    $.ajax({
        url: 'auth_candidate/web_login',
        type: "POST",
        dataType: "json",
        cache: false,
        data: credential,
        beforeSend: function(){
            $('#respond').html('<p class="ajax_processing">Please Wait... Checking....</p>');
        },
        success: function( jsonData ){
            console.log(jsonData);
            $('#respond').html( jsonData.Msg );
            if(jsonData.Status === 'OK'){
                console.log("Redirect to MyAccount");
                location.href = "myaccount";
                return false;
            }                                   
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            $('#respond').html( '<p> XML: '+ XMLHttpRequest + '</p>' );
            $('#respond').append( '<p>  Status: '+textStatus + '</p>' );
            $('#respond').append( '<p> Error: '+ errorThrown + '</p>' );            
        }  
    });        
});

$('#employersignin').on('click', function (e) {
    e.preventDefault();
    var credential = $('#credential').serialize();
    var error = 0;

    var username = jQuery('#username').val();
    if (!username) {
        jQuery('#username').addClass('required');
        error = 1;
    } else {
        jQuery('#username').removeClass('required');
    }

    var password = jQuery('#password').val();
    if (!password) {
        jQuery('#password').addClass('required');
        error = 1;
    } else {
        jQuery('#password').removeClass('required');
    }

    if (!error) {
        $.ajax({
            url: 'auth/login',
            type: "POST",
            dataType: "json",
            cache: false,
            data: credential,
            beforeSend: function () {
                $('#respond').html('<p class="ajax_processing">Please Wait... Checking....</p>');
            },
            success: function (jsonData) {
                if (jsonData.Status === 'OK') {
                    $('#respond').html(jsonData.Msg);
                    window.location.href = 'admin';
                    return false;
                } else {
                    $('#respond').html(jsonData.Msg);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#respond').html('<p> XML: ' + XMLHttpRequest + '</p>');
                $('#respond').append('<p>  Status: ' + textStatus + '</p>');
                $('#respond').append('<p> Error: ' + errorThrown + '</p>');
            }
        });
    }
});

$('#employer_forgot_pass').on('click', function (e) {
    e.preventDefault();
    var forgot_mail = $('#forgot_mail').val();
    $.ajax({
        url: 'auth/forgot_pass',
        type: "POST",
        dataType: "json",
        cache: false,
        data: {forgot_mail: forgot_mail},
        beforeSend: function () {
            $('#respond_pwd').html('<p class="ajax_processing">Please Wait... Checking....</p>');
        },
        success: function (jsonData) {
            if (jsonData.Status === 'OK') {
                $('#respond_pwd').html(jsonData.Msg);
            } else {
                $('#respond_pwd').html(jsonData.Msg);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#respond_pwd').html('<p> XML: ' + XMLHttpRequest + '</p>');
            $('#respond_pwd').append('<p>  Status: ' + textStatus + '</p>');
            $('#respond_pwd').append('<p> Error: ' + errorThrown + '</p>');
        }
    });

});

$('.js_forgot').on('click', function(){
    $('.js_login').slideUp('slow');
    $('.js_forget_password').slideDown('slow');
});

$('.js_back_login').on('click', function(){
    $('.js_forget_password').slideUp('slow');
    $('.js_login').slideDown('slow');
});

$('#candidate_forgot_pass').click(function(){
    var formData = $('#forgotForm').serialize();    
    $.ajax({
        url: 'auth_candidate/forgot_pass',
        type: "POST",
        dataType: 'json',
        data: formData,
        beforeSend: function () {
            $('.formresponse')
                    .html('<p class="ajax_processing">Checking user...</p>')
                    .css('display','block');
        },
        success: function ( jsonRespond ) {
            if( jsonRespond.Status === 'OK'){
                $('.formresponse').html( jsonRespond.Msg );                
            } else {
                $('.formresponse').html( jsonRespond.Msg );
            }                
        }
    });
    return false;
});