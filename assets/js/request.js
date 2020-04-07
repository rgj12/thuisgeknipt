$(document).ready(function () {
    $("#datum").change(function () {
        datum = $(this).val();

        $.ajax({
            url: "assets/php/request.php",
            method: "POST",
            data: { datum: datum },
            success: function (response) {
                console.log(response);
                $("#tijd").html(response);
            }
        });

    });


});