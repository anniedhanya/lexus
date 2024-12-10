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
		    <h2>Change Password</h2>	
			<div class="clearfix"></div>
		</div>
	<div class="x_content">
	<!-- start form for validation -->
	{!! Form::open(array('url' => url('admin/new_password'), 'role' => 'form','id'=>'demo-form')) !!} 
            <div class="row">
                <div class="col-lg-4">
                    <label for="heard">Current Password :  <span class="text-danger">(*)</span></label>
				    {!! Form::password('password', array('class'=>'form-control', 'id' => 'password', 'placeholder' => 'Enter your Current Password')) !!}
				     <span  class="text-danger error" style="color:#e03b3b">{{ $errors->first('password') }}</span>					
                </div>
            
                <div class="col-lg-4">
                    <label for="Station">New Password :  <span class="text-danger">(*)</span></label>
			        {!! Form::password('new_password', array('class'=>'form-control', 'id' => 'new_password', 'placeholder' => 'Enter your New Password')) !!}
			         <span  class="text-danger error" style="color:#e03b3b">{{ $errors->first('new_password') }}</span>
                </div> 
            </div>
             <div class="row">
                <div class="col-lg-4">
                    <label for="Charging">Confirm Password :  <span class="text-danger">(*)</span></label>
					{!! Form::password('confirm_password', array('class'=>'form-control', 'id' => 'confirm_password', 'placeholder' => 'Enter your Confirm Password')) !!}
					 <span  class="text-danger error" style="color:#e03b3b">{{ $errors->first('confirm_password') }}</span>
                </div>     
        </div>                    
									<!-- end form for validations -->
        <div class="row">
          <div class="col-lg-4">									
		        <button class="btn btn-success border-0 mt-3" type="submit" style="margin-bottom:5px;">Save</button>
		        <a href="{{ url('admin/change_password') }}" class="btn btn-large border-0 mt-3">Cancel</a>

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
