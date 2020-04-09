$(document).ready(function () {


    $(".af-knop").click(function () {
        timeslot = $(this).attr('data-timeslot');
        $("#tijd").val(timeslot);
    });

    //stuur geselecteerde soort service om de juiste services daarvan te krijgen
    $("#soort_service").change(function () {
        soort_service = $(this).val();

        $.ajax({
            url: "request.php",
            method: "POST",
            data: { soort_service: soort_service },
            success: function (response) {
                $("#service").html(response);

            }
        });

    });
    $(".no").click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Dit uur is al iemand ingepland',
            text: 'Probeer een ander uur',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
    // //stuur afspraak form data naar php
    $("#submit_afspraak").click(function (e) {
        if ($("#afspraak_form")[0].checkValidity()) {
            e.preventDefault();
            console.log($("#afspraak_form").serialize());

            $.ajax({
                url: "mail.php",
                method: 'POST',
                data: $("#afspraak_form").serialize() + "&action=afspraakInfo",
                success: function (response) {
                    console.log(response);

                    if (response == 'success') {
                        Swal.fire({
                            title: 'Gelukt!',
                            text: 'Uw afspraak is verzonden u krijgt binnenkort een bevestiging per mail',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $("#afspraak_form")[0].reset();
                        $("#myModal").modal("hide");
                    } else {
                        Swal.fire({
                            title: 'Er is iets misgegaan!',
                            text: 'Probeer het opnieuw',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }



                }
            });

        }
    });




});