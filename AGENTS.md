# AGENTS.md - Food Shop Laravel

## Stack
- **Laravel 12** (PHP 8.2+)
- **Tailwind CSS 4** + **Vite 7** (via laravel-vite-plugin)
- PHPUnit 11 for testing

## Key Commands
| Task | Command |
|------|---------|
| Full setup | `composer run setup` |
| Dev server (all: http, queue, logs, vite) | `composer run dev` |
| Run tests | `composer run test` |
| Code formatting (Laravel Pint) | `./vendor/bin/pint` |
| Run migrations | `php artisan migrate` |
| Vite dev | `npm run dev` |
| Vite build | `npm run build` |

## Project Structure
- **Routes**: `routes/web.php` (auth, cart, checkout, orders)
- **Models**: `app/Models/` (User, Food, Order, OrderItem, Cart)
- **Controllers**: `app/Http/Controllers/` (Auth, Cart, Order, Profile)
- **Views**: `resources/views/`
- **Frontend assets**: `resources/css/app.css`, `resources/js/app.js`

## Important Conventions
- **Cart is session-based** (no auth required for cart operations)
- **Checkout/Orders require auth** middleware
- Tests use **in-memory SQLite** (`:memory:`) - see `phpunit.xml`
- Use Laravel Pint for formatting (not php-cs-fixer)
- Vite auto-refreshes on Blade/asset changes (configured in `vite.config.js`)

## Testing
- Run all tests: `composer run test` or `php artisan test`
- Unit tests: `tests/Unit/`
- Feature tests: `tests/Feature/`
- Test environment automatically clears config first

## Gotchas
- Default test DB is `sqlite` in memory - no separate test DB setup needed
- `composer run dev` uses `concurrently` to run 4 processes: server, queue, pail, vite
- Tailwind CSS 4 uses Vite plugin (`@tailwindcss/vite`), not postcss.config.js
