let bootbox = require('bootbox');

var laravel = {
  initialize: function ()
              {
                this.methodLinks = $('a[data-method]');

                this.registerEvents();
              },

  registerEvents: function ()
                  {
                    this.methodLinks.on('click', this.handleMethod(this));
                  },

  handleMethod: function (e)
                {
                  var link = $(this);

                  if (typeof link.data('method') !== 'undefined') {
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
                  }
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
