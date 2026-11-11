# Laboratory Activity 2: Role-Based Access Control (RBAC) in an Existing Laravel Web Application

**Course:** Integrative Programming 2  
**Module 5 — Lesson 2:** Authorization and Role-Based Access Control  
**Intended Learning Outcome (ILO13):** Apply authorization techniques and role-based access control (RBAC).  
**Total:** 50 points  
**Type:** Individual hands-on laboratory  
**Project:** Your **existing Laravel web application** (not the API/Sanctum laboratory)

## Objective

Extend your current Laravel web application by implementing role-based access control using **custom middleware you write yourself**. Choose **one** approach: **Dynamic Role Middleware** or **Manual Role Middleware**. Both approaches have equal grading weight.

This is a **separate activity** from the Secure API / Postman laboratory. You are **not required** to create a new Laravel project, install Sanctum, or use Postman for this activity.

## Expected Learning Outcomes

By the end of this laboratory, you should be able to:

1. Define meaningful user roles and access permissions for your own web application.
2. Store and assign roles securely without allowing ordinary users to promote themselves.
3. Write and register custom Laravel middleware.
4. Protect real web routes and actions according to the authenticated user's role.
5. Verify allowed and denied access in a web browser, including direct URL attempts.

## Prerequisites

- Your existing Laravel web application opens and runs locally.
- A working database connection and migrations.
- A functioning web login system (Laravel session-based authentication).
- At least two test accounts that can log in.
- Git and a GitHub repository for your project.

> **Important:** Do not delete or recreate your existing project. Make changes in a new Git branch if possible. Back up important database data before applying migrations.

---

## Step-by-Step Instructions

### Step 1 — Review your existing web application

1. Open your existing Laravel project in your editor.
2. Run the application and verify that login works.
3. Identify **at least two real pages or actions** that should have different access rules. Examples: managing products, approving requests, editing records, viewing reports, or accessing an administrator dashboard.
4. Do **not** add placeholder pages only to satisfy this activity if suitable existing features are available.

Suggested commands:

```bash
php artisan --version
php artisan migrate:status
php artisan route:list
php artisan serve
```

If your app uses Vite, also run `npm install` (if needed) and `npm run dev` in another terminal.

### Step 2 — Plan roles and permissions

Define **at least two roles**, one of which must be `admin`. Name the other role based on your project, such as `staff`, `faculty`, `student`, `employee`, or `customer`.

Create a table in your submission README like this, replacing the sample pages with your own:

| Existing page or action | Admin | Other role |
|---|---|---|
| View dashboard | Allowed | Allowed |
| Manage records | Allowed | Denied |
| View own account | Allowed | Allowed |

Your permissions must be appropriate for your application's purpose. Identify at least **one action available to both roles** and **one restricted to a particular role**.

### Step 3 — Add or verify a role field

1. Check whether your users table already has a role field. **Do not create a duplicate column.**
2. If needed, create a migration:

```bash
php artisan make:migration add_role_to_users_table --table=users
```

3. Add an appropriate role column with a safe default for new accounts. Write the migration code yourself.
4. Run `php artisan migrate` and inspect the users table.
5. Make sure public registration does **not** accept arbitrary roles such as `admin`. New accounts should receive a safe default role.
6. Create or update your test accounts using a **trusted** method such as a seeder or Tinker. Do not expose role promotion through public forms.

### Step 4 — Choose ONE custom middleware approach

**Option A — Dynamic Role Middleware**

Write **one reusable middleware class** that accepts allowed roles as route parameters. It must support different allowed-role combinations without rewriting the class for every route.

Example usage pattern (not the solution):

```php
->middleware('role:admin')
->middleware('role:admin,staff')
```

**Option B — Manual Role Middleware**

Write **role-specific middleware** with explicit checks for a defined role. For example, an `AdminMiddleware` class can guard administrator-only pages. If your permission plan requires separate role-specific restrictions, create the appropriate additional middleware.

Example usage pattern (not the solution):

```php
->middleware('admin')
```

**Both options must:**

- Use the authenticated user's **server-side role**, not a role value sent by the browser.
- Reject access when the role is not allowed.
- Allow the request to continue when the role is permitted.
- Work with your application's existing web authentication.
- Never rely only on hiding buttons or menu items.

Create your middleware using Artisan, adjusting the class name for your chosen approach:

```bash
php artisan make:middleware CheckRole
```

**Do not copy a complete middleware solution from this README.** Implement the check yourself based on the class demonstration.

### Step 5 — Register your middleware

In Laravel 13, register a middleware alias in **`bootstrap/app.php`** inside the existing `withMiddleware` configuration.

Use a meaningful alias, such as `role` for dynamic middleware or `admin` for administrator-only middleware. Preserve any existing middleware configuration.

After editing, run:

```bash
php artisan optimize:clear
php artisan route:list -v
```

