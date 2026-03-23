# 🚀 Landing for Portfolio — Professional WordPress Theme starter

[![WordPress](https://img.shields.io/badge/WordPress-6.4+-21759b.svg?style=flat-square&logo=wordpress)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777bb4.svg?style=flat-square&logo=php)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ed.svg?style=flat-square&logo=docker)](https://docker.com)
[![Gulp](https://img.shields.io/badge/Gulp-v5.0-EB4A4B.svg?style=flat-square&logo=gulp)](https://gulpjs.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

**Landing for Portfolio** — це професійне рішення для розробки WordPress тем, побудоване на компонентній архітектурі з використанням Gutenberg Blocks, Docker та сучасного інструментарію.

---

## 🔥 Ключові особливості

-   **⚡ Lazy Loading активів:** Кожен блок має власний файл стилів та скриптів, які підвантажуються **тільки** якщо блок присутній на сторінці.
-   **🧩 Генератор блоків:** Створення нового Gutenberg блоку однією командою (`make block name=...`).
-   **🏗️ Docker environment:** Готовий стек: Nginx, PHP 8.2, MySQL 8.0, Redis, Mailhog та phpMyAdmin.
-   **🔄 ACF JSON Sync:** Поля ACF автоматично синхронізуються через файли для зручної роботи з Git.
-   **🛠️ Професійний воркфлоу:** Використання `Makefile` для автоматизації рутинних завдань.

---

## 🛠️ Швидкий старт

### 1. Підготовка
```bash
git clone <repo-url> landing-for-portfolio
cd landing-for-portfolio
cp .env.example .env
```
*Налаштуйте параметри в `.env` (назва БД, паролі тощо).*

### 2. Запуск проекту
Просто виконайте команду для підняття Docker-контейнерів:
```bash
make up
```

### 3. Компіляція активів
Встановіть залежності та запустіть Gulp (watch + BrowserSync):
```bash
npm install
npm run dev
```

---

## 🏗️ Структура проекту

```text
landing-for-portfolio/
├── theme/                 # Код вашої WP Теми
│   ├── blocks/            # Динамічні Gutenberg блоки
│   ├── acf-json/          # Авто-синхронізація ACF полів
│   ├── inc/               # Модульна логіка (setup, enqueue, blocks)
│   └── assets/            # Скомпільовані файли (CSS/JS)
├── src/                   # Source файли (SCSS, JS)
├── docker/                # Конфігурація Docker оточення
├── tools/                 # CLI інструменти (Block Generator)
└── docs/                  # Детальна документація
```

---

## ⌨️ Команди Makefile

| Команда | Опис |
| :--- | :--- |
| `make up` | Запустити проект у Docker |
| `make down` | Зупинити всі контейнери |
| `make restart` | Перезавантажити контейнери |
| `make logs` | Переглянути логи в реальному часі |
| `make block name=X` | **Генерувати новий блок** (папка + 4 файли) |
| `make wp cmd="X"` | Виконати WP-CLI команду |
| `make shell` | Зайти в Bash консоль WP контейнера |
| `make fix-permissions` | Виправити права доступу до папок |

---

## 🧩 Робота з блоками

Щоб створити новий блок, виконайте:
```bash
make block name=services
```
Це створить директорію `theme/blocks/services/` з повною структурою:
- `block.json` — метадані Gutenberg.
- `render.php` — PHP шаблон.
- `style.scss` — стилі (автоматично компілюються в окремий CSS).
- `script.js` — клієнтський JavaScript.

---

## 📡 Доступні сервіси (Local)

-   **Сайт:** [http://localhost:8082](http://localhost:8082)
-   **phpMyAdmin:** [http://localhost:8889](http://localhost:8889)
-   **Mailhog (Email test):** [http://localhost:8026](http://localhost:8026)
-   **Redis:** `landing_redis:6379` (всередині мережі Docker)

---

## 📖 Додаткова інформація
Більше деталей ви знайдете у папці `docs/`:
- [Professional Workflow](docs/professional-workflow.md)
- [Docker Cheatsheet](docs/docker-cheatsheet.md)
- [Git Cheatsheet](docs/git-cheatsheet.md)
