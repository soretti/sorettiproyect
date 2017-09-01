<?php

class Tipo_controller extends MX_Controller
{
    protected $per_page=40;

    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('chat');
    }

    public function _busqueda($paginas)
    {
        $paginas->clear();
        $like_text=$this->session->userdata('tipo_buscar');
        if($like_text){
            $paginas->group_start()
                     ->or_like(array('id'=>$like_text,'titulo'=>$like_text,'descripcion'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($paginas)
    {
        if(!$this->session->userdata('tipo_ordenar'))
            $this->session->set_userdata('tipo_ordenar',array('id','DESC'));
        $order=$this->session->userdata('tipo_ordenar');

        $paginas->order_by($order[0],$order[1]);
    }


    public function listar(){
        $this->titulo='CLASIFICACIÓN DE RESPUESTAS';
        $this->acceso->valida('chat','consultar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('tipo_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('tipo_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('tipo_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('tipo_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $paginas=new Tipo;
        $this->_busqueda($paginas);
        $total_rows=$paginas->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($paginas);
        $this->_ordenar($paginas);
        $paginas->limit($this->per_page, $limit)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/chat/tipo/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('chat/tipo/grid',array('paginas'=>$paginas),true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar()
    {
        $this->acceso->valida('chat','consultar',1);
        $categoria=new Tipo();
        $this->titulo = 'AGREGAR CLASIFICACIÓN DE RESPUESTA';
        $this->layout_content =  $this->load->view('chat/tipo/form',array('categoria'=>$categoria),TRUE);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id)
    {
        $this->acceso->valida('chat','consultar',1);
        $categoria=new Tipo($id);
        $this->titulo = 'EDITAR CLASIFICACIÓN DE RESPUESTAS';
        $this->layout_content =  $this->load->view('chat/tipo/form',array('categoria'=>$categoria),TRUE);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($id=0)
    {
         $this->titulo= ($id) ? "EDITAR CLASIFICACIÓN DE RESPUESTAS" : 'AGREGAR CLASIFICACIÓN DE RESPUESTAS';

        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('chat','editar',1);

        $categoria=new Tipo($id);

        $rel = $categoria->from_array($_POST, array( 'titulo','descripcion'));

        if($categoria->save($rel)){
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/chat/tipo/editar/'.$categoria->id);
        }else{
            $data['categoria'] = $categoria;
            $this->layout_content = $this->load->view('chat/tipo/form', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }


    public function eliminar()
    {
        $this->acceso->valida('chat','eliminar',1);
        $bloque = new Tipo();
        $bloque->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/chat/tipo/listar');
    }

}
