<?php

class Cuenta_controller extends MX_Controller
{
	public function __construct() {
		parent::__construct();
		$this->acceso->carga_permisos('tienda');
		$this->load->model('rol/rol');
		$this->load->model('usuario/usuario');
		$this->load->model('catalogo/descuento');
	}

 

	public function ver($id=0) {
		$this->load->model('sepomex/estado');
		$this->load->model('sepomex/municipio');
		$this->load->model('sepomex/colonia');
		$this->load->model('boletin/boletin_usuarios');
		$this->load->model('boletin/grupos');
		$this->acceso->valida('tienda','consultar',1);

		 $descuentos=new Descuento();
		 $descuentos->get();

		$this->titulo='VER CUENTA';
		if(!$id){ show_error('Lo sentimos, la cuenta no existe', 500 );}
		$this->usuario->where('id',$id)->where('rol_id',12)->get();
		if(!$this->usuario->result_count()) {show_error('Lo sentimos, la cuenta no existe', 500 );}
		$this->usuario->tiendadireccion->get_iterated();
		$this->boletin_usuarios->get_by_email($this->usuario->email);

		$this->grupos->where_in('id',explode(',', $this->boletin_usuarios->grupos))->get();

		$this->db->where('usuario_id',$id)->from('subordinados');
		$subordinados=$this->db->join('usuarios', 'usuarios.id = subordinados.subordinado_id')->get()->result();

		$this->layout_content = $this->load->view(
			'tienda/backend/cuenta',
			array(
				'cuenta'     => $this->usuario,
				'subordinados'     => $subordinados,
				'newsletter' => $this->boletin_usuarios,
				'grupos'     => $this->grupos,
				'descuento' => $descuentos
				),true);
		$this->load->view('plantilla/backend/form');
	}

	public function listar() {

		$this->acceso->valida('tienda','consultar',1);
		$this->load->model('tienda/cupon');

		$per_page=30;

		$this->titulo='LISTA DE CUENTAS';


		if($this->input->post('action_buscar')) {
			$this->session->set_userdata('cuenta_buscar',$this->input->post('buscar'));
		}

		if($this->input->post('ordenar')) {
			$order=$this->session->userdata('cuenta_ordenar');
			if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
				$this->session->set_userdata('cuenta_ordenar',array($this->input->post('ordenar'),'DESC'));
			else
				$this->session->set_userdata('cuenta_ordenar',array($this->input->post('ordenar'),'ASC'));
		}
		$this->_busqueda($this->usuario);
		$this->_ordenar($this->usuario);
		$this->usuario->where("rol_id",12);
		$total_rows=$this->usuario->count();

		$pagina=($this->uri->segment(6)) ? $this->uri->segment(6)-1 : 0;
		$limit=($pagina*$per_page);
		$this->_busqueda($this->usuario);
		$this->_ordenar($this->usuario);
		$this->usuario->include_related('cupon')->where("rol_id",12)->limit($per_page, $limit)->order_by('id','desc')->get();
 


		$configuracion_paginador=$this->config->item('pagination');
		$configuracion_paginador['base_url'] = base_url('modulo/tienda/backend/cuenta/listar/');
		$configuracion_paginador['total_rows'] = $total_rows;
		$configuracion_paginador['per_page'] = $per_page;
		$configuracion_paginador['uri_segment'] = 6;
		$this->pagination->initialize($configuracion_paginador);
		$this->layout_content=$this->load->view('tienda/backend/cuentas', array('cuentas'=>$this->usuario), true);
		$this->load->view('plantilla/backend/form');
	}

	public function _busqueda($usuario)
	{
		$usuario->clear();

		$like_text = $this->session->userdata('cuenta_buscar');

		if($like_text){
			$usuario->group_start()
			->or_like(array('apellidoPaterno' => $like_text,'apellidoMaterno' => $like_text, 'nombre' => $like_text))
			->group_end();
		}
	}

	public function _ordenar($usuario)
	{
		if(!$this->session->userdata('cuenta_ordenar'))
			$this->session->set_userdata('cuenta_ordenar',array('id','DESC'));
		$order=$this->session->userdata('cuenta_ordenar');

		$usuario->order_by($order[0],$order[1]);
	}


