<?php
include 'config/init.php';
// include 'helpers/system_helper.php';

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
            <option value="' . $tijd->tijden . '">' . $tijd->tijden . '</option>';
        }
        echo $output;
    }
}