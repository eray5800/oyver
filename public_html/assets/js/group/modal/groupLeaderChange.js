const editButtons = document.querySelectorAll('.edit-btn');
editButtons.forEach(button => {
  button.addEventListener('click', () => {
    const userId = button.dataset.userid;
    const formAction = `/group/changeleader/${userId}`;
    document.querySelector('#confirm-modal form').action = formAction;
  });
});
