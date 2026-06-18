# Security Measures Implemented

## 1. Prepared Statements
The application uses MySQLi prepared statements for database operations such as user login, registration, creating posts, editing posts, deleting posts, and searching posts. This helps prevent SQL injection attacks.

## 2. Password Hashing
User passwords are securely stored using PHP's `password_hash()` function instead of plain text passwords.

## 3. Password Verification
During login, passwords are verified using PHP's `password_verify()` function.

## 4. Server-Side Validation
Input fields such as username, password, post title, and post content are validated on the server before processing.

## 5. Client-Side Validation
HTML validation attributes like `required` and `minlength` are used to improve user experience and reduce invalid submissions.

## 6. User Roles
The application supports two user roles:
- Admin
- Editor

The role is stored in the `users` table and managed using PHP sessions.

## 7. Role-Based Access Control
Only users with the `admin` role are allowed to delete posts. Editors have limited permissions.

## 8. Session Management
PHP sessions are used to maintain authenticated user sessions and protect restricted pages.

## 9. Output Escaping
User-generated content is displayed using `htmlspecialchars()` to reduce the risk of Cross-Site Scripting (XSS).

## Conclusion
The application implements multiple security measures including prepared statements, password hashing, input validation, role-based access control, and secure session handling to improve protection against common web vulnerabilities.