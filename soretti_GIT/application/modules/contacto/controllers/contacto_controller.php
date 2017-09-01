<?php
class Contacto_controller extends MX_Controller
{

  protected $per_page=40;
  public $CI;

    public function __construct()
    {
         parent::__construct();
         $this->acceso->carga_permisos('contacto');
         $this->acceso->carga_permisos('pagina');
         $this->load->model('pagina/pagina');
    }

    public function index()
    {
       
        $proyecto=$this->config->item('proyecto');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('privacidad', 'Privacidad', 'required');
        $this->form_validation->set_rules('nombre', $this->lang->line('nombre'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lada','Lada', 'trim|required|xss_clean');
        $this->form_validation->set_rules('telefono','Teléfono', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('correo'), 'required|valid_email');
        //$this->form_validation->set_rules('email', "Correo", 'required|trim|valid_email|matches[confirmar_email]|xss_clean|strip_tags');
        //$this->form_validation->set_rules('confirmar_email', "Confirmar correo", 'required|trim');
        $this->form_validation->set_rules('area_desarrollo','Área de desarrollo profesional', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('texto','Información de su comentario', 'required|xss_clean');

        $datos['enviado']='';

        if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run())
        {
            if($this->input->post('email_field')!='')
            {
                return false;
            }

            $config['mailtype']='html';
            $config['wordwrap'] = FALSE;
            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from($_POST['email']);
            $this->email->to($proyecto['email_contacto']);

            $this->email->subject($proyecto['titulo'].' | Contacto');
            $mensaje="Nombre: ".$_POST['nombre']."<br>";
            $mensaje.="Apellido paterno: ".$_POST['apellido_paterno']."<br>";
            $mensaje.="Apellido materno: ".$_POST['apellido_materno']."<br>";
            $mensaje.="Teléfono: ".$_POST['lada']." ".$_POST['telefono']."<br>";
            $mensaje.="E-mail: ".$_POST['email']."<br>";
            $mensaje.="Area de desarrollo: ".$_POST['area_desarrollo']."<br>";
            $mensaje.="Mensaje: <br>".$_POST['texto']."<br>";
            
            $this->email->message($mensaje);

            /*Agregar al boletin*/
            if($this->input->post('boletin')){
                $boletin_usuario = new boletin_usuarios;
                $boletin_usuario->get_by_email($this->input->post('email'));
                if(!$boletin_usuario->exists()){
                    $boletin_usuario->email=$this->input->post('email');
                    $boletin_usuario->nombre=$this->input->post('nombre');
                    $boletin_usuario->grupos=implode(",",$this->input->post('grupos'));
                    $boletin_usuario->skip_validation()->save();

                    /*Inscribirlo a send_blaster*/
                    $send_blaster=$this->config->item('send_blaster','proyecto');
                    if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Subscribe','','From: '.$boletin_usuario->email);
                }
            }


            if ($this->email->send())
            {
                $contacto=new Contacto;
                if($contacto->from_array($_POST,'',TRUE))
                $datos['enviado']=$this->lang->line('enviado');
                unset($_POST);
            }
        }

        /*Datos para el meta*/
        $pagina=modules::run('pagina/_get_pagina',2);
        $datos['meta']=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $datos['pagina']=$pagina;

        $this->layout_content = $this->load->view('contacto/contacto',$datos,true);
        $this->load->view('plantilla/default');
    }

    public function areas_especialidad()
    {
        $proyecto=$this->config->item('proyecto');
        
        $areas = $this->db->query("SELECT metatitulo FROM paginas WHERE bloquecontenido_id=".$_POST['especialidad_id']." AND tipo=1 AND is_enable=1 ORDER BY metatitulo ASC")->result();

        echo "<option value=''>Especialidad *</option>";

        foreach ($areas as $key => $value) {
        	//if($this->input->post('especialidad')==$value->metatitulo){ $res='selected'};
        	echo "<option value='".$value->metatitulo."'>".$value->metatitulo."</option>";
        }
        exit();
    }


    public function catpais(){

        $this->load->library("Nusoap_lib");
        $oSoapClient = new nusoap_client('http://wsenlaceit.azurewebsites.net/WebEnlaceIT.asmx?wsdl', true); 
        $parametros = array( 'CatPais' => 'XXXX');
        $oSoapClient->loadWSDL(); 
        $respuesta = $oSoapClient->call("CatPais"); 
        if ($oSoapClient->fault) { // Si 
                echo 'No se pudo completar la operación '.$oSoapClient->getError(); 
                // die(); 
        } else { // No 
                $sError = $oSoapClient->getError(); 
               if ($sError) {  
                        echo 'Error!:'.$sError; 
                } 
        } 
        
        $aray = explode(",", $respuesta["CatPaisResult"]);
        echo "<option value='pais'>País *</option>"; 
        foreach($aray as $dat){
            $aray1 = explode(":", $dat);

            if($_POST['pais_id']==$aray1[0]) {
                echo '<option value="'.$aray1[0].'" selected>'.(utf8_encode($aray1[1])).'</option>';
            }else{
                echo '<option value="'.$aray1[0].'">'.(utf8_encode($aray1[1])).'</option>';
            }
        }

        exit();
 
	}


	function catestado(){
 
        $this->load->library("Nusoap_lib");
        $oSoapClient = new nusoap_client('http://wsenlaceit.azurewebsites.net/WebEnlaceIT.asmx?wsdl', true);
        $parametros = array( 'CatPais' => $_POST['idcatpais']); 
        $oSoapClient->loadWSDL(); 
        $respuesta = $oSoapClient->call("CatEstado",$parametros); 
        if ($oSoapClient->fault) { // Si 
                echo 'No se pudo completar la operación '.$oSoapClient->getError(); 
                // die(); 
        } else { // No 
                $sError = $oSoapClient->getError(); 
               if ($sError) {  
                        echo 'Error!:'.$sError; 
                } 
        } 
        
        $aray = explode(",", $respuesta["CatEstadoResult"]);
        echo "<option value='estado'>Estado: *</option>";
        foreach($aray as $dat){
            $aray1 = explode(":", $dat);

            if($_POST['estado_id']==$aray1[0]) {
                echo '<option value="'.$aray1[0].'" selected>'.(utf8_encode($aray1[1])).'</option>';
            }else{
                echo '<option value="'.$aray1[0].'">'.(utf8_encode($aray1[1])).'</option>';
            }
        }

        exit();
 
	}

    public function catmunicipio(){
        $this->load->library("Nusoap_lib"); 
        $oSoapClient = new nusoap_client('http://wsenlaceit.azurewebsites.net/WebEnlaceIT.asmx?wsdl', true); 
        $parametros = array( 'CatEstado' => $_POST['idcatestado']); 
        $oSoapClient->loadWSDL(); 
        $respuesta = $oSoapClient->call("CatMunicipio",$parametros); 
        if ($oSoapClient->fault) { // Si 
                echo 'No se pudo completar la operación '.$oSoapClient->getError(); 
                // die(); 
        } else { // No 
                $sError = $oSoapClient->getError(); 
               if ($sError) {  
                        echo 'Error!:'.$sError; 
                } 
        } 
        
        $aray = explode(",", $respuesta["CatMunicipioResult"]);
        echo "<option value='municipio'>Delegación / Municipio: *</option>";
        foreach($aray as $dat){
            $aray1 = explode(":", $dat);
            echo '<option value="'.$aray1[0].'">'.(utf8_encode($aray1[1])).'</option>';
        }

        exit();
    }

    public function registro_profesionales()
    {

        $proyecto=$this->config->item('proyecto');
        $error=array();
        $datos=array();
        $datos['enviado']='';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('privacidad', 'Privacidad', 'required');
        $this->form_validation->set_rules('nombre','Nombre', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('apellido_paterno','Apellido paterno', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('apellido_materno','Apellido Materno', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('genero','Genero', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('fecha_nacimiento','Fecha de nacimiento', 'required|xss_clean|strip_tags');

        $this->form_validation->set_rules('telefono','Teléfono', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('celular','Celular', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('pais','País', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('estado','Estado', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('municipio','Municipio', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('colonia','Colonia', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('cp','Codigo Postal', 'required|xss_clean|strip_tags');

        $this->form_validation->set_rules('desarrollo_profesional','Área de desarrollo profesional', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('especialidad','Especialidad', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('email', "Correo", 'required|trim|valid_email|matches[confirmar_email]|xss_clean|strip_tags');
        $this->form_validation->set_rules('confirmar_email', "Confirmar correo", 'required|trim');

        $config['upload_path'] = 'pub/documentos';
        $config['allowed_types'] = 'doc|docx|xls|ppt|txt|pdf';
        $config['max_size'] = '2048';

        $this->load->library('upload', $config);
        if($this->upload->do_upload('curriculum')){
             $upload=$this->upload->data();
            $_POST['curriculum']=$upload['file_name'];
        }elseif($this->input->post('mcontacto')){
            $error[0]=$this->upload->display_errors();
        }


        //Subir archivo FTP
        if($_POST['curriculum']){
	        $ftp_server="waws-prod-sn1-105.ftp.azurewebsites.windows.net"; 
			$ftp_user_name="WSEnlaceIT\UserftpEnlaceit"; 
			$ftp_user_pass="Sofihael01"; 
			$newfile = $this->_change_char($_POST['apellido_paterno']).'_'.$this->_change_char($_POST['apellido_materno']);
			$getext=explode('.',$_POST['curriculum']);
			$nomfile=strtolower($newfile.'.'.$getext[1]);
			rename ("pub/documentos/".$_POST['curriculum'], "pub/documentos/".$nomfile);
			$file = "pub/documentos/".$nomfile;//tobe uploaded 
			$remote_file = "\\site\\wwwroot\\ftp\\".$nomfile; 

			// set up basic connection 
			$conn_id = ftp_connect($ftp_server); 

			// login with username and password 
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

			// upload a file 
			if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) { 
			    //echo "successfully uploaded $file\n";
			    $archivo = 1;  
			} else { 
			    //echo "There was a problem while uploading $file\n";
			    $archivo = 0; 
			    } 
			// close the connection 
			ftp_close($conn_id); 
		}



        if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run() && !count($error) && $archivo == 1)
        //if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run() && !count($error))
        {
            if($this->input->post('email_field')!='')
            {
                return false;
            }
            
            $parametros = $_POST['nombre'].'|'.$_POST['apellido_paterno'].'|'.$_POST['apellido_materno'].'|'.$_POST['genero'].'|'.$_POST['fecha_nacimiento'].'|'.$_POST['telefono'].'|'.$_POST['celular'].'|'.$_POST['pais'].'|'.$_POST['estado'].'|'.$_POST['municipio'].'|'.$_POST['colonia'].'|'.$_POST['cp'].'|'.$_POST['desarrollo_profesional'].'|'.$_POST['especialidad'].'|'.$_POST['email'].'|'.$nomfile;

            $parametros=htmlentities($parametros);

            //echo $parametros; die();

            $this->load->library("Nusoap_lib");

            $wsdl ="http://wsenlaceit.azurewebsites.net/WebEnlaceIT.asmx?wsdl";
            $client = new nusoap_client($wsdl,true);
            $param = array('datos'=>$parametros);
            $result = $client->call('Registros', $param, '', '', false, true);


            if($result['RegistrosResult'][0]==1){

                $config['mailtype']='html';
                $config['wordwrap'] = FALSE;

                /* OBJETO EMAIL */
                $data_mail=$this->config->item('send_mail','proyecto');
                $config['protocol'] = 'smtp';
                $config['smtp_host'] =$data_mail['smtp_host'];
                $config['smtp_user'] = $data_mail['smtp_user'];
                $config['smtp_pass'] = $data_mail['smtp_pass'];
                $config['smtp_port'] =  $data_mail['smtp_port'];
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';

                $this->load->library('email');
                $this->email->initialize($config);

                $this->email->from($_POST['email']);
                $this->email->to($proyecto['email_contacto']);
                $this->email->cc('gsalgado@soretti.mx');
                $this->email->subject($proyecto['titulo'].' | registro de profesionales');
                // if(!isset($error[0]) && $_POST['curriculum']) $this->email->attach('pub/documentos/'.$_POST['curriculum']);
                $this->email->message($this->load->view('contacto/tpl_registro_profesionales',null,TRUE));
                if ($this->email->send())
                {
                  $this->email->clear();
                  $this->email->from('contacto@soretti.mx');
                  $this->email->to($_POST['email']);
                  $this->email->subject($proyecto['titulo'].' | respuesta | registro de profesionales');
                  $this->email->message($this->load->view('contacto/tpl_respuesta_prospecto',null,TRUE));
                  $this->email->send();

                  $datos['enviado']=$this->lang->line('enviado');
                }

            }

        }

        /*Datos para el meta*/
        $pagina=modules::run('pagina/_get_pagina',2);
        $datos['meta']=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $datos['pagina']=$pagina;

        $datos['error']=$error;
        $this->layout_content = $this->load->view('contacto/registro_profesionales',$datos,true);
        $this->load->view('plantilla/default');
    }

    public function _change_char($s){
        $s= str_replace('Á', 'A', $s);
        $s= str_replace('É', 'E', $s);
        $s= str_replace('Í', 'I', $s);
        $s= str_replace('Ó', 'O', $s);
        $s= str_replace('Ú', 'U', $s);
        $s= str_replace('Ñ', 'N', $s);
        $s= str_replace('á', 'a', $s);
        $s= str_replace('é', 'e', $s);
        $s= str_replace('í', 'i', $s);
        $s= str_replace('ó', 'o', $s);
        $s= str_replace('ú', 'u', $s);
        $s= str_replace('ä', 'a', $s);
        $s= str_replace('ë', 'e', $s);
        $s= str_replace('ï', 'i', $s);
        $s= str_replace('ö', 'o', $s);
        $s= str_replace('ü', 'u', $s);
        $s= str_replace('Ä', 'a', $s);
        $s= str_replace('Ë', 'e', $s);
        $s= str_replace('Ï', 'i', $s);
        $s= str_replace('Ö', 'o', $s);
        $s= str_replace('Ü', 'u', $s);
        $s= str_replace('ä', 'a', $s);
        $s= str_replace('ë', 'e', $s);
        $s= str_replace('ï', 'i', $s);
        $s= str_replace('ö', 'o', $s);
        $s= str_replace('ü', 'u', $s);
        $s= str_replace('ñ', 'n', $s);
        return $s;
    }

    public function registro_servicios(){
        $this->load->view('servicios');
    }

    public function registro_organizaciones()
    {

        $proyecto=$this->config->item('proyecto');
        $error=array();
        $datos=array();
        $datos['enviado']='';


        // $this->load->library('form_validation');


        // $this->form_validation->set_rules('tipo_sevicio', 'Tipo de servicio', 'required|xss_clean|strip_tags');
        
        // /*Requerimiento*/
        // $this->form_validation->set_rules('titulo','Titulo o nombre de posición', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('lugar_trabajo','Lugar de trabajo', 'required|xss_clean|strip_tags');
        // // $this->form_validation->set_rules('objetivos','Proposito y objetivos de la posición', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('tareas','Tareas', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('experiencia','Experecia requerida del profesional', 'required|xss_clean|strip_tags');
        // // $this->form_validation->set_rules('conocimientos_certificaciones','Conocimiento y certificaciones', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('esquema_contratacion','Esquema de contratación', 'required|xss_clean|strip_tags');

        // /*Oraganizacion*/
        // $this->form_validation->set_rules('nombre_razon_social','Nombre o Razó Social', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('giro','Giro o Sector', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('pais','País', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('estado','Estado', 'required|xss_clean|strip_tags');  

        // /*Contacto*/
        // $this->form_validation->set_rules('privacidad', 'Privacidad', 'required');
        // $this->form_validation->set_rules('nombre','Nombre', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('apellido_paterno','Apellido paterno', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('apellido_materno','Apellido Materno', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('puesto','Puesto ó Cargo', 'required|xss_clean|strip_tags');
        // //$this->form_validation->set_rules('departamento','Área o Departamento', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('telefono','Teléfono', 'required|xss_clean|strip_tags');
        // // $this->form_validation->set_rules('skype','Usuario Skype', 'required|xss_clean|strip_tags');

        // $this->form_validation->set_rules('email', "Correo", 'required|trim|valid_email|matches[confirmar_email]|xss_clean|strip_tags');
        // $this->form_validation->set_rules('confirmar_email', "Confirmar correo", 'required|trim');



        // if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run() )
        // {
        //     if($this->input->post('email_field')!='')
        //     {
        //         return false;
        //     }

        //     $config['mailtype']='html';
        //     $config['wordwrap'] = FALSE;

        //     /* OBJETO EMAIL */
        //     $data_mail=$this->config->item('send_mail','proyecto');
        //     $config['protocol'] = 'smtp';
        //     $config['smtp_host'] =$data_mail['smtp_host'];
        //     $config['smtp_user'] = $data_mail['smtp_user'];
        //     $config['smtp_pass'] = $data_mail['smtp_pass'];
        //     $config['smtp_port'] =  $data_mail['smtp_port'];
        //     $config['mailtype'] = 'html';
        //     $config['charset'] = 'utf-8';

        //     $this->load->library('email');
        //     $this->email->initialize($config);

        //     $this->email->from($_POST['email']);
        //     //$this->email->to($proyecto['email_contacto']);
        //     $this->email->to('gsbarreiro@gmail.com');
        //     $this->email->subject($proyecto['titulo'].' | Registro de las empresas y solicitud de servicios');
        //     $this->email->message($this->load->view('contacto/tpl_registro_organizaciones',null,TRUE));
        //     if ($this->email->send())
        //     {
        //       $datos['enviado']=$this->lang->line('enviado');
        //     }
        // }

        /*Datos para el meta*/
        $pagina=modules::run('pagina/_get_pagina',2);
        $datos['meta']=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $datos['pagina']=$pagina;

        // $datos['error']=$error;
        $this->layout_content = $this->load->view('contacto/registro_organizaciones',$datos,true);
        $this->load->view('plantilla/default');
    }


    public function solicitud_servicios()
    {

        $proyecto=$this->config->item('proyecto');
        $error=array();
        $datos=array();
        $datos['enviado']='';


        $this->load->library('form_validation');


        $this->form_validation->set_rules('tipo_sevicio', 'Tipo de servicio', 'required|xss_clean|strip_tags');
        
        /*Requerimiento*/
        $this->form_validation->set_rules('titulo','Titulo o nombre de posición', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('lugar_trabajo','Lugar de trabajo', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('objetivos','Proposito y objetivos de la posición', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('tareas','Tareas', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('experiencia','Experecia requerida del profesional', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('conocimientos_certificaciones','Conocimiento y certificaciones', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('esquema_contratacion','Esquema de contratación', 'required|xss_clean|strip_tags');

        /*Oraganizacion*/
        $this->form_validation->set_rules('nombre_razon_social','Nombre o Razó Social', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('giro','Giro o Sector', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('pais','País', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('estado','Estado', 'required|xss_clean|strip_tags');  

        /*Contacto*/
        $this->form_validation->set_rules('privacidad', 'Privacidad', 'required');
        $this->form_validation->set_rules('nombre','Nombre', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('apellido_paterno','Apellido paterno', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('apellido_materno','Apellido Materno', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('puesto','Puesto ó Cargo', 'required|xss_clean|strip_tags');
        //$this->form_validation->set_rules('departamento','Área o Departamento', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('telefono','Teléfono', 'required|xss_clean|strip_tags');
        // $this->form_validation->set_rules('skype','Usuario Skype', 'required|xss_clean|strip_tags');

        $this->form_validation->set_rules('email', "Correo", 'required|trim|valid_email|matches[confirmar_email]|xss_clean|strip_tags');
        $this->form_validation->set_rules('confirmar_email', "Confirmar correo", 'required|trim');



        if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run() )
        {
            if($this->input->post('email_field')!='')
            {
                return false;
            }

            $config['mailtype']='html';
            $config['wordwrap'] = FALSE;

            /* OBJETO EMAIL */
            $data_mail=$this->config->item('send_mail','proyecto');
            $config['protocol'] = 'smtp';
            $config['smtp_host'] =$data_mail['smtp_host'];
            $config['smtp_user'] = $data_mail['smtp_user'];
            $config['smtp_pass'] = $data_mail['smtp_pass'];
            $config['smtp_port'] =  $data_mail['smtp_port'];
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';

            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from($_POST['email']);
            //$this->email->to($proyecto['email_contacto']);
            $this->email->to('gsbarreiro@gmail.com');
            $this->email->subject($proyecto['titulo'].' | Registro de las empresas y solicitud de servicios');
            $this->email->message($this->load->view('contacto/tpl_registro_organizaciones',null,TRUE));
            if ($this->email->send())
            {
              $datos['enviado']=$this->lang->line('enviado');
            }
        }

        /*Datos para el meta*/
        // $pagina=modules::run('pagina/_get_pagina',2);
        // $datos['meta']=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        // $datos['pagina']=$pagina;

        $datos['error']=$error;
        $this->load->view('contacto/solicitud_servicios',$datos);
       
    }


    public function distribuidores()
    {

        $this->load->model('tienda/tiendausuario');

        $this->load->library('email');
        $this->load->library('encrypt');
        $proyecto=$this->config->item('proyecto');
        $this->load->library('form_validation');

        $usuario=new tiendaUsuario();
        $usuario->tipo='fisica';

    
        $enviado='';
        $error='';

        if( $this->input->post('tienda_registro')=='TRS6745-*1' && !$this->input->post('tienda_email_field') ){
            if($this->input->post('tipo')=='fisica') $usuario->validation['apellidoPaterno']= array('rules' => array('required'));
            elseif($this->input->post('tipo')=='moral') $usuario->validation['rfc']= array('rules' => array('required'));

            $usuario->validation['lada']= array('rules' => array('required','numeric'));
            $usuario->validation['telefono']= array('rules' => array('required','numeric'));
            $usuario->validation['privacidad']= array('rules' => array('required'));
            $usuario->validation['identificacion']= array('rules' => array('required'));
            $usuario->validation['comprobante_domicilio']= array('label'=>'Comprobrante de domicilio','rules' => array('required'));
            $usuario->validation['tipo']= array('label'=>'Tipo persona','rules' => array('required'));

            $config['upload_path'] = 'pub/documentos';
            $config['allowed_types'] = 'pdf|jpg';
            $config['max_size'] = '2048';

            $this->load->library('upload', $config);
            if($this->upload->do_upload('identificacion')){
                 $upload=$this->upload->data();
                $_POST['identificacion']=$upload['file_name'];
            }else{
                $error[0]=$this->upload->display_errors();
            }
            
            $this->upload->initialize($config);
            if($this->upload->do_upload('comprobante_domicilio')){
                 $upload=$this->upload->data();
                 $_POST['comprobante_domicilio']=$upload['file_name'];
            }else{
                $error[1]=$this->upload->display_errors();
            }


            $usuario->from_array($_POST,array('nombre','apellidoPaterno','apellidoMaterno','email','lada','telefono','password','confirmar','privacidad','identificacion','comprobante_domicilio','rfc','tipo'));
            $usuario->validate();
            if(isset($error[0])) $usuario->error->identificacion=$error[0];
            if(isset($error[1])) $usuario->error->comprobante_domicilio=$error[1];




            if($usuario->valid && !$error){
                    $usuario->rol_id=12;
                    $usuario->descuento_id=1;
                    $usuario->is_enable=0;
                    $usuario->fecha_creacion=date('Y-m-d H:i:s');
                    $usuario->password=$this->encrypt->encode($usuario->password);
                    if($usuario->save()){
                            $data_mail=$this->config->item('send_mail_tienda','proyecto');
                            $config['protocol'] = 'smtp';
                            $config['smtp_host'] =$data_mail['smtp_host'];
                            $config['smtp_user'] = $data_mail['smtp_user'];
                            $config['smtp_pass'] = $data_mail['smtp_pass'];
                            $config['smtp_port'] =  $data_mail['smtp_port'];
                            $config['mailtype'] = 'html';
                            $config['charset'] = 'utf-8';

                            $this->email->initialize($config);
                            $this->email->from($proyecto['email_contacto']);
                            $this->email->to($_POST['email']);
                            $this->email->cc($proyecto['email_contacto']);
                            $this->email->subject($proyecto['titulo'].' | Registro Distribuidor');
                            $this->email->message($this->load->view('tpl_distribuidor_hart','',true));
                            $this->email->send();
                    }
                    $enviado=1; 
            }else{
                if(isset($upload['file_name'])){
                    unlink('pub/documentos/'.$upload['file_name']);
                }
            }
        }


        /*Datos para el meta*/
        $pagina=modules::run('pagina/_get_pagina',2);
        $datos['meta']=array('titulo'=>$pagina->{'titulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $datos['pagina']=$pagina;
        $datos['error']=$error;
        $datos['enviado']=$enviado;
        $datos['usuario']=$usuario;


        $this->layout_content = $this->load->view('contacto/distribuidores',$datos,true);
        $this->load->view('plantilla/default');
    }


    public function inmediato()
    {
        $proyecto=$this->config->item('proyecto');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('texto', 'Texto', 'required|xss_clean');
        $datos['enviado']='';

        if($this->input->post('mcontacto')) if($this->form_validation->run())
        {
            if($this->input->post('email_field')!=''){
                return false;
            }

            $mensaje=$_POST['nombre']. ",se ha puesto en contacto y ha dicho: <br> ".$this->input->post('texto')."<br><br> ";
            $asunto='Contacto';

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
                if($this->contacto->from_array($_POST,'',TRUE))
                $datos['enviado']='Se envió correctamente su correo.';

            }
        }

        $this->load->view('inmediato',$datos);
    }



    public function _busqueda($contacto)
    {
        $contacto->clear();

        $like_text=$this->session->userdata('contacto_buscar');

        if($like_text){
            $contacto->group_start()
                     ->or_like(array( 'nombre' => $like_text, 'email' => $like_text, 'telefono' => $like_text, 'compania' => $like_text))
                     ->group_end();
        }
    }

    public function _ordenar($contacto)
    {
        if(!$this->session->userdata('contacto_ordenar'))
            $this->session->set_userdata('contacto_ordenar',array('id','DESC'));
        $order=$this->session->userdata('contacto_ordenar');

        $contacto->order_by($order[0],$order[1]);
    }


    public function listar(){

        $this->titulo='LISTA DE CONTACTOS';
        $this->acceso->valida('contacto','consultar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('contacto_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('contacto_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('contacto_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('contacto_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $contacto=new Contacto;
        $this->_busqueda($contacto);
        $total_rows=$contacto->where('is_enable',1)->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($contacto);
        $this->_ordenar($contacto);
        $contacto->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','desc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/contacto/lista');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content= $this->load->view('contacto/grid',$data=array('contacto'=>$contacto),true);
        $this->load->view('plantilla/backend/form');

    }
    function exportar()
    {
         $this->acceso->valida('contacto','consultar',1);

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Lista de contactos '.date('Y-m-d'));
                //set cell A1 content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', 'Nombre');

                $this->excel->getActiveSheet()->setCellValue('C1', 'Email');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Teléfono');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Compañía');


                $contacto=new Contacto;
                $this->_busqueda($contacto);
                $this->_ordenar($contacto);
                $contacto->where('is_enable',1)->order_by('id','desc')->get();

                $fila=2;
                foreach ($contacto as $item)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->nombre);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, $item->email);
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, $item->telefono);
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, $item->compania);
                    $fila++;
                }




                //change the font size
                //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
                //make the font become bold
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

                //merge cell A1 until D1
                //$this->excel->getActiveSheet()->mergeCells('A1:D1');
                //set aligment to center for that merged cell (A1 to D1)
                //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $filename='lista-de-contactos-'.date('Y-m-d').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');
    }
    public function agregar()
    {
        $this->titulo='AGREGAR CONTACTO';
        $this->acceso->valida('contacto','consultar',1);
        $data['contacto'] = new Contacto();
        $this->acceso->valida('contacto','editar',1);
        $this->layout_content  =$this->load->view('contacto/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id)
    {
        $this->titulo='EDITAR CONTACTO';
        $this->acceso->valida('contacto','consultar',1);
        $data['contacto']=new Contacto($id);
        $this->layout_content =  $this->load->view('contacto/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($id=0)
    {
         $this->titulo= ($id) ? 'EDITAR CONTACTO' : 'AGREGAR CONTACTO';
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('contacto','editar',1);

        $contacto=new Contacto($id);

        $campos=array( 'nombre', 'email', 'telefono', 'compania');

        $rel = $contacto->from_array($_POST, $campos);

        if($contacto->save($rel)){
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/contacto/editar/'.$contacto->id);
        }else{
            $data['contacto']=$contacto;
        $this->layout_content =  $this->load->view('contacto/form',$data,true);
        $this->load->view('plantilla/backend/form');
        }
    }

    public function eliminar()
    {
        $this->acceso->valida('contacto','eliminar',1);
        $contacto = new Contacto();
        $contacto->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/contacto/listar/');
    }


}
