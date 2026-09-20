# 🏗️ TaskFlow Architecture

## Overview

TaskFlow follows a **simplified MVC pattern** without any framework, demonstrating the fundamental principles that power modern web frameworks.

```
Browser → Router → Controller → Repository → Database (PDO)
                        ↓
                      View → Browser
```

## Application Layers

### 1. Presentation Layer (Views)
- Simple PHP files with HTML
- No business logic
- All output protected with `htmlspecialchars()`
- Layout system with content injection

### 2. Control Layer (Controllers)
- Receive requests from the Router
- Coordinate between Repositories and Views
- No direct SQL queries
- Apply role-based access control

### 3. Data Access Layer (Repositories)
- Interact with database via PDO
- Use Prepared Statements exclusively
- Return typed Entity objects
- Encapsulate all query logic

### 4. Domain Layer (Models & Enums)
- `readonly` classes representing data
- No database logic
- Use PHP 8.4 features (constructor promotion, readonly)
- Backed Enums for type safety

## Architectural Decisions

| Decision | Rationale |
|----------|-----------|
| PDO instead of mysqli | Supports 12+ databases, unified interface |
| Singleton for Database | Single efficient connection across app |
| Repositories over SQL in Controllers | Separation of concerns, testability |
| Enums over constants | Type safety, helper methods |
| MVC without framework | Understand fundamentals before frameworks |
| PSR-4 Autoloading | Industry standard, Composer integration |

## Request Lifecycle

1. **Request arrives** at `public/index.php` (Front Controller)
2. **Session starts** and CSRF token is generated
3. **Router matches** the URL pattern to a controller/action
4. **Middleware checks** authentication if required
5. **Controller processes** the request
6. **Repository fetches** data from database
7. **View renders** the response
8. **Response sent** to browser