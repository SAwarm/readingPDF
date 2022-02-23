<?php

namespace App\Http\Controllers\ReadingPDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ReadingPDFController extends Controller
{
    public function readingPDF()
    {
        $dir = base_path('pdf');
        $allFiles = scandir($dir);

        $files = array_diff($allFiles, array('.', '..'));
    
        foreach ($files as $value) {
            $var =  Response::make(file_get_contents("$dir/$value"), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="cronograma"'
            ]);

            $var1 = base64_encode($var);

            $return = $var;
        }

        $return = file_get_contents("$dir/cronograma.pdf");

        $parser = new \Smalot\PdfParser\Parser();

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile("$dir/cronograma.pdf");
        $text = $pdf->getText();

        if (strrpos($text, "feiras")) {
            return true;
        }

        return false;
    }
}
