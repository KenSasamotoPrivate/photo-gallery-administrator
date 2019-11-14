//JS Document
$(function(){
    $('a.statusLink').on('click',function(){

      var id = $(this).parents('ul').data('id');
      var $confirmMessage = 'この作品を非公開にしますか?'; 
      
      if($(this).hasClass('private')){
        $confirmMessage = 'この作品を公開しますか?'
      }
  
      if(confirm($confirmMessage)){
        // Ajax
        $.post('PublishingController.php', {
          id: id,
        },function(response){

          if(response.status === 'public'){
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
});