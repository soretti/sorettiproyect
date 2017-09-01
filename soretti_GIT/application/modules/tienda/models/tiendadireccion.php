<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TiendaDireccion extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='direcciones';

	var $has_one = array("estado",
		"municipio",
		"ciudad",
		"colonia"=>array('class' => 'colonia','join_table'=>'direcciones','join_other_as'=>'tiendadireccion'),
		"usuario");

	public $validation = array(
		'tipo' => array(
			'label' => 'Tipo de dirección',
			'rules' => array('required')
		),
		'nombre' => array(
			'label' => 'Nombre',
			'rules' => array('required')
		),
		'apellidoPaterno' => array(
			'label' => 'apellido Paterno',
			'rules' => array('required')
		),
		'lada' => array(
			'label' => 'Lada',
			'rules' => array('required')
		),
		'telefono' => array(
			'label' => 'Teléfono',
			'rules' => array('required')
		),
		'calle' => array(
			'label' => 'Calle',
			'rules' => array('required')
		),
		'numero_ext' => array(
			'label' => 'Número exterior',
			'rules' => array('required')
		),
		'codigo' => array(
			'label' => 'Código postal',
			'rules' => array('required')
		),
		'estado_id' => array(
			'label' => 'Estado',
			'rules' => array('required')
		),
		'municipio_id' => array(
			'label' => 'Municipio',
			'rules' => array('required')
		),
		'colonia_id' => array(
			'label' => 'Colonia',
			'rules' => array('required')
		)
	);


	public function to_json() {
		$arr = array(
			'calle'=>$this->calle,
			'estado'=>$this->estado->titulo,
			'municipio'=>$this->municipio->titulo,
			'colonia'=>($this->nombreColonia) ? $this->nombreColonia : $this->colonia->titulo,
			'ciudad'=>$this->ciudad->titulo,
			'nombre'=>$this->nombre,
 			'codigo'=>$this->codigo,
			'apellidoPaterno'=>$this->apellidoPaterno,
			'apellidoMaterno'=>$this->apellidoMaterno,
			'calle'=>$this->calle,
			'numero_ext'=>$this->numero_ext,
			'numero_int'=>$this->numero_int,
			'suplente'=>$this->suplente,
			'referencia'=>$this->referencia,
			'lada'=>$this->lada,
			'telefono'=>$this->telefono,
			'celular'=>$this->celular,
			'rfc'=>$this->rfc,
			'razon_social'=>$this->razon_social
			);

		return json_encode($arr);
	}

}
