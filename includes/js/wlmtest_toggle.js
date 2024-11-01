jQuery(document).ready(function($){

    $('.wlmtest_toogle').hide();

    $('.wlmtest_toogle_trigger').on('click',function(){

        $(this).next(this).toggle();

    });
});

