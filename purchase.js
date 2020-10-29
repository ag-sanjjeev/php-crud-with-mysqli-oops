/*
    file name purchase js
    programmer: sanjjeev
    created: 4/9/2019
*/

function purchase_su(id,action)
{
    var format = $('form').serialize()+'&id='+id+'&action='+action;
    
    if(action=='edit_sub')
    {
        $.ajax({
            type: 'POST',
            data: format,
            url: 'crud.php',
            success: function(data){
                var obj = JSON.parse(data);
                if(obj.error=='')
                {
                    $('#item_name').val(obj.item);
                    $('#quantity').val(obj.quantity);
                    $('#rate').val(obj.rate);
                    $('#tax').val(obj.tax);
                    $('#discount').val(obj.discount);
                    $('#sub_total').val(obj.total);
                    $('#addbtn').attr('onclick','purchase_su('+obj.id+',\'update_sub\')');
                    $('#addbtn').text('Update');
                }
                else
                {
                    alert(obj.error);
                }
            }
        });
    }
    else
    {
        $.ajax({
            type: 'POST',
            data: format,
            url: 'crud.php',
            success: function(data){
                var obj = JSON.parse(data);
                if(obj.error=='')
                {
                    alert(obj.status);
                    $('#item_name').val('');
                    $('#quantity').val(0);
                    $('#rate').val(0);
                    $('#tax').val('');
                    $('#discount').val(0);
                    $('#sub_total').val(0);
                    $('#total').val(obj.sub_total);
                    $('#addbtn').attr('onclick','purchase_su(\'\',\'add_sub\')');
                    $('#addbtn').text('Add');
                    $('#entrylist').html(obj.data);
                }
                else
                {
                    alert(obj.error);
                }
            }
        });
    }
}

function purchase_cu(id,action)
{    
    
    var format = $('form').serialize()+'&id='+id+'&action='+action;         
    $.ajax({
    type: 'POST',
    data: format,
    url: 'crud.php',
    success: function(data){
        var obj = JSON.parse(data);
        if(obj.error=='')
        {
            alert(obj.status);
            window.location.href='index.php';
        }
        else
        {
            alert(obj.error);
        }
    }
   });

}


$('document').ready(function(event){   
    $('#rate,#discount,#quantity').on('keyup change',function(){
        var quantity = $('#quantity').val();
        var tax = $('#tax').val();
        var rate = $('#rate').val();
        var discount = $('#discount').val();
        var total = 0;
        
        if(tax=='')
        {
            total = (rate-((rate*discount)/100))*quantity;    
        }
        else
        {
            tax1 = (rate*(tax/100));            
            total = tax1+(rate-((rate*discount)/100))*quantity;
        }
        
        
        $('#sub_total').val(total);
    });
});