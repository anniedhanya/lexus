@extends('_layouts.default')
@section('meta_title')
   {{  "Users" }}
@stop
@section('head-assets')
    <!----daterangepicker---->
<link href="{{asset('vendors/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
.pagination {
  /*display: inline-block;*/
}
.pagination button {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}
.pagination button.active {
  color: 000;
  background-color: red;
  background-image: linear-gradient(to right, red , #ffb100);
}
.pagination button:hover:not(.active) {background-color: #ffef01;}
.btn-height-a
{height: 36px;}
.search-form-a .input-group-addon 
{ padding: 6px 8px; }
.total_count_div_class{ font-size: 14px; font-weight: 300; padding: 7px 0;}
</style>
@parent
@endsection
@section('content-area')
           
          
                <div class="x_panel p-4"> 
                    @include('_partials.notifications') 
                    <div class="x_content transaction">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">                              
                                  <div class="col-sm-6 d-flex align-items-center text-center"> 
                                    <h3>Content Settings</h3>
                                  </div> 
                                  <div class="col-sm-6 d-flex align-items-center">
                                    <ul class="nav navbar-right panel_toolbox table-menu-sec">
                                      <li>
                                        <form id="formFilterSearch" method="post" action="{{url('/')}}">
                                          <div class="input-group">
                                            <input type="text" id="search" name="search" class="form-control searchbox" placeholder="Search.." aria-label="Search..">
                                            <input type="hidden" id="checkb" name="checkb" class="form-control" value="">
                                            <div class="input-group-append">
                                              <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                          </div>
                                          {{ csrf_field() }}
                                        </form>
                                      </li>
                                      <li>
                                        <a href="{{ route($route.'.create') }}" class="btn btn-primary border-0 new-page-btn"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; New</a>
                                      </li>
                                      <li>
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                          <i class="fa fa-cog"></i>
                                        </button>
                                        <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"></a> -->
                                      </li>
                                      <li class="dropdown">
                                        <a href="#" class="dropdown-toggle exp-button btn btn-primary" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bars"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <button id="export_csv" type="button" class="dropdown-item">Export</button>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <!-- toggle -->
                                <div class="collapse filter_collapse" id="collapseExample">
                                  <div class="card card-body mt-3 filter_card">
                                    <h3 class="mt-0 pt-0 pb-1">Search</h3>
                                    <form id="formFilterNew" method="post" action="{{url('/')}}">
                                      <div class="row">
                                        <div class="col-md-3 mb-2"> 
                                          <label for="fullname">Name</label>
                                          {!! Form::text('name', null, array('class'=>'form-control required', 'id'=>'name','placeholder'=>'Name')) !!}
                                        </div>
                                        <div class="col-md-3 mb-2"> 
                                          <label for="fullname">Contact Number</label>
                                          {!! Form::text('email', null, array('class'=>'form-control required', 'id'=>'email','placeholder'=>'Contact Number')) !!}
                                        </div>
                                        <div class="col-md-3 mb-2"> 
                                          <label for="fullname">Model No.</label>
                                          {!! Form::text('mobile_number', null, array('class'=>'form-control required', 'id'=>'mobile_number','placeholder'=>'Modal No')) !!}
                                        </div>                         
                                        <div class="col-md-12 mb-2">
                                          <div class="w-100 justify-content-end">
                                            <button type="submit" id="submit" class="btn btn-statu btn-primary border-0 mr-1">Search</button>
                                            <input type="reset" name="" onclick="window.location=''" class="btn btn-secondary btn-statu border-0">
                                          </div>
                                        </div>
                                      </div>
                                      <input type="hidden" name="per_page_count" id="per_page_count" value="">                                
                                      {{ csrf_field() }}
                                    </form>
                                  </div>
                                </div>

                            </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                  <label>
                                  <!-- <input type="search" class="form-control input-sm" placeholder="Search..." aria-controls="datatable"> -->
                                  </label>
                                </div>
                              </div>
                            </div>  
                              <!-- <div class="py-1 w-100 border-top border-bottom my-1"></div>   -->
                               <div class="row">
                                <div class="col-md-12">
                                <div class="card-box table-responsive">   
                                <table id="datatable_"  class="table table-striped dt-responsive nowrap dataTable_" cellspacing="0" width="100%">
 
                                <thead>
                                  <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>  

                                </div>
                               </div>
                        
                    </div>
                </div>
             
       

   
              <div class="x_panel"> 
                <div class="row"> 
                  <div  class="col-md-4 align-middle">
                    <div id="total_count_div" class="total_count_div_class"></div>
                  </div>
                  <div class="col-md-4 d-flex justify-content-center">
                    <div id="pagination"  class="pagination"></div>
                  </div>
                  <div  class="col-md-4 px-0 justify-content-end">
                    <div class="float-right">
                      <div class="dataTables_length" id="datatable_length">
                        <label class="d-flex mb-0">
                          <select id="per_page" name="datatable_length" aria-controls="datatable" class="form-control input-sm table-content-select">
                            <option value="10">10 per pages</option>
                            <option value="25">25 per pages</option>
                            <option value="50">50 per pages</option>
                            <option value="75">75 per pages</option>
                            <option value="100">100 per pages</option>
                            <option value="150">150 per pages</option>
                            <option value="200">200 per pages</option>
                          </select> 
                          <span class="p-2 arrow-left"> <p class="p-0 m-0" id="page_count_div"></p></span>
                        </label>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
         



@endsection
@section('footer-assets')
<!----daterangepicker---->
  <script type="text/javascript" src="{{asset('vendors/daterangepicker/daterangepicker.js')}}"></script>

  <script type="text/javascript">

  $("#toggle_status").change(function () {
            var check;
            $('input[name^="toggle_status"').prop('checked', $(this).prop("checked"));
            if ($(this).prop('checked')==true){ 
               check=1;

            }else{
              
              check=0;
            }
             $("#checkb").val(check);

      var url_ = '<?php echo url('/');?>';
     $("#per_page_count").val($("#per_page").val());
     $("#per_page").change(function(){
     $("#per_page_count").val($("#per_page").val());
     $('#formFilterNew').submit();
      });
     $("#per_page_count").val($("#per_page").val());
          var perpage = $("#per_page_count").val();
          var perpage = 1;
          var filter = {status:status}
          var page_number = 1;
     $('#datatable_ tbody').html('<tr><th colspan="9">Loading <i class="fa fa-spinner fa-spin"></i></th></tr>');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
          $.ajax({
              url:"{{url('/')}}/admin/users/users_list",
              data:{_token:"{{csrf_token()}}",filter:filter,page_number:page_number},
              dataType:'json',
              type:'post', 
              success:function(data){
                if(data)
                { $('#datatable_ tbody').html('');
                  if(data.total_count > 0)
                  {
                      var j=1;
                      for(var i=0;i<data.count;i++)
                      {
                        var url_ = '<?php echo url('/');?>';
                        var slno = j+data.offset;
                        var str = '<tr>';
                   
                        str += '<td>'+slno+'</td><td>'+data.result[i].name+'</td><td>'+data.result[i].email+'</td><td>'+data.result[i].user_type+'</td><td><a href="' +url_+'/admin/users/'+data.result[i].id + '/edit'+'" class="" title="Edit"><img src="{{asset('img/edit.svg')}}" alt="Edit Icon" height="25"></a><a href="#" class="user_delete" title="Delete"><img src="{{asset('img/delete.svg')}}" alt="Delete Icon" height="25" onclick="user_delete('+data.result[i].id+')"></a>';
                        str +='</td></tr>';
                        $('#datatable_ tbody').append(str);
                        j++;
                      }
                      var pagination = '';
                      if(data.total_count > 0)
                      {
                        if(data.current_page > 1)
                        {
                          var previous_page = data.current_page - 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+1+'">First</button><button type="button" class="paginate_btn btn" data-page_number="'+previous_page+'">Prev</button>';
                        }
                        pagination = pagination+'<button type="button" class="active btn" >'+data.current_page+'</button>';
                        if(data.current_page < data.total_pages)
                        {
                          var next_page = parseInt(data.current_page) + 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+next_page+'">Next</button><button type="button" class="paginate_btn btn" data-page_number="'+data.total_pages+'">Last</button>';
                        }
                      }

                      $('.pagination').html(pagination);
                      $("#page_count_div").html(data.current_page+" - "+data.total_pages);
                      $("#total_count_div").html(" Total Records: "+data.count);

            
                  }
                  else
                  {
                    $('#datatable_ tbody').html('<tr><th colspan="10">No Data Available</th></tr>');
                  }
                }
                else
                {
                 

                  $('#datatable_ tbody').html('<tr><th colspan="10">Something went wrong! Please try again.</th></tr>');
                  
                  
                }
              }
            }).fail(function(jqXHR, textStatus, error){
  
        
    });
        });

  </script>
<script type="text/javascript">
   $(document).ready(function(){
     var url_ = '<?php echo url('/');?>';
     $("#per_page_count").val($("#per_page").val());
     $("#per_page").change(function(){
     $("#per_page_count").val($("#per_page").val());
     $('#formFilterNew').submit();
      });
     $("#per_page_count").val($("#per_page").val());
          var perpage = $("#per_page_count").val();
          var status = 1;
          var status_ =$("#status_").val();
          var name = $('#name').val();
          var modal_number = $('#modal_number').val();
          var contact_number = $('#contact_number').val();
          var category_id = $('#category_id').val();
          var filter = {per_page_count:perpage,name:name,modal_number:modal_number,contact_number:contact_number,category_id:category_id,status:status}
          var page_number = 1;
     $('#datatable_ tbody').html('<tr><th colspan="9">Loading <i class="fa fa-spinner fa-spin"></i></th></tr>');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
          $.ajax({
              url:"{{url('/')}}/admin/users/users_list",
              data:{_token:"{{csrf_token()}}",filter:filter,page_number:page_number},
              dataType:'json',
              type:'post', 
              success:function(data){
                if(data)
                { $('#datatable_ tbody').html('');
                  if(data.total_count > 0)
                  {
                      var j=1;
                      for(var i=0;i<data.count;i++)
                      {
                        var url_ = '<?php echo url('/');?>';
                        var slno = j+data.offset;
                        var str = '<tr>';
                        str += '<td>'+slno+'</td><td>'+data.result[i].name+'</td><td>'+data.result[i].email+'</td><td>'+data.result[i].user_type+'</td><td><a href="' +url_+'/admin/users/'+data.result[i].id + '/edit'+'" class="" title="Edit"><img src="{{asset('img/edit.svg')}}" alt="Edit Icon" height="25"></a><a href="#" class="user_delete" title="Delete"><img src="{{asset('img/delete.svg')}}" alt="Delete Icon" height="25" onclick="user_delete('+data.result[i].id+')"></a>';
                        str +='</td></tr>';

                             


                      
                        $('#datatable_ tbody').append(str);
                        j++;
                      }
                      var pagination = '';
                      if(data.total_count > 0)
                      {
                        if(data.current_page > 1)
                        {
                          var previous_page = data.current_page - 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+1+'">First</button><button type="button" class="paginate_btn btn" data-page_number="'+previous_page+'">Prev</button>';
                        }
                        pagination = pagination+'<button type="button" class="active btn" >'+data.current_page+'</button>';
                        if(data.current_page < data.total_pages)
                        {
                          var next_page = parseInt(data.current_page) + 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+next_page+'">Next</button><button type="button" class="paginate_btn btn" data-page_number="'+data.total_pages+'">Last</button>';
                        }
                      }

                      $('.pagination').html(pagination);
                      // $("#page_count_div").html(data.current_page+" of "+data.total_pages+" Pages");
                                            $("#page_count_div").html(data.current_page+" - "+data.total_pages);

                      $("#total_count_div").html(" Total Records: "+data.count);

            
                  }
                  else
                  {
                    $('#datatable_ tbody').html('<tr><th colspan="9">No Data Available</th></tr>');
                  }
                }
                else
                {
                 

                  $('#datatable_ tbody').html('<tr><th colspan="9">Something went wrong! Please try again.</th></tr>');
                  
                  
                }
              }
            }).fail(function(jqXHR, textStatus, error){
  
        
    });

 $('#formFilterSearch').submit(function(event){
   event.preventDefault();
          $("#per_page_count").val($("#per_page").val());
          var perpage = $("#per_page_count").val();
          var search = $('#search').val();
          var status_ =$("#status_").val();
          var filter = {per_page_count:perpage,search:search}
          var page_number = 1;
           $('#datatable_ tbody').html('<tr><th colspan="9">Loading <i class="fa fa-spinner fa-spin"></i></th></tr>');

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

          $.ajax({
              url:"{{url('/')}}/admin/users/users_list",
              data:{_token:"{{csrf_token()}}",filter:filter,page_number:page_number},
              dataType:'json',
              type:'post', 
              success:function(data){
                if(data)
                { $('#datatable_ tbody').html('');
                  if(data.total_count > 0)
                  {
                      var j=1;
                      for(var i=0;i<data.count;i++)
                      {
                       
                        var url_ = '<?php echo url('/');?>';
                        var slno = j+data.offset;
                        var str = '<tr>';
                        str += '<td>'+slno+'</td><td>'+data.result[i].name+'</td><td>'+data.result[i].email+'</td><td>'+data.result[i].user_type+'</td><td><a href="' +url_+'/admin/users/'+data.result[i].id + '/edit'+'" class="" title="Edit"><img src="{{asset('img/edit.svg')}}" alt="Edit Icon" height="25"></a><a href="#" class="user_delete" title="Delete"><img src="{{asset('img/delete.svg')}}" alt="Delete Icon" height="25" onclick="user_delete('+data.result[i].id+')"></a>';
                        str +='</td></tr>';
                        $('#datatable_ tbody').append(str);
                        j++;
                      }

                      var pagination = '';
                      if(data.total_count > 0)
                      {
                        if(data.current_page > 1)
                        {
                          var previous_page = data.current_page - 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+1+'">First</button><button type="button" class="paginate_btn btn" data-page_number="'+previous_page+'">Prev</button>';
                        }
                        pagination = pagination+'<button type="button" class="active btn" >'+data.current_page+'</button>';
                        if(data.current_page < data.total_pages)
                        {
                          var next_page = parseInt(data.current_page) + 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+next_page+'">Next</button><button type="button" class="paginate_btn btn" data-page_number="'+data.total_pages+'">Last</button>';
                        }
                      }
                      $('.pagination').html(pagination);
                      // $("#page_count_div").html(data.current_page+" of "+data.total_pages+" Pages");
                      $("#page_count_div").html(data.current_page+" - "+data.total_pages);
                      $("#total_count_div").html(" Total Records: "+data.count);
                  }
                  else
                  {
                    $('#datatable_ tbody').html('<tr><th colspan="9">No Data Available</th></tr>');
                  }
                }
                else
                {
                 

                  $('#datatable_ tbody').html('<tr><th colspan="9">Something went wrong! Please try again.</th></tr>');
                  
                  
                }
              }
            }).fail(function(jqXHR, textStatus, error){
  
        
    });


 

 });
       $('#formFilterNew').submit(function(event){

          event.preventDefault();
          $("#per_page_count").val($("#per_page").val());
          var perpage = $("#per_page_count").val();
          var search_val = $('#search').val();
          var name = $('#name').val();
          var modal_number = $('#modal_number').val();
          var contact_number = $('#contact_number').val();
          var category_id = $('#category_id').val();
          var filter = {per_page_count:perpage,search_val:search_val,name:name,modal_number:modal_number,contact_number:contact_number,category_id:category_id}
          var page_number = 1;
          $('#datatable_ tbody').html('<tr><th colspan="9">Loading <i class="fa fa-spinner fa-spin"></i></th></tr>');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

          $.ajax({
              url:"{{url('/')}}/admin/users/users_list",
              data:{_token:"{{csrf_token()}}",filter:filter,page_number:page_number},
              dataType:'json',
              type:'post', 
              success:function(data){
                if(data)
                { $('#datatable_ tbody').html('');
                  if(data.total_count > 0)
                  {
                      var j=1;
                      for(var i=0;i<data.count;i++)
                      {
                        //alert(data.result[i].id);
                        //$('#datatable_ tr:last').after('<tr>...</tr>');
                       
                        var url_ = '<?php echo url('/');?>';

                        var slno = j+data.offset;
                        
                        var str = '<tr>';
                       
                        str += '<td>'+slno+'</td><td>'+data.result[i].name+'</td><td>'+data.result[i].email+'</td><td>'+data.result[i].user_type+'</td><td><a href="' +url_+'/admin/users/'+data.result[i].id + '/edit'+'" class="" title="Edit"><img src="{{asset('img/edit.svg')}}" alt="Edit Icon" height="25"></a><a href="#" class="user_delete" title="Delete"><img src="{{asset('img/delete.svg')}}" alt="Delete Icon" height="25" onclick="user_delete('+data.result[i].id+')"></a>';
                        str +='</td></tr>';
                        
                       
                        $('#datatable_ tbody').append(str);
                        j++;
                      }

                      var pagination = '';
                      if(data.total_count > 0)
                      {
                        //pagination = pagination+'<tr><th>';
                        if(data.current_page > 1)
                        {
                          var previous_page = data.current_page - 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+1+'">First</button><button type="button" class="paginate_btn btn" data-page_number="'+previous_page+'">Prev</button>';
                        }
                        pagination = pagination+'<button type="button" class="active btn" >'+data.current_page+'</button>';
                        if(data.current_page < data.total_pages)
                        {
                          var next_page = parseInt(data.current_page) + 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+next_page+'">Next</button><button type="button" class="paginate_btn btn" data-page_number="'+data.total_pages+'">Last</button>';
                        }
                      }

                      //pagination = pagination+'</th></tr>';

                      $('.pagination').html(pagination);
                      // $("#page_count_div").html(data.current_page+" of "+data.total_pages+" Pages");
                      $("#page_count_div").html(data.current_page+" - "+data.total_pages);
                      $("#total_count_div").html(" Total Records: "+data.count);

            
                  }
                  else
                  {
                    $('#datatable_ tbody').html('<tr><th colspan="9">No Data Available</th></tr>');
                  }
                }
                else
                {
                 

                  $('#datatable_ tbody').html('<tr><th colspan="9">Something went wrong! Please try again.</th></tr>');
                  
                  
                }
              }
            }).fail(function(jqXHR, textStatus, error){
  
        
    });

  });



    

   




   });
</script>
 <script type="text/javascript">
   $('.pagination').on('click','button.paginate_btn',function(){
      $('.pagination').html('');
      $('.page_count_div').html('');
      $('.total_count_div').html('');
      $('#datatable_ tbody').empty();

          var perpage = $("#per_page_count").val();
          var search_val =$("#search").val();
          var name = $('#name').val();
          var modal_number = $('#modal_number').val();
          var contact_number = $('#contact_number').val();
          var category_id = $('#category_id').val();
          var filter = {per_page_count:perpage,search_val:search_val,name:name,modal_number:modal_number,contact_number:contact_number,category_id:category_id}
       
      var page_number = $(this).data("page_number");

      $('#datatable_ tbody').html('<tr><th colspan="9">Loading <i class="fa fa-spinner fa-spin"></i></th></tr>');

      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

       $.ajax({
              url:"{{url('/')}}/admin/users/users_list",
              data:{_token:"{{csrf_token()}}",filter:filter,page_number:page_number},
              dataType:'json',
              type:'post', 
              success:function(data){
                if(data)
                { $('#datatable_ tbody').html('');
                  if(data.total_count > 0)
                  {
                      var j=1;
                      for(var i=0;i<data.count;i++)
                      {
                        //alert(data.result[i].id);
                        //$('#datatable_ tr:last').after('<tr>...</tr>');
                       
                        var url_ = '<?php echo url('/');?>';

                        var slno = j+data.offset;
                        
                       var str = '<tr>';
                       
                       str += '<td>'+slno+'</td><td>'+data.result[i].name+'</td><td>'+data.result[i].email+'</td><td>'+data.result[i].user_type+'</td><td><a href="' +url_+'/admin/users/'+data.result[i].id + '/edit'+'" class="" title="Edit"><img src="{{asset('img/edit.svg')}}" alt="Edit Icon" height="25"></a><a href="#" class="user_delete" title="Delete"><img src="{{asset('img/delete.svg')}}" alt="Delete Icon" height="25" onclick="user_delete('+data.result[i].id+')"></a>';
                        str +='</td></tr>';
                       
                        $('#datatable_ tbody').append(str);
                        j++;
                      }

                      var pagination = '';
                      if(data.total_count > 0)
                      {
                        //pagination = pagination+'<tr><th>';
                        if(data.current_page > 1)
                        {
                          var previous_page = data.current_page - 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+1+'">First</button><button type="button" class="paginate_btn btn" data-page_number="'+previous_page+'">Prev</button>';
                        }
                        pagination = pagination+'<button type="button" class="active btn" >'+data.current_page+'</button>';
                        if(data.current_page < data.total_pages)
                        {
                          var next_page = parseInt(data.current_page) + 1;
                          pagination = pagination+'<button type="button" class="paginate_btn btn" data-page_number="'+next_page+'">Next</button><button type="button" class="paginate_btn btn" data-page_number="'+data.total_pages+'">Last</button>';
                        }
                      }

                      //pagination = pagination+'</th></tr>';

                      $('.pagination').html(pagination);
                      // $("#page_count_div").html(data.current_page+" of "+data.total_pages+" Pages");
                      $("#page_count_div").html(data.current_page+" - "+data.total_pages);
                      $("#total_count_div").html(" Total Records: "+data.count);


            
                  }
                  else
                  {
                    $('#datatable_ tbody').html('<tr><th colspan="9">No Data Available</th></tr>');
                  }
                }
                else
                {
                 

                  $('#datatable_ tbody').html('<tr><th colspan="9">Something went wrong! Please try again.</th></tr>');
                  
                  
                }
              }
            }).fail(function(jqXHR, textStatus, error){
  
        
    });

             });
</script>
<script type="text/javascript">
    var baseurl = $('#baseurl').val();



         $("#export_csv").click(function(){
          var name = $('#name').val();
          var email = $('#email').val();
          var mobile_number = $('#mobile_number').val();
            setTimeout(function() {
              $('#export_csv').attr('disabled',false);
            },5000); 
            window.location.href =  '{{url('/')}}/admin/users_export?name='+name+'&email='+email+'&mobile_number='+mobile_number;


        

        });
</script>
<script src="{{asset('js/popper.min.js')}}"></script>

<!-- <script src="{{asset('js/boot4alert.js')}}"></script> -->

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script type="text/javascript">

  function user_delete(id){
    Swal.fire({
        title: 'WARNING',
        text: 'Are you sure to delete selected? Associated data will be removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'user_delete?id=' + id;
        }
    });  
  }


</script>

  @parent 


@endsection 