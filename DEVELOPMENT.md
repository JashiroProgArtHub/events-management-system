# Development Guide - SAO Event Management System

## Architecture Overview

### MVC Structure
```
Model Layer (Eloquent)
    ↓
Controller Layer (Business Logic)
    ↓
View Layer (Blade Templates)
    ↓
Routes (URL Mapping)
```

### Data Flow

1. **Request** → Routes → Controller
2. **Controller** → Model (Eloquent) → Database
3. **Database** → Model → Controller
4. **Controller** → View (Blade) → Response

## Model Relationships

```
Admin (1) ─────── (*) Event
                     │
                     ↓
Admin (1) ─────── (*) Participant
```

### Relationship Diagram
```
Admin
├── admin_id (PK)
├── Has Many Events
└── Indirect: Many Participants (through Events)

Event
├── event_id (PK)
├── admin_id (FK) → Admin
└── Has Many Participants

Participant
├── participant_id (PK)
├── event_id (FK) → Event
└── Belongs To Event
```

## Code Standards

### Model Conventions
- Table names: Lowercase plural (admins, events, participants)
- Model names: Singular PascalCase (Admin, Event, Participant)
- Primary keys: {model}_id or id
- Foreign keys: {model}_id
- Timestamps: created_at, updated_at (automatic)

### Controller Conventions
- Resource controllers with CRUD methods
- Naming: {Resource}Controller
- Methods: index, create, store, show, edit, update, destroy
- Return View or RedirectResponse

### Blade Template Conventions
- Naming: lowercase, underscores
- Directory: resources/views/{resource}/
- Files: index.blade.php, create.blade.php, edit.blade.php, show.blade.php
- Layouts: Extend from layouts.app

### Naming Conventions
```
Routes: resource-name (hyphenated)
Variables: $variableName (camelCase)
Methods: methodName() (camelCase)
Constants: CONSTANT_NAME (UPPERCASE)
Classes: ClassName (PascalCase)
```

## Adding New Features

### Example: Add Comment Model

1. **Create Migration**
   ```bash
   php artisan make:migration create_comments_table
   ```

2. **Create Model**
   ```bash
   php artisan make:model Comment
   ```

3. **Create Controller**
   ```bash
   php artisan make:controller CommentController --resource
   ```

4. **Create Form Request**
   ```bash
   php artisan make:request CommentFormRequest
   ```

5. **Add Relationships**
   ```php
   // In Event.php
   public function comments() {
       return $this->hasMany(Comment::class);
   }
   
   // In Comment.php
   public function event() {
       return $this->belongsTo(Event::class);
   }
   ```

6. **Register Routes**
   ```php
   Route::resource('comments', CommentController::class);
   ```

## Query Optimization

### Using Eager Loading (Prevents N+1)
```php
// ❌ BAD - N+1 Query Problem
$events = Event::all();
foreach ($events as $event) {
    echo $event->participants->count(); // Query for each event
}

// ✅ GOOD - Eager Loading
$events = Event::with('participants')->get();
foreach ($events as $event) {
    echo $event->participants->count(); // No extra queries
}
```

### Index Controller
```php
public function index() {
    // Always use with() for relationships
    $events = Event::with('admin', 'participants')
        ->paginate(15);
    
    return view('events.index', compact('events'));
}
```

## Database Queries

### Common Patterns

```php
// Get all records
$events = Event::all();

// Get with relationships
$events = Event::with('participants')->get();

// Get with pagination
$events = Event::paginate(15);

// Get first record
$event = Event::first();

// Get by ID
$event = Event::find($id);

// Get with where clause
$upcoming = Event::where('event_date', '>', now())->get();

// Get count
$count = Event::count();

// Update
$event->update(['title' => 'New Title']);

// Delete
$event->delete();

// Create
Event::create([
    'admin_id' => auth()->id(),
    'title' => 'Event Title',
]);
```

## Blade Templating

### Common Patterns

