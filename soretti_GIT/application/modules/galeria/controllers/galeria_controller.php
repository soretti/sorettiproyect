<?php
class Galeria_controller extends MX_Controller
{
  protected $per_page=40;

  public function __construct()
    {
        parent::__construct();
        //$this->load->model('galeria/galeria');
        $this->load->model('pagina/pagina');
        $this->load->model('galeria/galeriaimagenes');
        $this->load->library('Image_fit');
        $this->acceso->carga_permisos('pagina');
    }

    public function index($pagina_uri)
    {
        $this->per_page=9;
        $pagina=new Pagina;
        $pagina->get_by_uri($pagina_uri);

        //$this->_busqueda($contacto);
        $pag_segment=3;
        if(IDIOMA) $pag_segment++;
        $total_rows=$pagina->galeriaimagenes->is_active()->count();
        $page=($this->uri->segment($pag_segment)) ? $this->uri->segment($pag_segment)-1 : 0;
        $limit=($page*$this->per_page);
        //$this->_busqueda($contacto);
        //$this->_ordenar($contacto);
        //$pagina->articulo->include_related('usuario');
        // $pagina->articulo->include_related('categoria');
        $pagina->galeriaimagenes->limit($this->per_page, $limit)->is_active()->order_by('id','desc');
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('galeria/'.$this->uri->segment(2));
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $this->pagination->initialize($configuracion_paginador);

        $meta=array('titulo'=>$pagina->{'metatitulo'.IDIOMA},'descripcion'=>$pagina->{'descripcion'.IDIOMA},'palabras_clave'=>$pagina->{'palabras_clave'.IDIOMA});
        $this->layout_content=$this->load->view('index',array('pagina'=>$pagina,'titulo'=>$pagina->{'titulo'.IDIOMA},'meta'=>$meta), TRUE);

        $plantilla = ($pagina->plantilla=='default' || $pagina->plantilla=='') ? 'default' : $pagina->plantilla;
        $this->load->view('plantilla/'.$plantilla);
    }

    public function mostrar_galeria($id)
    {
        $this->load->view('galeria/mostrar_galeria',array( 'item'=>$this->_data_galeria($id) ));
    }


    public function _data(){
        $fg=new Pagina();
        $fg->where('is_enable',1)->order_by('sort','ASC')->get();
        return $fg;
    }

    public function _data_galeria($id){
         $datos = new Pagina($id);
         return $datos;
    }

    public function guardar_orden()
        {
            if(!$_POST) show_error($this->lang->line('alert_request'));
            $this->acceso->valida('pagina','editar',1);

            $slide=new Pagina();
            $slide->get();

            foreach ($this->input->post('slide') as $key => $value) {
                    $slide=new Pagina($value);
                    $slide->sort=$key;
                    $slide->save();
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));

