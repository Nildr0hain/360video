$( document ).ready(function() {

    var addressProperty = $("#street").html() + " " + $("#city").html() + " " + $("#country").html() ;
    console.log("TEST" + addressProperty);
    
    
    $("#map-canvas").gmap3({
        map: {
           options: {
                scrollwheel: false,           
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: false,
                maxZoom: 13
           }  
        },
        marker:{
           address: addressProperty,           
           options: {
            icon: new google.maps.MarkerImage(
              "http://www.serenitysands.com/imgs/gmap/icons/people/apartment.png",
              new google.maps.Size(45, 45, "px", "px")
            ),
           animation: google.maps.Animation.DROP
           }
        }
       },
       "autofit" );
       
    (function($) {
        $.fn.textfill = function(options) {
            var fontSize = options.maxFontPixels;
            var ourText = $('span:visible:first', this);
            var maxHeight = $(this).height();
            var maxWidth = $(this).width();
            var textHeight;
            var textWidth;
            do {
                ourText.css('font-size', fontSize);
                textHeight = ourText.height();
                textWidth = ourText.width();
                fontSize = fontSize - 1;
            } while ((textHeight > maxHeight || textWidth > maxWidth) && fontSize > 3);
            return this;
        }
    })(jQuery);

            //**************** DELETE
            $('#delete_popup').modal({
                backdrop: true,
                keyboard: true,
                show: false
            }).css({
                width: 'auto',
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            })
            var currentId;
            $('.confirm-delete').click( function(){
                currentId = $(this).attr("id");
                //console.log($(this).attr("id"));
                $('#delete_popup').modal('show');
            })
            $('.modal .btn-warning').click( function(){        
                //console.log($(this).attr("href"));
                window.location = $(this).attr("href") + currentId;
                $('#delete_popup').modal('hide');        
            })
            $('.modal a').click( function(){
                $('#delete_popup').modal('hide');
            })
            
            
            
             
    
        $('.Slogan p').textfill({ maxFontPixels: 36 });
              
              
              
              
              

        $('#myCarousel').carousel({
                interval: 5000
        });
 
        $('#carousel-text').html($('#slide-content-0').html());
 
        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click( function(){
                var id_selector = $(this).attr("id");
                var id = id_selector.substr(id_selector.length -1);
                var id = parseInt(id);
                $('#myCarousel').carousel(id);
        });
 
 
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid', function (e) {
                var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
        });
 
 
});
    