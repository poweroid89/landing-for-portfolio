# LANDING-FOR-PORTFOLIO PROJECT MANAGEMENT

.PHONY: up down restart logs build block wp shell

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

# CLI TOOLS
block:
	npm run block $(name)

wp:
	docker exec -it landing_wp wp $(cmd)

shell:
	docker exec -it landing_wp bash

# HELPERS
fix-permissions:
	sudo chown -R $$USER:$$USER .
	sudo chmod -R 775 wordpress/wp-content
	sudo chmod -R 775 theme/assets

clean:
	docker system prune -f
