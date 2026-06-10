# 📑 Sistem Informasi Surat Digital & Pengaduan Masyarakat Desa Blahbatuh

---

## 📖 Deskripsi
Aplikasi berbasis web untuk mendukung **transformasi digital pelayanan publik desa**, mengintegrasikan:
- Administrasi surat digital
- Pengelolaan pengaduan masyarakat

Tujuan utama adalah menjadikan proses pelayanan lebih **efektif, efisien, terstruktur, terdokumentasi, dan transparan**.

---

## 🎯 Tujuan
- Integrasi layanan administrasi desa dalam satu platform web  
- Efisiensi proses surat-menyurat  
- Dokumentasi pengaduan masyarakat  
- Transparansi & akuntabilitas pelayanan publik  
- Monitoring & evaluasi kinerja desa  

---

## 👥 Role Pengguna
- **Warga** → Mengirim pengaduan, cek status via email/notifikasi  
- **Kepala Dusun (Kadus)** → Input permohonan surat, verifikasi pengaduan  
- **Admin Desa** → Verifikasi permohonan, generate surat digital, arsip  
- **Super Admin** → Monitoring global, manajemen user & template surat  

---

## 🚀 Fitur Utama
### 📩 Pengaduan Masyarakat
- Form online + upload bukti (foto)  
- Validasi lokasi (Geolocation API)  
- Status: **Pending, Diproses, Selesai, Ditolak**  
- Notifikasi email otomatis  

### 📄 Surat Digital
- Input permohonan oleh Kadus  
- Verifikasi Admin  
- Generate surat otomatis (template)  
- Arsip digital + cetak manual  

### 📊 Monitoring
- Dashboard Super Admin  
- Monitoring pengaduan seluruh dusun  
- Manajemen user & arsip  

---

## 🏗️ Arsitektur
- **Pattern**: MVC (Model-View-Controller)  
- **Framework**: CodeIgniter 3  

---

## 🛠️ Teknologi
- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript (ES6)  
- **Backend**: PHP 8.2, CodeIgniter 3.1.13  
- **Database**: MySQL 8.0, phpMyAdmin  
- **Tools**: Geolocation API, SMTP Email, Apache/XAMPP/cPanel  

---

## 🔄 Alur Sistem
### 🔹 Pengaduan
1. Warga isi form → validasi data & lokasi  
2. Data masuk DB (status: Pending)  
3. Notifikasi ke Kadus 
4. Kadus verifikasi → status update  
5. Email notifikasi ke warga  

### 🔹 Surat Digital
1. Kadus input permohonan  
2. Admin verifikasi data  
3. Generate nomor & template surat  
4. Cetak & sahkan manual  
5. Arsip tersimpan  

---

## ⚠️ Batasan
- Berbasis web (tidak ada aplikasi mobile)  
- Belum ada WhatsApp/SMS Gateway  
- Tidak menggunakan tanda tangan digital  
- Validasi lokasi bergantung browser  
- Surat tetap memerlukan tanda tangan manual  
- Keamanan masih pada level autentikasi dasar  

---

## 📈 Manfaat
- Pelayanan administrasi lebih cepat  
- Minim kesalahan pencatatan  
- Arsip & pencarian dokumen lebih mudah  
- Transparansi pelayanan publik meningkat  
- Basis evaluasi kinerja desa  

---

## 👨‍💻 Developer
- **I Ketut Supranatha**  
- **Made Aditya Widarma**  
- **Ni Nengah Visca Dwipayanti**  

Program Studi **Manajemen Informatika**  
Politeknik Negeri Bali  
