$(document).on('click','#showcases',function(e){
    $.ajax({
        type: "GET",
        url: "datacases.php",
        dataType: "html",
        success: function (data2) {
            $("#data2").html(data2);

        }
    });
});