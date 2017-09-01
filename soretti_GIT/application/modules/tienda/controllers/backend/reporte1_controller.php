<?php
class Reporte1_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }

        function tree_subordinados_comision($distribuidor,$fecha_inicio,$fecha_fin,$distribuidor_superior=null){
               
                /*Subordinadas*/
                $this->db->select('GROUP_CONCAT(cupon_id) as cupones, GROUP_CONCAT(subordinado_id) as subordinados')->where('usuario_id',$distribuidor->id)->from('subordinados');
                $this->db->join('usuarios', 'usuarios.id = subordinados.subordinado_id');
                $subordinados=$this->db->get()->row();
                $cupon_subordinados = ($subordinados->cupones) ? $subordinados->cupones : '0';
                $usuarios_subordinados = ($subordinados->subordinados) ? $subordinados->subordinados : '0';

                $comisionCuponesSubordinados=0;

                /*Calcular las comisiones de las ordenes por cupones de subordinados*/
                $orderCupon=$this->db->query("SELECT descuentos.porcentaje as usuario_descuentoPorcentaje, orders.id,orders.cuponPorcentaje, orders.mayoreoPorcentaje, usuarios.id as usuario_id FROM (`orders`)
                    LEFT JOIN usuarios ON usuarios.cupon_id=orders.cupon_id
                    LEFT JOIN descuentos ON usuarios.descuento_id=descuentos.id
                    WHERE orders.cupon_id IN (".$cupon_subordinados.") AND orders.cupon_id<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();

                foreach ($orderCupon as $order) {
                        $productos=$this->db->select('items.precio, items.cantidad, cat_precios.costo, cat_precios.precio as producto_precio')->where('order_id',$order->id)->from('items')
                        ->join('cat_productos', 'items.producto_id = cat_productos.id')
                        ->join('cat_precios', 'cat_productos.id = cat_precios.producto_id')
                        ->get()->result();
                        foreach ($productos as $producto) {
                            $precioVenta=precioVenta($producto->producto_precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                            $precioDistribuidor=precioDistribuidor($producto->producto_precio,$order->usuario_descuentoPorcentaje);
                            $precioDistribuidorPadre=precioDistribuidor($producto->producto_precio,$distribuidor->porcentaje);
                            $comisionCuponesSubordinados+=( ($precioDistribuidor-$precioDistribuidorPadre) * $producto->cantidad );  
                        } 
                }

                /*Calcular las comisiones de las ordenes de compra directas  del subordinados*/
                $compras_subdistribuidores=$this->db->query("SELECT descuentos.porcentaje as usuario_descuentoPorcentaje, orders.id,orders.cuponPorcentaje, orders.mayoreoPorcentaje, usuarios.id as usuario_id FROM (`orders`)
                    LEFT JOIN usuarios ON usuarios.id=orders.usuario_id
                    LEFT JOIN descuentos ON usuarios.descuento_id=descuentos.id
                    WHERE orders.usuario_id IN (".$usuarios_subordinados.") AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
 
                    foreach ($compras_subdistribuidores as $order) {
                            $productos=$this->db->select('items.precio, items.cantidad, cat_precios.costo, cat_precios.precio as producto_precio')->where('order_id',$order->id)->from('items')
                            ->join('cat_productos', 'items.producto_id = cat_productos.id')
                            ->join('cat_precios', 'cat_productos.id = cat_precios.producto_id')
                            ->get()->result();
                            foreach ($productos as $producto) {
                                $precioVenta=precioVenta($producto->producto_precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                                $precioDistribuidor=precioDistribuidor($producto->producto_precio,$order->usuario_descuentoPorcentaje);
                                $precioDistribuidorPadre=precioDistribuidor($producto->producto_precio,(isset($distribuidor_superior->porcentaje)) ? $distribuidor_superior->porcentaje : $distribuidor->porcentaje);
                                $comisionCuponesSubordinados+=( ($precioDistribuidor-$precioDistribuidorPadre) * $producto->cantidad );  
                            } 
                    }

                $totalCupones=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `cupon_id` IN (".$cupon_subordinados.") AND `cupon_id`<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->row();
                $result=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `usuario_id` IN (".$usuarios_subordinados.") AND  (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->row();
                $totalComprasSubdistribuidores=$result->total; 

                /* Nivel 2 distribuidores*/
                $this->db->select(" usuarios.id, nombre,apellidoPaterno,apellidoMaterno, descuentos.titulo as descuento_titulo, cupones.id as cupon_id, porcentaje" );
                $this->db->where('descuento_id <>','')->where('usuarios.is_enable',1)->where_in('usuarios.id',explode(",",$usuarios_subordinados))->from('usuarios');
                $this->db->join('descuentos', 'usuarios.descuento_id = descuentos.id');
                $this->db->join('cupones', 'usuarios.cupon_id = cupones.id');
                $distribuidores_2_nivel=$this->db->get()->result();
                foreach ($distribuidores_2_nivel as $distribuidor2) {
                     $totalcomisiones=$this->tree_subordinados_comision($distribuidor2,$fecha_inicio,$fecha_fin,$distribuidor);
                     $comisionCuponesSubordinados+=$totalcomisiones['comisionCuponesSubordinados'];
                     $totalComprasSubdistribuidores+=$totalcomisiones['totalComprasSubdistribuidores'];
                }


                
                return array('comisionCuponesSubordinados'=>$comisionCuponesSubordinados,'totalComprasSubdistribuidores'=>($totalComprasSubdistribuidores+$totalCupones->total));
        }

    public function _set_tem_rep()
    {
            /*Rango de fechas si no existe  tomar el dia 15 del mes actual como fecha de corte y 15 del mes anterior como fecha de inicio*/
            if($this->input->post('fecha_ini') && $this->input->post('fecha_fin')){
                $this->session->set_userdata(array( 'fecha_reporte_ini'=>$this->input->post('fecha_ini'), 'fecha_reporte_fin'=>$this->input->post('fecha_fin') ));
            }

            if($this->session->userdata('fecha_reporte_ini') && $this->session->userdata('fecha_reporte_ini')){
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');
            }else{
                list($year,$month,$day)=explode("-",date('Y-m-d') );
                list($year_ini,$month_ini,$day_ini)=explode("-", date('Y-m-d',strtotime("-1 month")) ); 
                $fecha_inicio=$year_ini."-".$month_ini."-15";
                $fecha_fin=$year."-".$month."-15";
                $this->session->set_userdata(array( 'fecha_reporte_ini'=>$fecha_inicio, 'fecha_reporte_fin'=>$fecha_fin ));
            }

            /*Lista de usuarios distribuidores activos en la tienda*/
            $this->db->select(" usuarios.id, nombre,apellidoPaterno,apellidoMaterno, descuentos.titulo as descuento_titulo, cupones.id as cupon_id, porcentaje" );
            $this->db->where('descuento_id <>','')->where('usuarios.is_enable',1)->from('usuarios');
            $this->db->join('descuentos', 'usuarios.descuento_id = descuentos.id');
            $this->db->join('cupones', 'usuarios.cupon_id = cupones.id');
            $distribuidores=$this->db->get()->result();

            $this->db->query("DROP TABLE IF EXISTS temp_reporte1");
            $this->db->query("CREATE TEMPORARY TABLE `temp_reporte1` (
                      `distribuidor_id` int(11),
                      `distribuidor_nombre` varchar(255) NOT NULL DEFAULT '0',
                      `distribuidor_tipo` varchar(255) NOT NULL DEFAULT '0',
                      `compras_cupon` float  NULL,
                      `compras_directas` float  NULL,
                      `compras_subordinadas` float  NULL,
                      `comision_cupones` float  NULL,
                      `comision_subordinadas` float  NULL,
                      `comision_total` float  NULL
                    )");

            foreach ($distribuidores as $distribuidor)
            {
                
                /*Monto de ventas por distribuidores*/
                $comprasDirectas=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `usuario_id` = '".$distribuidor->id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->row();
                $comprasCupon=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `cupon_id` = '".$distribuidor->cupon_id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->row();
               
                
                /*Calcular las comisiones de las ordenes de compra del distribuidor*/
                $orderCupon=$this->db->query("SELECT * FROM (`orders`) WHERE `cupon_id` = '".$distribuidor->cupon_id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
                $comisionCupones=0;
                foreach ($orderCupon as $order) {
                        //$productos=$this->db->where('order_id',$order->id)->get('items')->result();

                        $productos=$this->db->select('items.precio, items.cantidad, cat_precios.costo, cat_precios.precio as producto_precio')->where('order_id',$order->id)->from('items')
                        ->join('cat_productos', 'items.producto_id = cat_productos.id')
                        ->join('cat_precios', 'cat_productos.id = cat_precios.producto_id')
                        ->get()->result();


                        foreach ($productos as $producto) {
                            $precioVenta=precioVenta($producto->producto_precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                            $precioDistribuidor=precioDistribuidor($producto->producto_precio,$distribuidor->porcentaje);
                            $comisionCupones+=( ($precioVenta-$precioDistribuidor) * $producto->cantidad );  
                        } 
                }

                $subordinados=$this->tree_subordinados_comision($distribuidor,$fecha_inicio,$fecha_fin);
               

                /*Monto total de las compras*/
                //echo $distribuidor->id." | ".$distribuidor->nombre." | ".$distribuidor->descuento_titulo." | ". $comprasCupon->numrows." | ".$comprasDirectas->numrows." | ".$comprasSubordinados->numrows." | ".$totalCompras." | ".$comisionCupones." | ".$comisionCuponesSubordinados."<br>";
                $this->db->insert('temp_reporte1',array(
                    'distribuidor_id'=>$distribuidor->id,
                    'distribuidor_nombre'=>$distribuidor->nombre." ".$distribuidor->apellidoPaterno." ".$distribuidor->apellidoMaterno,
                    'distribuidor_tipo'=>str_replace("Distribuidor","",$distribuidor->descuento_titulo),
                    'compras_cupon'=>$comprasCupon->total,
                    'compras_directas'=>$comprasDirectas->total,
                    'compras_subordinadas'=>$subordinados['totalComprasSubdistribuidores'], 
                    'comision_cupones'=>$comisionCupones,
                    'comision_subordinadas'=>$subordinados['comisionCuponesSubordinados'],
                    'comision_total'=>$comisionCupones+$subordinados['comisionCuponesSubordinados']
                ));
        }
    }
  


    public function index()
    {
        $this->_set_tem_rep();

        $byPage=20;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte1/index")."?";
        $pagination['total_rows'] = $this->db->count_all_results('temp_reporte1');
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

        $totales = $this->db->select('SUM(comision_total) as comision_total,SUM(comision_cupones) as comision_cupones,,SUM(comision_subordinadas) as comision_subordinadas')->get('temp_reporte1')->row();
 

        $this->titulo = 'REPORTE COMISIONES';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/general',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$this->db->limit($byPage,$offset)->get('temp_reporte1')->result(),
                'totales'=>$totales,
                ),true);
        $this->load->view('plantilla/backend/form');
    }


     public function excel(){
                $this->_set_tem_rep();
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Comisiones por proveddor');
                //set cell A1 content with some text

                                            
                $this->excel->getActiveSheet()->setCellValue('A1', 'ID');
                $this->excel->getActiveSheet()->setCellValue('C1', 'Nombre');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Distribuidor');
                $this->excel->getActiveSheet()->setCellValue('E1', 'compras/cupon');
                $this->excel->getActiveSheet()->setCellValue('F1', 'compras/directas');
                $this->excel->getActiveSheet()->setCellValue('G1', 'compras/subordinadas');
                $this->excel->getActiveSheet()->setCellValue('H1', 'total_compras');
                $this->excel->getActiveSheet()->setCellValue('I1', 'comision/cupones');
                $this->excel->getActiveSheet()->setCellValue('J1', 'comision/subordinadas');
                $this->excel->getActiveSheet()->setCellValue('K1', 'comision/total');


                $contacto=$this->db->get('temp_reporte1')->result();

                $fila=2;
                foreach ($contacto as $item)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->distribuidor_id);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, $item->distribuidor_nombre);
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, $item->distribuidor_descuento_titulo);
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, $item->compras_cupon);
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, $item->compras_directas);
                    $this->excel->getActiveSheet()->setCellValue('G'.$fila, $item->compras_subordinadas);
                    $this->excel->getActiveSheet()->setCellValue('H'.$fila, $item->total_compras);
                    $this->excel->getActiveSheet()->setCellValue('I'.$fila, $item->comision_cupones);
                    $this->excel->getActiveSheet()->setCellValue('J'.$fila, $item->comision_subordinadas);
                    $this->excel->getActiveSheet()->setCellValue('K'.$fila, $item->comision_total);
                    $fila++;
                }

                //change the font size
                //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
                //make the font become bold
                //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

                //merge cell A1 until D1
                //$this->excel->getActiveSheet()->mergeCells('A1:D1');
                //set aligment to center for that merged cell (A1 to D1)
                //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $filename='Comisiones por proveddor.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');


     }

}