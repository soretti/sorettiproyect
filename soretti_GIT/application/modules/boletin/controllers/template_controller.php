<?php
class Template_controller extends MX_Controller
{
	public $per_page=30;

	public function __construct()
	{
		parent::__construct();
    	$this->acceso->carga_permisos('boletin');
	}


    public function send()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
	    	die();
	    if($_SERVER['SERVER_ADDR']!=$_SERVER['REMOTE_ADDR'])
	    	die();
	    //if(!strstr($_SERVER['HTTP_USER_AGENT'], "curl"))
	    //	die();


        $this->load->library('email');
        $this->load->library('encrypt');
        $this->load->model('boletin/Newsletter');
        $this->load->model('boletin/Boletin_usuarios');
        $this->load->model('boletin/Boletin_newsletterstatus');

        $cantidad_envios=1;
        
        $enviar=array();
        
        /*Entre las 11:00 pm y '6:00 am se triplica el envio de correos*/
        if( strtotime(date('H:i:s')) >= strtotime(date('23:00:00')) && strtotime(date('H:i:s')) <= strtotime(date('06:00:00')) )
            $cantidad_envios=3;



        $boletines=new Newsletter;
        $boletines->where( array('is_enable'=>1,'status'=>1,'fecha_envio <= '=>date('Y-m-d H:i:s') ))->get();
        $e=0;
        
        foreach ($boletines as $boletin) {
            $boletin->Boletin_newsletterstatus->include_related('boletin_usuarios')->where('enviado','0')->limit($cantidad_envios)->get();

            /* Cambiar el status a completado si no  hay mas correos que enviar*/
            if(!$boletin->Boletin_newsletterstatus->result_count()) {
                $boletin->status=3;
                $boletin->save();
            }

            foreach($boletin->Boletin_newsletterstatus as $newsletterstatus){
                $enviar[$e]['newsletterstatus']=$newsletterstatus->id;
                $e++;
            }
        }

       


        if( count($enviar) > $cantidad_envios)
        	shuffle($enviar);

