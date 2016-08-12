// Bootbox
bootbox.setDefaults({backdrop: false});

$("a.confirm-remove").click(function (e) {
  e.preventDefault();
  var location = $(this).attr('href');
  bootbox.dialog({
    title: 'You are about to delete an item',
    message: "This is not reversible.  Are you sure you want to proceed?",
    buttons: {
      success: {
        label: "Yes",
        className: "btn-primary",
        callback: function () {
          window.location.replace(location);
        }
      },
      danger: {
        label: "No",
        className: "btn-primary"
      }
    }
  });
});
$("a.confirm-continue").click(function (e) {
  e.preventDefault();
  var location = $(this).attr('href');
  bootbox.dialog({
    title: 'Verify before continuing',
    message: "Are you sure you want to continue?",
    buttons: {
      danger: {
        label: "No",
        className: "btn-primary"
      },
      success: {
        label: "Yes",
        className: "btn-primary",
        callback: function () {
          window.location.replace(location);
        }
      },
    }
  });
});

// Work around for multi data toggle modal
// http://stackoverflow.com/questions/12286332/twitter-bootstrap-remote-modal-shows-same-content-everytime
$('body').on('hidden.bs.modal', '#modal', function () {
  $(this).removeData('modal');
});
$("div[id$='Modal']").on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});
$("div[id$='modal']").on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

