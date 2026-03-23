# 🛠 Git Cheat Sheet — Sellio

Шпаргалка по роботі з контролем версій для твого проєкту.

---

## 🔄 Щоденний робочий цикл

**1. Перевірити статус (що змінилося):**
```bash
git status
```

**2. Додати зміни до коміту:**
```bash
git add .
# або додати конкретний файл
git add path/to/file.php
```

**3. Створити коміт (зберегти стан):**
```bash
git commit -m "feat: опис того що ти зробив"
```

**4. Надіслати на сервер (якщо є remote):**
```bash
git push origin main
```

---

## 🌿 Гілки (Branches)

**Створити нову гілку (наприклад для нового блоку):**
```bash
git checkout -b feat/new-hero-block
```

**Перейти на основну гілку:**
```bash
git checkout main
```

**Об'єднати гілку з основною:**
```bash
git checkout main
git merge feat/new-hero-block
```

---

## 🔙 Скасування змін

**Скасувати зміни у файлі (до останнього коміту):**
```bash
git checkout path/to/file.php
```

**Видалити останній коміт (але залишити файли):**
```bash
git reset --soft HEAD~1
```

**Повністю відкотитися до останнього коміту (ОБЕРЕЖНО!):**
```bash
git reset --hard HEAD
```

---

## 🔍 Перегляд історії

**Коротка історія комітів:**
```bash
git log --oneline --graph --all
```

**Хто і коли міняв рядок у файлі:**
```bash
git blame path/to/file.php
```
