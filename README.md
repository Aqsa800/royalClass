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

1. Setup and Installation
2. Running Migrations for Specific Modules
3. Uploading and Viewing Documents
4. Modular Architecture
5. Database Seeders
6. Encryption and Security
7. API Endpoints

---

## Setup and Installation

1. **Clone the repository and setup the project**:
   ```bash
   git clone https://github.com/Aqsa800/royalClass.git
   cd royalClass
   composer install
   cp .env.example .env
   php artisan key: generate (Update the .env file)
   php artisan migrate
   php artisan db:seed

2. **Running Migrations for Specific Modules**:
    The project is built with a modular architecture. To run migrations for a specific module, use the php artisan migrate:module command. Here's how to run migrations for a specific module:
    ```bash
    php artisan migrate:module General
    php artisan migrate:module Motors
    php artisan migrate:module Jobs

3. **Uploading and Viewing Documents**:
    For Uploading and Viewing Documents, the user has to login and admin right user can upload and view the document.

    To upload a document (header + body):

        API Endpoint(HTTP):
           POST /api/general/documents HTTP/1.1
           Accept: application/json
           Content-Type: application/x-www-form-urlencoded
           Authorization: Bearer TOken
           Content-Length: 56
           title=Test%20Title&header=Test%20Header&body=Test%20Body


   
View Document
To view a document, use the GET endpoint /api/documents/{document_id}:


     API Endpoint(HTTP):
     POST /api/general/documents/{document_id} HTTP/1.1
            Accept: application/json
            Content-Type: application/x-www-form-urlencoded
            Authorization: Bearer TOken
            Content-Length: 56



This endpoint combines the encrypted header and body, decrypts them, and returns the combined content.

4. **Modular Architecture**:

This project is structured using the Laravel Modules package, which helps keep the project modular and organized. Each module (General, Motors, Jobs) has:
        Controllers: Handles business logic for documents within the module.
        Models: Eloquent models for the tables related to the module.
        Migrations: Module-specific migrations for database tables.
        Routes: Routes for the module’s API endpoints.
        Services: Utility classes that may be used by the controllers.

    
        Modules/
        ├── General/
        │   ├── Controllers/
        │   │   └── DocumentController.php       
        │   ├── Models/
        │   │   └── Document.php                 
        │   ├── Database/migrations/
        │   │   └── create_document_headers_table.php   
                └── create_document_bodies_table.php   
        │   ├── Routes/
        │   │   └── api.php                      
        │   └── Services/
        │       └── DocumentService.php         
        ├── Jobs/
        │   ├── Controllers/
        │   │   └── DocumentController.php      
        │   ├── Models/
        │   │   └── Document.php                
        │   ├── Database/migrations/
        │   │   └── create_document_headers_table.php   
                └── create_document_bodies_table.php   
        │   ├── Routes/
        │   │   └── api.php                      
        │   └── Services/
        │       └── DocumentService.php          
        ├── Motors/
        │   ├── Controllers/
        │   │   └── DocumentController.php       
        │   ├── Models/
        │   │   └── Document.php                 
        │   ├── Database/migrations/
        │   │   └── create_document_headers_table.php   
                └── create_document_bodies_table.php   
        │   ├── Routes/
        │   │   └── api.php                     
        │   └── Services/
        │       └── DocumentService.php         




This modular approach allows for easy scalability and management of different types of documents, such as General, Motors, and Jobs.

4. **Database Seeders**:

To test with dummy data, run php artisan db:seed. it will create the two users
    1- Admin User,(Email=>admin@example.com, Password:password) with admin role (can upload and view documents)
    2- Regular User,(Email=>user@example.com, Password:password) with user role



4. **Endpoint API**:
   
   
   ```bash
    Login:
       POST /api/login HTTP/1.1
       Host:
       Accept: application/json
       Content-Type: application/x-www-form-urlencoded
       Content-Length: 43
       password=password&email=admin%40example.com

    Logout:
       POST /api/logout HTTP/1.1
       Host: royalclass4.test
       Accept: application/json
       Authorization: Bearer Token
   
    To upload a document (header + body):
            POST /api/general/documents HTTP/1.1
            Accept: application/json
            Content-Type: application/x-www-form-urlencoded
            Authorization: Bearer Token
            Content-Length: 56
            title=Test%20Title&header=Test%20Header&body=Test%20Body

    To view a document:
            GET /api/general/documents/{document_id} HTTP/1.1
            Accept: application/json
            Authorization: Bearer Token

    To get the document list:
            GET /api/general/documents HTTP/1.1
            Accept: application/json
            Authorization: Bearer Token
