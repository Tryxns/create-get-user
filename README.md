## Prerequisite
1. **PHP 8.2 or newer** 
2. **MySQL**
3. **Postman**

## 🚀 Getting Started
1. **Clone Repo**: 
    ```bash
    git clone git@github.com:Tryxns/create-get-user.git
    ```
2. **Adjust the env with your local credential**:

3. **Setup the environment**:  
   ```bash
   composer install
   php artisan migrate
   php artisan php artisan db:seed
   ```
   and then alternatively, you can import my postman collection to your postman client for easier testing

3. **Start the Application**:  
   ```bash  
   php artisan serve
   ```

## 📝 Assumptions
1. record per page = 10
2. default sort result by created_at, which come from table users
3. sorting using ascending order