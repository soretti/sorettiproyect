<?php

class Flete_controller extends MX_Controller
{
	public $per_page=30;

	public function __construct()
	{
		parent::__construct();
    	$this->load->model('flete');
    	$this->acceso->carga_permisos('fletes');
    	$this->load->library('Image_fit');
	}

	// public function index(){
	// 	$this->cat_marca->where('imagen <>',"")->order_by('id','random')->limit(30)->get();
	// 	$this->load->view('catalogo/marcas/index',array('marcas'=>$this->cat_marca));
	// }

	public function _busqueda($catalogo)
	    {
	        $catalogo->clear();

	        $like_text=$this->session->userdata('fletes_buscar');

	        if($like_text){
	            $catalogo->group_start()
	                     ->or_like(array('titulo' => $like_text))
	                     ->group_end();
	        }
	    }

    public function _ordenar($catalogo)
    {
        if(!$this->session->userdata('fletes_ordenar'))
            $this->session->set_userdata('fletes_ordenar',array('id','DESC'));
        	$order=$this->session->userdata('fletes_ordenar');

        	$catalogo->order_by($order[0],$order[1]);
    }

	/**CRUD**/

	public function listar(){

	        $this->titulo='LISTA DE PAQUETERIAS';

	        $this->acceso->valida('fletes','consultar',1);

	        //buscar
	        if($this->input->post('action_buscar')){
	            $this->session->set_userdata('fletes_buscar',$this->input->post('buscar'));
	        }

	        //ordenar
	        if($this->input->post('ordenar')){
	            $order=$this->session->userdata('fletes_ordenar');
	            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
	                $this->session->set_userdata('fletes_ordenar',array($this->input->post('ordenar'),'DESC'));
	            else
	                $this->session->set_userdata('fletes_ordenar',array($this->input->post('ordenar'),'ASC'));
	        }

	        $catalogo=new Flete;
	        $this->_busqueda($catalogo);
	        $total_rows=$catalogo->count();
	        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
	        $limit=($pagina*$this->per_page);
	        $this->_busqueda($catalogo);
	        $this->_ordenar($catalogo);
	        $catalogo->limit($this->per_page, $limit)->order_by('id','desc')->get();

	        /*Paginador*/
	        $configuracion_paginador=$this->config->item('pagination');
	        $configuracion_paginador['base_url'] = base_url('modulo/flete/listar/');
	        $configuracion_paginador['total_rows'] = $total_rows;
	        $configuracion_paginador['per_page'] = $this->per_page;
	        $configuracion_paginador['uri_segment'] = 5;
	        $this->pagination->initialize($configuracion_paginador);
	        $this->layout_content=$this->load->view('tienda/flete/grid',array('marcas'=>$catalogo),true);
	        $this->load->view('plantilla/backend/form');

	    }



	    public function agregar(){
	        $this->titulo='AGREGAR PAQUETERÍA';
	        $this->acceso->valida('fletes','consultar',1);
	        $data['marca'] = new Flete();
	        $this->acceso->valida('fletes','editar',1);
	        $this->layout_content=$this->load->view('tienda/flete/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }


	    public function guardar($id=0){

	        $this->titulo = ($id) ? 'EDITAR PAQUETERÍA':'AGREGAR PAQUETERÍA';

	        if(!$_POST) show_error($this->lang->line('alert_request'));

	        $this->acceso->valida('fletes','editar',1);

	        $catalogo=new Flete($id);

	        $campos=array('titulo','imagen','url');
	        $catalogo->from_array($_POST, $campos);

	        if($catalogo->save()){
            		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            		redirect('modulo/tienda/flete/editar/'.$catalogo->id);
	        }else{
	            $data['marca']=$catalogo;
	            $this->layout_content=$this->load->view('tienda/flete/form',$data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    }

	    public function editar($id)
	    {
	        $this->titulo='EDITAR PAQUETERÍA';
	        $this->acceso->valida('fletes','consultar',1);
	        $data['marca']=new Flete($id);
	        $this->layout_content=$this->load->view('tienda/flete/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function eliminar()
	    {
	        $this->acceso->valida('fletes','eliminar',1);
	        $catalogo = new Flete();
	        $catalogo->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/tienda/flete/listar');
	    }
}
