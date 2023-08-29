var maxSecenek = 10; 
var secenekSayisi = document.querySelector("#secenek-alanlari").getAttribute('data-option-count') ; 

function addOption() {
    if (secenekSayisi < maxSecenek) {
        secenekSayisi++;
        var yeniSecenek = document.createElement('div');
        yeniSecenek.classList.add("new-option");
        let secenekInput = document.createElement('div');
        secenekInput.classList.add("d-flex", "align-items-center");
        yeniSecenek.innerHTML = '<label class="form-label" for="secenek' + secenekSayisi + '">Seçenek ' + secenekSayisi + '</label>';
        yeniSecenek.appendChild(secenekInput);

        if (secenekSayisi > 2) {
            var inputHtml = '<input class="form-control form-control" type="text" name="option[]" id="secenek' + secenekSayisi + '">' +
                '<button type="button" class="btn d-flex align-items-center btn-danger rounded" onclick="secenekSil(this)"><i class="fas fa-trash-alt me-1"></i> Sil</button>';
            secenekInput.innerHTML = inputHtml;
        } else {
            secenekInput.innerHTML = '<input class="form-control form-control" type="text" name="option[]" id="secenek' + secenekSayisi + '">';
        }

        var errorDiv = document.createElement('div');
        errorDiv.classList.add("error-div");
        errorDiv.textContent = "";
        yeniSecenek.appendChild(errorDiv);
        
        document.getElementById('secenek-alanlari').appendChild(yeniSecenek);
    }
}

function secenekSil(button) {
    secenekSayisi--;

    var secenekDiv = button.parentNode.parentNode;
    secenekDiv.parentNode.removeChild(secenekDiv);

    var secenekler = document.querySelectorAll(".new-option");
    for (var i = 0; i < secenekler.length; i++) {
        var label = secenekler[i].querySelector("label");
        label.innerHTML = "Seçenek " + (i + 1);

        var input = secenekler[i].querySelector("input");
        input.id = "secenek" + (i + 1);
        input.name = "option[]";

        label.innerHTML = "Seçenek " + (i + 1);
    }
}