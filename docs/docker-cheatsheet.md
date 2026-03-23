# 🐳 Docker Cheat Sheet — Sellio

Ці команди допоможуть тобі керувати оточенням проєкту. Всі команди Docker Compose потрібно запускати з папки `docker/`.

---

## 🚀 Основні команди

**Запустити всі контейнери (у фоні):**
```bash
docker compose up -d
```

**Зупинити та видалити контейнери:**
```bash
docker compose down
```

**Перезапустити контейнери (після зміни конфігів):**
```bash
docker compose up -d --build
```

**Переглянути статус контейнерів:**
```bash
docker compose ps
```

---

## 📝 Логи та Відлагодження

**Переглянути логи всіх сервісів (у реальному часі):**
```bash
docker compose logs -f
```

**Переглянути логи конкретного сервісу:**
```bash
docker compose logs -f wordpress
# або
docker compose logs -f db
```

---

## 💾 База Даних (MySQL)

**Зробити бекап (Експорт SQL):**
```bash
docker exec sellio_db mysqldump -u wp_user -pwp_password sellio > dump_$(date +%F).sql
```

**Відновити базу (Імпорт SQL):**
```bash
cat dump.sql | docker exec -i sellio_db mysql -u wp_user -pwp_password sellio
```

---

## 🛠 Корисне

**Ввійти всередину контейнера (SSH-like):**
```bash
docker exec -it sellio_wp bash
```

**Переглянути використання ресурсів (RAM/CPU):**
```bash
docker stats
```

**Очистити систему (якщо скінчилося місце):**
```bash
docker system prune -a
```
