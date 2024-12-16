
@if (isset($success))
<div id="successMessage" class="alert alert-success alert-dismissable"  style="padding-left:40% !important;">
 {{ $success }}
</div>
@endif

@if (isset($error))
<div class="alert alert-danger alert-dismissable">
{{ $error }}
</div>
@endif

@if (isset($warning))
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning:</strong> {{ $warning }}
</div>
@endif

@if (isset($info))
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>FYI:</strong> {{ $info }}
</div>
@endif


