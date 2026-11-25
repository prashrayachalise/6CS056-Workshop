<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    // Display all courses
    public function index()
    {
        return view('course.list', [
            'courses' => Course::all(),
        ]);
    }

    // Show create course form
    public function create()
    {
        return view('course.create');
    }

    // Store new course
    public function store(Request $request)
    {
        $course = Course::create(
            $request->validate($this->rules())
        );

        return redirect()
            ->route('courses.index')
            ->with('success', "Course {$course->name} created successfully!");
    }

    // Display course details
    public function show(Course $course)
    {
        return view('course.detail', [
            'course' => $course,
        ]);
    }

    // Show edit course form
    public function edit(Course $course)
    {
        return view('course.edit', [
            'course' => $course,
        ]);
    }

    // Update course
    public function update(Request $request, Course $course)
    {
        $course->update(
            $request->validate($this->rules())
        );

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    // Delete course
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    // Reusable validation rules
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'fee' => 'required|numeric|min:0',
            'difficulty' => [
                'required',
                Rule::in(['Easy', 'Medium', 'Hard']),
            ],
            'is_active' => 'boolean',
        ];
    }
}
