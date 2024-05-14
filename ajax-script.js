$(document).on('click','#showData',function(e){
    $.ajax({
        type: "GET",
        url: "data.php",
        dataType: "html",
        success: function (data) {
            $("#data").html(data);

        }
    });
});