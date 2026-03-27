# LANDING-FOR-PORTFOLIO PROJECT MANAGEMENT

.PHONY: up down restart logs build dev block wp shell

up:
	cd docker && docker compose up -d

down:
	cd docker && docker compose down

restart:
	cd docker && docker compose restart

logs:
	cd docker && docker compose logs -f

build:
	npm run build
	cd docker && docker compose up -d --build

dev:
	npm run dev

# CLI TOOLS
block:
	npm run block $(name)

wp:
	docker exec -it landing_wp wp $(cmd)

shell:
	docker exec -it landing_wp bash

# HELPERS
perms:
	@echo "Fixing permissions for both Host (Gulp) and Container (WP)..."
	sudo chown -R $$USER:$$USER .
	sudo chmod -R 775 .
	# Даємо повний доступ до папок, куди пишуть і Gulp, і WordPress
	sudo chmod -R 777 theme/assets
	sudo chmod -R 777 wordpress/wp-content
	# Даємо права WordPress (www-data) на оновлення ядра всередині контейнера
	docker exec -u 0 -it landing_wp chown -R www-data:www-data /var/www/html
	# Додатково відкриваємо права на запис для всіх у системних папках (тільки для розробки!)
	docker exec -u 0 -it landing_wp chmod -R 777 /var/www/html
	@echo "Done! You can now run 'npm run dev' and update WP at the same time."

fix-permissions: perms

clean:
	docker system prune -f
