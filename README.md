# 🎓 Student Portal

A PHP-based student portal that allows students to log in, view courses, attendance, grades, notifications, and more. Admins can manage student records, course enrollment, and post notifications.

---

## 🚀 Getting Started

### 🧱 Requirements
- PHP 7.x or above
- MySQL Server (e.g., XAMPP, MAMP, WAMP)
- MySQL Workbench (optional)
- Apache Server (or any web server)

---

### 📥 Installation

1. **Clone the repository**

```bash
git clone https://github.com/mykeyyxd/student-portal.git
cd student-portal
```
2. **Import the database**
   - Open MySQL Workbench or phpMyAdmin.
   - Create a new schema named student_portal.
   - Copy the contents of schema.sql (provided in this repository) and run it to create all required tables and relationships.
or 
alternatively from the terminal
```MySQL
mysql -u your_username -p student_portal < schema.sql
```
replace the your_username with your MySQL username

3. **Config the Database connection**
  Open the configuration file (like config.php) and set your DB credentials:
```php
$host = 'localhost';
$user = 'root';
$password = ''; // Your MySQL password
$database = 'student_portal';
```
4. **Run the Project**
  Copy the project folder to your web server’s root directory (e.g., htdocs for XAMPP).
  Start Apache and MySQL.
  Visit: http://localhost/student-portal

### 🤝 Contributing
1. Fork the repository
2. Create your branch: git checkout -b feature/YourFeature
3. Commit your changes: git commit -m "Add new feature"
4. Push to the branch: git push origin feature/YourFeature
5. Open a Pull Request




