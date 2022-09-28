# Entidades

- ## User
    User -> hasMany -> Task
    ```
    ```

<br />

- ## Category
```php
Category {
    int id;
    string name;
    string color;
    string user_id;
    }
```    
<br />

- Category -> hasMany -> Task

- ## Task
```php
Task {
    int id;
    string title;
    string description;
    DateTime deadline;
    int category_id;
    int user_id;
    }
```    

- Task -> belongsToOne -> User
- Task -> belongsToOne -> Category
