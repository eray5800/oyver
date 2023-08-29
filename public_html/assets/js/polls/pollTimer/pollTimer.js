function geriSayimYap(poolId) {
    // Zaman değerini al
    var poolEndTime = document.querySelector('#pool-' + poolId).dataset.pollEndTime;
    if (poolEndTime == null || isNaN(new Date(poolEndTime))) {
        return; // Eğer gelen değerler null veya geçersiz bir tarih ise fonksiyondan çık
    }
    
    var zamanDegeri = new Date(poolEndTime).getTime();
 
    // Geçmiş bir tarih ise
    if (zamanDegeri < new Date().getTime()) {
        document.getElementById('pool-' + poolId).innerHTML = 'Zaman doldu!';
        return;
    }
 
    // Geri sayım işlemini yap
    var fonksiyon = function () {
        var simdikiZaman = new Date().getTime();
        var fark = zamanDegeri - simdikiZaman;
 
        // Yıl bilgisini hesapla
        var yil = Math.floor(fark / (1000 * 60 * 60 * 24 * 365));
        fark = fark % (1000 * 60 * 60 * 24 * 365);
 
        // Zamanı hesapla
        var gun = Math.floor(fark / (1000 * 60 * 60 * 24));
        var saat = Math.floor((fark % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var dakika = Math.floor((fark % (1000 * 60 * 60)) / (1000 * 60));
        var saniye = Math.floor((fark % (1000 * 60)) / 1000);
 
        // Zamanı ekrana yazdır
        var zamanMetni = '';
        zamanMetni += yil > 0 ? yil + ' Yıl ' : '';
        zamanMetni += gun > 0 ? gun + ' Gün ' : '';
        zamanMetni += saat > 0 ? saat + ' Saat ' : '';
        zamanMetni += dakika > 0 ? dakika + ' Dakika ' : '';
        zamanMetni += saniye + ' Saniye ';
 
        document.getElementById('pool-' + poolId).innerHTML = zamanMetni;
 
        // Eğer zaman dolarsa geri sayımı durdur
        if (fark <= 0) {
            clearInterval(interval);
        }
    }
 
     fonksiyon();
     var interval = setInterval(fonksiyon, 1000);
 }
 
 var pools = document.querySelectorAll('.poll');
 
     pools.forEach(function(pool){
         geriSayimYap(pool.dataset.pollId);
     });