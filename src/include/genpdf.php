<?php
use dompdf\Dompdf;
use dompdf\Options;
require_once 'include/dompdf/autoload.inc.php';
$dompdf = new Dompdf();
$dompdf-> loadHtml('Brouette');

$option = new Option();

$dompdf->setPaper('A4', 'portait');

$dompdf->render();

$dompdf->stream();
?>