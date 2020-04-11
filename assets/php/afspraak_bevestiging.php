<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevestig afspraak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bevestig_afspraak.css">
</head>

<body>

    <div class="container">
        <?php
        if (isset($_GET['afspraak_datum'])) {
            $naam = $_GET['naam'];
            $datum = $_GET['afspraak_datum'];
            $tijd = $_GET['afspraak_tijd'];
            $aantal = $_GET['aantal'];
            $opmerking = $_GET['opmerking'];
            $service = $_GET['afspraak_service'];
            $email = $_GET['afspraak_email'];
            $tel = $_GET['tel'];
            $loc = $_GET['loc'];

        ?>
        <div class="Back">
            <i class="fa fa-arrow-left" onclick="Back()"></i>
        </div>
        <p class="h2 text-center">Bevestig afspraak voor : <?= $naam; ?></p>
        <form action="#" method="post">
            <input type="hidden" name="bevestig_email" value="<?= $email; ?>">
            <input type="hidden" name="bevestig_tel" value="<?= $tel; ?>">
            <div class="form-group">
                <label>Naam:</label>
                <input class="form-control" type="text" name="bevestig_naam" required value="<?= $naam; ?>" />
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <label>Datum:</label>
                <input class="form-control" type="date" name="bevestig_datum" required value="<?= $datum; ?>" />
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <label>Tijd:</label>
                <input class="form-control" type="text" name="bevestig_tijd" required value="<?= $tijd; ?>" />
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <label>Service:</label>
                <input class="form-control" type="text" name="bevestig_service" required value="<?= $service; ?>" />
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <label>Locatie:</label>
                <input class="form-control" type="text" name="loc" required value="<?= $loc; ?>" />
                <span class="Error"></span>
            </div>

            <div class="form-group">
                <label>Aantal personen:</label>
                <input class="form-control" type="text" name="aantal" required value="<?= $aantal; ?>" />
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <label>Opmerking:</label>
                <textarea class="form-control" type="text" name="opmerking" readonly><?= $opmerking; ?></textarea>
                <span class="Error"></span>
            </div>
            <div class="form-group">
                <input class="btn btn-primary btn-block" type="submit" name="bevestig_afspraak"
                    value="Bevestig afspraak" />
            </div>
        </form>
        <?php } ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>


</html>
<?php
include 'config/config.php';
include 'lib/Database.php';
include 'lib/Afspraak.php';


$afspraak = new Afspraak;
if (isset($_POST['bevestig_afspraak'])) {
    require 'lib/phpmailer/PHPMailerAutoload.php';
    $data = array();
    $data['naam'] = $_POST['bevestig_naam'];
    $data['datum'] = $_POST['bevestig_datum'];
    $data['tijd'] = $_POST['bevestig_tijd'];
    $data['email'] = $_POST['bevestig_email'];
    $data['aantal'] = $_POST['aantal'];
    $data['service'] = $_POST['bevestig_service'];
    $data['opmerk'] = $_POST['opmerking'];
    $data['tel'] = $_POST['bevestig_tel'];
    $data['loc'] = $_POST['loc'];

    if ($afspraak->bevestigAfspraak($data)) {
        //maak nieuwe instance aan van PHPmailer class
        $mail = new PHPMailer();
        //configuratie van de mail
        ## isSMTP() weghalen als website op liveserver komt, is alleen nodig voor lokaal testen
        $mail->isSMTP();
        ##Mailing werkt niet als isSmMTP function aan staat op liveserver
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        //login credentials
        $mail->Username = 'thuisgekniptrotterdam@gmail.com';
        $mail->Password = 'c332599i';
        //waar de mail naartoe gaat en van wie het komt
        $mail->setFrom('thuisgekniptrotterdam@gmail.com', 'thuisgeknipt');
        $mail->addAddress($data['email']);
        $mail->addReplyTo('thuisgekniptrotterdam@gmail.com');
        //inhoud van mail
        $mail->isHTML(true);
        $mail->Subject = 'Afspraak bevestiging';
        $mail->Body = '<p>Hallo ' . $data['naam'] . '</p><br>
    <p>Bij deze is uw afspraak bevestigt op:</p>
    <p><b>' . date_format(new datetime($data['datum']), 'd-m-Y') . '</b> van <b>' . $data['tijd'] . '</b>.</p>
    <p>Locatie: ' . $data['loc'] . ' </p>
    <p>Met vriendelijke groet,</p>
    <p>Thuisgeknipt</p>
    <p>0630947797</p>
    ';
        if (!$mail->send()) {
            echo '<script>alert("Er is iets misgegaan met mailing")</script>';
        } else {
            header("location:afspraak-beves.php?message=success");
        }
    }
}