# 📰 Info Seputar +62

**Portal Berita Digital Modern Berbasis Laravel**

---

## 📖 Deskripsi Project

**Info Seputar +62** adalah platform portal berita berbasis web yang memungkinkan pengguna untuk membaca, mencari, dan berinteraksi dengan berbagai informasi terkini dari berbagai kategori seperti teknologi, politik, dan olahraga.

Aplikasi ini dibangun menggunakan **Laravel (Fullstack)** dengan fokus pada:

* ⚡ Performa cepat
* 🔎 SEO-friendly
* 🧱 Arsitektur scalable

Sistem ini juga menyediakan fitur **manajemen konten untuk penulis dan editor**, sehingga mendukung workflow editorial seperti portal berita profesional.

---

## 🚀 Tech Stack

* **Backend & Frontend**: Laravel 12 (Blade)
* **Database**: MySQL
* **Styling**: Tailwind CSS
* **Auth**: Laravel Breeze
* **Caching (Ready)**: Redis
* **Queue (Ready)**: Laravel Queue

---

## 🧩 Fitur Utama

### 📰 1. Manajemen Konten

* CRUD artikel
* Kategori & tag
* Upload thumbnail
* Status artikel:

  * Draft
  * Review
  * Published
  * Archived
* Schedule publish
* Featured article

---

### 👤 2. User & Role

* Login & Register
* Role:

  * Admin
  * Editor
  * Penulis
* Role-based access control (RBAC)

---

### 🔍 3. Navigasi & Discovery

* Search artikel
* Filter kategori & tag
* Pagination
* Artikel terkait

---

### 💬 4. Engagement

* Komentar (nested reply – max 2 level)
* View count
* Trending artikel

---

### 🖥️ 5. Frontend Experience

* Homepage (headline + latest news)
* Detail artikel
* Halaman kategori
* Responsive design (Tailwind CSS)
* Toast notification (UX feedback)

---

### ⚙️ 6. System & Optimization

* Caching (Redis-ready)
* Queue system (email, image processing)
* SEO optimization:

  * Meta tags
  * Open Graph
  * Sitemap

---

### 🖼️ 7. Media Management

* Upload gambar
* Media library
* Optimasi gambar

---

### 🚀 8. Advanced (Opsional)

* Recommendation system
* Breaking news
* Analytics dashboard
* Multi-language support

---

## 🛠️ Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/info-seputar-62.git
cd info-seputar-62
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit `.env`:

```env
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migration & Seeder

```bash
php artisan migrate --seed
```

### 6. Jalankan Project

```bash
npm run dev
php artisan serve
```

Akses di:

```
http://localhost:8000
```

---

## 👤 Role & Akses

| Role    | Akses                               |
| ------- | ----------------------------------- |
| Admin   | Full akses + manajemen user         |
| Editor  | Review & publish artikel            |
| Penulis | Membuat & mengelola artikel sendiri |

---

## 🧱 Struktur Fitur Berdasarkan Phase

### ✅ Phase 0–4 (Completed)

* Setup project
* CRUD artikel & kategori
* Role & workflow dasar
* UI frontend
* Search & tagging

---

### 🚧 Phase 5 (Current)

* Auth (Login/Register dengan Breeze)
* Role-based redirect
* Middleware protection
* Komentar & engagement

---

### 🔜 Phase 6

* Admin Dashboard
* Manajemen artikel (approve/reject)
* Manajemen user
* Panel Editor & Penulis

---

### 🔜 Phase 7–10

* Optimization (cache, indexing)
* SEO enhancement
* Media management
* Advanced features

---

## 📌 Insight Project

> Tanpa admin panel → hanya blog biasa
> Dengan admin panel + role → sistem portal berita profesional

Project ini dirancang untuk mensimulasikan **workflow editorial nyata** seperti pada platform berita modern.

---

## 📸 Preview (Opsional)

> Tambahkan screenshot di sini (homepage, dashboard, dll)

---

## 👨‍💻 Author

**Muhammad Ilham Setiawan**

* 📧 [m.ilsetiawan1@gmail.com](mailto:m.ilsetiawan1@gmail.com)
* 🔗 [LinkedIn](https://www.linkedin.com/in/muhammad-ilham-setiawan)
* 📸 Instagram: @ilsetiawann

---
