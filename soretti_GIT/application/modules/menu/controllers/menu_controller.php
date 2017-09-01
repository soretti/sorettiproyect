<?php
class Menu_controller extends MX_Controller
{
	public function __construct()
    {
        parent::__construct();
         $this->acceso->carga_permisos('pagina');
         $this->load->model('menu/boton');
    }

    public function index()
    {
      $this->load->view('menu-principal', $this->_data() );
    }

    public function simple($id)
    {
      echo $this->load->view('menu-simple', $this->_data($id) ,true);
    }

    public function lista($id){
        $data['menu'] = new Menu();
        $data['menu']->include_related('boton',array('id','titulo','titulo_en','padre_id','posicion','link','target'),TRUE,TRUE)->order_by('posicion');
        $data['menu']->get_by_id($id);
        echo $this->load->view('lista', $data ,true);
    }

    public function superior($id){
        $data['menu'] = new Menu();
        $data['menu']->include_related('boton',array('id','titulo','titulo_en','padre_id','posicion','link','target'),TRUE,TRUE)->order_by('posicion');
        $data['menu']->get_by_id($id);
        echo $this->load->view('superior', $data ,true);
    }
    
    public function _data($id=1)
    {
        $data['menu'] = new Menu();
        $data['menu']->include_related('boton',array('id','titulo','titulo_en','texto','texto_en','padre_id','posicion','link','target'),TRUE,TRUE)->order_by('posicion');
        $data['menu']->get_by_id($id);
        $data['menu_categorias']  =  $data['menu']->get_menu_categorias();
        $data['menu_categorias2'] = $data['menu']->get_menu_categorias2();
        return $data;
    }

    public function agregar()
    {
        $this->titulo='AGREGAR MENU';
        $this->acceso->valida('pagina','editar',1);
        $this->layout_content=$this->load->view('menu/form',array('menu'=>new Menu(),'boton'=>new boton()),TRUE);
        $this->load->view('plantilla/backend/form');
    }

   public function editar($id,$link_id=0)
    {
        $this->titulo='EDITAR MENU';

        $this->acceso->valida('pagina','editar',1);
        $menu = new Menu();
        $menu->include_related('boton',array('id','titulo','titulo_en','padre_id','posicion','target'),TRUE,TRUE)->order_by('posicion');
    	$menu->get_by_id($id);
        $menu->nestable_menu();

        $boton = new Boton($link_id);

    	$this->layout_content=$this->load->view('menu/form',array('menu'=>$menu,'boton'=>$boton),true);
        $this->layout_assets=array(
            'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
            'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
        );

        $this->load->view('plantilla/backend/form');
    }
    public function guardar($id=0)
    {
        $this->titulo= ($id) ? 'EDITAR MENU' : 'AGREGAR MENU';
        $this->acceso->valida('pagina','editar',1);

        $menu = new Menu();
        $menu->include_related('boton',array('id','titulo','titulo_en','padre_id','posicion','target'),TRUE,TRUE)->order_by('posicion');
        $menu->get_by_id($id);
        $menu->from_array($_POST, array('titulo','titulo_en'));
        $menu->arr_orden_links = json_decode($this->input->post('nestable2-output'), true);
        $menu->ordenar_links();

        if($menu->save()){
            if(file_exists(FCPATH.APPPATH."cache/menu_".$id))  $this->cache->file->delete("menu_".$id);
            $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
            redirect('modulo/menu/editar/'.$menu->id);
        }else{
            $menu->nestable_menu();
            $this->layout_assets=array(
                'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
                'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
            );
            $this->layout_content=$this->load->view('menu/form',array('menu'=>$menu,'boton'=>new Boton()),TRUE);
            $this->load->view('plantilla/backend/form');


        }
    }
    
    public function guardar_link($menu_id,$id=0)
    {
        $this->titulo='EDITAR MENU';
        $this->acceso->valida('pagina','editar',1);
    	$menu = new Menu();
        $menu->include_related('boton',array('id','titulo','titulo_en','padre_id','posicion'),TRUE,TRUE)->order_by('posicion');
        $menu->get_by_id($menu_id);
        $menu->nestable_menu();

    	$boton = new Boton($id);
    	$rel = $boton->from_array($_POST, array('titulo','titulo_en','texto','texto_en','link','target'));
        $rel['menu'] = $menu;

        if($boton->save($rel)){
            if(file_exists(FCPATH.APPPATH."cache/menu_$menu_id")) $this->cache->file->delete("menu_$menu_id");
            $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
        	redirect('modulo/menu/editar/'.$menu->id);
        }else{
            $this->layout_assets=array(
                'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
                'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/menu_editar.js'))
            );
            $this->layout_content=$this->load->view('menu/form',array('menu'=>$menu,'boton'=>new Boton()),TRUE);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function eliminar_link($id)
    {
        $this->acceso->valida('pagina','eliminar',1);
        $boton = new Boton($id);
        $menu_id = $boton->menu_id;
        $boton->delete();
        if(file_exists(FCPATH.APPPATH."cache/menu_$menu_id"))  $this->cache->file->delete("menu_$menu_id");
        $this->session->set_flashdata('alert_save',$this->lang->line('alert_save'));
        redirect("modulo/menu/editar/$menu_id");
    }
}
