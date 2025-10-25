# PHP Database MVC Tutorial

A comprehensive educational project for learning PHP database connectivity using the MVC (Model-View-Controller) architectural pattern. Master the fundamentals of database operations with PHP.

## Project Structure

```
php-database/
├── run.php                          # View Layer - Main Interface
├── Controller/
│   └── database-connection.php     # Controller Layer - DB Connection Manager
├── Model/
│   └── database-model.php          # Model Layer - Database Operations
├── Service/
│   └── database-service.php        # Service Layer - Business Logic
├── index.php                        # Welcome Page
├── test.php                         # System Test Page
├── config.php                       # Configuration File
├── database.sql                     # Database Schema
├── .htaccess                        # Apache Configuration
├── README.md                        # This File
├── SETUP.md                         # Detailed Setup Guide
├── QUICKSTART.md                    # Quick Start Guide
└── LICENSE
```

## Understanding MVC Architecture

### Model Layer
- **File**: `Model/database-model.php`
- **Role**: Handles direct database interactions
- **Features**:
  - Table creation
  - Data retrieval (SELECT)
  - Data insertion (INSERT)
  - Data update (UPDATE)
  - Data deletion (DELETE)

### View Layer
- **File**: `run.php`
- **Role**: Manages user interface presentation
- **Features**:
  - HTML page rendering
  - Form processing
  - Data display

### Controller Layer
- **File**: `Controller/database-connection.php`
- **Role**: Manages database connection
- **Features**:
  - Establishes MySQL connections
  - Connection error handling
  - Character encoding configuration

### Service Layer
- **File**: `Service/database-service.php`
- **Role**: Handles business logic
- **Features**:
  - Data validation
  - Business rule application
  - Mediates between Model and View

## Getting Started with XAMPP

### 1. Install XAMPP
1. Download from [XAMPP Official Website](https://www.apachefriends.org/)
2. Run the installer
3. Default installation path is `C:\xampp`

### 2. Start Apache and MySQL
1. Launch **XAMPP Control Panel**
2. Click the **Start** button for **Apache**
3. Click the **Start** button for **MySQL**
4. Verify both services show green "Running" status

### 3. Create Database
1. Open your browser and navigate to `http://localhost/phpmyadmin`
2. Click **New** in the left menu
3. Enter `testdb` as the database name
4. Select `utf8mb4_general_ci` for collation
5. Click **Create**

### 4. Deploy Project Files
Choose one of the following methods:

#### Method A: Copy to htdocs Folder
```powershell
# Run in PowerShell
Copy-Item -Recurse "c:\Users\<your_username>\Desktop\PHP-system\php-database" "C:\xampp\htdocs\php-database"
```

#### Method B: Create Symbolic Link
```powershell
# Run PowerShell as Administrator
New-Item -ItemType SymbolicLink -Path "C:\xampp\htdocs\php-database" -Target "c:\Users\<your_username>\Desktop\PHP-system\php-database"
```

### 5. Access the Application
Open your browser and navigate to:
```
http://localhost/php-database/run.php
```

## How to Use

### Step 1: Database Connection
1. Access `run.php`
2. Enter the following credentials:
   - **Server Name**: `localhost`
   - **Username**: `root`
   - **Password**: (leave blank)
   - **Database Name**: `testdb`
3. Click **Connect**

### Step 2: Create Table
1. After successful connection, click **Create Table**
2. The `users` table will be created

### Step 3: Add User
1. Enter name and email address
2. Click **Add User**

### Step 4: View Users
1. Click **Show Users**
2. Registered users will be displayed

## Database Table Structure

### users Table
| Column Name | Data Type | Description |
|-------------|-----------|-------------|
| id | INT(11) | Primary Key (Auto-increment) |
| name | VARCHAR(100) | User Name |
| email | VARCHAR(100) | Email Address (Unique) |
| created_at | TIMESTAMP | Creation Timestamp (Auto-set) |

## Security Features

This project implements the following security measures:

1. **Prepared Statements**: Protection against SQL injection attacks
2. **Input Validation**: Data validation and sanitization
3. **HTML Escaping**: Prevention of XSS (Cross-Site Scripting) attacks
4. **Error Handling**: Safe error management through exception handling

## Troubleshooting

### Issue: "Connection failed: Access denied"
**Solution**: 
- Verify username and password are correct
- Ensure XAMPP MySQL is running

### Issue: "Unknown database 'testdb'"
**Solution**: 
- Create `testdb` database in phpMyAdmin
- Check for spelling errors in database name

### Issue: Page not displaying
**Solution**: 
- Verify XAMPP Apache is running
- Confirm correct URL (`http://localhost/php-database/run.php`)
- Ensure files are in the correct location

### Issue: "Table 'users' doesn't exist"
**Solution**: 
- Click **Create Table** button
- Manually create table via phpMyAdmin

## Learning Objectives

### 1. Understanding MVC Architecture
- Separation of concerns across layers
- Code reusability
- Improved maintainability

### 2. Database Operations Fundamentals
- CRUD operations (Create, Read, Update, Delete)
- SQL query execution
- Prepared statements

### 3. PHP Best Practices
- Error handling
- Security measures
- Code organization

### 4. Session Management
- Starting sessions
- Storing and retrieving data
- Session destruction

## Customization Guide

### Adding New Tables
1. Add new methods to `Model/database-model.php`
2. Implement business logic in `Service/database-service.php`
3. Create UI in `run.php`

### Adding New Features
1. Implement required database operations in Model
2. Add business logic in Service
3. Create user interface in View

## Reference Resources

- [PHP Official Documentation](https://www.php.net/manual/en/)
- [MySQLi Documentation](https://www.php.net/manual/en/book.mysqli.php)
- [XAMPP Official Website](https://www.apachefriends.org/)
- [MVC Pattern Overview](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)

## System Requirements

- **PHP**: 7.4 or higher (recommended)
- **MySQL**: 5.7 or higher
- **Web Server**: Apache (included with XAMPP)
- **Browser**: Latest version of Chrome, Firefox, Edge, or Safari

## Contributing

Suggestions for improving this educational material and bug reports are welcome!

## License

For licensing information, please refer to the [LICENSE](LICENSE) file.

---

**Happy Coding!**