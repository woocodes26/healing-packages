(function($){
    'use strict';

    $(document).ready(function(){
        // Simple accordion example (if you later add accordion classes)
        $('.healing-package-card .healing-package-toggle').on('click', function(e){
            e.preventDefault();
            $(this).closest('.healing-package-card').toggleClass('is-open');
        });
    });

})(jQuery);
