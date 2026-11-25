# LABORATORY ACTIVITY: Refactoring Laravel Controllers Using Service Classes

**Subject:** Integrative Programming 2  
**Framework:** Laravel 13  
**Activity Type:** Individual / Hands-on Laboratory

## I. Activity Title

**Complete Controller Refactoring: Separating Business Logic into Service Classes**

## II. Objectives

At the end of this activity, students should be able to:

1. Examine all controllers in an existing Laravel system.
2. Identify business logic and determine which responsibilities belong in service classes.
3. Create and organize service classes under `app/Services`.
4. Transfer business logic from controllers into the appropriate service classes.
5. Use dependency injection to access service classes from controllers.
6. Test the refactored system and verify that its existing functionality still works.

## III. Problem / Task

As your Laravel system grows, its controllers may contain several responsibilities, including retrieving records, creating and updating data, deleting records, processing calculations, and implementing business rules.

Placing too much business logic inside controllers makes the application harder to maintain, reuse, and test.

For this activity, you are required to **refactor all application controllers in your existing Laravel system by transferring their appropriate business logic into dedicated service classes.**

This is a system-wide refactoring activity. Refactoring only one or two controllers will not satisfy the requirement.

You are not required to build a new system. Improve the organization of your existing project while preserving its current features and behavior.

## IV. Instructions

### Step 1: Identify All Your Controllers

Open your Laravel project and inspect:

`app/Http/Controllers`

List all controllers that belong to your application. Review each controller and identify the operations and business logic it handles.

Do not select only your favorite or easiest controller. The goal is to review and refactor the controllers throughout your system.

### Step 2: Examine Each Controller

For every application controller, identify the business logic that should be transferred to a service class.

Examples include:

- Retrieving records from the database.
- Creating and saving records.
- Updating existing records.
- Deleting records.
- Performing calculations.
- Applying business rules.
- Processing or transforming data.
- Coordinating multiple database operations.

Keep responsibilities such as receiving the HTTP request, validating input, checking authorization, and returning an HTTP response in the controller when appropriate.

**Important:** Do not move code blindly. A service class should contain actual application operations or business logic, not simply duplicate the controller methods.

### Step 3: Create the Service Classes

Create a `Services` directory inside `app`, if it does not already exist.

Create appropriate service classes for the controllers and their responsibilities.

Example structure:

```text
app/
├── Http/
│   └── Controllers/
│       ├── StudentController.php
│       ├── SubjectController.php
│       └── EnrollmentController.php
│
└── Services/
    ├── StudentService.php
    ├── SubjectService.php
    └── EnrollmentService.php
```

You may create a service class using Artisan:

```bash
php artisan make:class Services/StudentService
```

Repeat as needed for the other parts of your system.

You may organize the services according to your system's actual modules and responsibilities. The example above is only a guide.

### Step 4: Transfer the Business Logic

Move the appropriate business logic from each controller into its corresponding service class.

For example, if `StudentController` handles student creation, updating, deletion, and retrieval, move the corresponding application operations into `StudentService`.

Make sure that:

- The service class contains the actual operations.
- The methods are reusable where appropriate.
- The service does not depend on receiving an HTTP request just to perform its core operation.
- The original controller no longer contains duplicated copies of the transferred logic.

### Step 5: Refactor Each Controller Using Dependency Injection

Update every application controller to use its corresponding service class through dependency injection.

Example:

```php
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService
    ) {}

    // Controller methods call the service here.
}
```

Your controller methods should call the service methods instead of directly containing the business logic that you transferred.

Apply the same approach to the other controllers in your system.

### Step 6: Test the Entire System

After refactoring, run your Laravel application and test the features affected by your changes.

Verify that:

- Records can still be displayed.
- New records can still be created.
- Existing records can still be updated.
- Records can still be deleted.
- Search, filtering, and other existing features still work.
- Existing validation and authorization behavior is preserved.
- Related modules and processes still work.
- No new errors are introduced.

**Important:** Refactoring should improve code organization without changing the expected behavior of your system.

## V. Requirements

Your submission must satisfy all of the following:

1. Use your existing Laravel system.
2. Review and refactor **all application controllers you developed**.
3. Create the necessary service classes inside `app/Services`.
4. Transfer appropriate business logic from the controllers into service classes.
5. Use dependency injection to access the service classes.
6. Avoid leaving duplicated business logic in the controllers.
7. Preserve the existing functionality, validation, authorization, and responses of the system.
8. Test the affected features after refactoring.

Framework-provided or package-provided controllers that you did not develop do not need to be modified. If a controller has no business logic to extract, document why it does not require a service class.

## VI. Submission Requirements

Submit the following:

1. **Controller Inventory** – A list of all application controllers in your system and their corresponding service classes.
2. **Service Classes** – Screenshots or code showing the service classes you created or updated.
3. **Refactored Controllers** – Screenshots or code showing how each controller uses dependency injection and calls its service.
4. **Working System** – Screenshots showing that the important features of your system still work after refactoring.
5. **Short Explanation** – Explain what responsibilities you transferred to the service classes and how the changes improved your system.

Your submission must demonstrate the refactoring of the entire application, not just a single controller.

## VII. Guide Questions

Answer briefly:

1. What is the purpose of a service class in Laravel?
2. Why should business logic not be placed entirely inside controllers?
3. What is dependency injection, and how did you use it in your system?
4. What responsibilities should remain in a controller?
5. How did refactoring all your application controllers improve the organization and maintainability of your system?
6. What difficulties did you encounter while transferring logic into service classes?

## VIII. Important Reminders

- Use your existing Laravel project. Do not create a separate demonstration project.
- Refactor all application controllers you developed.
- Do not simply create empty service classes. They must contain actual business logic transferred from the controllers.
- Do not create unnecessary service classes just to meet a file-count requirement.
- Do not remove existing features or change their expected behavior.
- Do not move request validation, authorization, or HTTP response handling blindly into services.
- Keep your code organized and follow proper Laravel naming conventions.
- Make sure your application works before and after refactoring.
- Test the related modules after making changes. A change in one service may affect other parts of your system.

## IX. Grading Rubric

**Total: 100 Points**

| Criteria | Points |
|---|---:|
| Complete review and inventory of all application controllers | 10 |
| Appropriate service class design and organization | 20 |
| Successful transfer of business logic across the controllers | 25 |
| Correct use of dependency injection and controller refactoring | 15 |
| Existing system functionality preserved and tested | 20 |
| Submission completeness and explanation | 10 |
| **Total** | **100** |
