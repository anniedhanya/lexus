
@extends('_layouts.default')

@section('head-assets')
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
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
        <h3>Edit Assign User</h3>
        @else
        <h3>Add Assign User</h3>
        @endif
                

    </div>
    <div class="x_content">
    @if($obj->id)
    @section('meta_title')
    {{  "Edit Assign User" }}
    @stop
    {!! Form::model($obj, array('method' => 'put', 'url' => route($route.'.update', $obj->id), 'files' => true, 'role' => 'form','id'=>'edit_activity')) !!}
    @else
    @section('meta_title')
    {{  "New Assign User" }}
    @stop
    {!! Form::open(array('url' => route($route.'.store'), 'files' => true, 'role' => 'form', 'id' =>'add_activity')) !!} 
    @endif
                    
    @include('_partials.notifications') 
           
<div class="row label-display-block">



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

              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Contact No. <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="contact_no" name="contact_no" value="{{$obj->contact_no}}" maxlength="15">
               <span  class="text-danger error" style="color:#e03b3b" id="contact_no_error">{{ $errors->first('contact_no') }}</span>               
              </div>
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Order ID <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="order_id" name="order_id" value="{{$obj->order_id}}" maxlength="20">
                <span  class="text-danger error" style="color:#e03b3b" id="order_id_error">{{ $errors->first('order_id') }}</span>               
              </div>
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Product Category <span class="madatory">*</span></label>                
              {!!Form::select('category_id', App\Models\Category::listForSelectCategory('Select Category', 10000),$obj->product_category_id, array('class'=>'itemName form-select select2 required', 'id'=>'category_id')) !!} 
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('category_id') }}</span>               
              </div>
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Model No. <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="model_no" name="model_no" value="{{$obj->model_no}}" maxlength="10">
                <span  class="text-danger error" style="color:#e03b3b" id="model_no_error">{{ $errors->first('model_no') }}</span>               
              </div>
               <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Executive <span class="madatory">*</span></label>   
                @if(Auth::guard('admin')->user()->type==1)     
                <input type="text"  class="form-control" id="name" name="name" value=""  maxlength="150">

                @else
              {!!Form::select('executive_user_id', App\Models\User::listForSelectExecutive('Select', 10000),$obj->executive_user_id, array('class'=>'itemName form-select select2 required', 'id'=>'executive_user_id')) !!} 
                @endif        
           
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('executive_user_id') }}</span>               
              </div>
             <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Assigned To <span class="madatory">*</span></label>                
               {!!Form::select('assigned_user_id', App\Models\User::listForSelectAssigned('Select', 10000),$obj->assigned_user_id, array('class'=>'itemName form-select select2 required', 'id'=>'assigned_user_id')) !!} 
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('assigned_user_id') }}</span>               
              </div>
            @if($obj['warranty_period_from']!="")
              <?php
                $warranty_period_from= \Carbon\Carbon::parse($obj['warranty_period_from'])->format('d F Y');
              ?>

                                          <div class="col-lg-4 mb-2">
                                          <label for="fullname">Extended Warranty Period From</label>
                                         {!! Form::text('from_date', $warranty_period_from, array('class'=>'form-control required' ,'placeholder'=>'', 'id'=>'from_date')) !!}
                                          <span id="start_date_err" class="text-danger error" style="color:#e03b3b">{{ $errors->first('from_date') }}</span>
                                        </div>
                                         @else

                                          <div class="col-lg-4 mb-2">
                                          <label for="fullname">Extended Warranty Period From</label>
                                         {!! Form::text('from_date', old('from_date'), array('class'=>'form-control required' ,'placeholder'=>'', 'id'=>'from_date')) !!}
                                          <span id="start_date_err" class="text-danger error" style="color:#e03b3b">{{ $errors->first('from_date') }}</span>
                                        </div>

                                        @endif

             @if($obj['warranty_period_to']!="")
              <?php
                $warranty_period_to= \Carbon\Carbon::parse($obj['warranty_period_to'])->format('d F Y');
              ?>
                                         <div class="col-lg-4 mb-2">
                                          <label for="fullname">Extended Warranty Period To </label>
                                         {!! Form::text('to_date', $warranty_period_to, array('class'=>'form-control required' ,'placeholder'=>'', 'id'=>'to_date')) !!}
                                          <span id="start_date_err" class="text-danger error" style="color:#e03b3b">{{ $errors->first('to_date') }}</span>
                                        </div>

                                        @else
                                        <div class="col-lg-4 mb-2">
                                          <label for="fullname">Extended Warranty Period To </label>
                                         {!! Form::text('to_date', old('to_date'), array('class'=>'form-control required' ,'placeholder'=>'', 'id'=>'to_date')) !!}
                                          <span id="start_date_err" class="text-danger error" style="color:#e03b3b">{{ $errors->first('to_date') }}</span>
                                        </div>
                                        @endif







             @if($obj['date_of_purchase']!="")
             <?php
                $date_of_purchase= \Carbon\Carbon::parse($obj['date_of_purchase'])->format('d F Y');
              ?>
               <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Date of purchase </label>                
             {!! Form::text('date_of_purchase', $date_of_purchase, array('class'=>'form-control required' ,'placeholder'=>'Date of Purchase', 'id'=>'date_of_purchase')) !!}
             <span  class="text-danger error" style="color:#e03b3b" id="date_of_purchase_error">{{ $errors->first('date_of_purchase') }}</span>               
              </div>
              @else
              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Date of purchase</label>                
             {!! Form::text('date_of_purchase', null, array('class'=>'form-control required' ,'placeholder'=>'Date of Purchase', 'id'=>'date_of_purchase')) !!}
             <span  class="text-danger error" style="color:#e03b3b" id="date_of_purchase_error">{{ $errors->first('date_of_purchase') }}</span>               
              </div>
              @endif
            <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Screenshot Status <span class="madatory">*</span></label>                
             {{ Form::select('screenshot_status', [
                      ''=>'Select',
                      '1' => 'Yes',
                      '0' => 'No'
                      ],old('screenshot_status'),['class' => ' form-control','id'=>'screenshot_status']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('screenshot_status') }}</span>               
              </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Warranty Status <span class="madatory">*</span></label>                
             {{ Form::select('warranty_status', [
                      ''=>'Select',
                      '1' => 'Issued',
                      '0' => 'Pending'
                      ],old('warranty_status'),['class' => ' form-control','id'=>'warranty_status']
                    ) }}
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('warranty_status') }}</span>               
              </div>

              <div class="col-md-6 col-lg-4 mb-3">
                <label class="form-label">Remarks <span class="madatory">*</span></label>
                    {!! Form::textarea('remarks', old('remarks'), array('class'=>'form-control', 'id'=>'remarks','placeholder'=>'')) !!} 
                <span  class="text-danger error" style="color:#e03b3b" id="remarks_error">{{ $errors->first('remarks') }}</span>               
              </div>
            </div>

 <div class="col-md-6 col-lg-4 mb-3">
  <label class="form-label">Documents/Screenshot <span class="madatory">*</span></label>
  <div id="attachments">
    @if($obj->doc_screenshot_extension=='jpeg')
    <a href="#" id="imageIcon"  data-toggle="modal" data-target="#imageModal">
      <img src="{{asset('img/imgicon.svg')}}" alt="Image Icon" width="50" height="50">
    </a>
    @endif
     

    @if($obj->doc_screenshot_extension=='pdf')
   <a href="{{url($obj->doc_screenshot_file)}}" id="pdfIcon"  target="_blank">
   <img src="{{asset('img/file-type-pdf.svg')}}" alt="PDF Icon" width="50" height="50">
    </a>
    @endif
     
    
  </div>
  <span class="text-danger error" style="color:#e03b3b" id="attachments_error">{{ $errors->first('attachments') }}</span>
