

## Steps for setup:

 
1.  Clone the repository.
2.  Create an `.env` file.
3.  Copy the contents of `.env.example` into `.env`.
4.  Run `docker compose build --no-cache`.
5.  Run `docker compose up -d`.
6.  Access docker with `docker exec -it laravel-app-1 bash`.
7.  Run `composer install`.
8.  Run `npm install`.
9.  Run `npm run dev`.
10.  Run `php artisan migrate`.
11.  Run `php artisan db:seed`.

Navigate to localhost:8000 (*if this port is already occupied consider changing this port in docker-compose.yml in service webserver*)

A testing user is already been provided by seeder.

    email: test@test.com
    
    password: password

  

There is unit test for DynmicFields to run the test execute following command:

    php artisan test

 ## Application Functionality

-   Fields can be created through Dynamic Fields.
-   Forms can be created through Dynamic Forms.
-   The relationship between these two models is `BelongsToMany` with a pivot table.
  

## IMPORTANT CONSIDERATIONS ON IMPLEMENTATIONS:

### Logic

The implementation includes the creation of the fields and forms tables. Users can define fields and then create a form by specifying the previously created fields. The form is persisted in the database, and a JSON representation of the dynamic form is created and added to the `form` column of the `dynamic_forms` table.

This approach allows for:

-   Manipulation of the form structure, such as adding actions to the form (user-defined or default).
-   Compatibility with a variety of consumers, as the form is stored in JSON format.
### Best Practices

The project follows best practices and conventions, including:

-   **Custom Eloquent model factory:** All model logic is aggregated in a custom factory that extends `Illuminate\Database\Eloquent\Model`. This approach simplifies the saving of various types of relationships, such as `BelongsTo`, `HasMany`, and `BelongsToMany`.
-   **Observers:** The project uses observers to dynamically observe all existing and future models. This provides flexibility and reduces repetitive code.
-   **ResourceController:** The `ResourceController` extends the default Laravel controller, providing a lean logic implementation for CRUD operations on resources. This allows for easy creation of new controllers using an Artisan command.
-   **Custom FormRequest:** The project utilizes custom `FormRequest` classes and binds them to the corresponding methods in the controller. This adheres to the Single Responsibility Principle and separates validation logic from the controller.
-   **Test-Driven Development (TDD):** The project includes unit tests for the `DynamicField` model, covering CRUD operations and validations.
-   **Enumerable implementation:** The implementation includes an Enumerable class, which simplifies the creation of dictionaries. It is used for validation types and field types, allowing easy access to predefined values.
-   **Dynamic Form Rendering:** Three types of form rendering are available:
    -   **JSON**: Used for integration with frontend API consumers.
    -   **Raw HTML**: Provides the form as raw HTML in the response.
    -   **Blade View**: Renders the form using Laravel's Blade templating engine.

## NOTES:

Considering that the assignment was a test, the core logic of the project was prioritized. However, some elements were left as placeholders, such as the TDD for the `DynamicForm` model, and the update, edit, and delete operations in the controllers. These tasks would involve repetition of the create and store operations with minor modifications.