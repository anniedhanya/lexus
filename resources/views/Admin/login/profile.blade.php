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
            <h3>Profile</h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            {!! Form::open(['url' => url('admin/update_profile'), 'role' => 'form', 'id' => 'demo-form']) !!}

            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="heard"> Name <span class="text-danger">*</span></label>
                    {!! Form::text('name', $data->name, [
                        'class' => 'form-control',
                        'id' => 'name',
                        'placeholder' => '',
                    ]) !!}
                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('name') }}</span>
                </div>


                <div class="col-lg-4 mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    {!! Form::text('email', $data->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => '']) !!}

                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('email') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                    {!! Form::text('mobile_number', $data->mobile_number, [
                        'class' => 'form-control',
                        'id' => 'mobile_number',
                        'placeholder' => '',
                    ]) !!}
                    <span class="text-danger error" style="color:#e03b3b">{{ $errors->first('mobile_number') }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-primary border-0 mt-3 mr-1" type="submit">Save</button>
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary border-0 mt-3">Cancel</a>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    </div>
    </div>
    <!-- /page content -->
@endsection
@section('footer-assets')
    @parent
@endsection
