<?php
require('fpdf/fpdf.php');
require_once('functions.php');
require_once('ttFunctions.php');

class PDF extends FPDF
{

    // Page header
    function Header()
    {
        $sem = checksem() == 1 ? "January-June" : "July-Decemebr";
        // Logo
        $this->Image('logo.png', 120, 15, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Ln(30);
        $this->Cell(250, 10, $sem . ' Master Teaching Timetable', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 12);
$days = mysqli_query($conn, "SELECT * FROM week_days") or die(mysqli_error($conn));
$rooms = mysqli_query($conn, "SELECT * FROM rooms") or die(mysqli_error($conn));
while ($day = mysqli_fetch_assoc($days)) {
    $dayid = $day['id'];
    $pdf->Cell(20, 10, 'DAY', 1, 0, 'C');
    $pdf->Cell(20, 10, 'ROOM', 1, 0, 'C');
    $pdf->Cell(35, 10, '8:00-9:30am', 1, 0, 'C');
    $pdf->Cell(35, 10, '9:30-11:00am', 1, 0, 'C');
    $pdf->Cell(35, 10, '11:00-12:30pm', 1, 0, 'C');
    $pdf->Cell(35, 10, '12:30-2:00pm', 1, 0, 'C');
    $pdf->Cell(35, 10, '2:00-3:30pm', 1, 0, 'C');
    $pdf->Cell(35, 10, '3:30-5:00pm', 1, 1, 'C');
    $pdf->SetFont('Times', '', 12);
    mysqli_data_seek($rooms, 0);
    $i = 1;
    //$x = 12;
//$xadd = $x + $xadd;

    while ($room_rows = mysqli_fetch_assoc($rooms)) {
        $currentRoom = $room_rows['room'];
        $currentRoomID = $room_rows['id'];
        if ($i % 2 == 0)
            $pdf->setFillColor(232, 232, 232);
        else

            $pdf->setFillColor(255, 255, 255);
        $pdf->Cell(20, 6, $day['day'], 1, 0, 'C');
        $pdf->Cell(20, 6, $currentRoom, 1, 0, 'C');
        $schedule = mysqli_query($conn, "SELECT * FROM schedule WHERE roomid='$currentRoomID' AND dayid='$dayid' ORDER BY timeslot ASC") or die(mysqli_error($conn));
        $x = 15;

        while ($schedule_row = mysqli_fetch_assoc($schedule)) {
            $data = $schedule_row['allocatedcourse'];
            $lectl = $schedule_row['lecturerlname'];
            $lectf = $schedule_row['lecturerfname'];
            if ($data == null) {
                $pdf->Cell(35, 60, '-', 1, 0, 'C');

            } else {
                $pdf->Cell(35, 20, $data, 1, 0, 'C');
            }

        }
        $pdf->Ln();
        $i++;
    }
}
$pdf->Output();
?>