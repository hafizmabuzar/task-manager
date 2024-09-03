# Task Manager CRUD (Laravel & Vuejs)

## Overview

This is a simple Task Manager application built with Laravel for the backend and Vue.js for the frontend. It allows users to create, view, update, and delete tasks.

## Requirements

- PHP 7.4 or higher
- Composer
- Node.js (v14.x or higher)
- npm

## Setup Instructions

### Backend (Laravel)

1. git clone https://github.com/hafizmabuzar/task-manager.git
2. cd task-manager
3. composer install
3. chmod -R 777 storage/
4. cp .env.example .env
5. php artisan key:generate
6. php artisan migrate

### Frontend (Vuejs)

1. cd task-manager-frontend
2. npm install
3. npm run serve
