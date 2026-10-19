# Kvarta Coffee Roastery

**A full-stack landing page for a specialty coffee roastery in Minsk, Belarus.**

[Live Demo](https://kvarta-app.onrender.com)

---

## 🇷🇺 Русский

### О проекте

Kvarta — лендинг для небольшой мастерской по обжарке кофе в Минске. Основная задача проекта — сбор заявок на разовые заказы и подписки на кофе.

Визуальный стиль вдохновлён индустриальным дизайном Teenage Engineering: строгая сетка, крупная типографика, функциональный минимализм и акцент на продукте.

Проект реализован на Laravel с использованием Blade, SCSS и Vanilla JavaScript. Серверная часть отвечает за обработку заявок, валидацию данных, защиту от повторных отправок, сохранение источников трафика и уведомления менеджера в Telegram.

### Технологический стек

- **Backend:** PHP 8.4, Laravel 13
- **Database:** PostgreSQL, Neon
- **Frontend:** Blade, SCSS, Vanilla JavaScript
- **Build tool:** Vite
- **Infrastructure:** Docker, Docker Compose, Render
- **Notifications:** Telegram Bot API

### Основные возможности

**Обработка заявок**
- Приём заявок на разовый заказ и подписку.
- Серверная валидация входных данных.
- Нормализация белорусских телефонных номеров: `80...` в `+375...`.
- Проверка допустимых кодов мобильных операторов.

**Защита от спама**
- Защита от повторной отправки заявок с одного номера.
- Атомарная блокировка через `Cache::add`.
- Период блокировки — 10 минут.

**Отслеживание источников трафика**
- Сбор UTM-меток, `referer` и URL страницы отправки.
- Сохранение данных об источнике в JSON-поле `source`.
- Передача источника перехода менеджеру вместе с заявкой.

**Интеграция с Telegram**
- Автоматическая отправка уведомлений менеджеру через Telegram Bot API.
- В уведомление включаются имя, телефон, тип интереса, комментарий, источник перехода и дата.
- Ошибки отправки логируются; недоступность Telegram не препятствует сохранению заявки в базе данных.

**Развёртывание**
- Docker-образ с многоэтапной сборкой.
- Сборка фронтенд-ресурсов через Vite.
- PostgreSQL в облаке Neon.
- Деплой приложения на Render.

### Локальный запуск

#### Требования

- Docker и Docker Compose
- Git

#### 1. Клонирование репозитория

```bash
git clone <REPOSITORY_URL>
cd <PROJECT_DIRECTORY>
```

Замените значения в угловых скобках на URL репозитория и имя каталога проекта.

#### 2. Настройка окружения

Создайте `.env` на основе `.env.example`:

```bash
cp .env.example .env
```

Укажите параметры подключения к PostgreSQL и настройки Telegram:

```dotenv
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

TELEGRAM_BOT_TOKEN=your-bot-token
TELEGRAM_CHAT_ID=your-chat-id
```

Используйте параметры базы данных, соответствующие конфигурации вашего Docker-окружения. Если проект настроен на локальную базу данных, укажите её параметры вместо примера выше.

#### 3. Сборка и запуск контейнеров

```bash
docker compose up -d --build
```

#### 4. Установка зависимостей фронтенда

Для локальной разработки запустите:

```bash
docker compose exec app npm install
docker compose exec app npm run dev
```

#### 5. Генерация ключа приложения

Если ключ ещё не задан:

```bash
docker compose exec app php artisan key:generate
```

#### 6. Применение миграций

```bash
docker compose exec app php artisan migrate
```

После запуска откройте локальный адрес приложения, настроенный в Docker Compose.

### Деплой: Render + Neon

#### 1. Создание базы данных

1. Создайте PostgreSQL-базу в [Neon](https://neon.tech/).
2. Получите параметры подключения к базе данных.
3. Подготовьте значения переменных окружения для Render.

#### 2. Создание сервиса

1. Откройте [Render](https://render.com/).
2. Создайте новый **Web Service**.
3. Подключите Git-репозиторий.
4. Выберите среду **Docker**.

#### 3. Настройка переменных окружения

Добавьте в настройках Render:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_KEY=<GENERATED_APPLICATION_KEY>

DB_CONNECTION=pgsql
DB_HOST=<NEON_DB_HOST>
DB_PORT=5432
DB_DATABASE=<NEON_DB_NAME>
DB_USERNAME=<NEON_DB_USER>
DB_PASSWORD=<NEON_DB_PASSWORD>

TELEGRAM_BOT_TOKEN=<TELEGRAM_BOT_TOKEN>
TELEGRAM_CHAT_ID=<TELEGRAM_CHAT_ID>
```

Сгенерировать ключ Laravel можно локально:

```bash
php artisan key:generate --show
```

Скопируйте полученный ключ в `APP_KEY` на Render. Не публикуйте ключи и токены в репозитории.

#### 4. Сборка и запуск

Render соберёт Docker-образ в соответствии с `Dockerfile`. Если сборка фронтенда предусмотрена в Dockerfile, SCSS и JavaScript будут собраны в процессе создания образа.

Применение миграций при запуске зависит от команды старта, настроенной в Dockerfile или Render. Убедитесь, что миграции выполняются до обработки запросов приложением.

#### 5. Проверка после деплоя

- Откройте публичный URL сервиса.
- Проверьте отправку тестовой заявки.
- Убедитесь, что данные сохраняются в PostgreSQL.
- Проверьте получение уведомления в Telegram.
- Проверьте обработку некорректных номеров и повторных отправок.
- Убедитесь, что UTM-метки и источник перехода сохраняются корректно.

### Безопасность

- Не добавляйте `.env` и секретные ключи в Git.
- Используйте `APP_DEBUG=false` в production.
- Ограничьте доступ к токену Telegram и учётным данным базы данных.
- Не храните реальные персональные данные в тестовых заявках.

---

## 🇬🇧 English

### About the Project

Kvarta is a landing page for a small coffee roasting workshop based in Minsk, Belarus. Its primary goal is to collect customer inquiries for one-time coffee orders and recurring subscriptions.

The visual direction draws inspiration from Teenage Engineering and industrial design: a strict grid, bold typography, functional minimalism, and a product-focused layout.

The application is built with Laravel, Blade, SCSS, and Vanilla JavaScript. The backend handles lead processing, input validation, duplicate-submission protection, traffic attribution, and Telegram notifications.

### Tech Stack

- **Backend:** PHP 8.4, Laravel 13
- **Database:** PostgreSQL, Neon
- **Frontend:** Blade, SCSS, Vanilla JavaScript
- **Build tool:** Vite
- **Infrastructure:** Docker, Docker Compose, Render
- **Notifications:** Telegram Bot API

### Key Features

**Lead Processing**
- Handles one-time order and subscription inquiries.
- Server-side input validation.
- Belarusian phone number normalization from `80...` to `+375...`.
- Validation of supported mobile operator codes.

**Spam Prevention**
- Prevents repeated submissions from the same phone number.
- Uses atomic `Cache::add` operations for duplicate protection.
- Applies a 10-minute cooldown.

**Traffic Attribution**
- Captures UTM parameters, the HTTP `referer`, and the submission page URL.
- Stores attribution data in a JSON `source` field.
- Includes traffic source information in manager notifications.

**Telegram Integration**
- Automatically sends lead notifications through the Telegram Bot API.
- Notifications include the customer's name, phone number, inquiry type, comment, traffic source, and date.
- Notification failures are logged without preventing the lead from being saved to the database.

**Deployment**
- Multi-stage Docker image build.
- Frontend asset compilation with Vite.
- Cloud-hosted PostgreSQL on Neon.
- Application deployment on Render.

### Local Development

#### Prerequisites

- Docker and Docker Compose
- Git

#### 1. Clone the Repository

```bash
git clone <REPOSITORY_URL>
cd <PROJECT_DIRECTORY>
```

Replace the placeholders with your repository URL and project directory name.

#### 2. Configure Environment Variables

Create your environment file:

```bash
cp .env.example .env
```

Configure your PostgreSQL connection and Telegram credentials:

```dotenv
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

TELEGRAM_BOT_TOKEN=your-bot-token
TELEGRAM_CHAT_ID=your-chat-id
```

Use database settings that match your Docker environment. If you use a local database, replace the example connection values accordingly.

#### 3. Build and Start the Containers

```bash
docker compose up -d --build
```

#### 4. Install Frontend Dependencies

For local development, run:

```bash
docker compose exec app npm install
docker compose exec app npm run dev
```

#### 5. Generate the Application Key

If the application key has not been configured yet:

```bash
docker compose exec app php artisan key:generate
```

#### 6. Run Database Migrations

```bash
docker compose exec app php artisan migrate
```

Open the local application URL configured in your Docker Compose setup.

### Deployment: Render + Neon

#### 1. Set Up the Database

1. Create a PostgreSQL database on [Neon](https://neon.tech/).
2. Obtain the database connection details.
3. Prepare the corresponding environment variables for Render.

#### 2. Create a Web Service

1. Open [Render](https://render.com/).
2. Create a new **Web Service**.
3. Connect your Git repository.
4. Select **Docker** as the deployment environment.

#### 3. Configure Environment Variables

Add the following variables in the Render service settings:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_KEY=<GENERATED_APPLICATION_KEY>

DB_CONNECTION=pgsql
DB_HOST=<NEON_DB_HOST>
DB_PORT=5432
DB_DATABASE=<NEON_DB_NAME>
DB_USERNAME=<NEON_DB_USER>
DB_PASSWORD=<NEON_DB_PASSWORD>

TELEGRAM_BOT_TOKEN=<TELEGRAM_BOT_TOKEN>
TELEGRAM_CHAT_ID=<TELEGRAM_CHAT_ID>
```

Generate a Laravel application key locally:

```bash
php artisan key:generate --show
```

Copy the generated key into the Render `APP_KEY` setting. Never commit application keys or API tokens to the repository.

#### 4. Build and Start the Application

Render builds the Docker image according to the project's `Dockerfile`. If frontend compilation is configured in the Dockerfile, Vite will compile the SCSS and JavaScript assets during the image build.

Database migrations run at startup only if the Dockerfile or Render start command is configured to execute them. Make sure migrations complete before the application begins handling requests.

#### 5. Verify the Deployment

- Open the public service URL.
- Submit a test inquiry.
- Verify that the lead is stored in PostgreSQL.
- Confirm that the Telegram notification is received.
- Test invalid phone numbers and duplicate submissions.
- Verify that UTM parameters and traffic attribution are stored correctly.

### Security Notes

- Never commit `.env` files or secret credentials.
- Keep `APP_DEBUG=false` in production.
- Protect Telegram bot tokens and database credentials.
- Avoid using real personal data in test submissions.
