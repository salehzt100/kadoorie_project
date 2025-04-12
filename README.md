# 🎓 Kadoori Project API

This is a RESTful API backend built with **Laravel 12** to manage university graduation projects. It allows admins to manage students, supervisors, faculty departments, project categories, and upload project files such as posters, theses, and videos via **Cloudinary**.

---

## 🚀 Features

- 🔐 Sanctum Authentication (Login/Logout)
- 📦 CRUD APIs for:
  - Students
  - Supervisors
  - Projects
  - Categories
  - Faculty Departments
- ☁️ Cloudinary integration for:
  - Image uploads
  - Thesis, Poster, and Video file management
- 📘 JSON API responses via Laravel Resources
- 🧩 RESTful resource controllers
- 👮 Role-based access for `admin` users

---

## 🔐 Public Endpoints

The following routes are publicly accessible:

POST /api/login
GET /api/projects
GET /api/projects/{id} 
GET /api/students 
GET /api/students/{id} 
GET /api/supervisors 
GET /api/supervisors/{id} 
GET /api/categories 
GET /api/categories/{id} 
GET /api/faculty-departments 
GET /api/faculty-departments/{id}


📁 Environment Configuration

Edit your .env file with the following values:

🔧 App Settings

```env
APP_NAME=KadooriProject
APP_ENV=production
APP_DEBUG=true
APP_URL=http://your-domain.com
```

☁️ Cloudinary Settings

```env
CLOUDINARY_URL=cloudinary://892442654887776:pos909VjrxaTU-HIe0uUuUWCTI0@dibxzbef5
CLOUDINARY_CLOUD_NAME=dibxzbef5
CLOUDINARY_API_KEY=892442654887776
CLOUDINARY_API_SECRET=pos909VjrxaTU-HIe0uUuUWCTI0
```
These credentials are used for uploading and managing files on Cloudinary.



📦 Installation Steps

```env
git clone https://github.com/salehzt100/kadoorie_project.git
cd kadoorie_project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
