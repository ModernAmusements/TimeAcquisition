@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h2>
                Create {{ $year }} for {{ $user->name }}
            </h2>
        <div class="editStaffCard card">
            <div class="card-body">
                <form method="POST" action="/admin/staff/{{ $offtime->id }}/{{ $year }}">
                    @csrf

                    <select name="user_id" class="form-control" id="formUsers" placeholder="Select Username"  style="display: none;">
                        <option>
                            {{ $user->id }}
                        </option>
                     </select>

     
                         <input name="year" type="read-only" class="form-control" id="yearForm" value={{ $year }} style="display: none">
                    {{-- <h2>Edit 2019 for {{ $user->name }}</h2> --}}
                    <div class="form-group">
                        <label for="workDayForm">Work Day in Hours</label>
                        <input name="work_day" type="read-only" class="form-control" id="workDayForm" value="0:00">
                    </div>

                    <div class="form-group">
                        <label for="vacationTime">Vacation Allotment</label>
                        <input name="vacation_allotment" type="read-only" class="form-control" id="vacationTime" value="0:00">
                    </div>

                    <div class="form-group">
                        <label for="personalTime">Personal Time Allotment</label>
                        <input name="personal_time_allotment" type="read-only" class="form-control" id="personalTime" value="0:00">
                    </div>

                    <div class="form-group">
                        <label for="overTime">Overtime</label>
                        <input name="overtime" type="read-only" class="form-control" id="overTime" value="0:00">
                    </div>

                    <div class="form-group">
                        <label for="overTime">Vacation Carry Over</label>
                        <input name="vacation_carry_over" type="read-only" class="form-control" id="overTime" value="0:00">
                    </div>

                    <input name="use_carry_over" type='hidden' value='0' id="hiddenCarryOver">
                    <div class="form-check">
                        <input name="use_carry_over" class="form-check-input" type="checkbox" value="1" id="carryOver" style="display: none"> 
                    </div>
                 
                    <br>
                    
                    <div>
                        <button type="submit" id="editStaffButton" class="btn btn-danger">Submit</button>
                    </div> 

                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection