<?php
    session_start();
    include '../config/connection.php';
    include '../vendor/autoload.php';

    $connect = new PDO("mysql:host=192.168.2.10;port=3306;dbname=iot", "root", "AdmRoot");

    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    $session_username = $_SESSION['username'];
    $kode_department = $_SESSION["kd_dept"];

    $get_idalat = $_GET["id"];
        
    $tanggal_awal_exp = $_POST['tgl_awal_exp'];
    $waktu_awal_exp = $_POST['wkt_awal_exp'];
    $tanggal_akhir_exp = $_POST['tgl_akhir_exp'];
    $waktu_akhir_exp = $_POST['wkt_akhir_exp'];
    $periode = $tanggal_awal_exp . ' ' . $waktu_awal_exp . '    s/d    ' . $tanggal_akhir_exp. ' ' . $waktu_akhir_exp;

    /* var_dump($periode);
    die(); */

    $result_parameter = mysqli_query(
        $conn, 
        "SELECT * FROM parameter where id=$get_idalat"
    );
    $row_parameter = mysqli_fetch_array($result_parameter);
    /* $min_suhu = (float)$row_parameter["min_suhu"];
    $max_suhu = (float)$row_parameter["max_suhu"];
    $min_lembab = (float)$row_parameter["min_kelembaban"];
    $max_lembab = (float)$row_parameter["max_kelembaban"]; */
    $idalat = $row_parameter["id_alat"];

    $query = "SELECT * FROM suhu_kelembaban 
                where id_alat='$idalat' 
                    AND substring(waktu,1,17) BETWEEN concat('$tanggal_awal_exp', concat(' ','$waktu_awal_exp')) and concat('$tanggal_akhir_exp', concat(' ','$waktu_akhir_exp'))
                ORDER BY id DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    /* var_dump($result);
    die(); */   

    $get_data = mysqli_query(
        $conn, 
        "SELECT * FROM suhu_kelembaban 
            where id_alat='$idalat' 
            ORDER BY id DESC LIMIT 1"
    ); 
    $data = mysqli_fetch_array($get_data);
    $lokasi = $data["ruang"];
    $no_alat = $data["id_alat"];

    $result_exp = mysqli_query(
        $conn, 
        "SELECT MIN(suhu), MAX(suhu), MIN(kelembaban), MAX(kelembaban), ROUND(AVG(suhu),2), ROUND(AVG(kelembaban),2) 
            FROM suhu_kelembaban
            WHERE  id_alat='$idalat'
            AND substring(waktu,1,17) BETWEEN concat('$tanggal_awal_exp', concat(' ','$waktu_awal_exp')) and concat('$tanggal_akhir_exp', concat(' ','$waktu_akhir_exp'))
        ");
    $row_exp = mysqli_fetch_array($result_exp);
    $suhu_min = $row_exp[0];
    $suhu_max = $row_exp[1];
    $suhu_avg = $row_exp[4];
    $kel_min = $row_exp[2];
    $kel_max = $row_exp[3];
    $kel_avg = $row_exp[5];
    
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            ],
        ],
    ];
    
    if (isset($_POST["download"])) {
        $file = new Spreadsheet();
        
        $active_sheet = $file->getActiveSheet();

        $active_sheet->getColumnDimension('B')->setWidth(21);
        $active_sheet->getColumnDimension('D')->setWidth(15);
        $active_sheet->getColumnDimension('F')->setWidth(18);
        $active_sheet->getColumnDimension('I')->setWidth(23);

        $active_sheet->mergeCells('A1:D1');
        $active_sheet->mergeCells('B2:D2');
        $active_sheet->mergeCells('B3:D3');
        $active_sheet->mergeCells('B4:D4');

        $active_sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $active_sheet->getStyle('A1:D1')->getFont()->setSize(16);

        /* $active_sheet->getStyle('A8')->getFont()->setBold(true);
        $active_sheet->getStyle('C8')->getFont()->setBold(true);
        $active_sheet->getStyle('A8:D8')->getFont()->setSize(12); */
        /* $active_sheet->getStyle('A12')->getFont()->setBold(true);
        $active_sheet->getStyle('C12')->getFont()->setBold(true);
        $active_sheet->getStyle('A12:D12')->getFont()->setSize(12); */

        $active_sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue('A1', 'Data Monitoring Suhu dan Kelembaban');
        
        $active_sheet->setCellValue('A2', 'Periode  :');
        $active_sheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue('B2', $periode);

        $active_sheet->setCellValue('A3', 'Lokasi  :');
        $active_sheet->getStyle('B3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue('B3', $lokasi);

        $active_sheet->setCellValue('A4', 'No. Alat  :');
        $active_sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue('B4', $no_alat);
        
        $active_sheet->mergeCells('A5:D5');
        $active_sheet->getStyle('A5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        $active_sheet->getStyle('A6:D8')->applyFromArray($styleArray);
        $active_sheet->mergeCells('A6:B6');
        $active_sheet->setCellValue('A6', 'Suhu Minimum :');
        $active_sheet->mergeCells('C6:D6');
        $active_sheet->setCellValue('C6', $suhu_min . ' °C');
        $active_sheet->mergeCells('A7:B7');
        $active_sheet->setCellValue('A7', 'Suhu Maximum :');
        $active_sheet->mergeCells('C7:D7');
        $active_sheet->setCellValue('C7', $suhu_max . ' °C');
        $active_sheet->mergeCells('A8:B8');
        $active_sheet->setCellValue('A8', 'Rata-rata Suhu :');
        $active_sheet->mergeCells('C8:D8');
        $active_sheet->setCellValue('C8', $suhu_avg . ' °C');

        $active_sheet->mergeCells('A9:D9');
        $active_sheet->getStyle('A9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        $active_sheet->getStyle('A10:D12')->applyFromArray($styleArray);
        $active_sheet->mergeCells('A10:B10');
        $active_sheet->setCellValue('A10', 'Kelembaban Minimum :');
        $active_sheet->mergeCells('C10:D10');
        $active_sheet->setCellValue('C10', $kel_min . ' %');
        $active_sheet->mergeCells('A11:B11');
        $active_sheet->setCellValue('A11', 'Kelembaban Maximum :');
        $active_sheet->mergeCells('C11:D11');
        $active_sheet->setCellValue('C11', $kel_max . ' %');
        $active_sheet->mergeCells('A12:B12');
        $active_sheet->setCellValue('A12', 'Rata-rata Kelembaban :');
        $active_sheet->mergeCells('C12:D12');
        $active_sheet->setCellValue('C12', $kel_avg . ' %');

        $active_sheet->mergeCells('A13:D13');
        $active_sheet->getStyle('A13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        
        $active_sheet->getStyle('A14:D18')->applyFromArray($styleArray);
        $active_sheet->mergeCells('A14:C14');
        $active_sheet->setCellValue('A14', 'Parameter Minimum Suhu :');
        // $active_sheet->mergeCells('C14:D14');
        $active_sheet->setCellValue('D14', $row_parameter["min_suhu"] . ' °C');
        $active_sheet->mergeCells('A15:C15');
        $active_sheet->setCellValue('A15', 'Parameter Maximum Suhu :');
        // $active_sheet->mergeCells('C15:D15');
        $active_sheet->setCellValue('D15', $row_parameter["max_suhu"] . ' °C');
        $active_sheet->mergeCells('A16:C16');
        $active_sheet->setCellValue('A16', 'Parameter Minimum Kelembaban :');
        // $active_sheet->mergeCells('C16:D16');
        $active_sheet->setCellValue('D16', $row_parameter["min_kelembaban"] . ' %');
        $active_sheet->mergeCells('A17:C17');
        $active_sheet->setCellValue('A17', 'Parameter Maximum Kelembaban :');
        // $active_sheet->mergeCells('C17:D17');
        $active_sheet->setCellValue('D17', $row_parameter["max_kelembaban"]. ' %');
        $active_sheet->mergeCells('A18:C18');
        $active_sheet->setCellValue('A18', 'Waktu Update Data :');
        // $active_sheet->mergeCells('C18:D18');
        $active_sheet->setCellValue('D18', $row_parameter["delay"] . ' menit'); 
                    
        $active_sheet->mergeCells('A19:D19');
        $active_sheet->getStyle('A19')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        $active_sheet->getStyle('A20:D20')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle('A20:D20')->getFont()->setBold(true);
        $active_sheet->getStyle('A20')->applyFromArray($styleArray);
        $active_sheet->setCellValue('A20', 'No.');
        $active_sheet->getStyle('B20')->applyFromArray($styleArray);
        $active_sheet->setCellValue('B20', 'Waktu');
        $active_sheet->getStyle('C20')->applyFromArray($styleArray);
        $active_sheet->setCellValue('C20', 'Suhu °C');
        $active_sheet->getStyle('D20')->applyFromArray($styleArray);
        $active_sheet->setCellValue('D20', 'Kelembaban %');        
    }

    $count = 21;
    $no=1;
    foreach ($result as $row) {
        $suhu = (float)$row["suhu"];
        $lembab = (float)$row["kelembaban"];
        if (isset($row))
        if ($suhu > $row_parameter["max_suhu"] or $lembab > $row_parameter["max_kelembaban"] or 
            $suhu < $row_parameter["min_suhu"] or $lembab < $row_parameter["min_kelembaban"]) {
            // $active_sheet->getStyle('A' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $active_sheet->getStyle('A' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $active_sheet->getStyle('A' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('B' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $active_sheet->getStyle('B' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('C' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $active_sheet->getStyle('C' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('D' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $active_sheet->getStyle('D' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        } else {
            $active_sheet->getStyle('A' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('A' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
            $active_sheet->getStyle('B' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('B' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
            $active_sheet->getStyle('C' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('C' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
            $active_sheet->getStyle('D' . $count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $active_sheet->getStyle('D' . $count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }
        $active_sheet->getStyle('A' . $count)->applyFromArray($styleArray);
        $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue('A' . $count, $no);
        $active_sheet->getStyle('B' . $count)->applyFromArray($styleArray);
        $active_sheet->setCellValue('B' . $count, $row["waktu"]);
        $active_sheet->getStyle('C' . $count)->applyFromArray($styleArray);
        $active_sheet->setCellValue('C' . $count, $row["suhu"]);
        $active_sheet->getStyle('D' . $count)->applyFromArray($styleArray);
        $active_sheet->setCellValue('D' . $count, $row["kelembaban"]);
        
        $count = $count + 1;
        $no++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST["file_type"]);
    $file_name = "Data Suhu Kelembaban." . strtolower($_POST["file_type"]);
    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');
    header('Content-Transfer-Encoding: Binary');
    header("Content-disposition: attachment; filename=\"".$file_name."\"");
    readfile($file_name);
    unlink($file_name);

    // header("location:tables");
    exit;
?>