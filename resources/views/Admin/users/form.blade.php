
@extends('_layouts.default')

@section('head-assets')
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
/*side menu style*/
body {
    color: #000;
}
.left_col {
    background-image: linear-gradient(#f30c0b, #ff8f00);
}
.nav_title {
    background: #ffffff40;
}
.nav.side-menu>li.current-page, .nav.side-menu>li.active {
    border-right: 5px solid #2c0505;
}
.nav.side-menu>li.active>a {
    background: #ffffff47;
}
.text-green {
    color: green
}
.main_container .right_col h3 {
    color: #000;
    font-size: 22px
}
.notifi-tab
{ right: 0; top: 13px;}
label.error {
    color: #e03b3b;
}
</style>
    @parent


@endsection
@section('content-area')

<div class="">
  <!------>
    <div class="x_panel p-4">
    <div class="x_title">
        @if($obj->id)
        <h3>Edit User</h3>
        @else
        <h3>New User</h3>
        @endif
                

    </div>
    <div class="x_content">
    @if($obj->id)
    @section('meta_title')
    {{  "Edit User" }}
    @stop
    {!! Form::model($obj, array('method' => 'put', 'url' => route($route.'.update', $obj->id), 'files' => true, 'role' => 'form','id'=>'edit_activity')) !!}
    @else
    @section('meta_title')
    {{  "New User" }}
    @stop
    {!! Form::open(array('url' => route($route.'.store'), 'files' => true, 'role' => 'form', 'id' =>'add_activity')) !!} 
    @endif
                    
               
<div class="row label-display-block">
<div class="col-md-12 text-right mb-3">
@if($obj->warranty_period!="" && $obj->warranty_status!="")
  <button id="export_pdf" type="button" class="btn btn-danger " Title="The PDF export can accommodate a maximum number of 1000 records,CSV is recommended for bulk exports.">Download Warranty Certificate</button>
@endif
</div>

@if($obj->id)

<div class="col-lg-12 mt-1 highlight">
<div class="">
<div class="row">
<div class="col-lg-12">
<div class="row">
              <input type="hidden" name="warranty_user_id" id="warranty_user_id" value="{{$obj->id}}">
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Name <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="name" name="name" value="{{$obj->name}}"  oninput="validateInput(event)"  maxlength="150">
                <span  class="text-danger error" style="color:#e03b3b" id="name_error">{{ $errors->first('name') }}</span>               
              </div>

              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Email </label>
                <input type="text"  class="form-control" id="email" name="email" value="{{$obj->email}}"  onblur="validateEmail()"  maxlength="100">
                <span  class="text-danger error" style="color:#e03b3b" id="email_error">{{ $errors->first('email') }}</span>               
              </div>

              <div class="col-md-6 col-lg-4 mb-3 country_code">
                <label class="form-label">Mobile Number <span class="madatory">*</span></label>
                <!-- <input type="text"  class="form-control" id="contact_no" name="contact_no" value="{{$obj->contact_no}}" maxlength="15"> -->
                <div class="form-group d-inline-block form-control">
                    <span class="border-end country-code px-2">+91</span>
                    <input type="text" name="contact_no" class="form-control" id="ec-mobile-number" value="{{$obj->mobile_number}}" oninput="validateContactInput(event)" maxlength="10" placeholder="" />
                </div>
               <span  class="text-danger error" style="color:#e03b3b" id="contact_no_error">{{ $errors->first('contact_no') }}</span>               
              </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">User type <span class="madatory">*</span></label>                
             {{ Form::select('type', [
                      ''=>'Select',
                      '1' => 'Executive',
                      '2' => 'User'
                      ],old('type'),['class' => ' form-control','id'=>'type']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="user_type_error">{{ $errors->first('type') }}</span>               
              </div>
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Status <span class="madatory">*</span></label>                
             {{ Form::select('status', [
                      ''=>'Select',
                      '1' => 'Active',
                      '0' => 'Inactive'
                      ],old($obj->type),['class' => ' form-control','id'=>'status']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('status') }}</span>               
              </div>
            </div>


</div>
</div>  
</div>  
</div>


@else

<div class="col-lg-12 mt-1">
  <div class="card position-relative new-con-label">
    <div class="row  p-2">
      <div class="col-lg-12 form_page">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-3">
            <label class="form-label">Name <span class="madatory">*</span></label>
            <input type="text"  class="form-control" id="name" name="name" oninput="validateInput(event)"  maxlength="150">
            <span  class="text-danger error" style="color:#e03b3b" id="name_error">{{ $errors->first('name') }}</span>               
          </div>

          <div class="col-md-6 col-lg-4 mb-3">
            <label class="form-label">Email </label>
            <input type="text"  class="form-control" id="email" name="email" onblur="validateEmail()"  maxlength="100">
            <span  class="text-danger error" style="color:#e03b3b" id="email_error">{{ $errors->first('email') }}</span>               
          </div>

          <div class="col-md-6 col-lg-4 mb-3 country_code">
            <label class="form-label">Mobile Number<span class="madatory">*</span></label>
            <div class="form-group d-inline-block form-control">
                    <span class="border-end country-code px-2">+91</span>
                    <input type="text" name="contact_no" class="form-control" id="ec-mobile-number" value="" oninput="validateContactInput(event)" maxlength="10" placeholder="" />
            </div>
            <span  class="text-danger error" style="color:#e03b3b" id="contact_no_error">{{ $errors->first('contact_no') }}</span>               
          </div>
          <div class="col-md-6 col-lg-4 mb-3 password_field">
            <label class="form-label">Password <span class="form-label" data-toggle="tooltip" data-placement="top" title="The password must be at least 8 letters. Password must contain at least one UPPERCASE letter, one lowercase letter, one numeric character and one special character (!@#$%^&*())"><i class="fas fa-info-circle"></i></span></label>
            <input type="text"  class="form-control" id="password" name="password" onblur="validateEmail()"  maxlength="12">
            <span  class="text-danger error" style="color:#e03b3b" id="password_error">{{ $errors->first('password') }}</span>               
          </div>
          <div class="col-md-6 col-lg-4 mb-3 confirm_password_field">
            <label class="form-label">Confirm Password </label>
            <input type="text"  class="form-control" id="password_confirmation" name="password_confirmation" onblur="validateEmail()"  maxlength="12">
            <span  class="text-danger error" style="color:#e03b3b" id="password_confirmation_error">{{ $errors->first('password_confirmation') }}</span>               
          </div>
          <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Status <span class="madatory">*</span></label>                
             {{ Form::select('status', [
                      ''=>'Select',
                      '1' => 'Active',
                      '0' => 'Inactive'
                      ],null,['class' => 'form-control','id'=>'status']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('status') }}</span>               
        </div>
          <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">User type <span class="madatory">*</span></label>                
             {{ Form::select('user_type', [
                      ''=>'Select',
                      '1' => 'Executive',
                      '2' => 'User'
                      ],null,['class' => 'form-control','id'=>'type']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="user_type_error">{{ $errors->first('user_type') }}</span>               
        </div>
          
        </div>
      </div>
    </div>  
  </div>  
</div>
@endif
<div class="scroll-sec w-100" id="add_connector_sec" >  </div>    
</div>     

       <div class="row">
            <div class="col-lg-12 text-right">
            <a href="{{ url('/admin/users/')}}" class="btn  mt-2 btn-secondary">Cancel</a>
                    <button type="submit" name="button" class="btn btn-primary mt-2 mr-1">Submit</button>
            </div>
        </div>
            {!! Form::close() !!}  
        </div>
    </div>
</div>

    
@endsection
@section('footer-assets')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> 
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/boot4alert.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {

  var baseurl = $('#baseurl').val();
  $('#date_of_purchase').datepicker({ dateFormat: "dd MM yy"});
  $('#warranty_period').datepicker({
    minDate: 0,
      onSelect: function(dateText, inst){
          $('#warranty_period').datepicker('option', 'minDate', new Date(dateText));
      },
       dateFormat: "dd MM yy"
  });


   var docScreenshotFile = @json($doc_screenshot_file ?? null);
   var invoiceLink = @json($invoice_link ?? null);
  if (docScreenshotFile) {
    $("#imageIcon").attr("href", docScreenshotFile).show();
  }


  $("#imageIcon").click(function(e) {
    e.preventDefault();
    $("#modalImage").attr("src", $(this).attr("href"));
    $("#imageModal").modal('show');
  });



 if (invoiceLink) {
    $("#imageIcon_").attr("href", invoiceLink).show();
  }


  $("#imageIcon_").click(function(e) {
    e.preventDefault();
    $("#modalImage_").attr("src", $(this).attr("href"));
    $("#imageModal_").modal('show');
  });



       $("#export_pdf").click(function(){
       var warranty_user_id =$("#warranty_user_id").val();
       window.location.href =  '{{url('/')}}/admin/extended_warranty_pdf?warranty_user_id='+warranty_user_id;
        });
      
  });


function extended_warranty_delete(id){
    boot4.confirm({
     msg:"Are you sure to delete selected ?  Associated data will be removed.",
     title:"WARNING",
     callback:function(result) {
      if(result){
        window.location.href ='{{url('/')}}/admin/extended_warranty_delete?id='+id;
      }
      else{
      return false;
    }
  }

});     
  }


  function validateInput(event) {
            const input = event.target;
            const value = input.value;
            const regex = /^[a-zA-Z\s]*$/;

            if (!regex.test(value)) {
                input.value = value.replace(/[^a-zA-Z\s]/g, '');
                document.getElementById('name_error').innerText = 'Only alphabetic characters and spaces are allowed.';
            } else {
                document.getElementById('name_error').innerText = '';
            }
        }
        $(document).on('keydown', '.number_value', function (e) {
    // Allow: backspace, delete, tab, escape, enter
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
    }

    // Check if the character is a special character or a dot
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) || e.key == ".") {
        e.preventDefault();
    }
});

function validateEmail() {
    var emailInput = document.getElementById("email").value;
    if(emailInput!=""){
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput)) {        
        document.getElementById("email_error").innerHTML = "The email field must be a valid email address.";
        //document.getElementById("add_email").value = ""; // Clear invalid input
        $(".hide_update_btn").hide();
    }else{
      document.getElementById("email_error").innerHTML = "";
      $(".hide_update_btn").show();

    }
  }else{
    document.getElementById("email_error").innerHTML = "";
    $(".hide_update_btn").show();

  }
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#type').change(function() {
        if ($(this).val() == '2') {
            $('.password_field').hide();
            $('.confirm_password_field').hide();
        } else {
            $('.password-field').show();
            $('.confirm-password-field').show();
        }
    });

    $('#type').trigger('change');
});
</script>
@endsection