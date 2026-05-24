<?php
require_once __DIR__ . '/../lib/fpdf186/fpdf.php';

class PDFService {
    
    public function downloadBooking($booking) {

        // Evita cualquier salida previa (MUY IMPORTANTE)
        if (ob_get_length()) {
            ob_end_clean();
        }

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Reserva Hotel Four Seasons');

        // =========================
        // ENCABEZADO
        // =========================
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'HOTEL FOUR SEASONS', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Boleta de Confirmacion de Reserva', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->Cell(0, 0, '', 'B', 1);
        $pdf->Ln(8);

        // =========================
        // DATOS
        // =========================
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'DETALLES DE LA RESERVA', 0, 1);

        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(60, 8, 'Codigo de Reserva:', 0);
        $pdf->Cell(0, 8, $booking['Reserva'] ?? '', 0, 1);

        $pdf->Cell(60, 8, 'Categoria:', 0);
        $pdf->Cell(0, 8, $booking['Categoria_de_habitacion'] ?? '', 0, 1);

        $pdf->Cell(60, 8, 'Habitacion:', 0);
        $pdf->Cell(0, 8, $booking['Numero_de_habitacion'] ?? '', 0, 1);

        $pdf->Cell(60, 8, 'Estado:', 0);
        $pdf->Cell(0, 8, $booking['Estado_de_reserva'] ?? '', 0, 1);

        // =========================
        // FECHAS
        // =========================
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'FECHAS DE ESTADIA', 0, 1);

        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(60, 8, 'Fecha de inicio:', 0);
        $pdf->Cell(0, 8, $booking['Fecha_de_inicio'] ?? '', 0, 1);

        $pdf->Cell(60, 8, 'Fecha de salida:', 0);
        $pdf->Cell(0, 8, $booking['Fecha_de_final'] ?? '', 0, 1);

        // =========================
        // HUESPEDES
        // =========================
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'HUESPEDES', 0, 1);

        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(60, 8, 'Cantidad de huespedes:', 0);
        $pdf->Cell(0, 8, $booking['Numero_de_huespedes'] ?? '', 0, 1);

        // =========================
        // PAGO
        // =========================
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'PAGO', 0, 1);

        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(60, 8, 'Metodo de pago:', 0);
        $pdf->Cell(0, 8, $booking['Metodo_de_pago'] ?? '', 0, 1);

        $pdf->Cell(60, 8, 'Total a pagar:', 0);
        $pdf->Cell(0, 8, '$ ' . number_format($booking['Total_a_pagar'] ?? 0, 0, ',', '.'), 0, 1);

        // =========================
        // SALIDA (DESCARGA)
        // =========================
        $pdf->Output('D', 'reserva.pdf');
        exit;
    }
}