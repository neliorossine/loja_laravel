window.onload = function() {
    $(".currency").mask('#.##0,00', {reverse: true});
    trataItens();
}
$(document.body).on('click','select', function(){
    trataItens();
});
$(document.body).on('blur','input', function(){
    trataItens();
});


//Função remover item
function btnRemoveItem(tr){
var rows = $("table tbody tr").length;
var length = $("table thead th").length;

if(rows > 1){

    tr.remove();

    for(var i=1; i < length+1; i++){
        $('tr:nth-child('+i+')').each(function() {
            $(this).find("select[data-tipo='produto']").attr('name', 'venda['+(i-1)+'][produto]');
            $(this).find("input[data-tipo='valor']").attr('name', 'venda['+(i-1)+'][valor]');
            $(this).find("input[data-tipo='qtde']").attr('name', 'venda['+(i-1)+'][qtde]');
            $(this).find("input[data-tipo='remove']").attr('name', 'venda['+(i-1)+'][remove]');
        });        
    }
} else {
    alert('Não é possível remover último registro.')
}

 trataItens();
}

$('#btnNewItem').click(function(){
    var row = $('table tbody > tr:last'),
        newRow = row.clone(),
        length = $("table tbody tr").length;

    newRow.find('td').each(function(){
        var td = $(this),
                input = td.find('input,select'),
                name = input.attr('name');
        input.attr('name', name.replace((length - 1) + "", length + ""));
    });

    newRow.find('[name="venda['+length+'][valor]"]').val(null);
    newRow.find('[name="venda['+length+'][produto]"]').val(0);
    newRow.find('[name="venda['+length+'][qtde]"]').val(1);
    newRow.insertAfter(row);
    trataItens();
});


function trataItens(){
    var produto = [];
    var total = 0,
        trLen = $('table tbody tr').length,
        tr = null, price, qtd;produto = [];

    for(var i=0; i < trLen; i++){
        tr = $('table tbody tr').eq(i);
        price = tr.find(':selected').data('price');
        qtd = tr.find('[name="venda['+i+'][qtde]"]').val();

        if(price){
            //calcular valor total
            total += price * qtd;
            //valor unitario
            $('[name="venda['+i+'][valor]"]').val(currencyFormat(price));
        }

        //seleciona produtos ja selecionados
        $('select option').attr("hidden", false);
        produto.push(tr.find('[name="venda['+i+'][produto]"]').find(":selected").val());  
    }

    //desativa produtos ja selecionados
    $(':input[type="submit"]').prop('disabled', false);
    for(var i=0; i<produto.length; i++) {
        $('select option[value="'+produto[i]+'"]').attr("hidden", true);
        if(produto[i] == '0'){
            $(':input[type="submit"]').prop('disabled', true);
        }
    }

    //valor total
    $('#total').html(currencyFormat(total));
    $('[name="total"]').val(total.toFixed(2));
}

function currencyFormat(num) {
  return num.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
}
