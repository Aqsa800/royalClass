# Secure Modular Document Management System with Encrypted Storage

## Problem Statement

This project implements a secure modular document management system where the document's header and body are stored separately in an encrypted format. The user can view the document only when both parts are decrypted and combined.

The system is modular, allowing different categories of documents (General, Motors, Jobs) to have separate migrations, models, and controllers.

## Features

- Encrypted storage of document header and body.
- Modular architecture for document categories.
- Role-based API access control.
- Secure document viewing by combining header and body.
- Migrations executed conditionally by module.

## Modules

1. **General**: Generic document management.
2. **Motors**: Automotive-related documents.
3. **Jobs**: Job-related documents.

## Table of Contents

1. [Setup and Installation](#setup-and-installation)
2. [Running Migrations for Specific Modules](#running-migrations-for-specific-modules)
3. [Uploading and Viewing Documents](#uploading-and-viewing-documents)
4. [Modular Architecture](#modular-architecture)
5. [Database Seeders](#database-seeders)
6. [Encryption and Security](#encryption-and-security)
7. [API Endpoints](#api-endpoints)

---

## Setup and Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/laravel-secure-doc-system.git
   cd laravel-secure-doc-system
1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/laravel-secure-doc-system.git
   cd laravel-secure-doc-system
2. Install dependencies:


    composer install
3. Set up the .env file:
cp .env.example .env
php artisan key:generate
4. 
Create and set up the database:

Update the .env file with your database credentials.
5. Run migrations for the default database structure:

php artisan migrate
php artisan db:seed


2.Running Migrations for Specific Modules
The project is built with a modular architecture. To run migrations for a specific module, use the php artisan migrate:module command. Here's how to run migrations for a specific module:

bash
Copy code
php artisan migrate:module General
php artisan migrate:module Motors
php artisan migrate:module Jobs


Uploading and Viewing Documents
Upload Document
To upload a document (header + body), use the POST endpoint /api/documents:

API Endpoint:

http
Copy code
POST /api/documents
Request Body:

json
Copy code
{
  "header": "encrypted_header_content",
  "body": "encrypted_body_content"
}
View Document
To view a document, use the GET endpoint /api/documents/{id}:

API Endpoint:

http
Copy code
GET /api/documents/{id}
This endpoint combines the encrypted header and body, decrypts them, and returns the combined content.



Modular Architecture
This project is structured using the Laravel Modules package, which helps keep the project modular and organized. Each module (General, Motors, Jobs) has:

Controllers: Handles business logic for documents within the module.
Models: Eloquent models for the tables related to the module.
Migrations: Module-specific migrations for database tables.
Routes: Routes for the module’s API endpoints.
Services: Utility classes that may be used by the controllers.
Example: General Module Structure
plaintext
Copy code
modules/
├── General/
│   ├── Controllers/
│   │   └── DocumentController.php
│   ├── Models/
│   │   └── Document.php
│   ├── Database/migrations/
│   │   └── create_documents_table.php
│   ├── Routes/
│   │   └── api.php
│   └── Services/
│       └── DocumentService.php
This modular approach allows for easy scalability and management of different types of documents, such as General, Motors, and Jobs.



Database Seeders
To test with dummy data, use the following seeder classes. The example below demonstrates how to seed dummy users and documents.

UserSeeder
php
Copy code
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create users
        $adminUser = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password')
        ]);
        $regularUser = User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Regular User',
            'password' => Hash::make('password')
        ]);

        // Attach roles
        $adminUser->roles()->attach($adminRole->id);
        $regularUser->roles()->attach($userRole->id);
    }
}
DocumentSeeder
php
Copy code
use Illuminate\Database\Seeder;
use Modules\General\Models\Document;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        // Creating dummy document data
        Document::create([
            'title' => 'Sample Document',
            'encrypted_header' => encrypt('Sample header content'),
            'encrypted_body' => encrypt('Sample body content')
        ]);
    }
}
Run the seeders with:

bash
Copy code
php artisan db:seed


