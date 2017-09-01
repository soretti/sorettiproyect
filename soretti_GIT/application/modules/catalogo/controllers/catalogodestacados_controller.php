<?php

class Catalogodestacados_controller extends MX_Controller
{
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('text');
            $this->load->model('catalogo/cat_imagen');
            $this->load->model('catalogo/cat_categoria');
            $this->load->model('catalogo/producto');
            $this->load->model('catalogo/destacado');
            $this->load->model('tienda/item');
            $this->load->model('tienda/order');
            $this->load->model('catalogo/cat_precio');
            $this->load->model('catalogo/descuento');
            $this->load->model('usuario/usuario');
            $this->acceso->carga_permisos('catalogo');
        }

        public function lomasvendido()
        {
            $data=$this->_data('lomasvendido');
            if( is_object($data['destacados']->producto) )
                $this->load->view('catalogo/destacados/lomasvendido',$data);
            else
                $this->load->view('catalogo/destacados/lomasvendido_automatico',$data);
        }

        public function recomienda()
        {
            $data=$this->_data('recomienda');
            $this->load->view('catalogo/destacados/destacados',$data);
        }

        public function promociones()
        {
            $data=$this->_data('promociones');
            $this->load->view('catalogo/destacados/promociones',$data);
        }

        function _data($seccion){

            $portadas=array();

                $fg=new Destacado();
                $fg->include_related('producto');
                $fg->include_related('producto/cat_categoria');
                $fg->include_related('producto/cat_precio');
                $fg->where('seccion',$seccion)->order_by('sort','ASC')->get();

                              

            /*Imagenes de los productos*/
            $produtos_array_id = ($fg->all_to_single_array('producto_id')) ? $fg->all_to_single_array('producto_id') : '0';
            $imagenes=new cat_imagen();
            $imagenes->select('producto_id,imagen')->where_in('producto_id', $produtos_array_id)->order_by('sort','asc')->get();
            foreach ($imagenes as $imagen) {
                if(empty( $portadas[$imagen->producto_id] )) { $portadas[$imagen->producto_id] = $imagen->imagen; }
            }

            /*variantes prederminadas */
            foreach ($fg as $item) {
                $combinaciones = new Producto();
                $combinaciones=$combinaciones->include_related('cat_precio')->where('producto_id',$item->producto_id)->order_by('default','DESC')->limit(1)->get_raw();
                if($combinaciones->num_rows() ){
                    $item->combinacion=$combinaciones->row();
                }
            }

            return array('destacados'=>$fg,'portadas'=>$portadas,'imagenes'=>$imagenes );
        }

        public function guardar($seccion)
        {
            if(!isset($_POST)) show_error($this->lang->line('alert_request'));
            if(!$seccion) die();
            $this->acceso->valida('catalogo','editar',1);
            $fg=new Destacado();
            $fg->where('seccion',$seccion)->get()->delete_all();

            if(is_array($this->input->post('destacados')))
            foreach ($this->input->post('destacados') as $key => $value) {
                $fg=new Destacado();
                $fg->producto_id=$value;
                $fg->seccion=$seccion;
                $fg->sort=$key;
                $fg->save();
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/catalogo/catalogodestacados/editar/'.$seccion);

        }

        public function editar($seccion)
        {
            $this->titulo='EDITAR PRODUCTOS DESTACADOS';

            $datos=array();
            $this->acceso->valida('catalogo','consultar',1);
            $fg=new Destacado();
            $fg->include_related('producto',array('id','titulo'));
            $fg->where('seccion',$seccion)->order_by('sort','ASC')->get();

            $this->layout_content=$this->load->view('catalogo/destacados/form',array('item'=>$fg,'seccion'=>$seccion),true);
            $this->load->view('plantilla/backend/form');
        }

}
