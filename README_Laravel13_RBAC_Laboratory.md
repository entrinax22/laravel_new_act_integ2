# Laboratory Activity: Role-Based Access Control (RBAC) with Laravel 13

**Course:** Integrative Programming & Technologies II  
**Module 5 — Lesson 2:** Authorization and Role-Based Access Control  
**Intended Learning Outcome (ILO13):** Apply authorization techniques and role-based access control (RBAC).  
**Total:** **50 points**  
**Type:** Individual hands-on laboratory  
**Tools:** Existing Laravel 13 project, WAMP/XAMPP (Apache and MySQL), Laravel Sanctum, Postman, Git, GitHub

## Objective

Continue the secure API from the previous laboratory. Implement **two custom middleware classes**—`CheckRole` (accepts one or more allowed roles) and `AdminMiddleware` (admin-only)—to restrict API endpoints. Show the difference between `401 Unauthenticated`, `403 Forbidden`, and `200 OK` using Postman.

> **Do not create a new Laravel project.** Use your existing project with working registration, login, profile, logout, and Sanctum Bearer-token authentication.

## Expected access rules

| Endpoint | HTTP method | Admin | Student | No token |
|---|---|---|---|---|
| `/api/profile` | GET | 200 | 200 | 401 |
| `/api/students` | GET | 200 | 200 | 401 |
| `/api/admin/dashboard` | GET | 200 | 403 | 401 |
| `/api/student/dashboard` | GET | 403 | 200 | 401 |

For this lab, `/api/students` may return a small fixed JSON array; no new student-record database table is needed.

## Part A — Prepare the users table (8 points)

1. Confirm the previous lab still works: `php artisan migrate:status` and `php artisan route:list --path=api`.
2. Create a migration:
   ```bash
   php artisan make:migration add_role_to_users_table --table=users
   ```
3. In the migration's `up()` method, add a `role` string column with a default of `student`. In `down()`, remove the `role` column.
4. Run `php artisan migrate`. **Do not use `migrate:fresh`** on a project containing data you want to keep.
5. Keep the public registration API restricted to normal student accounts. Never accept an arbitrary `role` from the registration request.
6. Use `php artisan tinker` to create or update **one admin account and one student account**. Assign the `admin` role only through trusted server-side code (not Postman registration). If accounts already exist, update them rather than creating duplicates.

**Suggested test identities:** `admin@example.com` and `student@example.com`. Choose your own temporary passwords; **never commit them or real tokens to GitHub**.

## Part B — Create custom middleware (16 points)

Run:

```bash
php artisan make:middleware CheckRole
php artisan make:middleware AdminMiddleware
```

Edit the files in `app/Http/Middleware/`:

**1. `CheckRole.php` — 9 points**

- Use the `handle(Request $request, Closure $next, string ...$roles)` method signature.
- Read the authenticated user using `$request->user()`.
- Return JSON with HTTP **401** if there is no authenticated user.
- Check whether the user's `role` is among the allowed `$roles` (for example, `in_array($user->role, $roles, true)`).
- Return JSON with HTTP **403** if the role is not allowed.
- Call `return $next($request);` if the role is permitted.

**2. `AdminMiddleware.php` — 7 points**

- Read the authenticated user from the request.
- Return **401** if unauthenticated and **403** if the user is not an admin.
- Allow the request to continue only when `$user->role === 'admin'`.

> Laravel Sanctum (`auth:sanctum`) authenticates the token first. Your custom middleware adds **authorization**. The explicit 401 check is a defensive safeguard; normal routes must also use `auth:sanctum`.

## Part C — Register aliases and protect API routes (10 points)

1. Open `bootstrap/app.php`. Inside the existing `withMiddleware(...)` callback, register these aliases (preserve any existing middleware configuration):

   ```php
   $middleware->alias([
       'role' => \App\Http\Middleware\CheckRole::class,
       'admin' => \App\Http\Middleware\AdminMiddleware::class,
   ]);
   ```

2. Open `routes/api.php`. **Keep your existing register, login, profile, and logout endpoints.** Add or update the protected routes so that:
   - `GET /api/students` uses `auth:sanctum` and `role:admin,student`.
   - `GET /api/admin/dashboard` uses `auth:sanctum` and `admin`.
   - `GET /api/student/dashboard` uses `auth:sanctum` and `role:student`.
   - `GET /api/profile` continues to use `auth:sanctum`.
3. Each dashboard route should return a short JSON message identifying the dashboard.
4. Check that you haven't accidentally defined the same path and HTTP method twice.
5. Run:

   ```bash
   php artisan optimize:clear
   php artisan route:list --path=api -v
   php artisan serve
   ```

**Example of the expected route style** (do not paste if you already have an equivalent route):

