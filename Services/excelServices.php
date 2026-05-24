<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelService {
    public function downloadBookings($user, $bookings) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REPORTE DE RESERVAS');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', 'Usuario: ' . $user['name'] . ' ' . $user['last_name']);
        $sheet->setCellValue('A3', 'Email: ' . $user['email']);
        $sheet->setCellValue('A4', 'ID Usuario: ' . $user['id']);

        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');

        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '111111']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        $sheet->getStyle('A2:A4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '333333']
            ]
        ]);

        $headers = [
            'A5' => 'ID',
            'B5' => 'Habitación',
            'C5' => 'Fecha inicio',
            'D5' => 'Fecha fin',
            'E5' => 'Visitantes',
            'F5' => 'Estado',
            'G5' => 'Total a pagar'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        $sheet->getStyle('A5:G5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F1F1F']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        for ($i = 0; $i < count($bookings); $i++) {

            $row = $i + 6;

            $sheet->setCellValue("A{$row}", $bookings[$i]['id']);
            $sheet->setCellValue("B{$row}", $bookings[$i]['Numero_de_habitacion']);
            $sheet->setCellValue("C{$row}", date('d/m/Y', strtotime($bookings[$i]['Fecha_de_empiezo'])));
            $sheet->setCellValue("D{$row}", date('d/m/Y', strtotime($bookings[$i]['Fecha_de_final'])));
            $sheet->setCellValue("E{$row}", $bookings[$i]['Total_de_visitantes']);
            $sheet->setCellValue("F{$row}", $bookings[$i]['Estado_de_reserva']);
            $sheet->setCellValue("G{$row}", $bookings[$i]['Total_a_pagar']);

            $color = ($i % 2 == 0) ? 'F2F2F2' : 'FFFFFF';

            $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color]
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);

            $sheet->getStyle("G{$row}")
                ->getNumberFormat()
                ->setFormatCode('"$" #,##0');
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_reservas.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}