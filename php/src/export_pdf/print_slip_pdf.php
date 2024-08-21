<?php
require "../connect.php";
$payment = $conn
    ->query(
        "
    SELECT
       *
    FROM
        tb_payment tp
    JOIN tb_transport tt on tt.tp_id = tp.tp_id
    WHERE
        tp.payment_id = '" .
            $_REQUEST["payment_id"] .
            "' "
    )
    ->fetch_object();

$items = $conn->query(
    "SELECT
            *
        FROM
	tb_order o
        JOIN tb_products tp ON tp.product_id = o.product_id
    WHERE o.payment_id = '" .
        $_REQUEST["payment_id"] .
        "'
        "
);

$itemsData = [];

while ($item = $items->fetch_object()) {
    $itemsData[] = $item;
}

require "code128.php";

$pdf = new PDF_Code128("P", "mm", [80, 200]);
$pdf->AddFont("THSarabunPSK", "", "THSarabun.php");
$pdf->AddFont("THSarabunPSK", "b", "THSarabun Bold.php"); //หนา
$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("THSarabunPSK", "B", 20);

$line = 6;
$count = 3;

$pdf->SetXY(5, 5);

$pdf->Cell(70, 10, iconv("UTF-8", "cp874", "SELECT WORM"), 0, 0, "C");
$pdf->SetFont("THSarabunPSK", "B", 15);

$pdf->SetXY(5, $line * 2);
$pdf->Cell(70, 10, iconv("UTF-8", "cp874", "ใบเสร็จรับเงิน"), 0, 0, "C");
$pdf->SetFont("THSarabunPSK", "B", 15);

$count++;
$pdf->SetXY(5, $line * $count);
// Convert the date string to a DateTime object
$date = new DateTime($payment->payment_create_at);

// Add 543 years to convert to the Buddhist year (BE)
$year = $date->format("Y") + 543;

// Format the date as 12/08/2567
$formattedDate = $date->format("d/m/") . $year;

$pdf->Cell(40, 7, iconv("UTF-8", "cp874", $formattedDate), 0, 0, "L");
$pdf->Cell(40, 7, iconv("UTF-8", "cp874", ""), 0, 0, "L");

$count++;
$pdf->SetXY(5, $line * $count);
$pdf->Cell(
    40,
    7,
    iconv(
        "UTF-8",
        "cp874",
        "............................................................................"
    ),
    0,
    0,
    "L"
);

$count++;
$pdf->SetXY(5, $line * $count);
$pdf->Cell(40, 7, iconv("UTF-8", "cp874", "ประเภทขนส่ง"), 0, 0, "L");
$pdf->Cell(40, 7, iconv("UTF-8", "cp874", $payment->tp_name), 0, 0, "L");

$count++;
$pdf->SetXY(5, $line * $count);
$pdf->Cell(40, 7, iconv("UTF-8", "cp874", "รหัสพัสดุ"), 0, 0, "L");
if ($payment->tp_id == 0) {
    $pdf->Cell(40, 7, iconv("UTF-8", "cp874", "-"), 0, 0, "L");
} else {
    $pdf->Cell(
        40,
        7,
        iconv(
            "UTF-8",
            "cp874",
            $payment->transport_number == null ? "" : $payment->transport_number
        ),
        0,
        0,
        "L"
    );
}

$count++;
$pdf->SetXY(5, $line * $count);
$pdf->Cell(
    40,
    7,
    iconv(
        "UTF-8",
        "cp874",
        "............................................................................"
    ),
    0,
    0,
    "L"
);

$count++;
foreach ($itemsData as $key => $value) {
    $pdf->SetXY(5, $line * ($key + $count));
    $pdf->Cell(4, 7, iconv("UTF-8", "cp874", $value->order_amount), 0, 0, "L");
    $pdf->Cell(0, 7, iconv("UTF-8", "cp874", $value->product_name), 0, 0, "L");
    $pdf->Cell(
        6,
        7,
        iconv(
            "UTF-8",
            "cp874",
            number_format($value->order_amount * $value->product_price) . " บาท"
        ),
        0,
        0,
        "R"
    );
    $pdf->Ln();
}

$pdf->SetXY(5, $line * (count($itemsData) + $count));
$pdf->Cell(
    40,
    7,
    iconv(
        "UTF-8",
        "cp874",
        "............................................................................"
    ),
    0,
    0,
    "L"
);

$count++;
$pdf->SetXY(5, $line * (count($itemsData) + $count));
$pdf->Cell(
    40,
    7,
    iconv("UTF-8", "cp874", "จำนวนสินค้ารวม " . count($itemsData) . " รายการ"),
    0,
    0,
    "L"
);

$count++;
$pdf->SetXY(5, $line * (count($itemsData) + $count));
$pdf->Cell(31, 7, iconv("UTF-8", "cp874", "ยอดรวม "), 0, 0, "L");
$pdf->Cell(
    40,
    7,
    iconv("UTF-8", "cp874", number_format($payment->payment_total) . " บาท"),
    0,
    0,
    "R"
);

$count++;
$pdf->SetXY(5, $line * (count($itemsData) + $count));
$pdf->Cell(
    40,
    7,
    iconv(
        "UTF-8",
        "cp874",
        "............................................................................"
    ),
    0,
    0,
    "L"
);

$count++;
$pdf->SetXY(5, $line * (count($itemsData) + $count));
$pdf->Cell(
    70,
    7,
    iconv("UTF-8", "cp874", "***** ขอบคุณที่ใช้บริการ *****"),
    0,
    0,
    "C"
);

$pdf->Output();
