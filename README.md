# Stunting Prediction
## Laravel Web Application with FastAPI Machine Learning Integration

Repositori ini merupakan hasil pengembangan dari proyek **Dev_Weekend_WD** yang diberikan pada kegiatan **Dev Weekend**.

Pengembangan difokuskan pada peningkatan kualitas aplikasi dari sisi **keamanan, arsitektur perangkat lunak, pengalaman pengguna,** serta **integrasi Machine Learning**, tanpa mengubah tujuan utama aplikasi sebagai sistem prediksi risiko stunting pada balita.

---

## Repository Terkait

Proyek ini terdiri dari dua repositori yang saling terintegrasi.

### 1. Repository Aplikasi Web (Laravel)

Repository ini berisi pengembangan aplikasi web yang meliputi:

- Laravel Breeze Authentication
- Dashboard
- Riwayat Prediksi
- Integrasi FastAPI
- Manajemen Data
- UI/UX
- Routing & Authorization

### 2. Repository Machine Learning

Repository Machine Learning berisi seluruh proses pengembangan model, mulai dari:

- Exploratory Data Analysis (EDA)
- Investigasi Data Leakage
- Penghapusan fitur `risk_score`
- Hyperparameter Tuning
- Perbandingan beberapa algoritma Machine Learning
- Evaluasi Model
- Deployment menggunakan FastAPI

Repository Machine Learning:

**https://github.com/Najiann/Stunting_Model_ML**

---

## Disclaimer

Repositori ini dikembangkan sebagai hasil pembelajaran dan pengembangan pribadi berdasarkan proyek awal yang disediakan oleh mentor pada kegiatan Dev Weekend.

Selama proses pengembangan, penulis memanfaatkan **Artificial Intelligence (AI)**, termasuk **ChatGPT**, sebagai **asisten pengembangan** untuk membantu berbagai aktivitas, seperti:

- memahami dokumentasi framework
- brainstorming solusi
- debugging
- penjelasan konsep
- penyusunan dokumentasi
- pemberian saran implementasi

Seluruh keputusan arsitektur sistem, implementasi fitur, pengembangan model Machine Learning, proses debugging, pengujian, validasi hasil, hingga kode akhir tetap dilakukan, ditinjau, dan diputuskan oleh penulis. AI digunakan sebagai alat bantu selama proses pengembangan, bukan sebagai pengganti pengembang.

---

# Ringkasan Perubahan

| Aspek | Versi Awal (Dev_Weekend_WD) | Versi Pengembangan |
|------|------|------|
| Autentikasi | Tidak ada | Laravel Breeze (Login, Register, Verifikasi Email, Reset Password) |
| Kepemilikan Data | Seluruh pengguna dapat melihat semua data | Data dipisahkan berdasarkan `user_id` |
| Otorisasi | Tidak ada | Validasi kepemilikan data menggunakan HTTP 403 |
| Routing | Manual | RESTful `Route::resource()` |
| CRUD | Create & Read | Create, Read, Delete |
| Riwayat Prediksi | Tabel sederhana | Search, Filter, Pagination, Statistik |
| Integrasi Machine Learning | Menggunakan `risk_score` | `risk_score` dihapus dari seluruh alur prediksi |
| API Service | Penanganan error dasar | Validasi response, Exception Handling, Timeout |
| UI | Halaman Blade sederhana | Layout, Components, Tailwind CSS, Vite |
| Landing Page | Tidak ada | Landing Page kustom |
| Database | `patient_id` | `user_id` + Foreign Key |

---

# Detail Pengembangan

## 1. Sistem Autentikasi

### Perubahan

Menambahkan Laravel Breeze sehingga aplikasi memiliki fitur:

- Login
- Register
- Verifikasi Email
- Reset Password
- Konfirmasi Password

### Alasan

Data yang diproses merupakan data kesehatan balita sehingga akses aplikasi perlu dibatasi kepada pengguna yang telah terautentikasi.

---

## 2. Kepemilikan Data Berdasarkan Pengguna

### Perubahan

- Mengganti `patient_id` menjadi `user_id`
- Menambahkan relasi Foreign Key
- Riwayat prediksi hanya dapat diakses oleh pemilik akun
- Menambahkan validasi kepemilikan pada `show()` dan `destroy()`

### Alasan

