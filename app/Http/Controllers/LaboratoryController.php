<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbResult;
use App\Models\LbTest;
use App\Reports\LaboratoryReport;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LaboratoryController extends Controller
{
    public function pdf($orderId)
    {
        $orderModel=LbOrder::with('medicalAppointment.patient')->where('id','=',$orderId)->first();
        $model=new LbResult();
        $resultados=$model->dataToPdf($orderId);
        /*$resultresultados=LbResult::with([
            'resultados.test.group.area',
            'resultados.test.measurement'
        ])->where('order_id','=',$orderId)->firstOrFail();*/

       // dd($resultModel->toArray());
        $report=new LaboratoryReport();
        $report->SetCreator(PDF_CREATOR);
        $report->SetAuthor('Nicola Asuni');
        $report->SetTitle('HISTORIAL');
        $report->SetSubject('TCPDF Tutorial');
        $report->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data

        // set default header data
        $report->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Historial' . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $report->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $report->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $report->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $report->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set default monospaced font
        $report->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $report->SetHeaderMargin(15);

        $report->SetMargins(10, 85, 10);

        $report->patient=$orderModel->medicalAppointment->patient;
        $report->date=$resultados->date;
        $report->AddPage();
        //$report->InformacionPersonal($orderModel->medicalAppointment->patient,$resultados->date);

        $report->showResults($resultados);

        $report->Output('Resultados.pdf', 'I');

        //dd($resultadostoArray());
    }
    
}
