<?php

class Enconstruccion_controller extends MX_Controller
{
	protected $per_page=40;

	public function __construct()
    {
        parent::__construct();
         $this->acceso->carga_permisos('columna'); 
         $this->acceso->carga_permisos('pagina');
         $this->acceso->carga_permisos('textos');
         $this->load->model('pagina/pagina');
         $this->load->model('usuario/usuario');
    }

    public function index()
    {
        $this->load->library('form_validation');
        $proyecto=$this->config->item('proyecto');
        $error=''; 

        if($this->input->post('entrar'))
        {
            if(!$this->input->post('usuario')) $error.='El campo usuario es requerido<br>';
            if(!$this->input->post('contrasenna')) $error.='El campo contraseña es requerido<br>';
            if( $this->input->post('usuario') && $this->input->post('contrasenna') ){
                if($this->input->post('usuario')!=$proyecto['usuario'] || $this->input->post('contrasenna')!=$proyecto['password']) $error.='Usuario y/o constraseña no válidos<br>';
            }
            if(!$error)
            {
                $this->session->set_userdata('avances', '1');
                redirect(base_url());
            }
        }
 
        $this->load->view('enconstruccion',array('proyecto'=>$proyecto,'error'=>$error));
    }
}
