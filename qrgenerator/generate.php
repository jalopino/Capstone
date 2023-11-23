<?php include __DIR__ . '/../static/header.php';?>
<?php include __DIR__ . '/../templates/restrict_anon.php';?>
<?php
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

$text = $_POST["text"];

$qr_code = QrCode::create($text)
                 ->setSize(600)
                 ->setMargin(40)
                 ->setForegroundColor(new Color(0, 0, 0))
                 ->setBackgroundColor(new Color(204, 229, 255))
                 ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh);

$writer = new PngWriter;

$result = $writer->write($qr_code);

// Output the QR code image to the browser
header("Content-Type: " . $result->getMimeType());

echo $result->getString();

// Save the image to a file
$uniqueqr = __DIR__ . "/../qrgenerator/qrcodes/" . uniqid() . "qr-code.png";
$result->saveToFile($uniqueqr);