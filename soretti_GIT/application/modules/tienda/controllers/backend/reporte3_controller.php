<?php
class Reporte3_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL);
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }


    function set_tem_utilidad($orders,$tipo){

            $total_ventas=0;
            $numero_ventas=0;
            $utilidad=0;
            $costo=0;
            $flete_total=0;
            $comision=0;
            $iva=0.16;
            $costo_flete=0;
            foreach ($orders as $order) {
                $comision_total=0;

                $datos_pago=json_decode($order->datos_pago);
                $flete=(isset($datos_pago->flete) && $datos_pago->flete_gratis==0) ?  $datos_pago->flete : 0;
                $flete_total+=$flete;
                $numero_ventas+=1;
                $total_ventas+=$order->total;
                $costo_flete+=$order->costo_flete;

                /*Comisiones formas de pago*/
                if($datos_pago->metodo_pago==1 || $datos_pago->metodo_pago==2){
                    $comision_porcentaje=(isset($datos_pago->tarjeta) && $datos_pago=='american-express') ? 4.5 : 2.9;
                    $extra=2.5;
                    $comision_total=(($order->total*$comision_porcentaje)/100)+$extra;
                    $comision_total=($comision_total + ($comision_total*$iva) );
                    $comision+=$comision_total;
                }
                
                /*Comisiones formas de pago paypal*/
                if($datos_pago->metodo_pago==5){
                    $comision_porcentaje=3.95;
                    $extra=4;
                    $comision_total=(($order->total*$comision_porcentaje)/100)+$extra;
                    $comision_total=($comision_total + ($comision_total*$iva) );
                    $comision+=$comision_total;
                }

                /*Comisiones formas de pago spei*/
                if($datos_pago->metodo_pago==3){
                    $extra=8;
                    $comision_total=($extra + ($extra*$iva));
                    $comision+=$comision_total;

                }

                $productos=$this->db->select('items.extra,items.precio, items.cantidad, cat_precios.costo, cat_precios.precio as producto_precio')->where('order_id',$order->id)->from('items')
                ->join('cat_productos', 'items.producto_id = cat_productos.id')
                ->join('cat_precios', 'cat_productos.id = cat_precios.producto_id')
                ->get()->result();

                foreach ($productos as $producto) {

                    $pr=json_decode($producto->extra);
                    $producto_precio=$pr->precio;
                    $producto_costo=$pr->costo;
                    

                    $precioVenta=precioVenta($producto_precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                    $precioDistribuidor=precioDistribuidor($producto_precio,$order->usuario_descuento);

                    $precioSuperFoods=$producto_costo;
                    $costo+=$producto_costo * $producto->cantidad;
                    if($order->usuario_descuento){
                         $utilidad+=( ($precioDistribuidor-$precioSuperFoods) * $producto->cantidad ); 
                    }else{
                         $utilidad+=( ($precioVenta-$precioSuperFoods) * $producto->cantidad ); 
                    }

                    
                }

                $utilidad = $utilidad -  $comision_total;
                $utilidad = $utilidad +  ((isset($datos_pago->flete) && $datos_pago->flete_gratis==0) ?  $datos_pago->flete : 0);
                $utilidad = $utilidad -  $order->costo_flete;                          
                             
            }

            $this->db->insert('temp_reporte3',array(
                'tipo_venta'=>$tipo,
                'numero_ventas'=> $numero_ventas,
                'total_ventas'=>$total_ventas,
                'costo'=>$costo,
                'flete'=>$flete_total,
                'costo_flete'=>$costo_flete,
                'comisiones'=>$comision,
                'utilidad'=>$utilidad
            ));

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

            $this->db->query("DROP TABLE IF EXISTS temp_reporte3");
            $this->db->query("CREATE TEMPORARY TABLE `temp_reporte3` (
                      `tipo_venta` varchar(255) NOT NULL DEFAULT '0',
                      `numero_ventas` float,
                      `total_ventas` float,
                      `costo` float,
                      `flete` float,
                      `costo_flete` float,
                      `comisiones` float,
                      `utilidad` float
             )");




            //Ventas sin cupones en la página, no mayoreo, no distribuidores
            $orders=$this->db->query(" SELECT orders.*, 0 usuario_descuento FROM (`orders`) 
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            WHERE orders.pago_verificado=1 and   ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  usuarios.descuento_id='' and mayoreoPorcentaje='' and cuponPorcentaje=''  AND orders.cupon_id='' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas Directas');

            //Ventas con cupones Super Foods y no son mayoreo
            $orders=$this->db->query("SELECT orders.*, usuarios.id AS usuario_id_cupon, 0 usuario_descuento FROM (`orders`)
            LEFT JOIN usuarios on usuarios.cupon_id=orders.cupon_id
            WHERE orders.pago_verificado=1 and   ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  mayoreoPorcentaje='' and cuponPorcentaje<>''  AND orders.cupon_id<>'' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING ISNULL(usuario_id_cupon) ")->result();
            $this->set_tem_utilidad($orders,'Ventas con Cupones');

            //Ventas de medio mayoreo que pueden tener o no un cupon y no pertenecen a Distribuidores
            $orders=$this->db->query("SELECT orders.*, 0 AS usuario_descuento, distribuidores.id as distribuidor_id FROM (`orders`)
            LEFT JOIN cupones on cupones.id=orders.cupon_id
            LEFT JOIN usuarios as distribuidores on distribuidores.cupon_id=cupones.id
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  mayoreoPorcentaje='6' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING  ISNULL(distribuidor_id) ")->result();
            $this->set_tem_utilidad($orders,'Ventas Medio Mayoreo');

             //Ventas de mayoreo que pueden tener o no un cupon y no pertenecen a Distribuidores
            $orders=$this->db->query("SELECT orders.*, 0 AS usuario_descuento, distribuidores.id as distribuidor_id FROM (`orders`)
            LEFT JOIN cupones on cupones.id=orders.cupon_id
            LEFT JOIN usuarios as distribuidores on distribuidores.cupon_id=cupones.id
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  mayoreoPorcentaje='9' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING  ISNULL(distribuidor_id) ")->result();
            $this->set_tem_utilidad($orders,'Ventas Mayoreo');

            //Ventas  a Distribuidores Bronce
            $orders=$this->db->query("SELECT orders.*, 30 AS usuario_descuento FROM (`orders`)
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            LEFT JOIN descuentos on descuentos.id=usuarios.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje='30' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas a Distribuidores Bronce');

            //Ventas a Distribuidores Plata
            $orders=$this->db->query("SELECT orders.*, 35 AS usuario_descuento FROM (`orders`)
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            LEFT JOIN descuentos on descuentos.id=usuarios.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje='35' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas a Distribuidores Plata');

            //Ventas a Distribuidores Oro
            $orders=$this->db->query("SELECT orders.*, 40 AS usuario_descuento FROM (`orders`)
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            LEFT JOIN descuentos on descuentos.id=usuarios.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje='40' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas a Distribuidores Oro');

            //Ventas  con cupones bronce
            $orders=$this->db->query("SELECT orders.*, 30 AS usuario_descuento, distribuidores.id as distribuidor_id FROM (`orders`)
            LEFT JOIN cupones on cupones.id=orders.cupon_id
            LEFT JOIN usuarios as distribuidores on distribuidores.cupon_id=cupones.id
            LEFT JOIN descuentos on descuentos.id=distribuidores.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje=30 AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING  distribuidor_id  IS NOT NULL ")->result();           
            $this->set_tem_utilidad($orders,'Ventas con Cupones bronce');
 
            //Ventas  con cupones plata
            $orders=$this->db->query("SELECT orders.*, 35 AS usuario_descuento, distribuidores.id as distribuidor_id FROM (`orders`)
            LEFT JOIN cupones on cupones.id=orders.cupon_id
            LEFT JOIN usuarios as distribuidores on distribuidores.cupon_id=cupones.id
            LEFT JOIN descuentos on descuentos.id=distribuidores.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje=35 AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING  distribuidor_id  IS NOT NULL ")->result();
            $this->set_tem_utilidad($orders,'Ventas con Cupones Plata');
            
            //Ventas  con cupones Oro
            $orders=$this->db->query("SELECT orders.*, 40 AS usuario_descuento, distribuidores.id as distribuidor_id FROM (`orders`)
            LEFT JOIN cupones on cupones.id=orders.cupon_id
            LEFT JOIN usuarios as distribuidores on distribuidores.cupon_id=cupones.id
            LEFT JOIN descuentos on descuentos.id=distribuidores.descuento_id
            WHERE orders.pago_verificado=1 and  ( orders.usuario_id<>139 && orders.usuario_id<>138) AND  descuentos.porcentaje=40 AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') HAVING  distribuidor_id  IS NOT NULL ")->result();
            $this->set_tem_utilidad($orders,'Ventas con Cupones Oro');

            //Ventas algaespirulina.com
            $orders=$this->db->query(" SELECT orders.*, 0 AS usuario_descuento FROM (`orders`) 
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            WHERE orders.pago_verificado=1 and   ( orders.usuario_id=139) AND  usuarios.descuento_id='' AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas algaespirulina.com');
            

            //Ventas algaespirulina.com 360
            $orders=$this->db->query(" SELECT orders.*, 0 AS usuario_descuento FROM (`orders`) 
            LEFT JOIN usuarios on usuarios.id=orders.usuario_id
            WHERE orders.pago_verificado=1 AND   ( orders.usuario_id=138) AND  usuarios.descuento_id=''  AND total<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (DATE(pago_verificado_fecha) between '".$fecha_inicio."' AND '".$fecha_fin."') ")->result();
            $this->set_tem_utilidad($orders,'Ventas espirulina360.com');


    }
  
    function costoProducto(){
       $this->load->model(array('catalogo/producto','catalogo/cat_precio'));

       $items=new item;
       $items->get();
           foreach ($items as $item)
           {
             $producto=new Producto();
             $producto->include_related('cat_precio')->where('id',$item->producto_id)->get();
             echo $producto->titulo."--".$producto->cat_precio_costo."----".$producto->cat_precio_precio."<br>";
             $item->extra=json_encode(array('costo'=>$producto->cat_precio_costo,'precio'=>$producto->cat_precio_precio));
             $item->skip_validation()->save();
           }
        }

    public function index()
    {
        $this->_set_tem_rep();

        $byPage=20;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte3/index")."?";
        $pagination['total_rows'] = $this->db->count_all_results('temp_reporte3');
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

        $totales = $this->db->select('SUM(comisiones) as total_comisiones,SUM(costo_flete) as total_costo_flete ,SUM(numero_ventas) as numero_ventas,SUM(flete) as total_flete, SUM(costo) as total_costo, SUM(total_ventas) as total_ventas,SUM(utilidad) as utilidad')->get('temp_reporte3')->row();
 

        $this->titulo = 'REPORTE VENTAS-UTILIDAD';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/ventas',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$this->db->limit($byPage,$offset)->get('temp_reporte3')->result(),
                'totales'=>$totales,
                ),true);
        $this->load->view('plantilla/backend/form');
    }

    public function pdf()
    {
        $this->_set_tem_rep();

        $byPage=60;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte3/index")."?";
        $pagination['total_rows'] = $this->db->count_all_results('temp_reporte3');
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

        $totales = $this->db->select('SUM(comisiones) as total_comisiones,SUM(costo_flete) as total_costo_flete ,SUM(numero_ventas) as numero_ventas,SUM(flete) as total_flete, SUM(costo) as total_costo, SUM(total_ventas) as total_ventas,SUM(utilidad) as utilidad')->get('temp_reporte3')->row();
 

        $this->titulo = 'REPORTE VENTAS-UTILIDAD';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/ventas_pdf',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$this->db->limit($byPage,$offset)->get('temp_reporte3')->result(),
                'totales'=>$totales,
                ),true);

        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPageOrientation('L', $autopagebreak='', $bottommargin='');
 

        $pdf->SetTitle('REPORTE DE VENTAS');
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);        
        $pdf->AddPage();


 

        // output the HTML content
        $pdf->writeHTML($this->layout_content, true, false, true, false, ''); 

        $pdf->Output('reporte_ventas.pdf', 'I');



    }


     public function excel(){
                $this->_set_tem_rep();
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('REPORTE VENTAS-UTILIDAD');
                //set cell A1 content with some text

                                            
                $this->excel->getActiveSheet()->setCellValue('A1', 'Tipo de venta');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Número de ventas');
                $this->excel->getActiveSheet()->setCellValue('C1', 'Total de ventas');
                $this->excel->getActiveSheet()->setCellValue('D1', '%');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Flete');
                $this->excel->getActiveSheet()->setCellValue('F1', 'Costo flete');
                $this->excel->getActiveSheet()->setCellValue('G1', 'Costo productos');
                $this->excel->getActiveSheet()->setCellValue('H1', 'Comis/Met Pago');
                $this->excel->getActiveSheet()->setCellValue('I1', 'Utilidad');
                $this->excel->getActiveSheet()->setCellValue('J1', '%');


                $reporte=$this->db->get('temp_reporte3')->result();
                $totales = $this->db->select('SUM(comisiones) as total_comisiones,SUM(costo_flete) as total_costo_flete ,SUM(numero_ventas) as numero_ventas,SUM(flete) as total_flete, SUM(costo) as total_costo, SUM(total_ventas) as total_ventas,SUM(utilidad) as utilidad')->get('temp_reporte3')->row();


                $fila=2;
                foreach ($reporte as $item)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->tipo_venta);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $item->numero_ventas);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, formato_precio($item->total_ventas));
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, number_format(($item->total_ventas*100)/$totales->total_ventas,1)."%");
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, formato_precio($item->flete));
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, formato_precio($item->costo_flete));
                    $this->excel->getActiveSheet()->setCellValue('G'.$fila, formato_precio($item->costo));
                    $this->excel->getActiveSheet()->setCellValue('H'.$fila, formato_precio($item->comisiones));
                    $this->excel->getActiveSheet()->setCellValue('I'.$fila, formato_precio($item->utilidad));
                    $this->excel->getActiveSheet()->setCellValue('J'.$fila, number_format(($item->utilidad*100)/$totales->utilidad,1)."%");
                    $fila++;
                }

                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $totales->numero_ventas);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, formato_precio($totales->total_ventas));
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila,'');
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, formato_precio($totales->total_flete));
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, formato_precio($totales->total_costo_flete));
                    $this->excel->getActiveSheet()->setCellValue('G'.$fila, formato_precio($totales->total_costo));
                    $this->excel->getActiveSheet()->setCellValue('H'.$fila, formato_precio($totales->total_comisiones));
                    $this->excel->getActiveSheet()->setCellValue('I'.$fila, formato_precio($totales->utilidad));
                    $this->excel->getActiveSheet()->setCellValue('J'.$fila, '');

                    $filename='ventas-utilidad.xls'; //save our workbook as this file name
                    header('Content-Type: application/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache                            
                    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                    //if you want to save it as .XLSX Excel 2007 format
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save('php://output');


     }

}