# SAO Event Management System

A comprehensive Laravel 12 web application for managing school events and participants. Built with modern Laravel practices, this system provides a complete solution for event organizers to create, manage, and track events with participant management capabilities.

## 📋 Features

### Core Features
- **Event Management**
  - Create, read, update, and delete events
  - Automatic status tracking (Upcoming, Ongoing, Done)
  - Search and filter events by title and status
  - Event details with description and venue information

- **Participant Management**
  - Add, edit, and delete participants for events
  - Track participant information (name, course, year level, email, contact)
  - Search and filter participants by name, course, and year level
  - Participant registration history

- **Dashboard Analytics**
  - Total events count
  - Total participants count
  - Event status distribution (Upcoming, Ongoing, Completed)
  - Recent events overview
  - Quick event management actions

- **Authentication**
  - Secure admin login/logout
  - Session-based authentication
  - Registration for new admins (optional)
  - Protected routes with middleware

### UI/UX Features
- Modern, responsive design with Bootstrap 5
- Clean sidebar navigation
- Intuitive data tables with pagination
- Search and filter functionality
- Status badges with color coding
- Real-time feedback with flash messages
- Mobile-friendly interface

## 🛠 Technology Stack

- **Framework**: Laravel 12
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Frontend**: Bootstrap 5, Blade Templating
- **ORM**: Eloquent
- **Authentication**: Laravel Session
- **Validation**: Form Request Validation
- **Authorization**: Policy-based (Gate)

## 📦 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & npm (optional, for asset compilation)

### Step 1: Navigate to Project Directory
```bash
cd c:\Users\Admin\Desktop\Jashen\web-projects\ipt\events-management-system
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Environment Configuration
Create or update .env file:
```bash
APP_NAME="SAO Event Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sao_events
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Create Database
```bash
# Using MySQL command line
mysql -u root -p
CREATE DATABASE sao_events;
EXIT;
```

### Step 6: Run Migrations
```bash
php artisan migrate
```

### Step 7: Seed Database (Optional - Adds Demo Data)
```bash
php artisan db:seed
```

This creates:
- Admin: **username: `admin`**, **password: `password123`**
- 4 sample events
- 20+ sample participants

### Step 8: Start Development Server
```bash
php artisan serve
```

Access at: `http://localhost:8000`

## 🔐 Default Credentials

- **Username**: `admin`
- **Password**: `password123`

⚠️ **Change immediately in production!**

## 📂 Project Structure

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── EventController.php
│   ├── ParticipantController.php
│   └── Auth/
├── Models/
│   ├── Admin.php
│   ├── Event.php
│   └── Participant.php
├── Policies/
│   └── EventPolicy.php
└── Http/Requests/

database/migrations/
└── seeders/

resources/views/
├── layouts/app.blade.php
├── auth/
├── events/
└── participants/

routes/web.php
```

## 📊 Database Schema

**admins**: admin_id, username, email, password, full_name, timestamps
**events**: event_id, admin_id (FK), title, description, venue, event_date, status, timestamps  
**participants**: participant_id, event_id (FK), full_name, course, year_level, email, contact_number, timestamps

## 🚀 Usage Guide

### Create Event
1. Login → Click "Events" → "Create New Event"
2. Fill details (title, description, venue, date)
3. Submit to create

### Manage Participants
1. Select an event
2. Click "Manage Participants"
3. Add, edit, or delete participants

### Dashboard
View statistics and recent events at a glance

### Search & Filter
- Events: by title or status
- Participants: by name, course, or year level

## 🔄 Event Status Logic

- **Upcoming**: Event date in future
- **Ongoing**: Event date is today
- **Done**: Event date passed

Status updates automatically based on current date.

## ✅ Validation Rules

**Events**:
- Title: required, max 255 chars
- Description: required, min 10 chars
- Venue: required
- Date: required, future date

**Participants**:
- Full Name: required
- Course: required
- Year Level: required
- Email: required, valid format
- Contact: required

## 🔒 Security

- CSRF Protection
- Password hashing (bcrypt)
- Session authentication
- Authorization policies
- Input validation
- XSS protection
- SQL injection prevention

## 🐛 Troubleshooting

```bash
# Database connection error
# Check .env configuration and ensure MySQL is running

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Rollback migrations
php artisan migrate:rollback
php artisan migrate
```

## 📚 Routes

**Auth**: `/login`, `/register`, `/logout`
**Dashboard**: `/dashboard`
**Events**: `/events`, `/events/create`, `/events/{id}/edit`, `/events/{id}`
**Participants**: `/events/{id}/participants`, `/events/{id}/participants/create`

## ✨ Best Practices Implemented

✅ Clean MVC architecture
✅ Eloquent relationships
✅ Route model binding
✅ Form request validation
✅ Authorization policies
✅ Responsive design
✅ Pagination
✅ Eager loading
✅ CSRF protection

## 📄 License

MIT License - See LICENSE file

