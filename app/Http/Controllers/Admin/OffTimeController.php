<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Time;
use App\User;
use App\Category;
use App\Offtime;
use App\Http\Helper\ReportHelper;
use Session;
use Carbon\Carbon;

class OffTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::all()->sortBy('name');

        return view('admin.staff.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $year)
    {
        $user = User::findOrFail($id);
        $offtime = Offtime::findOrFail($id);
        $current_year = date("Y");

        $work_day = $this->secToHR($this->timeToSeconds($offtime->work_day));
        $vacation_allotment = $this->secToHR($this->timeToSeconds($offtime->vacation_allotment));
        $personal_time = $this->secToHR($this->timeToSeconds($offtime->personal_time_allotment));
        $overtime = $this->secToHR($this->timeToSeconds($offtime->overtime));
        $vacation_carry_over = $this->secToHR($this->timeToSeconds($offtime->vacation_carry_over));
        $use_carry_over = $offtime->use_carry_over;
  
        return view('admin.staff.create', compact('user', 'current_year', 'offtime', 'work_day', 'vacation_allotment', 'personal_time', 'overtime', 'vacation_carry_over', 'use_carry_over', 'year'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
  
        $attributes = request()->validate([
            'work_day'=> 'required',
            'vacation_allotment' => 'required',
            'personal_time_allotment'=> 'required',
            'overtime'=> 'required',
            'vacation_carry_over' => 'required',
            'use_carry_over' => 'required',
            'year' => 'required'
        ]);
        $attributes['user_id']= request('user_id');
        Offtime::create($attributes);
        return redirect()->route('admin.staff.show', ['staff' => $id]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $current_year = date("Y");
        $years = Offtime::where('user_id', $id)->pluck('year')->sort();

        $min_year = $years->min();
        $max_year = $years->max();
      
        return view ('admin.staff.show', compact('user', 'years', 'current_year', 'min_year', 'max_year'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request, $year)
    {
        $user = User::findOrFail($id);
        $user_id = $user->id;
        
        $offtime = Offtime::where('user_id', $id)->whereYear('year', $year )->get();
        $offtime->toArray();
        $use_carry_over = $offtime[0]->use_carry_over;
        $vacation_carry_over = $this->secToHR($this->timeToSeconds($offtime[0]->vacation_carry_over));

        $work_day = $this->secToHR($this->timeToSeconds($offtime[0]->work_day));
        $vacation_allotment = $this->secToHR($this->timeToSeconds($offtime[0]->vacation_allotment));
        $personal_time = $this->secToHR($this->timeToSeconds($offtime[0]->personal_time_allotment));
        $overtime = $this->secToHR($this->timeToSeconds($offtime[0]->overtime));

        $last_updated = Offtime::where('user_id', $id)
            ->whereYear('year', $year )
            ->where('vacation_carry_over', $vacation_carry_over)
            ->value('updated_at');
        
        $last_updated = Carbon::parse($last_updated)->format('Y-m-d G:i');

    return view('admin.staff.edit', compact('user', 'offtime', 'work_day', 'vacation_allotment', 'personal_time', 'overtime', 'vacation_carry_over','use_carry_over', 'year', 'id', 'last_updated'));
    }



    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update($id, Request $request, $year)
    {

        $all_ot = array();
        $all_vacation = array();
        $total_ot = 0;
        $total_vacation = 0;

        $times_last_year = Time::where('user_id', $id)->whereYear('start_day', $request->year-1)->get();
        $offtime_last_year = Offtime::where('user_id', $id)->whereYear('year', $year-1)->get();

        if($offtime_last_year->isEmpty()){
          
            $offtime = Offtime::where('user_id', $id)->whereYear('year', $year )->get()->first();
            $offtime->update(request(['work_day','vacation_allotment','personal_time_allotment','overtime','vacation_carry_over','use_carry_over'])); 
            $offtime->save();
            
            return back();
        }
        else {

            $work_day = $this->timeToSeconds($offtime_last_year[0]->work_day);
            $vacation_allotment = $this->timeToSeconds($offtime_last_year[0]->vacation_allotment);
            $vacation_carry_over = $this->timeToSeconds($offtime_last_year[0]->vacation_carry_over);
            $overtime = $this->timeToSeconds($offtime_last_year[0]->overtime);
    
            foreach ($times_last_year as $time) {
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
                            case 3:
                                $totalDuration = Carbon::parse($time->start_time)->diffInSeconds(Carbon::parse($time->finish_time));
                                if (!array_key_exists($i, $all_vacation)) {
                                    $all_vacation[$i] = $totalDuration;
                                } else {
                                    $all_vacation[$i] += $totalDuration;
                                }
                                break;
                        }
                    }
                }
            }
            
            $calculator = new Time();

            $ot = array_values($all_ot);
            $length_ot = count($ot);
            for ($i = 0; $i < $length_ot; $i++) {
                $total_ot += $ot[$i];
            }

            $vacation = array_values($all_vacation);
            $length_vacation = count($vacation);
            for ($i = 0; $i < $length_vacation; $i++) {
                $total_vacation += $vacation[$i];
            }

            $balance_in_hours_ot = $calculator->secToHR($total_ot * 1.5);
            $balance_in_hours_vacation = $calculator->secToHR(($vacation_carry_over + $vacation_allotment) - $total_vacation);

            switch($request->action) {
                case 'editHours':
                    $offtime = Offtime::where('user_id', $id)->whereYear('year', $year )->get()->first();
                    $offtime->update(request(['work_day','vacation_allotment','personal_time_allotment','overtime','vacation_carry_over','use_carry_over'])); 
                    $offtime->save();
                    session()->flash('notify', 'Successfully Updated');
            
                break;

                case 'updateCarryOver':
                    $offtime = Offtime::where('user_id', $id)->whereYear('year', $year )->get()->first();
                    $offtime->update(['overtime' => $balance_in_hours_ot, 'vacation_carry_over' => $balance_in_hours_vacation, 'use_carry_over' => $request->use_carry_over]);
                    $offtime->save();
                    session()->flash('notify', 'Updated Carry Over Successful');

                break;

                }
            }
            return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function timeToSeconds($time) {
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        return $time = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
    }

    public function secToHR($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        if (strlen($minutes) < 2){
        $minutes = $minutes ."0";
      }
        return "$hours:$minutes";
      }

   
}