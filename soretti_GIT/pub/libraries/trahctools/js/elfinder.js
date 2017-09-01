function getExtention(fileName){
 var i = fileName.lastIndexOf('.');
 if(i === -1 ) return false;
 return fileName.slice(i)
}

 
 var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (URL) {

    file_extension=getExtention(URL);

    var valid_crop_extensions = [".jpg", ".jpeg", ".png", ".gif"];
    var valid_extension = valid_crop_extensions.indexOf(file_extension);
 

   

      if(opener!=null && opener.input_file_selected != '')
      {

    var width =opener.input_file_selected.attr('width'); 
    var height =opener.input_file_selected.attr('height');
    var campo =opener.input_file_selected.attr('name');
    var modulo =opener.input_file_selected.attr('modulo');

    $("#width").val(width);
    $("#height").val(height);
    $("#imagen").val(URL);
    $("#modulo").val(modulo);
    $("#campo").val(campo);
            
        if(opener.input_file_selected.attr('galeria'))
        {
          opener.input_file_selected.val(URL);
          goto(base_url+'modulo/galeria/prev_recortar');
          $('#myform').submit();
        }            
        else if(opener.input_file_selected.attr('catalogo'))
        {
          opener.input_file_selected.val(URL);
          goto(base_url+'modulo/catalogo/prev_recortar');
          $('#myform').submit();
        }
        else if(valid_extension>=0)
        {   
            var img = new Image();


            img.src = URL;
            img.onload = function() {
                // verificar que el tamaño de la imagen no sea más pequeño
                if(width && height){
                   if(img.height < height ||  img.width < width)
                   {
                     alert('Las dimensiones de la imagen deben ser mayores a '+width+' x '+height+' px' );
                     return;
                   }
                }

                if( img.height > height ||  img.width > width )
                {
                  goto(base_url+'modulo/imagen/prev_recortar');
                  $('#myform').submit();
                  return; 
                }else{
                  opener.input_file_selected.val(URL);
                  opener.input_file_selected='';
                  window.close();
                }     
            }
            
        }else{
            opener.input_file_selected.val(URL);
            opener.input_file_selected='';
            window.close();
        }
        return;      
      }
     

      // pass selected file path to TinyMCE
      parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

      // close popup window
      parent.tinymce.activeEditor.windowManager.close();
    }
 }

    $(document).ready(function() {
        var elf = $('#file-manager').elfinder({
            url : base_url+'modulo/filemanager/load_elfinder',
            getFileCallback: function(file) { // editor callback
             FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE 
            },
            lang: 'es',
        }).elfinder('instance');
    });