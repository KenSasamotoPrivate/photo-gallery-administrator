//JS Document
$(function(){
    $('a.deleteLink').on('click',function(){
        var id = $(this).parents('div.item').data('id');
        console.log(id);
        if(confirm('この作品を削除しますか？')){
          // Ajax
          $.post('DeleteController.php',{
            id: id,
          },function(){
              console.log(id + ' delete requested!')
              $('div.item[data-id=' + id + ']').css('display','none');              
          });
        }
        
        return false;
        
    });
});