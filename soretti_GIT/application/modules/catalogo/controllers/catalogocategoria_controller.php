<?php
class CatalogoCategoria_controller extends MX_Controller
{
    protected $per_page=40;
    
	public function __construct()
    {
        parent::__construct();
         $this->load->model('catalogo/cat_categoria'); 
         $this->load->model('menu/boton'); 
         $this->acceso->carga_permisos('catalogo');
    }

    public function horizontal()
    {
      echo $this->load->view('catalogo/categorias/horizontal', $this->_data() );
    }


    public function index()
    {
      echo $this->load->view('catalogo/categorias/lateral', $this->_data() );
    }

    public function _data($id=1)
    {
        $categorias = new cat_categoria(); 
        $categorias->where('padre_id',0)->or_where('padre_id',null)->order_by('posicion')->get();

        return array('categorias'=>$categorias);
    }

    public function agregar()
    {
        $this->titulo='AGREGAR MENU';
        $this->acceso->valida('catalogo','editar',1);
        $this->layout_content=$this->load->view('catalogo/formCategoria',array('menu'=>new Menu(),'boton'=>new boton()),TRUE);
        $this->load->view('plantilla/backend/form');
    }

   public function editar($link_id=0)
    {

        $this->titulo='EDITAR CATEGORÍA';
        $this->acceso->valida('catalogo','editar',1);
        $menu =new cat_categoria();
        $menu->order_by('posicion')->get();
        $menu->nestable_menu();

        $boton = new cat_categoria($link_id);

    	$this->layout_content=$this->load->view('catalogo/formCategoria',array('menu'=>$menu,'boton'=>$boton),true);
        $this->layout_assets=array(
            'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
            'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
        );
 
        $this->load->view('plantilla/backend/form');
    }
    public function guardar()
    {
        $this->titulo= 'EDITAR CATEGORÍA';
        $this->acceso->valida('catalogo','editar',1);

        $menu = new cat_categoria();
        $menu->order_by('posicion')->get();
        $menu->arr_orden_links = json_decode($this->input->post('nestable2-output'), true);
        $menu->ordenar_links();

        if($menu->save()){
            //if(file_exists(FCPATH.APPPATH."cache/menu_".$id))  $this->cache->file->delete("menu_".$id);
            $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
            redirect('modulo/catalogo/catalogocategoria/editar/');
        }else{
            $menu->nestable_menu();
            $this->layout_assets=array(
                'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
                'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
            );
            $this->layout_content=$this->load->view('catalogo/formCategoria',array('menu'=>$menu,'boton'=>new Boton() ),TRUE);
            $this->load->view('plantilla/backend/form');


        }
    }
    public function guardar_link($menu_id,$id=0)
    {
        $this->titulo='EDITAR CATEGORÍA';
        $this->acceso->valida('catalogo','editar',1);
    	$menu = new cat_categoria();
        $menu->order_by('posicion')->get();
        $menu->nestable_menu();

    	$boton = new cat_categoria($id);
    	
        $rel = $boton->from_array($_POST, array('titulo','metatitulo','uri','descripcion','palabras_clave','imagen','titulo_en','titulo_en','metatitulo_en','descripcion_en','palabras_clave_en','porcentaje'));

        if($boton->save($rel)){
            //if(file_exists(FCPATH.APPPATH."cache/menu_$menu_id")) $this->cache->file->delete("menu_$menu_id");
            $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
        	redirect('modulo/catalogo/catalogocategoria/editar/'.$id);
        }else{
            $this->layout_assets=array(
                'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
                'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
            );
            $this->layout_content=$this->load->view('catalogo/formCategoria',array('menu'=>$menu,'boton'=>new Boton() ),TRUE);
            $this->load->view('plantilla/backend/form');
        }
    }
    public function eliminar_link($id)
    {
        $this->acceso->valida('catalogo','eliminar',1);
        $boton = new cat_categoria($id);
        $boton->delete();
        $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
        redirect("modulo/catalogo/catalogocategoria/editar");
    }

     public function _busqueda($categorias)
    {
        $categorias->clear();
        $like_text=$this->session->userdata('categoria_buscar');
        if($like_text){
            $categorias->group_start()
                     ->or_like(array('id'=>$like_text,'titulo'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($categorias)
    {
        if(!$this->session->userdata('categoria_ordenar'))
            $this->session->set_userdata('categoria_ordenar',array('id','DESC'));
        $order=$this->session->userdata('categoria_ordenar');

        $categorias->order_by($order[0],$order[1]);
    }

    public function listar(){
        $this->titulo='LISTA DE CATEGORÍAS';
        $this->acceso->valida('catalogo','editar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('pagina_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('categoria_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('categoria_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('categoria_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $categorias=new cat_categoria;
        $this->_busqueda($categorias);
        $total_rows=$categorias->where('is_enable',1)->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($categorias);
        $this->_ordenar($categorias);
        $categorias->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/catalogo/catalogocategoria/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);

        $this->layout_content=$this->load->view('catalogo/gridCategorias',array('categorias'=>$categorias),true);
        $this->load->view('plantilla/backend/form');
    }
}
