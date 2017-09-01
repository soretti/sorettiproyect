<?php
class CatalogoAtributo_controller extends MX_Controller
{
	protected $per_page=40;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('catalogo/atributo');
        $this->acceso->carga_permisos('catalogo');
    }

    public function _busqueda($atributos)
    {
        $atributos->clear();
        $like_text=$this->session->userdata('atributo_buscar');
        if($like_text){
            $atributos->group_start()
            ->or_like(array('id'=>$like_text,'nombre'=>$like_text))
            ->group_end();
        }
    }

    public function _ordenar($atributos)
    {
        if(!$this->session->userdata('atributo_ordenar'))
            $this->session->set_userdata('atributo_ordenar',array('id','DESC'));
        $order=$this->session->userdata('atributo_ordenar');

        $atributos->order_by($order[0],$order[1]);
    }

    public function listar(){
     $this->titulo='LISTA DE ATRIBUTOS';
     $this->acceso->valida('catalogo','editar',1);

     if($this->input->post('action_buscar')){
        $this->session->set_userdata('pagina_buscar',$this->input->post('buscar'));
    }

    if($this->input->post('ordenar')){
       $order=$this->session->userdata('atributo_ordenar');
       if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
        $this->session->set_userdata('atributo_ordenar',array($this->input->post('ordenar'),'DESC'));
    else
        $this->session->set_userdata('atributo_ordenar',array($this->input->post('ordenar'),'ASC'));
}

$atributo = new atributo;
$this->_busqueda($atributo);
$total_rows=$atributo->where('padre_id =',0)->where('tipo !=',0)->where('is_enable',1)->count();
$pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
$limit=($pagina*$this->per_page);
$this->_busqueda($atributo);
$this->_ordenar($atributo);
$atributo->limit($this->per_page, $limit)->where('padre_id =',0)->where('tipo !=',0)->where('is_enable',1)->order_by('id','asc')->get();


$configuracion_paginador=$this->config->item('pagination');
$configuracion_paginador['base_url'] = base_url('modulo/catalogo/catalogoatributo/listar');
$configuracion_paginador['total_rows'] = $total_rows;
$configuracion_paginador['per_page'] = $this->per_page;
$configuracion_paginador['uri_segment'] = 5;
$this->pagination->initialize($configuracion_paginador);

$this->layout_content = $this->load->view('catalogo/gridAtributo',array('atributo'=>$atributo),true);
$this->load->view('plantilla/backend/form');
}

public function agregar()
{
    $this->titulo='AGREGAR ATRIBUTO';
    $this->acceso->valida('catalogo','consultar',1);

    $atributo = new atributo();
    $data['atributo'] = $atributo;

    $valor = new atributo();
    $data['valor'] = $valor;

    $this->layout_content=$this->load->view('catalogo/formAtributo',$data,TRUE);
    $this->load->view('plantilla/backend/form');
}

public function guardar($id=0){

   $this->titulo = ($id) ? 'EDITAR ATRIBUTO':'AGREGAR ATRIBUTO';

   if(!$_POST) show_error($this->lang->line('alert_request'));

   $this->acceso->valida('catalogo','editar',1);

   $atributo=new atributo($id);

   $campos=array('nombre','tipo');
   $atributo->from_array($_POST, $campos);

   if($atributo->save()){
      $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
      redirect('modulo/catalogo/catalogoatributo/editar/'.$atributo->id);
  }else{
      $data['atributo'] = $atributo;
      $data['valor'] = new atributo();

      $valores = new atributo();
      $valores->where('is_enable =',1)->where("padre_id",$id)->get();
      $data['valores'] = $valores;

      $this->layout_content=$this->load->view('catalogo/formAtributo',$data,true);
      $this->layout_assets=array(
            'js'=>array(
                base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.js'),
                base_url('pub/libraries/trahctools/js/bloque_editar.js')
                ),
            'css'=>array(base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.css')
                ));
      $this->load->view('plantilla/backend/form');
  }
}

public function guardarvalor($atributo_id=0) {

   if($atributo_id){

      $valor = new atributo();
      $valor->padre_id = $atributo_id;
      $valor->from_array($_POST, array("nombre","micolor"));


      if($valor->save()){
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/catalogo/catalogoatributo/editar/'.$atributo_id);
    }else{
        $this->titulo = ($atributo_id) ? 'EDITAR ATRIBUTO':'AGREGAR ATRIBUTO';
        $data['atributo']=new atributo($atributo_id);
        $data['valor']=$valor;

        $valores = new atributo();
        $valores->where('is_enable =',1)->where("padre_id",$atributo_id)->get();
        $data['valores'] = $valores;

        $this->layout_content=$this->load->view('catalogo/formAtributo',$data,true);
        $this->layout_assets=array(
            'js'=>array(
                base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.js'),
                base_url('pub/libraries/trahctools/js/bloque_editar.js')
                ),
            'css'=>array(base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.css')
                ));
        $this->load->view('plantilla/backend/form');
    }
}
}

public function editar($id=0)
{

    $this->titulo='EDITAR ATRIBUTO';
    $this->acceso->valida('catalogo','consultar',1);
    $data['atributo']=new atributo($id);
    $valor = new atributo();
    $data['valor'] = $valor;

    $valores = new atributo();
    $valores->where('is_enable =',1)->where("padre_id",$id)->order_by("sort")->get();
    $data['valores'] = $valores;

    $this->layout_content=$this->load->view('catalogo/formAtributo',$data,true);

    $this->layout_assets=array(
        'js'=>array(
            base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.js'),
            base_url('pub/libraries/trahctools/js/bloque_editar.js')
            ),
        'css'=>array(base_url('pub/libraries/bgrins-spectrum-a7bb45b/spectrum.css')
            ));


    $this->load->view('plantilla/backend/form');
}

public function ordenarvalores($atributo_id=0)
{
    if($atributo_id && $this->input->post('valores_id')){

        foreach ($this->input->post('valores_id') as $key => $id) {
            $valor = new atributo($id);
            $valor->sort=$key;
            $valor->save();

                //$valor->check_last_query();
        }
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/catalogo/catalogoatributo/editar/'.$atributo_id); 
    }
}

public function eliminarvalor($atributo_id=0, $id=0) {

    if($atributo_id && $id){
        $valor = new atributo($id);

        $valor->is_enable = 0;
        $valor->save();
    }
    $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
    redirect('modulo/catalogo/catalogoatributo/editar/'.$atributo_id); 
}

public function eliminar()
    {
        $this->acceso->valida('catalogo','eliminar',1);
        $atributo = new atributo();
        $atributo->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/catalogo/catalogoatributo/listar/');
    }

}