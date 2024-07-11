# Simple Laravel API with Job Queue, Database, and Event Handling test task

This README provides instructions how to run this project locally. Test task implemented on Laravel 11 by Vladlen Mikhalov

## Steps for Local Testing

### 1. Clone the Project

```bash
git clone git@github.com:vladowski/1datatec_test.git
cd 1datatec_test
```

### 2. Start Laravel Sail

```bash
./vendor/bin/sail up
```
This command launches the necessary Docker containers for your Laravel project.

### 3. Run the Job Queue

```bash
./vendor/bin/sail artisan queue:work
```

### 4. Run Tests

```bash
./vendor/bin/sail test
```

### 5. Test with Postman

 * Import the provided Postman request collection from `postman/1datatec_test.postman_collection.json`.
 * Start the Laravel server (if not already running).
 * Open Postman and use the imported collection to test the `api/submit` endpoint

## Notes

 * Ensure Docker and Docker Compose are installed on your machine to use Laravel Sail.
 * If you encounter any issues with commands, make sure you're in the project's root directory and using the correct paths.

**Time spent:** ~1.5h  
**Telegram:** [@vladowski](https://t.me/vladowski)  
**Email:** vladowski@gmail.com
