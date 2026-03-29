# Blog

Simple Laravel + Inertia Vue 3 blog application.

## Setup

1. Clone repository
2. Install PHP dependencies

```bash
composer install
```

3. Install JavaScript dependencies

```bash
npm install
```

4. Copy environment file

```bash
cp .env.example .env
```

5. Generate application key

```bash
php artisan key:generate
```

6. Configure database in .env

Set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, and other DB settings.

## Run the project

Start the Laravel backend:

```bash
php artisan serve
```

Start the frontend/Vite watcher:

```bash
npm run dev
```

Visit the app at:

- `http://127.0.0.1:8000`

## Database migrations and seeders

Run migrations:

```bash
php artisan migrate
```

Run all seeders:

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=UserSeeder
```

## Project Pages

## Client

- `/` - Home / Posts list
- `/posts/{id}` - View single post

## Admin

- `/admin` - Redirects to `/admin/posts`
- `/admin/login` - Login into admin panel
- `/admin/posts` - List all posts
- `/admin/posts/create` - Create new post
- `/admin/posts/{post}` - Show single post
- `/admin/posts/{post}/edit` - Edit post
