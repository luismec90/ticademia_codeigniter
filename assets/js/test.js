$(function() {
    
    $("#modal-step-1").modal({
            keyboard: false,
              backdrop: "static"
    });
    var velocidad = 100;
    var count = 0;
    function loop() {
        $('#slideshow').stop().animate({scrollLeft: 100}, velocidad, 'linear', function() {
            $(this).scrollLeft(0).find('div:last').after($('div:first', this));
           if (count > 30)
                velocidad += 15;
            else
                count++;
            if (velocidad < 400)
             loop();
        });
    }
    loop();
});