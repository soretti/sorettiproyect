<?php

class Cuenta_controller extends MX_Controller
{
	public $per_page=30;

	public function __construct()
	{
		parent::__construct();
    	$this->acceso->carga_permisos('boletin');
	}

	public function _busqueda($cuentas)
	    {
	        $cuentas->clear();

	        $like_text=$this->session->userdata('boletinCuentas_buscar');

	        if($like_text){
	            $cuentas->group_start()
	                     ->or_like(array('email' => $like_text))
	                     ->or_like(array('alias' => $like_text))
	                     ->group_end();
	        }
	    }

    public function _ordenar($cuentas)
    {
        if(!$this->session->userdata('boletinCuentas_ordenar'))
            $this->session->set_userdata('boletinCuentas_ordenar',array('id','DESC'));
        
        $order=$this->session->userdata('boletinCuentas_ordenar');
        $cuentas->order_by($order[0],$order[1]);
    }

	/**CRUD**/

	public function listar(){

	        $this->titulo='LISTA DE CUENTAS';
	        $this->acceso->valida('boletin','consultar',1);

	        //buscar
	        if($this->input->post('action_buscar')){
	            $this->session->set_userdata('boletinCuentas_buscar',$this->input->post('buscar'));
	        }

	        //ordenar
	        if($this->input->post('ordenar')){
	            $order=$this->session->userdata('boletinCuentas_ordenar');
	            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
	                $this->session->set_userdata('boletinCuentas_ordenar',array($this->input->post('ordenar'),'DESC'));
	            else
	                $this->session->set_userdata('boletinCuentas_ordenar',array($this->input->post('ordenar'),'ASC'));
	        }

	        $cuentas=new Cuentas;
	        $this->_busqueda($cuentas);
	        $total_rows=$cuentas->count();
	        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
	        $limit=($pagina*$this->per_page);
	        $this->_busqueda($cuentas);
	        $this->_ordenar($cuentas);
	        $cuentas->limit($this->per_page, $limit)->order_by('id','desc')->get();

	        /*Paginador*/
	        $configuracion_paginador=$this->config->item('pagination');
	        $configuracion_paginador['base_url'] = base_url('modulo/boletin/cuentas/listar/');
	        $configuracion_paginador['total_rows'] = $total_rows;
	        $configuracion_paginador['per_page'] = $this->per_page;
	        $configuracion_paginador['uri_segment'] = 5;
	        $this->pagination->initialize($configuracion_paginador);
	        $this->layout_content=$this->load->view('boletin/cuentas/grid',array('cuentas'=>$cuentas),true);
	        $this->load->view('plantilla/backend/form');
	    
	    }


	    public function agregar(){
	        $this->titulo='AGREGAR CUENTA';
	        $this->acceso->valida('boletin','consultar',1);
	        $data['cuenta'] = new Cuentas();
	        $this->acceso->valida('boletin','editar',1);
	        $this->layout_content=$this->load->view('boletin/cuentas/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }


	    public function guardar($id=0){
	    	$this->load->library('encrypt');
	        $this->titulo = ($id) ? 'EDITAR CUENTA':'AGREGAR CUENTA';

	        if(!$_POST) show_error($this->lang->line('alert_request'));
	        $this->acceso->valida('boletin','editar',1);
	        $cuenta=new Cuentas($id); 
	        $campos=array('email','host','password','alias','puerto','confirmar');

	        if($cuenta->id &&  !$this->input->post('cambiar_password')){
	            unset($campos[2]);
	          } 
        

	        $cuenta->from_array($_POST, $campos);

        if($cuenta->id &&  !$this->input->post('cambiar_password')) {
            $cuenta->validation['password']='';
            $cuenta->validation['confirmar']='';
        }

			$cuenta->validate();

        if($cuenta->valid){
        	
        	if( !$cuenta->id || $this->input->post('cambiar_password')) 
            $cuenta->password=$this->encrypt->encode($cuenta->password);

            $cuenta->save();

            		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            		redirect('modulo/boletin/cuenta/editar/'.$cuenta->id);
	        }else{
	            $data['cuenta']=$cuenta;
	            $this->layout_content=$this->load->view('boletin/cuentas/form',$data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    } 

	    public function editar($id)
	    {
	        $this->titulo='EDITAR CUENTA';
	        $this->acceso->valida('boletin','consultar',1);
	        $data['cuenta']=new Cuentas($id); 
	        $this->layout_content=$this->load->view('boletin/cuentas/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function eliminar()
	    {
	        $this->acceso->valida('boletin','eliminar',1);
	        $cuenta = new Cuentas();
	        $cuenta->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/boletin/cuentas/listar/');
	    }
}
