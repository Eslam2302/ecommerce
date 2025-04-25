## 🛒 E-Commerce Project with PHP & MySQL

A basic E-commerce web application built using native PHP and MySQL. This project provides product browsing, user authentication, item management, and an admin dashboard.

---

### 🚀 Features

- ✅ Browse products by category  
- 👤 User registration & login  
- 🛍️ Add/Edit/Delete products (Admin)  
- 🧾 Shopping cart system (in progress)  
- 🔍 Filter products by category, price, or keywords  
- 📄 Pagination for product listings  
- 🧑‍💼 Admin dashboard to manage users, categories, and items  

---

### 🛠️ Tech Stack

- **Backend:** PHP (native, no frameworks)  
- **Database:** MySQL  
- **Frontend:** HTML5, CSS3, JavaScript, jQuery  
- **Server:** Apache via XAMPP  

---

### 📁 Project Structure

```
ecommerce/
├── admin/              # Admin panel pages
├── includes/           # Database connection & helper functions
├── layout/             # Layout templates (header, footer, etc.)
├── uploads/            # Uploaded images
├── index.php           # Homepage
├── categories.php      # Display items by category
├── items.php           # Individual item page
├── login.php           # User login
├── logout.php          # User logout
├── profile.php         # User profile
├── newad.php           # Add new item
├── init.php            # Project initializer (DB connect, includes)
└── assets/             # Images (e.g., mcro.png)
```

---

### ⚙️ How to Run Locally

1. **Clone the repository:**

```bash
git clone https://github.com/Eslam2302/ecommerce.git
```

2. **Create the database:**

- Open [phpMyAdmin](http://localhost/phpmyadmin)  
- Create a database named `ecommerce`  
- Import the SQL file if included, or build the schema manually based on the app

3. **Configure DB connection:**

Edit `includes/init.php` and set:

```php
$dsn = 'mysql:host=localhost;dbname=ecommerce';
$user = 'root';
$pass = '';
```

4. **Run the project:**

Visit:  
```
http://localhost/ecommerce/
```

---

### 🧠 To-Do / Improvements

- [x] File upload system  
- [x] Code cleanup and optimization  
- [x] UI color and layout enhancement  
- [x] Sub-category support  
- [ ] Shopping cart system  
- [ ] Search & filter improvements  
- [ ] Product review and rating  

---

### 📌 Notes

- Make sure Apache & MySQL are running (via XAMPP or similar).
- Admin credentials can be set manually from the database (`users` table).
- Project still under development and meant for learning purposes.

---

### 👤 Author

**Eslam2302**  
[GitHub Profile](https://github.com/Eslam2302)