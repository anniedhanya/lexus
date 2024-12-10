@extends('_layouts.default')

@section('head-assets')
    @parent
@endsection

@section('content-area')
    <!-- page content -->
    <div class="x_panel p-4">
        @if (session()->has('successmsg'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session()->get('successmsg') }}
            </div>
        @endif
        @if (session()->has('errormsg'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Warning:</strong> {{ session()->get('errormsg') }}
            </div>
        @endif
        <div class="x_title">
            <h3>Change Password</h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!-- start form for validation -->
            {!! Form::open(['url' => url('admin/new_password'), 'role' => 'form', 'id' => 'demo-form']) !!}
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="heard">Current Password <span class="text-danger">*</span></label>
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'id' => 'password',
                        'placeholder' => 'Enter Your Current Password',
                    ]) !!}
                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('password') }}</span>
                </div>

                <div class="col-lg-4 mb-3">
                    <label for="Station">New Password <span class="text-danger">*</span></label>
                    {!! Form::password('new_password', [
                        'class' => 'form-control',
                        'id' => 'new_password',
                        'placeholder' => 'Enter Your New Password',
                    ]) !!}
                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('new_password') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="Charging">Confirm Password <span class="text-danger">*</span></label>
                    {!! Form::password('confirm_password', [
                        'class' => 'form-control',
                        'id' => 'confirm_password',
                        'placeholder' => 'Enter Your Confirm Password',
                    ]) !!}
                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('confirm_password') }}</span>
                </div>
            </div>
            <!-- end form for validations -->
            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-primary border-0 mt-3 mr-1" type="submit">Save</button>
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary border-0 mt-3">Cancel</a>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /page content -->
@endsection
@section('footer-assets')
    @parent
@endsection
