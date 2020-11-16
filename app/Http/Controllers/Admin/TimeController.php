<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Time;
use App\User;
use App\Category;

class TimeController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.timetracker.index', compact('users'));
    }
    public function create(Category $category)
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.timetracker.create', compact('users', 'categories'));
    }
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'start_day'=> 'required',
            'category_id' => 'required',
            'start_time'=> 'required',
            'finish_time'=> 'required',
            'duration' => 'required',
            'notes'=> 'required'
        ]);
        $attributes['user_id']= request('user_id');
        $attributes['start_day'] = \Carbon\Carbon::parse($request->start_day)->format('Y-m-d');
        Time::create($attributes);
        return redirect('/admin/timetracker');
    }
    
}