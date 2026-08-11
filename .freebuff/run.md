# Josue Molina — preview run doc

Laravel 11 app (Filament admin + Livewire public site). The public site is served by PHP; Vite only builds
frontend assets (`public/build` is committed, so no Node step is required to serve the app).

## Reproduce uncommitted artifacts (fresh checkout)

From the project root (`C:\Users\Mi Pc\Desktop\Proyectos\josue`):

1. Install PHP dependencies:
   - `composer install --no-interaction --prefer-dist`
2. Create the environment file (values may need adapting per machine; secrets like Google Drive
   credentials are stored in `.env`, not here):
   - Copy `.env.example` to `.env`
   - `php artisan key:generate`
3. Set up the SQLite database:
   - `touch database/database.sqlite`
   - `php artisan migrate --force`
4. Frontend assets (only needed when changing CSS/JS — committed `public/build` already exists):
   - `npm install` then `npm run build` (or `npm run dev` for the Vite dev server)

## Run the server

Preferred command (serves the whole app at http://127.0.0.1:8123):

- `php artisan serve --host=127.0.0.1 --port=8123` (from the project root)

Port 8123 is the established preview port for this workspace; pick another free port if busy.

Detached start on Windows (PowerShell) — stdout and stderr MUST go to different files:

```
powershell -NoProfile -Command "(Start-Process -FilePath 'C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe' -ArgumentList 'artisan','serve','--host=127.0.0.1','--port=8123' -WorkingDirectory 'C:\Users\Mi Pc\Desktop\Proyectos\josue' -RedirectStandardOutput 'C:\Users\Mi Pc\Desktop\Proyectos\josue\.freebuff\preview.log' -RedirectStandardError 'C:\Users\Mi Pc\Desktop\Proyectos\josue\.freebuff\preview.log.err' -WindowStyle Hidden -PassThru).Id"
```

Notes / gotchas learned:

- Use the exact `php.exe` path — `Start-Process` does not resolve PATH shims.
- The PowerShell call may appear to hang after printing the pid; the server is still started — check the port
  with `netstat -ano | grep :8123` and curl the URL instead of waiting.
- Do NOT bypass with `php -S 127.0.0.1:8123 <vendor>/.../server.php` through `Start-Process -ArgumentList`:
  the project path contains spaces (`C:\Users\Mi Pc\...`), and the router's `require_once` breaks when the
  router argument is re-split on spaces. `artisan serve` handles this correctly.
