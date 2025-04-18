# 💰 Web Kasir (POS System) with Multi-Role Access

A responsive web-based Point of Sale (POS) system designed for small businesses. Built using **HTML, CSS, JavaScript, PHP**, and **MySQL**, this system allows efficient transaction handling by **cashiers (pegawai)** and **supervisory control by managers (atasan)**. The platform includes sales tracking, real-time reporting, printable receipts, and Excel export support.

---

## 🚀 Features

### 👨‍💼 Pegawai (Cashier)

- 🧮 **Kalkulasi Otomatis** — Hitung total pembayaran pelanggan dengan otomatisasi per item.  
- 🧾 **Cetak Struk** — Hasil transaksi bisa langsung dicetak dalam bentuk struk.  
- 🔐 **Akses Terbatas** — Pegawai hanya dapat melakukan kalkulasi dan mencetak struk, tanpa akses ke data keuangan.

### 🧑‍💼 Atasan (Manager)

- 📊 **Laporan Harian** — Melihat total pemasukan dan pengeluaran setiap hari.  
- 📂 **Export Excel** — Unduh data pemasukan dalam format Excel (.xlsx) untuk pembukuan.  
- 📈 **Riwayat Transaksi** — Akses ke seluruh aktivitas kasir yang telah dilakukan.  

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  
- **Export Tool**: PHPSpreadsheet (untuk export Excel)

---

## 🔐 User Roles

| Role     | Access Rights                                      |
|----------|----------------------------------------------------|
| Pegawai  | Kalkulasi transaksi, cetak struk                   |
| Atasan   | Lihat laporan pemasukan/pengeluaran, export Excel |

---

## 📂 Folder Structure

📁 web-kasir/  
├── 📁 css/               → Styling files  
├── 📁 js/                → JavaScript interaction  
├── 📁 php/               → PHP backend scripts  
│   ├── login.php         → Login & auth  
│   ├── transaksi.php     → Transaksi & struk  
│   ├── laporan.php       → Laporan harian  
│   ├── export_excel.php  → Export ke Excel  
├── 📁 views/             → Halaman UI untuk pegawai & atasan  
├── 📁 assets/            → Icons, images, etc.  
├── 📄 index.php          → Halaman login  
├── 📄 db_config.php      → Koneksi database  
├── 📄 database.sql       → Struktur & sample data  
└── 📄 README.md          → Dokumentasi proyek  

---

## ⚙️ Installation & Setup

### 1. Clone this repository

```bash
git clone https://github.com/clementhermawan/Website-Kasir.git
```

### 2. Import database

- Buka `phpMyAdmin`  
- Buat database baru, misalnya `kasir_app`  
- Import file `database.sql`

### 3. Konfigurasi database

Edit `db_config.php`:

```php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kasir_app";
```

### 4. Jalankan di server lokal

- Gunakan XAMPP, MAMP, atau WAMP  
- Taruh folder proyek di `htdocs`  
- Akses via browser: `http://localhost/web-kasir/`

---

## 📸 Screenshots

_**Tambahkan gambar di sini yang menunjukkan tampilan halaman pegawai, halaman atasan, dan contoh struk.**_

---

## 📊 Example Use Case

1. Pegawai login ke sistem dan mulai mencatat transaksi pelanggan.
2. Setelah transaksi selesai, pegawai mencetak struk langsung dari halaman.
3. Atasan login dan melihat semua pemasukan hari ini, pengeluaran, dan bisa mengekspor ke Excel untuk laporan keuangan.

---

## 📌 Future Enhancements

- [ ] Tambah laporan mingguan & bulanan  
- [ ] Grafik visual untuk statistik penjualan  
- [ ] Role tambahan (admin, gudang, dll)  
- [ ] Integrasi dengan printer Bluetooth  

---

## 🙋‍♂️ Author

**Your Name**  
GitHub: [@clementhermawan](https://github.com/clementhermawan)

---

## 📄 License

This project is licensed under the MIT License – see the [LICENSE](https://github.com/clementhermawan/Licensi) file for details.

---
