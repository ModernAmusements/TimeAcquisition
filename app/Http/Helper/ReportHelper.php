<?php

namespace App\Http\Helper;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Time;
use App\User;
use App\Category;
use App\Offtime;
use Carbon\Carbon;
use Auth;
use Date;
use PDF;

class ReportHelper
{

    public static function drawReport($id, Request $request)
    {
       
        $user = User::find($id);
        if (!$user) {
            return false;
        }
        
        $reportValues = self::getReportValues($id, $request);
        extract($reportValues);

        if (Auth::user()->is_admin) {
            if($request->month == null) {
                return view(
                    'admin.report.show',
                    compact('all_ot', 'all_comp', 'year', 'all_vacation', 'all_personal', 'all_sick', 'calculator', 'user', 'total_ot', 'total_comp', 'total_vacation', 'total_personal', 'total_sick', 'vacation_allotment', 'vacation_carry_over', 'work_day', 'personal_time_allotment', 'overtime', 'balance_in_hours_ot', 'balance_in_hours_vacation')
                );
              }  else {
                return view('admin.report.month', compact('all_ot', 'all_comp', 'all_vacation', 'all_personal', 'all_sick', 'calculator','work_day', 'year', 'month', 'user'));
          } 
    }   else {
            if($request->month == null) {
                return view(
                    'report.show',
                    compact('all_ot', 'all_comp', 'year', 'all_vacation', 'all_personal', 'all_sick', 'calculator', 'user', 'total_ot', 'total_comp', 'total_vacation', 'total_personal', 'total_sick', 'vacation_allotment', 'vacation_carry_over', 'work_day', 'personal_time_allotment', 'overtime', 'balance_in_hours_ot', 
                    'balance_in_hours_vacation')
                );
          } else {
            return view('report.month', compact('all_ot', 'all_comp', 'all_vacation', 'all_personal', 'all_sick', 'calculator','work_day', 'year', 'month', 'user'));
          }
        }
    }

