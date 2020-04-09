<?php
include 'lib/calendar_functions.php';
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $mysqli = new mysqli("localhost", "root", "", "thuisgeknipt_website");
    $stmt = $mysqli->prepare("SELECT * FROM bevestigde_afspraken WHERE datum=?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['tijd'];
            }
            $stmt->close();
        }
    }
}
// $bookings[] = $timeslot;
?>
<!doctype html>
<html lang="en">

<head>
    <title>book</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/calendar.css">
</head>

<body>
    <div class="container">
        <h6 class="text-center">Maak afspraak voor datum: <?= date('F d,Y', strtotime($date)); ?></h6>
        <hr>
        <div class="row">
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $ts) {
            ?>

            <div class="btn-group mb-2 mr-2 ml-2">
                <?php if (in_array($ts, $bookings)) { ?>
                <button class="btn btn-danger no" data-timeslot="<?= $ts; ?>"><?= $ts; ?></button>
                <?php } else { ?>
                <button class="btn btn-success af-knop" data-toggle="modal" data-target="#myModal-modal-sm"
                    data-timeslot="<?= $ts; ?>"><?= $ts; ?></button>
                <?php } ?>
            </div>

            <?php } ?>

        </div>
        <div class="text-center">
            <a href="calendar.php">terug</a>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal" id="myModal-modal-sm">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Maak afspraak</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="#" method="post" id="afspraak_form" autocomplete="off">
                        <div class="form-group">
                            <label for="datum">Datum *</label>
                            <input type="date" class="form-control" name="datum" id="datum"
                                placeholder="selecteer datum" required readonly value="<?= $date; ?>">
                        </div>

                        <div class="form-group">
                            <label for="tijd">Tijd *</label>
                            <input type="text" name="tijd" id="tijd" class="form-control" required readonly>

                        </div>

                        <div class="form-group">
                            <label for="aantal_personen">Aantal personen *</label>
                            <input type="number" class="form-control" name="aantal_personen" id="aantal_personen"
                                min="1" placeholder="aantal personen">
                        </div>
                        <div class="form-group">
                            <label for="soort_service">Kies uw gewenste locatie*</label>
                            <select name="soort_service" id="soort_service" class="form-control" required>
                                <option value="" selected hidden>Selecteer locatie</option>
                                <option value="op locatie zuidplein">Op locatie zuidplein</option>
                                <option value="huis-aan-huis">Huis aan huis service Rotterdam</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="service">Kies waar u voor komt *</label>
                            <select name="service" id="service" class="form-control" required>
                                <option value="" selected hidden>Selecteer soort service eerst</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="naam">Naam *</label>
                            <input type="text" class="form-control" name="naam" id="naam" placeholder="naam" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="email"
                                aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="telefoonnummer">Telefoonnummer *</label>
                            <input type="text" class="form-control" name="telefoonnummer" id="telefoonnummer"
                                placeholder="telefoonnummer" maxlength="10" aria-describedby="telefoonnummerHelp"
                                onkeyup="return validatePhoneNumber(this.value);" required>
                        </div>

                        <div class="form-group">
                            <label for="opmerking">Opmerkingen</label>
                            <textarea name="opmerking" class="form-control" id="opmerking" cols="20"
                                rows="5"></textarea>
                        </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="submit" id="submit_afspraak"
                        value="Maak afspraak">
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script>
    //custom method zodat er alleen nummers ingevoerd worden in telefoonnummer veld
    function validatePhoneNumber(number) {
        //verwijder elke character die geen nummer is
        number = number.replace(/[^0-9]/g, '');
        $("#telefoonnummer").val(number);

        //als de input niet 10 characters is maak input veld rood anders groen
        if (!number.match(/^0[0-9]{9}$/)) {
            $("#telefoonnummer").css({
                'background': '#FFEDEF',
                'border': 'solid 1px red'
            });
            return false;
        } else {
            $("#telefoonnummer").css({
                'background': '#99FF99',
                'border': 'solid 1px green'
            });
            return true;
        }
    }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/request_book.js"></script>
    <script src="../js/validate.js"></script>
</body>

</html>