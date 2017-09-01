<?php

class Blog_controller extends MX_Controller
{
	protected $per_page=9;

	public function __construct()
    {
        parent::__construct();
        $this->load->model('pagina/pagina');
        $this->acceso->carga_permisos('pagina');
        $this->load->model('usuario/usuario');
        $this->acceso->carga_permisos('columna');

    }

    function index($pagina_uri=''){ 
        if(!$pagina_uri) redirect(site_url(), 'refresh');  
        $this->per_page=9;
        $pagina=new Pagina;
        $pagina->get_by_uri($pagina_uri);

        if($pagina->id==48) $this->per_page=4;

        //$this->_busqueda($contacto);
        $pag_segment=3;
        if(IDIOMA) $pag_segment++;
        $total_rows=$pagina->articulo->is_active()->count();
        $page=($this->uri->segment($pag_segment)) ? $this->uri->segment($pag_segment)-1 : 0;
        $limit=($page*$this->per_page);
        //$this->_busqueda($contacto);
        //$this->_ordenar($contacto);
        $pagina->articulo->include_related('usuario');
        // $pagina->articulo->include_related('categoria');
        $pagina->articulo->limit($this->per_page, $limit)->is_active()->order_by('fecha_creacion','desc');
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('blog/'.$this->uri->segment(2));
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $configuracion_paginador['suffix'] = '.html';
        $configuracion_paginador['first_url'] = site_url('blog/'.$this->uri->segment(2));;
        $this->pagination->initialize($configuracion_paginador);


        $metatitulo=$pagina->{'metatitulo'.IDIOMA};
        if($this->uri->segment(3)){
            $metatitulo=$metatitulo." pagina ".$this->uri->segment(3);
        }

        $meta=array('titulo'=>$metatitulo,'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('blog',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta), TRUE);

        $plantilla = ($pagina->plantilla=='default' || $pagina->plantilla=='') ? 'default' : $pagina->plantilla;
        $this->load->view('plantilla/'.$plantilla,array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta));
    }

