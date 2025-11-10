# Paperari (CI3 Lightweight Sections Library)

**Paperari** is a lightweight, **CodeIgniter 3** library project for organizing content in multiple sections such as **Books**, **Tutorials**, or **Lyrics**. It supports Markdown and PHP rendering, site-wide search, sitemap generation, and stateless password protection.

It uses **[PaperCSS](https://www.papercss.com/)** template for a clean, minimal UI.

---

## Features

* Multi-section support: Books, Tutorials, Lyrics, or any custom sections you define.
* Organizes content into volumes and chapters using Markdown.
* Flexible base templates: header, footer, and hero section.
* Static folder for CSS, JS, and images.
* Optional pages without header/footer using `Page.php`.
* Site-wide search and sitemap across all defined sections.
* Stateless password protection using a single cookie (`access_token`).
* Dark/light mode, clean Markdown rendering, and optional TOC/prev-next navigation.

---

## Requirements

* **CodeIgniter 3.x.x**
* **PHP 7.x+**
* Optional: **Parsedown** for Markdown parsing ([parsedown.org](https://parsedown.org/))
* PaperCSS template (credit included)

---

## 1️⃣ Controllers

| Controller                    | Purpose                                                                      |
| ----------------------------- | ---------------------------------------------------------------------------- |
| `Books.php`                   | Handles sections like Books, Tutorials, Lyrics. Nested Markdown/PHP content. |
| `Page.php`                    | Standalone PHP pages without header/footer (`/page/static/column`).          |
| `Errors.php`                  | Custom 404 handler (`page_missing()`).                                       |
| `Search.php`                  | Site-wide search page across all sections.                                   |
| `Sitemap.php`                 | Sitemap page showing all sections and items.                                 |
| `Auth.php`                    | Password-protects the site using a stateless cookie. The default             |
|                               |   password is set to "q", and it can be changed in the `Auth.php` file.      |

---

## 2️⃣ Routing Overview (`routes.php`)

| Route                 | Maps to               | Notes                                      |
| --------------------- | --------------------- | ------------------------------------------ |
| `/page/(:any)/(:any)` | `Page/view/$1/$2`     | Standalone PHP pages (no header/footer).   |
| `/page/(:any)`        | `Page/view/$1`        | Single file fallback.                      |
| `/`                   | `Books/index`         | Homepage / Table of contents.              |
| `/search`             | `Search/index`        | Site-wide search.                          |
| `/sitemap`            | `Sitemap/index`       | Sitemap showing all sections.              |
| `/(:any)/(.+)`        | `Books/view/$1/$2`    | Nested content (section → volume/chapter). |
| `/(:any)`             | `Books/view/$1`       | Single section entry.                      |
| `404_override`        | `Errors/page_missing` | Custom 404 page.                           |

---

## 3️⃣ Sections, Markdown & PHP Handling

* Define **multiple sections** by creating a folder under `/application/views/` (e.g., `Books/`, `Tutorials/`, `Lyrics/`).
* Each folder can contain:

  * Markdown files (`.md`) → auto-parsed.
  * PHP files (`.php`) → auto-loaded as views.
* `README.md` or `index.php` is auto-loaded as the default for a folder.
* Nested folders (volumes, chapters) are fully supported.

---

## 4️⃣ Static Pages

* Place a folder under `/application/views/staic/` (e.g., `column.php, calculator.php`).
* Access via (e.g., `/page/static/column` or `/page/static/calculator`).
* Runs **without header/footer**, fully standalone.
* Works consistently on Windows and Debian.

---

## 5️⃣ Password Protection (Stateless)

* Single cookie (`access_token = ok`) enables access.
* Login page sets cookie; Logout clears it.
* No sessions or database needed.
* Works across all pages, sections, and standalone static pages.

---

## 6️⃣ Navbar / Login Toggle

* Automatically shows **Login / Logout** based on cookie status:

```php
<a href="<?= isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok' ? site_url('logout') : site_url('login') ?>">
  <?= isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok' ? 'Logout' : 'Login' ?>
</a>
```

---

## 7️⃣ Search & Sitemap

* **Search** scans all defined sections (`Books`, `Tutorials`, `Lyrics`, etc.) and returns relevant results.
* **Sitemap** lists all sections, items, and nested content automatically.
* Easy to extend: just add a new folder for a new section.

---

## 8️⃣ Visual & UI Features

* Clean, minimal **PaperCSS** design ([papercss.com](https://www.papercss.com/)).
* Markdown syntax highlighting (PHP, code blocks).
* Dark/light mode toggle.
* Previous/Next navigation and progress bars optional.

---

## 9️⃣ Portability & Environment

* Works on **Windows 32-bit**, **modern Debian**, and portable hosts.
* No database or session required.
* Minimal setup: just copy the project and it works immediately.

---

## 🔗 Credits

* **PaperCSS** – for the minimal and beautiful template: [https://www.papercss.com/](https://www.papercss.com/)
* **Parsedown** – for Markdown parsing: [https://parsedown.org/](https://parsedown.org/)

---

## License

This project is intended for **private use, learning, and experimentation**.
