<?php

class Pagina_controller extends MX_Controller
{
	protected $per_page=40;

	public function __construct()
    {
        parent::__construct();
         $this->acceso->carga_permisos('columna');
         $this->acceso->carga_permisos('pagina');
         $this->load->model('pagina/pagina');
         $this->load->model('usuario/usuario');
         $this->load->model('bloque/bloquecontenidos');
         $this->load->model('menu/menu');
    }

    public function index()
    {  
        $pagina=$this->_get_pagina(); 
        $emails_array=extract_emails( $pagina->{'contenido'.IDIOMA} );
        foreach ($emails_array[0] as $email)  {
            $pagina->{'contenido'.IDIOMA}=str_replace($email, safe_mailto($email), $pagina->{'contenido'.IDIOMA} );
        }
        
        $meta=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('pagina',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta), TRUE);
        $plantilla=($pagina->plantilla) ? $pagina->plantilla : 'default';
        $this->load->view('plantilla/'.$plantilla);
    }

    public function blank()
    {
        $pagina=$this->_get_pagina(4);

        $emails_array=extract_emails( $pagina->{'contenido'.IDIOMA} );
        foreach ($emails_array[0] as $email)  {
            $pagina->{'contenido'.IDIOMA}=str_replace($email, safe_mailto($email), $pagina->{'contenido'.IDIOMA} );
        }


        $meta=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('pagina',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta), TRUE);
        $this->load->view('plantilla/blank');
    }

    public function home()
    { 
        $pagina=$this->_get_pagina_by_id(24);
        $meta=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('pagina',array('pagina'=>$pagina), TRUE);
        $this->load->view('plantilla/home',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta));
    }

    public function _get_pagina($segment=2)
    {
        $this->load->library('user_agent');
        $pagina = new Pagina();
        $pagina->include_related('usuario');
        
        
        if(IDIOMA) $segment++; 
        $uri=$this->uri->segment($segment);
        if(!$uri) $uri='';
        $pagina->is_active()->get_by_uri($uri);
        
        if(!$pagina->id) show_404();
        if ($this->agent->is_browser()){
            $pagina->hits=$pagina->hits+1;
            $pagina->save();
        }
        return $pagina;
    }
    public function _get_pagina_by_id($id)
    {
        $this->load->library('user_agent');
        $pagina = new Pagina();
        $pagina->include_related('usuario');

        $pagina->is_active()->get_by_id($id);
        
        if(!$pagina->id) show_404();
        if ($this->agent->is_browser()){
            $pagina->hits=$pagina->hits+1;
            $pagina->save();
        }
        return $pagina;
    }

    public function _busqueda($paginas)
    {
        $paginas->clear();
        $like_text=$this->session->userdata('pagina_buscar');
        if($like_text){
            $paginas->group_start()
                     ->or_like(array('id'=>$like_text,'titulo'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($paginas)
    {
        if(!$this->session->userdata('pagina_ordenar'))
            $this->session->set_userdata('pagina_ordenar',array('id','DESC'));
        $order=$this->session->userdata('pagina_ordenar');

        $paginas->order_by($order[0],$order[1]);
    }


    public function listar(){
        $this->titulo='LISTA DE PÁGINAS';
        $this->acceso->valida('pagina','consultar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('pagina_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('pagina_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('pagina_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('pagina_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $paginas=new Pagina;
        $this->_busqueda($paginas);
        $total_rows=$paginas->where('is_enable',1)->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($paginas);
        $this->_ordenar($paginas);
        $paginas->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/pagina/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('pagina/grid',array('paginas'=>$paginas),true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar(){
        $this->titulo='AGREGAR PÁGINA';
        $this->acceso->valida('pagina','consultar',1);
        $data['pagina'] = new Pagina();
        $data['pagina']->editable=1;
        $data['pagina']->is_enable=1;
        $this->acceso->valida('pagina','editar',1);

        $data['areas'] = new Bloquecontenidos();
        $data['areas']->where('bloque_id',3)->where('is_enable',1)->order_by('id','asc')->get();

        $this->layout_content=$this->load->view('pagina/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id)
    {
        $this->titulo='EDITAR PÁGINA';
        $this->acceso->valida('pagina','consultar',1);
        $data['pagina']=new Pagina($id);

        $data['areas'] = new Bloquecontenidos();
        $data['areas']->where('bloque_id',3)->where('is_enable',1)->order_by('id','asc')->get();

        $data['menu'] = new Menu();
        $data['menu']->where('is_enable',1)->order_by('id','asc')->get();

        $this->layout_content=$this->load->view('pagina/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($id=0)
    {
        $this->titulo = ($id) ? 'EDITAR PÁGINA' : 'AGREGAR PÁGINA';

        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

        $pagina=new Pagina($id);


        $campos=array( 'bloquecontenido_id','menu_id','titulo','metatitulo','palabras_clave','descripcion','tipo','fecha_creacion','fecha_desactivacion','fecha_activacion','contenido','uri','c_fecha','c_archivo','c_ultimos_post','c_categorias','c_usuario','c_comentarios','c_compartir','c_contacto','titulo_en','uri_en','contenido_en','descripcion_en','palabras_clave_en','metatitulo_en','imagen');


        if($_REQUEST['tipo']=='blogs' && $_REQUEST['tipo_page']==0){
            $_POST['tipo']='blogs';
        }else if($_REQUEST['tipo']=='blogs' && $_REQUEST['tipo_page']==1){
            $_POST['tipo']=1;
        }else if($_REQUEST['tipo']==0 && $_REQUEST['tipo_page']==1){
            $_POST['tipo']=1;
        }else if($_REQUEST['tipo']==0 && $_REQUEST['tipo_page']==0){
            $_POST['tipo']=0;
        }

        $rel = $pagina->from_array($_POST, $campos);

        if(!$id){
            $pagina->fecha_creacion=date('Y-m-d H:i:s');
            $pagina->usuario_id=$this->session->userdata('logged_user');
        }

        if($pagina->save($rel)){
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/pagina/editar/'.$pagina->id);
        }else{
            $data['pagina']=$pagina;
            if(!$id) $data['pagina']->editable=1;
            $this->layout_content=$this->load->view('pagina/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function eliminar()
    {
        $this->acceso->valida('pagina','eliminar',1);
        $pagina = new Pagina();
        $pagina->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/pagina/listar/');
    }


    public function sitemap()
    {
        $this->acceso->valida('pagina','consultar',1);
        $this->recursos->sitemap();
        $this->session->set_flashdata('mensaje','Su mapa del sitio se ha actualizado exitosamente');
        redirect('modulo/pagina/listar/');
    }

    public function checasesion(){
        $this->load->library('session');
        $this->session->set_userdata('popupboletin', '1');
    }

    public function guardar_dato(){
        $this->load->model('boletin/boletin_usuarios');
         
         $this->load->library('form_validation');
         $this->form_validation->set_rules('email','email','required|valid_email|is_unique[boletin_usuarios.email]');
         $this->form_validation->set_error_delimiters('', '');
         $this->form_validation->set_message('is_unique', 'El email ingresado ya fue registrado con anterioridad.');

         if($this->form_validation->run() == false){
            $resultado = form_error('email');
         }else{

             /*Agregar al boletin*/
            if($this->input->post('email')){
                $boletin_usuario = new boletin_usuarios;
                $boletin_usuario->get_by_email($this->input->post('email'));
                if(!$boletin_usuario->exists()){
                    $boletin_usuario->email=$this->input->post('email');
                    $boletin_usuario->fecha_inscripcion=date('Y-m-d H:i:s');
                    $boletin_usuario->skip_validation()->save();
                }
            }

            $resultado = 'SUPERFOOD';
         }

         echo $resultado;
        
    }
    
}
