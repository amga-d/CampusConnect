
# CampusConnect Project Setup Guide

This guide will walk you through the steps to set up and run the CampusConnect project on your local machine.

## Prerequisites
- MySQL Server installed and running.
- PHP installed on your system.

---

## Step 1: Set Up MySQL Database

1. **Start MySQL Server**  
   Open your terminal and log in to MySQL as the root user:
   ```bash
   mysql -u root
   ```

2. **Create a Database**  
   Create an empty database named `campusconnect`:
   ```sql
   CREATE DATABASE campusconnect;
   ```

3. **Exit MySQL**  
   Exit the MySQL shell:
   ```sql
   exit;
   ```

4. **Import Database Schema**  
   From the root folder of the CampusConnect project, run the following command to import the database schema:
   ```bash
   mysql -u root campusconnect < campusconnect.sql
   ```

---

## Step 2: Set Up the `.env` File

1. **Copy `.env.test` to `.env`**  
   In the root directory of the project, locate the `.env.test` file. Copy its contents into a new file named `.env`.

2. **Configure Database Settings**  
   Open the `.env` file and update the database configuration with your MySQL credentials. For example:
   ```env
   MYSQL_DB_HOST=localhost
   MYSQL_DB_USER=root
   MYSQL_DB_PASSWORD=""
   MYSQL_DB_NAME=campusconnect
   ```
   Replace the values with your actual database credentials if they differ.

---

## Step 3: Run the PHP Server

1. **Start the PHP Development Server**  
   Navigate to the project directory and start the PHP server:
   ```bash
   php -S localhost:8080
   ```

2. **Access the Application**  
   Open your browser and go to `http://localhost:8080` to access the CampusConnect application.

---

## Important Notes
- Do not use XAMPP's Apache server for this project. The built-in PHP server is sufficient.
- Ensure that MySQL is running before importing the database schema.
---

## Troubleshooting
- If you encounter any issues, ensure that MySQL and PHP are properly installed and configured on your system.
- Check that the database credentials in your `.env` file match those of your MySQL server.
- Verify that the `.env` file is correctly named and located in the root directory of the project.

---
# Running the Project Using Docker

To run the project using Docker, follow these steps:

#### 1. **Start the Docker Containers**
   - Run the following command to start the Docker containers in detached mode:
     ```bash
     docker compose up -d
     ```

#### 2. **Initialize the Database**
   - Access the MySQL server container:
     ```bash
     docker exec -it mysql-server bash
     ```
   - Inside the container, run the following command to initialize the database with the provided SQL file:
     ```bash
     mysql -u root campusconnect < /var/lib/mysql/campusconnect.sql
     ```
   - This process is only required once when initializing the dataset.

#### 3. **Create the `.env` File**
   - Create a `.env` file in your project root directory and paste the following content:
     ```env
     APP_NAME=CampusConnect
     MYSQL_DB_HOST=mysql-server
     MYSQL_DB_USER=root
     MYSQL_DB_PASSWORD=""
     MYSQL_DB_NAME=campusconnect
     ```

#### 4. **Run the Application**
   - Once the database is initialized and the `.env` file is configured, your application should be ready to run. Access it via the appropriate URL or port as defined in your Docker setup.

---


### Notes:
- Ensure that the `campusconnect.sql` file is placed in the correct location (`/var/lib/mysql/`) inside the MySQL container.
- The `.env` file is crucial for the application to connect to the MySQL database. Double-check the values to ensure they match your Docker configuration.
- If you make changes to the Docker setup or the database schema, you may need to restart the containers or reinitialize the database. 