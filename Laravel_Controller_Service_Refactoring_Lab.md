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

## VI. Submission and System Checking

Each group must prepare their system for an individual checking and submit a printed documentation sheet.

### A. Actual System Demonstration

Each group must present their existing Laravel system for checking.

The instructor will check each group's system **one group at a time**.

During the checking, the group must demonstrate:

1. All application controllers have been reviewed and refactored.
2. Appropriate business logic has been transferred into service classes.
3. Service classes are properly organized inside `app/Services`.
4. Controllers use dependency injection to access their corresponding services.
5. The system's existing features still work after refactoring.
6. The instructor can inspect the actual controller and service class implementations.

**Important:** All group members must be present during the checking and should be able to explain their implementation.

### B. Printed Documentation

Each group must submit **one printed copy per group**, using A4-size bond paper.

The printed documentation must contain the following:

**1. Group Information**
- Group Number
- Names of Group Members
- Name of the Laravel System
- Section

**2. Controller Inventory**

List all application controllers in your system and their corresponding service classes.

| Controller Name | Corresponding Service Class | Refactored? |
|---|---|---|
| StudentController | StudentService | Yes |
| ProductController | ProductService | Yes |
| OrderController | OrderService | Yes |

*Use your actual controller and service class names. The table above is only an example.*

**3. Guide Questions**

Answer the following questions briefly but clearly:

1. What is the purpose of a service class in Laravel?
2. Why should business logic not be placed entirely inside a controller?
3. What is dependency injection, and how did your group use it in this activity?
4. What changes did your group make to the controllers after refactoring?
5. What challenges did your group encounter during the refactoring process, and how did you resolve them?
6. How did your group verify that the system still works after refactoring?

**4. Group Reflection**

In one short paragraph, explain how separating business logic into service classes improved the organization and maintainability of your Laravel system.

### C. Submission Reminders

- Submit only **one printed documentation sheet per group**.
- Use A4-size bond paper.
- Make sure all answers are readable and complete.
- The printed documentation must be prepared before your group's scheduled system checking.
- The actual Laravel system must be accessible and ready for demonstration.
- The instructor will inspect the implementation directly. Printed answers alone will not be sufficient for completion of the activity.

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
