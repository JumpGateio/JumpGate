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
    var mainError   = {!! (session()->has('error') ? json_encode(session()->get('error')) : 0) !!};
    var mainErrors  = {!! (session()->has('errors') ? '"There was a problem with your request.<br />"+'. json_encode(implode('<br />', session()->get('errors')->all())) : 0) !!};
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
      $.each(mainErrors, function ()
      {
        $.notify({
          message: this,
          icon:    'fa fa-exclamation-triangle'
        }, {
          // settings
          type: 'danger'
        });
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
