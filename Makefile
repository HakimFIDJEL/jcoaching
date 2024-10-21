# Lancement des containers docker
start:
	docker compose up -d

# Arrêt des containers docker
stop:
	docker compose stop

# Suppression des containers docker et des volumes
remove:
	docker compose down --remove-orphans

remove_volume:
	docker volume rm mysql_data

# Migration et seeding de la base de données
database:
	docker compose exec jcoaching-app bash -c "php artisan migrate"
	docker compose exec jcoaching-app bash -c "php artisan db:seed"

# Vide le cache
cache:
	docker compose exec jcoaching-app bash -c "php artisan config:clear"
	docker compose exec jcoaching-app bash -c "php artisan cache:clear"
	docker compose exec jcoaching-app bash -c "php artisan route:clear"
	docker compose exec jcoaching-app bash -c "php artisan view:clear"

	docker compose exec jcoaching-queue bash -c "php artisan config:clear"
	docker compose exec jcoaching-queue bash -c "php artisan cache:clear"
	docker compose exec jcoaching-queue bash -c "php artisan route:clear"
	docker compose exec jcoaching-queue bash -c "php artisan view:clear"

# Buile l'image docker
build_image:
	docker build -t hakimfidjel/jcoaching:latest .

# Login sur docker hub
login:
	docker login

# Push de l'image sur docker hub
image_push:
	docker push hakimfidjel/jcoaching:latest


# 
prepare_containers:
	@make start
	@make database

# 
prepare_image:
	@make build_image
	@make login
	@make image_push