	public function login_with($usuario_id)
	{
		$this->load->library('session', $config);
		 $this->acceso->valida('tienda','editar',1);
		 $user=new Usuario($usuario_id);
		 if($user->exists())
		 {
			 $this->session->set_userdata(array('login'=>'tienda','usuario_id'=>$user->id,'nombre'=>$user->nombre));
			 redirect('tienda/cuenta/micuenta');		 	
		}else{
			redirect('modulo/tienda/backend/cuenta/listar/');
		}

	}


		public function agregar()
	    {
	    	$this->load->library(array('encrypt','email'));
	        $this->acceso->valida('tienda','consultar',1);
	        $this->titulo='AGREGAR USUARIO';
	        $this->load->model('tienda/cupon');
	        $usuario=new Usuario();
	        $usuario->tipo='fisica';
			$descuentos=new Descuento();
			$descuentos->get();


	        $enviado='';
	        $error=array();
        	$proyecto=$this->config->item('proyecto');


	        if($this->input->post('guardar')){

	        	if($this->input->post('cupon'))
	        	{
	        		$cupon=new Cupon();
	        		$total=$cupon->where('cupon',$this->input->post('cupon'))->count();
	        		if($total) $error[3]='El codigo del cupón ya esta ocupado por otro usuario';
	        	}

	            if($this->input->post('tipo')=='fisica') $usuario->validation['apellidoPaterno']= array('rules' => array('required'));
	            elseif($this->input->post('tipo')=='moral') $usuario->validation['rfc']= array('rules' => array('required'));

	            $usuario->validation['lada']= array('rules' => array('required','numeric'));
	            $usuario->validation['telefono']= array('rules' => array('required','numeric'));
	            $usuario->validation['tipo']= array('label'=>'Tipo persona','rules' => array('required'));
	            unset($usuario->validation['privacidad']);
	            unset($usuario->validation['rol_id']);

	            $config['upload_path'] = 'pub/documentos';
	            $config['allowed_types'] = 'pdf|jpg';
	            $config['max_size'] = '2048';

	            if(isset($_FILES['identificacion']['tmp_name']) && $_FILES['identificacion']['tmp_name']!=''){ 
		            $this->load->library('upload', $config);
		            if($this->upload->do_upload('identificacion')){
		                 $upload=$this->upload->data();
		                $_POST['identificacion']=$upload['file_name'];
		            }else{
		                $error[0]=$this->upload->display_errors();
		            }
	            }
	            
	            if(isset($_FILES['comprobante_domicilio']['tmp_name']) && $_FILES['comprobante_domicilio']['tmp_name']!=''){ 
		            $this->upload->initialize($config);
		            if($this->upload->do_upload('comprobante_domicilio')){
		                 $upload=$this->upload->data();
		                 $_POST['comprobante_domicilio']=$upload['file_name'];
		            }else{
		                $error[1]=$this->upload->display_errors();
		            }
		        }


	            $usuario->from_array($_POST,array('nombre','apellidoPaterno','apellidoMaterno','descuento_id','email','lada','telefono','password','confirmar','rfc','tipo'));
	            $usuario->validate();
	            if(isset($error[0])) $usuario->error->identificacion=$error[0];
	            if(isset($error[1])) $usuario->error->comprobante_domicilio=$error[1];




	            if($usuario->valid && !$error){
	                    $usuario->rol_id=12;
	                    $usuario->is_enable=1;
	                    $usuario->fecha_creacion=date('Y-m-d H:i:s');
	                    $usuario->password=$this->encrypt->encode($usuario->password);
	                    if($usuario->save()){
	                    	    /*Crear el cupon del usuario y asignarlo con el */
	                    	    if($usuario->descuento_id)
	                    	    {
									
									$cupon=new Cupon();
									$cupon_string= ($this->input->post('cupon')) ? $this->input->post('cupon') : modules::run('tienda/cupon/generar_cupon');
									$cupon->cupon=$cupon_string;
									$cupon->descuento=7;
									$cupon->is_enable=1;
									$cupon->tipo_descuento='porcentaje';
									$cupon->uso='recurrente';
									$cupon->save();
									$usuario->cupon_id=$cupon->id;
									$usuario->skip_validation()->save();                    	    	
	                    	    }

	                            $data_mail=$this->config->item('send_mail_tienda','proyecto');
	                            $config['protocol'] = 'smtp';
	                            $config['smtp_host'] = $data_mail['smtp_host'];
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
	                            $this->email->message($this->load->view('contacto/tpl_distribuidor_hart','',true));
	                            $this->email->send();
	                            redirect('modulo/tienda/backend/cuenta/listar','refresh');
	                    }
	                    $enviado=1; 
	            }else{
	                if(isset($upload['file_name'])){
	                    unlink('pub/documentos/'.$_POST['comprobante_domicilio']);
	                    unlink('pub/documentos/'.$_POST['identificacion']);
	                }
	            }
	        }

	        $this->layout_content=$this->load->view('tienda/backend/form',array('usuario'=>$usuario,'descuentos'=>$descuentos,'error'=>$error),true);
	        $this->load->view('plantilla/backend/form');
	    }

