<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Direccion_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('sepomex/estado');
		$this->load->model('sepomex/municipio');
		$this->load->model('sepomex/colonia');
		$this->load->model('sepomex/ciudad');
		$this->load->model('tiendaDireccion'); 
	}


	public function listar(){ 
		identificar();
		$usuario_id = $this->session->userdata('usuario_id');
		$this->tiendaDireccion->where('usuario_id',$usuario_id)->get();
		$meta=array('titulo'=>'Mi ceutan | Mis direcciones','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('direccion/direccion_list',array('direcciones'=>$this->tiendaDireccion, 'meta' =>$meta, 'titulo'=>'Mis direcciones'),true);
		$this->load->view('plantilla/default');
	}

	public function formulario($id=0) {

		identificar();
		$titulo='Crear Dirección';

		if($id) {
			$titulo='Modificar Dirección';
			$this->tiendaDireccion->where('id',$id)->where('usuario_id',$this->session->userdata("usuario_id"))->get();
			if(!$this->tiendaDireccion->result_count()) {
				show_error('Lo sentimos, la dirección no existe', 500 );
			}
		}

		$fields = array( 
				'tipo',
				'rfc',
				'razon_social',
				'nombre',
				'apellidoPaterno',
				'apellidoMaterno',
				'lada',
				'telefono',
				'celular',
				'alias',
				'calle',
				'codigo',
				'numero_ext',
				'numero_int',
				'suplente',
				'referencia',
				'estado_id',
				'municipio_id',
				'nombreColonia',
				'colonia_id');

		if($_POST) {

			if($this->input->post('colonia_id')!='n/a'){
				$_POST['nombreColonia']='';
			}

			if($this->input->post('nombreColonia') || $this->input->post('colonia_id')=='n/a'){
				$this->tiendaDireccion->validation['nombreColonia']=array( 'field' => 'nombreColonia','label' => 'Nombre de la colonia','rules' => array('required') );
				$this->tiendaDireccion->ciudad_id='';
			}
			if(is_numeric($this->input->post('colonia_id'))){
				$colonia=new colonia($this->input->post('colonia_id'));
				if( $colonia->exists() && $colonia->ciudad_id )  $this->tiendaDireccion->ciudad_id=$colonia->ciudad_id;
			}


				$this->tiendaDireccion->usuario_id = $this->session->userdata("usuario_id");
				$this->tiendaDireccion->from_array($_POST, $fields);

				if($this->tiendaDireccion->tipo==1){
						$this->tiendaDireccion->validation = array( 
							'tipo' => array(
								'label' => 'Tipo de dirección',
								'rules' => array('required')
							),
							'nombre' => array(
								'label' => 'Nombre',
								'rules' => array('required')
							),
							'apellidoPaterno' => array(
								'label' => 'Apellido paterno',
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
				}
				if($this->tiendaDireccion->tipo==2){
						$this->tiendaDireccion->validation = array( 
							'tipo' => array(
								'label' => 'Tipo de dirección',
								'rules' => array('required')
							),
							'rfc' => array(
								'label' => 'RFC',
								'rules' => array('required')
							),
							'razon_social' => array(
								'label' => 'Razon social',
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
				}

				if($this->input->post('enviar')){
					$this->tiendaDireccion->save();
					$id = $this->tiendaDireccion->id;
				}
				
		}
		$this->tiendaDireccion->tipo=($this->tiendaDireccion->tipo) ? $this->tiendaDireccion->tipo : 1;
 

		$estados    = $this->estado->order_by('titulo')->get();
		$municipios = $this->municipio;
		$colonias   = $this->colonia;



		$estado_id = $this->tiendaDireccion->estado_id;
		$post_estado_id = $this->input->post('estado_id');
		if($post_estado_id) {$estado_id=$post_estado_id;}

		if($estado_id) {

			if($_POST && !$this->input->post('enviar')){
				$this->tiendaDireccion->from_array($_POST, $fields);
			}

			$estado = new Estado($estado_id);
			if(!$estado->result_count()) {
				show_error('Lo sentimos, el estado no existe', 500 );
			}
			$municipios = $this->municipio->where('estado_id',$estado_id)->order_by('titulo')->get();

			$municipio_id = $this->tiendaDireccion->municipio_id;

			$post_municipio_id = $this->input->post('municipio_id');
			if($post_municipio_id) {$municipio_id=$post_municipio_id;}

			if($municipio_id) {

				$colonias = $this->colonia->where('municipio_id',$municipio_id)->order_by('titulo')->get();
			}

		}



		$meta=array('titulo'=>'Mis Direcciones | Editar dirección','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view(
			'direccion/direccion_form',
			array(
				'id'        => $id,
				'direccion' => $this->tiendaDireccion,
				'estados'   => $estados,
				'municipios'=> $municipios,
				'colonias'=> $colonias,
				'meta'      => $meta,
				'titulo'=>$titulo)
			,true);
		$this->load->view('plantilla/default');
	}

	public function eliminar($id=0) {
		identificar();
		$usuario_id = $this->session->userdata('usuario_id');
		if($id) {
			$this->tiendaDireccion->where('id',$id)->where('usuario_id',$usuario_id)->get();
			if(!$this->tiendaDireccion->result_count()) {
				show_error('Lo sentimos, la dirección no existe', 500 );
			}
			$this->tiendaDireccion->delete();
		}
		$this->session->set_flashdata('mensaje', 'Se elimno la dirección seleccionada');
		redirect('tienda/direccion/listar');


	}

}