Perubahan ini dilakukan untuk menjaga privasi data serta mencegah kerentanan **Insecure Direct Object Reference (IDOR)**, yaitu kondisi ketika pengguna dapat mengakses data milik pengguna lain hanya dengan memanipulasi URL.

---

## 3. Routing RESTful

### Perubahan

Routing diubah dari definisi manual menjadi Resource Route Laravel.

```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('stunting', StuntingPredictionController::class);
});
```

### Alasan

Mengikuti standar Laravel sehingga struktur aplikasi lebih rapi, mengurangi duplikasi kode, dan mempermudah pengembangan fitur selanjutnya.

---

## 4. Riwayat Prediksi

### Perubahan

Menambahkan fitur:

- Pencarian berdasarkan nama balita
- Filter status prediksi
- Pagination
- Statistik jumlah prediksi
- Statistik jumlah stunting
- Statistik jumlah tidak stunting

### Alasan

Semakin banyak data yang tersimpan, semakin penting kemampuan mencari dan memfilter data agar aplikasi tetap mudah digunakan.

---

## 5. Penghapusan `risk_score`

### Perubahan

Field `risk_score` dihapus dari:

- Database
- Migration
- Model
- Form Input
- Validation
- Controller
- Payload FastAPI
- Alur Machine Learning

### Alasan

`risk_score` merupakan nilai turunan yang seharusnya dihasilkan oleh sistem, bukan dimasukkan secara manual oleh pengguna. Penghapusan field ini juga membuat proses input menjadi lebih sederhana dan mengurangi potensi kesalahan pengguna.

Untuk penjelasan teknis mengenai perubahan model Machine Learning, investigasi data leakage, serta alasan penghapusan `risk_score`, silakan melihat repository Machine Learning yang terpisah.

---

## 6. Peningkatan Integrasi FastAPI

### Perubahan

- Menambahkan `ConnectionException`
- Validasi struktur response API
- Optimasi timeout
- Pembulatan probabilitas prediksi

### Alasan

Aplikasi menjadi lebih stabil ketika server Machine Learning tidak aktif ataupun mengembalikan response yang tidak sesuai.

---

## 7. Penyempurnaan Antarmuka

### Perubahan

- Blade Layout
- Blade Components
- Tailwind CSS
- Vite
- Landing Page
- Design System

### Alasan

Mengurangi duplikasi kode, meningkatkan konsistensi tampilan, serta mempermudah proses maintenance.

---

## 8. Otorisasi

### Perubahan

Menambahkan validasi kepemilikan data sebelum pengguna dapat melihat maupun menghapus riwayat prediksi.

### Alasan

Mencegah akses data melalui manipulasi URL sehingga data pengguna tetap terlindungi.

---

## 9. Fitur Hapus Data

### Perubahan

Menambahkan fitur penghapusan riwayat prediksi.

### Alasan

Memberikan pengguna kemampuan menghapus data yang salah input ataupun data hasil pengujian.

---

## Pengembangan Selanjutnya

Beberapa fitur yang masih dapat dikembangkan pada aplikasi ini antara lain:

- Edit data prediksi
- Update data prediksi
- Role Management (Admin & User)
- Export PDF
- Export Excel
- Dashboard Admin
- Monitoring penggunaan model Machine Learning

---

## Kesimpulan

Versi pengembangan ini mempertahankan alur utama prediksi stunting dari proyek awal, kemudian meningkatkan kualitas aplikasi dari berbagai aspek, meliputi:

- Keamanan dan privasi data.
- Kualitas rekayasa perangkat lunak.
- Pengalaman pengguna.
- Integrasi Machine Learning yang lebih baik.

Dengan berbagai pengembangan tersebut, aplikasi tidak hanya berfungsi sebagai *proof of concept*, tetapi juga lebih mendekati implementasi aplikasi yang aman, terstruktur, mudah dikembangkan, dan siap digunakan oleh banyak pengguna.

---

## Teknologi yang Digunakan

### Backend

- Laravel 12
- PHP 8
- MySQL

### Frontend

- Blade
- Tailwind CSS
- Alpine.js
- Vite

### Machine Learning

- FastAPI
- Scikit-Learn
- Pandas
- NumPy
- Joblib

### Tools

- Composer
- Node.js
- npm
- Git
- GitHub
