require('./bootstrap');

$('#editFormModal').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');
    var task = button.data('task');
    var owner = button.data('owner');
    var status = button.data('status');

    var modal = $(this)
    modal.find('.modal-body input[name=id]').val(id);
    modal.find('.modal-body input[name=task]').val(task);
    modal.find('.modal-body input[name=owner]').val(owner);
    modal.find('.modal-body select[name=status]').selectedIndex = statusIndex(status);
  })

  function statusIndex(status) {
    if (status.localeCompare('Working on'))
      return 0
    return 1
  }