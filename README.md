# 🎮 Capibara Games - Gaming Portfolio & Blog

> Personal gaming portfolio and blog platform with a secure, modern admin panel built from scratch.

[![PHP](https://img.shields.io/badge/PHP-7.4-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![DaisyUI](https://img.shields.io/badge/DaisyUI-4.6-5A0EF8?style=flat&logo=daisyui&logoColor=white)](https://daisyui.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Security](#-security)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Project Structure](#-project-structure)
- [Development](#-development)
- [Deployment](#-deployment)
- [License](#-license)

---

## 🎯 Overview

**Capibara Games** is a full-stack web application designed to showcase indie game development projects and share blog content. The project demonstrates modern web development practices, security implementation, and infrastructure management from the ground up.

### Key Highlights

- 🏗️ **Complete Infrastructure Setup** - Deployed on Proxmox container with LAMP stack
- 🔒 **Security-First Approach** - 36+ security implementations (CSRF, XSS, SQL injection prevention)
- 🎨 **Modern Admin Panel** - Migrated to DaisyUI/Tailwind CSS with custom branding
- 📝 **Markdown Blog System** - With auto-save and live preview
- 🎮 **Game Portfolio** - Showcase projects with metadata and Itch.io integration
- 👥 **Multi-User System** - Role-based access control (Admin/Editor)

---

## ✨ Features

### Public Website
- 🏠 **Homepage** - Hero section with featured games
- 📰 **Blog System** - Markdown-powered articles with syntax highlighting
- 🎮 **Games Portfolio** - Grid showcase with project details
- 👤 **About Page** - Personal introduction and skills
- 📧 **Contact Form** - Secure message handling

### Admin Panel
- 🔐 **Secure Authentication** - Session-based login with CSRF protection
- 📊 **Dashboard** - Statistics and quick actions
- ✍️ **Posts Management**
  - Create/Edit/Delete articles
  - Markdown editor (EasyMDE)
  - Auto-save every 30 seconds
  - Image upload with preview
  - Bulk actions (publish/delete)
  - Search and filters
- 🎯 **Games Management**
  - CRUD operations
  - Image upload
  - Itch.io URL integration
  - Release date tracking
- 👥 **Users Management**
  - Create/Edit/Delete users
  - Role assignment (Admin/Editor)
  - Password hashing (bcrypt)
  - Self-protection (can't delete yourself)

---

## 🛠️ Tech Stack

### Backend
- **PHP 7.4** - Server-side logic
- **MySQL 8.0** - Database management
- **PDO** - Prepared statements for SQL security
- **Apache 2.4** - Web server

### Frontend
- **HTML5/CSS3** - Semantic markup and modern styling
- **Tailwind CSS 3.x** - Utility-first framework
- **DaisyUI 4.6** - Component library for admin panel
- **JavaScript (Vanilla)** - Client-side interactions
- **EasyMDE** - Markdown editor

### Libraries & Tools
- **Parsedown** - Markdown parsing
- **Git** - Version control
- **Proxmox** - Container deployment

### Infrastructure
- **Proxmox CT** - Containerized environment
- **LAMP Stack** - Linux, Apache, MySQL, PHP
- **Git** - Version control and deployment

---

## 🔒 Security

Security is a top priority. The project implements industry best practices:

### Implemented Measures

✅ **CSRF Protection**
- Tokens on all forms (11+ implementations)
- Server-side validation
- Token regeneration per session

✅ **XSS Prevention**
- Output escaping with `htmlspecialchars()` (25+ locations)
- `ENT_QUOTES` flag for JavaScript contexts
- Content Security Policy ready

✅ **SQL Injection Prevention**
- 100% prepared statements
- Parameter binding
- No direct SQL concatenation

✅ **Secure File Uploads**
- MIME type validation (via `finfo`)
- Extension whitelist (jpg, jpeg, png, gif, webp)
- Unique filename generation
- Size limits enforced

✅ **Authentication & Session Security**
- Session-based authentication
- Password hashing (bcrypt)
- Protected admin routes
- Secure logout

✅ **Additional Security**
- Input validation
- Error handling without information leakage
- Directory traversal prevention
- HTTP-only cookies (recommended)

### Security Audit

A comprehensive security review was conducted, documenting all measures and verifying zero security regressions during the admin panel migration.

📄 **[View Security Review](docs/security_review.md)**

---

## 📸 Screenshots

### Public Website

**Homepage**
> Hero section with featured games and retro aesthetic

**Blog**
> Markdown articles with syntax highlighting and proper formatting

**Games Portfolio**
> Grid showcase of game projects with details

### Admin Panel

**Dashboard**
> Statistics cards and quick actions with modern DaisyUI components

**Posts Management**
> Create/edit articles with EasyMDE markdown editor and auto-save

**Games Management**
> CRUD interface for game portfolio items

**Users Management**
> Role-based user administration

*(Add actual screenshots in a `/docs/screenshots/` folder)*

---

## 🚀 Installation

### Prerequisites

- PHP 7.4+
- MySQL 8.0+
- Apache 2.4+
- Git

### Local Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/LuisEnriquePH/capibaragames.com.git
   cd capibaragames.com
   ```

2. **Database Setup**
   ```bash
   mysql -u root -p
   CREATE DATABASE capibaragames;
   USE capibaragames;
   SOURCE database/schema.sql;
   ```

3. **Configure Database Connection**
   ```bash
   cp includes/db.example.php includes/db.php
   # Edit db.php with your credentials
   ```

4. **Set Permissions**
   ```bash
   chmod 775 assets/uploads/posts/
   chmod 775 assets/uploads/games/
   chown -R www-data:www-data assets/uploads/
   ```

5. **Access the Site**
   ```
   Public: http://localhost/capibaragames.com
   Admin: http://localhost/capibaragames.com/admin
   ```

### Default Credentials

```
Username: admin
Password: [set during installation]
```

---

## 📁 Project Structure

```
capibaragames.com/
├── admin/                      # Admin panel
│   ├── includes/              # Headers, auth, CSRF, upload
│   ├── posts/                 # Posts CRUD
│   ├── games/                 # Games CRUD
│   ├── users/                 # Users CRUD
│   └── js/                    # Admin JavaScript
├── assets/
│   └── uploads/               # User-uploaded images
│       ├── posts/
│       └── games/
├── css/                       # Stylesheets
│   ├── base.css              # Variables & reset
│   ├── layout.css            # Layout components
│   ├── components.css        # Reusable components
│   └── pages.css             # Page-specific styles
├── includes/                  # Shared includes
│   ├── db.php                # Database connection
│   ├── header.php            # Public header
│   ├── footer.php            # Public footer
│   └── Parsedown.php         # Markdown parser
├── database/
│   └── schema.sql            # Database structure
├── index.php                  # Homepage
├── blog.php                   # Blog listing
├── post.php                   # Single post view
├── games.php                  # Games portfolio
├── about.php                  # About page
└── contact.php                # Contact form
```

---

## 💻 Development

### Git Workflow

This project uses Git Flow with feature branches:

```bash
# Main branches
main                           # Production-ready code
feature/daisyui-redesign      # Admin panel migration
```

### Recent Major Updates

- ✅ **Admin Panel Migration to DaisyUI** - Modern component library
- ✅ **Security Audit** - Comprehensive review and documentation
- ✅ **Brand Theming** - Custom Capibara green color scheme
- ✅ **Markdown Content Styling** - Improved blog post formatting

### Making Changes

1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Commit with descriptive messages
5. Push and create pull request

---

## 🌐 Deployment

### Production Checklist

Before deploying to production:

- [ ] Build Tailwind CSS locally (remove CDN)
  ```bash
  npm install -D tailwindcss daisyui
  npx tailwindcss -i ./admin/css/input.css -o ./admin/css/output.min.css --minify
  ```
- [ ] Verify database credentials
- [ ] Set upload directory permissions
- [ ] Enable HTTPS
- [ ] Configure secure cookie flags
- [ ] Disable error display (`display_errors = Off`)
- [ ] Test all CRUD operations
- [ ] Run security verification

### Deployment Options

- **Shared Hosting** (HostGator, etc.)
- **VPS** (DigitalOcean, Linode)
- **Proxmox Container** (Current setup)

---

## 📊 Performance

### Metrics (Development Environment)

- **Page Load**: 320-650ms
- **Database Queries**: <1ms average
- **Memory Usage**: 2-3MB per request
- **Code Quality**: 2000+ lines, well-documented

### Optimization Notes

For production, consider:
- Build Tailwind locally (reduces ~350KB)
- Enable output compression
- Implement browser caching
- Use CDN for static assets

📄 **[View Performance Review](docs/performance_review.md)**

---

## 🤝 Contributing

This is a personal portfolio project, but feedback and suggestions are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👤 Author

**Luis Enrique**

- Website: [capibaragames.com](https://capibaragames.com)
- GitHub: [@LuisEnriquePH](https://github.com/LuisEnriquePH)
- LinkedIn: [LinkedIn](https://www.linkedin.com/in/luispinah/)

---

## 🙏 Acknowledgments

- **Tailwind CSS** - Utility-first CSS framework
- **DaisyUI** - Beautiful component library
- **EasyMDE** - Simple and embeddable markdown editor
- **Parsedown** - Markdown parser for PHP

---

## 📈 Project Stats

![GitHub last commit](https://img.shields.io/github/last-commit/LuisEnriquePH/capibaragames.com)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/LuisEnriquePH/capibaragames.com)
![GitHub code size](https://img.shields.io/github/languages/code-size/LuisEnriquePH/capibaragames.com)

---

## 👤 Use of IA

- Layout
- Coding 

<div align="center">

### ⭐ Star this repo if you find it useful!

**Made with ❤️ and ☕ by Luis Enrique**

</div>
