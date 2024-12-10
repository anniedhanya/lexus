<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>404</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
 h5{ color: #333F48;  font-weight: 300;}   
   
</style>
</head>
<body>
<div class="container">
  <div class="row">
<div class="col-lg-6 mx-auto py-3 mt-5">
    <img src="{{asset('img/404.png')}}" class="img-fluid">
</div>
<div class="col-12 text-center">
    <h5>The page you requested could not be found</h5>
<a href="{{url('admin/extended_warranty')}}" class="btn btn-primary mt-3">Go Back Home</a>
</div>

  </div>  
</div>
</body>
</html>