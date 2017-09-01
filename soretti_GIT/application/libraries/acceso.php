<?php
class Acceso
{
    private $CI;
    private $usuario;
    protected $configuracion;

	function __construct(){


		$this->CI=& get_instance();     
        $this->CI->load->model('usuario/usuario');
        $this->CI->load->model('usuario/permiso');
        $this->CI->load->model('usuario/acl');
        $this->usuario=new Usuario();
        if($this->CI->session->userdata('logged_user')) $this->usuario->get_by_id($this->CI->session->userdata('logged_user'));
        
	}

    function carga_permisos($permiso_acl)
    {
        if(!$this->usuario->id) 
            return FALSE;
        if(isset($this->configuracion[$permiso_acl])){
            return false;
        }
        $permiso=new Permiso();
        $permiso->select('id')->where('permiso',$permiso_acl)->get();
        $acl=new Acl();
        $acl->where( array('roles_id'=>$this->usuario->rol_id,'permisos_id'=>$permiso->id) )->get();
        $this->configuracion[$permiso_acl]= json_decode($acl->acl);
    }

    function valida_login($redirect=0)
    {
        if(!$this->usuario->id){
            if($redirect) redirect(base_url('modulo/admin'),'refresh');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function valida($permiso,$accion,$redirect=0)
    {  
        if(!$this->usuario->id){
            if($redirect) redirect(base_url('modulo/admin'),'refresh');
            return FALSE;
        } 
 
        if(isset($this->configuracion[$permiso]->$accion) && $this->configuracion[$permiso]->$accion==1 )
        {
            return TRUE;
        }
        else
        {
            //if($redirect) redirect(base_url('modulo/admin'),'refresh');
            if($redirect) show_error($this->CI->lang->line('alert_acl'));
            return FALSE;
        }
            
    }

    function set_token($ventana){
        $token = md5(uniqid(rand().$this->CI->config->item('encryption_key'),true));
        $this->CI->session->set_userdata('tools_token_'.$ventana,$token);
        return $token;
    }


    function valida_token($ventana)
    {
 
        if(! $this->CI->session->userdata('tools_token_'.$ventana) || !$this->CI->input->post('tools_token'))
        {
            show_error($this->CI->lang->line('alert_request'));
        }

        if($this->CI->session->userdata('tools_token_'.$ventana) != $this->CI->input->post('tools_token')){
            show_error($this->CI->lang->line('alert_request'));
        }
    }

}
