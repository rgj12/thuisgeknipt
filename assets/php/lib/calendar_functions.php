<?php
function build_calendar($month, $year)
{
    $mysqli = new mysqli("localhost", "root", "", "thuisgeknipt_website");
    $daysOfWeek = array('Zo', ' Ma', ' Din', ' Woe', ' Don ', ' Vrij', ' Zat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberOfDays = date('t', $firstDayOfMonth);

    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $dateToday = date('Y-m-d');

    //creeer HTML tabel
    $calender = '<table class="table table-bordered">';
    $calender .= '<center><h2>' . $monthName . ' ' . $year . '</h2>';
    $calender .= '<a href="?month=' . date("m", mktime(0, 0, 0, $month - 1, 1, $year)) . '&year=' . date("Y", mktime(0, 0, 0, $month - 1, 1, $year)) . '" class="btn btn-xs btn-primary mb-2 mr-2">Vorige maand</a>';
    $calender .= '<a href="?month=' . date("m") . '&year=' . date("Y") . '" class="btn btn-xs btn-primary mb-2 mr-2">Deze maand</a>';
    $calender .= '<a href="?month=' . date("m", mktime(0, 0, 0, $month + 1, 1, $year)) . '&year=' . date("Y", mktime(0, 0, 0, $month + 1, 1, $year)) . '" class="btn btn-xs btn-primary mb-2 bt">Volgende maand</a></center><br>';
    $calender .= '<tr>';

    //calendar header
    foreach ($daysOfWeek as $day) {
        $calender .= '<th class="header">' . $day . '</th>';
    }
    $calender .= '</tr><tr>';

    //dit zorgt ervoor dat er altijd 7 kolommmen in tabel zijn
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calender .= '<td></td>';
        }
    }

    //day counter
    $currentDay = 1;

    //krijg maand nummer
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberOfDays) {
        //als de 7e dag is beriekt start nieuwe row
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calender .= '</tr><tr>';
        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = $year . "-" . $month . "-" . $currentDayRel;

        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? 'today' : '';

        if ($date < date('Y-m-d')) {
            $calender .= '<td><h4>' . $currentDay . '</h4><button class="btn btn-danger btn-sm">x</button>';
        } else {
            $totalbookings = checkSlots($mysqli, $date);
            if ($totalbookings == 14) {
                $calender .= '<td class="' . $today . '"><h4>' . $currentDay . '</h4><a href="#" class="btn btn-danger btn-sm">Vol</a>';
            } else {
                $calender .= '<td class="' . $today . '"><h4>' . $currentDay . '</h4><a href="book.php?date=' . $date . '" class="btn btn-success btn-sm">+</a>';
            }
        }
        // if ($dateToday == $date) {
        //     $calender .= '<td class="today"><h4>' . $currentDay . '</h4>';
        // } else {
        //     $calender .= '<td><h4>' . $currentDay . '</h4>';
        // }
        $calender .= '</td>';

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek < 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calender .= '<td class="empty"></td>';
        }
    }

    $calender .= '</tr>';
    $calender .= '</table>';

    echo $calender;
}
$duration = 30;
$cleanup = 0;
$start = "10:00";
$end = "17:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:i") . "-" . $endPeriod->format("H:i");
    }

    return $slots;
}

function checkSlots($mysqli, $date)
{
    $stmt = $mysqli->prepare("SELECT * FROM bevestigde_afspraken WHERE datum=?");
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalbookings++;
            }
            $stmt->close();
        }
    }
    return $totalbookings;
}