# Task Management System

## Initial Planning and decisions based on technical specifications

The purpose of this coding task is to showcase my skills, innovation and understanding of modern PHP as well as Laravel development.
After going over technical spec and required features list I have made following decisions regarding project structure and usage of 3rd party packages. 

### - PHP version
I have opted for PHP version 8.2 which is a minimal requirement for Laravel version chosen.

### - Laravel version
I have opted to base this coding task around Laravel version 11.

### - Laravel Filament
I have opted to include laravel filament to quickly develop backend admin system.

### - Laravel Livewire
Since Laravel Breeze starter kit is based on Livewire I will use that to create responsive task list that
responds to user input instantly through use of Livewire components and events.
The following Livewire components are present in the application:
- first
- second
- third

### - Authentication and Authorization
• Authentication will be handled by Laravel session based auth 
middleware. Laravel Breeze starter kit has ideal scaffolding to take advantage of this system.
• Authentication will be handled by Laravel Policies and Gates taking advantage of Livewire authorise method to verify
if user can perform actions.
• Access to filament admin panel will be controlled by
canAccessPanel() method that in turn will only allow pre-seeded user with type admin to access it.

### - Event Driven Architecture

### - Testing
I have opted to use Pest testing framework to test project functionality.

### - Database

### - Code Quality and Standards
I have opted to use Laravel Pint code formatter to aid in consistent code style formatting and adherence to coding standards.

### - Additional Features
Implement task due notification with dismiss option and timed notifications.

## Installation
