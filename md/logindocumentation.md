# Login Documentation

## Overview
This document provides details about the login functionality implemented in the Dietku application. It explains the flow, configuration, and troubleshooting steps for the login process.

---

## Login Flow

1. **User Input:**
   - The user enters their email and password on the login page.
   - Optionally, the user can select "Remember Me" (if enabled).

2. **Form Submission:**
   - The form sends a POST request to `/login`.
   - The request includes the user's email, password, and the CSRF token.

3. **Authentication:**
   - The `LoginController` validates the input.
   - It checks the credentials against the database using `Auth::attempt`.

4. **Response:**
   - On success:
     - The session is regenerated.
     - A JSON response is returned with user details and their role.
     - The user is redirected based on their role.
   - On failure:
     - A JSON response is returned with an error message.

---

## Configuration

### Environment Variables
Ensure the following variables are correctly set in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dietku
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Routes
The login routes are defined in `routes/web.php`:

```php
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
```

---

## Troubleshooting

### Common Issues

1. **401 Unauthorized:**
   - Ensure the password is hashed correctly in the database.
   - Verify the `.env` file matches the database configuration.

2. **Database Connection Errors:**
   - Check the `DB_HOST`, `DB_PORT`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.
   - Run `php artisan config:clear` to refresh the configuration cache.

3. **Session Issues:**
   - Ensure the session driver is correctly set in `.env`:
     ```env
     SESSION_DRIVER=file
     ```
   - Clear session files in `storage/framework/sessions` if necessary.

---

## Troubleshooting Page Expired (HTTP 419)

### Overview
The "Page Expired" error occurs when a CSRF token is missing or invalid during a request. This is a security feature in Laravel to prevent cross-site request forgery.

### Common Causes
1. **Missing CSRF Token:**
   - The form does not include the `@csrf` directive.
2. **Session Expired:**
   - The user's session has expired, and the CSRF token is no longer valid.
3. **Incorrect Configuration:**
   - The session driver is not correctly set in the `.env` file.

### Solutions

1. **Add CSRF Token to Forms:**
   Ensure all forms include the `@csrf` directive:
   ```blade
   <form action="/login" method="POST">
       @csrf
       <!-- Other form fields -->
   </form>
   ```

2. **Check Session Configuration:**
   Verify the session driver in the `.env` file:
   ```env
   SESSION_DRIVER=file
   ```
   Clear session files if necessary:
   ```bash
   php artisan session:clear
   ```

3. **Increase Session Lifetime:**
   Extend the session lifetime in `config/session.php`:
   ```php
   'lifetime' => 120,
   ```

4. **Clear Cache:**
   Run the following commands to clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

### Debugging
Use Laravel's logs to identify the root cause of the error. Check `storage/logs/laravel.log` for detailed error messages.

---

## Additional Notes

- The login functionality uses Laravel's built-in authentication features.
- Debugging can be done by logging errors in `storage/logs/laravel.log`.
- For advanced debugging, use the `/debug-superadmin` route to inspect user data directly from the database.

---

## API Documentation

### Login API

#### Endpoint
`POST /login`

#### Request

**Headers:**
- `Content-Type: application/json`
- `Accept: application/json`
- `X-CSRF-TOKEN`: CSRF token for security

**Body:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

#### Response

**Success:**
```json
{
  "success": true,
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com",
    "role": "user"
  },
  "role": "user"
}
```

**Failure:**
```json
{
  "success": false,
  "message": "Email atau kata sandi yang diberikan tidak cocok."
}
```

---

### Logout API

#### Endpoint
`POST /logout`

#### Request

**Headers:**
- `Content-Type: application/json`
- `Accept: application/json`
- `Authorization`: Bearer token (if applicable)

#### Response

**Success:**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

**Failure:**
```json
{
  "success": false,
  "message": "Terjadi kesalahan saat logout."
}
```

---
