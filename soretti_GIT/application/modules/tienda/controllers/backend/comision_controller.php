<?php
class Comision_controller extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
 
    }

    public function listar($id,$usuario_id)
    {

        $this->titulo = 'Orden de compra #'.$id;
        $this->acceso->valida('tienda', 'consultar', 1);
        $order= new Order();
        $order->include_related('usuario');
        $order->where('id',$id)->group_start()-> where('estatus', 2)->or_where('estatus', 3)->or_where('estatus', 4)->or_where('estatus', 5)->group_end()->get();
        if(!$order->estatus) show_error('');
        $data['order'] = $order;

        $data['metodos_de_pago'] =  $this->config->item('metodos_pago','proyecto');
        $data['envio'] =  $order->datos_envio;
        $data['usuario_id'] =  $usuario_id;

        $this->layout_content   = $this->load->view('tienda/backend/comision/listar', $data, true);
        $this->layout_assets=array();
        $this->load->view('plantilla/backend/form');
    }

}