```php
Route::middleware(['auth:sanctum', 'admin'])->get('/admin/dashboard', function () {
    return response()->json(['message' => 'Welcome Admin!']);
});
```

## Part D — Postman testing and screenshot evidence (12 points)

Set `Accept: application/json` in Postman. Use **Authorization → Bearer Token** with the actual token returned from your existing `/api/login` endpoint. Remove inherited authorization when testing without a token.

| Test | Request | Token used | Expected status | Screenshot filename |
|---|---|---|---|---|
| 1 | POST `/api/login` | None; admin credentials in body | 200 | `01-admin-login.png` |
| 2 | GET `/api/admin/dashboard` | Admin | 200 | `02-admin-allowed.png` |
| 3 | GET `/api/student/dashboard` | Admin | 403 | `03-admin-denied.png` |
| 4 | POST `/api/login` | None; student credentials in body | 200 | `04-student-login.png` |
| 5 | GET `/api/student/dashboard` | Student | 200 | `05-student-allowed.png` |
| 6 | GET `/api/admin/dashboard` | Student | 403 | `06-student-denied.png` |
| 7 | GET `/api/students` | Student | 200 | `07-shared-route.png` |
| 8 | GET `/api/admin/dashboard` | No token | 401 | `08-no-token.png` |

For each screenshot, show the **HTTP method, request URL, response status, and response JSON**. **Hide/blur the Bearer token, passwords, and other secrets** before taking or submitting screenshots. If login returns a token, conceal the token value in the screenshot.

If your login endpoint returns a different success code or JSON shape, explain the difference in the submission README; it must still authenticate successfully.

## Part E — GitHub submission and short reflection (4 points)

1. Commit the completed Laravel project to your existing or a new **GitHub repository**.
2. Include the eight Postman screenshots under `screenshots/` and add a short project `README.md` documenting the RBAC routes and local testing steps.
3. **Do not upload:** `.env`, `vendor/`, `node_modules/`, database dumps with real user data, passwords, personal access tokens, or other secrets. Confirm your `.gitignore` excludes these paths; use `.env.example` for safe configuration examples.
4. In your project README, answer briefly:
   - What is the difference between authentication and authorization?
   - Why does a student receive `403` when accessing the admin dashboard, but a request without a token receives `401`?
5. Submit your **GitHub repository URL** and the **eight screenshots** as instructed by your instructor. Ensure the instructor has access to the repository.

**Suggested repository organization:**

```text
laravel-secure-api/
├── app/Http/Middleware/
│   ├── AdminMiddleware.php
│   └── CheckRole.php
├── bootstrap/app.php
├── routes/api.php
├── database/migrations/
├── screenshots/
│   ├── 01-admin-login.png
│   ├── ...
│   └── 08-no-token.png
├── .env.example
└── README.md
```

## Grading rubric — 50 points

| Criterion | Points |
|---|---:|
| A. Role migration, default role, and properly assigned test accounts | 8 |
| B. `CheckRole` middleware (9) and `AdminMiddleware` (7) | 16 |
| C. Middleware aliases, route protection, and correct access rules | 10 |
| D. Eight accurate Postman tests/screenshots (1.5 points each) | 12 |
| E. GitHub repository, safe submission, and reflection | 4 |
| **Total** | **50** |

## Completion checklist

- [ ] Role column migrated with `student` as default
- [ ] Admin and student test accounts configured securely
- [ ] `CheckRole` checks one or multiple allowed roles
- [ ] `AdminMiddleware` restricts admin-only routes
- [ ] Both middleware aliases registered in `bootstrap/app.php`
- [ ] Routes protected by Sanctum **and** the correct role middleware
- [ ] All eight Postman tests show expected results
- [ ] Eight screenshots captured with secrets hidden
- [ ] GitHub repository pushed and accessible to instructor
- [ ] Reflection answers included

## Troubleshooting

| Problem | Check |
|---|---|
| `401 Unauthenticated` | Bearer token is present, valid, and not revoked; `auth:sanctum` is configured |
| `403 Forbidden` unexpectedly | User's role in the database and the role listed on the route |
| `404 Not Found` | Route is present in `php artisan route:list --path=api` and URL includes `/api` |
| `Target class [role] does not exist` | Middleware aliases in `bootstrap/app.php`; run `php artisan optimize:clear` |
| `SQLSTATE` database error | `.env` MySQL credentials, migrations, and previously configured InnoDB engine |
| API returns HTML instead of JSON | Add `Accept: application/json` in Postman |

## References

- Laravel 13 middleware: https://laravel.com/docs/13.x/middleware
- Laravel 13 Sanctum: https://laravel.com/docs/13.x/sanctum
- Laravel 13 authorization: https://laravel.com/docs/13.x/authorization
