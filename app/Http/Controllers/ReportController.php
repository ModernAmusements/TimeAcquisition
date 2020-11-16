<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Time;
use App\User;
use App\Category;
use App\Offtime;
use Carbon\Carbon;
use Auth;
use Date;
use App\Http\Helper\ReportHelper;
use PDF;

class ReportController extends Controller
{
    public function create()
    {
        $user = auth()->user();
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

        
        $years_time = Time::where('user_id', $user->id)->pluck('start_day')->sort();

        foreach($years_time as $year){
            $year = Carbon::parse($year)->format('Y');
            array_push($years, $year);
        }

        $years = array_unique($years);
       
        
        return view('report.create', compact('user', 'years', 'months'));
    }
    public function show($id, Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
      
        if ($user_id != $id) {
            return abort(404);
        }
        
        return ReportHelper::drawReport($id, $request);

    }

    public function month($id, Request $request){

        $user = auth()->user();
        $user_id = $user->id;
      
        if ($user_id != $id) {
            return abort(404);
        }
        
        return ReportHelper::drawReport($id, $request);
    
    }

    public function downloadPdf($id, Request $request) {

        return ReportHelper::downloadPDF($id, $request);
    }

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

        $user = auth()->user();

        if ($user && $reportType == 'Yearly') {
            return redirect()->route('report.show', [$user->id, 'year' => $year]);
        }
        elseif ($user && $reportType == 'Single Month') {
            return redirect()->route('report.month', [$user->id, 'year' => $year, 'month' => $month]);
        }

        return abort(404);
    }

}
