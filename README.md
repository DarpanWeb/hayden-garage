# Hayden's Garage

# Laravel 10 and Vue 3 Project

This is a starter project that combines Laravel 10 on the backend with Vue 3 on the frontend.

## Installation

Follow these steps to install the project locally:

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 20.x
- NPM or Yarn
- MySQL or any other compatible database

### Clone the repository

```bash
git clone https://github.com/yourusername/your-project.git
```

### Install Php Dependencies
composer install

### Install JavaScript dependencies
```
npm install   # If using npm
# or
yarn install  # If using Yarn
```

### Environment Configuration

- Duplicate the .env.example file and rename it to .env.
- Update the .env file with your local environment settings:
- Set DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD for database configuration.
- Set MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, and MAIL_FROM_ADDRESS for email SMTP configuration.
- Generate an application key by running:
```
php artisan key:generate
```

### Database Setup
- Create a new database in your MySQL server.
- Run the database migrations to create tables and seed the database with sample data:
``` 
  php artisan migrate 
  php artisan db:seed --class=SlotMasterSeeder
```

### Running the Application
```
php artisan serve
```
The application should now be running locally at http://localhost:8000.

### Compiling Assets
During development, you may want to compile assets such as JavaScript and CSS files. In this project, we use Vite for asset compilation. You can compile assets using the following commands:
```
npm run dev
```





  
  

