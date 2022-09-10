<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class OdontologyReport extends TCPDF
{
  public $companyName = "";
  public $companyAddress = "";
  public $companyCellphone = "";
  

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
    $this->MultiCell(0, 0, $this->companyName, 0, 'C', false);
    $this->SetFont('helvetica', '', 12);
    $this->Cell(0, 0, $this->companyAddress, 0, 1, 'C');
    $this->Cell(0, 0, "Teléfono: ". $this->companyCellphone, 0, 1, 'C');
    $this->Cell(0, 0, ' = Machala - El Oro - Ecuador =', 0, 1, 'C');
    $this->SetFont('helvetica', '', 11);
    //$this->setY($this->GetY() + 30);
    $this->SetFillColor(200, 220, 255);
    $this->Ln(5);
  }

  public function InformacionPersonal($patient, $patientRecord)
  {
    $this->AddPage();
    $this->SetFillColor(79, 178, 50);
    #------------------DATOS PERSONALES------------------
    $this->Cell(0, 0, "1. INFORMACION PERSONAL", 'B', 1, '', false);
    $this->MultiCell(50, 0, 'Nombres y apellidos: ', 0, 'J', false, 0);
    $this->MultiCell(0, 0, $patient->fullname, 0, 'L');
    $this->MultiCell(50, 0, 'Fecha de nacimiento: ', 0, 'J', false, 0);
    $this->MultiCell(60, 0, Carbon::parse($patient->birth_date)->isoFormat('dddd D \d\e MMMM \d\e\l Y'), 0, 'L', false, 0);
    //$this->MultiCell(15, 0, 'Edad: ', 0, 'J', false, 0);
    // $this->MultiCell(20, 0, '22 años', 0, 'L', false, 0);
    $this->MultiCell(15, 0, 'Sexo: ', 0, 'J', false, 0, $this->GetX() + 35);
    $this->MultiCell(25, 0, $patient->gender, 0, 'L', false, 1);
    $this->MultiCell(20, 0, 'Celular: ', 0, 'J', false, 0);
    $this->MultiCell(30, 0, $patient->cellphone, 0, 'L', false, 0);
    $this->MultiCell(22, 0, 'Provincia: ', 0, 'J', false, 0);
    $this->MultiCell(69, 0, $patient->province, 0, 'L', false, 0);
    $this->MultiCell(20, 0, 'Ciudad: ', 0, 'J', false, 0);
    $this->MultiCell(0, 0, $patient->city, 0, 'L', false, 1);
    $this->MultiCell(50, 0, 'Fecha de atención: ', 0, 'J', false, 0);
    $this->MultiCell(0, 0, Carbon::parse($patientRecord->date)->isoFormat('dddd D \d\e MMMM \d\e\l Y'), 0, 'L', false, 1);
    #------------------MOTIVO DE LA CONSULTA------------------
    $this->Cell(0, 0, "2. MOTIVO DE LA CONSULTA", 'B', 1, '', false);
    $this->MultiCell(0, 0, $patientRecord->reason_consultation ? $patientRecord->reason_consultation : "Ninguno", 0, 'L', false, 1);
    #------------------ENFERMEDAD O PROBLEMA ACTUAL------------------
    $this->Cell(0, 0, "3. ENFERMEDAD O PROBLEMA ACTUAL", 0, 1, '', false);
    $this->MultiCell(0, 0, $patientRecord->current_disease_and_problems ? $patientRecord->current_disease_and_problems : "Ninguno", 0, 'L', false, 1);
  }

  public function Antecedentes($diseaseList, $familyHistory)
  {
    $this->Cell(0, 0, "4. ANTECEDENTES PERSONALES Y FAMILIARES", 'B', 1, '', false);
    $this->Ln(2);
    $this->Cell(0, 0, "Antecendentes:", 0, 1, '', false);
    $this->Ln(2);
    $checkPositionX = $this->GetX();
    $checkPositionY = $this->GetY();
    for ($i = 0; $i < count($diseaseList); $i++) {
      if ($i % 4 === 0 && $i > 0) {
        $this->Ln();
        $checkPositionX = $this->GetX();
        $checkPositionY += 5;
      }
      $this->MultiCell(42.5, 0, $diseaseList[$i]->name, 0, 'L', false, 0, $checkPositionX, $checkPositionY);
      $encontrado = false;
      for ($y = 0; $y < count($familyHistory->details); $y++) {
        $det = $familyHistory->details[$y];
        if ($det->disease_id === $diseaseList[$i]->id) {
          $encontrado = true;
          break;
        }
      }
      if ($encontrado) {
        $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $checkPositionY + 1, '<img src="images/checked_checkbox.png" />');
      } else {
        $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $checkPositionY + 1, '<img src="images/unchecked_checkbox.png" />');
      }
      $checkPositionX += 47.5;
    }
    $this->Ln(7);
    $this->Cell(0, 0, "Descripción:", 0, 1, '', false);
    $this->Ln(2);
    $this->MultiCell(0, 0, $familyHistory->description ? $familyHistory->description : "Ninguna", 0, 'L', false, 1);
    //$this->Ln();
  }

  public function ExamenEstomatognatico($pathologies, $stomatognathicTest)
  {
    $this->Cell(0, 0, "5. EXAMEN DEL SISTEMA ESTOMATOGNÁTICO", 'B', 1, '', false);
    $checkPositionX = $this->GetX();
    $checkPositionY = $this->GetY();
    for ($i = 0; $i < count($pathologies); $i++) {
      if ($i % 4 == 0 && $i > 0) {
        $this->Ln();
        $checkPositionX = $this->GetX();
        $checkPositionY += 5;
      }
      $this->MultiCell(42.5, 0, $pathologies[$i]->name, 0, 'L', false, 0, $checkPositionX, $checkPositionY);
      $encontrado = false;
      for ($y = 0; $y < count($stomatognathicTest->details); $y++) {
        $det = $stomatognathicTest->details[$y];
        if ($det->pat_id === $pathologies[$i]->id) {
          $encontrado = true;
          break;
        }
      }
      if ($encontrado) {
        $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $checkPositionY + 1, '<img src="images/checked_checkbox.png" />');
      } else {
        $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $checkPositionY + 1, '<img src="images/unchecked_checkbox.png" />');
      }
      $checkPositionX += 47.5;
    }
    $this->Ln(7);
    $this->Cell(0, 0, "Descripción:", 0, 1, '', false);
    $this->Ln(2);
    $this->MultiCell(0, 0, $stomatognathicTest->description ? $stomatognathicTest->description : "Ninguna", 0, 'L', false, 1);
    $this->Ln();
  }
  public function Odontograma($odontogramPath)
  {
    $this->AddPage();
    $this->Cell(0, 0, "6. ODONTOGRAMA", 'B', 1, '', false);
    //$imagen=file_get_contents(public_path('images/png/checked.png'));
    $this->Ln();
    /*$img_base64_encoded = $odontogramaImage;
        $imgDecoded=base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $img_base64_encoded));
        file_put_contents(public_path('images/png/odontograma.jpeg'),base64_decode(substr($img_base64_encoded, strpos($img_base64_encoded, ",")+1)));*/
    //base64_decode(substr($img_base64_encoded, strpos($img_base64_encoded, ",")+1));
    //base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $img_base64_encoded));
    // $img = '<img src="@'.$imgDecoded. '" width="100px" height="100px">';
    //$this->writeHTML($img, true, false, true, false, '');
    $full_path = Storage::path($odontogramPath);
    //storage_path('app/'.$data['odontograma']['odontogramaImage'])
    $this->Image($full_path, $this->GetX(), $this->GetY(), 190, 80, '', '', '', false, 400);
  }
  public function IndicadoresDeSaludBucal($indicator)
  {
    //$this->AddPage();
    //$this->setPageOrientation('P');
    $this->setY($this->GetY() + 80);
    $this->Ln();
    $this->Cell(0, 0, "7. INDICADORES DE SALUD BUCAL", 'B', 1, '', false);
    $options1 = ['Leve', 'Moderada', 'Severa'];
    $options2 = ['Angle I', 'Angle II', 'Angle III'];
    //Enfermedad periodontal
    $this->Cell(0, 0, "a. Enfermedad periodontal:", 0, 1, '', false);
    //$div="<div>";
    foreach ($options1 as $value) {
      if ($value === $indicator->per_disease) {
        //$div.="<span style='background-color: #FFFF00'>$value<span>";
        $this->SetFillColor(255, 255, 0);
        $this->Cell(25, 0, $value, 0, 0, 'C', true);
      } else {
        //$div.="<span style='background-color:#c0ffc8;'>$value<span>";
        $this->Cell(25, 0, $value, 0, 0, 'C', false);
      }
    }
    $this->Ln();
    $this->Cell(0, 0, "b. Mal oclusión:", 0, 1, '', false);
    foreach ($options2 as $value) {
      if ($value === $indicator->bad_occlu) {
        //$div.="<span style='background-color: #FFFF00'>$value<span>";
        $this->SetFillColor(255, 255, 0);
        $this->Cell(25, 0, $value, 0, 0, 'C', true);
      } else {
        //$div.="<span style='background-color:#c0ffc8;'>$value<span>";
        $this->Cell(25, 0, $value, 0, 0, 'C', false);
      }
    }
    $this->Ln();
    $this->Cell(0, 0, "c. Fluorosis:", 0, 1, '', false);
    foreach ($options1 as $value) {
      if ($value === $indicator->fluorosis) {
        //$div.="<span style='background-color: #FFFF00'>$value<span>";
        $this->SetFillColor(255, 255, 0);
        $this->Cell(25, 0, $value, 0, 0, 'C', true);
      } else {
        //$div.="<span style='background-color:#c0ffc8;'>$value<span>";
        $this->Cell(25, 0, $value, 0, 0, 'C', false);
      }
    }
    $this->Ln();
    $this->SetFillColor(79, 178, 50);
    $this->Ln();
    $this->crearTable($indicator, 35);
  }
  private function crearTable($indicator, $moveTo)
  {
    $this->SetX($moveTo);
    //----------------Header--------------------
    $tbHeader = array('Piezas dentales', 'Placa', 'Cálculo', 'Gingivitis');
    $widthHeaders = array(50, 30, 30, 30);
    for ($i = 0; $i < count($tbHeader); $i++) {
      $this->Cell($widthHeaders[$i], 7, $tbHeader[$i], 'LTBR', 0, 'C', 1);
    }
    $this->Ln();
    $this->SetX($moveTo);
    //----------------Body---------------------

    $yini = $this->GetY();
    $y = $yini;
    for ($i = 0; $i < count($indicator->details); $i++) {

      $detail = $indicator->details[$i];
      //Primera fila
      if ($i == 0) {
        $this->createRow('16', '17', '55', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
      if ($i == 1) {
        $this->createRow('11', '21', '51', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
      if ($i == 2) {
        $this->createRow('26', '27', '65', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
      if ($i == 3) {
        $this->createRow('36', '37', '75', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
      if ($i == 4) {
        $this->createRow('31', '41', '71', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
      if ($i == 5) {
        $this->createRow('46', '47', '85', $detail, $widthHeaders, $y, 'LB', $moveTo);
        $y = $this->GetY();
        //$this->GetX()=$this->GetX();
      }
    }
    $this->SetX($moveTo);
    //----------------Footer--------------------
    $this->Cell($widthHeaders[0], 6, 'Totales', 'LBR', 0, 'C', 1);
    $this->Cell($widthHeaders[1], 6, $indicator->plaque_total, 'LB', 0, 'C', 1);
    $this->Cell($widthHeaders[2], 6, $indicator->calc_total, 'LB', 0, 'C', 1);
    $this->Cell($widthHeaders[3], 6, $indicator->gin_total, 'LBR', 0, 'C', 1);
    $this->Ln(2);
  }

  private function createRow($num1, $num2, $num3, $detail, $widthHeaders, $y, $border, $moveTo)
  {
    //--------------Primera celda-----------------
    $this->SetX($moveTo);
    $this->MultiCell($widthHeaders[0], 6, '', $border, '', false, 0, $this->GetX(), $y); //para efecto de primera celda
    $this->SetX($this->GetX() - $widthHeaders[0]);

    //Primer item con check
    $selectedPieces = $detail['selected_pieces'];
    $this->MultiCell(8, 6, $num1, 0, '', false, 0, $this->GetX(), $y);
    if (str_contains($selectedPieces, $num1)) {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/checked_checkbox.png" />');
    } else {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/unchecked_checkbox.png" />');
    }


    //Segundo item con check
    $this->MultiCell(8, 6, $num2, 0, '', false, 0, $this->GetX(), $y);
    if (str_contains($selectedPieces, $num2)) {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/checked_checkbox.png" />');
    } else {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/unchecked_checkbox.png" />');
    }


    //Tercer item con check
    $this->MultiCell(8, 6, $num3, 0, '', false, 0, $this->GetX(), $y);
    if (str_contains($selectedPieces, $num3)) {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/checked_checkbox.png" />');
    } else {
      $this->writeHTMLCell(5.5, 5.5, $this->GetX(), $y + 1, '<img src="images/unchecked_checkbox.png" />');
    }


    $this->SetX($this->GetX() + ($moveTo - $this->GetX()));
    //------------------------Segunda Celda--------------
    $this->SetX($this->GetX() + $widthHeaders[0]); //Se desplaza a la segunda celda
    $this->MultiCell($widthHeaders[1], 6, $detail->plaque, $border, 'C', false, 0, $this->GetX(), $y);
    $this->MultiCell($widthHeaders[2], 6, $detail->calc, $border, 'C', false, 0, $this->GetX(), $y);
    $this->MultiCell($widthHeaders[3], 6, $detail->gin, $border . 'R', 'C', false, 0, $this->GetX(), $y);

    $this->Ln();
    $y = $this->GetY();
  }

  public function calcMid($cellWidth, $a4Width = 210, $marginX = 20)
  {
    $a4WithoutMargin = $a4Width - $marginX;
    $cellMid = $cellWidth / 2;
    $paperMid = $a4WithoutMargin / 2;
    $difference = $paperMid - $cellMid;
    $mid = $difference + $marginX / 2;
    return $mid;
  }

  public function indicesCpoCeo($cpoCeoRatios)
  {
    $this->setY($this->GetY() + 10);
    $this->Cell(0, 0, "8. INDICES CPO-CEO", 'B', 1, '', false);
    $this->Ln();
    $this->setX($this->calcMid(150));

    $this->Cell(30, 12, 'D', 'LBT', false, 'C', true);
    $this->Cell(30, 6, 'c', 'LBT', false, 'C', true);
    $this->Cell(30, 6, 'p', 'LBT', false, 'C', true);
    $this->Cell(30, 6, 'o', 'LBRT', false, 'C', true);
    $this->Cell(30, 6, 'Total', 'LBRT', false, 'C', true);
    $this->setY($this->GetY() + 6);
    $this->setX($this->calcMid(150) + 30);
    //$this->setX($this->calcMid(150));
    $this->Cell(30, 6, $cpoCeoRatios->cd, 'LT', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->pd, 'LT', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->od, 'LRT', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->cpo_total, 'LRT', true, 'C', false);
    $this->setY($this->GetY());
    $this->setX($this->calcMid(150));
    $this->Cell(30, 12, 'd', 'LBT', false, 'C', true);
    $this->Cell(30, 6, 'c', 'LTB', false, 'C', true);
    $this->Cell(30, 6, 'e', 'LTB', false, 'C', true);
    $this->Cell(30, 6, 'o', 'LTB', false, 'C', true);
    $this->Cell(30, 6, 'Total', 'LTBR', true, 'C', true);
    $this->setX($this->calcMid(150) + 30);
    $this->Cell(30, 6, $cpoCeoRatios->ce, 'LB', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->ee, 'LB', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->oe, 'LB', false, 'C', false);
    $this->Cell(30, 6, $cpoCeoRatios->ceo_total, 'LBR', true, 'C', false);
    $this->Ln();
  }

  public function planDiagnostico($planDiagnostic)
  {
    $this->Cell(0, 0, "9. PLANES DE DIAGNÓSTICO, TERAPÉUTICO Y EDUCACIONAL", 'B', true, '', false);
    $this->Cell(0, 0, "Planes seleccionados:", 0, 1, '', false);
    $mappedArray = $planDiagnostic->details->map(function ($detail) {
      return $detail->plan->name;
    })->toArray();
    $planes = implode(', ', $mappedArray);
    $this->MultiCell(0, 0, $planes ? $planes : "Ninguno", 0, 'L', false, 1);
    $this->Ln(2);
    $this->Cell(0, 0, "Descripción:", 0, 1, '', false);
    $this->Ln(2);
    $this->MultiCell(0, 0, $planDiagnostic->description ? $planDiagnostic->description : "Ninguno", 0, 'L', false, 1);
    $this->Ln();
  }

  public function diagnosticos($diagnostics)
  {
    $this->Cell(0, 0, "10. DIAGNÓSTICOS", 'B', true, '', false);
    foreach ($diagnostics as $index => $diag) {
      $this->Cell(10, 0, "N°:", 0, false, '', false);
      $this->Cell(0, 0, $index + 1, 0, true, '', false);
      $this->Cell(30, 0, "Tipo:", 0, true, '', false);
      $this->Cell(0, 0, $diag->type, 0, true, '', false);
      $this->Cell(30, 0, "Diagnóstico:", 0, true, '', false);
      $this->MultiCell(0, 0, $diag->diagnostic, 0, 'L', false, 1);
      $this->Cell(30, 0, "CIE:", 0, true, '', false);
      $this->Cell(0, 0, $diag->cie->disease, 0, true, '', false);
      $this->Cell(0, 0, "--------------------------------------------------------------------------------------", 0, true, '', false);
      $this->Ln();
    }
    $this->Ln();
  }

  public function tratamientos($treatments)
  {
    $this->Cell(0, 0, "11. TRATAMIENTOS", 'B', true, '', false);
    foreach ($treatments as $index => $treatment) {
      $this->Cell(20, 0, "Sesión:", 0, false, '', false);
      $this->Cell(0, 0, $treatment->sesion, 0, true, '', false);
      $this->Cell(30, 0, "Diagnósticos y complicaciones:", 0, true, '', false);
      $this->MultiCell(0, 0, $treatment->complications, 0, 'L', false, 1);
      $this->Cell(30, 0, "Procedimientos:", 0, true, '', false);
      $this->MultiCell(0, 0, $treatment->procedures, 0, 'L', false, 1);
      $this->Cell(30, 0, "Prescripciones:", 0, true, '', false);
      $this->MultiCell(0, 0, $treatment->prescriptions, 0, 'L', false, 1);
      $this->Cell(0, 0, "--------------------------------------------------------------------------------------", 0, true, '', false);
      $this->Ln();
    }
    $this->Ln();
  }
  public function Footer()
  {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    //$this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Pág ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
  }
}
