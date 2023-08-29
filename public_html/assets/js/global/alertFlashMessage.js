var perfEntries = performance.getEntriesByType("navigation");
var result = true;
for (var i = 0; i < perfEntries.length; i++) {
    if(perfEntries[i].type === "back_forward") {
        result = false;
    }
}

if(result) {
    setTimeout(function() {
        const flashMessage = document.getElementById('flashMessageDiv');
        setTimeout(function() {
            flashMessage.remove();
        }, 1000);
    }, 3000);
}
if(!result) {
    const flashMessage = document.getElementById('flashMessageDiv');
    flashMessage.remove();
}