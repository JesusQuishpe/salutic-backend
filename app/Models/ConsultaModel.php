<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class ConsultaModel
{
    private $nombre;     //se declaran los atributos de la clase, que son los atributos del cliente
	private $apellido;
	private $fecha;
	private $peso;
	private $id;
	private $historial;
	private $sexo;
	private $medico;
	private $num;
	private $temperatura;
	private $presion;
	private $estatura;
	private $discapacidad;
	private $embarazo;
	private $terapia;
	private $cardiopatia;
	private $diabetes;
	private $hipertension;
	private $cirugias;
	private $alergiasmedicina;
	private $alergiascomida;
	private $sintoma1;
	private $sintoma2;
	private $sintoma3;
	private $presuntivo1;
	private $presuntivo2;
	private $presuntivo3;
	private $definitivo1;
	private $definitivo2;
	private $definitivo3;
	private $medicamento1;
	private $medicamento2;
	private $medicamento3;
	private $medicamento4;
	private $medicamento5;
	private $medicamento6;
	private $dosificacion1;
	private $dosificacion2;
	private $dosificacion3;
	private $dosificacion4;
	private $dosificacion5;
	private $dosificacion6;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        
    }

    public function getClientes()
    {
        return DB::select("select C.id, CONCAT(A.apellidos,' ',A.nombres) as nombre, B.areaa_cita as apellido, A.nacimiento as fecha_nac, C.medico as peso 
        from ingresar A, citas B, enfermeria C
        where B.fecha_cita=CURDATE() and A.num=B.num and B.id=C.id  
        and C.medico!='Luis Olmedo Abril' and C.medico!='Tetyana Sidash' and C.medico!='Dalila Pacheco Galabay' 
        and C.medico!='Erika Baldeon Fajardo' and C.medico!='Vilma Poma' and C.medico!='Robert Lopez'
        and C.medico!='Marilyn Barzola Mosquera' and C.medico!='Gerardo Niebla' and C.medico!='Mariana Tinoco'
        and C.medico!='Kennya Penaranda Niebla' and C.medico!='Alercex Subaldia' and C.medico!='Gabriela Crespo Asanza'
        and C.medico!='Emma Sanchez Ramirez' and C.medico!='Jorge Martinez' and consultorio!='c' order by B.hora_cita asc", [1]);
    }
}
