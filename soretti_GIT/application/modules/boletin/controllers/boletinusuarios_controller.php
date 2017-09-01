<?php  
class Boletinusuarios_controller extends MX_Controller
{
    protected $per_page=40;

    public function __construct(){
        parent::__construct();
        $this->load->model('rol/rol');
        $this->acceso->carga_permisos('boletin');
    }

    public function index()
    {
        $this->titulo='AGREGAR SUSCRIPTOR';
        $usuario=new Boletin_Usuarios();
        $grupos=new Grupos();
        $grupos->where('is_enable',1)->order_by('nombre asc')->get();
        $this->load->view('usuarios/frontend',array('usuario'=>$usuario,'grupos'=>$grupos));
    }

    public function agregar()
    {
        $this->titulo='AGREGAR SUSCRIPTOR';
        $this->acceso->valida('boletin','consultar',1);
        $usuario=new Boletin_Usuarios();
        $grupos=new Grupos();
        $grupos->where('is_enable',1)->order_by('nombre asc')->get();
        /*$grupos->check_last_query();*/
        $this->layout_content=$this->load->view('usuarios/form',array('usuario'=>$usuario,'grupos'=>$grupos),true);
        $this->load->view('plantilla/backend/form');
    }

    public function guardarsuscriptor(){

        if( $this->input->post('mnewsletter')!='TRS6745-*1')
            show_error('Datos incorrectos');

         if($this->input->post('email_field')!='')
            show_error('Datos incorrectos');

        $usuario=new Boletin_Usuarios();

        $grupos=new Grupos();
        $grupos->order_by('nombre asc')->get(); 

        $campos=array('nombre','grupos','apellidoPaterno','apellidoMaterno','email','privacidad');
       
        $rel = $usuario->from_array($_POST, $campos);

        if($usuario->grupos)
        $usuario->grupos = implode(",",$usuario->grupos);

        $reeinscribir = new Boletin_Usuarios();
        $reeinscribir->get_by_email($this->input->post('email'));
        if($reeinscribir->exists()){
            $reeinscribir->from_array($_POST, $campos);
            $reeinscribir->unsuscribed=1;
            $reeinscribir->save();
            redirect('modulo/boletin/boletinusuarios/index');
        }

        $usuario->validate();

        if($usuario->valid){
            $usuario->save($rel);
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/boletin/boletinusuarios/index');
        }else{
            $this->load->view('usuarios/frontend',array('usuario'=>$usuario,'grupos'=>$grupos));
        }
    }

    public function guardar($id=0){

        $this->titulo = ($id) ? 'EDITAR SUSCRIPTOR' : $this->titulo='AGREGAR SUSCRIPTOR';
        $this->acceso->valida('boletin','editar',1);

        $usuario=new Boletin_Usuarios($id);
        $grupos=new Grupos();
        $grupos->order_by('nombre asc')->get(); 

        $campos=array('nombre','grupos','apellidoPaterno','apellidoMaterno','email');
       
        $rel = $usuario->from_array($_POST, $campos);

        $usuario->grupos = ($usuario->grupos) ? implode(",",$usuario->grupos) : '';
        $usuario->privacidad=1;
        $usuario->validate();

        if($usuario->valid){
            $usuario->save($rel);
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/boletin/boletinusuarios/editar/'.$usuario->id);
        }else{
            $this->layout_content=$this->load->view('usuarios/form',array('usuario'=>$usuario,'grupos'=>$grupos),true);
            $this->load->view('plantilla/backend/form');
        }
    }


    public function eliminar()
    {
        $this->acceso->valida('boletin','eliminar',1);
        $cuenta = new Boletin_Usuarios();
        $cuenta->where_in('id', $this->input->post('post_ids') )->get()->delete_all();
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/boletin/lista');
    }

    public function editar($id=0){
        $this->titulo='EDITAR SUSCRIPTOR';
        $this->acceso->valida('boletin','consultar',1);
        $usuario=new  Boletin_Usuarios($id);
        if(!$usuario->id) show_error($this->lang->line('alert_not_found_row'));
        $grupos=new Grupos();
        $grupos->where('is_enable',1)->order_by('nombre asc')->get();  
        $this->layout_content=$this->load->view('usuarios/form',array('usuario'=>$usuario,'grupos'=>$grupos),true);
        $this->load->view('plantilla/backend/form');
    }

    public function _busqueda($usuario)
    {
        $usuario->clear();
        $like_text=$this->session->userdata('boletinusuarios_buscar');
    
        if($like_text){
            $usuario->group_start()
                     ->or_like(array('id'=>$like_text,'nombre'=>$like_text,'apellidoPaterno'=>$like_text,'apellidoMaterno'=>$like_text,'email'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($usuario)
    {
        if(!$this->session->userdata('boletinusuarios_ordenar'))
            $this->session->set_userdata('boletinusuarios_ordenar',array('id','DESC'));
        $order=$this->session->userdata('boletinusuarios_ordenar');
 
 
            $usuario->order_by($order[0],$order[1]);
    }  
      

    public function lista()
    {

        $this->titulo='LISTA DE USUARIOS';
        $this->acceso->valida('boletin','consultar',1);
        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('boletinusuarios_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('boletinusuarios_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('boletinusuarios_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('boletinusuarios_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $usuario=new Boletin_Usuarios;
        $this->_busqueda($usuario);
        $total_rows=$usuario->where('is_enable',1)->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($usuario);
        $this->_ordenar($usuario);
        $usuario->limit($this->per_page, $limit)->where('is_enable',1)->get();
        foreach ($usuario as $key => $value) {
            $grupos = new Grupos();
            $grupos->select("Group_concat(nombre) as nombregrupo")->where_in('id', explode(",",$value->grupos))->where("is_enable",1)->get();
            $value->grupos = $grupos->nombregrupo;
        }
        
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/boletin/boletinusuarios/lista');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('usuarios/grid',array('usuarios'=>$usuario),true);

        $this->load->view('plantilla/backend/form');
    }

}