        $i=0; foreach ($enviar as $item){
        	$this->email->clear();
        	if($i>=$cantidad_envios) break;

            $newsletterstatus=new Boletin_newsletterstatus;
            $newsletterstatus->include_related('newsletter',array('asunto','contenido'));
            $newsletterstatus->include_related('boletin_usuarios',array('id','nombre','apellidoPaterno','apellidoMaterno','email'));
            $newsletterstatus->include_related('newsletter/cuentas');
            $newsletterstatus->get_by_id($item['newsletterstatus']);

	        $config['protocol'] = 'smtp';
	        $config['smtp_host'] = $newsletterstatus->newsletter_cuentas_host;
	        $config['smtp_user'] = $newsletterstatus->newsletter_cuentas_email;
	        $config['smtp_pass'] = $this->encrypt->decode($newsletterstatus->newsletter_cuentas_password);
	        $config['smtp_port'] =  $newsletterstatus->newsletter_cuentas_puerto;
	        $config['mailtype'] = 'html';
	        $config['charset'] = 'utf-8';
	        $this->email->initialize($config);

	        /*Remplazar los tags por el contenido real*/
	        $tags=$this->config->item('boletin','proyecto');
	        $tags['usuario_nombre']=$newsletterstatus->boletin_usuarios_nombre." ".$newsletterstatus->boletin_usuarios_apellidoPaterno." ".$newsletterstatus->boletin_usuarios_apellidoMaterno;
	        $tags['usuario_email']=$newsletterstatus->boletin_usuarios_email;
	        
	        foreach ($tags as $tag=>$valor) {
	        	if($tag=='cancelar_suscripcion') $valor=str_replace('{unsuscribe}',urlencode($this->encrypt->encode('byemail+'.$newsletterstatus->boletin_usuarios_id,'byetonews'))."&nstatus=".$newsletterstatus->id, $valor);
	        	$newsletterstatus->newsletter_contenido=str_replace("{".$tag."}",$valor,$newsletterstatus->newsletter_contenido);
	        }
	        
            $this->email->from($newsletterstatus->newsletter_cuentas_email, $newsletterstatus->newsletter_cuentas_alias);
            $this->email->to($newsletterstatus->boletin_usuarios_email);
            $this->email->subject($newsletterstatus->newsletter_asunto);
            $this->email->message($newsletterstatus->newsletter_contenido);

            $newsletterstatus->enviado=1;
            $newsletterstatus->fecha_envio=date('Y-m-d H:i:s');
            if($this->email->send()){
                $newsletterstatus->debug=$this->email->print_debugger();
            }
            $newsletterstatus->skip_validation()->save();
        $i++;
    	}
    }


    public function content_template($id){
        $template=new Template($id);
        echo $template->contenido;
    }

    public function json_templates()
    {
        $templates=new Template;

        $templates->select('id,titulo')->where(array('is_enable'=>1))->get();

        $lista_templates=array();
        foreach ($templates as $i=>$template) {
            $lista_templates[$i]['title']=$template->titulo;
            $lista_templates[$i]['url']= base_url('modulo/boletin/template/content_template/'.$template->id);
        }
        echo json_encode($lista_templates);

    }

	public function _busqueda($templates)
	    {
	        $templates->clear();

	        $like_text=$this->session->userdata('boletintemplate_buscar');

	        if($like_text){
	            $templates->group_start()
	                     ->or_like(array('titulo' => $like_text))
	                     ->group_end();
	        }
	    }

    public function _ordenar($templates)
    {
        if(!$this->session->userdata('boletintemplate_ordenar'))
            $this->session->set_userdata('boletintemplate_ordenar',array('id','DESC'));
        
        $order=$this->session->userdata('boletintemplate_ordenar');
        $templates->order_by($order[0],$order[1]);
    }

	/**CRUD**/

	public function listar(){

	        $this->titulo='LISTA DE TEMPLATES';
	        $this->acceso->valida('boletin','consultar',1);

	        //buscar
	        if($this->input->post('action_buscar')){
	            $this->session->set_userdata('boletintemplate_buscar',$this->input->post('buscar'));
	        }

	        //ordenar
	        if($this->input->post('ordenar')){
	            $order=$this->session->userdata('boletintemplate_ordenar');
	            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
	                $this->session->set_userdata('boletintemplate_ordenar',array($this->input->post('ordenar'),'DESC'));
	            else
	                $this->session->set_userdata('boletintemplate_ordenar',array($this->input->post('ordenar'),'ASC'));
	        }

	        $templates=new Template;
	        $this->_busqueda($templates);
	        $total_rows=$templates->count();
	        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
	        $limit=($pagina*$this->per_page);
	        $this->_busqueda($templates);
	        $this->_ordenar($templates);
	        $templates->limit($this->per_page, $limit)->order_by('id','desc')->get();

	        /*Paginador*/
	        $configuracion_paginador=$this->config->item('pagination');
	        $configuracion_paginador['base_url'] = base_url('modulo/boletin/template/listar/');
	        $configuracion_paginador['total_rows'] = $total_rows;
	        $configuracion_paginador['per_page'] = $this->per_page;
	        $configuracion_paginador['uri_segment'] = 5;
	        $this->pagination->initialize($configuracion_paginador);
	        $this->layout_content=$this->load->view('boletin/template/grid',array('templates'=>$templates),true);
	        $this->load->view('plantilla/backend/form');
	    
	    }



	    public function agregar(){
	        $this->titulo='AGREGAR TEMPLATE';
	        $this->acceso->valida('boletin','consultar',1);
	        $data['template'] = new Template();
	        $this->acceso->valida('boletin','editar',1);
	        $this->layout_content=$this->load->view('boletin/template/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }


	    public function guardar($id=0){

	        $this->titulo = ($id) ? 'EDITAR TEMPLATE':'AGREGAR TEMPLATE';

	        if(!$_POST) show_error($this->lang->line('alert_request'));
	        $this->acceso->valida('boletin','editar',1);
	        $template=new Template($id); 
	        $campos=array('titulo','contenido');
	        $template->from_array($_POST, $campos);
	        if($template->save()){
            		$this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            		redirect('modulo/boletin/template/editar/'.$template->id);
	        }else{
	            $data['template']=$template;
	            $this->layout_content=$this->load->view('boletin/template/form',$data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    } 

	    public function editar($id)
	    {
	        $this->titulo='EDITAR TEMPLATE';
	        $this->acceso->valida('boletin','consultar',1);
	        $data['template']=new Template($id); 
	        $this->layout_content=$this->load->view('boletin/template/form',$data,true);
	        $this->load->view('plantilla/backend/form');
	    }

	    public function eliminar()
	    {
	        $this->acceso->valida('boletin','eliminar',1);
	        $template = new Template();
	        $template->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
	        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	        redirect('modulo/boletin/template/listar/');
	    }
}
