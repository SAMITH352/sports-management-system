# 🏆 KCT Sports Hub – Sports Management System

**KCT Sports Hub** is a **web-based Sports Management System** built to organize and manage sports events, match schedules, scoreboards, and user roles in a centralized platform.
The system is designed for colleges, institutions, or sports organizations to manage **players, organizers, officials, and viewers** efficiently.

This project supports **multiple sports**, **role-based dashboards**, **match scheduling**, **official assignment**, and **live score/schedule management**, making it a complete solution for handling sports tournaments digitally.

---

# 📌 Project Overview

Managing sports events manually can be difficult when there are multiple teams, players, matches, schedules, and officials involved.
**KCT Sports Hub** simplifies this process by providing a centralized system where:

* **Players** can log in and view sports-related information
* **Organizers** can manage schedules and tournament flow
* **Officials** can view assigned matches and update match-related data
* **Viewers** can check schedules, match updates, and scoreboards

The project is built to improve sports event coordination, communication, and visibility through a simple web platform.

---

# ✨ Features

## 🔐 Authentication & User Management

* User signup and login system
* Session-based authentication
* Logout functionality
* Profile management
* Multi-role access support

## 👥 Multi-Role Dashboard System

The application includes dedicated dashboards for different user roles:

* **Player Dashboard**
* **Organizer Dashboard**
* **Official Dashboard**
* **Viewer Dashboard**

Each role can access the features relevant to them.

## 🗓️ Match Schedule Management

* Add match schedules
* Edit schedules
* Delete schedules
* Update schedules
* Fetch and display schedules
* Manage sports event timing and planning

## 🧑‍⚖️ Official Assignment

* Assign officials to matches
* View assigned matches
* View assignment details

## 📊 Scoreboard Management

* Update scoreboard
* View scoreboard
* Maintain match score records

## 🏅 Sports Categories

The platform includes dedicated pages for different sports such as:

* Cricket
* Football
* Hockey
* Tennis

## 👤 User Profile & Session Handling

* Profile page for logged-in users
* Session testing / session validation support

---

# 🧩 Project Structure

```bash id="dsv5r5"
sports-management-system/
│
├── assets/                        # Images, CSS, JS, and other static resources
├── dashboards/                    # Dashboard-related files / resources
│
├── add_schedule.php               # Add new sports/match schedule
├── assign_official.php            # Assign officials to matches
├── assigned_matches.php           # List of matches assigned to officials
├── db_connect.php                 # Database connection file
├── delete_schedule.php            # Delete an existing schedule
├── edit_schedule.php              # Edit schedule details
├── fetch_schedules.php            # Fetch schedule data
├── login.php                      # Login backend processing
├── logout.php                     # Logout and session destroy
├── manage_schedules.php           # Organizer/admin schedule management
├── profile.php                    # User profile page
├── session_test.php               # Session validation / testing
├── signup.php                     # User registration backend
├── update_schedule.php            # Update schedule data
├── update_scoreboard.php          # Update match scoreboard
├── view_assignments.php           # View official assignments
├── view_schedule.php              # View sports schedule
├── view_scoreboard.php            # View scoreboard
│
├── index.html                     # Main landing page
├── login.html                     # Login UI page
├── signup.html                    # Signup UI page
│
├── dashboard_player.html          # Player dashboard UI
├── dashboard_organizer.html       # Organizer dashboard UI
├── dashboard_official.html        # Official dashboard UI
├── dashboard_viewer.html          # Viewer dashboard UI
│
├── cricket.html                   # Cricket page
├── football.html                  # Football page
├── hockey.html                    # Hockey page
├── tennis.html                    # Tennis page
│
├── update_scoreboard.html         # Scoreboard update UI
├── composer.json                  # Composer dependencies
├── composer.lock                  # Composer lock file
└── README.md                      # Project documentation
```

---

# 🛠️ Tech Stack

## Frontend

* **HTML**
* **CSS**
* **JavaScript**

## Backend

* **PHP**

## Database

* **MySQL**

## Development Environment

* **XAMPP / Localhost server**

## Dependency Management

* **Composer**

---

# 🎯 Core Modules

## 1. User Authentication Module

Handles:

* User registration (`signup.html`, `signup.php`)
* User login (`login.html`, `login.php`)
* Logout (`logout.php`)
* Session management (`session_test.php`)

This ensures only authenticated users can access their relevant dashboard and sports features.

---

## 2. Dashboard Module

The system provides separate dashboards for different roles:

### 👤 Player Dashboard

Players can:

* Access sports event information
* View schedules and scoreboards
* Stay updated with sports activities

### 🛠️ Organizer Dashboard

Organizers can:

* Add new match schedules
* Edit or delete schedules
* Manage tournament planning
* Oversee event coordination

