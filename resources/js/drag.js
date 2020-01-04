$(function(){
  
  $(document).on("dragover drop", function(e){
    e.preventDefault();    
  });

  $("[name='upfile']").on('change', function (e) {
    
    var reader = new FileReader();

    reader.onload = function (e) {
        $("#preview").attr('src', e.target.result);
    }    
    
    reader.readAsDataURL(e.target.files[0]);
    
    $("p.preview-comment").removeClass('preview-comment');
    
    if(window.innerWidth < 415){
        $('#preview').css({"height" : "165px"});
    }

  });
  
  $("#preview").on("drop", function(e){   
      document.querySelector("[name='upfile']").files = 
      e.originalEvent.dataTransfer.files;
      
      e.preventDefault();
      
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#preview").attr('src', e.target.result);        
      }

      reader.readAsDataURL(e.originalEvent.dataTransfer.files[0]);

      $("p.preview-comment").removeClass('preview-comment');
  });
  
  $("#preview").on("dragover", function(e){
    $("#preview").css('background-color','#87ceeb');
  });
  
  $("#preview").on("dragleave", function(e){    
    $("#preview").css('background-color','darkgray');
  });

});
