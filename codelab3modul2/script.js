const form = document.getElementById('registrationForm');

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const alamat = document.getElementById('alamat').value.trim();
    
    if (!nama || !email || !alamat) {
        alert("Data tidak boleh kosong!"); // Menggunakan alert bawaan dari Chrome
    } else {
        alert('Form berhasil disubmit!');
        this.reset();
    }
});

// Show alert when user tries to input only spaces
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim() === '' && this.value !== '') {
            this.value = '';
            alert("Data tidak boleh kosong!"); 
        }
    });
});
