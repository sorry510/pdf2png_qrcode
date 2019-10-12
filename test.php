<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPZxing\PHPZxingDecoder;

function pdf2png($pdf, $path='') {
	$pdf = str_replace('\\', '/', $pdf);
    if(empty($path)) {
        $path = __DIR__ . '/imgs/';
    }
	$path = str_replace('\\', '/', $path);
	$filename = $path . pathinfo($pdf)['filename'] . '.png';
	$cmd = "gswin64 -dQUIET -dNOSAFER -r300 -dBATCH -sDEVICE=pngalpha -dNOPAUSE -sOutputFile={$filename} {$pdf}";
    shell_exec($cmd);
    return $filename;
}

function readQrcode($path) {
    $config = array(
        'try_harder' => true,
    );
    $decoder = new PHPZxingDecoder($config);
    // $decoder->setJavaPath('E:\\env\\Java\\jdk1.8.0_171\\jre\\bin\\java.exe');
    $decoder->setJavaPath('java'); // 全局环境变量 global env
    $path = str_replace('\\', '/', $path);
    substr(PHP_OS, 0, 3) === 'WIN' && $path = 'file:///' . $path; // window is must write file:///
    $decodedData = $decoder->decode($path);
    if($decodedData->isFound()) {
		return $decodedData->getImageValue();
	}else {
        return 'not find qrcode';
    }
}

(function() {
    $args = func_get_args();
    if(count($args) > 1) {
        $pdf = $args[1];
        $path = isset($args[2]) ? $args[2] : '';
        $img = pdf2png($pdf, $path);
        $code = readQrcode($img);
        echo $code;
    }else {
        echo 'example1: php test.php inputFile';
        echo PHP_EOL;
        echo 'example2: php test.php inputFile outputFile(is must absulute path)';
    }
})(...$argv);