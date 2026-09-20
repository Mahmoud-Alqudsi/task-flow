# 🛡️ Security in TaskFlow

## Protection Layers

### 1. SQL Injection Prevention
- **Mechanism**: Prepared Statements with PDO
- **Application**: All queries in Repositories
- **Example**:
  ```php
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  ```

### 2. XSS (Cross-Site Scripting) Prevention
- **Mechanism**: `htmlspecialchars()` on all output
- **Application**: All View files
- **Example**:
  ```php
  <?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?>
  ```

### 3. CSRF (Cross-Site Request Forgery) Prevention
- **Mechanism**: Random token per session
- **Application**: All POST forms
- **Example**:
  ```php
  <?= \App\Security\CsrfToken::field() ?>
  ```

### 4. Password Protection
- **Mechanism**: `password_hash()` with Argon2id
- **Application**: On registration and update
- **Verification**: `password_verify()` on login

### 5. Session Protection
- Session ID regeneration after login
- Complete session destruction on logout
- HttpOnly and Secure cookie flags recommended

## What We Don't Do (Intentionally)

- ❌ Never display SQL errors to users
- ❌ Never store passwords in plain text
- ❌ Never use `addslashes()` as protection
- ❌ Never use `SELECT *` in production queries
- ❌ Never trust client-side validation alone

## Testing Security

To verify security, try these inputs in search fields:

```
1. '
2. ' OR '1'='1
3. '; DROP TABLE users; --
4. <script>alert('XSS')</script>
5. <img src=x onerror=alert('XSS')>
```

**Expected Result**: All attempts fail. No errors. No breach.