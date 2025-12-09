# LiftlyFitness API Documentation

## Base URL

```
https://api.liftlyfitness.com/api/v1
```

## Authentication

All API requests require authentication using Bearer tokens.

### Headers

```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

## Response Format

### Success Response

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

### Error Response

```json
{
  "success": false,
  "message": "Error message",
  "errors": {},
  "meta": {
    "timestamp": "2025-12-09T17:00:00Z",
    "version": "v1"
  }
}
```

## HTTP Status Codes

- `200` - OK: Successful request
- `201` - Created: Resource created successfully
- `204` - No Content: Successful deletion
- `400` - Bad Request: Invalid request parameters
- `401` - Unauthorized: Authentication required
- `403` - Forbidden: Insufficient permissions
- `404` - Not Found: Resource not found
- `422` - Unprocessable Entity: Validation error
- `429` - Too Many Requests: Rate limit exceeded
- `500` - Internal Server Error: Server error

## API Endpoints

### Authentication

#### Register

```http
POST /auth/register
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "1|abc123..."
  },
  "message": "Registration successful"
}
```

#### Login

```http
POST /auth/login
```

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Social Login

```http
GET /auth/{provider}/redirect
GET /auth/{provider}/callback
```

Supported providers: `google`, `facebook`, `apple`

#### Logout

```http
POST /auth/logout
```

### User Management

#### Get Current User

```http
GET /user
```

#### Update Profile

```http
PUT /user/profile
```

**Request Body:**
```json
{
  "name": "John Doe",
  "bio": "Fitness enthusiast",
  "height": 180,
  "weight": 75,
  "birth_date": "1990-01-01"
}
```

### Workouts

#### List Workouts

```http
GET /workouts?page=1&per_page=20&category=strength
```

#### Create Workout

```http
POST /workouts
```

**Request Body:**
```json
{
  "name": "Upper Body Strength",
  "description": "Focus on chest and arms",
  "category": "strength",
  "duration": 45,
  "exercises": [
    {
      "exercise_id": 1,
      "sets": 3,
      "reps": 10,
      "rest": 60
    }
  ]
}
```

#### Get Workout

```http
GET /workouts/{id}
```

#### Update Workout

```http
PUT /workouts/{id}
```

#### Delete Workout

```http
DELETE /workouts/{id}
```

### Exercises

#### List Exercises

```http
GET /exercises?search=bench&category=strength
```

#### Get Exercise

```http
GET /exercises/{id}
```

### Nutrition

#### Log Meal

```http
POST /meals
```

**Request Body:**
```json
{
  "meal_type": "breakfast",
  "date": "2025-12-09",
  "foods": [
    {
      "food_id": 1,
      "quantity": 100,
      "unit": "g"
    }
  ]
}
```

#### Get Daily Nutrition

```http
GET /nutrition/daily?date=2025-12-09
```

### Analytics

#### Get Progress Stats

```http
GET /analytics/progress?period=month
```

#### Log Body Measurement

```http
POST /analytics/measurements
```

**Request Body:**
```json
{
  "weight": 75.5,
  "body_fat": 15.2,
  "measurements": {
    "chest": 100,
    "waist": 80,
    "arms": 35
  },
  "date": "2025-12-09"
}
```

### Social

#### Follow User

```http
POST /social/follow/{user_id}
```

#### Get Activity Feed

```http
GET /social/feed?page=1
```

#### Share Workout

```http
POST /social/share/workout/{workout_id}
```

## Pagination

List endpoints support pagination:

```
GET /workouts?page=1&per_page=20
```

**Response:**
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 100,
    "last_page": 5
  }
}
```

## Filtering & Sorting

```
GET /workouts?category=strength&sort=created_at&order=desc
```

## Rate Limiting

- **Authenticated**: 60 requests per minute
- **Unauthenticated**: 10 requests per minute

## Error Handling

### Validation Errors

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

## Webhooks

Webhooks can be configured for:
- New user registration
- Workout completion
- Achievement unlocked

## SDKs

Official SDKs coming soon for:
- iOS (Swift)
- Android (Kotlin)
- JavaScript

## Support

For API support, contact: api-support@liftlyfitness.com