$( ".ami-a" ).click(function() {
    id= $(this).data("id")
    non_ami=$('#non-ami-'+id)
    ami=$('#ami-'+id)
   
    $.ajax({
        url: "http://127.0.0.1:8000/utilisateur/ami/"+id,
        context: document.body
      }).done(function() {
        
        if($(ami).is(':visible')){
            $(non_ami).show()
            $(ami).hide()
        }
        else{
            $(non_ami).hide()
            $(ami).show()
        }
    });
    
});