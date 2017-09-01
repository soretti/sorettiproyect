function mySubmit (URL) {

    file_extension=getExtention(URL);
    var valid_crop_extensions = [".jpg", ".jpeg", ".png", ".gif"];
    var valid_extension = valid_crop_extensions.indexOf(file_extension);
      
 

      if(opener!=null && opener.input_file_selected != '')
      {
        if(valid_extension==0)
        {
            var img = new Image();
            var width =opener.input_file_selected.attr('width');
            var height =opener.input_file_selected.attr('height');

            img.src = URL;
            img.onload = function() {
                if( img.height > height ||  img.width > width )
                {
                  goto(base_url+'/modulo/imagen/prev_recortar');
                  $("#width").val(width);
                  $("#height").val(height);
                  $("#imagen").val(URL);
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