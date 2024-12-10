function next_step1(){
        var _token = $("input[name='_token']").val();
        var business_name = $("input[name='business_name']").val();
        var business_email = $("input[name='business_email']").val();
        var telephone = $("input[name='telephone']").val();
        var address = $("textarea[name='address']").val();
        var gstn = $("input[name='gstn']").val();
        var id = $("#id").val();
        document.getElementById('business_name_err').innerHTML = "";
        document.getElementById('business_email_err').innerHTML = "";
        document.getElementById('telephone_err').innerHTML = "";
        document.getElementById('address_err').innerHTML = "";
        document.getElementById('gstn_err').innerHTML = "";




          $.ajax({
              url:  '{{ url("/") }}/admin/cpo_first_tab',
              type:'POST',
              data: {_token:_token, business_name:business_name, business_email:business_email, address:address, telephone:telephone,gstn:gstn,id:id},
              success: function(data) {
                  if($.isEmptyObject(data.error)){
                   // $('.nav-tabs .nav-link.active.generaltab').addClass('disabled');
                    $('.nav-tabs .nav-link.active.generaltab').removeClass('active');
                    $('.nav-tabs .nav-link.disabled.descriptiontab_').removeClass('disabled');
                    $('.nav-tabs .nav-link.descriptiontab_').addClass('active');
                    $('.nav-tabs .nav-link.descriptiontab_').addClass('show');
                    $('.tab-content>.tab-pane.general-tab').removeClass('active');
                    $('.tab-content>.tab-pane.general-tab').removeClass('show');
                    $('.tab-content>.tab-pane.general-tab').addClass('show');
                    $('.tab-content>.tab-pane.general-tab').addClass('inactive');
                    $('.tab-content>.tab-pane.description-tab').removeClass('inactive');
                    $('.tab-content>.tab-pane.description-tab').addClass('active');
                    $('.tab-content>.tab-pane.description-tab').addClass('show');

                  }else{
                    printErrorMsg(data.error);
                  }
              }
          });
      function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
        console.log(key);
        if(key=='business_name'){
          document.getElementById('business_name_err').innerHTML = value;
        }
        if(key=='business_email'){
          document.getElementById('business_email_err').innerHTML = value;
        }
        if(key=='telephone'){
          document.getElementById('telephone_err').innerHTML = value;
        }
        if(key=='address'){
          document.getElementById('address_err').innerHTML = value;
        }
        if(key=='gstn'){
          document.getElementById('gstn_err').innerHTML = value;
        }
       
      

      });
    }

  }

  function prev_step1(){
  $('.nav-tabs .nav-link.generaltab').addClass('active');
  $('.nav-tabs .nav-link.generaltab').removeClass('disabled');
  $('.nav-tabs .nav-link.descriptiontab_').removeClass('active');
  $('.nav-tabs .nav-link.descriptiontab_').addClass('disabled');
  $('.nav-tabs .nav-link.descriptiontab_').removeClass('show');
  $('.tab-content>.tab-pane.general-tab').addClass('active');
  $('.tab-content>.tab-pane.general-tab').addClass('show');
  $('.tab-content>.tab-pane.description-tab').addClass('inactive');
  $('.tab-content>.tab-pane.description-tab').removeClass('active');
  $('.tab-content>.tab-pane.description-tab').removeClass('show');




  }

  function next_step2(){
        var _token = $("input[name='_token']").val();
        var contact_name = $("input[name='contact_name']").val();
        var contact_designation = $("input[name='contact_designation']").val();
        var contact_number = $("input[name='contact_number']").val();
        var contact_email = $("input[name='contact_email']").val();
        var id = $("#id").val();
        document.getElementById('contact_name_err').innerHTML = "";
        document.getElementById('contact_email_err').innerHTML = "";
        document.getElementById('contact_designation_err').innerHTML = "";
        document.getElementById('contact_number_err').innerHTML = "";

          $.ajax({
              url:  '{{ url("/") }}/admin/cpo_second_tab',
              type:'POST',
              data: {_token:_token, contact_name:contact_name, contact_designation:contact_designation, contact_number:contact_number, contact_email:contact_email,id:id},
              success: function(data) {
                  if($.isEmptyObject(data.error)){
                   //$('.nav-tabs .nav-link.active.descriptiontab_').addClass('disabled');
                    $('.nav-tabs .nav-link.active.descriptiontab_').removeClass('active');
                    $('.nav-tabs .nav-link.disabled.logintab_').removeClass('disabled');
                    $('.nav-tabs .nav-link.logintab_').addClass('active');
                    $('.nav-tabs .nav-link.logintab_').addClass('show');
                    $('.tab-content>.tab-pane.description-tab').removeClass('active');
                    $('.tab-content>.tab-pane.description-tab').removeClass('show');
                    $('.tab-content>.tab-pane.description-tab').addClass('show');
                    $('.tab-content>.tab-pane.description-tab').addClass('inactive');
                    $('.tab-content>.tab-pane.login-tab').removeClass('inactive');
                    $('.tab-content>.tab-pane.login-tab').addClass('active');
                    $('.tab-content>.tab-pane.login-tab').addClass('show');

                  }else{
                    printErrorMsg(data.error);
                  }
              }
          });
      function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
        console.log(key);
        if(key=='contact_name'){
          document.getElementById('contact_name_err').innerHTML = value;
        }
        if(key=='contact_email'){
          document.getElementById('contact_email_err').innerHTML = value;
        }
        if(key=='contact_designation'){
          document.getElementById('contact_designation_err').innerHTML = value;
        }
        if(key=='contact_number'){
          document.getElementById('contact_number_err').innerHTML = value;
        }
      });
    }

  }

  function prev_step4(){
   $('.nav-tabs .nav-link.descriptiontab_').addClass('active');
  $('.nav-tabs .nav-link.descriptiontab_').removeClass('disabled');
  $('.nav-tabs .nav-link.logintab_').removeClass('active');
  $('.nav-tabs .nav-link.logintab_').addClass('disabled');
  $('.nav-tabs .nav-link.logintab_').removeClass('show');
  $('.tab-content>.tab-pane.description-tab').addClass('active');
  $('.tab-content>.tab-pane.description-tab').addClass('show');
  $('.tab-content>.tab-pane.login-tab').addClass('inactive');
  $('.tab-content>.tab-pane.login-tab').removeClass('active');
  $('.tab-content>.tab-pane.login-tab').removeClass('show');


  }

  function next_step5(){
        var _token = $("input[name='_token']").val();
        var email = $("input[name='email']").val();
        var id = $("#id").val();
        document.getElementById('email_err').innerHTML = "";

          $.ajax({
              url:  '{{ url("/") }}/admin/cpo_third_tab',
              type:'POST',
              data: {_token:_token, email:email,id:id},
              success: function(data) {
                  if($.isEmptyObject(data.error)){
                   // $('.nav-tabs .nav-link.active.logintab_').addClass('disabled');
                    $('.nav-tabs .nav-link.active.logintab_').removeClass('active');
                    $('.nav-tabs .nav-link.disabled.filestab_').removeClass('disabled');
                    $('.nav-tabs .nav-link.filestab_').addClass('active');
                    $('.nav-tabs .nav-link.filestab_').addClass('show');
                    $('.tab-content>.tab-pane.login-tab').removeClass('active');
                    $('.tab-content>.tab-pane.login-tab').removeClass('show');
                    $('.tab-content>.tab-pane.login-tab').addClass('show');
                    $('.tab-content>.tab-pane.login-tab').addClass('inactive');
                    $('.tab-content>.tab-pane.files-tab').removeClass('inactive');
                    $('.tab-content>.tab-pane.files-tab').addClass('active');
                    $('.tab-content>.tab-pane.files-tab').addClass('show');

                  }else{
                    printErrorMsg(data.error);
                  }
              }
          });
      function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
        console.log(key);
        if(key=='email'){
          document.getElementById('email_err').innerHTML = value;
        }
       
      });
    }

  }

  function prev_step2(){
   $('.nav-tabs .nav-link.logintab_').addClass('active');
  $('.nav-tabs .nav-link.logintab_').removeClass('disabled');
  $('.nav-tabs .nav-link.filestab_').removeClass('active');
  $('.nav-tabs .nav-link.filestab_').addClass('disabled');
  $('.nav-tabs .nav-link.filestab_').removeClass('show');
  $('.tab-content>.tab-pane.login-tab').addClass('active');
  $('.tab-content>.tab-pane.login-tab').addClass('show');
  $('.tab-content>.tab-pane.files-tab').addClass('inactive');
  $('.tab-content>.tab-pane.files-tab').removeClass('active');
  $('.tab-content>.tab-pane.files-tab').removeClass('show');


  }
  function next_step3(){
        var _token = $("input[name='_token']").val();
        var plan_name = $("input[name='plan_name']").val();
        var start_date = $("input[name='start_date']").val();
        var stations = $("input[name='stations']").val();
        var charging_point = $("input[name='charging_point']").val();
        var connectors = $("input[name='connectors']").val();
        var sub_status = $("select[name='sub_status']").val();
        document.getElementById('plan_name_err').innerHTML = "";
        document.getElementById('start_date_err').innerHTML = "";
        document.getElementById('stations_err').innerHTML = "";
        document.getElementById('charging_point_err').innerHTML = "";
        document.getElementById('connectors_err').innerHTML = "";
        document.getElementById('sub_status_err').innerHTML = "";

          $.ajax({
              url:  '{{ url("/") }}/admin/cpo_fourth_tab',
              type:'POST',
              data: {_token:_token, plan_name:plan_name,start_date:start_date,stations:stations,charging_point:charging_point,connectors:connectors,sub_status:sub_status},
              success: function(data) {
                  if($.isEmptyObject(data.error)){
                   // $('.nav-tabs .nav-link.active.filestab_').addClass('disabled');
                    $('.nav-tabs .nav-link.active.filestab_').removeClass('active');
                    $('.nav-tabs .nav-link.disabled.pricetab_').removeClass('disabled');
                    $('.nav-tabs .nav-link.pricetab_').addClass('active');
                    $('.nav-tabs .nav-link.pricetab_').addClass('show');
                    $('.tab-content>.tab-pane.files-tab').removeClass('active');
                    $('.tab-content>.tab-pane.files-tab').removeClass('show');
                    $('.tab-content>.tab-pane.files-tab').addClass('show');
                    $('.tab-content>.tab-pane.files-tab').addClass('inactive');
                    $('.tab-content>.tab-pane.Price-tab').removeClass('inactive');
                    $('.tab-content>.tab-pane.Price-tab').addClass('active');
                    $('.tab-content>.tab-pane.Price-tab').addClass('show');

                  }else{
                    printErrorMsg(data.error);
                  }
              }
          });
      function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
        console.log(key);
        if(key=='plan_name'){
          document.getElementById('plan_name_err').innerHTML = value;
        }
        if(key=='start_date'){
          document.getElementById('start_date_err').innerHTML = value;
        }
        if(key=='stations'){
          document.getElementById('stations_err').innerHTML = value;
        }
        if(key=='charging_point'){
          document.getElementById('charging_point_err').innerHTML = value;
        }
        if(key=='connectors'){
          document.getElementById('connectors_err').innerHTML = value;
        }
        if(key=='sub_status'){
          document.getElementById('sub_status_err').innerHTML = value;
        }
       
      });
    }

  }

  function prev_step3(){
   $('.nav-tabs .nav-link.filestab_').addClass('active');
  $('.nav-tabs .nav-link.filestab_').removeClass('disabled');
  $('.nav-tabs .nav-link.pricetab_').removeClass('active');
  $('.nav-tabs .nav-link.pricetab_').addClass('disabled');
  $('.nav-tabs .nav-link.pricetab_').removeClass('show');
  $('.tab-content>.tab-pane.files-tab').addClass('active');
  $('.tab-content>.tab-pane.files-tab').addClass('show');
  $('.tab-content>.tab-pane.Price-tab').addClass('inactive');
  $('.tab-content>.tab-pane.Price-tab').removeClass('active');
  $('.tab-content>.tab-pane.Price-tab').removeClass('show');


  }

   function next_step4(){
        var _token = $("input[name='_token']").val();
        var website_link = $("input[name='website_link']").val();
        var about = $("input[name='about']").val();
       // var logo = $("#logo").val();
      
        document.getElementById('website_link_err').innerHTML = "";
        document.getElementById('about_err').innerHTML = "";
        //document.getElementById('logo_err').innerHTML = "";
     

          $.ajax({
              url:  '{{ url("/") }}/admin/cpo_fifth_tab',
              type:'POST',
              data: {_token:_token, website_link:website_link,about:about},
              success: function(data) {
                  if($.isEmptyObject(data.error)){
                   // $('.nav-tabs .nav-link.active.pricetab_').addClass('disabled');
                    $('.nav-tabs .nav-link.active.pricetab_').removeClass('active');
                    $('.nav-tabs .nav-link.disabled.contenttab_').removeClass('disabled');
                    $('.nav-tabs .nav-link.contenttab_').addClass('active');
                    $('.nav-tabs .nav-link.contenttab_').addClass('show');
                    $('.tab-content>.tab-pane.Price-tab').removeClass('active');
                    $('.tab-content>.tab-pane.Price-tab').removeClass('show');
                    $('.tab-content>.tab-pane.Price-tab').addClass('show');
                    $('.tab-content>.tab-pane.Price-tab').addClass('inactive');
                    $('.tab-content>.tab-pane.content-tab').removeClass('inactive');
                    $('.tab-content>.tab-pane.content-tab').addClass('active');
                    $('.tab-content>.tab-pane.content-tab').addClass('show');

                  }else{
                    printErrorMsg(data.error);
                  }
              }
          });
      function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
        console.log(key);
        if(key=='website_link'){
          document.getElementById('website_link_err').innerHTML = value;
        }
        if(key=='about'){
          document.getElementById('about_err').innerHTML = value;
        }
        // if(key=='logo'){
        //   document.getElementById('logo_err').innerHTML = value;
        // }
       
       
      });
    }

  }

  function prev_step4(){
   $('.nav-tabs .nav-link.descriptiontab_').addClass('active');
  $('.nav-tabs .nav-link.descriptiontab_').removeClass('disabled');
  $('.nav-tabs .nav-link.logintab_').removeClass('active');
  $('.nav-tabs .nav-link.logintab_').addClass('disabled');
  $('.nav-tabs .nav-link.logintab_').removeClass('show');
  $('.tab-content>.tab-pane.description-tab').addClass('active');
  $('.tab-content>.tab-pane.description-tab').addClass('show');
  $('.tab-content>.tab-pane.login-tab').addClass('inactive');
  $('.tab-content>.tab-pane.login-tab').removeClass('active');
  $('.tab-content>.tab-pane.login-tab').removeClass('show');


  }

    function prev_step5(){
   $('.nav-tabs .nav-link.pricetab_').addClass('active');
  $('.nav-tabs .nav-link.pricetab_').removeClass('disabled');
  $('.nav-tabs .nav-link.contenttab_').removeClass('active');
  $('.nav-tabs .nav-link.contenttab_').addClass('disabled');
  $('.nav-tabs .nav-link.contenttab_').removeClass('show');
  $('.tab-content>.tab-pane.Price-tab').addClass('active');
  $('.tab-content>.tab-pane.Price-tab').addClass('show');
  $('.tab-content>.tab-pane.content-tab').addClass('inactive');
  $('.tab-content>.tab-pane.content-tab').removeClass('active');
  $('.tab-content>.tab-pane.content-tab').removeClass('show');


  }