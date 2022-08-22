<?php

namespace App\Reports;

use TCPDF;

class QRReport extends TCPDF
{

    public function Header()
    {
        $points=array(0,0,100,0,100,8,20,8,15,11,10,8,0,8,0,0);
        //$this->setLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0,0)));
        $this->setMargins(0,0,0);
        //$this->setFillColor(81, 159, 106);
        $this->setFont('Helvetica','B',12);
        /*$this->Polygon($points,'DF',array(),array(59, 131, 199));
        $this->Cell(0, 8, '', 0, 0, '', true);
        $this->setColor('text',255,255,255);
        $this->setX(5);
        $this->setMargins(5,0,5);
        $this->setY(0);*/
        //$this->Cell(0,8,"SUPERMARKET",0,1,'L');
    }
    public function Cuerpo($patient,$company)
    {
        $XLeft=55;
        $complex_cell_border = array(
            'TB' => array('width' => 4, 'color' => array(0, 0, 255), 'dash' => 4, 'cap' => 'butt'),
            'RL' => array('width' => 2, 'color' => array(0, 0, 255), 'dash' => '1,3', 'cap' => 'round'),
        );
        $this->AddPage();
        $this->SetLineStyle(array(
            'width' => 1,
            'cap' => 'round',
            'join' => 'round',
            'dash' => 0,
            'color' => array(59, 131, 199)
        ));

        $style = array(
            'border' => 1,
            'padding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            //'bgcolor' => array(255, 255, 64)
        );
        $this->setFillColor(59, 131, 199);
        $this->setColor('text', 59, 131, 199);
        //$this->SetMargins(10, 15, 10);
        $this->setY(5);
        $this->write2DBarcode($patient->identification_number, 'QRCODE,H', $XLeft, $this->GetY(), 25, 25, $style, 'N');

        $this->setFont('helvetica', 'R',12);

        //$this->setX(35);
        $this->MultiCell(40, 10, $patient->fullname, 0, '',false,1,5,5);
        $this->Ln(18);
        //$this->setX(35);

        $this->setFontSize(8);
        $this->setX(5);
        $this->Cell(5,0,"SALUTIC",0,1);
        $this->setX(5);
        $this->setColor('text', 129, 130, 131);
        $this->MultiCell(40,0,substr("Ciudadela la primavera manzana 6 villa 11",0,30),0,false);

        $this->setY(30);
        $this->Ln(4);
        $this->setColor('text', 59, 131, 199);
        $this->setFontSize(8);
        $this->setX($XLeft-10);
        $this->Cell(5,0,"M");
        $this->setColor('text', 129, 130, 131);
        $this->Cell(40,0,substr("+593123456789",0,30),0,1);
        $this->setColor('text', 59, 131, 199);
        $this->setX($XLeft-10);
        $this->Cell(5,0,"E");
        $this->setColor('text', 129, 130, 131);
        $this->Cell(40,0,substr("saluticasdasd@gmail.com",0,30),0,1);
        $this->setColor('text', 59, 131, 199);
        $this->setX($XLeft-10);
        $this->Cell(5,0,"W");
        $this->setColor('text', 129, 130, 131);
        $this->Cell(40,0,substr("www.salutic.ec",0,30),0,1);
        /*$this->setFont('helvetica', 'B');
        //$this->setX(50);
        $this->MultiCell(0, 0, $patient->lastname, 0, 'L',false,0,);*/
    }

    public function Footer()
    {
        /*$this->setY(-10);
        $this->setX(5);
        $this->setFontSize(8);
        $this->setFont('helvetica','I');
        $this->setColor('text', 129, 130, 131);
        $this->setMargins(5,0,5);
        $this->MultiCell(0,0,'Presente esta tarjeta al encargado del area que se va hacer atender');*/
    }
}
