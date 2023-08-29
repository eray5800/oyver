const applyButtons = document.querySelectorAll('.apply-btn');
if(applyButtons) {
  applyButtons.forEach(button => {
    button.addEventListener('click', () => {
      const groupId = button.dataset.groupid;
      const formAction = `/group/application/create/${groupId}`;
      document.querySelector('#confirm-modal form').action = formAction;
    });
  });
}