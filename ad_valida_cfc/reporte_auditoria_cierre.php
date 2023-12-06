<?php
include('inc/conexion.php');
require_once 'PHPExcel/Classes/PHPExcel.php';

try {
    if (isset($_POST['busca'])) {
        $busca = $_POST['busca'];

        // Crear un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Definir propiedades del documento
        $objPHPExcel->getProperties()
            ->setCreator("Tu Nombre")
            ->setTitle("Reporte de Auditoría")
            ->setDescription("Reporte en Excel");

        // Crear una nueva hoja de cálculo
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Agregar encabezados
        $sheet->setCellValue('A1', 'Periodo');
        $sheet->setCellValue('B1', 'Numero de Cierre');
        $sheet->setCellValue('C1', 'Cuit Farmacia');
        $sheet->setCellValue('D1', 'Farmacia');
        $sheet->setCellValue('E1', 'Recetas');
        $sheet->setCellValue('F1', 'Total Facturado');
        $sheet->setCellValue('G1', 'T/OS');
        $sheet->setCellValue('H1', 'Fecha de Cierre');

        // Consulta SQL para obtener los datos
        $query = "SELECT a.periodo, a.num_cierre, a.cuit_farm, a.cant_recetas, a.tf, a.tos, a.ano, a.mes, a.dia, a.hora, a.minuto, b.cuit, b.farmacia, b.idsucursal, b.id
                  FROM cierres_lotes a
                  LEFT JOIN users b ON a.cuit_farm = b.cuit AND a.suc_farm = b.idsucursal
                  WHERE a.periodo LIKE '%" . $busca . "%'";

        $busqueda = mysqli_query($conexion, $query);

        // Fila inicial para los datos
        $rowIndex = 2;

        while ($f = mysqli_fetch_array($busqueda)) {
            $sheet->setCellValue('A' . $rowIndex, $f['periodo']);
            $sheet->setCellValue('B' . $rowIndex, $f['num_cierre']);
            $sheet->setCellValue('C' . $rowIndex, $f['cuit_farm']);
            $sheet->setCellValue('D' . $rowIndex, $f['farmacia'] . "-" . $f['idsucursal']);
            $sheet->setCellValue('E' . $rowIndex, $f['cant_recetas']);
            $sheet->setCellValue('F' . $rowIndex, $f['tf']);
            $sheet->setCellValue('G' . $rowIndex, $f['tos']);
            $sheet->setCellValue('H' . $rowIndex, $f['dia'] . "/" . $f['mes'] . "/" . $f['ano']);
            $rowIndex++;
        }

        // Nombre del archivo Excel a generar
        $filename = "reporte_auditoria.xlsx";

        // Configurar cabeceras para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Crear el archivo Excel
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
} catch (Exception $e) {
    error_log("Error en exportar_excel.php: " . $e->getMessage());
    echo "Error al exportar a Excel. Por favor, contacta al administrador.";
}
?>
