        <h5 class="time" id="time" style="color:azure">
            <?php  
            date_default_timezone_set('Asia/Jakarta');
            echo date (" d F Y | l, h:i T"); 
            ?>
        </h5>
        <script>
        function updateTime() {
            const timeElement = document.getElementById('time');
            const now = new Date();  // Mendapatkan waktu saat ini
            
            // Mendapatkan komponen-komponen waktu
            const day = String(now.getDate()).padStart(2, '0');  // Hari (01-31)
            const month = now.toLocaleString('default', { month: 'short' });  // Bulan dalam format singkat (Jan, Feb, dll.)
            const year = now.getFullYear();  // Tahun (misalnya 2024)
            const hours = now.getHours();  // Jam (0-23)
            const minutes = String(now.getMinutes()).padStart(2, '0');  // Menit (00-59)
            const seconds = String(now.getSeconds()).padStart(2, '0');  // Detik (00-59)
            const period = hours >= 12 ? 'PM' : 'AM';  // Menentukan AM/PM
            const displayHours = (hours % 12) || 12;  // Jam dalam format 12-jam (1-12)

            // Format string waktu yang ditampilkan
            const formattedTime = `${day} ${month} ${year} | ${now.toLocaleDateString('en-US', { weekday: 'long' })}, ${displayHours}:${minutes}:${seconds} ${period}`;
            
            timeElement.textContent = formattedTime;  // Mengatur teks elemen dengan id 'time'
        }

        setInterval(updateTime, 1000);  // Memperbarui waktu setiap detik
        updateTime();
        </script>