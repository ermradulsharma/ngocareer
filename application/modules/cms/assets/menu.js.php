<script>
$(document).ready(function(){
    var updateOutput = function(e){
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); 
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    
    $('#nestable').nestable({
        group: 1
    }).on('change', updateOutput);
    
    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));              
});

$(document).on('click', '#save_menu_order', function(){    
    var id = parseInt( $('#menu_id').val()) || 0;
    var json = $('#nestable-output').val();
    
    $.ajax({
        url: 'admin/cms/menu/save_order',
        type: 'POST',
        dataType: "json",
        data: { json: json, id: id  },
        beforeSend: function(){
            $('#respond_save_order' ).html('Updating...').css('display','block');
        },
        success: function ( jsonRespond ) {
            $('#respond_save_order').html(jsonRespond.Msg);
            setTimeout(function(){ $('#respond_save_order').slideUp('slow'); }, 1500);
        }
    });
});

$(document).on('click', '.remove_menu_item', function(){    
    var id = parseInt( $(this).data('id') ) || 0;
    var li = $(this).parent().parent();
    var yes = confirm('Confirm Remove');
    if(yes){
        $.ajax({
            url: 'admin/cms/menu/item_remove',
            type: 'POST',
            dataType: "json",
            data: { id: id  },        
            success: function ( jsonRespond ) {
                if( jsonRespond.Status === 'OK'){
                    li.remove();
                }            
            }
        });
    }
});

$(document).on('click', '.item_edit', function(){    
    var id = parseInt( $(this).data('id') ) || 0;    
    $('.js_update_respond').empty();
    $('#edit_menu').modal({show: 'false'});
   
    $.ajax({
        url: 'admin/cms/menu/item_edit',
        type: 'POST',
        dataType: "text",
        data: { id: id  },        
        success: function ( jsonRespond ) {
            $('.edit_box').html( jsonRespond );
        }
    });    
});

$(document).on('click', '#saveMenuTitle', function(){    
    
    var FormData    = $('#menu_edit').serialize();   
    var rel_id      = $('#rel_id').val();
    var title       = $('#title').val();
        
    $.ajax({
        url: 'admin/cms/menu/item_edit_action',
        type: 'POST',
        dataType: "json",
        data: FormData,
        beforeSend: function () {
            $('.js_update_respond').html( 'Saving...' );
        },
        success: function ( jsonRespond ) {
            $('.js_update_respond').html( jsonRespond.Msg );
            $('#'+rel_id).text( title );
            setTimeout(function(){ $('#edit_menu').modal('hide'); }, 1500);            
        }
    });    
});

$("#change_menu_item").change(function(){
    document.location.href = $(this).val();
});

function DeleteMenuItem(pageid) {
    $.ajax({
        url: '<?php echo base_url('admin/cms/menu/deletePageFromMenu'); ?>',
        type: 'POST',
        dataType: 'text',
        data: {pageid: pageid},
        beforeSend: function () {
            $('#arrayorder_' + pageid).css('background-color','red');
        },
        success: function () {
            $('#arrayorder_' + pageid).fadeOut();
        }
    });
}

$("#checkAll").change(function () {
    $("input.page:checkbox").prop('checked', $(this).prop("checked"));
});


$("#catCheckAll").change(function () {
    $("input.cat:checkbox").prop('checked', $(this).prop("checked"));
});

    
function updateMenuForm(id,obj_id){	    
    $.ajax({
        url: '<?php echo base_url('admin/cms/menu/item_update_form'); ?>',
        type: 'POST',
        dataType: 'text',			
        data: {id: id, obj_id: obj_id},
        beforeSend: function(){
            $('#menu_'+id).html( 'Loading...' );
        },
        success: function(msg){	
            
            $('#menu_'+id).html( msg );
        }
    });
}

function updateMenuName(id,obj_id){
    var menu_name = $('#'+id).val();
    $.ajax({
        type: 'post',
        url: '<?php echo base_url('admin/cms/menu/item_update_action'); ?>',
        data: { id:id, post_id:obj_id, menu_name:menu_name },
        beforeSend: function () { 
            $('#menu_'+id).html( 'Processing...' );
        },
        success: function(data){ 
            $('#menu_'+id).html(data);	
        }
    });
}

function DeleteMenu(menu_id){
    var yes = confirm('Realy Want to delete?');
    if(yes){
        $.ajax({
            type: 'post',
            url: '<?php echo site_url( Backend_URL . 'cms/menu/delete_menu'); ?>',
            dataType: 'json',
            data: {menu_id: menu_id},
            beforeSend: function () {
                $('#ajax_respond').css('display', 'block').html('<p class="success"> Processing...</p>');
            },
            success: function (jsonRespond) {
                if(jsonRespond.Status === 'OK'){
                    $('#ajax_respond').html(jsonRespond.Msg);
                    setTimeout(function () {
                        window.location.replace('<?php echo site_url( Backend_URL . 'cms/menu'); ?>');
                    }, 1500);
                }else{
                    $('#ajax_respond').html(jsonRespond.Msg);
                }
            }
        });
    }
}

</script>