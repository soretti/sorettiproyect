<?php
class Usuario_controller extends MX_Controller
{
    protected $per_page=40;

	public function __construct(){
            parent::__construct();
            $this->load->model('rol/rol');
            $this->acceso->carga_permisos('usuario');
    }

    public function agregar()
    {
        $this->titulo='AGREGAR USUARIO';
        $this->acceso->valida('usuario','consultar',1);
        $usuario=new Usuario();
        $roles=new Rol();
        $roles->where('is_enable',1)->order_by('nombre asc')->get();
        $this->layout_content=$this->load->view('usuario/form',array('usuario'=>$usuario,'roles'=>$roles),true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id=0){
        $this->titulo='EDITAR USUARIO';
        $this->acceso->valida('usuario','consultar',1);
        $usuario=new  Usuario($id);
        $usuario->chat_dominios=explode(",",$usuario->chat_dominios);
        if(!$usuario->id) show_error($this->lang->line('alert_not_found_row'));
        $roles=new Rol();
        $roles->where('is_enable',1)->order_by('nombre asc')->get();
        $this->layout_content=$this->load->view('usuario/form',array('usuario'=>$usuario,'roles'=>$roles),true);
        $this->load->view('plantilla/backend/form');
    }

    public function guardar($id=0){

        $this->load->library('encrypt');

        $this->titulo = ($id) ? 'EDITAR USUARIO' : $this->titulo='AGREGAR USUARIO';
        $this->acceso->valida('usuario','editar',1);

        $usuario=new Usuario($id);
        $roles=new Rol();
        $roles->order_by('nombre asc')->get();

        $campos=array('nombre','rol_id','apellidoPaterno','apellidoMaterno','email','password','confirmar');
        if($usuario->id &&  !$this->input->post('cambiar_password')){
            unset($campos[5]);
        }
        $rel = $usuario->from_array($_POST, $campos);

        if($usuario->id &&  !$this->input->post('cambiar_password')) {
            $usuario->validation['password']='';
            $usuario->validation['confirmar']='';
        }

        $usuario->validate();

        if($usuario->valid){
            if( !$usuario->id || $this->input->post('cambiar_password'))
                 $usuario->password=$this->encrypt->encode($usuario->password);
                 if(is_array($this->input->post('dominios'))) $usuario->chat_dominios=implode(",",$this->input->post('dominios'));
            $usuario->save($rel);
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/usuario/editar/'.$usuario->id);
        }else{
            $usuario->rol_id=$this->input->post('rol_id');
            $this->layout_content=$this->load->view('usuario/form',array('usuario'=>$usuario,'roles'=>$roles),true);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function eliminar(){
         $this->acceso->valida('usuario','eliminar',1);
         $usuario=new Usuario();
         $usuario->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
         $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
         redirect('modulo/usuario/lista/');
    }

    public function _busqueda($usuario)
    {
        $usuario->clear();
        $like_text=$this->session->userdata('usuario_buscar');

        if($like_text){
            $usuario->group_start()
                     ->or_like(array('id'=>$like_text,'nombre'=>$like_text,'apellidoPaterno'=>$like_text,'apellidoMaterno'=>$like_text,'email'=>$like_text))
                     ->or_like_related_rol('nombre',$like_text)
                     ->group_end();
        }
    }

    public function _ordenar($usuario)
    {
        if(!$this->session->userdata('usuario_ordenar'))
            $this->session->set_userdata('usuario_ordenar',array('id','DESC'));
        $order=$this->session->userdata('usuario_ordenar');

        if($order[0]=='rol')
            $usuario->order_by_related_rol('nombre',$order[1]);
        else
            $usuario->order_by($order[0],$order[1]);
    }


    public function lista()
    {
        $this->titulo='LISTA DE USUARIOS';
        $this->acceso->valida('usuario','consultar',1);
        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('usuario_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('usuario_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('usuario_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('usuario_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $usuario=new Usuario;
        $this->_busqueda($usuario);
        $total_rows=$usuario->where("rol_id !=",12)->where('is_enable',1)->count();
        //$total_rows=$usuario->where('is_enable',1)->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($usuario);
        $this->_ordenar($usuario);
        $usuario->where("rol_id !=",12)->limit($this->per_page, $limit)->where('is_enable',1)->get();
        //$usuario->limit($this->per_page, $limit)->where('is_enable',1)->get();

        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/usuario/lista');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('usuario/grid',array('usuarios'=>$usuario),true);

        $this->load->view('plantilla/backend/form');
    }

}
