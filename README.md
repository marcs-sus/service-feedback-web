# Service Quality Feedback System

> Veja o [README em Português(Brasil)](README.pt-BR.md)

A web-based anonymous service evaluation platform designed for tablet deployment across organizational sectors. Collects real-time feedback through a user-friendly interface while providing administrators with comprehensive analytics and reporting capabilities.

## Features

- **Anonymous Evaluations**: Collects service feedback without storing personal data
- **Dynamic Questions**: Load questions by sector from the database
- **Multi-Language Support**: Built-in localization support
- **Score-Based Responses**: 0-10 scale rating system with visual feedback
- **Optional Comments**: Open-ended feedback field for qualitative data
- **Admin Dashboard**: Complete management panel with analytics and charts
- **Complete CRUD interfaces**: Manage tables via CRUD pages seamlessly
- **Evaluation Summaries**: Filter and review all submissions and feedback
- **Responsive Design**: Mobile-optimized interface suitable for tablet use
- **Session Security**: Secure session management with lifetime limit

## Technologies

- **Backend**: PHP 8.0+
- **Database**: PostgreSQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Charts**: Chart.js for data visualization

## Database

The system uses PostgreSQL with 7 core tables:

- `sectors` - Organizational divisions for categorizing questions
- `devices` - Tablet/device registrations for form deployment
- `questions` - Survey questions linked to sectors
- `question_translations` - Multi-language translations for questions
- `evaluations` - Individual response records (questions ref. + scores)
- `feedback` - Open-ended text comments from users
- `admin_users` - Administrator credentials for panel access

See [`sql/database.sql`](sql/database.sql) for the complete schema.

## Libraries & Dependencies

### PHP

- **vlucas/phpdotenv** ^5.6 - Environment configuration management
  - Used in [`config.php`](config.php) to load [`.env`](.env.example) file

### Frontend

- **Chart.js** ^4.5.1 - Interactive data visualization
  - Used in [`public/js/charts.js`](public/js/charts.js) to display charts in [`public/admin/dashboard.php`](public/admin/dashboard.php)

## Installation

### Prerequisites

- PHP 8.0 or higher
- PostgreSQL 12 or higher
- Composer (for PHP dependency management)
- Web server (Apache, Nginx, etc.)

### Setup Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/marcs-sus/service-feedback-web.git
   cd service-feedback-web
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install frontend dependencies**

   ```bash
   npm install
   ```

4. **Configure environment variables**

   ```bash
   cp .env.example .env
   ```

   Edit `.env` with your PostgreSQL credentials and application settings:

   ```
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=feedback_system
   DB_USER=postgres
   DB_PASSWORD=your_password
   DEFAULT_LOCALE=en_US
   ```

5. **Create the database**

   ```sql
   CREATE DATABASE feedback_system;
   ```

6. **Load the database schema**

   ```bash
   psql -U postgres -d feedback_system -f sql/database.sql
   ```

7. **Configure web server**

   - Point the document root to the `public` directory
   - Example for Apache: `DocumentRoot /path/to/service-feedback-web/public`

8. **Set proper permissions**

   ```bash
   chmod 755 public
   chmod 644 public -R
   ```

9. **Access the application**
   - Public form: [`http://localhost/`](http://localhost/)
   - Admin panel: [`http://localhost/admin/login_page.php`](http://localhost/admin/login_page.php)

## Project Structure

```
service-feedback-web/
├── public/                 # Web-accessible files
│   ├── admin/             # Admin panel pages
│   ├── css/               # Stylesheets
│   ├── js/                # Frontend JavaScript
│   ├── assets/            # Icons and images
│   ├── index.php          # Public evaluation form
│   └── thank.php          # Completion page
├── src/                   # Backend source code
│   ├── model/             # Data models (Device, Question, etc.)
│   ├── auth/              # Authentication logic
│   ├── crud_actions/      # Create, Read, Update, Delete operations
│   ├── locales/           # Translation files (JSON)
│   ├── db_conn.php        # Singleton Database connection
│   ├── query.php          # Query builder
│   └── session.php        # Session management
├── sql/                   # Database scripts
├── config.php             # Application configuration
└── .env.example          # Environment variables template
```

## Usage

### Public Form

1. Access the form at the root URL
2. Select your language (top-right selector)
3. Rate each question on a 0-10 scale
4. Optionally provide additional feedback
5. Submit the evaluation

### Admin Dashboard

1. Log in at `/admin/login_page.php`
2. Default credentials must be created in the database initially
3. Manage sectors, devices, and questions
4. View analytics and evaluation summaries

## Configuration

Edit `.env` to customize:

- Database connection details
- Application locale and timezone
- Session timeout
- Default device and sector IDs for form routing

## License

This project is under the MIT License - See [LICENSE](LICENSE) file for details
