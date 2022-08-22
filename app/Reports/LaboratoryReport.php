<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use TCPDF;


class LaboratoryReport extends TCPDF
{
    protected $last_page_flag = false;

    public function Close()
    {
        $this->last_page_flag = true;
        parent::Close();
    }
    public function Header()
    {
        $image_file = public_path('images/wave.png');
        $this->Image($image_file, 0, 0, 250, 50, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        //$this->SetFillColor(117,164,120);
        $this->SetFillColor(79, 178, 50);
        //$this->MultiCell(0, 0, '', 0, 'C', true,1,null,0);
        $this->Ln(25);
        $this->MultiCell(0, 0, 'CENTRO INTEGRAL DE SALUD DEL GOBIERNO AUTONOMO DESCENTRALIZADO PROVINCIAL DE EL ORO', 0, 'C', false);
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 0, 'Dirección: 9 de Mayo s/n entre 25 de Junio y Sucre', 0, 1, 'C');
        $this->Cell(0, 0, 'Teléfono: 07-2936055', 0, 1, 'C');
        $this->Cell(0, 0, ' = Machala - El Oro - Ecuador =', 0, 1, 'C');
        $this->SetFont('helvetica', '', 11);
        //$this->setY($this->GetY() + 30);
        $this->SetFillColor(200, 220, 255);
        $this->Ln(5);
        #------------------DATOS PERSONALES------------------
        $this->Cell(20, 0, "Código", 0, 0);
        $this->Cell(20, 0, $this->patient->id, 0, 1);
        $this->Cell(20, 0, 'Cédula: ', 0, 0);
        $this->Cell(20, 0, $this->patient->identification, 0, 1);
        $this->Cell(20, 0, 'Paciente: ', 0, 0);
        $this->Cell(80, 0, $this->patient->fullname, 0, 0);
        $this->Cell(20, 0, 'Sexo: ', 0, 0);
        $this->Cell(50, 0, $this->patient->gender, 0, 1);
        $this->Cell(20, 0, 'Fecha: ', 0, 0);
        $this->Cell(50, 0, Carbon::parse($this->date)->isoFormat('dddd D \d\e MMMM \d\e\l Y'), 0, 1);

        $this->SetFont('helvetica', 'I', 9);
        $this->setX(15);
        $this->SetFillColor(79, 178, 50);
        $this->setX($this->GetX() + 60);
        $this->Cell(50, 0, "Resultados", 0, 0, '', false);
        $this->Cell(25, 0, "Unidad", 0, 0, '', false);
        $this->Cell(0, 0, "Valores normales", 0, 1, '', false);
        $this->Ln(5);
    }

    public function InformacionPersonal($patient, $date)
    {
        $this->AddPage();
    }

    public function showResults($resultados)
    {
        //$this->AddPage();

        //$area = "";
        foreach ($resultados->areas as $area) {
            $this->SetFillColor(79, 178, 50);
            $this->SetFont('helvetica', '', 12);
            //Pintamos el area
            $this->Cell(0, 0, $area->name, 'B', 1, 'C', true);
            $this->Ln(1);

            foreach ($area->groups as $group) {
                if ($group->showAtPrint) {
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell(70, 0, $group->name, 0, 1, '', false);
                }
                $this->Ln(1);
                foreach ($group->tests as $test) {
                    $this->SetFont('helvetica', '', 9.5);
                    $this->setX(15);
                    //Cortamos el nombre de la prueba en caso de que sea muy largo
                    $partOfName = $test->name;
                    if (strlen($test->name) > 25) {
                        $partOfName = substr($test->name, 0, 25) . "...";
                    }
                    $this->Cell(60, 0, $partOfName, 0, 0, '', false);
                    $resultValue = $test->is_numeric === 1 ?
                        $test->numeric_result :
                        ucfirst(strtolower($test->string_result));
                    if (strlen($resultValue) > 30) {
                        $resultValue = substr($resultValue, 0, 30) . "...";
                    }

                    $interpreationValue = ucfirst(strtolower($test->interpretation));
                    if (strlen($interpreationValue) > 30) {
                        $interpreationValue = substr($interpreationValue, 0, 30) . "...";
                    }
                    $this->Cell(50, 0, $resultValue, 0, 0, '', false);
                    $this->Cell(25, 0, $test->abbreviation ? $test->abbreviation : "Sin definir", 0, 0, '', false);
                    $this->Cell(0, 0, $interpreationValue, 0, 0, '', false);
                    //dd($result->toArray());
                    $this->Ln();
                }
            }
            $this->Ln(2);
        }
        /*foreach ($resultados as $result) {
            if ($area !== $result->test->group->area->name) {
                $this->SetFillColor(79, 178, 50);
                $this->SetFont('helvetica', '', 12);
                $area = $result->test->group->area->name;
                //Pintamos el area
                $this->Cell(0, 0, $result->test->group->area->name, 'B', 1, 'C', true);
                //$this->ln(2);

                $this->Ln(1);
            }
            $this->SetFont('helvetica', '', 10);
            $this->Cell(70, 0, $result->test->name, 0, 0, '', false);
            $this->Cell(40.5, 0, $result->test->is_numeric === 1 ?
                $result->numeric_result :
                $result->string_result, 0, 0, '', false);
            $this->Cell(40.5, 0, $result->test->measurement['abbreviation'], 0, 0, '', false);
            $this->Cell(40.5, 0, $result->test->interpretation, 0, 0, '', false);
            //dd($result->toArray());
            $this->Ln();
        }*/
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        if ($this->last_page_flag) { //Si es la ultima
            $this->SetFont('helvetica', 'B', 8);
            $this->SetY(-30);
            $this->Cell(65, 0, "DRA.BIOQ. IRMA JIMENEZ R.", '', 0, 'C', false);
            $this->setX(130);
            $this->Cell(65, 0, "DRA.BIOQ. CAROLINA VALAREZO T.", '', 1, 'C', false);
            $this->SetY(-20);
            $this->Cell(0, 0, "PROGRAMA DE SALUD COMUNITARIA.", 0, 0, 'C', false);
        }

        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetY(-15);
        $this->Cell(0, 10, 'Pág ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
