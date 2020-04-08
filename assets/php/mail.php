<?php
if (isset($_POST['action']) && $_POST['action'] == 'afspraakInfo') {
    require 'lib/phpmailer/PHPMailerAutoload.php';
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $telefoon = $_POST['telefoonnummer'];
    $opmerking = $_POST['opmerking'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $aantal_personen = $_POST['aantal_personen'];
    $soort_service = $_POST['soort_service'];
    $service = $_POST['service'];
    if (!empty($naam) || !empty($email) || !empty($telefoon) || !empty($datum) || !empty($tijd) || !empty($aantal_personen) || !empty($soort_service) || !empty($service)) {
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
        $mail->addAddress('renatogomes600@gmail.com');
        $mail->addReplyTo('thuisgekniptrotterdam@gmail.com');
        //inhoud van mail
        $mail->isHTML(true);
        $mail->Subject = 'Een klant heeft een afspraak gemaakt';
        $mail->Body = '<h2>Hallo Joel,</h2><br>
    <p>De volgende klant heeft een afspraak gemaakt en wacht op bevestiging:</p><br>
    <p>Naam : <b>' . $naam . '</b></p><br>
   <p>datum : <b>' . date_format(new datetime($datum), 'd-m-Y') . '</b></p><br>
   <p>Tijd : <b>' . $tijd . '</b></p><br>
   <p>aantal personen : <b>' . $aantal_personen . '</b></p><br>
   <p>Service : <b>' . $service . '</b></p><br>
   <p>Soort service : <b>' . $soort_service . '</b></p><br>
    <p>Email : <b>' . $email . '</b></p><br>
    <p>Telefoon : <b>' . $telefoon . '</b></p><br>
    <a href="#">Klik hier om de afspraak te bevestigen</a>
    ';
        $message = '';
        if (!$mail->send()) {
            $message .= 'fail';
        } else {
            $message .= 'success';
        }

        echo $message;
    }
}