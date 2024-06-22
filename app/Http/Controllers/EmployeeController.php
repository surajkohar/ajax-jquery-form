<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     // dd($request->all());
    //     $perPage = 3; // Number of employees per page
    //     $page = $request->input('page', 1);
    //     $searchTerm = $request->input('search', '');
    //     $dateFilter = $request->input('date', '');

    //     $query = Employee::query();

    //     // Apply search filter
    //     if (! empty($searchTerm)) {
    //         $query->where(function ($q) use ($searchTerm) {
    //             $q->where('firstname', 'like', '%'.$searchTerm.'%')
    //                 ->orWhere('lastname', 'like', '%'.$searchTerm.'%')
    //                 ->orWhere('email', 'like', '%'.$searchTerm.'%')
    //                 ->orWhere('phone', 'like', '%'.$searchTerm.'%')
    //                 ->orWhere('status', 'like', '%'.$searchTerm.'%');
    //         });
    //     }

    //     // Apply date filter
    //     if (! empty($dateFilter)) {
    //         $query->whereDate('joining_date', $dateFilter)
    //             ->orWhereDate('leaving_date', $dateFilter);
    //     }

    //     $employees = $query->paginate($perPage);

    //     return response()->json($employees);

    // }

    public function index(Request $request)
    {
        $perPage = 3; // Number of employees per page
        $page = $request->input('page', 1);
        $searchTerm = $request->input('search', '');
        $dateFilter = $request->input('date', '');
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');

        $query = Employee::query();

        // Apply search filter
        if (! empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('firstname', 'like', '%'.$searchTerm.'%')
                    ->orWhere('lastname', 'like', '%'.$searchTerm.'%')
                    ->orWhere('email', 'like', '%'.$searchTerm.'%')
                    ->orWhere('phone', 'like', '%'.$searchTerm.'%')
                    ->orWhere('status', 'like', '%'.$searchTerm.'%');
            });
        }

        // Apply date filter
        if (! empty($dateFilter)) {
            $query->whereDate('joining_date', $dateFilter)
                ->orWhereDate('leaving_date', $dateFilter);
        }

        // Apply sorting
        $query->orderBy($sortField, $sortDirection);

        $employees = $query->paginate($perPage);

        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'joining_date' => 'required|date',
            'leaving_date' => 'nullable|date',
        ]);

        Employee::create($validatedData);

        return response()->json(['message' => 'Employee added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
