/*
 <a href="posts/2" data-method="delete"> <---- We want to send an HTTP DELETE request

 - Or, request confirmation in the process -

 <a href="posts/2" data-method="delete" data-confirm="Are you sure?">
 */

let bootbox = require('bootbox');

var laravel = {
  initialize: function ()
              {
                console.log('LOADED');
                this.methodLinks = $('a[data-method]');

                this.registerEvents();
              },

  registerEvents: function ()
                  {
                    console.log('REGISTERING');
                    this.methodLinks.on('click', this.handleMethod(this));
                  },

  handleMethod: function (e)
                {
                  console.log('CLICKED');
                  var link       = $(this);
                  var httpMethod = link.data('method').toUpperCase();
                  var title      = link.data('title');
                  var message    = link.data('message');
                  var backdrop   = link.data('backdrop');
                  var form;

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
                   return bootbox.dialog(
                     {
                       title:    title == null ? 'You are about to delete an item' : title,
                       message:  message == null ? 'This is not reversible.  Are you sure you want to proceed?' : message,
                       backdrop: backdrop == null ? true : backdrop,
                       onEscape: true,
                       buttons:  {
                         success: {
                           label:     "Yes",
                           className: "btn-primary",
                           callback:  function ()
                                      {
                                        var form = laravel.createForm(link);
                                        form.submit();
                                      }
                         },
                         danger:  {
                           label:     "No",
                           className: "btn-primary",
                         }
                       }
                     }
                   );
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
