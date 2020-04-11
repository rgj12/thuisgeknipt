<?php
include 'config/config.php';
include 'lib/Database.php';
include 'lib/Afspraak.php';

$afspraak = new Afspraak;

if (isset($_POST['datum'])) {
    $datum = $_POST['datum'];
    $tijden = $afspraak->getTijden();

    foreach ($tijden as $tijd) {
        $tijdCheck = $afspraak->checkIfTimeIsTaken($datum, $tijd->tijden);
        $output = '';
        if ($tijdCheck > 0) {
            $output .= '<option  value="" selected hidden>Selecteer tijd</option>
            <option class="notAvailable" disabled value="' . $tijd->tijden . '">' . $tijd->tijden . '</option>';
        } else {
            $output .= '<option  value="" selected hidden>Selecteer tijd</option>
            <option class="available" value="' . $tijd->tijden . '">' . $tijd->tijden . '</option>';
        }
        echo $output;
    }
}

if (isset($_POST['soort_service'])) {
    $soort_service = $_POST['soort_service'];
    $services = $afspraak->getServices($soort_service);
    $output = '';

    foreach ($services as $service) {
        $output .=   '<option  value="" selected hidden>Selecteer service</option>
        <option value="' . $service->naam . '">' . $service->naam . '  €<sup>' . $service->prijs . '</sup>,- p.p</option>';
    }

    echo $output;
}