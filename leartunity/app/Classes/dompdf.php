<?php 

namespace App\Classes;
use App\Interfaces\PDFGenerator;

class Dompdf implements PDFGenerator {
    public function __construct(protected Dompdf $PDFGen) {}
    public function generate($content) {

        $this->PDFGen->loadHtml($content);

    }
}