$(function() {
    $('.estrellas').raty({
        path: base_url+'assets/libs/raty/lib/img',
        half: true,
        readOnly: true,
        score: function() {
            return $(this).attr('data-score');
        }       
    });
});