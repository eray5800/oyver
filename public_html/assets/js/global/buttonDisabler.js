function disableButton(button) {
    if (!button.disabled) {
        button.disabled = true;
    }
}

function submitForm(event) {
    event.preventDefault();
    var button = event.target;
    disableButton(button);
    var form = button.closest("form");
    form.submit(); 
}