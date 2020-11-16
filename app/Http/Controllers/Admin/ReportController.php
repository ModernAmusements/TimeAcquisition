<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\ReportHelper;
use App\Time;
use App\User;
use App\Category;
use App\Offtime;

use Carbon\Carbon;

use Auth;
use Date;
use PDF;
use Session;


class ReportController extends Controller
{
    public function create()
    {

        $users = User::all();
        $times = Time::all();

        $years = array();
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );

        $length_times = count($times);
        for($i=0;$i<$length_times;$i++){
            $year = Carbon::parse($times[$i]->start_day)->format('Y');
            array_push($years, $year);
        }
        $years = array_unique($years);
        
        return view('admin.report.create', compact('users', 'years', 'months'));
    }

    public function show($id, Request $request){

        if (!$id) { return abort(404);}
        
        return ReportHelper::drawReport($id, $request);

    }

    public function month($id, Request $request){

        if (!$id) { return abort(404);}
        
        return ReportHelper::drawReport($id, $request);
    
    }

    public function downloadPdf($id, Request $request) {
        
        return ReportHelper::downloadPDF($id, $request);
    }

// Post function
    public function getReport(Request $request) {

        $form_user = $request->form_user;
        $reportType = $request->reportTypeForm;
        $month = $request->month;
        $year = $request->year;
        
        $offtimes = Offtime::where('user_id', $form_user)->whereYear('year', $year)->get();
        
        if (!$form_user) {
            return abort(404);
        }
        
        if($offtimes->isEmpty()) {
             DB::table('offtimes')->insert([
                    ['user_id' => $form_user,
                    'work_day'=> '8:00',
                    'vacation_allotment' => '0:00',
                    'personal_time_allotment' => '0:00',
                    'overtime' => '0:00',
                    'vacation_carry_over' => '0:00',
                    'use_carry_over' => 0,
                    'year' => $year,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }

        $user = User::find($form_user);
        $id = $user->id;

        if ($user && $reportType == 'Yearly') {
            return redirect()->route('admin.report.show', [$id, 'year' => $year]);
        }
        elseif ($user && $reportType == 'Single Month') {
            return redirect()->route('admin.report.month', [$id, 'year' => $year, 'month' => $month]);
        }

        return abort(404);

    }


}
