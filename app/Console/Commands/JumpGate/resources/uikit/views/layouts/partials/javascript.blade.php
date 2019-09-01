<script>
  window.Laravel = <?php echo json_encode([
        'csrfToken'  => csrf_token(),
        'userId'     => auth()->id(),
        'host'       => env('APP_URL'),
        'socketPort' => env('NODE_PORT'),
    ]); ?>
</script>

<!-- javascript-->
{!! HTML::script('js/app.js') !!}
<script async src="https://gw2armory.com/gw2aEmbeds.js"></script>

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
      var errors      = "There was a problem with your request.<br />" +{!! is_string(session()->get('errors')) ? '"'. session()->get('errors') .'"' : json_encode(implode('<br />', is_array(session()->get('errors')) ? session()->get('errors') : session()->get('errors')->all())) !!};
    @else
      var errors      = 0;
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
      allow_dismiss: true,
//      template:      '<article data-notify="container" class="col-xs-11 col-sm-3 message uk-alert-{0}" role="alert" uk-alert>' +
//                     '<div class="message-body">' +
//                     '<span data-notify="title">{1}</span> ' +
//                     '<button type="button" aria-hidden="true" uk-close class="uk-alert-close delete" data-notify="dismiss"></button>' +
//                     '<span data-notify="icon"></span> ' +
//                     '<span data-notify="message" class="m-r-2">{2}</span>' +
//                     '<div class="progress" data-notify="progressbar">' +
//                     '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
//                     '</div>' +
//                     '<a href="{3}" target="{4}" data-notify="url"></a>' +
//                     '</div>' +
//                     '</article>',
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

    $("a.confirm-remove").click(function (e)
    {
      e.preventDefault();
      var location = $(this).attr('href');

      UiKit.modal.confirm(
        '<h2>You are about to delete an item</h2>This is not reversible.  Are you sure you want to proceed?')
           .then(function ()
           {
             window.location.replace(location);
           });
    });
    $("a.confirm-continue").click(function (e)
    {
      e.preventDefault();
      var location = $(this).attr('href');

      UiKit.modal.confirm(
        '<h2>Verify before continuing</h2>Are you sure you want to continue?')
           .then(function ()
           {
             window.location.replace(location);
           });
    });

    (function ()
    {
      var laravel = {
        initialize: function ()
                    {
                      console.log('LOADED');
                      this.methodLinks = $('a[data-method]');

                      laravel.registerEvents();
                    },

        registerEvents: function ()
                        {
                          console.log('REGISTERING');
                          this.methodLinks.on('click', this.handleMethod);
                        },

        handleMethod: function (e)
                      {
                        console.log('CLICKED');
                        var link       = $(this);
                        var httpMethod = link.data('method').toUpperCase();
                        var title      = link.data('title');
                        var message    = link.data('message');
                        var backdrop   = link.data('backdrop');

                        console.log(httpMethod);

                        // If the data-method attribute is not DELETE,
                        // then we don't know what to do. Just ignore.
                        if ($.inArray(httpMethod, ['DELETE']) === -1) {
                          return;
                        }

                        e.preventDefault();
                        return laravel.verifyConfirm(link, title, message, backdrop);
                      },

        verifyConfirm: function (link, title, message, backdrop)
                       {
                         title   = title == null ? 'You are about to delete an item' : title
                         message = message == null ? 'This is not reversible.  Are you sure you want to proceed?' : message

                         return UiKit.modal.confirm(
                                       '<h2>' + title + '</h2>' + message)
                                     .then(function ()
                                     {
                                       var form = laravel.createForm(link);
                                       form.submit();
                                     });
                       },

        createForm: function (link)
                    {
                      var form =
                            $('<form>', {
                              'method': 'POST',
                              'action': link.attr('href')
                            });

                      var token =
                            $('<input>', {
                              'type':  'hidden',
                              'name':  '_token',
                              'value': Laravel.csrfToken
                            });

                      var hiddenInput =
                            $('<input>', {
                              'name':  '_method',
                              'type':  'hidden',
                              'value': link.data('method')
                            });

                      return form.append(token, hiddenInput)
                                 .appendTo('body');
                    }
      };

      laravel.initialize();
    })();
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
