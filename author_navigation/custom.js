jQuery(document).ready(function($){ 
    jQuery('.alphabet').on('click', function(e){
        e.preventDefault();
        var alphabet = jQuery(this).data('char');
        var myclass = '.author_'+alphabet;
        //var select_author = $(myclass).html();
       
        $.ajax({ 
            url: my_object.ajax_url,
            type:"POST",
            dataType:'json',
            cache: false,
            data: {
                action:'get_char',
                char : alphabet,
            },   
            success: function(response) { 
                //jQuery('.author_data').hide();
                
                 $('html,body').animate({
                    scrollTop: $(myclass).offset().top},
                    'slow');
    
    
    
    
            }, 
            error: function(data) {
            }
        });  
    
    });
});