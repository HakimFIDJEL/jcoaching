# Build des containers docker
# build_containers:
# 	docker-compose build --no-cache --force-rm 

# Lancement des containers docker
start:
	docker-compose up -d

# Arrêt des containers docker
stop:
	docker-compose stop

# Suppression des containers docker et des volumes
remove:
	docker-compose down --volumes --remove-orphans
	rm -rf docker

# Migration et seeding de la base de données
database:
	docker-compose exec laravel-app bash -c "php artisan migrate"
	docker-compose exec laravel-app bash -c "php artisan db:seed"

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
