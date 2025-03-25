# Task Manager

This project is a simple POC built with **Laravel** as the backend service and **Blade** with **Alpine.js CDN** for the frontend, providing a drag-and-drop task manager.

## Project Overview

The project follows the **SOLID principles** for the backend, particularly ensuring **single responsibility** in controllers. A **Task Service** is implemented to maintain the single responsibility principle and ensure scalability for future growth.

## Important Note
Make sure to run the seeder command in order to populate dummy data and test the POC
```bash
php artisan db:seed
```

### Implemented Features:
- **Display Task List**: View tasks with their priorities.
- **Project Dropdown**: Select a project to filter tasks.
- **Drag and Drop**: Rearrange tasks, automatically resetting the task priority in the database.
- **Sort by Priority**: Tasks are sorted based on their priority.

### To-Do:
- **Filter by Project**: Needs to be implemented.
- **Sort by Project**: Pending feature.
- **partially implemented Domain-Driven Design (DDD)

## Requirements

- PHP >= 8
- Composer
- MySQL 

## Setup Guide 

### Note : Ignore the "1. Clone the repository" if you setting up manually 


### 1. Clone the repository

```bash
git clone <repository_url>
cd <project_directory>
````

### 2. Install backend dependencies
```bash
composer install
```
### 3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```
Edit .env for your database and other settings.

### 4. Set up environment
```bash
php artisan migrate
php artisan db:seed
```

### 5. Serve the application
```bash
php artisan serve
```
Visit http://127.0.0.1:8000 in your browser.


