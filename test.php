<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPZxing\PHPZxingDecoder;

function pdf2png($pdf, $path) {
	$pdf = str_replace('\\', '/', $pdf);
	$path = str_replace('\\', '/', $path);
	$filename = $path . "/" . md5(time()) . '.png';
	$cmd = "gswin64 -dQUIET -dNOSAFER -r300 -dBATCH -sDEVICE=pngalpha -dNOPAUSE -sOutputFile={$filename} {$pdf}";
    shell_exec($cmd);
    return $filename;
}

function readQrcode($path) {
    $config = array(
        'try_harder' => true,
    );
    // window
    $decoder = new PHPZxingDecoder($config);
    // $decoder->setJavaPath('E:\\env\\Java\\jdk1.8.0_171\\jre\\bin\\java.exe');
    $decoder->setJavaPath('java');
    $path = str_replace('\\', '/', $path);
    $decodedData = $decoder->decode('file:///' . $path);
    if($decodedData->isFound()) {
		return $decodedData->getImageValue();
	}
}
// $decoder = new \PHPZxing\PHPZxingDecoder();
// // Set java path with double quote '"path/to/java/exe"'
// $decoder->setJavaPath('"C:\Program Files\Java\jdk1.8.0_202\bin\java.exe"');
// // replace \ by / in file path

// // add file:/// before file Path
// $data = $decoder->decode('file:///'.$newPath);
$pdf = './test.pdf';
$path = 'E:\php\qrcode';
$img = pdf2png($pdf, $path);
$code = readQrcode($img);
echo $code;
// $path = 'C:/Users/admin/Desktop/test.png';
// $path = 'C:/Users/admin/Desktop/test.pdf';
// echo readQrcode($path);
