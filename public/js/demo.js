$(document).ready(function(){
    //Welcome Message (not for login page)
    function notify(message, type){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated bounceOut'
            },
            offset: {
                x: 20,
                y: 85
            }
        });
    };
    
    if (!$('.login-content')[0]) {
        // notify('Welcome back Mallinda Hollaway', 'danger');
    } 
    window.notify = notify;

    if($(window).width() < 700){
        $('#sidebar a').on('click', function(){
            $('#sidebar').toggleClass('toggled');
        });
        console.log($(window).height());
    }

    $('#sidebar').css({'height' : $(window).height()-65+'px'});
});