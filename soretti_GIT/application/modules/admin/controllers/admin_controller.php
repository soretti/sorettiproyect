<?php  

class Admin_controller extends MX_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->acceso->carga_permisos('pagina');
        $this->acceso->carga_permisos('usuario');
        $this->acceso->carga_permisos('catalogo');
        $this->acceso->carga_permisos('tienda');
        $this->acceso->carga_permisos('boletin');        
        $this->acceso->carga_permisos('chat');        
        $this->acceso->carga_permisos('tienda');        
        $this->acceso->carga_permisos('orders');        
        $this->acceso->carga_permisos('fletes');        
        @session_start();
    }

    public function menu()
    {
        if($this->session->userdata('logged_in')){
            $this->load->view('admin/menu');
        }
        
    }

    public function index()
    {
        if(!$this->session->userdata('logged_in')){
            redirect(base_url('modulo/admin/login'),'refresh');
        }
        redirect(base_url());
    }

    public function login(){
                        
        $vals = array(
            //'word'   => 'Random word',
            'img_path'   => './pub/cap/',
            'img_url'    => base_url('pub/cap')."/",
            //'font_path'  => './pub/ARLRDBD.TTF',
            'img_width'  => '150',
            'img_height' => 40,
            'expiration' => 100
            );

        $cap = create_captcha($vals);
        
        $_SESSION['capt']=$cap['word'];
 
                      
        $this->load->view('admin/sesion',array('error'=>$this->session->flashdata('error'),'caption'=>$cap) );
    }

    public  function accesar(){
        $this->load->library('encrypt');
        
        $this->acceso->valida_token('acceso');     
        $this->load->model("usuario/usuario");
        $this->load->library('form_validation');
        $usuario=new Usuario();
        $error=array();
        if($this->input->post('email')=='') $error['email']='El campo email es obligatorio.';
        if($this->input->post('password')=='') $error['password']='El campo password es obligatorio.';
        if($this->input->post('captcha')=='') $error['captcha']='El código de seguridad es obligatorio.';

        if($this->input->post('captcha')!=$_SESSION['capt']) $error['captcha']='El código de seguridad es incorrecto.';

        $usuario->where( array('rol_id <>'=>'12','email'=>$this->input->post('email')) )->get();

        if($usuario->exists() && $usuario->id && !$error && $this->encrypt->decode($usuario->password) == $this->input->post('password')){
            $_SESSION['avances']=1;
            $this->session->set_userdata('logged_in',1);
            $this->session->set_userdata('logged_user',$usuario->id);
            $this->session->set_userdata('logged_name',$usuario->nombre);
            redirect(base_url('modulo/admin'));
        }
        else{
            if(!$error) 
                $error['login']='El usuario o password incorrecto.'; 
            
            $this->session->set_flashdata('error', $error);
            redirect(base_url('modulo/admin/login'));
        }

    }

    public function cerrar_sesion()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('logged_user');
        $this->session->unset_userdata('logged_name');
        $this->session->unset_userdata('avances');
        redirect(base_url());
    }
}