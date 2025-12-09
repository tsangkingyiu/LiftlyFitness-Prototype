# Contributing to LiftlyFitness

Thank you for considering contributing to LiftlyFitness! This document provides guidelines and instructions for contributing to the project.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment for all contributors.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected behavior**
- **Actual behavior**
- **Environment details** (PHP version, OS, Laravel version)
- **Screenshots** if applicable

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Clear title and description**
- **Rationale** for the enhancement
- **Possible implementation** approach
- **Benefits** to users

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Follow the coding standards** (PSR-12)
3. **Write tests** for new features
4. **Update documentation** as needed
5. **Ensure tests pass** before submitting
6. **Write clear commit messages**

## Development Workflow

### Getting Started

1. Fork the repository
2. Clone your fork:
   ```bash
   git clone https://github.com/YOUR_USERNAME/LiftlyFitness-Prototype.git
   ```
3. Add upstream remote:
   ```bash
   git remote add upstream https://github.com/tsangkingyiu/LiftlyFitness-Prototype.git
   ```
4. Install dependencies:
   ```bash
   composer install
   npm install
   ```

### Branch Naming Convention

- `feature/feature-name` - New features
- `bugfix/bug-description` - Bug fixes
- `hotfix/critical-fix` - Critical production fixes
- `docs/documentation-update` - Documentation changes
- `refactor/code-improvement` - Code refactoring

### Commit Message Guidelines

Follow [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation changes
- `style:` - Code style changes (formatting, etc.)
- `refactor:` - Code refactoring
- `test:` - Adding or updating tests
- `chore:` - Maintenance tasks

Examples:
```
feat: add workout session tracking API
fix: resolve authentication token expiration issue
docs: update API documentation for nutrition module
```

## Coding Standards

### PHP Code Style

- Follow **PSR-12** coding standards
- Use **type hinting** for all method parameters and return types
- Write **PHPDoc blocks** for all classes and methods
- Keep methods **small and focused** (single responsibility)
- Use **meaningful variable names**

### Laravel Best Practices

- Use **Eloquent ORM** for database operations
- Implement **Repository Pattern** for data access
- Use **Service Layer** for business logic
- Follow **RESTful conventions** for API endpoints
- Use **Form Requests** for validation
- Implement **API Resources** for response formatting

### Testing

- Write **unit tests** for business logic
- Write **feature tests** for API endpoints
- Aim for **80%+ code coverage**
- Run tests before submitting PR:
  ```bash
  php artisan test
  ```

### Example Code Structure

```php
<?php

namespace Modules\Workout\Services;

use Modules\Workout\Repositories\WorkoutRepository;
use Modules\Workout\Models\Workout;

class WorkoutService
{
    public function __construct(
        private WorkoutRepository $workoutRepository
    ) {}

    /**
     * Create a new workout template.
     *
     * @param array $data
     * @return Workout
     */
    public function createWorkout(array $data): Workout
    {
        // Business logic here
        return $this->workoutRepository->create($data);
    }
}
```

## Module Development

### Creating a New Module

```bash
php artisan module:make ModuleName
```

### Module Structure

```
Modules/ModuleName/
├── Config/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Repositories/
├── Services/
├── Routes/
│   ├── api.php
│   └── web.php
└── Tests/
    ├── Feature/
    └── Unit/
```

### Module Guidelines

- Keep modules **independent** and **loosely coupled**
- Use **dependency injection**
- Implement proper **separation of concerns**
- Write **module-specific tests**
- Document **module APIs**

## API Development

### API Endpoint Guidelines

- Use **proper HTTP methods** (GET, POST, PUT, DELETE)
- Implement **proper status codes**
- Use **consistent response format**
- Include **pagination** for list endpoints
- Implement **filtering and sorting**
- Add **rate limiting**

### Response Format

```json
{
  "success": true,
  "data": {},
  "message": "Operation successful",
  "meta": {
    "timestamp": "2025-12-09T17:00:00Z",
    "version": "v1"
  }
}
```

## Documentation

### What to Document

- **API endpoints** with request/response examples
- **Module functionality** and architecture
- **Configuration options**
- **Database schema changes**
- **Breaking changes**

### Where to Document

- **README.md** - Project overview and setup
- **CHANGELOG.md** - Version history
- **Wiki** - Detailed guides and tutorials
- **Code comments** - Complex logic explanation
- **API docs** - Endpoint specifications

## Pull Request Process

1. **Update documentation** for any changes
2. **Add tests** for new functionality
3. **Ensure all tests pass**
4. **Update CHANGELOG.md** with your changes
5. **Request review** from maintainers
6. **Address feedback** promptly
7. **Squash commits** if requested

### PR Template

```markdown
## Description
[Describe the changes]

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] All tests passing

## Checklist
- [ ] Code follows project style guidelines
- [ ] Documentation updated
- [ ] CHANGELOG.md updated
- [ ] No breaking changes (or documented)
```

## Questions?

If you have questions, feel free to:
- Open an issue for discussion
- Contact maintainers directly
- Join our community discussions

## Recognition

Contributors will be acknowledged in:
- Release notes
- CONTRIBUTORS.md file
- Project documentation

Thank you for contributing to LiftlyFitness! 🏋️‍♂️