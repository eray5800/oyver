
  document.addEventListener('DOMContentLoaded', function() {
    var normalContainers = document.querySelectorAll('.normal-container');
    var formContainers = document.querySelectorAll('.form-container');

    var editBtns = document.querySelectorAll('.edit-btn');
    var cancelBtns = document.querySelectorAll('.cancel-btn');

    for (var i = 0; i < editBtns.length; i++) {
      editBtns[i].addEventListener('click', function() {
        var index = Array.from(editBtns).indexOf(this);

        normalContainers[index].classList.add("d-none");
        formContainers[index].classList.add("d-md-flex");
        formContainers[index].classList.remove("d-none");
      });
    }

    for (var i = 0; i < cancelBtns.length; i++) {
      cancelBtns[i].addEventListener('click', function() {
        var index = Array.from(cancelBtns).indexOf(this);

        normalContainers[index].classList.remove("d-none");
        formContainers[index].classList.add("d-none");
        formContainers[index].classList.remove("d-md-flex");
      });
    }
  });