<?php

class Buscador_controller extends MX_Controller
{
    public $per_page=30;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('catalogo/producto'); 
        $this->load->model('catalogo/cat_imagen'); 
        $this->load->model('blog/articulo'); 
    }
 
    function index($keyword=''){

        $keyword=mysql_real_escape_string(urldecode($keyword));
        $this->per_page=10;
        $per_page=3;
        if(IDIOMA)  $per_page++;
        $pagina=($this->uri->segment($per_page)) ? $this->uri->segment($per_page)-1 : 0;
        $limit=($pagina*$this->per_page);

        $query_string="
            SELECT blog_articulos.fecha_creacion, blog_articulos.id, blog_articulos.titulo,blog_articulos.titulo_en, blog_articulos.uri, blog_articulos.resumen,blog_articulos.resumen_en, 'articulo' as tipo, paginas.uri as categoria 
            FROM blog_articulos left join paginas on paginas.id=blog_articulos.pagina_id WHERE 
            (blog_articulos.titulo like '%$keyword%' or blog_articulos.contenido like '%$keyword%' or
            blog_articulos.palabras_clave like '%$keyword%' or
            blog_articulos.titulo_en like '%$keyword%' or blog_articulos.contenido_en like '%$keyword%') AND (blog_articulos.is_enable = 1 and paginas.is_enable=1)
                
                UNION

            SELECT paginas.fecha_creacion, paginas.id, titulo,titulo_en, uri, 'descripcion' AS resumen,'descripcion' AS resumen_en, 'pagina' as tipo, '' as categoria FROM paginas WHERE 
            (titulo like '%$keyword%' or contenido like '%$keyword%' or
            paginas.palabras_clave like '%$keyword%' or
            titulo_en like '%$keyword%' or contenido_en like '%$keyword%' ) AND paginas.is_enable = 1
                
                UNION

            SELECT cat_productos.fecha_creacion, cat_productos.id, cat_productos.titulo,cat_productos.titulo_en,cat_productos.uri, cat_productos.resumen,cat_productos.resumen_en, 'producto' as tipo, cat_categorias.uri as categoria FROM  cat_productos 
            LEFT JOIN cat_categorias ON cat_categorias.id=cat_productos.categoria_id WHERE 
            (cat_productos.titulo like '%$keyword%' or cat_productos.descripcion like '%$keyword%' or  cat_productos.resumen like '%$keyword%' or
            cat_productos.palabras_clave like '%$keyword%' or
            cat_productos.titulo_en like '%$keyword%' or cat_productos.descripcion_en like '%$keyword%' or  cat_productos.resumen_en like '%$keyword%') and cat_productos.is_enable=1
            "; 

        $total_resultados=$this->db->query("SELECT COUNT(*) as total  FROM ($query_string) as total"
        )->row()->total;

        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['first_link'] = '&lsaquo; '.$this->lang->line('inicio');
        $configuracion_paginador['last_link'] = $this->lang->line('fin').' &rsaquo;';
        $configuracion_paginador['base_url'] = url_idioma(base_url('buscador/'.$keyword));
        $configuracion_paginador['total_rows'] = $total_resultados;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = $per_page;
        $this->pagination->initialize($configuracion_paginador);

        $query=$this->db->query(" $query_string ORDER BY titulo ASC LIMIT $limit,$this->per_page ");

        $meta=array('titulo'=>$this->lang->line('resultados').' : '.$keyword,'descripcion'=>'Busqueda de resultados','palabras_clave'=>'');
        $this->layout_content=$this->load->view('resultados',array('resultados'=>$query,"keyword"=>$keyword,'titulo'=>$this->lang->line('resultados').' : '.$keyword,'meta'=>$meta), TRUE);
        $this->load->model('pagina/pagina');
        $pagina=new Pagina;
        $pagina->titulo=$this->lang->line('resultados').' : '.$keyword;
        $this->load->view('plantilla/default',array('pagina'=>$pagina));

    }

public function catalogo($keyword = '')
    {
        $this->load->model('catalogo/cat_precio');
        $this->load->model('catalogo/cat_categoria');
        $this->load->model('catalogo/cat_marca');
        $keyword=mysql_real_escape_string(urldecode($keyword));


        $portadas  = array();

        $meta = array(
            'titulo' =>'buscador: '.$keyword,
            'descripcion' => 'Busqueda de productos',
            'palabras_clave' => ''
        );

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

        $catalogo->include_related('cat_marca',array('titulo'));
        $catalogo->include_related('cat_categoria',array('titulo'));

        $catalogo->group_start()->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));
        if($this->wstock=='true')
            $catalogo->where('stock >',0)->group_end()->group_start();

        $catalogo->like('titulo', $keyword);
        $catalogo->or_like('resumen',$keyword);
        $catalogo->or_like('descripcion',$keyword);
        $catalogo->or_like('metatitulo',$keyword);
        $catalogo->or_like('palabras_clave',$keyword);
        $catalogo->or_like('SKU',$keyword);
        $catalogo->or_like('caracteristicas',$keyword);
        $catalogo->or_like_related_cat_categoria('titulo',$keyword);
        $catalogo->or_like_related_cat_marca('titulo',$keyword)->group_end();

        $pag_segment = 4;
        if (IDIOMA)
            $pag_segment++;
        $total_rows = $catalogo->count(); 
        $pagina     = ($this->uri->segment($pag_segment)) ? $this->uri->segment($pag_segment) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $catalogo->clear();

        $catalogo->include_related('cat_precio');
        $catalogo->include_related('cat_marca',array('titulo'));
        $catalogo->include_related('cat_categoria',array('titulo','uri'));
        $catalogo->group_start()->where(array(
            'is_enable' => 1,'producto_id'=>0
        ));
        if($this->wstock=='true')
            $catalogo->where('stock >',0)->group_end()->group_start();

        $catalogo->like('titulo', $keyword);
        $catalogo->or_like('resumen',$keyword);
        $catalogo->or_like('descripcion',$keyword);
        $catalogo->or_like('metatitulo',$keyword);
        $catalogo->or_like('palabras_clave',$keyword);
        $catalogo->or_like('SKU',$keyword);
        $catalogo->or_like('caracteristicas',$keyword);
        $catalogo->or_like_related_cat_categoria('titulo',$keyword);
        $catalogo->or_like_related_cat_marca('titulo',$keyword)->group_end();

        if ($this->orden == 'nombre')
            $catalogo->order_by('titulo', $this->direction_orden);
        elseif ($this->orden == 'popularidad')
            $catalogo->order_by('hits', $this->direction_orden);
        elseif ($this->orden == 'precio')
            $catalogo->order_by('cat_precio_precio_pesos', $this->direction_orden);

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
        $configuracion_paginador['base_url']    = url_idioma(base_url('buscador/catalogo/' . $keyword));
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = $pag_segment;
        $configuracion_paginador['first_url']   = url_idioma(site_url('buscador/catalogo/' . $keyword));
        $configuracion_paginador['suffix']      = '.html';
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content = $this->load->view('catalogo/resultados_buscador', array(
            'productos' => $catalogo,
            'portadas' => $portadas,
            'total_rows' => $total_rows,
            'keyword' => $keyword,
            'meta' => $meta
        ), TRUE);
        $this->load->view('plantilla/default', array('keyword'=>$keyword));
    }



}
