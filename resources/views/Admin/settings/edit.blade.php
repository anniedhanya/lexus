
@extends('_layouts.default')

@section('head-assets')
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

  .nav.side-menu>li.current-page,
  .nav.side-menu>li.active {
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

  .notifi-tab {
    right: 0;
    top: 13px;
  }

  #map-canvas {
    height: 420px;
    width: 620px;
    background-color: #6495ed;
    display: none;
  }

  .location_field_ {
    position: relative;
  }

  .location_field_ .btn-success {
    position: absolute;
    right: 0;
    top: 0;
    border-radius: 10px;
    background-color: #333;
    border-color: #333;
  }

  .location_field_ .btn-success:hover,
  .location_field_ .btn-success:active,
  .location_field_ .btn-success:focus {
    background-color: #111 !important;
    border-color: #111 !important;
    box-shadow: none !important;
  }

  .location_field_ .input100 {
    width: 91%;
  }

  div.pac-container {
    z-index: 1050 !important;
  }
</style>
@parent
@endsection
@section('content-area')
<div class="col-md-12 col-sm-12 mt-4">
  <div class="x_panel p-4">
    <div class="x_title">
      <h2>Edit</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

    {!! Form::open(['route' => ['settings-update', $data], 'method' => 'put']) !!}

      <div class="row">

      <div class="col-lg-12 mb-2">
          <label for="id">Title : <span class="text-danger">*</span></label>
          {!! Form::text('title', isset($data->title) ? $data->title : old('title'), array('class'=>'form-control', 'id'=>'title','style'=>'width:50%;','placeholder'=>'', 'readonly' => 'readonly')) !!}

        </div>

        <div class="col-lg-12 mb-2">
          <label for="text1">Address: <span class="text-danger">*</span></label>
          {!! Form::textarea('address', isset($data->address) ? $data->address : old('address'), array('class'=>'form-control', 'id'=>'address','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('rfid_tag') }}</span> -->
        </div>

        <div class="col-lg-12 mb-2">
          <label for="text2">Phone Number: <span class="text-danger">*</span></label>
          {!! Form::textarea('phone_number', isset($data->phone_number) ? $data->phone_number : old('phone_number'), array('class'=>'form-control', 'id'=>'phone_number','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('tag_label') }}</span> -->
        </div>

        <div class="col-lg-12 mb-2">
          <label for="text3">Email</label>
          {!! Form::textarea('email', isset($data->email) ? $data->email : old('email'), array('class'=>'form-control', 'id'=>'email','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('master_tag') }}</span> -->
        </div>
        <div class="col-lg-12 mb-2">
          <label for="text3">Facebook Link</label>
          {!! Form::textarea('facebook', isset($data->facebook) ? $data->facebook : old('facebook'), array('class'=>'form-control', 'id'=>'facebook','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('master_tag') }}</span> -->
        </div>
        <div class="col-lg-12 mb-2">
          <label for="text3">Instagram Link</label>
          {!! Form::textarea('instagram', isset($data->instagram) ? $data->instagram : old('instagram'), array('class'=>'form-control', 'id'=>'instagram','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('master_tag') }}</span> -->
        </div>
        <div class="col-lg-12 mb-2">
          <label for="text3">Youtube Link</label>
          {!! Form::textarea('youtube', isset($data->youtube) ? $data->youtube : old('youtube'), array('class'=>'form-control', 'id'=>'youtube','rows'=>'3','style'=>'width:50%;','placeholder'=>'')) !!}
          <!-- <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('master_tag') }}</span> -->
        </div>
      </div>


      <!-- end form for validations -->
      <div class="row">
        <div class="col-lg-12">
          <button type="submit" name="button" class="btn login_btn mt-2 w-auto align-right float-right">Update Data</button>
          <!-- <a href="{{ url('/admin/rfids/')}}" class="btn  mt-2 w-auto align-right float-right">Cancel</a> -->
        </div>
      </div>
    </div>
    {!! Form::close() !!}

  </div>
</div>

@endsection
@section('footer-assets')
@parent
@endsection