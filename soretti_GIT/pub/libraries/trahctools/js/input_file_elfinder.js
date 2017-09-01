/*Input file  elfinder*/
/*Requiere Juquery | jquery.popupWindow.js*/
var input_file_selected;

function popup_elfinder()
{
  $(".filemanager.popup").off("click");
  $(".show_image_input").off("click");
  
  $(".show_image_input").click(function(){

  });

  $(".filemanager.popup").click(function()
  {
      input_file_selected = $(this).parent().prev();
  });

	$(".show_image_input").fancybox({  
	 type:'iframe',
	 onReady : function()
	   {
	   	 file=$(this.element).parent().next().val();
	   	 if(!file) $.fancybox.close();
	   	 this.href=$(this.element).parent().next().val();
	       }
	}); 
	      
  $(".filemanager.popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );

}

$(document).ready(function() {
	popup_elfinder();
});