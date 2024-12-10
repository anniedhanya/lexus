@extends('layouts.default')
@section('content-area')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- Main content -->
  <section class="main_content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-7 warranty_title">
            <h2>
            Extended Warranty Registration
            </h2>
            <p>Extend your warranty to enjoy extra coverage and peace of mind, protecting your purchase from unexpected repair costs and ensuring hassle-free service.</p>
          </div>
        </div>
         @include('_partials.notifications') 
        <form action="{{url('registration')}}" method="post" name="file" files="true" enctype="multipart/form-data"  id="image-upload">
        @csrf
        <div class="row justify-content-center mt-5">
          <div class="col-lg-5 pe-lg-4 mb-lg-0 mb-4"><img src="{{asset('assets/images/ib_image-about.jpg')}}" class="mw-100 position-sticky top-0" alt=""></div>
          <div class="col-lg-7 form_page">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Name <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="name" name="name" value="{{old('name')}}" oninput="validateInput(event)" maxlength="150">
                <span  class="text-danger error" style="color:#e03b3b" id="name_error">{{ $errors->first('name') }}</span>               
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="text"  class="form-control" id="email" name="email" value="{{old('email')}}"  maxlength="100" onblur="validateEmail()">
                <span  class="text-danger error" style="color:#e03b3b" id="add_email_error">{{ $errors->first('email') }}</span>               
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Contact No. <span class="madatory">*</span></label>
                <input type="text"  class="form-control number_value" id="contact_no" name="contact_no" value="{{old('contact_no')}}" maxlength="15">
               <span  class="text-danger error" style="color:#e03b3b" id="contact_no_error">{{ $errors->first('contact_no') }}</span>               
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Order ID <span class="madatory">*</span></label>
                <input type="text"  class="form-control" id="order_id" name="order_id" value="{{old('order_id')}}" maxlength="20">
                <span  class="text-danger error" style="color:#e03b3b" id="order_id_error">{{ $errors->first('order_id') }}</span>               
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Product Category <span class="madatory">*</span></label>                
              {!!Form::select('category_id', App\Models\Category::listForSelectCategory('Select Category', 10000),old('category_id'), array('class'=>'itemName form-select select2 required', 'id'=>'category_id')) !!} 
             <span  class="text-danger error" style="color:#e03b3b" id="category_id_error">{{ $errors->first('category_id') }}</span>               
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Model No.</label>
                <input type="text"  class="form-control" id="model_no" name="model_no" value="{{old('model_no')}}" maxlength="10">
                <span  class="text-danger error" style="color:#e03b3b" id="model_no_error">{{ $errors->first('model_no') }}</span>               
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Upload Documents/Screenshot <span class="madatory">*</span></label>
                <span class="form-text text-muted">(Allowed file formats: png, jpeg, pdf. Max file size: 2MB.)</span>

                <input type="file"  class="" id="doc_upload" name="doc_upload" accept=".png,.jpeg,.pdf">
                <span  class="text-danger error" style="color:#e03b3b" id="doc_upload_error">{{ $errors->first('doc_upload') }}</span> 
              </div>
                 <div class="col-md-6 mb-3">
                <label class="form-label">Upload Product Review Screenshot <span class="madatory">*</span></label>
                <span class="form-text text-muted">(Allowed file formats: png, jpeg, pdf. Max file size: 2MB.)</span>
                <input type="file"  class="" id="certificate_upload" name="certificate_upload" accept=".png,.jpeg,.pdf">
                <span  class="text-danger error" style="color:#e03b3b" id="certificate_upload_error">{{ $errors->first('certificate_upload') }}</span> 
              </div>
              <div class="g-recaptcha" data-sitekey="{{ config('services.nocaptcha.sitekey') }}"></div>
              <span class="text-danger error" style="color:#e03b3b" id="captcha_error">{{ $errors->first('g-recaptcha-response') }}</span>

              <div class="col-12 mt-3">
                <button class="btn btn-primary_warranty">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
        

      </div>
    </section>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 

<script type="text/javascript">
 
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
        $( document ).ready(function() {
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
});

function validateEmail() {
    var emailInput = document.getElementById("email").value;
    if(emailInput!=""){
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput)) {        
        document.getElementById("add_email_error").innerHTML = "The email field must be a valid email address.";
        //document.getElementById("add_email").value = ""; // Clear invalid input
        $(".hide_update_btn").hide();
    }else{
      document.getElementById("add_email_error").innerHTML = "";
      $(".hide_update_btn").show();

    }
  }else{
    document.getElementById("add_email_error").innerHTML = "";
    $(".hide_update_btn").show();

  }
    }

    setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
</script>
@section('footer-assets')

  @parent

@endsection
