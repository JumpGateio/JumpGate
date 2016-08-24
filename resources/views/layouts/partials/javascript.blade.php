<!-- javascript-->
{!! HTML::script('js/app.js') !!}

<!-- JS Include -->
@section('jsInclude')
@show
<!-- JS Include Form -->
@section('jsIncludeForm')
@show

<script>
  $(document).ready(function ()
  {
    @if (session()->has('errors'))
    var errors = "There was a problem with your request.<br />"+{!! is_string(session()->get('errors')) ? '"'. session()->get('errors') .'"' : json_encode(implode('<br />', is_array(session()->get('errors')) ? session()->get('errors') : session()->get('errors')->all())) !!};
    @else
    var errors = 0;
    @endif

    var mainError   = {!! (session()->has('error') ? json_encode(session()->get('error')) : 0) !!};
    var mainErrors  = errors;
    var mainMessage = {!! (session()->has('message') ? json_encode(session()->get('message')) : 0) !!};
    var mainWarning = {!! (session()->has('warning') ? json_encode(session()->get('warning')) : 0) !!};

    $.notifyDefaults({
      placement:     {
        from:  'bottom',
        align: 'right'
      },
      animate:       {
        enter: 'animated fadeInUp',
        exit:  'animated fadeOutDown'
      },
      allow_dismiss: true
    });

    if (mainError != 0) {
      $.notify({
        message: mainError,
        icon:    'fa fa-exclamation-triangle'
      }, {
        // settings
        type: 'danger'
      });
    }

    if (mainErrors != 0) {
      $.notify({
        message: mainErrors,
        icon:    'fa fa-exclamation-triangle'
      }, {
        // settings
        type: 'danger'
      });
    }

    if (mainMessage != 0) {
      $.notify({
        message: mainMessage,
        icon:    'fa fa-info-circle'
      }, {
        // settings
        type: 'info'
      });
    }

    if (mainWarning != 0) {
      $.notify({
        message: mainWarning,
        icon:    'fa fa-info'
      }, {
        // settings
        type: 'warning'
      });
    }
    // On Ready Js
    @section('onReadyJs')
    @show
    // On Ready Js Form
    @section('onReadyJsForm')
    @show
  });
</script>

<!-- JS -->
@section('js')
@show
<!-- JS Form -->
@section('jsForm')
@show