    public static function getReportValues($id, Request $request)
    {
        
        $all_ot = array();
        $all_comp = array();
        $all_vacation = array();
        $all_personal = array();
        $all_sick = array();
   
        $total_ot = 0;
        $total_comp = 0;
        $total_vacation = 0;
        $total_personal = 0;
        $total_sick = 0;

        if($request->month == null) {

            if(Auth::user()->is_admin) {

                $times = Time::where('user_id', $id)->whereYear('start_day', $request->year)->get();
                $offtime = Offtime::where('user_id', $id)->whereYear('year', $request->year)->get();
                $use_carry_over = Offtime::where('user_id', $id)->whereYear('year', $request->year)->pluck('use_carry_over')[0];
            }
            else {
                $times = Time::where('user_id', Auth::user()->id)->whereYear('start_day', $request->year)->get();
                $offtime = Offtime::where('user_id', Auth::user()->id)->get();
                $use_carry_over = Offtime::where('user_id', Auth::user()->id)->whereYear('year', $request->year)->pluck('use_carry_over')[0];
            }
            
            $work_day = self::timeToSeconds($offtime[0]->work_day);
            $vacation_allotment = self::timeToSeconds($offtime[0]->vacation_allotment);
            $personal_time_allotment = self::timeToSeconds($offtime[0]->personal_time_allotment);
            
            switch($use_carry_over) {
                case 0:
                    $vacation_carry_over = 0;
                    $overtime = 0;

                break;
                case 1: 
                    $vacation_carry_over = self::timeToSeconds($offtime[0]->vacation_carry_over);
                    $overtime = self::timeToSeconds($offtime[0]->overtime);

                break;

            }
    
            
            foreach ($times as $time) {
                for ($i = 1; $i <= 12; $i++) {
                    $month = Carbon::parse($time->start_day)->format('m');
                    if ($month == $i) {
                        switch ($time->category_id) {
                            case 1:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_ot)) {
                                    $all_ot[$i] = $totalDuration;
                                } else {
                                    $all_ot[$i] += $totalDuration;
                                }
                                break;
                            case 2:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_comp)) {
                                    $all_comp[$i] = $totalDuration;
                                } else {
                                    $all_comp[$i] += $totalDuration;
                                }
                                break;
                            case 3:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_vacation)) {
                                    $all_vacation[$i] = $totalDuration;
                                } else {
                                    $all_vacation[$i] += $totalDuration;
                                }
                                break;
                            case 4:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_personal)) {
                                    $all_personal[$i] = $totalDuration;
                                } else {
                                    $all_personal[$i] += $totalDuration;
                                }
                                break;
                            case 5:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_sick)) {
                                    $all_sick[$i] = $totalDuration;
                                } else {
                                    $all_sick[$i] += $totalDuration;
                                }
                                break;
                        }
                    }
                }
            }
            $calculator = new Time();
            // Total Counts
            $total_ot = self::getTotal($all_ot);
            $total_comp = self::getTotal($all_comp);
            $total_vacation = self::getTotal($all_vacation);
            $total_personal = self::getTotal($all_personal);
            $total_sick = self::getTotal($all_sick);

            $balance_in_hours_ot = $calculator->secToHR($total_ot * 1.5);
            $balance_in_hours_vacation = $calculator->secToHR(($vacation_carry_over + $vacation_allotment) - $total_vacation);

            $data = [
                'all_ot' => $all_ot,
                'all_comp' => $all_comp,
                'all_vacation' => $all_vacation,
                'all_personal' => $all_personal,
                'all_sick' => $all_sick,
                'calculator' => $calculator,
                'total_ot' => $total_ot,
                'total_comp' => $total_comp,
                'total_vacation' => $total_vacation,
                'total_personal' => $total_personal,
                'total_sick' => $total_sick,
                'vacation_allotment' => $vacation_allotment,
                'vacation_carry_over' => $vacation_carry_over,
                'work_day' => $work_day,
                'personal_time_allotment' => $personal_time_allotment,
                'overtime' => $overtime,
                'year' => $request->year,
                'balance_in_hours_ot' => $balance_in_hours_ot,
                'balance_in_hours_vacation' => $balance_in_hours_vacation
            ];

            return $data;

     } else {

        $month = $request->month;
        $user = User::find($id);
        $year = $request->year;
        $month_num = date_parse($month)['month'];
     
        $times = Time::where('user_id', $id)
             ->whereYear('start_day', $year)
             ->whereMonth('start_day', $month_num)
             ->get();

       $offtime = Offtime::where('user_id', $id)->whereYear('year', $request->year)->get();
       $work_day = self::timeToSeconds($offtime[0]->work_day);

       $length_time = count($times);
       foreach ($times as $time){
            for($i = 0; $i < $length_time; $i++) {
                switch ($time->category_id) {
                    case 1:
                        $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                        if (!array_key_exists($i, $all_ot)) {
                            $all_ot[$i] = $totalDuration;
                        } else {
                            $all_ot[$i] += $totalDuration;
                        }
                        break;
                    case 2:
                        $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                        if (!array_key_exists($i, $all_comp)) {
                            $all_comp[$i] = $totalDuration;
                        } else {
                            $all_comp[$i] += $totalDuration;
                        }
                        break;
                    case 3:
                        $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                        if (!array_key_exists($i, $all_vacation)) {
                            $all_vacation[$i] = $totalDuration;
                        } else {
                            $all_vacation[$i] += $totalDuration;
                        }
                        break;
                    case 4:
                        $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                        if (!array_key_exists($i, $all_personal)) {
                            $all_personal[$i] = $totalDuration;
                        } else {
                            $all_personal[$i] += $totalDuration;
                        }
                        break;
                    case 5:
                        $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                        if (!array_key_exists($i, $all_sick)) {
                            $all_sick[$i] = $totalDuration;
                        } else {
                            $all_sick[$i] += $totalDuration;
                        }
                        break;
                  }
            }
           
        }
  
        $all_ot = self::isNull($all_ot);
        $all_comp = self::isNull($all_comp);
        $all_vacation = self::isNull($all_vacation);
        $all_personal = self::isNull($all_personal);
        $all_sick = self::isNull($all_sick);
        
        $calculator = new Time();

        
        $data = [
            'all_ot' => $all_ot,
            'all_comp' => $all_comp,
            'all_vacation' => $all_vacation,
            'all_personal' => $all_personal,
            'all_sick' => $all_sick,
            'calculator' => $calculator,
            'work_day' => $work_day,
            'year' => $request->year,
            'month' => $request->month,
            'user' => $user
        ];

        return $data;
     }
    }

    private static function getTotal($times) {
        $total = 0;
        $arr = array_values($times);
        $length_arr = count($arr);
        for ($i = 0; $i < $length_arr; $i++) {
            return $total += $arr[$i];
        }
    }

    private static function timeToSeconds($time) {
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        return $time = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
    }

    public static function downloadPDF($id, Request $request) {

         $user = User::find($id);
         $reportValues = self::getReportValues($id, $request);
         extract($reportValues);

         if($request->month == null) {
            $pdf = PDF::loadView('report.pdf', compact('all_ot', 'all_comp', 'all_vacation', 'all_personal', 'all_sick', 'year', 'calculator', 'user', 'total_ot', 'total_comp', 'total_vacation', 'total_personal', 'total_sick', 'vacation_allotment', 'vacation_carry_over', 'work_day', 'personal_time_allotment', 'overtime', 
            'balance_in_hours_ot', 'balance_in_hours_vacation' ));

            return $pdf->download('report.pdf');
     }   else {

            $pdf = PDF::loadView('report.pdf', compact('all_ot', 'all_comp', 'all_vacation', 'all_personal', 'all_sick', 'calculator','work_day', 'year', 'month', 'user'));

            return $pdf->download('report.pdf');
    }

}
    private static function isNull($time) {

        if (empty($time)) {
            return $time = null;
        }  else {
            return $time = $time[0];
        }
    }

}