    public function documentos($id,$tipo='')
    {  
    	$this->acceso->valida('tienda','consultar',1);
	    $usuario=new tiendaUsuario();
	    if(!is_numeric($id)) show_error("El usuario no  existe");
    	$usuario->where('id', $id)->get(); 
    	
    	$ext = pathinfo($usuario->identificacion);

    	if($tipo=='identificacion'){
				$file = 'pub/documentos/'.$usuario->identificacion;
    	}
    	if($tipo=='comprobante_domicilio'){
				$file = 'pub/documentos/'.$usuario->comprobante_domicilio;
    	}
    	if(!isset($file)){
    		show_error('No se encontro el documento');
    	}

		if($ext['extension']=='jpg')
			$type = 'image/jpeg';

		if($ext['extension']=='pdf')
			$type = 'application/pdf';
		
		header('Content-Type:'.$type);
		header('Content-Length: ' . filesize($file));
		readfile($file);
    }

	    public function editar($id=0){
	        $this->titulo='EDITAR USUARIO';
	        $this->acceso->valida('tienda','consultar',1);

 		    $this->load->model('tienda/cupon');
       		$usuario=new  Usuario();
        	$usuario->where('id',$id)->include_related('cupon')->get();


	        if(!$usuario->id) show_error($this->lang->line('alert_not_found_row'));
	        $roles=new Rol();
	        $roles->where("id",12)->where('is_enable',1)->order_by('nombre asc')->get();
	        $this->layout_content=$this->load->view('tienda/bakend/form',array('usuario'=>$usuario,'roles'=>$roles),true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function guardardescuento($id=0){

	    		 $this->titulo = ($id) ? 'EDITAR USUARIO' : $this->titulo='AGREGAR USUARIO';
	        	 $this->acceso->valida('tienda','editar',1);

	 			$error=array();
	            $config['upload_path'] = 'pub/documentos';
	            $config['allowed_types'] = 'pdf|jpg';
	            $config['max_size'] = '2048';

	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('identificacion')){
	                 $upload=$this->upload->data();
	                 $_POST['identificacion']=$upload['file_name'];
	            }else{
	                $error[0]=$this->upload->display_errors();
	                $usuario->error->identificacion=$error[0];
	            }

	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('comprobante_domicilio')){
	                 $upload=$this->upload->data();
	                 $_POST['comprobante_domicilio']=$upload['file_name'];
	            }else{
	                $error[1]=$this->upload->display_errors();
	                $usuario->error->comprobante_domicilio=$error[1];
	            }



	        	 $usuario=new Usuario($id);

	        	      $campos = array(
	       			 'descuento_id',
	       			 'cupon_id',
	       			 'identificacion',
	       			 'comprobante_domicilio',
	       			 'clabe',
	       			 'banco'
		        );

		        $usuario->from_array($_POST, $campos);
		        $success=$usuario->skip_validation()->save();

		        $this->db->where('usuario_id',$id)->delete('subordinados');
		        if( is_array($this->input->post('subordinados')) ) foreach($this->input->post('subordinados') as $indice=>$usuario_id){
 					 $this->db->insert('subordinados',array('usuario_id'=>$id,'subordinado_id'=>$usuario_id));
		        }	

		        if($success){
		            $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
		            redirect('tienda/backend/cuenta/listar/');
		        } else {
		            redirect('tienda/backend/cuenta/ver/'.$id);
		        }



	    }

