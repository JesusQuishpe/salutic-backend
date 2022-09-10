<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OdoPatientRecord;
use App\Reports\OdontologyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class OdoPDFController extends Controller
{
    //
    public function pdf($recId)
    {
        // $idOdo = $request->input('idOdo');
        //$appoId=$request->input('appoId');
        //$nurId=$request->input('nurId');
       // $recId=$request->input('recId');
        $company=Company::find(1);
        $model=new OdoPatientRecord();
        
        $data=$model->getPatientRecordData($recId);

        #---------------------------------------

        $report = new OdontologyReport();
        $report->companyName=$company->long_name;
        $report->companyAddress=$company->address;
        $report->companyCellphone=$company->phone;
        // set document information

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

        // set default monospaced font
        $report->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $report->SetHeaderMargin(15);

        $report->SetMargins(10, 60, 10);

        //$report->SetFooterMargin(PDF_MARGIN_FOOTER);

        $report->InformacionPersonal($data['patient'],$data['patient_record']);
        $report->Antecedentes($data['diseaseList'],$data['familyHistory']);
        $report->ExamenEstomatognatico($data['pathologies'],$data['stomatognathicTest']);
        $report->Odontograma($data['patient_record']->odontogram_path);
        $report->IndicadoresDeSaludBucal($data['indicator']);
        $report->indicesCpoCeo($data['cpoCeoRatios']);
        $report->planDiagnostico($data['planDiagnostic']);
        $report->diagnosticos($data['diagnostics']);
        $report->tratamientos($data['treatments']);
        //dd($data['planDiagnostic']->details->toArray());
        $report->Output('Historial.pdf', 'I');
    }

    public function downloadActa($recId)
    {
        $model=OdoPatientRecord::find($recId);
        $extension=File::extension($model->acta_path);
        return Storage::download($model->acta_path,"acta-$model->id.$extension");
    }
}
