$(function(){
    $('#error-message').hide()
    $('#info-message').hide()
    $('.post').click(function () {

        var send  = ($(this).attr('send'))
        var go    = ($(this).attr('go'))
        var error = ($(this).attr('error'))
        var info  = ($(this).attr('info'))

        $('#info-message').html(info).show()

        $.ajax(
            {
                type: "get",
                url:  send,
                data: '',
                success: function (data)
                {
                    location.href = go
                },error: function (e) {
                    $('#info-message').hide()
                    $('#error-message').html(error).show()
                }
            }
        );
    });

})