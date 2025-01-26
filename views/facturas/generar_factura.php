<?php
require_once __DIR__ . '/../../FPDF/fpdf.php';
require_once __DIR__ . '/../../config/db.php';

// Crear clase personalizada para la factura
class FacturaPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'FERREPIL - Factura de Venta', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Gracias por su compra - FERREPIL', 0, 0, 'C');
    }
}

// Validar parámetros
if (!isset($_GET['id']) || !isset($_GET['cantidad']) || !isset($_GET['nombre']) || !isset($_GET['nit'])) {
    die('Parámetros inválidos');
}

$ids = $_GET['id'];
$cantidades = $_GET['cantidad'];
$nombreCliente = htmlspecialchars($_GET['nombre']);
$nitCliente = htmlspecialchars($_GET['nit']);

if (!is_array($ids) || !is_array($cantidades)) {
    die('Datos inválidos');
}

// Crear PDF
$pdf = new FacturaPDF();
$pdf->AddPage();

// Información del cliente
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Cliente: ' . $nombreCliente, 0, 1, 'C');
$pdf->Cell(0, 10, 'NIT: ' . $nitCliente, 0, 1, 'C');
$pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
$pdf->Ln(10);

// Detalle de la factura
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(70, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'Precio Unit.', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total', 1, 1, 'C');

// Conexión con la base de datos
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");

$totalGeneral = 0;

foreach ($ids as $key => $id) {
    $cantidad = intval($cantidades[$key]);

    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $nombreProducto = $producto['nombre'];
        $precioUnitario = $producto['precio'];
        $total = $cantidad * $precioUnitario;
        $totalGeneral += $total;

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(70, 10, $nombreProducto, 1);
        $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($precioUnitario, 2), 1, 0, 'C');
        $pdf->Cell(40, 10, number_format($total, 2), 1, 1, 'C');
    }
}

$pdf->Ln(10);

// Total general
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(70, 10, '', 0, 0); // Espacio vacío para alinear el total
$pdf->Cell(30, 10, '', 0, 0);
$pdf->Cell(30, 10, 'TOTAL:', 0, 0, 'R');
$pdf->Cell(40, 10, number_format($totalGeneral, 2) . ' Bs', 0, 1, 'C');

// Salida del PDF
$pdf->Output('I', 'factura.pdf'); // Mostrar en el navegador
?>
