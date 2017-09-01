<?php
class Catalogo_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('catalogo/producto');
        $this->load->model('catalogo/variante');
        $this->load->model('catalogo/cat_imagen');
        $this->load->model('catalogo/cat_precio');
        $this->load->model('catalogo/cat_categoria');
        $this->load->model('catalogo/cat_marca');
        $this->load->model('catalogo/destacado');
        $this->load->model('catalogo/atributo');
        $this->load->model('catalogo/descuento');
        $this->load->model('pagina/pagina');
        $this->acceso->carga_permisos('catalogo');
        $this->load->library('Image_fit');
    }

    function index(){
        if(!$pagina_uri) redirect(site_url(), 'location', 301);
    }

        function mail(){

        $this->load->library('email');

        $this->email->initialize(array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.sendgrid.net',
          'smtp_user' => 'paginaswebmx',
          'smtp_pass' => 'controlphp86',
          'smtp_port' => 587,
          'crlf' => "\r\n",
          'newline' => "\r\n"
        ));

        $this->email->from('ob@paginasweb.mx', 'AlgaEspirulinaMX');
        $this->email->to('source.manuel@gmail.com');
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();

        echo $this->email->print_debugger();

    }

function directorio($pagina=1){
    $this->load->model('tienda/directorio');
    $this->load->library('dom_parser');
    // $url="http://www.seccionamarilla.com.mx/resultados/tiendas-naturistas/";
    // $clasificacion="Tiendas naturistas";
    //$pag_fin=39;


    // $url="http://www.seccionamarilla.com.mx/resultados/nutriologos/";
    // $clasificacion="Nutriologos";
    // $pag_fin=24;

    // $url="http://www.seccionamarilla.com.mx/resultados/nutricion-productos-y-asesoria-de/";
    // $clasificacion="Nutricion productos y asesoria de ";
    // $pag_fin=26;


    $url="http://www.seccionamarilla.com.mx/resultados/gimnasios/";
    $clasificacion="Gimnasios";
    $pag_fin=50;

    $pag_ini=($pagina) ? $pagina : 1;

            $directorio=$this->dom_parser->file_get_html($url.$pag_ini);
            $items=$directorio->find("li.vcard");
            foreach ($items as $item) {
                    $directorio=new Directorio();
                    $data=$item->find("a[class=ProductosMx mas_info]",0);
                    if($data){
                         $anuncio=$this->dom_parser->file_get_html($data->href);
                         $correo=@substr($anuncio->find("a[class=ProductosMx correo]",0)->href,7);
                         $directorio->correo=$correo;
                    }

                    $directorio->nombre=$item->find("h3",0)->text();
                    if($item->find(".adr",0))$directorio->direccion=$item->find(".adr",0)->text();
                    if($item->find(".phone-number",0)) $directorio->telefonos=$item->find(".phone-number",0)->text();
                    $directorio->clasificacion=$clasificacion;
                    if($directorio->telefonos || $directorio->correo ) $directorio->save();
            }
            $pag_ini++;

            if($pag_ini<=$pag_fin) redirect('modulo/catalogo/directorio/'.$pag_ini ,'refresh');
    }



    public function solicitar_informacion($id = '')
    {
         if (!$id)
            show_error('información incompleta');
        if (!$_POST)
            show_error('información incompleta');
        $producto = new Producto($id);
        if (!$producto->result_count())
            show_error('información incompleta');
        $proyecto = $this->config->item('proyecto');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('texto', 'Texto', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('', '');
        $datos['enviado'] = '';
        if ($this->input->post('mcontacto') == 'TRS6745-*1' && $this->form_validation->run()) {
            if ($this->input->post('email_field') != '') {
                $datos['error'] = validation_errors();
            }
            $config['mailtype'] = 'html';
            $config['wordwrap'] = FALSE;
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->from($this->input->post('email'));
            $this->email->to($proyecto['email_contacto']);
            $this->email->subject($proyecto['titulo'] . ' | Solicitud de cotización | ' . $this->input->post('nombre'));
            $mensaje = "Nombre: " . $this->input->post('nombre') . "\n";
            $mensaje .= "E-mail: " . $this->input->post('email') . "\n";
            $mensaje .= "Teléfono: " . $this->input->post('lada') . "-" . $this->input->post('lada') . "\n";
            $mensaje .= "Producto: " . $producto->titulo . "\n";
            $mensaje .= "Mensaje: \n" . $this->input->post('texto') . "\n";
            $this->email->message($mensaje);
            if ($this->email->send()) {
                $datos['enviado'] = 'Se envió correctamente su correo.';
            }
        } else {
            $datos['error'] = validation_errors();
        }
        echo json_encode($datos);
    }



    public function breadcrumb($cat_categoria)
    {
        $navegacion_array=array();
        $padre_id           = $cat_categoria->padre_id;
        while ($padre_id) {
            $categoria_prev = new cat_categoria();
            $categoria_prev->select('titulo,titulo_en,uri,padre_id,id')->get_by_id($padre_id);
            $padre_id           = $categoria_prev->padre_id;
            $navegacion_array[] = array(
                'titulo' => $categoria_prev->{'titulo' . IDIOMA},
                'uri' => site_url('catalogo/' . $categoria_prev->uri)
            );
        }
        $navegacion_array=array_reverse($navegacion_array);
        $navegacion_array[] = array(
            'titulo' => $cat_categoria->{'titulo' . IDIOMA},
            'uri' => site_url('catalogo/' . $cat_categoria->uri)
        );
        return $this->load->view('catalogo/breadcrumb', array('navegacion'=>$navegacion_array), TRUE);
    }

    public function ficha($categoria = '', $uri = '')
    {
        if (!$uri)
        show_404();
        $producto = new Producto();
        $producto->include_related('cat_precio');
        $producto->get_by_uri($uri);
        if (!$producto->result_count())
            show_404('Producto no encontrado');
        $producto_combinaciones=array();
        $cat_categoria = new cat_categoria;
        $cat_categoria->get_by_uri($categoria);



        /*-- Productos Relacionados--*/
        $portadas         = array();
        $fg               = new Relacionado();
        $fg->include_related('producto', array(
            'id',
            'titulo',
            'resumen',
            'titulo_en',
            'resumen_en',
            'uri'
        ));
        $fg->include_related('producto/cat_categoria', array(
            'uri'
        ));
        $fg->where(array(
            'rootproducto_id' => $producto->id
        ));
        $fg->order_by('sort', 'ASC')->get();


        /*Imagenes de los productos*/
        $produtos_array_id = $fg->all_to_single_array('producto_id');
        $imagenes          = new cat_imagen();
        if (!$produtos_array_id)
            $produtos_array_id = 0;
        $imagenes->select('producto_id,imagen')->where_in('producto_id', $produtos_array_id)->order_by('sort', 'asc')->get();
        foreach ($imagenes as $imagen) {
            if (empty($portadas[$imagen->producto_id]))
                $portadas[$imagen->producto_id] = $imagen->imagen;
        }


        $meta                 = array(
            'titulo' => $producto->{'metatitulo' . IDIOMA},
            'descripcion' => $producto->{'resumen' . IDIOMA},
            'palabras_clave' => $producto->{'palabras_clave' . IDIOMA}
        );

        /*combinacion prederminada */
        $combinaciones = new Producto();
        $combinaciones=$combinaciones->include_related('cat_precio')->where('producto_id',$producto->id)->order_by('default','DESC')->limit(1)->get_raw();
        if($combinaciones->num_rows() ){
            $producto->combinacion=$combinaciones->row();
        }


          $combinaciones = new Producto();

          $combinaciones->include_related('cat_precio')->where('producto_id',$producto->id)->get();

          if($combinaciones->result_count()){
              $producto_combinaciones=array();
              $combinaciones_atributos = $combinaciones->all_to_single_array('combinaciones');
              $atributos_producto='';

              foreach ($combinaciones_atributos as $value) {
                $atributos_producto.=$value.",";
              }

              $atributos_producto_array=explode( ",",substr($atributos_producto,0,-1) );
              $atributos_producto_array=array_unique($atributos_producto_array);
              $atributos_producto = $atributos->where_in('id', $atributos_producto_array )->order_by('padre_id','ASC')->order_by('sort','ASC')->get_raw();

              /*Atributos padre */
              $atributos_padre_value=array();
              foreach ($atributos_producto->result() as $atributo) {
                $atributos_padre_value[]=$atributo->padre_id;
              }
              $atributos_padre_value=array_unique($atributos_padre_value);
              $atributos_padre = $atributos->where_in('id', $atributos_padre_value )->order_by('sort','ASC')->get_raw();

              /*Lista de combinaciones para el producto seleccionado*/
              foreach ($atributos_padre->result() as $atributo) {
                $atributo->valores=$atributos->where_in('id', $atributos_producto_array )->where('padre_id',$atributo->id)->order_by('sort','ASC')->get_raw()->result();
              }

              foreach ($combinaciones as $combinacion){
                 $precio=$producto->precio(1,$producto,$combinacion);
                 $precio_mayoreo=$producto->precio($combinacion->cat_precio_cantidad,$producto,$combinacion);
                  $producto_combinaciones[$combinacion->combinaciones]=array(
                  'id'=>$combinacion->id,
                  'mayoreo_precio'=>$precio_mayoreo['precio'],
                  'mayoreo_cantidad'=>$combinacion->cat_precio_cantidad,
                  'precio'=>$precio['precio'],
                  'precio_sin_promocion'=>$precio['precio_sin_promocion'],
                  'imagenes'=>$combinacion->combinacion_imagenes,
                  'stock'=>$combinacion->stock,
                  'comprar_sin_stock'=>$producto->comprar_sin_stock
                  );
              }
        }





        $this->layout_content = $this->load->view('catalogo/ficha', array(
            'combinaciones' => $combinaciones,
            'producto_combinaciones' => $producto_combinaciones,
            'atributos' => new Atributo,
            'producto' => $producto,
            'meta' => $meta,
            'breadcrum' => $this->breadcrumb($cat_categoria),
            'destacados' => $fg,
            'imagenes' => $imagenes,
            'portadas' => $portadas
        ), TRUE);

        $this->load->view('plantilla/default', array(
            'categoria' => $cat_categoria
        ));
    }

    public function categoria($categoria = '')
    {
        
        $portadas  = array();
        $cat_categoria = new cat_categoria;
        $cat_categoria->get_by_uri($categoria);
        if(!$cat_categoria->exists()) show_404();
        $super_categoria  = new cat_categoria();
        $super_categoria->where('padre_id', $cat_categoria->id)->get();

        $meta = array(
            'titulo' => $cat_categoria->{'metatitulo' . IDIOMA},
            'descripcion' => $cat_categoria->{'descripcion' . IDIOMA},
            'palabras_clave' => $cat_categoria->{'palabras_clave' . IDIOMA}
        );

        /*Lista de categorias*/
        if ($super_categoria->result_count() > 0) {
            $this->layout_content = $this->load->view('categorias', array(
                'categorias' => $super_categoria,
                'titulo' => $cat_categoria->titulo,
                'meta' => $meta,
                'breadcrumb' => $this->breadcrumb($cat_categoria)
            ), TRUE);
            $this->load->view('plantilla/default', array(
                'categoria' => $cat_categoria
            ));
            return false;
        }
         /*FIN Lista de categorias*/

        $allow_pagination = array(
            12,
            24,
            36
        );
        $allow_order      = array(
            'nombre',
            'popularidad',
            'precio'
        );


        if ($this->input->get('wstock') && ($this->input->get('wstock')=='true' || $this->input->get('wstock')=='false') )
            $this->session->set_userdata('wstock', $this->input->get('wstock'));
        $this->wstock = ($this->session->userdata('wstock')) ? $this->session->userdata('wstock') : 'false';
        if ($this->input->get('direction') && ($this->input->get('direction')=='asc' || $this->input->get('direction')=='desc') )
            $this->session->set_userdata('direction_orden', $this->input->get('direction'));
        $this->direction_orden = ($this->session->userdata('direction_orden')) ? $this->session->userdata('direction_orden') : 'asc';
        if ($this->input->get('per_page') && in_array($this->input->get('per_page'), $allow_pagination))
            $this->session->set_userdata('per_page', $this->input->get('per_page'));
        $this->per_page = ($this->session->userdata('per_page')) ? $this->session->userdata('per_page') : 2;
        if (!in_array($this->per_page, $allow_pagination))
            $this->per_page = $allow_pagination[0];
        if ($this->input->get('orden') && in_array($this->input->get('orden'), $allow_order))
            $this->session->set_userdata('orden', $this->input->get('orden'));
        $this->orden = ($this->session->userdata('orden')) ? $this->session->userdata('orden') : 'nombre';
        if (!in_array($this->orden, $allow_order))
            $this->orden = $allow_order[0];
        $catalogo = new Producto();

        $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));

        if($this->wstock=='true'){
            $catalogo->group_start()->where('stock >','0');
                $catalogo->or_where("(SELECT sum(cat_productos_subquery.stock)
                        FROM `cat_productos` `cat_productos_subquery`
                        LEFT OUTER JOIN `cat_productos` producto_cat_productos ON `producto_cat_productos`.`id` =
                        `cat_productos_subquery`.`producto_id`
                        WHERE producto_cat_productos.id = `cat_productos`.`id` and cat_productos_subquery.default=1 ) > 0")->group_end();
        }


        if ($categoria) {
            $catalogo->where_related_cat_categoria('uri', $categoria);
            $catalogo->or_where("FIND_IN_SET('{$cat_categoria->id}',categorias) >", 0);
        }
        $pag_segment = 3;
        if (IDIOMA)
            $pag_segment++;
        $total_rows = $catalogo->count();
        $pagina     = ($this->uri->segment($pag_segment)) ? $this->uri->segment($pag_segment) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $catalogo->clear();

        $catalogo->include_related('cat_precio');
        $catalogo->include_related('cat_categoria');
        $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));

        if($this->wstock=='true'){
            $catalogo->group_start()->where('stock >','0');
            $catalogo->or_where("(SELECT sum(cat_productos_subquery.stock)
                    FROM `cat_productos` `cat_productos_subquery`
                    LEFT OUTER JOIN `cat_productos` producto_cat_productos ON `producto_cat_productos`.`id` =
                    `cat_productos_subquery`.`producto_id`
                    WHERE producto_cat_productos.id = `cat_productos`.`id` and cat_productos_subquery.default=1 ) > 0")->group_end();
        }

        if ($this->orden == 'nombre')
            $catalogo->order_by('titulo', $this->direction_orden);
        elseif ($this->orden == 'popularidad')
            $catalogo->order_by('hits', $this->direction_orden);
        elseif ($this->orden == 'precio')
            $catalogo->order_by('cat_precio_precio_pesos', $this->direction_orden);

        if ($categoria) {
            $catalogo->where_related_cat_categoria('uri', $categoria);
            $catalogo->or_where("FIND_IN_SET('{$cat_categoria->id}',categorias) >", 0);
        }


        $catalogo->select("if(cat_precios.moneda='peso',cat_precios.precio,( cat_precios.precio * ".DOLAR." ) ) as cat_precio_precio_pesos");

        $catalogo->limit($this->per_page, $limit)->get();
        // $catalogo->check_last_query();

        /*Imagenes  predeterminadas de los productos*/
        $produtos_array_id = ($catalogo->all_to_single_array('id')) ? $catalogo->all_to_single_array('id') : '0';
        $imagenes          = new cat_imagen();
        $imagenes->select('producto_id,imagen')->where_in('producto_id', $produtos_array_id)->order_by('sort', 'asc')->get();

        foreach ($imagenes as $imagen) {
            if (empty($portadas[$imagen->producto_id]))
                $portadas[$imagen->producto_id] = $imagen->imagen;
        }

        /*variantes prederminadas */
        foreach ($catalogo as $producto) {
            $combinaciones = new Producto();
            $combinaciones=$combinaciones->include_related('cat_precio')->where('producto_id',$producto->id)->order_by('default','DESC')->limit(1)->get_raw();
            if($combinaciones->num_rows() ){
                $producto->combinacion=$combinaciones->row();
            }
        }


        /*Paginador*/
        $configuracion_paginador                = $this->config->item('pagination');
        $configuracion_paginador['first_link']  = '&lsaquo; ' . $this->lang->line('inicio');
        $configuracion_paginador['last_link']   = $this->lang->line('fin') . ' &rsaquo;';
        $configuracion_paginador['base_url']    = url_idioma(base_url('catalogo/' . $categoria));
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $configuracion_paginador['first_url']   = url_idioma(site_url('catalogo/' . $categoria ));
        $configuracion_paginador['suffix']      = '.html';
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content = $this->load->view('catalogo', array(
            'categoria' => $cat_categoria,
            'productos' => $catalogo,
            'portadas' => $portadas,
            'titulo' => $cat_categoria->titulo,
            'total_rows' => $total_rows,
            'meta' => $meta,
            'breadcrumb' => $this->breadcrumb($cat_categoria)
        ), TRUE);
        $this->load->view('plantilla/default', array(
            'categoria' => $cat_categoria
        ));
    }

    public function marca($marca = '')
    {
        $this->load->model('catalogo/cat_marca');
        $portadas  = array();
        $cat_marca = new cat_marca;
        $cat_marca->get_by_uri($marca);



        $meta = array(
            'titulo' => $cat_marca->{'metatitulo' . IDIOMA},
            'descripcion' => $cat_marca->{'descripcion' . IDIOMA},
            'palabras_clave' => $cat_marca->{'palabras_clave' . IDIOMA}
        );

         /*FIN Lista de categorias*/

        $allow_pagination = array(
            12,
            24,
            36
        );
        $allow_order      = array(
            'nombre',
            'popularidad',
            'precio'
        );


        if ($this->input->get('wstock') && ($this->input->get('wstock')=='true' || $this->input->get('wstock')=='false') )
            $this->session->set_userdata('wstock', $this->input->get('wstock'));
        $this->wstock = ($this->session->userdata('wstock')) ? $this->session->userdata('wstock') : 'false';
        if ($this->input->get('direction') && ($this->input->get('direction')=='asc' || $this->input->get('direction')=='desc') )
            $this->session->set_userdata('direction_orden', $this->input->get('direction'));
        $this->direction_orden = ($this->session->userdata('direction_orden')) ? $this->session->userdata('direction_orden') : 'asc';
        if ($this->input->get('per_page') && in_array($this->input->get('per_page'), $allow_pagination))
            $this->session->set_userdata('per_page', $this->input->get('per_page'));
        $this->per_page = ($this->session->userdata('per_page')) ? $this->session->userdata('per_page') : 2;
        if (!in_array($this->per_page, $allow_pagination))
            $this->per_page = $allow_pagination[0];
        if ($this->input->get('orden') && in_array($this->input->get('orden'), $allow_order))
            $this->session->set_userdata('orden', $this->input->get('orden'));
        $this->orden = ($this->session->userdata('orden')) ? $this->session->userdata('orden') : 'nombre';
        if (!in_array($this->orden, $allow_order))
            $this->orden = $allow_order[0];
        $catalogo = new Producto();
        $catalogo->include_related('cat_categoria');
        $catalogo->include_related('cat_marca');

        $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));
        if($this->wstock=='true'){
            $catalogo->group_start()->where('stock >','0');
                $catalogo->or_where("(SELECT sum(cat_productos_subquery.stock)
                        FROM `cat_productos` `cat_productos_subquery`
                        LEFT OUTER JOIN `cat_productos` producto_cat_productos ON `producto_cat_productos`.`id` =
                        `cat_productos_subquery`.`producto_id`
                        WHERE producto_cat_productos.id = `cat_productos`.`id` and cat_productos_subquery.default=1 ) > 0")->group_end();
        }

        if ($marca) {
            $catalogo->where_related_cat_marca('uri', $marca);
        }

        $pag_segment = 4;
        if (IDIOMA)
            $pag_segment++;
        $total_rows = $catalogo->count();
        $pagina     = ($this->uri->segment($pag_segment)) ? $this->uri->segment($pag_segment) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $catalogo->clear();

        $catalogo->include_related('cat_precio');
        $catalogo->include_related('cat_categoria');
        $catalogo->include_related('cat_marca');
        $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));

        if($this->wstock=='true'){
            $catalogo->group_start()->where('stock >','0');
                $catalogo->or_where("(SELECT sum(cat_productos_subquery.stock)
                        FROM `cat_productos` `cat_productos_subquery`
                        LEFT OUTER JOIN `cat_productos` producto_cat_productos ON `producto_cat_productos`.`id` =
                        `cat_productos_subquery`.`producto_id`
                        WHERE producto_cat_productos.id = `cat_productos`.`id` and cat_productos_subquery.default=1 ) > 0")->group_end();
        }

        if ($this->orden == 'nombre')
            $catalogo->order_by('titulo', $this->direction_orden);
        elseif ($this->orden == 'popularidad')
            $catalogo->order_by('hits', $this->direction_orden);
        elseif ($this->orden == 'precio')
            $catalogo->order_by('cat_precio_precio_pesos', $this->direction_orden);

        if ($marca) {
            $catalogo->where_related_cat_marca('uri', $marca);
        }

        $catalogo->select("if(cat_precios.moneda='peso',cat_precios.precio,( cat_precios.precio * ".DOLAR." ) ) as cat_precio_precio_pesos  ");
        $catalogo->limit($this->per_page, $limit)->get();

        /*Imagenes  predeterminadas de los productos*/
        $produtos_array_id = ($catalogo->all_to_single_array('id')) ? $catalogo->all_to_single_array('id') : '0';
        $imagenes          = new cat_imagen();
        $imagenes->select('producto_id,imagen')->where_in('producto_id', $produtos_array_id)->order_by('sort', 'asc')->get();
        foreach ($imagenes as $imagen) {
            if (empty($portadas[$imagen->producto_id]))
                $portadas[$imagen->producto_id] = $imagen->imagen;
        }

        /*variantes prederminadas */
        foreach ($catalogo as $producto) {
            $combinaciones = new Producto();
            $combinaciones=$combinaciones->include_related('cat_precio')->where('producto_id',$producto->id)->order_by('default','DESC')->limit(1)->get_raw();
            if($combinaciones->num_rows() ){
                $producto->combinacion=$combinaciones->row();
            }
        }


        /*Paginador*/
        $configuracion_paginador                = $this->config->item('pagination');
        $configuracion_paginador['first_link']  = '&lsaquo; ' . $this->lang->line('inicio');
        $configuracion_paginador['last_link']   = $this->lang->line('fin') . ' &rsaquo;';
        $configuracion_paginador['base_url']    = url_idioma(base_url('catalogo/marca/' . $marca));
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $configuracion_paginador['first_url']   = url_idioma(site_url('catalogo/marca/' . $marca ));
        $configuracion_paginador['suffix']      = '.html';
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content = $this->load->view('lista_productos_marca', array(
            'marca' => $cat_marca,
            'productos' => $catalogo,
            'portadas' => $portadas,
            'titulo' => $cat_marca->titulo,
            'total_rows' => $total_rows,
            'meta' => $meta,
            'breadcrumb' => $this->breadcrumb($cat_marca)
        ), TRUE);
        $this->load->view('plantilla/default', array(
            'marca' => $cat_marca
        ));
    }


    public function _busqueda($catalogo)
    {
        $catalogo->clear();
        $like_text = $this->session->userdata('catalogo_buscar');
        if ($like_text) {
            $catalogo->group_start()->or_like(array(
                'titulo' => $like_text,
                'uri' => $like_text,
                'SKU' => $like_text,
                'resumen' => $like_text,
                'descripcion' => $like_text
            ))->or_like_related_cat_categoria('titulo', $like_text)->group_end();
        }
    }
    public function _ordenar($catalogo)
    {
        if (!$this->session->userdata('catalogo_ordenar'))
            $this->session->set_userdata('catalogo_ordenar', array(
                'id',
                'DESC'
            ));
        $order = $this->session->userdata('catalogo_ordenar');
        if ($order[0] == 'categoria')
            $catalogo->order_by_related_cat_categoria('titulo', $order[1]);

        elseif ($order[0] == 'promocion')
            $catalogo->order_by_related_cat_precio('promocion', $order[1]);
        else
            $catalogo->order_by($order[0], $order[1]);
    }

    /**CRUD**/
    public function listar()
    {
        $this->titulo = 'CAT&Aacute;LOGO';
        $this->acceso->valida('catalogo', 'consultar', 1);

        //buscar
        if ($this->input->post('action_buscar')) {
            $this->session->set_userdata('catalogo_buscar', $this->input->post('buscar'));
        }

        //ordenar
        if ($this->input->post('ordenar')) {
            $order = $this->session->userdata('catalogo_ordenar');
            if ($this->input->post('ordenar') == $order[0] && $order[1] == 'ASC')
                $this->session->set_userdata('catalogo_ordenar', array(
                    $this->input->post('ordenar'),
                    'DESC'
                ));
            else
                $this->session->set_userdata('catalogo_ordenar', array(
                    $this->input->post('ordenar'),
                    'ASC'
                ));
        }
        $catalogo = new Producto;
        $this->_busqueda($catalogo);
        $total_rows = $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ))->count();
        $pagina     = ($this->uri->segment(4)) ? $this->uri->segment(4) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $this->_busqueda($catalogo);
        $this->_ordenar($catalogo);
        $catalogo->include_related('cat_categoria', array('titulo'));
        $catalogo->include_related('cat_categoria', array('titulo'));
        $catalogo->include_related('cat_precio');
        $catalogo->where(array(
            'is_enable' => 1,'producto_id'=>0
        ))->limit($this->per_page, $limit)->order_by('id', 'desc')->get();

        /*Paginador*/
        $configuracion_paginador                = $this->config->item('pagination');
        $configuracion_paginador['base_url']    = base_url('modulo/catalogo/listar/');
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content = $this->load->view('catalogo/gridCatalogo', $data = compact('catalogo'), true);
        $this->load->view('plantilla/backend/form');
    }

    public function lote()
    {
        $this->titulo = 'AGREGAR - PROMOCIONES POR LOTE';
        $this->acceso->valida('catalogo', 'consultar', 1);
        $data['catalogo'] = new Producto();
        $data['combinaciones'] = new Producto();
        $data['precios'] = new cat_precio();
        $categorias = new cat_categoria();

        $categorias->multiple_selected = explode(",", $data['catalogo']->categorias);

        $categorias->order_by('posicion')->get();

        $categorias->order_by('posicion')->get();
        $data['menu_categorias_multiple'] = $categorias->get_menu_categorias3(1);
        $this->acceso->valida('catalogo', 'editar', 1);
        $this->layout_content = $this->load->view('catalogo/formcatalogolote', $data, true);
        $this->load->view('plantilla/backend/form');

    }


    public function agregar()
    {
        $this->titulo = 'AGREGAR PRODUCTO';
        $this->acceso->valida('catalogo', 'consultar', 1);
        $data['catalogo']              = new Producto();
        $categorias                    = new cat_categoria();
        $data['combinaciones']         = new Producto();
        $data['precios']               = new cat_precio();
        $data['marcas'] = new cat_marca;
        $data['marcas']->order_by('id', 'asc')->get();
        $categorias->primary_selected  = $data['catalogo']->categoria_id;
        $categorias->multiple_selected = explode(",", $data['catalogo']->categorias);
        $categorias->order_by('posicion')->get();
        $data['menu_categorias'] = $categorias->get_menu_categorias3();
        $categorias->clear();
        $categorias->order_by('posicion')->get();
        $data['menu_categorias_multiple'] = $categorias->get_menu_categorias3(1);
        $this->acceso->valida('catalogo', 'editar', 1);
        $this->layout_content = $this->load->view('catalogo/formcatalogo', $data, true);
        $this->load->view('plantilla/backend/form');
    }

     public function guardar_combinacion($idprodu, $idnuevo=0){


        $this->titulo = ($idnuevo) ? 'EDITAR PRODUCTO' : 'AGREGAR PRODUCTO';

         if (!$_POST)show_error($this->lang->line('alert_request'));



         $this->acceso->valida('catalogo', 'editar', 1);
         $precios = new cat_precio();
         if($idnuevo!=0)$precios->where('producto_id',$idnuevo)->get();

         $producto = new Producto($idnuevo);
         $cat_imagen = new cat_imagen();
         $cat_imagen->where('producto_id',$idprodu)->get();


                unset($producto->validation['titulo']);
                unset($producto->validation['uri']);
                unset($producto->validation['categoria_id']);

                 if (isset($_POST['combinacion_imagenes']))
                $_POST['combinacion_imagenes'] = implode(",", $_POST['combinacion_imagenes']);


                $_POST['producto_id'] = $idprodu;

                //datos producto
                $campos = array(
                    'SKU',
                    'combinacion_imagenes',
                    'producto_id',
                    'peso',
                    'combinaciones',
                    'default',
                    'stock'
                );

                $producto->from_array($_POST, $campos);

                $producto->fecha_creacion = date('Y-m-d H:i:s');
                $producto->validation['combinaciones']=array('rules' => array('required'));

                if ($producto->save()) {

                    $producto->where('producto_id',$idprodu)->where('id <>',$producto->id)->update('default','0');

                    $_POST['producto_id'] = $producto->id;

                    //datos precios
                    $campos_precios = array(
                        'precio',
                        'costo',
                        'precio_mayoreo',
                        'promocion',
                        'activacion_promocion',
                        'desactivacion_promocion',
                        'cantidad',
                        'descuento_tipo',
                        'descuento_cantidad',
                        'producto_id',
                    );

                    $precios->from_array($_POST, $campos_precios);

                     if($precios->save()){

                         $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
                         $resp='off';
                         redirect('modulo/catalogo/editar_combinacion/'.$producto->id.'/'.$resp);
                    }

                }


            $atributos = new Atributo();
            $data['atributos'] = $atributos->where(array('padre_id'=>0,'is_enable'=>1))->get();
            $data['id_imgs']=explode(",", $producto->combinacion_imagenes);//Obtengo los id de seleccion de las imagenes
            $data['idprodu']=$idprodu;
            $data['idnuevo']=$idnuevo;
            $data['imagenes']=$cat_imagen;
            $data['mostrar']='on';
            $data['catalogo'] = $producto;
            $data['nuevo_precio'] = $precios;
            $data['producto_padre']=new Producto();
            $data['producto_padre']->include_related("cat_precio")->where('id',$data['catalogo']->producto_id)->get();

            $data['combinacion_produ'] = explode(',',$producto->combinaciones);

            $this->db->select('grupo.id as grupo_id, grupo.nombre as grupo_nombre, cat_atributos.*');
            $this->db->from('cat_atributos');
            $combinacion=$this->db->join('cat_atributos AS grupo', 'grupo.id = cat_atributos.padre_id')->where_in('cat_atributos.id', $data['combinacion_produ'])->get();

            $data['resultados']=$combinacion->result();


            $this->layout_content = $this->load->view('catalogo/combinacion', $data, true);
            $this->layout_assets=array(
                    'js'=>array(base_url('pub/libraries/trahctools/js/catalogo_editar.js'))
            );
         $this->load->view('plantilla/backend/form');

    }

    public function editar_combinacion($idprodu,$resp='on'){

        $this->titulo = 'EDITAR PRODUCTO';
        $this->acceso->valida('catalogo', 'consultar', 1);

        $data['catalogo']=new PRODUCTO($idprodu); //Obtengo los datos del producto actual.

        $data['nuevo_precio'] = new cat_precio(); //Obtengo los precios del producto
        $data['nuevo_precio']->where('producto_id',$idprodu)->get();

        $data['id_imgs']=explode(",", $data['catalogo']->combinacion_imagenes);//Obtengo los id de seleccion de las imagenes

        $data['imagenes'] = new cat_imagen();
        $data['imagenes']->where(array('producto_id'=>$data['catalogo']->producto_id))->get();//Todas las imagenes del producto original

        $data['idnuevo']=$idprodu;
        $data['idprodu']=$data['catalogo']->producto_id;

        $data['mostrar']=$resp;

        $atributos = new Atributo();
        $data['atributos'] = $atributos->where(array('padre_id'=>0,'is_enable'=>1))->get();

        $combinacionesprodu = new PRODUCTO($idprodu);
        $data['combinacion_produ']=explode(',',$combinacionesprodu->combinaciones);

        $atributos_produ=new Atributo();// Obtener los atributos y valores de la tabla cat_atributos

        $this->db->select('grupo.id as grupo_id, grupo.nombre as grupo_nombre, cat_atributos.*');
        $this->db->from('cat_atributos');
        $combinacion=$this->db->join('cat_atributos AS grupo', 'grupo.id = cat_atributos.padre_id')->where_in('cat_atributos.id', $data['combinacion_produ'])->get();

        $data['resultados']=$combinacion->result();

        $data['producto_padre']=new Producto();
        $data['producto_padre']->include_related("cat_precio")->where('id',$data['catalogo']->producto_id)->get();

        $this->layout_content  = $this->load->view('catalogo/combinacion', $data, true);
        $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/catalogo_editar.js'))
        );

        $this->load->view('plantilla/backend/form');

    }

    public function guardar_lote()
    {
            $this->titulo = 'AGREGAR - PROMOCIONES POR LOTE';
             if (!$_POST)show_error($this->lang->line('alert_request'));
            $this->acceso->valida('catalogo', 'editar', 1);
            $producto = new Producto;
            $precios = new cat_precio;
            $catalogo = array();
            $var=0;

            //print_pre($_POST['categorias']); die();
            if (isset($_POST['categorias'])){

                foreach ($_POST['categorias'] as $key => $value) {
                        $catalogo = $producto->include_related("cat_precio")->where('categoria_id', $value)->get();

                        foreach ($catalogo as $value):
                            $precios->where('producto_id',$value->id)->get();

                            $value->cat_precio->descuento_cantidad = $_POST['descuento_cantidad'] ;
                            //echo  'kdkd'.$_POST['descuento_cantidad']; die();
                            if($_POST['descuento_cantidad']==0 || $_POST['descuento_cantidad']==''){
                                 $value->cat_precio->promocion = 0;
                            }else{
                                 $value->cat_precio->promocion = 1;
                            }

                            $value->cat_precio->descuento_tipo = 'porcentaje';
                            $value->cat_precio->activacion_promocion = $_POST['activacion_promocion'];
                            $value->cat_precio->desactivacion_promocion = $_POST['desactivacion_promocion'];

                            $var = $value->cat_precio->save() ? $var=1:$var=0;
                        endforeach;

                }


                        if($var==1){
                                    $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
                                    redirect('modulo/catalogo/lote/');
                        }else{
                                    $this->titulo = 'AGREGAR - PROMOCIONES POR LOTE';
                                     if (!$_POST)show_error($this->lang->line('alert_request'));
                                    $this->acceso->valida('catalogo', 'consultar', 1);

                                    $data['precios'] = new cat_precio();
                                    $categorias = new cat_categoria();

                                    $data['precios']->descuento_cantidad = $_POST['descuento_cantidad'];

                                    $data['precios']->validate();

                                    $categorias->multiple_selected = $_POST['categorias'];

                                    $categorias->order_by('posicion')->get();

                                    $data['menu_categorias_multiple'] = $categorias->get_menu_categorias3(1);

                                    $this->layout_content = $this->load->view('catalogo/formcatalogolote', $data, true);
                                    $this->load->view('plantilla/backend/form');
                        }
             }else{
                        $this->titulo = 'AGREGAR - PROMOCIONES POR LOTE';
                         if (!$_POST)show_error($this->lang->line('alert_request'));
                        $this->acceso->valida('catalogo', 'consultar', 1);


                        $data['precios'] = new cat_precio();
                        $miscategorias = new cat_categoria();

                        $data['precios']->descuento_cantidad = $_POST['descuento_cantidad'];

                        $data['precios']->validate();

                        //$miscategorias->multiple_selected = $_POST['categorias'];

                        $miscategorias->order_by('posicion')->get();

                        $data['menu_categorias_multiple'] = $miscategorias->get_menu_categorias3(1);

                        $this->layout_content = $this->load->view('catalogo/formcatalogolote', $data, true);
                        $this->load->view('plantilla/backend/form');


            }
    }

    public function guardar($id = 0)
    {
        $this->titulo = ($id) ? 'EDITAR PRODUCTO' : 'AGREGAR PRODUCTO';
        if (!$_POST)show_error($this->lang->line('alert_request'));
        $this->acceso->valida('catalogo', 'editar', 1);
        $catalogo    = new Producto($id);
        $nuevaImagen = new cat_imagen;

        if (isset($_POST['categorias']))
        $_POST['categorias'] = implode(",", $_POST['categorias']);
        $campos = array(
            'titulo',
            'uri',
            'marca_id',
            'SKU',
            'resumen',
            'descripcion',
            'fecha_creacion',
            'fecha_activacion',
            'fecha_desactivacion',
            'caracteristicas',
            'metatitulo',
            'palabras_clave',
            'categoria_id',
            'categorias',
            'titulo_en',
            'resumen_en',
            'descripcion_en',
            'metatitulo_en',
            'palabras_clave_en',
            'comprar_sin_stock',
            'peso',
            'agotado',
            'stock',
        );
        $catalogo->from_array($_POST, $campos);

        $precios = new cat_precio();
       if($id) $precios->where('producto_id',$id)->get();
        $_POST['producto_id'] = $id;

        $campos_precios = array(
            'precio',
            'costo',
            'impuesto',
            'moneda',
            'precio_mayoreo',
            'promocion',
            'activacion_promocion',
            'desactivacion_promocion',
            'cantidad',
            'descuento_tipo',
            'descuento_cantidad',
            'producto_id',
        );



        $fg = new Relacionado();
        $fg->where(array(
            'rootproducto_id' => $id
        ))->get()->delete_all();
        if (is_array($this->input->post('destacados')))
            foreach ($this->input->post('destacados') as $key => $value) {
                $fg = new Relacionado();
                $fg->producto_id     = $value;
                $fg->rootproducto_id = $id;
                $fg->sort            = $key;
                $fg->save();
            }
        if (!$id) {
            $catalogo->fecha_creacion = date('Y-m-d H:i:s');
            $catalogo->usuario_id = $this->session->userdata('logged_user');
        }
        if ($catalogo->save()) {

            $precios->from_array($_POST, $campos_precios);
            $precios->save();

            if ($this->input->post('cat_imagen')) {
                $nuevaImagen->imagen = $this->input->post('cat_imagen');
                $nuevaImagen->titulo = $this->input->post('titulo_imagen');
                $nuevaImagen->producto_id = $catalogo->id;
                $nuevaImagen->sort        = '0';
                $nuevaImagen->save();
                $nuevaImagen->where(array(
                    'producto_id' => $catalogo->id,
                    'id <>' => $nuevaImagen->id
                ))->update(array(
                    'sort' => 'sort + 1'
                ), false);
            }
            if (is_array($this->input->post('cat_imagenes')))
                foreach ($this->input->post('cat_imagenes') as $indice => $id) {
                    $imagen       = new cat_imagen($id);
                    $imagen->sort = $indice;
                    $imagen->save();
                }
            $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
            redirect('modulo/catalogo/editar/' . $catalogo->id);
        } else {
            $data['catalogo'] = $catalogo;
            $data['precios'] = $precios;
            $categorias = new cat_categoria();
            $categorias->primary_selected  = $data['catalogo']->categoria_id;
            $categorias->multiple_selected = explode(",", $data['catalogo']->categorias);
            $categorias->order_by('posicion')->get();
            $data['menu_categorias'] = $categorias->get_menu_categorias3();
            $categorias->clear();
            $categorias->order_by('posicion')->get();
            $data['menu_categorias_multiple'] = $categorias->get_menu_categorias3(1);
            $data['combinaciones']         = new Producto();
            $data['marcas'] = new cat_marca;
            $data['marcas']->order_by('id', 'asc')->get();
            $this->layout_content             = $this->load->view('catalogo/formcatalogo', $data, true);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function agregar_combinacion($idprodu){

        $this->titulo = 'EDITAR PRODUCTO';

        $data['catalogo'] = new Producto();
        $data['idprodu'] = $idprodu;
        $data['idnuevo'] = '';
        $data['precios'] = new cat_precio();
        $data['precios']->where('producto_id',$idprodu)->get();
        $data['nuevo_precio'] = new cat_precio();
        $data['imagenes'] = new cat_imagen();
        $data['imagenes']->where(array('producto_id'=>$idprodu))->get();
        $data['id_imgs']=array();
        $data['mostrar']='on';
        $data['combinacion_produ']='';
        $data['producto_padre']=new Producto();
        $data['producto_padre']->include_related("cat_precio")->where('id',$idprodu)->get();


        $atributos = new Atributo();
        $data['atributos'] = $atributos->where(array('padre_id'=>0,'is_enable'=>1))->get();

        $this->layout_content =$this->load->view('combinacion',$data, true);
        $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/catalogo_editar.js'))
        );
         $this->load->view('plantilla/backend/form');
    }

  public function atributos_valores($atributo_id){

      $atributo_valores=new Atributo();
      $atributo_valores->where(array('padre_id'=>$atributo_id,'is_enable'=>1))->order_by('sort')->get();
         $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/catalogo_editar.js'))
        );
      echo $this->load->view('atributos_select',array('atributos'=>$atributo_valores),true);
  }

    public function editar($id)
    {

        $this->titulo = 'EDITAR PRODUCTO';
        $this->acceso->valida('catalogo', 'consultar', 1);
        $data['catalogo'] = new Producto($id);

        $data['precios'] = new cat_precio();

        $data['precios']->where('producto_id',$id)->get();
        $categorias = new cat_categoria();
        $categorias->primary_selected  = $data['catalogo']->categoria_id;
        $categorias->multiple_selected = explode(",", $data['catalogo']->categorias);
        $categorias->order_by('posicion')->get();
        $data['menu_categorias'] = $categorias->get_menu_categorias3();
        $categorias->clear();
        $categorias->order_by('posicion')->get();
        $data['menu_categorias_multiple'] = $categorias->get_menu_categorias3(1);
        $data['marcas'] = new cat_marca;
        $data['marcas']->order_by('id', 'asc')->get();
        $data['item'] = new Relacionado();
        $data['item']->include_related('producto', array(
            'id',
            'titulo'
        ));

        $atributos = new Atributo();
        $data['atributos'] = $atributos->where(array('padre_id'=>0,'is_enable'=>1))->get();

        $data['combinaciones']=new Producto();
        $data['combinaciones']->where('producto_id', $id)->get();

         foreach ($data['combinaciones'] as $key => $value) {

             $this->db->select('grupo.id as grupo_id, grupo.nombre as grupo_nombre, cat_atributos.*');
             $this->db->from('cat_atributos');
             $combinacion=$this->db->join('cat_atributos AS grupo', 'grupo.id = cat_atributos.padre_id')->where_in('cat_atributos.id', explode(',', $value->combinaciones))->get();
             $value->result_combinaciones=$combinacion->result();

        }

        $data['item']->where('rootproducto_id', $id)->order_by('sort', 'ASC')->get();
        $data['catalogoImagen'] = $data['catalogo']->cat_imagen->order_by('sort', 'asc')->get();
        $this->layout_content   = $this->load->view('catalogo/formcatalogo', $data, true);
        $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/catalogo_editar.js'))
        );
        $this->load->view('plantilla/backend/form');
    }
    public function eliminar_imagen()
    {
        $this->acceso->valida('catalogo', 'eliminar', 1);
        $catalogo = new cat_imagen;
        $catalogo->where_in('id', $this->input->post('post_ids'))->get()->delete();
    }

    public function eliminar_combinacion($id)
    {
        $this->acceso->valida('catalogo', 'eliminar', 1);
        $catalogo = new Producto();
        $catalogo->where('id', $id)->get();
        $id_produ=$catalogo->producto_id;

        $atributo_id = explode(',', $catalogo->combinaciones);
        $atributos = new Atributo();

        // if(count($atributo_id)>=1){
        //     foreach ($atributo_id as $value) {
        //             $atributos->where(array('id'=>$value))->get();
        //             $atributos->delete();
        //     }
        // }

        // $imagenes = new cat_imagen;
        // $imagenes->where_in('producto_id',$catalogo->producto_id)->get();
        // $imagenes->delete();
        $catalogo->delete();

        redirect('modulo/catalogo/editar/'.$id_produ);

    }

    public function eliminar()
    {
        $this->acceso->valida('catalogo', 'eliminar', 1);
        $catalogo = new Producto();
        $catalogo->where_in('id', $this->input->post('post_ids'))->update('is_enable', 0);
        $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
        redirect('modulo/catalogo/listar/');
    }
    public function prev_recortar()
    {
        $imagenes = new cat_imagen;
        $this->acceso->valida('catalogo', 'editar', 1);
        $imagen         = new Image_fit();
        $ruta_imagen    = strstr($this->input->post('imagen'), "pub/uploads");
        $data['imagen'] = $ruta_imagen;
        $data['imagen'] = urldecode($data['imagen']);
        $data['width']  = $imagenes->lista_w;
        $data['height'] = $imagenes->lista_h;
        $imagen->_inicializar($data);
        $imagen->upload_dir   = 'pub/uploads/thumbs';
        $data['imagen_lista'] = $imagen->escalar();
        $data['width']        = $imagenes->thumb_w;
        $data['height']       = $imagenes->thumb_h;
        $imagen->_inicializar($data);
        $imagen->upload_dir   = 'pub/uploads/thumbs';
        $data['imagen_thumb'] = $imagen->escalar();
        $data['lista_w']      = $imagenes->lista_w;
        $data['lista_h']      = $imagenes->lista_h;
        $data['thumb_w']      = $imagenes->thumb_w;
        $data['thumb_h']      = $imagenes->thumb_h;
        $this->load->view("catalogo/recortar", $data);
    }
    public function recortar()
    {
        $this->acceso->valida('catalogo', 'editar', 1);
        $crop_imagen    = new Image_fit();
        $cordenadas     = json_decode($this->input->post('cordenadas_lista'));
        $data['imagen'] = $this->input->post('imagen_lista');
        $data['crop_x'] = $cordenadas->x;
        $data['crop_y'] = $cordenadas->y;
        $data['width']  = $cordenadas->x2 - $cordenadas->x;
        $data['height'] = $cordenadas->y2 - $cordenadas->y;
        $crop_imagen->_inicializar($data);
        $crop_imagen->cortar();
        $cordenadas     = json_decode($this->input->post('cordenadas_thumb'));
        $data['imagen'] = $this->input->post('imagen_thumb');
        $data['crop_x'] = $cordenadas->x;
        $data['crop_y'] = $cordenadas->y;
        $data['width']  = $cordenadas->x2 - $cordenadas->x;
        $data['height'] = $cordenadas->y2 - $cordenadas->y;
        $crop_imagen->_inicializar($data);
        $crop_imagen->cortar();
        echo json_encode(array(
            'response' => 'TRUE'
        ));
    }
}
