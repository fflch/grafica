jQuery(function ($) {
    $('#responsavel_centro_despesa').change(function(){
        var data = { codpes: $( "#responsavel_centro_despesa" ).val() };
        function success(response) {
            $( "#info" ).html(response).css('color', 'red');;
        }
        $.get('info', data, success);
    });

    //JqueryUI:Datepicker
    $('.datepicker, .datePicker').datepicker({
        dateFormat: 'dd/mm/yy'
        , dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']
        , dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D']
        , dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom']
        , monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
        , monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
        , nextText: 'Próximo'
        , prevText: 'Anterior'
    });
    
    $(".numeros").mask('00000000');

    $("#numero_nome").click(function() {
        if ($("#numero_nome").prop("checked")) {
            $("#busca_data").hide();
            $("#busca").show();
        }
    });
    
    $("#data").click(function() {
        if($("#data").prop("checked")) {
            $("#busca").hide();
            $("#busca_data").show();
        }
    });

    $('#scroll').stop().animate({
        scrollTop: $('#scroll')[0].scrollHeight
    }, 800);
    
});

function MascaraMoeda(i) {
	var v = i.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	i.value = v;
}

