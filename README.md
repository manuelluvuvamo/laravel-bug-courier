# Laravel Bug Courier

## Introduction

`laravel-bug-courier` is a Laravel package designed to facilitate bug reporting and issue tracking across multiple platforms. It provides a structured way to capture, store, and report bugs using various integrations such as email, Azure DevOps, GitHub, and Trello. The package allows you to configure reporting methods and use predefined services, domain entities, and repositories either independently or in combination.

## Installation

To install the package, run the following command:

```bash
composer require manuelluvuvamo/laravel-bug-courier
```

After installing, publish the configuration file:

```bash
php artisan vendor:publish --provider="ManuelLuvuvamo\BugCourier\Providers\BugCourierServiceProvider"
```

This will create a `config/bug-courier.php` file where you can customize the package settings.

---

## Configuration

### Environment Variables

Add the following environment variables to your `.env` file to configure the package:

```ini
BUG_COURIER_AUTOMATIC=true # Enable middleware to intercept errors and show a page with a report button
BUG_COURIER_BACKGROUND=false # Enable middleware to intercept errors and report without a report button

# Note: Only one of the above options can be enabled at a time.
BUG_COURIER_VIEWS_ENABLED=true # Enable views for bug reporting
BUG_COURIER_ROUTES_PREFIX=bug-courier # Prefix for package routes
BUG_COURIER_ROUTES_MIDDLEWARE=web # Middleware for routes

# Email Configuration
EMAIL_ENABLED=true # Enable email reporting
BUG_MONITOR_EMAIL=your-email@example.com # Recipient email for bug reports

# Azure DevOps Configuration
AZURE_DEVOPS_ENABLED=false # Enable Azure DevOps reporting
AZURE_DEVOPS_ORG=your-org # Your Azure DevOps organization
AZURE_DEVOPS_PROJECT=your-project # Your Azure DevOps project name
AZURE_DEVOPS_API_VERSION=7.1-preview.3 # API version
AZURE_DEVOPS_TOKEN=your-token # Personal Access Token
AZURE_DEVOPS_AREA_PATH=your-area-path # Area path for work items

# GitHub Configuration
GITHUB_ENABLED=false # Enable GitHub issue reporting
GITHUB_OWNER=your-owner # GitHub owner (user or organization)
GITHUB_REPO=your-repo # Repository name
GITHUB_ASSIGNEES=assignee1,assignee2 # Assignees for GitHub issues
GITHUB_LABELS=label1,label2 # Labels for GitHub issues
GITHUB_MILESTONE=your-milestone # Milestone ID for GitHub issues
GITHUB_TOKEN=your-token # GitHub API token

# Trello Configuration
TRELLO_ENABLED=false # Enable Trello integration
TRELLO_BOARD_ID=your-board-id # Trello board ID
TRELLO_LIST_ID=your-list-id # Trello list ID
TRELLO_TOKEN=your-token # Trello API token
TRELLO_KEY=your-key # Trello API key
```

---

## Usage

### Reporting Bugs Automatically

If `BUG_COURIER_AUTOMATIC=true`, the package will automatically capture and report application errors. Otherwise, you can manually report bugs using the `CreateItemService` service.

### Manually Reporting Bugs

To manually create a bug report:

```php
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemDto;

$service = app(CreateItemService::class);
$data = new CreateItemDto(
    'Bug Title',
    'Bug Description',
    ['key' => 'value'],
    'open'
);
$service->execute($data);
```

### Using Services

The package provides the following services:

- `CreateItemService` - Handles bug creation and reporting.

### Using Domain Entities

The package includes domain entities to represent bug reports:

- `Item` - Represents a bug in the system.
- `CreateItemDto` - Data transfer object for creating a bug report.

### Using Infrastructure Repositories

The package provides repositories to interact with various bug tracking systems:

- `ItemAzureDevopsRepository` - Reports bugs to Azure DevOps.
- `ItemGithubRepository` - Reports bugs to GitHub.
- `ItemTrelloRepository` - Reports bugs to Trello.

