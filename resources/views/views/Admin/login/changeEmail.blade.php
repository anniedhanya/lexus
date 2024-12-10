@extends('_layouts.default')

@section('head-assets')
    @parent
@endsection

@section('content-area')
      <!-- page content -->
<div class="x_panel p-4">
	 @if(session()->has('successmsg'))
                            <div class="alert alert-success">
                               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('successmsg') }}
                            </div>
                            @endif
                             @if(session()->has('errormsg'))
                        <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <strong>Warning:</strong> {{ session()->get('errormsg') }}   
                        </div>
                            @endif
		<div class="x_title">
		    <h2>Change Email Address</h2>	
			<div class="clearfix"></div>
		</div>
	<div class="x_content">
	<!-- start form for validation -->
	{!! Form::open(array('url' => url('admin/new_email'), 'role' => 'form','id'=>'demo-form')) !!} 
            <div class="row">
                <div class="col-lg-4">
                    <label for="heard">New Email :<span class="text-danger">(*)</span></label>
            {!! Form::text('new_email', null, array('class'=>'form-control', 'id'=>'new_email','placeholder'=>'Enter your New Email Address')) !!}
				     <span  class="text-danger error" style="color:#e03b3b">{{ $errors->first('new_email') }}</span>					
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-4">
                    <label for="Station">Confirm Email :<span class="text-danger">(*)</span></label>
              {!! Form::text('confirm_email', null, array('class'=>'form-control', 'id'=>'confirm_email','placeholder'=>'Enter your Confirm Email Address')) !!}

			         <span  class="text-danger error" style="color:#e03b3b">{{ $errors->first('confirm_email') }}</span>
                </div> 
            </div>
                              
									<!-- end form for validations -->
        <div class="row">
          <div class="col-lg-4">									
		        <button class="btn btn-success border-0 mt-3" type="submit" style="margin-bottom:5px;">Save</button>
		        <a href="{{ url('admin/change_email') }}" class="btn btn-large border-0 mt-3">Cancel</a>

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
