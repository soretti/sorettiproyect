<?php

class Proveedor_controller extends MX_Controller
{
	public $per_page=30;

	public function __construct()
	{
		parent::__construct();
    	$this->load->model('catalogo/proveedor');
    	$this->acceso->carga_permisos('catalogo');
    	$this->load->library('Image_fit');
	}


	public function _busqueda($proveedor)
	    {
	        $proveedor->clear();

	        $like_text=$this->session->userdata('proveedor_buscar');

	        if($like_text){
	            $proveedor->group_start()
	                     ->or_like(array('titulo' => $like_text, 'descripcion' => $like_text))
	                     ->group_end();
	        }
	    }

    public function _ordenar($proveedor)
    {
        if(!$this->session->userdata('proveedor_ordenar'))
            $this->session->set_userdata('proveedor_ordenar',array('id','DESC'));
        	$order=$this->session->userdata('proveedor_ordenar');
        	$proveedor->order_by($order[0],$order[1]);
    }

	/**CRUD**/

	public function listar(){

	        $this->titulo='LISTA DE PROVEEDORES';

	        $this->acceso->valida('catalogo','consultar',1);

	        //buscar
	        if($this->input->post('action_buscar')){
	            $this->session->set_userdata('proveedor_buscar',$this->input->post('buscar'));
	        }

	        //ordenar
	        if($this->input->post('ordenar')){
	            $order=$this->session->userdata('proveedor_ordenar');
	            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
	                $this->session->set_userdata('proveedor_ordenar',array($this->input->post('ordenar'),'DESC'));
	            else
	                $this->session->set_userdata('proveedor_ordenar',array($this->input->post('ordenar'),'ASC'));
	        }

	        $proveedor=new Proveedor;
	        $this->_busqueda($proveedor);
	        $total_rows=$proveedor->count();
	        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
	        $limit=($pagina*$this->per_page);
	        $this->_busqueda($proveedor);
	        $this->_ordenar($proveedor);
	        $proveedor->limit($this->per_page, $limit)->order_by('id','desc')->get();

	        /*Paginador*/
	        $configuracion_paginador=$this->config->item('pagination');
	        $configuracion_paginador['base_url'] = base_url('modulo/catalogo/proveedor/listar/');
	        $configuracion_paginador['total_rows'] = $total_rows;
	        $configuracion_paginador['per_page'] = $this->per_page;
	        $configuracion_paginador['uri_segment'] = 5;
	        $this->pagination->initialize($configuracion_paginador);
	        $this->layout_content=$this->load->view('catalogo/proveedores/grid',array('proveedores'=>$proveedor),true);
	        $this->load->view('plantilla/backend/form');

	    }



	    public function agregar(){
	        $this->titulo='AGREGAR PROVEEDOR';
	        $this->acceso->valida('catalogo','consultar',1);
	        $data['proveedor'] = new Proveedor();
	        $this->acceso->valida('catalogo','editar',1);
	        $this->layout_content=$this->load->view('catalogo/proveedores/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }


	    public function guardar($id=0){

	        $this->titulo = ($id) ? 'EDITAR PROVEEDOR':'AGREGAR PROVEEDOR';

	        if(!$_POST) show_error($this->lang->line('alert_request'));

	        $this->acceso->valida('catalogo','editar',1);

	        $proveedor=new Proveedor($id);

	        $campos=array('titulo','descripcion');
	        $proveedor->from_array($_POST, $campos);

	        if($proveedor->save()){
            		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            		redirect('modulo/catalogo/proveedor/editar/'.$proveedor->id);
	        }else{
	            $data['proveedor']=$proveedor;
	            $this->layout_content=$this->load->view('catalogo/proveedores/form',$data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    }

	    public function editar($id)
	    {
	        $this->titulo='EDITAR PROVEEDOR';
	        $this->acceso->valida('catalogo','consultar',1);
	        $data['proveedor']=new Proveedor($id);
	        $this->layout_content=$this->load->view('catalogo/proveedores/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function eliminar()
	    {
	        $this->acceso->valida('catalogo','eliminar',1);
	        $proveedor = new Proveedor();
	        $proveedor->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/catalogo/proveedor/listar/');
	    }
}
