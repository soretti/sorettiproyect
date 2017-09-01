	$(document).ready(function()
	{

		var publicidadbtn = $("li[tipo='publicidad'] .dd-handle")
			publicidadbtn.css("background-image", "-webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #f38a08), color-stop(100%, #c7740c))");
			publicidadbtn.css("background-image", "-webkit-linear-gradient(top, #f38a08 0%,#c7740c 100%)");
			publicidadbtn.css("background-image", "-moz-linear-gradient(top, #f38a08 0%,#c7740c 100%)");
			publicidadbtn.css("background-image", "-o-linear-gradient(top, #f38a08 0%,#c7740c 100%)");
			publicidadbtn.css("background-image", "linear-gradient(top, #f38a08 0%,#c7740c 100%)");

		function getItems(exampleNr)
		{
			var columns = [];

			$(exampleNr + ' #nestable2 ol.sortable-list').each(function(){
				columns.push($(this).sortable('toArray').join(','));                
			});
			return columns.join('|');
		}
		function renderJsonItems(items)
		{
			var html = '';
			var columns = items.split('|');
			for ( var c in columns )
			{
				if ( columns[c] != '' )
				{
					html += '[';
					var items = columns[c].split(',');
					for ( var i in items )
					{
						if ( i != 0 )
						{
							html += ',';
						}
						html += '{"id":"'+items[i]+'","tipo":"'+$("#nestable2 li").eq(i).attr("tipo")+'"}';
					}
					html += ']';
				}
			}
            //$('#example-2-4-renderarea').html(html);
            return html;
        }
        $('#guardar-columna').click(function(){
        	$("#lista_json_modulos").val(renderJsonItems(getItems('#example-2-1')));
        });
        $('.sortable-list').sortable({
        	connectWith: '.sortable-list',
        	placeholder: 'dd-placeholder',
        	start: function(event, ui) {
        		ui.placeholder.height(ui.item.height());

        	}
        });
       
        $( "#inputlabel" ).focusout(function() {
        	if($( "#inputnombre" ).val() == ""){
        		$( "#inputnombre" ).val( friendly_url( $(this).val() ) );
        	}
        });
        $( 'a[value="remove"]' ).click(function() {
        	$(this).parent().parent().remove();
        });

        $(".popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );
    });
