### 📦 Установка и запуск

1. Клонируйте репозиторий:

```bash
git clone https://github.com/KoyoriySamPoSebe/Nebus.git
cd Nebus
```

2. Скопируйте `.env.example` в `.env`:

```bash
cp .env.example .env
```

3. Соберите и запустите контейнеры:

```bash
docker compose up --build
```

4. После запуска выполните миграции и сидеры:

```bash
docker compose exec app php artisan migrate --seed
```

5. Сгенерируйте API-ключ:

```bash
docker compose exec app php artisan apikey:generate user1
```

🔑 Скопируйте выданный ключ и передавайте его в заголовке каждого запроса:

```
X-API-KEY: <your-api-key>
```

---

### 🔍 Swagger UI

Интерфейс Swagger доступен по адресу:

```
http://localhost/swagger
```

Он автоматически подключает файл `openapi.yaml`.

Для генерации OpenAPI-документации выполните:

```bash
docker compose exec app composer openapi:generate
```
