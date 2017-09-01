<?php
class Grupos_controller extends MX_Controller
{
    protected $per_page=30;

	public function __construct()
    {
        parent::__construct();
         $this->load->model('boletin/grupos');
         $this->acceso->carga_permisos('boletin');
    }



    public function agregar(){
            $this->titulo='AGREGAR GRUPOS';
            $this->acceso->valida('boletin','consultar',1);
            $data['grupo'] = new grupos();
            $this->acceso->valida('boletin','editar',1);
            $this->layout_content=$this->load->view('boletin/grupo/formgrupos',$data,true);
            $this->load->view('plantilla/backend/form');
        }

   public function editar($id)
        {
            $this->titulo='EDITAR GRUPO';
            $this->acceso->valida('boletin','consultar',1);
            $data['grupo']=new grupos($id);
            $this->layout_content=$this->load->view('boletin/grupo/formgrupos',$data,true);
            $this->load->view('plantilla/backend/form');
        }

        public function eliminar()
        {
            $this->acceso->valida('boletin','eliminar',1);
            $catalogo = new grupos();
            $catalogo->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/boletin/grupos/listar/');
        }
     public function guardar($id=0){

            $this->titulo = ($id) ? 'EDITAR GRUPO':'AGREGAR GRUPO';

            if(!$_POST) show_error($this->lang->line('alert_request'));

            $this->acceso->valida('boletin','editar',1);

            $grupo=new grupos($id);

            $campos=array('nombre');
            $grupo->from_array($_POST, $campos);

            if($grupo->save()){
                    $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
                    redirect('modulo/boletin/grupos/editar/'.$grupo->id);
            }else{
                $data['grupo']=$grupo;
                $this->layout_content=$this->load->view('boletin/grupo/formgrupos',$data,true);
                $this->load->view('plantilla/backend/form');
            }
        }



     public function _busqueda($grupos)
    {
        $grupos->clear();
        $like_text=$this->session->userdata('grupos_buscar');
        if($like_text){
            $grupos->group_start()
                     ->or_like(array('id'=>$like_text,'nombre'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($grupos)
    {
        if(!$this->session->userdata('grupos_ordenar'))
            $this->session->set_userdata('grupos_ordenar',array('id','DESC'));
        $order=$this->session->userdata('grupos_ordenar');

        $grupos->order_by($order[0],$order[1]);
    }

    public function listar(){
        $this->titulo='GRUPOS';
        $this->acceso->valida('boletin','editar',1);

        //buscar
        if($this->input->post('action_buscar')){  
            $this->session->set_userdata('grupos_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('grupos_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('grupos_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('grupos_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $grupos=new grupos;
        $this->_busqueda($grupos);
        $total_rows=$grupos->where('is_enable',1)->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($grupos);
        $this->_ordenar($grupos);
        $grupos->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/boletin/boletincategoria/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('boletin/grupo/gridgrupos',array('grupos'=>$grupos),true);
        $this->load->view('plantilla/backend/form');
    }
}
