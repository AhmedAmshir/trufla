docker-compose up -d --build
docker exec trufla_php composer install
docker exec trufla_php cp .env.example .env
docker exec trufla_php php artisan key:generate
docker exec trufla_php php artisan migrate

# Get top rated and latest movies from API
docker exec trufla_php php artisan movie:api

echo "Project installed successfully";