Verify that your protected routes show the expected middleware.

### Step 6 — Protect existing web routes and actions

1. Open **`routes/web.php`**.
2. Apply Laravel's **`auth` middleware** to pages that require a logged-in user.
3. Apply **your own custom middleware** to at least **two existing routes or actions** according to the permissions you planned.
4. Keep at least one appropriate page or action accessible to both test roles.
5. Make sure the restriction is enforced on the **server**. If a restricted page contains a form, protect the corresponding **POST, PUT, PATCH, or DELETE** action too, not only its GET page.
6. Ensure unauthorized requests are denied (typically HTTP **403**) or handled by an appropriate denial page. Unauthenticated users should be redirected to login by the normal web authentication flow.

> **Security reminder:** Hiding an admin menu link does not protect its URL. A user must still be blocked when manually entering the restricted address.

### Step 7 — Test using your browser

Use two separate accounts and perform all of these tests:

| Test | Action | Expected result |
|---|---|---|
| 1 | Log in as `admin` and open an admin-only feature | Access granted |
| 2 | Log in as the other role and open its permitted feature | Access granted |
| 3 | Log in as the other role and enter an admin-only URL directly | Access denied |
| 4 | Log out and open a protected URL | Redirect to login / access blocked |
| 5 | Attempt a restricted create/update/delete action using the wrong role | Action denied; no unauthorized change |

**Tips:** Use a private/incognito window or log out between account tests. Confirm each account's role in your database. Check that a failed action did not change any records.

### Step 8 — Capture evidence

Save **five clear screenshots** in an `evidence/` folder in your repository:

1. `01-admin-allowed.png` — Admin successfully accesses a restricted feature.
2. `02-other-role-allowed.png` — Other role accesses its permitted feature.
3. `03-role-denied.png` — Other role is blocked from the admin URL entered directly.
4. `04-guest-blocked.png` — Logged-out user is blocked from a protected URL.
5. `05-restricted-action-denied.png` — Unauthorized create/update/delete attempt is blocked.

Screenshots must show enough browser context to identify the page and result. **Do not include passwords, session cookies, tokens, `.env` contents, or other secrets.** You may redact personal information.

### Step 9 — Document your implementation

Add a section to your project's README titled **“Laboratory Activity 2 — RBAC”** containing:

- Project title and short description.
- The **selected approach**: Dynamic or Manual middleware.
- Role-and-permission table for your actual application.
- Middleware class name(s), aliases, and routes/actions protected.
- Brief explanation (3–5 sentences) of how your middleware authorizes requests.
- Screenshot links pointing to the five files in `evidence/`.
- A short reflection (3–5 sentences): What was challenging, and why is server-side authorization necessary?

### Step 10 — Commit, push, and submit

Verify that your `.env` file, credentials, and other secrets are **not committed**. Then commit your changes:

```bash
git status
git add .
git commit -m "Implement RBAC with custom middleware"
git push
```

Submit the following through your instructor's designated submission platform:

1. **GitHub repository URL** pointing to your updated existing project.
2. **Chosen middleware approach** (Dynamic or Manual).
3. **Five screenshot files** (included in the repository; attach separately if instructed).
4. **README documentation** described in Step 9.

Your repository must be accessible to your instructor. If it is private, grant the required access instead of exposing secrets by making it public.

---

## Grading Rubric — 50 Points

| Criteria | Points |
|---|---:|
| Roles and permissions planning (appropriate roles, clear permission matrix, secure assignment) | 8 |
| Custom middleware implementation (correct checks, proper rejection, selected approach implemented independently) | 16 |
| Integration into existing web application (registration, protected routes and actions, functional behavior) | 12 |
| Browser testing and five screenshots (authorized, forbidden, guest, and restricted-action cases) | 10 |
| GitHub submission and documentation (repo link, explanation, reflection) | 4 |
| **TOTAL** | **50** |

**Fairness:** Dynamic and Manual approaches receive the **same maximum score**. Grades depend on correctness, security, integration, and evidence—not on which option you choose.

## Final Submission Checklist

- [ ] I used my **existing Laravel web application**.
- [ ] I defined at least two roles, including `admin`.
- [ ] I chose **one** approach: Dynamic or Manual middleware.
- [ ] I wrote and registered my **own** custom middleware.
- [ ] I protected at least two real routes/actions, including a restricted action.
- [ ] I tested allowed and denied access using different accounts.
- [ ] I saved five screenshots in `evidence/`.
- [ ] I documented my roles, routes, middleware, and reflection in my README.
- [ ] I pushed my work to GitHub and submitted the repository link.
- [ ] I checked that no passwords, tokens, or `.env` secrets were committed.

**Reference:** [Laravel 13 — Middleware](https://laravel.com/docs/13.x/middleware) and [Laravel 13 — Authorization](https://laravel.com/docs/13.x/authorization).
