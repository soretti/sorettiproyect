  $(document).ready(function(){
        $( '.tab-pane input[type="radio"]' ).click(function() {
            $('.tab-pane.active .link').attr("value",$(this).attr("value"));
        });

        $(".filemanager").fancybox({
            href : base_url+'modulo/filemanager',
            beforeShow : function()
            {
              type=$(this.element).is('input');
              if(type==true)
                input_file_selected=$(this.element);
            else
                input_file_selected=$(this.element).prev();
        },
        afterClose : function(){
          $('#inputUrl').attr('value', $('input.filemanager').val());
      }

  });

     $( ".nav-tabs a" ).click(function() {
          $('input#inputUrl').attr("value","");
      });

        $("#aplicar").click(function(){
            opener.input_file_selected.val($('.tab-pane.active .link').val());
            window.close();
        });

        $(".grid_seleccionar").click(function()
        {
            group = $(this).parent().parent();
        });

        $(".popup").click(function()
        {
            input_file_selected = $(this).parent().prev();
        });

        $(".popup, .grid_seleccionar").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1});
    });