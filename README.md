# CSV File Processor

A Laravel-based web application for uploading, processing, and managing CSV files with real-time job tracking. Built with Laravel 12, React, Inertia.js, and Laravel Horizon for queue management.

## Features

- 📁 **CSV File Upload**: Drag-and-drop or click-to-upload CSV files
- 🔄 **Asynchronous Processing**: Background job processing using Laravel Queues
- 📊 **Real-time Status Tracking**: Monitor file processing status with live updates
- 🗄️ **Product Data Management**: Automatically parse and store product data from CSV files
- 🎯 **Data Validation**: UTF-8 encoding conversion and data cleaning
- 📋 **Job Monitoring**: Track file processing history and status
- 🚀 **Modern UI**: React-based frontend with Tailwind CSS styling

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: React 18 with Inertia.js
- **Styling**: Tailwind CSS
- **Database**: SQLite (configurable)
- **Queue Management**: Laravel Horizon with Redis
- **Build Tool**: Vite
- **Job Processing**: Laravel Queue Jobs

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- Redis (for queue management)
- SQLite or MySQL/PostgreSQL

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/kaijie1023/csv-file-processor.git
   cd csv-file-processor
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   
   QUEUE_CONNECTION=redis
   REDIS_HOST=127.0.0.1
   REDIS_PASSWORD=null
   REDIS_PORT=6379
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

## Running the Application

1. **Start the Laravel development server**
   ```bash
   php artisan serve
   ```

2. **Start the Vite development server (in another terminal)**
   ```bash
   npm run dev
   ```

3. **Start Redis server**
   ```bash
   redis-server
   ```

4. **Start Laravel Horizon for queue processing (in another terminal)**
   ```bash
   php artisan horizon
   ```

5. **Access the application**
   Open your browser and visit: `http://localhost:8000`

## Usage

### Uploading CSV Files

1. Navigate to the main page
2. Either drag and drop a CSV file onto the upload area or click to select a file
3. Click the "Upload" button to start processing
4. Monitor the processing status in real-time

### Processing Status

Files can have the following processing statuses:
- **Pending**: File uploaded, waiting to be processed
- **Processing**: File is currently being processed
- **Completed**: File processing completed successfully
- **Failed**: File processing failed (check logs for details)


## File Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── CsvUploadController.php    # Handles file uploads and status
│   ├── Jobs/
│   │   └── ProcessCsvJob.php          # Background CSV processing job
│   └── Models/
│       ├── FileJob.php                # File processing job tracking
│       └── Product.php                # Product data model
├── database/
│   └── migrations/                    # Database schema migrations
├── resources/
│   └── js/Pages/
│       └── Main.jsx                   # Main React component
└── routes/
    └── web.php                        # Web routes
```

## Queue Management

The application uses Laravel Horizon for queue management. You can monitor jobs at:
`http://localhost:8000/horizon`

## Logging

Processing logs are stored in `storage/logs/laravel.log`. Monitor this file for:
- File processing start/completion
- Error messages
- Job status updates

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