</div>

<div class="col-md-6 col-lg-4 mb-3">
  <label class="form-label">Product Review Screenshot <span class="madatory">*</span></label>
  <div id="attachments">
  
      @if($obj->invoice_link_extension=='jpeg')
    <a href="#" id="imageIcon_"  data-toggle="modal" data-target="#imageModal_">
      <img src="{{asset('img/imgicon.svg')}}" alt="Image Icon" width="50" height="50">
    </a>
    @endif


      @if($obj->invoice_link_extension=='pdf')
    <a href="{{url($obj->invoice_link)}}" id="pdfIcon_"  target="_blank">
    <img src="{{asset('img/file-type-pdf.svg')}}" alt="PDF Icon" width="50" height="50">
    </a>
    @endif
    
  </div>
  <span class="text-danger error" style="color:#e03b3b" id="attachments_error">{{ $errors->first('attachments') }}</span>
</div>

</div>
</div>  
</div>  
</div>

<?php  
if($obj->doc_screenshot_extension=='jpeg'){
    $doc_screenshot_file=url($obj->doc_screenshot_file);
}
if($obj->invoice_link_extension=='jpeg'){
    $invoice_link=url($obj->invoice_link);
}
?>

@else

<div class="col-lg-12 mt-1">
<div class="card position-relative new-con-label">
<div class="row  p-2">
<div class="col-lg-12">

<div class="row">
<div class="col-md-6 col-lg-4 mb-3">
<label class="form-label">Assign User</label>
{!!Form::select('assigned_id', App\Models\Users::listForSelectAssigned('Select User', 10000),null, array('class'=>'itemName form-select select2 required', 'id'=>'assigned_id')) !!} 
<span  class="text-danger error" style="color:#e03b3b" id="name_error">{{ $errors->first('assigned_id') }}</span>               
</div>
<div class="col-md-6 col-lg-4 mb-3">
    <label class="form-label">Select List From</label>
    {!! Form::select('registration_id_from', App\Models\ExtendedWarranty::listForSelectFromAssigned('', 10000), null, ['class' => 'itemName form-select select2 required', 'id' => 'registration_id_from']) !!}
    <span class="text-danger error" style="color:#e03b3b" id="registration_id_from_error">{{ $errors->first('registration_id_from') }}</span>
</div>

<div class="col-md-6 col-lg-4 mb-3">
    <label class="form-label">Select List To</label>
    {!! Form::select('registration_id_to', App\Models\ExtendedWarranty::listForSelectFromAssigned('', 10000), null, ['class' => 'itemName form-select select2 required', 'id' => 'registration_id_to']) !!}
    <span class="text-danger error" style="color:#e03b3b" id="registration_id_to_error">{{ $errors->first('registration_id_to') }}</span>
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
            <a href="{{ url('/admin/assign_users/create')}}" class="btn  mt-2 btn-secondary">Cancel</a>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function () {

  var baseurl = $('#baseurl').val();

   var allOptions = $('#registration_id_to option').clone();

    $('#registration_id_from').on('change', function() {
        var selectedFrom = $(this).val();
        $('#registration_id_to').html(''); // Clear the To dropdown

        allOptions.each(function() {
            if ($(this).val() != selectedFrom) {
                $('#registration_id_to').append($(this));
            }
        });

        $('#registration_id_to').trigger('change');
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
@endsection




