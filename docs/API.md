# 📡 Application Routes

## Authentication

| Method | Route | Description | Protection |
|--------|-------|-------------|------------|
| GET | `/login` | Login page | Guest only |
| POST | `/login` | Process login | CSRF |
| GET | `/register` | Registration page | Guest only |
| POST | `/register` | Process registration | CSRF |
| POST | `/logout` | Logout | CSRF + Auth |

## Tasks

| Method | Route | Description | Protection |
|--------|-------|-------------|------------|
| GET | `/tasks` | Task list with search & pagination | Auth |
| GET | `/tasks/create` | Create form | Auth |
| POST | `/tasks/store` | Save task | Auth + CSRF |
| GET | `/tasks/{id}` | View task | Auth |
| GET | `/tasks/{id}/edit` | Edit form | Auth |
| POST | `/tasks/{id}/update` | Update task | Auth + CSRF |
| POST | `/tasks/{id}/delete` | Delete task | Auth + CSRF |

## Categories

| Method | Route | Description | Protection |
|--------|-------|-------------|------------|
| GET | `/categories` | Category list | Auth |

## Dashboard

| Method | Route | Description | Protection |
|--------|-------|-------------|------------|
| GET | `/dashboard` | Statistics | Auth |

## Query Parameters (GET /tasks)

| Parameter | Type | Description |
|-----------|------|-------------|
| `search` | string | Text search in title/description |
| `status` | enum | Filter by status |
| `priority` | enum | Filter by priority |
| `page` | int | Page number for pagination |