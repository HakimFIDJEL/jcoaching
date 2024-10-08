setup: 
	@make build 
	@make start 
	@make data

# Build des containers docker
build:
	docker-compose build --no-cache --force-rm

# Lancement des containers docker
start:
	docker-compose up -d

# Arrêt des containers docker
stop:
	docker-compose stop

# Suppression des containers docker et des volumes
remove:
	docker-compose down --volumes
	rm -rf docker

# Migration et seeding de la base de données
data:
	docker-compose exec laravel-docker bash -c "php artisan migrate"
	docker-compose exec laravel-docker bash -c "php artisan db:seed"
