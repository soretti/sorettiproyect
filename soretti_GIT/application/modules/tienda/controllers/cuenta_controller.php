<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuenta_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario/usuario');
		$this->load->model('pagina/pagina');
	}


	public function cancelar_boletin_cupones()
	{
		$this->load->library('encrypt');
		$string_m=$this->input->get('cancel');
		$string=$this->encrypt->decode($string_m,"byetonews");
		list($txt,$mail)=explode("+",$string);
		$usuario = new Usuario();
		$usuario->where('email',$mail)->get();
		if($usuario->exists()){
			$usuario->recibir_cupon=0;
			$usuario->skip_validation()->save();
		}else{
			return false;
		}

		$meta=array('titulo'=>'Cancelar boletín de cupones para distribuidores','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('cuenta/cancelar_boletin_cupones',array('titulo'=>'Cancelar boletín de cupones para distribuidores','meta' =>$meta),true);
		$this->load->view('plantilla/default');		
	}	

	/*Enviar cupones pdf por correo electronico*/
	/*Se ejecuta este metodo  por medio de un cron job configurado cada minuto en el cpanel*/

	public function enviar_cupones()
	{
		$this->load->library('encrypt');
		$month_actual=date('m');
		$year_actual=date('y');

		$this->load->library('email');
		$config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.algaespirulina.mx';
        $config['smtp_user'] = 'hola@algaespirulina.mx';
        $config['smtp_pass'] = 'H01@E2p1rul1na123';
        $config['smtp_port'] = '26';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->initialize($config);  


        $usuario=new Usuario();
        $usuario->include_related('cupon');
        $usuario->select('usuarios.id,usuarios.nombre,usuarios.apellidoPaterno,usuarios.email,cupones.descuento AS descuento,cupones.cupon AS cupon');
        $usuario->where(array('usuarios.is_enable'=>1,'usuarios.descuento_id <>'=>'0','usuarios.cupon_id <>'=>'0','recibir_cupon'=>1))
        ->group_start()->where(array('YEAR(fecha_envio_cupon) ='=>$year_actual,'MONTH(fecha_envio_cupon) <'=>$month_actual))->or_group_start()->where(array('fecha_envio_cupon'=>'0000-00-00'))->group_end()-> group_end()
        ->limit(1)->get();

        if(!$usuario->exists()){
        	return FALSE;
        }
        /*Se genera el PDF Y SE GUARDA TEMPORALMENTE PARA ENVIARLO POR CORREO*/	
		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('CUPONES DE DESCUENTO DISTRIBUIDORES');
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(0);
		$pdf->setFooterMargin(0);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetDisplayMode('real', 'default');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);		
		$pdf->AddPage();
		$html = $this->load->view('cuenta/cupones',array('cupon'=>$usuario),true);
		$pdf->writeHTML($html, true, false, true, false, ''); 
		$pdf->Output(FCPATH.'pub/uploads/cupones/cupones.pdf', 'F');

		$this->email->from($this->config->item('proyecto','email_producto'), 'Alga Espirulina');
		$this->email->to($usuario->email);
		$this->email->subject(' Alga espirulina | Cupones para distribuidores ');
		$this->email->message($this->load->view('cuenta/tpl_cupones',compact('usuario'), TRUE));
		$this->email->attach('pub/uploads/cupones/cupones.pdf');
		
		if($this->email->send()){
			$usuario->fecha_envio_cupon=date('Y-m-d');
			$usuario->skip_validation()->save();
		}
		unlink('pub/uploads/cupones/cupones.pdf');

	}

	public function notificaciones()
	{
		$proyecto=$this->config->item('proyecto');
		$this->load->library('email');
		$config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.algaespirulina.mx';
        $config['smtp_user'] = 'hola@algaespirulina.mx';
        $config['smtp_pass'] = 'H01@E2p1rul1na123';
        $config['smtp_port'] = '26';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->initialize($config);


		/* obtener a los usuarios distribuidores que su ultima compra sea mayor o igual a 60 días   */

		$distribuidores=$this->db->query("SELECT usuarios.cupon_id, usuarios.id,usuarios.fecha_creacion,usuarios.nombre,usuarios.apellidoPaterno,usuarios.email, MAX( pago_fecha ) as pago_fecha, MAX( notificaciones_distribuidores.fecha ) as notificacion_fecha, DATEDIFF(NOW(), MAX( pago_fecha )) as ultima_compra
							FROM  `usuarios` 
							LEFT JOIN orders ON orders.usuario_id = usuarios.id 
							LEFT JOIN notificaciones_distribuidores ON notificaciones_distribuidores.usuario_id = usuarios.id 
							WHERE descuento_id <>  ''
							AND usuarios.is_enable = 1
							GROUP BY usuarios.id
							HAVING ( ultima_compra >= 60 OR ISNULL( ultima_compra ) AND  ( notificacion_fecha < NOW()  OR ISNULL( notificacion_fecha )) ) order by notificacion_fecha ASC");
		$distribuidores_sin_compras=array();
		/*Distribuidores que no han realizado compras en 60 días */
		foreach ($distribuidores->result() as $distribuidor)
		{
			  $ultima_actividad=($distribuidor->pago_fecha) ? $distribuidor->pago_fecha : $distribuidor->fecha_creacion;
			  $distribuidores_sin_compras[$distribuidor->id]=array('id'=>$distribuidor->id,'nombre'=>$distribuidor->nombre,'apellidoPaterno'=>$distribuidor->apellidoPaterno,'email'=>$distribuidor->email);

			  
			 /* Revisar si hubo una compra con el cupon del distribuidor */
			  $compras_distribuidor=$this->db->query("SELECT MAX(pago_fecha) as ultima_compra  FROM  orders WHERE cupon_id={$distribuidor->cupon_id}");
			  if($compras_distribuidor->num_rows()){
			  	 $compra=$compras_distribuidor->row();
			  	 if( dias_transcurridos(date('Y-m-d'), $compra->ultima_compra) < 60 )
			  	 {
			  	 	unset($distribuidores_sin_compras[$distribuidor->id]);
			  	 	continue;
			  	 }
			  }

			  $platas=$this->db->select('usuarios.*')->where('subordinados.usuario_id',$distribuidor->id)->from('subordinados')->join('usuarios','usuarios.id=subordinados.subordinado_id')->get();
			  $distribuidores_platas=$platas->result_array();

			  if( $platas->num_rows() )
			  {
				  $distribuidores_platas_id_string=implode(",",arrayColumn($distribuidores_platas,'id'));
				  if(!$distribuidores_platas_id_string) $distribuidores_platas_id_string='0';
				  
				  /* Revisar si hubo una compra de subdistribuidores nivel 1 */
				  $compras_distribuidor=$this->db->query("SELECT MAX(pago_fecha) as ultima_compra  FROM  orders WHERE usuario_id IN({$distribuidores_platas_id_string}) ");
				  if($compras_distribuidor->num_rows()){
				  	 $compra=$compras_distribuidor->row();
				  	 if( dias_transcurridos(date('Y-m-d'), $compra->ultima_compra) < 60 )
				  	 {
				  	 	unset($distribuidores_sin_compras[$distribuidor->id]);
				  	 	continue;
				  	 }
				  }

				  /*Revisar si hubo compra con  los cupones nivel1*/
				  $distribuidores_platas_cupon_string=implode(",",arrayColumn($distribuidores_platas,'cupon_id'));
				  if(!$distribuidores_platas_cupon_string) $distribuidores_platas_cupon_string='0';
				 /* Revisar si hubo una compra de subdistribuidores nivel 1 */
				  $compras_distribuidor=$this->db->query("SELECT MAX(pago_fecha) as ultima_compra  FROM  orders WHERE cupon_id IN({$distribuidores_platas_cupon_string}) ");
				  if($compras_distribuidor->num_rows())
				  {
				  	 $compra=$compras_distribuidor->row();
				  	 if( dias_transcurridos(date('Y-m-d'), $compra->ultima_compra) < 60 )
				  	 {
				  	 	unset($distribuidores_sin_compras[$distribuidor->id]);
				  	 	continue;
				  	 }
				  }
			  }


			  if( $plata->num_rows() )
			  {
			  	foreach ($platas as $plata)
			  	{
			  		$bronces=$this->db->select('usuarios.*')->where('subordinados.usuario_id',$plata->id)->from('subordinados')->join('usuarios','usuarios.id=subordinados.subordinado_id')->get();
			  		$distribuidores_bronce=$platas->result_array();
			  		if( $bronces->num_rows() )
			  		{
							  $distribuidores_bronces_id_string=implode(",",arrayColumn($distribuidores_bronce,'id'));
							  if(!$distribuidores_bronces_id_string) $distribuidores_bronces_id_string='0';
							  
							  /* Revisar si hubo una compra de subdistribuidores nivel 2 */
							  $compras_distribuidor=$this->db->query("SELECT MAX(pago_fecha) as ultima_compra  FROM  orders WHERE usuario_id IN({$distribuidores_bronces_id_string}) ");
							  if($compras_distribuidor->num_rows()){
							  	 $compra=$compras_distribuidor->row();
							  	 if( dias_transcurridos(date('Y-m-d'), $compra->ultima_compra) < 60 )
							  	 {
							  	 	unset($distribuidores_sin_compras[$distribuidor->id]);
							  	 	continue;
							  	 }
							  }


							  /*Revisar si hubo compra con  los cupones nivel1*/
							  $distribuidores_bronces_cupon_string=implode(",",arrayColumn($distribuidores_bronce,'cupon_id'));
							  if(!$distribuidores_bronces_cupon_string) $distribuidores_bronces_cupon_string='0';
							 /* Revisar si hubo una compra de subdistribuidores nivel 1 */
							  $compras_distribuidor=$this->db->query("SELECT MAX(pago_fecha) as ultima_compra  FROM  orders WHERE cupon_id IN({$distribuidores_bronces_cupon_string}) ");
							  if($compras_distribuidor->num_rows())
							  {
							  	 $compra=$compras_distribuidor->row();
							  	 if( dias_transcurridos(date('Y-m-d'), $compra->ultima_compra) < 60 )
							  	 {
							  	 	unset($distribuidores_sin_compras[$distribuidor->id]);
							  	 	continue;
							  	 }
							  }


			  		}
			  }

			}
		
		print_pre($distribuidores_sin_compras);

		die();


		foreach ($distribuidores_sin_compras as $distribuidor){
 
			 if($distribuidor['email']!='ob@paginasweb.mx') continue;

			 /*Buscar si se le ha enviado una notificacion anteriormente*/
			 $notificacion_result=$this->db->where('usuario_id',$distribuidor['id'])->where('fecha >',$ultima_actividad)->order_by('id','DESC')->get('notificaciones_distribuidores');
			 if(!$notificacion_result->num_rows()){
				/* Enviar notificación al usuario 30 días antes */
				$this->db->insert('notificaciones_distribuidores', array('usuario_id'=>$distribuidor['id'],'fecha'=>date('Y-m-d'),'tipo'=>1) );
				/*Enviar correo electronico de notificacion*/

			 }else{
			 	$notificacion=$notificacion_result->row();
			 	$dias_transcurridos=dias_transcurridos(date('Y-m-d'),$notificacion->fecha);

			 	if($dias_transcurridos>=15 && $notificacion->tipo==1)
			 	{
					$this->db->insert('notificaciones_distribuidores',array('usuario_id'=>$distribuidor['id'],'fecha'=>date('Y-m-d'),'tipo'=>2));
					/*Enviar correo electronico de notificacion*/
					$this->email->from($this->config->item('proyecto','email_producto'), 'Alga Espirulina');
					$this->email->to($distribuidor['email']);
					$this->email->subject('Alga espirulina | Lo invitamos a mantener su cuenta de distribuidor vigente');
					$this->email->message($this->load->view('cuenta/notificacion',array('distribuidor'=>$distribuidor,'dias'=>75), TRUE));
					$this->email->send();					
					return false;
			 	}

			 	if($dias_transcurridos>=5  && $notificacion->tipo==2)
			 	{
					$this->db->insert('notificaciones_distribuidores',array('usuario_id'=>$distribuidor['id'],'fecha'=>date('Y-m-d'),'tipo'=>3));
					/*Enviar correo electronico de notificacion*/
					$this->email->from($this->config->item('proyecto','email_producto'), 'Alga Espirulina');
					$this->email->to($distribuidor['email']);
					$this->email->subject('Alga espirulina | Lo invitamos a mantener su cuenta de distribuidor vigente');
					$this->email->message($this->load->view('cuenta/notificacion',array('distribuidor'=>$distribuidor,'dias'=>80), TRUE));
					$this->email->send();					
					return false;
			 	}

			 	if($dias_transcurridos>=10 && $notificacion->tipo==3)
			 	{
					$this->db->insert('notificaciones_distribuidores',array('usuario_id'=>$distribuidor['id'],'fecha'=>date('Y-m-d'),'tipo'=>4));

					/*Desactivar al usuario*/
					$this->db->update('usuarios',array('descuento_id'=>0), "id = ".$distribuidor['id']);
					/*Enviar correo electronico de notificacion*/
					$this->email->from($this->config->item('proyecto','email_producto'), 'Alga Espirulina');
					$this->email->to($distribuidor['email']);
					$this->email->subject('Alga espirulina | Su descuento como distribuidor ha sido cancelado');
					$this->email->message($this->load->view('cuenta/notificacion',array('distribuidor'=>$distribuidor,'dias'=>90), TRUE));
					$this->email->send();
					
			 	}
			 }
		}
	}
	}

	public function _session($usuario)
	{
		$this->session->set_userdata(array('login'=>'tienda','usuario_id'=>$usuario->id,'nombre'=>$usuario->nombre));
	}
	
	public function print_cupon(){
		identificar();
		$cupon='';
		$usuario=new tiendaUsuario();
		$usuario=$usuario->where('id',$this->session->userdata('usuario_id'))->get();
		
		if($usuario->cupon_id){
			$cupon=new Cupon($usuario->cupon_id);
		}else{
			die('Datos incorrectos');
		}


		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('CUPONES DE DESCUENTO DISTRIBUIDORES');
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(0);
		$pdf->setFooterMargin(0);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetDisplayMode('real', 'default');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);		
		$pdf->AddPage();

		$html = $this->load->view('cuenta/cupones',array('cupon'=>$cupon),true);

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, ''); 

		$pdf->Output('cupones.pdf', 'I');
	}

	public function  micuenta(){

		identificar();
		$cupon='';

		$this->load->model('boletin/grupos');
	    $this->load->model('boletin/boletin_usuarios');

	    $boletin_grupos= new Grupos();
		$usuario=new tiendaUsuario();
		$usuario=$usuario->where('id',$this->session->userdata('usuario_id'))->get();
		//$usuario->distribuidor=$this->db->where('usuario_id',$usuario->id)->get('usuarios_distribuidores')->row();

		
		if($usuario->cupon_id){
			$cupon=new Cupon($usuario->cupon_id);
		}

		$boletin_usuario = new boletin_usuarios();
		$boletin_usuario=$boletin_usuario->get_by_email($usuario->email);


		if(($boletin_grupos->count()!=0)&&($boletin_usuario->grupos)){
			$total=$boletin_grupos->where_in('id',explode(",",$boletin_usuario->grupos))->count();
			$boletin_grupos->where_in('id',explode(",",$boletin_usuario->grupos))->get();
		}else{
			$boletin_grupos='';
			$total=0;
		}

		$meta=array('titulo'=>'Detalles de mi cuenta','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('cuenta/micuenta',array('cupon'=>$cupon,'usuario'=>$usuario,'boletin_usuario'=>$boletin_usuario,'titulo'=>'Mi Cuenta','meta' =>$meta,'grupos'=>$boletin_grupos,'total'=>$total),true);
		$this->load->view('plantilla/default');
	}

	public function editargrupo()
	{
		identificar();


		$this->load->model('boletin/grupos');
	    $this->load->model('boletin/boletin_usuarios');

	 	$boletin_grupos= new Grupos();
	 	$boletin_usuario = new boletin_usuarios();
		$usuario=new tiendaUsuario();



		$usuario->where('id',$this->session->userdata('usuario_id'))->get();

		/*Agregar al boletin*/
	    $boletin_usuario->get_by_email($usuario->email);

		if($this->input->post('inlineRadioOptions')=='option1'){

			if($boletin_grupos->count()){
				$boletin_usuario->validation['grupos']=array('rules' => array('required'));
			}

			if($this->input->post('guardar') ){

				unset($boletin_usuario->validation['nombre']);
				unset($boletin_usuario->validation['privacidad']);
				unset($boletin_usuario->validation['apellidoPaterno']);
				unset($boletin_usuario->validation['apellidoMaterno']);
				unset($boletin_usuario->validation['email']);

		               	$boletin_usuario->grupos=($this->input->post('grupos')) ? implode(",",$this->input->post('grupos')) : '' ;
		               	$boletin_usuario->unsuscribed=0;

		               	if($boletin_usuario->exists()){
	                    		if($boletin_usuario->save()){

        							/*Inscribirlo a send_blaster*/
				                    $send_blaster=$this->config->item('send_blaster','proyecto');
				                    if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Subscribe','','From: '.$boletin_usuario->email);

				                    $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	                    			redirect('tienda/cuenta/micuenta');
	                    		}
	                	}else{
               				$boletin_usuario->email=$usuario->email;
			                $boletin_usuario->nombre=$usuario->nombre;
			                if($boletin_usuario->skip_validation()->save()){
		                	     /*Inscribirlo a send_blaster*/
			                    $send_blaster=$this->config->item('send_blaster','proyecto');
			                    if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Subscribe','','From: '.$boletin_usuario->email);

			               	    $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
                    			redirect('tienda/cuenta/micuenta');
			                }
	                	}
		        	}

        		}else{  // el usuario se dio de baja:

        			if($this->input->post('guardar') ){

		               	if($boletin_usuario->exists()){
		               		$boletin_usuario->unsuscribed=1;
		               		if($boletin_usuario->skip_validation()->save()){
		               			/*Desuscribirlo a send_blaster*/
			                    $send_blaster=$this->config->item('send_blaster','proyecto');
			                    if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Unsubscribe','','From: '.$boletin_usuario->email);

		               			 $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
		                    	 redirect('tienda/cuenta/micuenta');
		               		}
		               	}
		               }
        		}

        		$grupos=$boletin_grupos->where('is_enable',1)->order_by('nombre asc')->get_raw()->result();

		$meta=array('titulo'=>'Mi cuenta | Newsletter','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('cuenta/editargrupo',array('usuario'=>$usuario,'boletin_usuario'=>$boletin_usuario,'titulo'=>'Newsletter','meta' =>$meta,'grupos'=>$grupos),true);
		$this->load->view('plantilla/default');
	}

    public function documentos($tipo='')
    {  
    	identificar();
	    $usuario=new tiendaUsuario();
    	$usuario->where('id', $this->session->userdata('usuario_id'))->get(); 
    	
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


	public function editar()
	{

		identificar();


		$this->load->library('email');
		$this->load->library('encrypt');
    	$this->load->model('boletin/grupos');
    	$this->load->model('boletin/boletin_usuarios');
    	$proyecto=$this->config->item('proyecto');
		$this->load->library('form_validation');

		$usuario=new tiendaUsuario();

	        	$usuario->where('id', $this->session->userdata('usuario_id'))->get();
	        	//$usuario->distribuidor=$this->db->where('usuario_id',$usuario->id)->get('usuarios_distribuidores')->row();

	            
				if(isset($usuario->distribuidor->tipo) && $usuario->distribuidor->tipo=='moral') $usuario->validation['rfc']= array('rules' => array('required'));
				else $usuario->validation['apellidoPaterno']= array('rules' => array('required'));			        		



	        	if($this->input->post('guardar')){ 
	        		unset($usuario->validation['privacidad']) ;


	        		
	        		if(!$this->input->post('pass')){
	        			unset($usuario->validation['password']) ;
	        			unset($usuario->validation['confirmar']) ;
	        		}else{
	        			$usuario->password=$this->input->post('password');
	        			$usuario->confirmar=$this->input->post('confirmar');
	        		}

			  	  	$usuario->validate();

		 			$error=array();
		 			if($usuario->descuento_id){
			            $config['upload_path'] = 'pub/documentos';
			            $config['allowed_types'] = 'pdf|jpg';
			            $config['max_size'] = '2048';

			            
			            $this->load->library('upload', $config);
			            if($_FILES['identificacion']['tmp_name']){
					            if($this->upload->do_upload('identificacion')){
					                 $upload=$this->upload->data();
					                 $_POST['identificacion']=$upload['file_name'];
					            }else{
					                $error[0]=$this->upload->display_errors();
					                $usuario->error->identificacion=$error[0];
					            }
					    }

					    if($_FILES['comprobante_domicilio']['tmp_name']){
				            $this->load->library('upload', $config);
				            if($this->upload->do_upload('comprobante_domicilio')){
				                 $upload=$this->upload->data();
				                 $_POST['comprobante_domicilio']=$upload['file_name'];
				            }else{
				                $error[1]=$this->upload->display_errors();
				                $usuario->error->comprobante_domicilio=$error[1];
				            }
			            }
		 			}
		 			$usuario->from_array($_POST,array('nombre','apellidoPaterno','apellidoMaterno','email','lada','telefono','rfc','banco','clabe','identificacion','comprobante_domicilio'));
				  	if($usuario->valid && !count($error)){
				  		 $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
				  		 if($this->input->post('pass')) {
				  		 	$usuario->password=$this->encrypt->encode($usuario->password);
				  		 }
				  		$usuario->save();
				  	}
	        	}

		$meta=array('titulo'=>'','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('cuenta/editar',array('usuario'=>$usuario ,'titulo'=>'Modificar Cuenta', 'meta' =>$meta),true);
		$this->load->view('plantilla/default');
	}

	public function registro()
	{

		$this->load->library('email');
		$this->load->library('encrypt');
    	$this->load->model('boletin/grupos');
    	$this->load->model('boletin/boletin_usuarios');
    	$proyecto=$this->config->item('proyecto');
		$this->load->library('form_validation');

		$usuario=new tiendaUsuario();


		$grupos=new Grupos();
		$grupos_result=$grupos->where('is_enable',1)->order_by('nombre asc')->get_raw();
		$total_grupos=$grupos_result->num_rows();
		$grupos=$grupos_result->result();

	    if($this->input->post('boletin') && $total_grupos){
		            $usuario->validation['grupos']=array('rules' => array('required'));
		}

		$enviado='';

		if( $this->input->post('tienda_registro')=='TRS6745-*1' && !$this->input->post('tienda_email_field') ){
			
			$usuario->validation['apellidoPaterno']=array('rules' => array('required'));
			$usuario->validation['lada']=array('rules' => array('required'));
			$usuario->validation['telefono']=array('rules' => array('required'));
			// print_pre($usuario->validation);

		 	$usuario->from_array($_POST,array('nombre','apellidoPaterno','apellidoMaterno','email','lada','telefono','password','confirmar','grupos','privacidad'));
	  	  	$usuario->validate();
		  	if($usuario->valid){
		     		$usuario->rol_id=12;
		     		$usuario->fecha_creacion=date('Y-m-d H:i:s');
		       		$usuario->password=$this->encrypt->encode($usuario->password);
		       		if($usuario->save()){
			            		$config['mailtype']='html';
			                	$config['wordwrap'] = FALSE;
			                	$this->email->initialize($config);
			                	$this->email->from($proyecto['email_contacto'], $proyecto['titulo']);
			                	$this->email->to($_POST['email']);
			                	$this->email->cc($proyecto['email_contacto']);
			                	$this->email->subject($proyecto['titulo'].' | Bienvenido');
			                	$this->email->message($this->load->view('cuenta/tpl_registro','',true));
			                	$this->email->send();

								  	/*Agregar al boletin*/
								  	if($this->input->post('boletin')){
								  		$boletin_usuario = new boletin_usuarios;
								               	$boletin_usuario->get_by_email($this->input->post('email'));
								               	if(!$boletin_usuario->exists()){
								               		$boletin_usuario->email=$this->input->post('email');
						                    		$boletin_usuario->nombre=$this->input->post('nombre');
						                    		$boletin_usuario->apellidoPaterno=$this->input->post('apellidoPaterno');
						                    		$boletin_usuario->apellidoMaterno=$this->input->post('apellidoMaterno');
						                    		$boletin_usuario->grupos=($this->input->post('grupos')) ? implode(",",$this->input->post('grupos')) : '';
						                    		$boletin_usuario->skip_validation()->save();

													/*Inscribirlo a send_blaster*/
								                    $send_blaster=$this->config->item('send_blaster','proyecto');
								                    if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Subscribe','','From: '.$boletin_usuario->email);

								                	}
								  	}
		       			$this->_session($usuario);
			       		if($this->input->get('to')){
							redirect($this->input->get('to'));
						}else{
			       		 redirect('tienda/cuenta/micuenta');
			       		}
		            }
		  	}
		}



		$meta=array('titulo'=>'Registro de clientes','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view('cuenta/registro',array('usuario'=>$usuario ,'titulo'=>'CREAR CUENTA','meta' =>$meta,'grupos'=>$grupos, 'enviado'=>$enviado),true);
		$this->load->view('plantilla/default');
	}

 	public function recordarPassword()
 	{
 		$mensaje='';
 		$usuario=new Usuario();
 		// print_pre($this->session->userdata('resetPassword'));
 		if( $this->input->post('tienda_registro')=='TRS6745-*1' && !$this->input->post('tienda_email_field' ) ){

		$usuario->validation=array(
						'email' => array('rules' => array('required','valid_email','verificar_email'))
		);
		$usuario->from_array($_POST,array('email'));
			$usuario->validate();

			if($usuario->valid){
				/*Enviar correo  y crear sesion en el sitio*/
				$random=random_string('unique');
				$this->session->set_userdata('resetPassword',array('random'=>$random,'email'=>$this->input->post('email')));


				$data_mail=$this->config->item('send_mail','proyecto');

	 			$config['protocol'] = 'smtp';
		        $config['smtp_host'] =$data_mail['smtp_host'];
		        $config['smtp_user'] = $data_mail['smtp_user'];
		        $config['smtp_pass'] = $data_mail['smtp_pass'];
		        $config['smtp_port'] =  $data_mail['smtp_port'];
		        $config['mailtype'] = 'html';
		        $config['charset'] = 'utf-8';

				$this->load->library('email',$config);
				$this->email->from($data_mail['smtp_user'],$data_mail['alias']);
				$this->email->to($this->input->post('email'));
				$this->email->subject('Resetea tu contraseña | '.$this->config->item('titulo','proyecto') );
				$this->email->message('<a href="'.base_url('tienda/cuenta/resetPassword/'.$random).'"> Haz click aqui para cambiar tu contraseña </a>');
				if( $this->email->send() ){
					$mensaje=1;
				}
			}
 		}
 		$meta=array('titulo'=>'Recordar password','descripcion'=>'','palabras_clave'=>'');
 		$this->layout_content=$this->load->view('recordarPassword',array('usuario'=>$usuario,'mensaje'=>$mensaje,'titulo'=>'RECUPERAR MI CONTRASEÑA','meta' =>$meta),true);
		$this->load->view('plantilla/default');
 	}

 	public function resetPassword($random='')
 	{
		$this->load->library('encrypt');

 		$mensaje='';
		$reset_password=$this->session->userdata('resetPassword','email');

 		if( !$this->session->userdata('resetPassword') || $reset_password['random']!=$random  ){
 			show_error('El tiempo de la sesion ha expitado o su clave es incorrecta');
 		}


 		$usuario=new Usuario();

 		$usuario->validation=array(
			'password' => array('rules' => array('required', 'trim', 'min_length' => 3)),
			'confirmar' => array('rules' => array('required','trim','confirmarPassword' => array('password','confirmar') ) )
		);

		if( $this->input->post('tienda_registro')=='TRS6745-*1' && !$this->input->post('tienda_email_field') )
		{
			$usuario->from_array($_POST,array('password','confirmar'));
			$usuario->validate();
			if($usuario->valid){
		       $usuario->where('email',$reset_password['email'])->update('password',$this->encrypt->encode($this->input->post('password')) );
		       $this->session->unset_userdata('resetPassword');
		       $this->session->set_flashdata('mensaje', 'Su password se modificó exitosamente, ingrese con su nuevo password');
		       redirect('tienda/cuenta/login', 'refresh');
		    }
		}

  		$meta=array('titulo'=>'','descripcion'=>'','palabras_clave'=>'');
 		$this->layout_content=$this->load->view('resetPasswrod',array('usuario'=>$usuario,'mensaje'=>$mensaje,'titulo'=>'RESETEAR MI CONTRASEÑA','meta' =>$meta),true);
		$this->load->view('plantilla/default');
 	}

	public function login()
	{
		$this->load->library('encrypt');

		$usuario=new Usuario();
		$user=new Usuario();

		if( $this->input->post('tienda_registro')=='TRS6745-*1' && !$this->input->post('tienda_email_field' ) )
		{

			/*Cambio de la validacion establecida en el modelo*/
			$usuario->validation=array(
				'email' => array('rules' => array('required','valid_email')),
				'password' => array('rules' => array('required'))
			);

			$usuario->from_array($_POST,array('email','password'));
			$usuario->validate();


			if($usuario->valid)
			{

				$user->where('email',$this->input->post('email'))->where('is_enable',1)->get();

				if( $user->exists()  &&  $this->encrypt->decode($user->password)==$this->input->post('password') ){
					$this->_session($user);
					if($this->input->get('to')){
						redirect($this->input->get('to'));
					}else{
					redirect('tienda/cuenta/micuenta');
					}
			    }else
			    {
			    	$usuario->not_found='Usuario o password incorrecto';
			    }
			}
		}

		$meta=array('titulo'=>'Accede a tu cuenta','descripcion'=>'','palabras_clave'=>'');
		$this->layout_content=$this->load->view(
			'login',
			array(
				'usuario'=>$usuario,
				'titulo' =>'INGRESA A TU CUENTA',
				'meta'   =>$meta
			),true);
		$this->load->view('plantilla/default');
	}

	public function logout($ruta="") {

		identificar();

		$this->session->sess_destroy();
		redirect($this->input->get('ruta'));
	}

}
