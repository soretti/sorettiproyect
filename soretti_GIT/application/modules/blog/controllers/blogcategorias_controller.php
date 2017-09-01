<?php

class BlogCategorias_controller extends MX_Controller
{
	protected $per_page=40;

	public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('pagina');

    }

    function blog(){ 
        $pagina=new Pagina();
        
        $pagina->get_by_uri('alga-espirulina');

        $articulos=new Articulo;

        $categorias=new Blog_Categoria();
        $categorias->where(array('is_enable'=>1,'pagina_id'=>$pagina->id))->order_by('sort','ASC')->get();
        $this->load->view('categorias_lateral',array('categorias'=>$categorias,'articulos'=>$articulos,'pagina'=>$pagina));
    }

    function index(){
        $pagina=new Pagina();
        
        if($this->uri->segment(1)=='blogs'){
            $pagina->get_by_uri($this->uri->segment(2));
        }else{
            return false;
        }
        
        $articulos=new Articulo;

        $categorias=new Blog_Categoria();
        $categorias->where(array('is_enable'=>1,'pagina_id'=>$pagina->id))->order_by('sort','ASC')->get();
        $this->load->view('categorias',array('categorias'=>$categorias,'articulos'=>$articulos,'pagina_id'=>$pagina->id));
    }

    public function listar($pagina_id)
    {
        $this->acceso->valida('pagina','consultar',1);
        $categorias=new Blog_Categoria();
        $categorias->where(array('is_enable'=>1,'pagina_id'=>$pagina_id))->order_by('sort','asc')->get();

        $this->titulo = 'LISTA DE CATEGORIAS';
        $this->layout_content =  $this->load->view('blog/categoria_grid',array('categorias'=>$categorias,'pagina_id'=>$pagina_id),TRUE);
        $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/blogcategorias_editar.js'))
        );
        $this->load->view('plantilla/backend/form');
    }

    public function agregar($pagina_id)
    {
        $this->acceso->valida('pagina','consultar',1);
        $categoria=new Blog_Categoria();
        $this->titulo = 'AGREGAR CATEGORÍA';
        $this->layout_content =  $this->load->view('blog/categoria_form',array('categoria'=>$categoria,'pagina_id'=>$pagina_id),TRUE);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($pagina_id,$id)
    {
        $this->acceso->valida('pagina','consultar',1);
        $categoria=new Blog_Categoria($id);
        $this->titulo = 'EDITAR CATEGORÍA';
        $this->layout_content =  $this->load->view('blog/categoria_form',array('categoria'=>$categoria,'pagina_id'=>$pagina_id),TRUE);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($pagina_id,$id=0)
    {
         $this->titulo= ($id) ? "EDITAR" : 'AGREGAR';

        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

        $categoria=new Blog_Categoria($id);

        $rel = $categoria->from_array($_POST, array( 'titulo','metatitulo','uri','descripcion','palabras_clave','titulo_en','metatitulo_en','descripcion_en','palabras_clave_en'));
        $categoria->pagina_id=$pagina_id;
        if(!$id) $categoria->sort='0';

        if($categoria->save($rel)){
            if(!$id){
                $reordenar_categorias=new Blog_Categoria;
                $reordenar_categorias->where(array('pagina_id'=>$pagina_id,'is_enable'=>1))->update(array('sort'=>'sort + 1'),false);
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/blog/blogcategorias/editar/'.$pagina_id.'/'.$categoria->id);
        }else{
            $data['categoria'] = $categoria;
            $data['pagina_id'] = $pagina_id;
            $this->layout_content = $this->load->view('blog/categoria_form', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }


    public function guardar_orden($pagina_id)
    {
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

             if( $this->input->post('categorias') ) foreach ( $this->input->post('categorias') as $key => $categoria_id) {
                $categoria = new Blog_Categoria($categoria_id);
                $categoria->sort=$key;
                $categoria->save();
            }
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/blog/blogcategorias/listar/'.$pagina_id);

    }


    public function eliminar()
    {
        $this->acceso->valida('pagina','eliminar',1);
        $bloque = new Blog_Categoria();
        $bloque->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
    }

}