	    public function guardar($id=0){ die();

	        $this->load->library('encrypt');

	        $this->titulo = ($id) ? 'EDITAR USUARIO' : $this->titulo='AGREGAR USUARIO';
	        $this->acceso->valida('tienda','editar',1);

	        $usuario=new Usuario($id);
	        $roles=new Rol();
	        $roles->where("id",12)->order_by('nombre asc')->get();

	        $_POST['rol_id']=12;

	        $campos=array('nombre','rol_id','apellidoPaterno','apellidoMaterno','email','password','confirmar','cupon_id');
	        if($usuario->id &&  !$this->input->post('cambiar_password')){
	            unset($campos[4]);
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
	            $usuario->save($rel);
	            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));

	            redirect('modulo/tienda/backend/cuenta/editar/'.$usuario->id);
	        }else{
	            $usuario->rol_id=$this->input->post('rol_id');
	        $this->layout_content=$this->load->view('tienda/backend/cuentas/form',array('usuario'=>$usuario,'roles'=>$roles),true);
	        $this->load->view('plantilla/backend/form');

	        }
	    }





	public function eliminar() {
		$this->acceso->valida('tienda','eliminar',1);
		
		$usuarios_sel=new Usuario();
		$usuarios_sel->where('rol_id',12)->where_in('id', $this->input->post('post_ids'))->get();
		
		foreach ($usuarios_sel as $user) {
			if($user->descuento_id==1){
					$cupon=new Cupon($user->cupon_id);
					$cupon->is_enable=0;
					$cupon->save();
			}
		}

		$this->usuario->where('rol_id',12)->where_in('id', $this->input->post('post_ids'))->update('is_enable', 0);
		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
		redirect($this->input->get('uri'));
	}

	public function activar() {
		$this->load->library('email');
		$mensaje_cupon=0; 
		$usuarios_sel=new Usuario();
		$this->acceso->valida('tienda','eliminar',1);
		$usuarios_sel->where('rol_id',12)->where_in('id', $this->input->post('post_ids'))->where('is_enable',0)->get();
		$this->usuario->where('rol_id',12)->where_in('id', $this->input->post('post_ids'))->update('is_enable', 1);

		$descuento_base=$this->config->item('proyecto','descuento_base');

		foreach ($usuarios_sel as $user) {
									/*SI el usuario no tiene asignado un cupon  para distribuidor se crea y se asigna*/
						if(!$user->cupon_id){
							$this->load->model('tienda/cupon');
							$cupon=new Cupon();
							$cupon_string=modules::run('tienda/cupon/generar_cupon');
							$cupon->cupon=$cupon_string;
							$cupon->descuento=7;
							$cupon->is_enable=1;
							$cupon->tipo_descuento='porcentaje';
							$cupon->uso='recurrente';
							$cupon->save();
							$user->cupon_id=$cupon->id;
							$user->skip_validation()->save();
							$mensaje_cupon=1;
						}else{
							$cupon=new Cupon($user->cupon_id);
							$cupon->is_enable=1;
							$user->cupon_id=$cupon->id;
							$user->skip_validation()->save();
						}

			    //         $data_mail=$this->config->item('send_mail_tienda','proyecto');
       //  				$proyecto=$this->config->item('proyecto');
       //                  $config['protocol'] = 'smtp';
       //                  $config['smtp_host'] =$data_mail['smtp_host'];
       //                  $config['smtp_user'] = $data_mail['smtp_user'];
       //                  $config['smtp_pass'] = $data_mail['smtp_pass'];
       //                  $config['smtp_port'] =  $data_mail['smtp_port'];
       //                  $config['mailtype'] = 'html';
       //                  $config['charset'] = 'utf-8';

       //                  $this->email->initialize($config);
       //                  $this->email->from($proyecto['email_contacto'],'Alga Espirulina MX');
       //                  $this->email->to($user->email);
       //                  $this->email->cc($proyecto['email_contacto']);
       //                  $this->email->attach('pub/lista-precios-distribuidores.docx');
 						// $this->email->attach('pub/politicas-distribuidores.docx');
       //                  $this->email->subject($proyecto['titulo'].' | Cuenta de Distribuidor Activada');
       //                  $this->email->message($this->load->view('contacto/tpl_distribuidor',array('mensaje_cupon'=>$mensaje_cupon,'cupon'=>$cupon,'user'=>$user),true));
       //                  $this->email->send();
		}
		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
		redirect('modulo/tienda/backend/cuenta/listar');
	}

}