### 🧑‍⚖️ Official Dashboard

Officials can:

* View assigned matches
* Access their duties
* Update match-related details where applicable

### 👀 Viewer Dashboard

Viewers can:

* Check schedules
* View scoreboards
* Follow sports events without needing management access

---

## 3. Schedule Management Module

This is one of the main parts of the system.

The schedule module allows organizers/admins to:

* **Add** new sports schedules
* **Edit** schedule details
* **Delete** schedules
* **Update** schedule information
* **Fetch** and display schedules to users

Related files:

* `add_schedule.php`
* `edit_schedule.php`
* `delete_schedule.php`
* `update_schedule.php`
* `fetch_schedules.php`
* `manage_schedules.php`
* `view_schedule.php`

---

## 4. Official Assignment Module

This module helps assign match responsibilities to officials.

Features:

* Assign officials to specific matches
* Track assigned matches
* View assignment details

Related files:

* `assign_official.php`
* `assigned_matches.php`
* `view_assignments.php`

---

## 5. Scoreboard Management Module

The scoreboard module is used to update and display match scores.

Features:

* Enter/update match score details
* View current scoreboard information
* Maintain score updates for viewers and participants

Related files:

* `update_scoreboard.html`
* `update_scoreboard.php`
* `view_scoreboard.php`

---

## 6. Sports Pages Module

The system supports different sports categories with dedicated pages:

* `cricket.html`
* `football.html`
* `hockey.html`
* `tennis.html`

This makes the project extensible and allows the platform to handle multiple sports under the same system.

---

# ⚙️ Installation & Setup Guide

## Prerequisites

Before running the project, make sure you have:

* **PHP 7.x or above**
* **MySQL / MariaDB**
* **Composer**
* **XAMPP / WAMP / Laragon**

---

## 1) Clone the Repository

```bash id="fqvwrd"
git clone https://github.com/SAMITH352/sports-management-system.git
```

---

## 2) Move the Project to Your Server Directory

If you are using **XAMPP**, place the project inside:

```bash id="poc6ni"
C:\xampp\htdocs\
```

Example:

```bash id="frq92q"
C:\xampp\htdocs\sports-management-system
```

---

## 3) Install Dependencies

If your project uses Composer packages, run:

```bash id="lcr1zc"
composer install
```

This will install dependencies listed in `composer.json`.

---

## 4) Create the Database

Open **phpMyAdmin** and create a database.

Example:

```sql id="om0k2q"
kct_sports_hub
```

---

## 5) Configure Database Connection

Open **`db_connect.php`** and update the database credentials.

Example structure:

```php id="tr12w7"
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kct_sports_hub";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

---

## 6) Import Database Tables

If you have an SQL file for the project, import it into the database using **phpMyAdmin**.

Typical tables in this project may include:

* users
* players
* officials
* organizers
* schedules
* assignments
* scoreboards

---

## 7) Start Apache and MySQL

Open **XAMPP Control Panel** and start:

* **Apache**
* **MySQL**

---

## 8) Run the Application

Open the browser and visit:

```bash id="q8jxj0"
http://localhost/sports-management-system/
```

---

# 👥 User Roles

## Player

A player can:

* Access the player dashboard
* View schedules
* Check scoreboards
* Follow sports updates

## Organizer

An organizer can:

* Manage sports schedules
* Add, edit, update, and delete match schedules
* Coordinate sports events

## Official

An official can:

* View assigned matches
* Track assignments
* Participate in event management workflow

## Viewer

A viewer can:

* View schedules
* View match scoreboards
* Access sports pages and event information

---

# 📄 Important Files Explained

## `index.html`

Main landing page of the application.

## `login.html` / `login.php`

User login interface and backend authentication logic.

## `signup.html` / `signup.php`

User registration interface and registration logic.

## `logout.php`

Ends the session and logs out the current user.

## `profile.php`

Displays user profile details.

## `db_connect.php`

Handles MySQL database connection.

## `manage_schedules.php`

Main page for schedule management.

## `add_schedule.php`

Adds a new match schedule.

## `edit_schedule.php`

Allows editing of an existing schedule.

## `delete_schedule.php`

Deletes a schedule.

## `update_schedule.php`

Updates schedule information.

## `fetch_schedules.php`

Retrieves schedule records from the database.

## `assign_official.php`

Assigns officials to matches.

## `assigned_matches.php`

Displays matches assigned to an official.

## `view_assignments.php`

Shows assignment details.

## `update_scoreboard.php`

Handles scoreboard updates.

## `view_scoreboard.php`

Displays scoreboards to users.

---

---

# 🌟 Use Cases

This project can be used for:

* College sports event management
* Tournament schedule planning
* Sports club management systems
* Multi-role sports coordination platforms
* Final year academic projects
* Sports administration dashboards

---
