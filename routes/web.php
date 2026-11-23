
<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Models\Course;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Display Create Student Form
Route::get('/student/create', function () {
    return view('student.create');
});

// Store Student in MySQL
Route::post('/student', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:students,email',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

// Display All Students
Route::get('/students', function () {
    $students = Student::all();

    return view('student.list', [
        'students' => $students
    ]);
})->name('students.index');


 
// Display Individual Student Details
Route::get('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);

    return view('student.detail', [
        'student' => $student
    ]);
});


 
// Display Edit Student Form
Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);

    return view('student.edit', [
        'student' => $student
    ]);
});


 
// Update Student Information
Route::put('/students/{id}', function (Request $request, $id) {

    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('students')->ignore($student->id),
        ],
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
});

 
// Delete Student
Route::delete('/students/{id}', function ($id) {

    $student = Student::findOrFail($id);

    $student->delete();

    return redirect('/students')
        ->with('success', 'Student deleted successfully!');
});


 
// =======================================
// COURSE CRUD ROUTES
// =======================================

// 1. Display All Courses
Route::get('/courses', function () {
    $courses = Course::all();

    return view('course.list', [
        'courses' => $courses
    ]);
})->name('courses.index');


// 2. Display Create Course Form
Route::get('/courses/create', function () {
    return view('course.create');
})->name('courses.create');


// 3. Store New Course
Route::post('/courses', function (Request $request) {

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => [
            'required',
            Rule::in(['Easy', 'Medium', 'Hard'])
        ],
        'is_active' => 'required|boolean',
    ]);

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");

})->name('courses.store');


// 4. Display Individual Course Details
Route::get('/courses/{id}', function ($id) {

    $course = Course::findOrFail($id);

    return view('course.detail', [
        'course' => $course
    ]);

})->name('courses.show');


// 5. Display Edit Course Form
Route::get('/courses/{id}/edit', function ($id) {

    $course = Course::findOrFail($id);

    return view('course.edit', [
        'course' => $course
    ]);

})->name('courses.edit');


// 6. Update Existing Course
Route::put('/courses/{id}', function (Request $request, $id) {

    $course = Course::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => [
            'required',
            Rule::in(['Easy', 'Medium', 'Hard'])
        ],
        'is_active' => 'required|boolean',
    ]);

    $course->update($validated);

    return redirect()->route('courses.show', $course->id)
        ->with('success', 'Course updated successfully!');

})->name('courses.update');


// 7. Delete Course
Route::delete('/courses/{id}', function ($id) {

    $course = Course::findOrFail($id);

    $course->delete();

    return redirect()->route('courses.index')
        ->with('success', 'Course deleted successfully!');

})->name('courses.destroy');

