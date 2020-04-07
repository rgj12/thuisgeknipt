$(function () {
    afspraakform = $("#afspraak_form");
    //custom method zodat er geen spaties ingevoerd worden
    $.validator.addMethod("noSpace", function (value, element) {
        return value == '' || value.trim().length != 0
    }, "Geen spaties");

    //validate input met jquery validate library
    if (afspraakform.length) {
        //zet error message waar label for='' staat
        afspraakform.validate({
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                $(element.form).find("label[for=" + element.id + "]")
                    .addClass(errorClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
                $(element.form).find("label[for=" + element.id + "]")
                    .removeClass(errorClass);
            },
            //zet de regels voor wat er ingevoer moet worden
            rules: {
                naam: {
                    required: true,
                    noSpace: true,

                },
                email: {
                    required: true,
                    email: true,
                    noSpace: true
                },
                datum: {
                    required: true
                },
                tijd: {
                    required: true

                },
                telefoonnummer: {
                    required: true,
                    noSpace: true,
                    minlength: 10
                },
                aantal_personen: {
                    required: true,
                    max: 5,
                    min: 1
                },
                service: {
                    required: true
                },
                opmerking: {
                    noSpace: true
                },
                soort_service: {
                    required: true
                }
            },
            //bepaal welke error messages bij welke errors horen
            messages: {
                naam: {
                    required: 'Naam is verplicht!'
                },
                email: {
                    required: 'Email is verplicht!',
                    email: 'Vul een geldige email in!'
                },
                datum: {
                    required: 'Voer een datum in zodat we weten wanneer u langskomt!'

                },
                tijd: {
                    required: 'Selecteer een tijd'
                },
                telefoonnummer: {
                    required: 'telefoonnummer is verplicht!'
                },
                aantal_personen: {
                    required: 'aantal personen is verplicht!',
                    min: 'Minimaal 1 persoon',
                    max: 'Mag max 5 personen meenemen'
                },
                service: {
                    required: ' Selecteer waar u voor komt!'
                },
                soort_service: {
                    required: 'Kies uw gewenste locatie'
                }
            }
        });
    }

});
