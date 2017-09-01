<?php
class Reporte6_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }
  
    public function index()
    {


        $byPage=30;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);



        /* obtener a los usuarios distribuidores que su ultima compra sea mayor o igual a 60 días   */
        $distribuidores_count=$this->db->query("SELECT usuarios.id,MAX( notificaciones_distribuidores.fecha ) as notificacion_fecha, DATEDIFF(NOW(), MAX( pago_fecha )) as ultima_compra
                            FROM  `usuarios` 
                            LEFT JOIN orders ON orders.usuario_id = usuarios.id 
                            LEFT JOIN notificaciones_distribuidores ON notificaciones_distribuidores.usuario_id = usuarios.id 
                            WHERE descuento_id <>  ''
                            AND usuarios.is_enable =1
                            GROUP BY usuarios.id");


        //ordenar
        if ($this->input->post('ordenar')) { 
            $order = $this->session->userdata('reporte6_ordenar');
            if ($this->input->post('ordenar') == $order[0] && $order[1] == 'ASC')
                $this->session->set_userdata('reporte6_ordenar', array(
                    $this->input->post('ordenar'),
                    'DESC'
                ));
            else
                $this->session->set_userdata('reporte6_ordenar', array(
                    $this->input->post('ordenar'),
                    'ASC'
                ));
        }


        if (!$this->session->userdata('reporte6_ordenar'))
            $this->session->set_userdata('reporte6_ordenar', array(
                'id',
                'DESC'
            ));
        $order = $this->session->userdata('reporte6_ordenar');
        if($order[0]=='descuento') $order[0]='descuentos.titulo';
        if($order[0]=='fecha_registro') $order[0]='usuarios.fecha_creacion';
        if($order[0]=='ultima_compra') $order[0]='MAX( pago_fecha )';
        if($order[0]=='ultima_compra_dias') $order[0]='ultima_compra';
        if($order[0]=='numero_compras') $order[0]='numero_orders';
        if($order[0]=='total_compras') $order[0]='total_compras';
        $txt_order=$order[0]." ".$order[1];


        /* obtener a los usuarios distribuidores que su ultima compra sea mayor o igual a 60 días   */
        $distribuidores=$this->db->query("SELECT COUNT( if(orders.pago_verificado = 1, orders.id, null) ) as numero_orders, SUM(orders.total) as total_compras, usuarios.id,usuarios.fecha_creacion,usuarios.nombre,usuarios.apellidoPaterno,descuentos.titulo as tipodistribuidor,CONCAT(lada,'-',telefono) as telefono,usuarios.email, MAX( pago_fecha ) as pago_fecha, MAX( notificaciones_distribuidores.fecha ) as notificacion_fecha, DATEDIFF(NOW(), MAX( pago_fecha )) as ultima_compra
                            FROM  `usuarios` 
                            LEFT JOIN descuentos ON descuentos.id = usuarios.descuento_id 
                            LEFT JOIN orders ON orders.usuario_id = usuarios.id 
                            LEFT JOIN notificaciones_distribuidores ON notificaciones_distribuidores.usuario_id = usuarios.id 
                            WHERE descuento_id <>  ''
                            AND usuarios.is_enable =1
                            GROUP BY usuarios.id order by $txt_order LIMIT $offset , $byPage   ");

        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte6/index")."?";
        $pagination['total_rows'] = $distribuidores_count->num_rows();
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

 

        $this->titulo = 'REPORTE DISTRIBUIDORES';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/distribuidores',
        array('distribuidores'=>$distribuidores->result()),true);
        $this->load->view('plantilla/backend/form');
        
    }


}