```blade
{{-- Display variable --}}
{{ $variable }}

{{-- Echo escaped HTML --}}
{{ htmlspecialchars($variable) }}

{{-- Conditionals --}}
@if ($condition)
    Content
@elseif ($other)
    Other
@else
    Default
@endif

{{-- Loops --}}
@foreach ($items as $item)
    {{ $item->name }}
@endforeach

{{-- Loops with empty state --}}
@forelse ($items as $item)
    {{ $item->name }}
@empty
    <p>No items found</p>
@endforelse

{{-- Include other views --}}
@include('partials.header')

{{-- Pass variables to included views --}}
@include('partials.item', ['item' => $item])

{{-- Components --}}
@component('components.alert')
    This is an alert
@endcomponent

{{-- Auth checks --}}
@auth
    User is logged in
@endauth

@guest
    User is not logged in
@endguest

{{-- CSRF token --}}
@csrf

{{-- Form method override --}}
@method('PUT')
@method('DELETE')
```

## Form Validation

### In Form Request

```php
public function rules(): array {
    return [
        'title' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'age' => ['required', 'integer', 'min:18', 'max:100'],
    ];
}

public function messages(): array {
    return [
        'title.required' => 'Title is required.',
        'email.unique' => 'Email already exists.',
    ];
}
```

### In View (Show Errors)

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif

{{-- Display specific field error --}}
@error('title')
    <span class="error">{{ $message }}</span>
@enderror

{{-- Use old input values --}}
<input value="{{ old('title') }}">
```

## Authorization

### Using Policies

```php
// Check authorization
if (auth()->user()->can('update', $event)) {
    // User can update
}

// In controller method
public function edit(Event $event) {
    $this->authorize('update', $event);
    // Continue...
}

// In Blade view
@can('update', $event)
    <a href="#">Edit</a>
@endcan
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/EventTest.php

# Run with coverage
php artisan test --coverage
```

## Debugging

### Using dd() and dump()

```php
// Die and dump (stops execution)
dd($variable);

// Dump only (continues execution)
dump($variable);

// Log to file
\Log::info('Message', ['data' => $variable]);

// Laravel Debugbar (install separately)
// Check storage/logs/laravel.log
```

### Tinker (Interactive Shell)

```bash
php artisan tinker

# Then:
>>> $event = App\Models\Event::first();
>>> $event->participants->count();
>>> App\Models\Admin::factory(5)->create();
```

## Common Issues & Solutions

### N+1 Query Problem
```php
// Problem: Extra queries
$events = Event::all();
foreach ($events as $event) {
    $event->participants; // Query inside loop
}

// Solution: Eager load
$events = Event::with('participants')->get();
```

### Soft Deletes
```php
// Add to model
use SoftDeletes;
protected $dates = ['deleted_at'];

// Check in queries
$events = Event::withTrashed()->get();
$events = Event::onlyTrashed()->get();
```

### Pagination

```php
// In controller
$events = Event::paginate(15);

// In view
{{ $events->links() }}

// With query parameters
{{ $events->appends(request()->query())->links() }}
```

## Performance Tips

1. **Use eager loading** with with()
2. **Add indexes** to foreign keys
3. **Limit query results** with limit() and paginate()
4. **Cache queries** with cache()
5. **Use select()** to get specific columns
6. **Avoid N+1 problems** with relationships

## Version Control

### Git Best Practices
```bash
# Create feature branch
git checkout -b feature/add-comments

# Make changes and commit
git add .
git commit -m "Add comment feature"

# Push to remote
git push origin feature/add-comments

# Create pull request on GitHub
```

### Commit Message Format
```
feat: Add comment feature
fix: Fix pagination bug
docs: Update README
refactor: Simplify event controller
```

## Documentation

### Code Comments

```php
/**
 * Get all events for the authenticated user
 *
 * @param Request $request
 * @return View
 */
public function index(Request $request): View
{
    // Load events with participant count
    $events = Event::with('participants')->get();
    
    return view('events.index', compact('events'));
}
```

## Resources & Links

- [Laravel Docs](https://laravel.com/docs/12.x)
- [Eloquent Relationships](https://laravel.com/docs/12.x/eloquent-relationships)
- [Form Requests](https://laravel.com/docs/12.x/validation#form-request-validation)
- [Policies](https://laravel.com/docs/12.x/authorization#creating-policies)
- [Blade Templates](https://laravel.com/docs/12.x/blade)

## Development Workflow

1. **Plan** - Define features and database schema
2. **Migrate** - Create migrations for database changes
3. **Model** - Create Eloquent models with relationships
4. **Validate** - Create form request classes
5. **Control** - Write controller methods
6. **Route** - Define routes in web.php
7. **View** - Create Blade templates
8. **Test** - Test all functionality
9. **Deploy** - Deploy to production

---

Happy coding! 🚀
