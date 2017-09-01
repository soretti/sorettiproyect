<?php

class Cupon_controller extends MX_Controller
{
	public $per_page=30;

	public function __construct()
	{
		parent::__construct();
    	$this->load->model('usuario/usuario');
    	$this->load->model('tienda/cupon');
    	$this->acceso->carga_permisos('tienda');
	}

	public function _busqueda($catalogo)
	    {
	        $catalogo->clear();

	        $like_text=$this->session->userdata('cupon_buscar');

	        if($like_text){
	            $catalogo->group_start()
	                     ->or_like(array('titulo' => $like_text))
	                     ->group_end();
	        }
	    }

    public function _ordenar($catalogo)
    {
        if(!$this->session->userdata('cupon_ordenar'))
            $this->session->set_userdata('cupon_ordenar',array('id','DESC'));
        	$order=$this->session->userdata('cupon_ordenar');
        	$catalogo->order_by($order[0],$order[1]);
    }

	/**CRUD**/

	public function listar(){

	        $this->titulo='LISTA DE CUPONES';

	        $this->acceso->valida('tienda','consultar',1);

	        //buscar
	        if($this->input->post('action_buscar')){
	            $this->session->set_userdata('cupon_buscar',$this->input->post('buscar'));
	        }

	        //ordenar
	        if($this->input->post('ordenar')){
	            $order=$this->session->userdata('cupon_ordenar');
	            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
	                $this->session->set_userdata('cupon_ordenar',array($this->input->post('ordenar'),'DESC'));
	            else
	                $this->session->set_userdata('cupon_ordenar',array($this->input->post('ordenar'),'ASC'));
	        }

	        $catalogo=new Cupon;
	        $this->_busqueda($catalogo);
	        $total_rows=$catalogo->count();
	        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
	        $limit=($pagina*$this->per_page);
	        $this->_busqueda($catalogo);
	        $this->_ordenar($catalogo);
	        $catalogo->limit($this->per_page, $limit)->order_by('id','desc')->get();

	        /*Paginador*/
	        $configuracion_paginador=$this->config->item('pagination');
	        $configuracion_paginador['base_url'] = base_url('modulo/cupon/listar/');
	        $configuracion_paginador['total_rows'] = $total_rows;
	        $configuracion_paginador['per_page'] = $this->per_page;
	        $configuracion_paginador['uri_segment'] = 5;
	        $this->pagination->initialize($configuracion_paginador);
	        $this->layout_content=$this->load->view('tienda/cupon/grid',array('marcas'=>$catalogo),true);
	        $this->load->view('plantilla/backend/form');

	    }
	    public function generar_cupon(){
	        $this->acceso->valida('tienda','consultar',1);

	    	$this->load->helper('string');
	    	$cupon_string=strtoupper(random_string('alnum',6));
	    	$cupon_valido=1;

	    	while ($cupon_valido==1) {
	    		$cupon=new Cupon();
	    		$total_cupon=$cupon->where('cupon', $cupon_string)->count();
	    		if($total_cupon) {
	    				$cupon_string=strtoupper(random_string('alnum',6));
	    		}
	    		else {
	    			$cupon_valido=0;
	    		}
	    	}

	    	echo $cupon_string;
	    }


	    public function agregar(){
	        $this->titulo='AGREGAR CUPON';
	        $this->acceso->valida('tienda','consultar',1);
	        $data['cupon'] = new Cupon();
	        $this->acceso->valida('tienda','editar',1);
	        $this->layout_content=$this->load->view('tienda/cupon/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }


	    public function guardar($id=0){

	        $this->titulo = ($id) ? 'EDITAR CUPON':'AGREGAR CUPON';

	        if(!$_POST) show_error($this->lang->line('alert_request'));

	        $this->acceso->valida('tienda','editar',1);

	        $catalogo=new Cupon($id);

	        $campos=array('cupon','fecha_activacion','fecha_desactivacion','descuento','tipo_descuento','compra_minima','uso');
	        $catalogo->from_array($_POST, $campos);

	        if($catalogo->save()){
            		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            		redirect('modulo/tienda/cupon/editar/'.$catalogo->id);
	        }else{
	            $data['cupon']=$catalogo;
	            $this->layout_content=$this->load->view('tienda/cupon/form',$data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    }

	    public function editar($id)
	    {
	        $this->titulo='EDITAR CUPON';
	        $this->acceso->valida('tienda','consultar',1);
	        $data['cupon']=new Cupon($id);
	        $this->layout_content=$this->load->view('tienda/cupon/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function eliminar()
	    {
	    	$this->load->model('usuario');
	        $this->acceso->valida('tienda','eliminar',1);
	        $catalogo = new Cupon();
	        $catalogo->where_in('id', $this->input->post('post_ids'))->update(array('is_enable'=>0));
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/tienda/cupon/listar');
	    }
	    public function activar()
	    {
	    	$this->load->model('usuario');
	        $this->acceso->valida('tienda','eliminar',1);
	        $catalogo = new Cupon();
	        $catalogo->where_in('id', $this->input->post('post_ids'))->update(array('is_enable'=>1));
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/tienda/cupon/listar');
	    }
}
