<?php
class Chat_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('chat');
        $this->load->library('user_agent');
        if($this->agent->is_robot()){
            return false;
        }
    }
    
    function set_mensaje_off_line(){
        $this->load->library('form_validation');
        $proyecto=$this->config->item('proyecto');

        $datos=array();
        $datos['enviado']='';
        $datos['error']='';
        
        if($this->input->post('enviar')=='enviar+(@)'){   
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


            $dominio=str_replace("http://","", $this->input->post('dominio'));
            $dominio=str_replace("https://","", $dominio);
            $dominio=str_replace("www.","", $dominio);
            if(!in_array($dominio,array('paginasweb.mx','algaespirulina.mx','espirulina360.com','algaespirulina.com'))) return false;
            if($dominio=='paginasweb.mx') $proyecto['email_contacto']='soporte@paginasweb.mx';


            if($this->form_validation->run()){
                    $mensaje=$this->input->post('nombre'). ",se ha puesto en contacto y ha dicho: <br> ".$this->input->post('mensaje')."<br><br> ";
                    $asunto='Contacto Chat offline '.$this->input->post('nombre');
                    $config['mailtype']='html';
                    $config['wordwrap'] = FALSE;
                    $this->load->library('email');
                    $this->email->initialize($config);
                    $this->email->from($this->input->post('email'));
                    $this->email->to($proyecto['email_contacto']);
                    $this->email->subject($asunto);
                    $this->email->message($mensaje);
                    if ($this->email->send())
                    {
                        $datos['enviado']='Se envió correctamente su correo.';
                    }
            }else{
                 $datos['error']=validation_errors();
            }
        }
        print(json_encode($datos));
    } 

    function offline(){
        $this->load->view('offline');
    }

    /*Inserta la ventana del chat en la pagina*/
    function index()
    {
        $usuario=new Usuario();
        $conectados=$usuario->where('status_chat',1)->count();

        if(!$conectados){
            $this->offline();
            return;
        }

        if( $this->session->userdata('logged_user') ) return FALSE;
        $ip=$this->input->ip_address();
        if(!$ip) return false;

        if( substr($ip, 0,3)=='66.' )  return false;
        if( $ip=='187.189.245.183' )  return false;
        $data=@file_get_contents('http://ip-api.com/json/'.$ip);
        if($data){
            $location=json_decode($data);
            if( isset($location->as) && strstr($location->as,'Baidu') )
                return false;
        }

        $this->load->helper('string');
        $dominio=str_replace("http://","", $this->input->get('dominio'));
        $dominio=str_replace("https://","", $dominio);
        $dominio=str_replace("www.","", $dominio);
        if(!in_array($dominio,array('paginasweb.mx','algaespirulina.mx','espirulina360.com','algaespirulina.com'))) return false;


        if(!$this->session->userdata('chat')){
             $usermax=new Visitante();
             $usermax->select_max('id')->get();
             $user_chat=new Visitante();
             $user_chat->codigo=random_string('alnum', 15);
             $user_chat->ip=$ip;
             $user_chat->fecha=date('Y-m-d H:i:s');
             $user_chat->nombre="visitante_".($usermax->id+1);
             $user_chat->dominio=$dominio;
             $user_chat->location=$data;
             $user_chat->ultimo_movimiento=date('Y-m-d H:i:s');
             $user_chat->save();
             $this->session->set_userdata(array('chat'=>1,'user_chat_id'=>$user_chat->id));
             // $this->navegacion();
        }else{
             $user_chat=new Visitante($this->session->userdata('user_chat_id'));
             if(!$user_chat->id){
                $this->session->unset_userdata('chat');
                $this->session->unset_userdata('user_chat_id');
                return false;
             }
             $user_chat->dominio=$dominio;
             $user_chat->codigo='567';
             $user_chat->save();
        }
        /*Leer la pagina en la que se encuentra y registrarla en el historial de navegacion */
        $mensajes=new Mensaje();
        $total_mensajes=$mensajes->where(array('visitante_id'=>$this->session->userdata('user_chat_id'),'usuario <>'=>'sistema' ))->count();

        $this->load->view('index',array('total_mensajes'=>$total_mensajes));
    }

    /*Inserta el  mensaje del visitante en el chat*/
    function set_mensaje()
    {
        if(!$this->session->userdata('user_chat_id')){
            return false;
        }
        $visitante=new Visitante($this->session->userdata('user_chat_id'));
        $visitante->ultimo_movimiento=date('Y-m-d H:i:s');
        $visitante->skip_validation()->save();
        $mensaje=new Mensaje();
        $mensaje->visitante_id=$this->session->userdata('user_chat_id');
        $mensaje->fecha=date('Y-m-d H:i:s');
        $mensaje->usuario=$visitante->nombre;
        $mensaje->dominio=$visitante->dominio;
        $mensaje->mensaje=$this->input->post('mensaje', TRUE);
        $mensaje->save();
    }
    /*Conversacion mostrada en la ventana del chat*/
    function get_mensajes()
    {
        $mensajes=new Mensaje();
        $mensajes->where(array('visitante_id'=>$this->session->userdata('user_chat_id'),'usuario <>'=>'sistema' ))->order_by('id','desc')->get_iterated();
        $this->load->view('get_mensajes',array('mensajes'=>$mensajes));
    }

    /*Inserta en el chat la navegacion del usuario dentro del sitio*/
    function navegacion()
    {
        if(!$this->session->userdata('user_chat_id')) return false;
        $mensaje=new Mensaje();
        $visitante=new Visitante($this->session->userdata('user_chat_id'));
        $visitante->ultimo_movimiento=date('Y-m-d H:i:s');
        $visitante->codigo='123';
        $visitante->skip_validation()->save();
        $mensaje->visitante_id=$visitante->id;
        $mensaje->dominio=$visitante->dominio;
        $mensaje->fecha=date('Y-m-d H:i:s');
        $mensaje->usuario="sistema";
        $mensaje->mensaje="El usuario esta en: ".urldecode( $this->input->post('navegacion') );
        $mensaje->save();
    }

    /*Lista lateral de visitantes en el panel de administracion en el chat*/
    function lista_visitantes(){ 
         $mensajes_nuevos='';
         $visitantes_nuevos='';

         $this->acceso->valida('chat', 'consultar', 1);
         $this->load->model('usuario/usuario');
         $usuario=new Usuario($this->session->userdata('logged_user'));
         $visitantes=new Visitante();
         $total_visitantes=new Visitante();
         $last=new Visitante();
         $last->select_max('id')->get();
         $dominiosPermitidos=explode(",",$usuario->chat_dominios);
         $visitantes->where_in('dominio',$dominiosPermitidos);
         $visitantes->limit(100)->order_by('ultimo_movimiento','desc')->get();

         foreach ($visitantes as $visitante){
            $mensajes=new Mensaje();
            $total=$mensajes->where('leido','0')->where('usuario <>','sistema')->where('visitante_id',$visitante->id)->count();
            $navegando=$mensajes->where('leido','0')->where('usuario','sistema')->where('visitante_id',$visitante->id)->count();
            $mensajes->where('visitante_id',$visitante->id)->limit(1)->order_by('id','desc')->get();
            $visitante->navegando=$navegando;
            $visitante->mensajes=$total;
            if($total) $mensajes_nuevos=$mensajes_nuevos+$total;
            if($navegando) $visitantes_nuevos=$visitantes_nuevos+$navegando;
            // $visitante->ultimo_movimiento=$mensajes->fecha;
         } 

         $this->load->view('lista_visitantes',array('visitantes'=>$visitantes,'visitantes_nuevos'=>$visitantes_nuevos,'mensajes_nuevos'=>$mensajes_nuevos,'ultimo_visitante'=>$last->id));
    }

    /*COnversacion del chat en panel*/
    function conversacion(){
        if(!$this->input->get('conversacion')) return false;
         $this->acceso->valida('chat', 'consultar', 1);
         $mensajes_update=new Mensaje();
         $mensajes=new Mensaje();
         $mensajes->where('visitante_id',$this->input->get('conversacion'))->order_by('id','desc')->get_iterated();
         $mensajes_update->where('visitante_id',$this->input->get('conversacion'))->update('leido',1);
         
        $visitante=new Visitante();
        if($this->input->get('conversacion')){
            $visitante->where(array('id'=>$this->input->get('conversacion')))->get();
        }

         $this->load->view('conversacion',array('mensajes'=>$mensajes,'visitante'=>$visitante));
    }

    /*mensajes del usuarios administradores*/
    function status_moderador()
    {
        $usuario=new Usuario($this->session->userdata('logged_user'));
        $usuario->status_chat=0;
        $usuario->skip_validation()->save();
    }

    /*mensajes del usuarios administradores*/
    function set_mensaje_panel()
    {
        $this->acceso->valida('chat', 'editar', 1);
        if(substr($this->input->post('mensaje'),0,1)==":"){
            $respuesta=new Respuesta();
            $respuesta->get_by_snipet(substr($this->input->post('mensaje'),1));
            if($respuesta->exists()) $_POST['mensaje']=$respuesta->respuesta;
            else {
                return false;
            }
        }

        $usuario=new Usuario($this->session->userdata('logged_user'));
        $mensaje=new Mensaje();
        $mensaje->visitante_id=$this->input->post('conversacion');
        $mensaje->fecha=date('Y-m-d H:i:s');
        $mensaje->usuario=$usuario->nombre;
        $mensaje->mensaje=$this->input->post('mensaje');
        $mensaje->save();
    }

    /*Panel de administracion del chat*/
    function panel(){
        $this->titulo = 'Chat';
        $this->acceso->valida('chat', 'consultar', 1);
        $usuario=new Usuario($this->session->userdata('logged_user'));
        $usuario->status_chat=1;
        $usuario->skip_validation()->save();
        $this->layout_content = $this->load->view('panel',null,true);
        $this->load->view('plantilla/backend/form');
    }
}
