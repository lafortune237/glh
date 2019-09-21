$( document ).ready(function() {

    toastr.options = {
        'positionClass':'toast-top-center',
        'closeButton': true,
        'timeOut ' : 10000,
    };
    var message_handler = $('#message_handler');

    if(message_handler && message_handler.val().length > 0){

        if(message_handler.attr("data-type") === 'error'){


            toastr.error(message_handler.val());

        }

        if(message_handler.attr("data-type") === 'info'){

            toastr.info(message_handler.val());

        }

        if(message_handler.attr("data-type") === 'success'){

            toastr.success(message_handler.val());

        }

    }
});

