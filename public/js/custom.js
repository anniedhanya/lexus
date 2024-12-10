    /***************** select2 tooltip remove ******************/
    $(document).on('mouseenter', '.select2-selection__rendered', function () { $(this).removeAttr('title');  });

    $(document).ready(function () {
    /***************** Navbar-Collapse ******************/

   

    /***************** Scroll Spy ******************/

    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    })

    /***************** Owl Carousel ******************/

  


    /***************** Full Width Slide ******************/

    var slideHeight = $(window).height();

    $('#owl-hero .item').css('height', slideHeight);

    $(window).resize(function () {
        $('#owl-hero .item').css('height', slideHeight);
    });
   
    

    /***************** Wow.js ******************/
    
    
    /***************** Preloader ******************/

})


function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}
(function($){

    // Get url parameter
    $.urlParam = function(name, url) {
        if (!url) {
         url = window.location.href;
        }
        var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(url);
        if (!results) { 
            return undefined;
        }
        return results[1] || undefined;
    }

	// Catch all ajax response and redirect if not authenticated.
	$.ajaxSetup({
	    statusCode: {
            401: function(msg){
                alert("Your session has been expired, please login.");
                window.location = window.base_url;
            },
	        403: function(msg){
	            alert("Your dont have permission to do this.");
	        }
	    }
	});

    // Attach selectize plugin
    if($().selectize) {
        $(".selectize").selectize();
        $(".selectize_c").selectize({
            create: true
        });
    }

    /* Find Active menu */
    var url = window.location.pathname + window.location.search;
    
    var anc = $('.sidebar-menu li:not(.header) a[href$="' + url + '"]');
    var sep = '/';
    while(anc.length != 1 && url) {
        if(url.indexOf('&') > -1) {
          sep = '&';
        } else if(url.indexOf('?') > -1) {
          sep = '?';
        } else {
          sep = '/';            
        }
        url = url.substring(0, url.lastIndexOf(sep));
        anc = $('.sidebar-menu a[href$="' + url + '"]');
    }
    if(anc.length == 1) {
        anc.closest('li').addClass('active'); 
        anc.parents('li.treeview').addClass('active');  
        anc.parents('ul.treeview-menu').css('display', 'block');
    }

    if(typeof $.fn.dataTableExt != 'undefined')
        $.fn.dataTableExt.sErrMode = 'function';

    // Open COnfirmation Modal
    function openConfirmModal($_form, callback) {
        if(typeof BootstrapDialog != 'undefined')   
            BootstrapDialog.confirm({
                title: 'WARNING',
                message: $_form.attr("data-confirm"),
                type: BootstrapDialog.TYPE_WARNING,
                btnOKLabel: 'Proceed',
                callback: function(result){
                    if(result) {
                        $_form.removeAttr( "data-confirm" );
                        callback($_form);
                    }else {
                        return false;
                    }
                }
            }); 
    }

    // Confirm deleting resources
    $(document).on('submit', 'form[data-confirm]',function(e){ 
        e.preventDefault();
        openConfirmModal($(this), function($form){
            $form.trigger('submit');
        });
          
    });

    // Trigger ajax modals
    function openAjaxModal(targetUrl, params, stacked) {
        var _method = 'GET';
        if(params)
            _method = 'POST';
        else
            params = {};

        if(typeof stacked != 'boolean')
            stacked = false;
        // $('#modal-loading').modal();
        var bd_id = $.urlParam('modal_id', targetUrl);
        if(!bd_id)
            bd_id = BootstrapDialog.newGuid();
        var bd = BootstrapDialog.getDialog(bd_id);
        if(!bd)
            bd = BootstrapDialog.show({
                    id: bd_id,
                    nl2br: false
                }); 
        bd.setMessage('<h2 class="text-muted">Loading...</h2>');
        
        targetUrl = updateQueryStringParameter(targetUrl, 'modal_id', bd_id);
        if(typeof BootstrapDialog != 'undefined') {
            $.ajax({
              method: _method,
              url: targetUrl,
              data: params
            }).done(function( res ) {
                // $('#modal-loading').modal('hide');
                bd.setMessage(res);
                /*BootstrapDialog.show({
                    id: bd_id,
                    message: res,
                    nl2br: false,
                    draggable: true,
                    title: res.title,
                    type: BootstrapDialog.TYPE_INFO,
                    buttons: res.buttons
                }); */
            });
        }
    }
    $(document).on('click', '.open-ajax-modal', function(e) {
        e.preventDefault();
        if($(this).attr('data-url'))
            var targetUrl = $(this).data('url'); 
        else
            var targetUrl = $(this).attr('href'); 
        var params = '';
        var stacked = false;
        if($(this).hasClass('method-post')){
            params = $.extend({}, getUrlVars(targetUrl));
            targetUrl = targetUrl.split("?")[0];
        }
        var form = null;
        if($(this).hasClass('modal-submit')){
            if($(this).attr('data-form'))
                form = $($(this).data('form'));
            else
                form = $(this).closest('form');
            targetUrl = form.attr("action");
            params = $(form).serializeArray();
        }
        if($(this).hasClass('stacked'))
            stacked = true;
        if(form && form.data('confirm')) {
            openConfirmModal(form, function($form){
                openAjaxModal(targetUrl, params, stacked);
            });
        } else
            openAjaxModal(targetUrl, params, stacked);
    });

    $(document).on('click', 'a.open-image-modal', function(e){
      e.preventDefault();
      var _title = "Preview";//$(this).attr('title');
      var img_url = $(this).attr('href');
      BootstrapDialog.show({
          title: _title,
          message: '<p class="text-right"></p><img src="' + img_url + '" class="img-responsive super-fix" />',
          size: BootstrapDialog.SIZE_WIDE
      });
    });
    


})(jQuery);