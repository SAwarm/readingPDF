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

        $file_name = "$dir/cronograma.pdf";

        $files = array_diff($allFiles, array('.', '..'));
    
        foreach ($files as $value) {
            $var =  Response::make(file_get_contents("$dir/$value"), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="cronograma"'
            ]);

            $base64_pdf = base64_encode($var);
        }

        $parser = new \Smalot\PdfParser\Parser();

        $pdf = $parser->parseFile("$file_name");

        $text = $pdf->getText();

        if (strrpos($text, "feiras")) {
            return true;
        }

        return false;
    }
}
