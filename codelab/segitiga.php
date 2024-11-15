<?php
    $star = 5; // Jumlah baris
    echo "Segitiga sama sisi :<br><br>";

    for ($a = 1; $a <= $star; $a++) {
        // Loop untuk membuat spasi di sebelah kiri
        for ($i = $star - $a; $i > 0; $i--) {
            echo "&nbsp;&nbsp;"; // Menggunakan dua &nbsp; untuk membuat spasi lebih lebar
        }
        // Loop untuk mencetak bintang
        for ($j = 1; $j <= (2 * $a - 1); $j++) {
            echo "*";
        }
        // Pindah ke baris berikutnya
        echo "<br>";
    }
    echo "<br>";
    echo "<br>";
    echo "<br>";

    echo "Segitiga sama sisi (terkena uno reverse card) :<br><br>";

    for ($a = $star; $a > 0; $a--) {
        // Loop untuk membuat spasi di sebelah kiri
        for ($i = 0; $i < $star - $a; $i++) {
            echo "&nbsp;&nbsp;"; // Menggunakan dua &nbsp; untuk membuat spasi lebih lebar
        }
        // Loop untuk mencetak bintang
        for ($j = 1; $j <= (2 * $a - 1); $j++) {
            echo "*";
        }
        // Pindah ke baris berikutnya
        echo "<br>";
    }
?>