            redirect('modulo/galeria/listar');
    }



    public function listar(){
        $this->titulo='ÁLBUM DE IMAGENES';
        $this->acceso->valida('pagina','consultar',1);
        $galeria=new Galeria;
        $galeria->where(array('is_enable'=>1))->order_by('sort','asc')->get();
        $this->layout_assets=array(
                'js'=>array(base_url('pub/libraries/trahctools/js/galeria_grid.js'))
            );
        $this->layout_content=$this->load->view('galeria/grid',$data=array('galeria'=>$galeria),true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar(){
        $this->titulo='AGREGAR GALERÍA DE IMAGENES';
        $this->acceso->valida('pagina','consultar',1);
        $data['galeria'] = new Pagina();
        $this->layout_assets=array(
                'js'=>array(base_url('pub/libraries/trahctools/js/galeria_agregar.js'))
            );
        $this->layout_content=$this->load->view('galeria/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id)
    {
        $this->titulo='EDITAR ÁLBUM DE IMAGENES';
        $this->acceso->valida('pagina','consultar',1);
        $data['galeria']=new Pagina($id);
        $data['imagenes']=$data['galeria']->galeriaimagenes->where('is_enable',1)->order_by('sort','asc')->get();
        $this->layout_assets=array(
                'js'=>array(base_url('pub/libraries/trahctools/js/galeria_agregar.js'))
            );
        $this->layout_content=$this->load->view('galeria/form',$data,true);
        $this->load->view('plantilla/backend/form');
    }


    public function guardar($id=0)
    {
         $this->titulo= ($id) ? 'EDITAR GALERÍA DE IMAGENES': 'AGREGAR GALERÍA DE IMAGENES';

        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

        $galeria=new Pagina($id);
        $campos=array( 'title');

        $rel = $galeria->from_array($_POST, $campos);
        if(!$id) $galeria->sort='0';

        if($galeria->save($rel)){
            if( $this->input->post('slide') ) foreach ($this->input->post('slide') as $key => $imagen) {
                $imagenes = new Galeriaimagenes($imagen);
                $imagenes->sort=$key;
                $imagenes->save();
            }
            if(!$id){
                $gal=new Pagina();
                $gal->where(array('is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/galeria/editar/'.$galeria->id);
        }else{
            $data['galeria']=$galeria;
        $this->layout_assets=array(
                'js'=>array(base_url('pub/libraries/trahctools/js/galeria_agregar.js'))
            );
        $this->layout_content=$this->load->view('galeria/form',$data,true);
        $this->load->view('plantilla/backend/form');
        }
    }

    public function eliminar()
    {
        $this->acceso->valida('pagina','eliminar',1);
        $galeria = new Pagina();
        $galeria->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/galeria/listar/');
    }

    public function eliminar_imagen()
    {
        $this->acceso->valida('pagina','eliminar',1);
        $galeria = new Galeriaimagenes();
        $galeria->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
    }
    public function guardar_imagen($id_galeria,$id=0)
    {
        $this->titulo= ($id) ? 'EDITAR IMAGEN' : 'AGREGAR IMAGEN';
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

        $galeria=new Galeriaimagenes($id);
        $rel = $galeria->from_array($_POST, array( 'title','description','title_en','description_en','path','pagina_id'));

        if(!$id) $galeria->sort='0';

        if($galeria->save($rel)){
            if(!$id){
                $reordenar_imagenes=new Galeriaimagenes();
                $reordenar_imagenes->where(array('pagina_id'=>$id_galeria,'is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/galeria/editar_imagen/'.$id_galeria.'/'.$galeria->id);
        }else{
            $data['imagenes']=$galeria;
            $data['galeria']=$id_galeria;
            $this->layout_content =  $this->load->view('galeria/form_imagenes', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }
    public function editar_imagen($id_galeria,$id){
        $this->titulo='EDITAR IMAGEN';
        $this->acceso->valida('pagina','consultar',1);
        $data['imagenes'] = new Galeriaimagenes($id);
        $data['galeria'] = $id_galeria;

        $this->layout_content =  $this->load->view('galeria/form_imagenes', $data,true);
        $this->load->view('plantilla/backend/form');
    }
    public function agregar_imagen($id_galeria){
        $this->titulo='AGREGAR IMAGEN';
        $this->acceso->valida('pagina','consultar',1);
        $data['imagenes'] = new Galeriaimagenes();
        $data['galeria'] = $id_galeria;
        $this->layout_content =  $this->load->view('galeria/form_imagenes', $data,true);
        $this->load->view('plantilla/backend/form');
    }

public function prev_recortar(){
        $imagenes=new Galeriaimagenes;
        $this->acceso->valida('pagina','editar',1);
        $imagen=new Image_fit();
        $ruta_imagen=strstr($this->input->post('imagen'),"pub/uploads");
        $data['imagen']=$ruta_imagen;
        $data['imagen']=urldecode($data['imagen']);

        $data['width']=$imagenes->width;
        $data['height']=$imagenes->height;
        $imagen->_inicializar($data);
        $imagen->upload_dir='pub/uploads/thumbs';
        $data['imagen_principal']=$imagen->escalar();

        $data['width']=$imagenes->t_width;
        $data['height']=$imagenes->t_height;
        $imagen->_inicializar($data);
        $imagen->upload_dir='pub/uploads/thumbs';
        $data['imagen_thumb']=$imagen->escalar();

        $data['w']=$imagenes->width;
        $data['h']=$imagenes->height;
        $data['wt']=$imagenes->t_width;
        $data['ht']=$imagenes->t_height;
        $this->load->view("galeria/recortar",$data);
    }

    public function recortar(){

        $this->acceso->valida('pagina','editar',1);
        $crop_imagen=new Image_fit();

        $cordenadas=json_decode($this->input->post('cordenadas_principal'));
        $data['imagen']=$this->input->post('imagen_principal');
        $data['crop_x']=$cordenadas->x;
        $data['crop_y']=$cordenadas->y;
        $data['width']= $cordenadas->x2-$cordenadas->x;
        $data['height']=$cordenadas->y2-$cordenadas->y;
        $crop_imagen->_inicializar( $data );
        $crop_imagen->cortar();

        $cordenadas=json_decode($this->input->post('cordenadas_thumb'));
        $data['imagen']=$this->input->post('imagen_thumb');
        $data['crop_x']=$cordenadas->x;
        $data['crop_y']=$cordenadas->y;
        $data['width']= $cordenadas->x2-$cordenadas->x;
        $data['height']=$cordenadas->y2-$cordenadas->y;
        $crop_imagen->_inicializar( $data );
        $crop_imagen->cortar();

        echo  json_encode(array('response'=>'TRUE'));
    }

}