    function mostrar($pagina_uri){

        $pagina=new Articulo;
        $pagina->get_by_uri($pagina_uri);

        echo $pagina->conte; die();

        $meta=array('metatitulo'=>$pagina->{'metatitulo'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('plantilla/contenido',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta), TRUE);

    }


    function categoria($pagina_uri,$categoria_uri){
        $categoria= new Blog_categoria;
        $categoria->get_by_uri($categoria_uri);
        $pagina=new Pagina;
        $pagina->get_by_uri($pagina_uri);

        //$this->_busqueda($contacto);
        $pag_segment=5;
        if(IDIOMA) $pag_segment++;

        $total_rows=$pagina->articulo->where_related_blog_categoria('uri',$categoria_uri)->is_active()->count();
        $page=($this->uri->segment($pag_segment)) ? $this->uri->rsegment($pag_segment)-1 : 0;

        $limit=($page*$this->per_page);
        //$this->_busqueda($contacto);
        //$this->_ordenar($contacto);
        $pagina->clear();
        $pagina->get_by_uri($pagina_uri);
        $pagina->include_related('blog_categoria');
        $pagina->articulo->include_related('blog_categoria');
        $pagina->articulo->include_related('usuario');


        $pagina->articulo->limit($this->per_page, $limit)->where_related_blog_categoria('uri',$categoria_uri)->is_active()->order_by('id','desc');
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('blog/'.$pagina_uri."/categoria/".$categoria_uri);
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $configuracion_paginador['suffix'] = '.html';
        $this->pagination->initialize($configuracion_paginador);

        $titulo=$pagina->titulo." <small>".$categoria->titulo."</small>";

        $metatitulo=$categoria->{'metatitulo'.IDIOMA};
        if($this->uri->segment(5)){
            $metatitulo=$metatitulo." pagina ".$this->uri->segment(5);
        }

        $meta=array('titulo'=>$metatitulo,'descripcion'=>$categoria->{'descripcion'.IDIOMA},'palabras_clave'=>$categoria->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('blog',array('pagina'=>$pagina,'titulo'=>$titulo,'meta'=>$meta,'categoria'=>$categoria), TRUE);
        $plantilla = ($pagina->plantilla=='default' || $pagina->plantilla=='') ? 'default' : $pagina->plantilla;
        $this->load->view('plantilla/'.$plantilla);
    }

    function archivo($pagina_uri,$year,$month){

        //$categoria= new Blog_categoria;

        //$categoria->get_by_uri($categoria_uri);

        $month=$this->dateutils->months_string($month);

        if(!is_numeric($year) || !$month){

            show_error('datos incorrecto');

        }

        $pagina=new Pagina;

        $pagina->get_by_uri($pagina_uri);



        //$this->_busqueda($contacto);

        $pag_segment=6;

        if(IDIOMA) $pag_segment++;



        $total_rows=$pagina->articulo->where(array('YEAR(fecha_creacion)'=>$year,'MONTH(fecha_creacion)'=>$month))->is_active()->count();  

        $page=($this->uri->segment($pag_segment)) ? $this->uri->rsegment($pag_segment)-1 : 0;



        $limit=($page*$this->per_page);

        //$this->_busqueda($contacto);

        //$this->_ordenar($contacto);

        $pagina->clear();

        $pagina->get_by_uri($pagina_uri);

        $pagina->include_related('blog_categoria');

        $pagina->articulo->include_related('blog_categoria',array('titulo','uri','id'));

        $pagina->articulo->include_related('usuario',array('nombre','id'));
        
        $articulos=$pagina->articulo->limit($this->per_page, $limit)->where(array('YEAR(blog_articulos.fecha_creacion)'=>$year,'MONTH(blog_articulos.fecha_creacion)'=>$month))->is_active()->order_by('id','desc');

        /*Paginador*/

        $configuracion_paginador=$this->config->item('pagination');

        $configuracion_paginador['base_url'] = base_url('blog/'.$pagina_uri."/archivo/".$year."/".$this->dateutils->months($month));

        $configuracion_paginador['total_rows'] = $total_rows;

        $configuracion_paginador['per_page'] = $this->per_page;

        $configuracion_paginador['uri_segment'] = $pag_segment;

        $this->pagination->initialize($configuracion_paginador);



        $meta=array('titulo'=>'Blog Alga Espirulina - Archivo','descripcion'=>'','palabras_clave'=>'');

        $this->layout_content=$this->load->view('blog',array('articulos'=>$articulos,'pagina'=>$pagina,'meta'=>$meta,'year'=>$year,'month'=>$month), TRUE);

        $plantilla = ($pagina->plantilla=='default' || $pagina->plantilla=='') ? 'default' : $pagina->plantilla;

        $this->load->view('plantilla/'.$plantilla);

    }

    function post($pagina_uri,$post_uri)
    {
        $this->load->library('user_agent');

        $pagina=new Pagina();
        $pagina->get_by_uri($pagina_uri);
        $post=new Articulo;
        $post->include_related('usuario');
        $post->include_related('blog_categoria');
        $post->get_by_uri($post_uri);

        if(!$post->id) show_404();

        if($this->agent->is_browser()){
            $post->hits=$post->hits+1;
            $post->save();
        }

        $meta=array('titulo'=>$post->{'metatitulo'.IDIOMA},'descripcion'=>$post->{'resumen'.IDIOMA},'palabras_clave'=>$post->{'palabras_clave'.IDIOMA});

        $navegacion_array[]=array('titulo'=>$pagina->{'titulo'.IDIOMA},'uri'=>'blog/'.$pagina->uri);

        $this->layout_content=$this->load->view('post',array('post'=>$post,'pagina'=>$pagina,'titulo'=>$post->{'titulo'.IDIOMA},'meta'=>$meta,'navegacion'=>$navegacion_array ), TRUE);
        $plantilla = ($pagina->plantilla=='default' || $pagina->plantilla=='') ? 'default' : $pagina->plantilla;
        $this->load->view('plantilla/'.$plantilla);
    }

    function plugin_archivo(){


       if($this->uri->segment(1)!='blogs')
            return false;
        $pagina=new Pagina();
        $pagina->get_by_uri($this->uri->segment(2));
        if(!$pagina->c_archivo){
            return false;
        }
 
        $this->load->library('dateutils');

        $articulo=new Articulo;

        $archivo=new Articulo;

        $offset_year=date('Y')-1;

        $archivo->select('YEAR(fecha_creacion) as year, MONTH(fecha_creacion) as month')->is_active()->where('pagina_id',$pagina->id)->where('YEAR(fecha_creacion) >=',$offset_year)->group_by('YEAR(fecha_creacion)')->group_by('MONTH(fecha_creacion)')->order_by('fecha_creacion DESC')->get();

        $this->load->view('blog/plugin_archivo',array('archivo'=>$archivo,'articulos'=>$articulo));
    }

 public function _busqueda($articulo)
    {
        $articulo->clear();

        $like_text=$this->session->userdata('pagina_buscar');

        if($like_text){
            $articulo->group_start()
                     ->or_like(array('titulo' => $like_text, 'contenido' => $like_text, 'uri' => $like_text, 'palabras_clave' => $like_text, 'resumen' => $like_text))
                     ->group_end();
        }
    }

    public function _ordenar($articulo)
    {
        if(!$this->session->userdata('pagina_ordenar'))
            $this->session->set_userdata('pagina_ordenar',array('id','DESC'));
        $order=$this->session->userdata('pagina_ordenar');

        $articulo->order_by($order[0],$order[1]);
    }


    public function listar($pagina_id=0){

        $this->titulo='LISTA';

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

        $articulo=new Articulo;
        $this->_busqueda($articulo);
        $total_rows=$articulo->where(array('is_enable'=>1,'pagina_id'=>$pagina_id))->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($articulo);
        $this->_ordenar($articulo);
        $articulo->limit($this->per_page, $limit)->where( array('is_enable'=>1,'pagina_id'=>$pagina_id) )->order_by('id','desc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/blog/listar/'.$pagina_id);
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content=$this->load->view('blog/grid',$data=array('paginas'=>$articulo,'pagina_id'=>$pagina_id,'bdpagina'=>new Pagina($pagina_id)),true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar($pagina_id){
        $this->titulo='EDITAR';
        $this->acceso->valida('pagina','consultar',1);
        $data['articulo'] = new Articulo();
        $data['articulo']->fecha_creacion = date('Y-m-d H:i:s');
        $data['categorias']=new Blog_Categoria;
        $data['categorias']->where(array('pagina_id'=>$pagina_id,'is_enable'=>1))->get();
        $data['pagina_id'] = $pagina_id;
        $data['pagina']=new Pagina($pagina_id);
        $this->layout_content=$this->load->view('blog/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($pagina_id,$id)
    {
        $this->titulo='EDITAR';
        $this->acceso->valida('pagina','consultar',1);
        $data['articulo']=new Articulo($id);
        $data['categorias']=new Blog_Categoria;
        $data['categorias']->where(array('pagina_id'=>$pagina_id,'is_enable'=>1))->get();
        $data['pagina_id'] = $pagina_id;
        $data['pagina']=new Pagina($pagina_id);
        $this->layout_content=$this->load->view('blog/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($pagina_id,$id=0)
    {
        $this->titulo='EDITAR';
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

        $articulo=new Articulo($id);
        $campos=array( 'footer_titulo','footer_subtitulo','footer_imagen','footer_liga','footer_target','fecha_creacion','fecha_activacion','fecha_desactivacion', 'titulo','metatitulo', 'contenido','datos', 'uri', 'palabras_clave', 'resumen','resumen_imagen','pie','perfil','categoria_id','titulo_en','metatitulo_en','contenido_en','datos_en','palabras_clave_en','resumen_en');

        $rel = $articulo->from_array($_POST, $campos);

        if(!$id){
            $articulo->pagina_id=$pagina_id;
            $articulo->usuario_id= $this->session->userdata('logged_user');
        }

        if($articulo->save($rel)){
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/blog/editar/'.$pagina_id.'/'.$articulo->id);
        }else{
            $data['articulo']=$articulo;
            $data['categorias']=new Blog_Categoria;
            $data['categorias']->where(array('pagina_id'=>$pagina_id,'is_enable'=>1))->get();
            $data['pagina_id']=$pagina_id;
            $data['pagina']=new Pagina($pagina_id);
            $this->layout_content=$this->load->view('blog/form',$data,true);
            $this->load->view('plantilla/backend/form');

        }
    }

    public function eliminar($pagina_id)
    {
        $this->acceso->valida('pagina','eliminar',1);
        $articulo = new Articulo();
        $articulo->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/blog/listar/'.$pagina_id);
    }

    public function ultimos_post(){
        if($this->uri->segment(1)!='blog')
            return false;
        $data['listado']=new Articulo();
        $blog=new Pagina();
        $blog->get_by_uri($this->uri->segment(2));

        if(!$blog->c_ultimos_post){
            return false;
        }

        $data['blog']=$blog;
        $data['listado']->where('pagina_id',$blog->id)->is_active()->order_by('fecha_creacion','desc')->get();
        if( $blog->tipo=='blogs' ) $this->load->view('blog/ultimos_post',$data);

    }
    public function ultimos_post_blog(){
        $data['listado']=new Articulo();
        $blog=new Pagina();
        $blog->get_by_uri('alga-espirulina');

        if(!$blog->c_ultimos_post){
            return false;
        }

        $data['blog']=$blog;
        $data['listado']->include_related('blog_categoria');

        $data['listado']->where('pagina_id',$blog->id)->is_active()->order_by('fecha_creacion','desc')->limit(4)->get();
        if( $blog->tipo=='blogs' ) $this->load->view('blog/ultimos_post',$data);

    }


    function plugin_archivo_blog(){


        $pagina=new Pagina();
        $pagina->get_by_uri('alga-espirulina');
        if(!$pagina->c_archivo){
            return false;
        }
 
        $this->load->library('dateutils');

        $articulo=new Articulo;

        $archivo=new Articulo;

        $offset_year=date('Y')-1;

        $archivo->select('YEAR(fecha_creacion) as year, MONTH(fecha_creacion) as month')->is_active()->where('pagina_id',$pagina->id)->where('YEAR(fecha_creacion) >=',$offset_year)->group_by('YEAR(fecha_creacion)')->group_by('MONTH(fecha_creacion)')->order_by('fecha_creacion DESC')->get();

        $this->load->view('blog/plugin_archivo',array('archivo'=>$archivo,'articulos'=>$articulo,'pagina'=>$pagina));
    }



    public function solicitar_informacion($id=''){



        $this->load->model('boletin/grupos');

        $this->load->model('boletin/boletin_usuarios');

    
        // if(!$id) show_error('información incompleta1');

        if(!$_POST) show_error('información incompleta2');

        //$producto= new Articulo($id);
        $tipo_pagina[1]='Parallax';
        $tipo_pagina[2]='Estandar';
        $tipo_pagina[3]='Profesional';
        $tipo_pagina[4]='Tienda';

        //if(!$producto->result_count()) show_error('información incompleta3');

        $proyecto=$this->config->item('proyecto');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('privacidad', 'Privacidad', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lada', 'Lada', 'trim|required|xss_clean');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'trim|required|xss_clean');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        $this->form_validation->set_rules('texto', 'Mensaje', 'required|xss_clean');

        if($this->input->post('boletin')){

            $this->form_validation->set_rules('grupos', $this->lang->line('grupos'), 'required');

        }        

        $this->form_validation->set_error_delimiters('', '');

        $datos['enviado']='';

        if($this->input->post('mcontacto')=='TRS6745-*1' && $this->form_validation->run())

        {

            if($this->input->post('email_field')!='')

            {

                $datos['error']=validation_errors();

            }

            $config['mailtype']='html';

            $config['wordwrap'] = FALSE;

            $this->load->library('email');

            $this->email->initialize($config);

            $this->email->from($this->input->post('email'));

            $this->email->to($proyecto['email_contacto']);

            $this->email->subject($proyecto['titulo'].' | Solicitud de cotización | '.$this->input->post('nombre'));

            $mensaje="Nombre: ".$this->input->post('nombre')."<br>";

            $mensaje.="E-mail: ".$this->input->post('email')."<br>";

            $mensaje.="Teléfono: ".$this->input->post('lada')."-".$this->input->post('telefono')."<br>";

            $mensaje.="Tipo de Página: ".$tipo_pagina[$id]."<br>";

            $mensaje.="Mensaje: <br>".$this->input->post('texto')."<br>";

            $this->email->message($mensaje);

            if ($this->email->send())

            {

            /*Agregar al boletin*/

            if($this->input->post('boletin')){

                $boletin_usuario = new boletin_usuarios;

                $boletin_usuario->get_by_email($this->input->post('email'));

                if(!$boletin_usuario->exists()){

                    $boletin_usuario->email=$this->input->post('email');

                    $boletin_usuario->nombre=$this->input->post('nombre');

                    $boletin_usuario->grupos=implode(",",$this->input->post('grupos'));

                    $boletin_usuario->skip_validation()->save();

                }                

            }                

                $datos['enviado']='Se envió correctamente su correo.';

            }

        }else{

            $datos['error']=validation_errors();

        }

        echo json_encode($datos);

    }


}