You can use a specific repository directly if needed:

```php
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemGithubRepository;

$repository = app(ItemGithubRepository::class);
$repository->save($data);
```

---

## Example Workflows

### Reporting a Bug via GitHub

```php
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemDto;

$data = new CreateItemDto('Bug in checkout process', 'Description of the issue', ['module' => 'checkout'], 'open');
$service = app(CreateItemService::class);
$service->execute($data);
```

### Reporting a Bug via Email

Ensure that `EMAIL_ENABLED=true` and the recipient email is set in `.env`.

```php
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemDto;

$data = new CreateItemDto('Database connection error', 'Timeout issue', ['server' => 'db01'], 'open');
$service = app(CreateItemService::class);
$service->execute($data);
```

---

## Advanced Configuration

### Enabling Only Specific Reporting Methods

You can only use one reporting method at a time. Enable the desired method in `.env` and disable the others. For example, to use only GitHub:

```ini
GITHUB_ENABLED=true
EMAIL_ENABLED=false
AZURE_DEVOPS_ENABLED=false
TRELLO_ENABLED=false
```

### Queueing Email Reports for Performance

The `laravel-bug-courier` package allows sending error reports via email either synchronously or asynchronously, depending on the `.env` configuration.

To define the desired behavior, set the following variable:
```ini
BUG_COURIER_EMAIL_QUEUE=true # true for async sending, false for immediate sending
```

If `BUG_COURIER_EMAIL_QUEUE=true`, the package will send emails using Laravel's queue system. Make sure your application is properly configured for queues in `config/queue.php` and that a worker is running:

```bash
php artisan queue:work
```

If `BUG_COURIER_EMAIL_QUEUE=false`, emails will be sent immediately without using queues.

**Note:** There is no need to modify the `CreateItemService`. The package is already prepared to work with both options.

---

## Conclusion

`laravel-bug-courier` provides a structured and flexible way to manage and report bugs in Laravel applications. With support for multiple platforms and easy customization, it can fit into various workflows. Configure the package as needed, use the provided services, domain entities, and repositories, and start tracking bugs efficiently.

For additional details, refer to the `config/bug-courier.php` file and the `BugCourierServiceProvider.php` service provider.

## Contribution Guide

### Bug Reports

If you find a bug in `laravel-bug-courier`, please open an **Issue** on GitHub.

#### Before Submitting a Bug Report

1. **Search open and closed issues** to check if the issue has already been reported.
2. **If the issue is new**, open a new issue and include:
   - A **clear description** of the problem.
   - Steps to reproduce the bug.
   - Any **error messages** you encountered.
   - The Laravel and PHP versions you are using.

> **Note:** Issues that do not follow this format may be closed without notice.

### Coding Standards

This project follows the **PSR-1**, **PSR-4**, and **PSR-12** coding standards. Ensure your code adheres to these standards before submitting a pull request.

Additionally, we use **StyleCI** to automatically fix code style issues. You don't need to worry about formatting—StyleCI will handle it when your pull request is merged.

### Code of Conduct

This project follows the **Laravel Code of Conduct**, which is based on the Ruby Code of Conduct. Please adhere to the following guidelines:

- Be respectful of opposing views.
- Ensure your language and actions are free of personal attacks and disparaging remarks.
- Assume good intentions when interpreting others' words and actions.
- Harassment of any kind will not be tolerated.

### Branching Strategy

- **Bug fixes** should be sent to the latest stable version (currently **1.x**).
- **Minor features** that are backward compatible can also be sent to the latest stable version.
- **Major features** or breaking changes should be sent to the **master** branch.

### Submitting a Pull Request

1. **Fork** the repository and create a new branch from the latest `1.x` branch.
2. Write clear, well-structured, and tested code.
3. Ensure all tests pass before submitting (`vendor/bin/pest`).
4. Open a **pull request**, providing a detailed description of your changes.

For more details, refer to the project's **config/bug-courier.php** file and **BugCourierServiceProvider.php**.

