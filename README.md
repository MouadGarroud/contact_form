# contact_form

This project is a web-based contact form with backend functionality that allows users to send messages via a popup interface. It includes validations and restrictions, such as limiting users to one message per hour.

## Features
- **User-friendly Design:** Popup form with clear input fields and icons.
- **Validation:** Enforces input length, format (email, phone, etc.), and required fields.
- **Database Integration:** Stores user messages in a MySQL database.
- **Rate Limiting:** Restricts users to one message submission per hour.

## Technologies Used
- **Frontend:** HTML, CSS, Font Awesome icons.
- **Backend:** PHP, MySQL.
- **Database:** MySQL for storing user data.

## Prerequisites
- A web server (e.g., Apache) with PHP support.
- MySQL installed and running.
- A database named `test` with a table `contact` created using the following SQL:
  ```sql
  CREATE TABLE contact (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(50) NOT NULL,
      email VARCHAR(50) NOT NULL,
      phone VARCHAR(15),
      web VARCHAR(100),
      msg TEXT NOT NULL,
      date DATETIME NOT NULL
  );
