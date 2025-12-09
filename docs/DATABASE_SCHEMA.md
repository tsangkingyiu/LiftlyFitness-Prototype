# Database Schema Documentation

## Overview

This document describes the database schema for LiftlyFitness application.

## Entity Relationship Diagram

```
users 1---* workouts
users 1---* meals
users 1---* body_measurements
users *---* users (followers)
workouts *---* exercises
meals *---* foods
```

## Tables

### users

Stores user account information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK, AUTO_INCREMENT | User ID |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| password | VARCHAR(255) | NULLABLE | Hashed password |
| provider | VARCHAR(50) | NULLABLE | OAuth provider |
| provider_id | VARCHAR(255) | NULLABLE | OAuth provider ID |
| avatar | VARCHAR(255) | NULLABLE | Profile picture |
| bio | TEXT | NULLABLE | User biography |
| birth_date | DATE | NULLABLE | Date of birth |
| gender | ENUM | NULLABLE | Gender |
| height | DECIMAL(5,2) | NULLABLE | Height in cm |
| weight | DECIMAL(5,2) | NULLABLE | Current weight |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification |
| created_at | TIMESTAMP | | Creation time |
| updated_at | TIMESTAMP | | Last update |

### roles

User roles (managed by Spatie Permission).

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Role ID |
| name | VARCHAR(255) | UNIQUE | Role name |
| guard_name | VARCHAR(255) | | Guard name |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### exercises

Exercise library.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Exercise ID |
| name | VARCHAR(255) | NOT NULL | Exercise name |
| slug | VARCHAR(255) | UNIQUE | URL slug |
| description | TEXT | NULLABLE | Description |
| category | VARCHAR(100) | NOT NULL | Category |
| muscle_group | VARCHAR(100) | | Primary muscle |
| equipment | VARCHAR(100) | NULLABLE | Required equipment |
| difficulty | ENUM | | Difficulty level |
| instructions | TEXT | | Step-by-step |
| video_url | VARCHAR(255) | NULLABLE | Demo video |
| thumbnail | VARCHAR(255) | NULLABLE | Image |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### workouts

Workout templates.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Workout ID |
| user_id | BIGINT | FK | Creator |
| name | VARCHAR(255) | NOT NULL | Workout name |
| slug | VARCHAR(255) | | URL slug |
| description | TEXT | NULLABLE | Description |
| category | VARCHAR(100) | | Category |
| duration | INT | | Est. duration (min) |
| difficulty | ENUM | | Difficulty |
| is_public | BOOLEAN | DEFAULT false | Public/private |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### workout_exercises

Exercises within workouts.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | |
| workout_id | BIGINT | FK | Workout reference |
| exercise_id | BIGINT | FK | Exercise reference |
| order | INT | | Exercise order |
| sets | INT | | Number of sets |
| reps | INT | NULLABLE | Reps per set |
| duration | INT | NULLABLE | Duration (seconds) |
| rest | INT | | Rest time (sec) |
| notes | TEXT | NULLABLE | Exercise notes |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### workout_sessions

Completed workout tracking.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Session ID |
| user_id | BIGINT | FK | User |
| workout_id | BIGINT | FK | Workout |
| started_at | TIMESTAMP | | Start time |
| completed_at | TIMESTAMP | NULLABLE | End time |
| duration | INT | NULLABLE | Actual duration |
| notes | TEXT | NULLABLE | Session notes |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### foods

Food database.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Food ID |
| name | VARCHAR(255) | NOT NULL | Food name |
| brand | VARCHAR(255) | NULLABLE | Brand |
| serving_size | DECIMAL(8,2) | | Serving size |
| serving_unit | VARCHAR(50) | | Unit (g, ml, etc) |
| calories | DECIMAL(8,2) | | Calories per serving |
| protein | DECIMAL(8,2) | | Protein (g) |
| carbs | DECIMAL(8,2) | | Carbs (g) |
| fat | DECIMAL(8,2) | | Fat (g) |
| fiber | DECIMAL(8,2) | NULLABLE | Fiber (g) |
| sugar | DECIMAL(8,2) | NULLABLE | Sugar (g) |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### meals

User meal logs.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | Meal ID |
| user_id | BIGINT | FK | User |
| meal_type | ENUM | | Meal type |
| date | DATE | NOT NULL | Meal date |
| time | TIME | NULLABLE | Meal time |
| notes | TEXT | NULLABLE | Meal notes |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**meal_type values:** `breakfast`, `lunch`, `dinner`, `snack`

### meal_foods

Foods within meals.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | |
| meal_id | BIGINT | FK | Meal |
| food_id | BIGINT | FK | Food |
| quantity | DECIMAL(8,2) | | Quantity |
| unit | VARCHAR(50) | | Unit |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### body_measurements

User body tracking.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | |
| user_id | BIGINT | FK | User |
| date | DATE | NOT NULL | Measurement date |
| weight | DECIMAL(5,2) | NULLABLE | Weight (kg) |
| body_fat | DECIMAL(4,2) | NULLABLE | Body fat % |
| chest | DECIMAL(5,2) | NULLABLE | Chest (cm) |
| waist | DECIMAL(5,2) | NULLABLE | Waist (cm) |
| hips | DECIMAL(5,2) | NULLABLE | Hips (cm) |
| arms | DECIMAL(5,2) | NULLABLE | Arms (cm) |
| legs | DECIMAL(5,2) | NULLABLE | Legs (cm) |
| notes | TEXT | NULLABLE | Notes |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

### follows

User following relationships.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | |
| follower_id | BIGINT | FK | Follower user |
| following_id | BIGINT | FK | Following user |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

**Unique:** (follower_id, following_id)

### activities

User activity feed.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK | |
| user_id | BIGINT | FK | User |
| type | VARCHAR(100) | | Activity type |
| activityable_type | VARCHAR(255) | | Polymorphic type |
| activityable_id | BIGINT | | Polymorphic ID |
| data | JSON | NULLABLE | Additional data |
| created_at | TIMESTAMP | | |
| updated_at | TIMESTAMP | | |

## Indexes

### Performance Indexes

```sql
-- Users
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_provider ON users(provider, provider_id);

-- Workouts
CREATE INDEX idx_workouts_user ON workouts(user_id);
CREATE INDEX idx_workouts_category ON workouts(category);
CREATE INDEX idx_workouts_public ON workouts(is_public);

-- Sessions
CREATE INDEX idx_sessions_user ON workout_sessions(user_id);
CREATE INDEX idx_sessions_workout ON workout_sessions(workout_id);
CREATE INDEX idx_sessions_date ON workout_sessions(started_at);

-- Meals
CREATE INDEX idx_meals_user_date ON meals(user_id, date);

-- Follows
CREATE INDEX idx_follows_follower ON follows(follower_id);
CREATE INDEX idx_follows_following ON follows(following_id);
```

## Foreign Keys

All foreign keys include `ON DELETE CASCADE` for proper cleanup.

## Migration Commands

```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Fresh migration with seed
php artisan migrate:fresh --seed
```