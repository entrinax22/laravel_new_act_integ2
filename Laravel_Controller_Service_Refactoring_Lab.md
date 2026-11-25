# LABORATORY ACTIVITY: Refactoring Laravel Controllers Using Service Classes

**Subject:** Integrative Programming 2  
**Framework:** Laravel 13  
**Activity Type:** Individual / Hands-on Laboratory

## I. Activity Title

**Controller Refactoring: Separating Business Logic into Service Classes**

## II. Objectives

At the end of this activity, students should be able to:

1. Identify business logic inside an existing Laravel controller.
2. Create a service class under the `app/Services` directory.
3. Transfer appropriate business logic from a controller into a service class.
4. Use dependency injection to access the service class from a controller.
5. Test the refactored system and verify that its existing functionality still works.

## III. Problem / Task

Your existing Laravel system may contain controllers that handle several responsibilities, such as retrieving records, saving data, updating information, deleting records, and processing business rules.

When too much logic is placed inside a controller, the code becomes difficult to maintain, reuse, and test.

For this activity, you are required to **refactor one existing controller from your own Laravel system by transferring its business logic into a dedicated service class.**

You are not required to create a new system. You must improve the structure of your existing project while preserving its current functionality.

## IV. Instructions

### Step 1: Select an Existing Controller

Open your existing Laravel project and select **at least one controller** that contains business logic.

Examples:

- StudentController
- ProductController
- EmployeeController
- EnrollmentController
- OrderController
- InventoryController

Choose a controller that performs operations such as retrieving, creating, updating, or deleting records.

### Step 2: Examine the Controller

Review the selected controller and identify the logic that can be transferred into a service class.

Examples include:

- Retrieving records from the database.
- Creating and saving records.
- Updating existing records.
- Deleting records.
- Processing calculations or business rules.
- Preparing or transforming data.

Remember: The controller should primarily handle incoming requests, validation, calling the service, and returning the appropriate response.

### Step 3: Create a Service Class

Inside your Laravel project, create a directory named `Services` under `app`, if it does not already exist.

Create a service class that corresponds to your selected controller.

Example:

`app/Services/StudentService.php`

You may use the following Artisan command:

```bash
php artisan make:class Services/StudentService
```

Place the appropriate business logic inside your newly created service class.

### Step 4: Refactor the Controller

Modify your selected controller so that it no longer directly contains the business logic transferred to the service class.

Use **dependency injection** to access your service class.

Example:

```php
public function __construct(
    protected StudentService $studentService
) {}
```

Your controller methods should now call the appropriate service methods instead of containing the transferred logic.

### Step 5: Test Your Refactored System

Run your Laravel application and test the affected features.

Verify that:

- Records can still be displayed.
- New records can still be created.
- Existing records can still be updated.
- Records can still be deleted.
- Existing validations and responses still work.
- No new errors are introduced.

**Important:** Refactoring should improve your code organization without changing the expected behavior of your system.

## V. Requirements

Your submission must satisfy the following:

1. Use an existing Laravel project.
2. Refactor at least one existing controller.
3. Create at least one service class inside `app/Services`.
4. Transfer appropriate business logic from the controller into the service.
5. Use dependency injection to access the service.
6. Preserve the existing functionality of the system.
7. Ensure the affected features work after refactoring.

## VI. Submission Requirements

Submit the following:

1. **Original Controller** – Screenshot or code showing the controller before refactoring.
2. **Service Class** – Screenshot or code showing your newly created service class.
3. **Refactored Controller** – Screenshot or code showing how the controller now uses dependency injection.
4. **Working System** – Screenshots showing that the affected features still work after refactoring.
5. **Short Explanation** – In 3–5 sentences, explain what logic you transferred to the service class and how this improved your controller.

## VII. Guide Questions

Answer briefly:

1. What is the purpose of a service class in Laravel?
2. Why should business logic not be placed entirely inside a controller?
3. What is dependency injection, and how did you use it in this activity?
4. What is the main difference between your original controller and your refactored controller?

## VIII. Important Reminders

- Do not create a separate demonstration project. Use your existing system.
- Do not simply create an empty service class. It must contain actual business logic transferred from your controller.
- Do not remove existing features or change their expected behavior.
- Keep your code organized and follow proper Laravel naming conventions.
- Make sure your application runs before and after refactoring.

## IX. Grading Rubric

**Total: 100 Points**

| Criteria | Points |
|---|---:|
| Correct identification of controller logic | 15 |
| Proper creation and implementation of service class | 25 |
| Correct use of dependency injection | 20 |
| Controller successfully refactored | 15 |
| Existing system functionality preserved and tested | 15 |
| Submission and explanation | 10 |
| **Total** | **100** |
