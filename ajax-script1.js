$(document).on('click','#showvisits',function(e){
    $.ajax({
        type: "GET",
        url: "datavisits.php",
        dataType: "html",
        success: function (data1) {
            $("#data1").html(data1);

        }
    });
});