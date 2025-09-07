<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../controllers/ChamadoController.php";
require_once "../../Vendor/fpdf/fpdf.php"; // FPDF padrão

$controller = new ChamadoController();

// Se tiver filtro de usuário
$filtroUsuario = $_GET['usuario_id'] ?? $_SESSION['usuario_id'];

// Aqui você pode adaptar o index() para receber um filtro
$chamados = $controller->index();

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Cabeçalho do relatório
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Relatorio de Chamados', 0, 1, 'C');
$pdf->Ln(5);

// Cabeçalho da tabela
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(70, 130, 180); // azul marinho
$pdf->SetTextColor(255, 255, 255);

$header = [
    'ID' => 10,
    'Cliente' => 30,
    'Usuário' => 30,
    'Tipo' => 30,
    'Assunto' => 40,
    'Situação' => 25,
    'Data Inicial' => 25,
    'Hora Inicial' => 20,
    'Data Final' => 25,
    'Hora Final' => 20
];

foreach ($header as $col => $width) {
    $pdf->Cell($width, 7, utf8_decode($col), 1, 0, 'C', true);
}
$pdf->Ln();

// Conteúdo
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$tituloDescricao = "Descrição";

while ($row = $chamados->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10, 6, $row['id'], 1, 0, 'C');
    $pdf->Cell(30, 6, utf8_decode($row['cliente_nome']), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode($row['usuario_nome']), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode($row['tipo']), 1, 0, 'L');
    $pdf->Cell(40, 6, utf8_decode($row['assunto']), 1, 0, 'L');
    $pdf->Cell(25, 6, utf8_decode($row['situacao']), 1, 0, 'C');
    $pdf->Cell(25, 6, $row['data_inicial'] ? date('d/m/Y', strtotime($row['data_inicial'])) : '', 1, 0, 'C');
    $pdf->Cell(20, 6, $row['hora_inicial'], 1, 0, 'C');
    $pdf->Cell(25, 6, $row['data_final'] ? date('d/m/Y', strtotime($row['data_final'])) : '', 1, 0, 'C');
    $pdf->Cell(20, 6, $row['hora_final'], 1, 0, 'C');
    $pdf->Ln();

    // Descrição em linha separada, ocupa toda largura da tabela
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(array_sum($header), 6, utf8_decode($tituloDescricao), 1, 1, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(array_sum($header), 5, utf8_decode($row['descricao']), 1);
    $pdf->Ln(1);
}

$pdf->Output('I', 'Relatorio_Chamados.pdf');
