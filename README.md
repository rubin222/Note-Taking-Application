# NoteMan: A Note Taking application

## Overview
**NoteMan** is a web-based note-taking application built with **Laravel**. Users can register, log in, create categories, and manage their notes securely. JWT authentication is used for API access.

## Features
- **User Authentication**
  - Registration and login using email and password
  - JWT-based authentication for APIs

- **Categories**
  - Create, edit, and delete categories
  - Assign color codes to categories
  - List all categories with note counts

- **Notes**
  - Create, edit, and delete notes within categories
  - Search notes by title
  - Notes linked to specific users and categories

- **Responsive UI**
  - Built with **Tailwind CSS**
  - Works on desktop

## Tech Stack
- **Backend:** Laravel,PHP 
- **Frontend:** Blade templates, Tailwind CSS
- **Database:** SQLite
- **Authentication:** JWT Auth


## Installation

### 1. Clone the Repository
git clone https://github.com/rubin222/Note-Taking-Application.git
cd Note-Taking-Application

### 2. Install Dependencies
composer install
npm install
npm run dev

### 3. Copy Environment File
cp .env.example .env

### 4. Generate Application Key
php artisan key:generate

### 5. Configure Environment
In .env file, setup:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

### 6. Generate JWT Secret
php artisan jwt:secret

### 7. Run Migrations
php artisan migrate

### 8. Start Development Server
php artisan serve
Now open your browser at http://127.0.0.1:8000






