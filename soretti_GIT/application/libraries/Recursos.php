<?php
class Recursos
{
    private $CI;


	function __construct(){
		$this->CI=&get_instance();
	}


    function sitemap()
    {
        $url='';
        $proyecto=$this->CI->config->item('proyecto'); 

        $paginas=$this->CI->db->where('is_enable','1')->where('id <>','24')->order_by('id desc')->limit(300)->get('paginas')->result();
 
        $productos=$this->CI->db->query("SELECT cat_productos.uri as producto_uri, cat_categorias.uri as categoria_uri from cat_productos LEFT JOIN cat_categorias ON  cat_productos.categoria_id=cat_categorias.id  WHERE  cat_productos.is_enable=1 order by cat_productos.id DESC LIMIT 500")->result();

        foreach ($paginas as $pagina)
        {
            if($pagina->tipo=='blogs' || $pagina->plantilla=='firma' || $pagina->plantilla=='noticias') $prev='blog';
            else $prev = 'web';
 
            $url.="\n<url>
                        <loc>".base_url($prev."/".$pagina->uri.".html")."</loc>
                        <priority>1.0</priority>
                        <changefreq>monthly</changefreq>
                    </url>\n";

            if($prev=='blog'){
                $articulos=$this->CI->db->where(array('is_enable'=>1,'pagina_id'=>$pagina->id))->order_by('id desc')->limit(300)->get('blog_articulos')->result();
                foreach ($articulos as $articulo) {
                            $url.="\n<url>
                                <loc>".base_url($prev."/".$pagina->uri."/".$articulo->uri.".html")."</loc>
                                <priority>1.0</priority>
                                <changefreq>never</changefreq>
                            </url>
                          \n";
                }
            }

        }
    

        if($proyecto['catalogo'] || $proyecto['tienda']) foreach ($productos as $producto)
        {

            $url.="\n<url>
                        <loc>".base_url("catalogo/".$producto->categoria_uri."/".$producto->producto_uri.".html")."</loc>
                        <priority>1.0</priority>
                        <changefreq>never</changefreq>
                    </url>
                  \n";
        }

        $sitemap='<?xml version="1.0" encoding="UTF-8" ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>'.base_url().'</loc>
                <priority>1.0</priority>
                <changefreq>monthly</changefreq>
            </url>
            '.$url.'
        </urlset>';

        write_file('sitemap.xml',$sitemap,'w+');

    } 
}
