$(document).ready(function()
{
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
        output = list.data('output');
        if (window.JSON) {
            $('#nestable2').nestable({maxDepth : $("#deep").val() });
            $('#nestable2').nestable('serialize');
        output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $("#guardar-menu").click(function() {
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
    });


});