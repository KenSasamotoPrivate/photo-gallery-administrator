//JS Document
$(function(){
    $('a.deleteLink').on('click',function(){
        var id = $(this).parents('div.item').data('id');
        console.log(id);
        if(confirm('この作品を削除しますか？')){
          //ajax
          $.post('admin.php',{
            id: id,
            mode: 'delete'
          },function(){
              console.log(id + ' delete requested!')
              $('div.item[data-id=' + id + ']').css('display','none');
              //$('div.item[data-id=' + id + ']').fadeOut();
          });
        }
        
        return false;
        
    });
});