# Service Quality Feedback System

A web-based anonymous service evaluation platform built with PHP and PostgreSQL, designed to be used on tablet devices in different sectors of an organization.

## Key Features

- **Dynamic Content**: Questions are loaded dynamically from the database.
- **Anonymity**: No personal data is collected during the evaluation process.
- **Flexible Scoring**: Supports score-based answers (e.g., 0–10 or 0–5).
- **User Feedback**: Includes an optional comment/feedback field for qualitative data.
- **Administrative Panel**: Allows administrators to manage questions, register devices, and view results and averages per sector.

## Technologies Used

- **Backend**: PHP
- **Database**: PostgreSQL
- **Frontend**: HTML, CSS, JavaScript

## Database Schema

The database consists of the following tables:

- `evaluations`: Stores the responses to the evaluation questions.
- `questions`: Contains the questions to be displayed in the evaluation form.
- `devices`: Manages the devices (tablets) used for submitting evaluations.
- `sectors`: Represents the different sectors of the organization.
- `admin_users`: Stores the credentials for the administrative users.

For the complete database schema, please refer to the [`sql/database.sql`](sql/database.sql) file.

## Installation

To set up the project locally, follow these steps:

1.  **Clone the repository**:

    ```bash
    git clone https://github.com/marcs-sus/service-feedback-web.git
    cd service-feedback-web
    ```

2.  **Database Setup**:

    - Create a PostgreSQL database named `feedback_system`.
    - Execute the `sql/database.sql` script to create the necessary tables.

3.  **Configuration**:

    - Update the `config.php` file with your PostgreSQL database credentials.

4.  **Running the Application**:
    - Serve the `public` directory with a web server (e.g., Apache, Nginx).
