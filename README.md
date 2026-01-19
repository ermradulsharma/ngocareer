# NGO Career

**NGO Career** is a web application built using the [CodeIgniter 3](https://codeigniter.com/) PHP framework. It serves as a platform for [Add specific purpose if known, e.g., connecting NGOs with job seekers].

## Requirements

- PHP 5.6 or newer (PHP 7.4 recommended)
- Composer (for dependency management)
- MySQL or MariaDB

## Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/ermradulsharma/ngocareer.git
    cd ngocareer
    ```

2.  **Install Dependencies:**
    This project uses Composer. Ensure you have the `vendor` directory. If `composer.json` is present, run:

    ```bash
    composer install
    ```

3.  **Database Setup:**
    - Create a new MySQL database.
    - Import the project's database schema (usually found in `database.sql` or similar, check `uploads` or backup zips if not in root).
    - Configure database connection settings in `application/config/database.php`.

4.  **Configuration:**
    - Open `application/config/config.php` and set your base URL:
      ```php
      $config['base_url'] = 'http://localhost/ngocareer/';
      ```
    - If necessary, configure `application/config/config.local.php` for local environment overrides.

5.  **Run the Application:**
    - You can use a local server like XAMPP/WAMP or the built-in PHP server:
      ```bash
      php -S localhost:8000
      ```
    - Visit `http://localhost:8000` in your browser.

## Contributing

We welcome contributions! Please see our [Contributing Guidelines](CONTRIBUTING.md) for details on how to submit pull requests, report issues, and request features.

- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Security Policy](SECURITY.md)

## License

This project is licensed under the [MIT License](LICENSE).
