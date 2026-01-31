<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// login check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// database connection
require_once "../database/db.php";
require_once "fpdf/fpdf.php";
$userId = $_SESSION['user_id'];

// latest admission record for this user
$query = "
SELECT *
FROM admissions
WHERE user_id = '$userId'
ORDER BY id DESC
LIMIT 1
";

$result = mysqli_query($conn, $query);
$admission = mysqli_fetch_assoc($result);

// abhi sirf test output
if (!$admission) {
    echo "No admission data found.";
    exit();
}

// // next step me yahin se PDF generate hoga
// echo "PDF generation will be done here.";


$pdf = new FPDF();
$pdf->AddPage();

// Title
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Admission Receipt',0,1,'C');
$pdf->Ln(5);

// Student Info
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Name: ' .
    $admission['first_name'].' '.
    $admission['middle_name'].' '.
    $admission['last_name'],0,1);

$pdf->MultiCell(0,8,'Address: '.$admission['address']);
$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'S.No',1);
$pdf->Cell(120,8,'Description',1);
$pdf->Cell(40,8,'Amount (Rs)',1,1,'R');

// Table Data
$i = 1;

$pdf->SetFont('Arial','',12);

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'Admission Fee',1);
$pdf->Cell(40,8,$admission['admission_fee'],1,1,'R');

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'Coaching Fee',1);
$pdf->Cell(40,8,$admission['coaching_fee'],1,1,'R');

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'Total Fee',1);
$pdf->Cell(40,8,$admission['total_fee'],1,1,'R');

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'SGST (9%)',1);
$pdf->Cell(40,8,$admission['sgst'],1,1,'R');

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'CGST (9%)',1);
$pdf->Cell(40,8,$admission['cgst'],1,1,'R');

$pdf->Cell(20,8,$i++,1);
$pdf->Cell(120,8,'IGST (18%)',1);
$pdf->Cell(40,8,$admission['igst'],1,1,'R');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'',1);
$pdf->Cell(120,8,'Grand Total',1);
$pdf->Cell(40,8,$admission['grand_total'],1,1,'R');

// Output PDF
$pdf->Output('D','Admission_Receipt.pdf');
exit();

