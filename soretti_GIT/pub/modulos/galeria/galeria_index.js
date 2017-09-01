	function galeria_home(){
		 $('.lo_ultimo_fotog').bxSlider({
		  slideWidth: 720,
		  minSlides: 1,
		  maxSlides: 1,
		  slideMargin: 0,
		  moveSlides:1,
		  pager: false
		});
	}
	

	$(window).load(function() {
            $("#ultimas_multimedia .lo_ultimo_multimedia a").click(function(event) {
                event.preventDefault();
                $("#carga").load(base_url+"modulo/galeria/mostrar_galeria/"+$(this).attr("id"),false,galeria_home);
            });
           $(".thumb img").tooltip();
		   $(".thumb img").mouseover(function() {
		    	$(this).css('cursor', 'pointer');
		   });
    });

    $(document).ready(function() {
       $('.lo_ultimo_multimedia').bxSlider({
		  slideWidth: 146,
		  minSlides: 6,
		  maxSlides: 4,
		  slideMargin: 5,
		  moveSlides:1,
		  pager: false
		});    	
    	galeria_home();	
    });