# SSL Certificate Checker

A simple **PHP CLI tool** to check SSL certificate details for any domain.

## Features
- Fetches SSL certificate details for a given domain.
- Displays certificate validity period.
- Shows issuer (Certificate Authority).
- Extracts organization and email (if available).
- Works in both **CLI mode** and **web mode**.

## Requirements
- PHP 7.4 or later.
- OpenSSL extension enabled.

## Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/naseeraslam/tech-blogs.git
   cd ssl-certifcate-checker
   ```
2. Ensure PHP is installed and accessible via the command line:
   ```sh
   php -v
   ```
3. Make the script executable (optional):
   ```sh
   chmod +x ssl-checker.php
   ```

## Usage
### CLI Mode
To check an SSL certificate via the command line:
```sh
php ssl-checker.php example.com
```
Or, if you didn’t pass a domain argument, the script will prompt you:
```sh
php ssl-checker.php
Enter a domain name: example.com
```

### Web Mode (if hosted on a server)
Upload `ssl-checker.php` to your server and access it via a browser:
```url
https://yourdomain.com/ssl-checker.php?domain=example.com
```

## Example Output
```sh
SSL Certificate Details for example.com:
Valid From: 2024-01-01 12:00:00
Valid To: 2025-01-01 12:00:00
Issuer (CA): Let's Encrypt
Subject (CN): example.com
Organization: Example Inc.
Organizational Unit: IT Department
Email (if available): admin@example.com
Serial Number: 03A9F1ABCD123456789
```

## Troubleshooting
- If you get an error like `Unable to connect to example.com`, ensure the domain has an active SSL certificate.
- Ensure PHP has OpenSSL enabled by running:
  ```sh
  php -m | grep openssl
  ```

## License
This project is licensed under the **MIT License**. Feel free to modify and distribute it.

## Contributing
Pull requests are welcome! If you find any issues or want improvements, open an issue on GitHub.

## Author
- **MUHAMMAD NASEER ASLAM** - [GitHub Profile](https://github.com/naseeraslam)
