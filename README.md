# Task Management System

## Peronal notes
I have truly enjoyed working on this project as I feel it provided me with
good opportunity to showcase my coding and development skills.

I'm looking forward to your feedback.


## Initial Planning and decisions based on technical specifications

The purpose of this coding task is to showcase my skills, innovation and understanding of modern PHP as well as Laravel development.
After going over technical spec and required features list I have made following decisions regarding project structure and usage of 3rd party packages. 

### - PHP version
I have opted for PHP version 8.2 which is a minimal requirement for Laravel version 11.

### - Laravel version
I have opted to base this coding task around Laravel version 11.

### - Laravel Filament
I have opted to include laravel filament to quickly develop backend admin system.

### - Laravel Livewire
Since Laravel Breeze starter kit is using Livewire Volt components
I have decided to create responsive front end using Livewire Volt single file components.

The following Livewire components are present in the application:
- `resources/views/livewire/tasks/add.blade.php` - responsible for adding new tasks
- `resources/views/livewire/tasks/list.blade.php` - responsible for listing all the tasks for currently logged in user
- `resources/views/livewire/tasks/task.blade.php` - responsible for displaying a task
- `resources/views/livewire/tasks/update.blade.php` - responsible for updating task

### - Authentication and Authorization
• Authentication is handled by Laravel session based web auth 
middleware. Laravel Breeze starter kit has ideal scaffolding to take advantage of this system.

• Authorisation is handled by Laravel Policies and Gates taking advantage of Livewire authorise method to verify
if user can perform action.

• Access to filament admin panel is controlled by extending User model by implementing FilamentUser interface and its
`canAccessPanel()` method that in turn will only allow user of type admin to access it.
Once admin user logs in to application he/she will be able to access filament Admin dashboard by clicking link in navigation.
Filament is configured to accept currently authenticated admin user. Regular users will not have access to back end and will not see the admin link.
For convenience of admins `back to tasks` navigation link has been added to filament admin panel to allow admin user to quickly switch between front end and back end of application.

### - Event Driven Architecture
Due to usage of Livewire Volt I took the liberty of using built in Livewire web event system to update the state of parent components
every time action on child components that update tasks is performed.
I have also used alpine.JS events to control state of modals.
Notably when user completes task a Laravel event is fired to send email to user that task has been completed

### - Testing
I have opted to use Pest testing framework to test project functionality.
- I have created few unit tests to test added methods to Models and newly created enum trait `EnumToArray` that greatly simplified enum interactions.

- I have also created a suite of feature tests to test all required front end functionality.

### - Database
For main project I have used mysql database and sqlite database during testing.

### - Code Quality and Standards
I have opted to use Laravel Pint code formatter to aid in consistent code style formatting and adherence to coding standards.

### - Additional Features
I have added comprehensive admin panel by integrating Laravel Filament package into project.
In the admin panel admin user can:
- create, view, update and delete users,
- create, view, update and delete tasks,
- create, edit and delete Task Statuses that are available to the rest of the users of the application.

I have also included some nice to haves like filtering of task and user table. 
Implemented filament action to mark tasks as completed.
Created comprehensive validated forms to create user, task and status.

I have added feature to send email to users when task is completed.
It is based on Laravel Mailable notifications and is set to queue mails that are pending to send using default redis queue.

I have implemented bespoke responsive frontend using Livewire Volt and Tailwind.

Front end allows users to:
- create task in modal that appears after `add task` button is clicked
- edit task via po up modal
- delete task which triggers confirmation via browser alert dialog.
- mark task as complete


When task is marked as complete following actions are performed:
- task is marked as completed and its completed_at property has date of completion set
- task border turns green and completed_at date is clearly shown to indicate its completed status.
- completed task are send to end of the list by using custom orderBy query in component
- the edit and complete buttons are no longer shown to the user.
- email is sent to the user to indicate task completion.

## Installation
- clone the repo to your local environment.
- configure the `.env` file to match your environment settings.
- run `composer install` - to install php project dependencies
- run `npm install` - to install js project dependencies
- run `npm run dev` - to start included vite asset bundler
- set app key by running: `php artisan key:generate`
- run migrations: `php artisan migrate`
- run provided seeder `php artisan db:seed` that will set initial users and tasks in the project
- run the included tests to ensure all is set as it should `php artisan test`
- start the queue worker by running `php artisan queue:work`
- visit the project at your configured url for my local env I have used `task-management-system.test`
- I have set up 2 users with following credentials:
- Admin: `admin@tms.test` password: `password`
- User: `user@tms.test` password: `password`
