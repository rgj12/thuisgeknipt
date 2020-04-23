$(document).ready(function () {
    //stuur geselecteerde datum naar request.php om te kijken of tijdstip al ingenomen is
    $("#datum").change(function () {
        datum = $(this).val();

        $.ajax({
            url: "assets/php/request.php",
            method: "POST",
            data: { datum: datum },
            success: function (response) {
                $("#tijd").html(response);
            }
        });

    });

    //stuur geselecteerde soort service om de juiste services daarvan te krijgen
    $("#soort_service").change(function () {
        soort_service = $(this).val();

        $.ajax({
            url: "assets/php/request.php",
            method: "POST",
            data: { soort_service: soort_service },
            success: function (response) {
                $("#service").html(response);

            }
        });

    });

    //stuur geselecteerde soort service om de juiste services daarvan te krijgen
    $("#service").change(function () {
        soort_service = $(this).children(":selected").attr("data-id");;
        $.ajax({
            url: "assets/php/request.php",
            method: "POST",
            data: {service_id: soort_service},
            success: function (response) {
                $("#price0").val(response);

            }
        });

    });

    // //stuur afspraak form data naar php
    $("#submit_afspraak").click(function (e) {
        if ($("#afspraak_form")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "assets/php/mail.php",
                method: 'POST',
                data: $("#afspraak_form").serialize() + "&action=afspraakInfo",
                success: function (response) {
                    if (response == 'success') {
                        Swal.fire({
                            title: 'Gelukt!',
                            text: 'Uw afspraak is verzonden u krijgt binnenkort een bevestiging per mail',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $("#confirm-afspraak").modal("hide");
                        $("#afspraak_form")[0].reset();
                    } else {
                        Swal.fire({
                            title: 'Er is iets misgegaan!',
                            text: 'Probeer het opnieuw',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }



                }
            });

        }
    });




});