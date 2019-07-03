//JS Document
$(function(){//status change
    $('a.statusLink').on('click',function(){

      var id = $(this).parents('ul').data('id');
      var $confirmMessage = 'この作品を非公開にしますか?'; 
      
      if($(this).hasClass('private')){
        $confirmMessage = 'この作品を公開しますか?'
      }
  
      if(confirm($confirmMessage)){
        //ajax
        $.post('admin.php', {
          id: id,
          mode: 'change-status'
        },function(response){
          console.log(response);
          if(response.status === 'public'){
            //$thisを使うと responseが対象となる
            $('ul[data-id=' + id + ']').find('li.status, li.status-link a').removeClass('private');
            $('ul[data-id=' + id + ']').find('li.status, li.status-link a').addClass('public');
          }
          if(response.status === 'private') {
            $('ul[data-id=' + id + ']').find('li.status, li.status-link a').removeClass('public');
            $('ul[data-id=' + id + ']').find('li.status, li.status-link a').addClass('private');     
          }
        });
      }
      return false;
    });
    
    //delete
    $('a.deleteLink').on('click',function(){

        var id = $(this).parents('div.item').data('id');
        console.log(id);
        if(confirm('この作品を削除しますか？')){
          //ajax
          $.post('delete.php',{
            id: id
          },function(){
              console.log(id + ' delete requested!')
              $('div.item[data-id=' + id + ']').css('display','none');
              //$('div.item[data-id=' + id + ']').fadeOut();
          });
        }
        
        return false;
        
    });
});