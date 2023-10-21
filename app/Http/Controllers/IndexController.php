<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Mark;
use App\Models\Option;
use App\Models\Parameter;
use App\Models\Part;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $marks = Mark::all();
        $vehicles = Vehicle::all();
        $parts = Part::all();
        $categories = Category::all();
        $parameters = Parameter::all();
        $options = Option::all();
        return view('index', compact('marks', 'vehicles', 'parts', 'categories', 'parameters', 'options'));
    }
}