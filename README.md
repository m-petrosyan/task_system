# 🗓 Task Scheduling Tool

Lightweight internal tool for managers to create, assign, and track tasks, as well as monitor user availability.

---

## 🚀 Features

### Backend (Laravel)
- **Task Management**
  - List, create, update, delete tasks
  - Search tasks by title or description
- **User Availability**
  - View all users with current status
  - Toggle user availability
- **Basic Authentication**
  - Simple login for managers and users

### Frontend (Vue.js + TypeScript)
- **Task Board View**
  - Kanban or list-style display grouped by status
  - Filter by status or assignee
  - Search tasks by title/description
- **Task Assignment Modal**
  - Create/edit task with title, description, due date, assignee, and status
- **User Availability Toggle**
  - Toggle user availability in real-time
- **Responsive Admin Dashboard**

---

## ⚙️ Technical Requirements

- **Database:** MySQL (with indexes for search)
- **Seeders:** Prepopulate users and statuses
- **Optional Enhancements:**
  - Filters by status, assignee, due date
  - Docker containerization (backend + DB)
  - Task creation/assignment notifications (simulated or via websockets)

---

## 🧩 Setup Instructions

```bash
# Clone repository
git clone <repo-url>
cd task-scheduler

# Environment setup
cp .env.example .env
composer install
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Frontend setup
npm install
npm run dev

# Start server
php artisan serve
