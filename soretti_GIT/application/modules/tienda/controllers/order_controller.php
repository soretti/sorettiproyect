<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_controller extends MX_Controller {

	public function __construct() {
		parent::__construct();
		identificar();
	}

	public function listar() {
		$this->per_page=10;
		$this->load->model('order');

 		$order=new Order;
        $total_rows=$order->where('usuario_id',$this->session->userdata('usuario_id'))->where('estatus <>','0')->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $order->limit($this->per_page, $limit)->where('usuario_id',$this->session->userdata('usuario_id'))->where('estatus <>','0')->order_by('id','desc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('tienda/order/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);

		$meta=array('titulo'=>'MI CUENTA | Lista de ordenes','descripcion'=>'','palabras_clave'=>'');

		$this->layout_content = $this->load->view('order/order_list',
			array(
				'orders'=>$order,
				'meta' =>$meta, 
				'metodos_de_pago'  => $this->config->item('metodos_pago','proyecto'),
				'titulo'=>'Mis órdenes',
				'status_tienda'  => $this->config->item('status_tienda','proyecto'),

		),true);

		$this->load->view('plantilla/default');
	}

	public function ver($id) {
		$this->load->model('order');
		$this->load->model('item');
		$this->load->model('catalogo/cat_imagen');

		$this->order->where('id',$id)->where('usuario_id',$this->session->userdata('usuario_id'))->get();
		$this->order->item->get();

		$estatus=$this->config->item('status_tienda','proyecto');
		$titulo = "PEDIDO #".$this->order->id . " - " . $estatus[$this->order->estatus];

		$meta=array('titulo'=>'MI CUENTA2','descripcion'=>'','palabras_clave'=>'');

		$data_mail=$this->config->item('send_mail_tienda','proyecto');

 
		$this->layout_content = $this->load->view('order/order_view',array(
			'order'   => $this->order,
			'email'   => $data_mail['smtp_user'],
			'status_tienda'  => $estatus,
			'metodos_de_pago'  => $this->config->item('metodos_pago','proyecto'),
			'envio'   => json_decode($this->order->datos_envio),
			'factura' => json_decode($this->order->datos_factura),
			'pago'    => json_decode($this->order->datos_pago),
			'banco'   => json_decode($this->order->datos_banco),
			'meta'    => $meta,
			'titulo'  => $titulo
			),true);
		$this->load->view('plantilla/default');
	}


		public function printm($id) {
		$this->load->model('order');
		$this->load->model('item');
		$this->load->model('catalogo/cat_imagen');

		$this->order->where('id',$id)->where('usuario_id',$this->session->userdata('usuario_id'))->get();
		$this->order->item->get();

		$estatus=$this->config->item('status_tienda','proyecto');
		$titulo = "PEDIDO #".$this->order->id . " - " . $estatus[$this->order->estatus];

		$meta=array('titulo'=>'MI CUENTA2','descripcion'=>'','palabras_clave'=>'');

		$data_mail=$this->config->item('send_mail_tienda','proyecto');

 
		$this->layout_content = $this->load->view('order/order_view',array(
			'order'   => $this->order,
			'email'   => $data_mail['smtp_user'],
			'status_tienda'  => $estatus,
			'metodos_de_pago'  => $this->config->item('metodos_pago','proyecto'),
			'envio'   => json_decode($this->order->datos_envio),
			'factura' => json_decode($this->order->datos_factura),
			'pago'    => json_decode($this->order->datos_pago),
			'banco'   => json_decode($this->order->datos_banco),
			'meta'    => $meta,
			'titulo'  => $titulo
			),true);
		$this->load->view('plantilla/blank');
	}

}