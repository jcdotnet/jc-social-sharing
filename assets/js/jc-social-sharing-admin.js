jQuery(function($) {
    $( '.sortable' ).sortable({
        connectWith: '.connectable',
        helper: 'clone',
        update:  function() {
            // update social options
            $('#social-options').val($('#social-selected ul .social-list-item li span').map(function() {
                return $(this).html();
            }).get());
            // check Twitter
            $( '#social-selected #Twitter' ).length ? $( '#twitter-username' ).show() : $( "#twitter-username" ).hide();
        }
    }).disableSelection();
});