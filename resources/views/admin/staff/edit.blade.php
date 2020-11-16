@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h2>
                Edit {{ $year }} for {{ $user->name }}
            </h2>
        
        <div class="editStaffCard card">
            <div class="card-body">
            <form method="POST" action="/admin/staff/{{ $id }}/{{ $year}}">
                    @csrf
                    {{ method_field('PATCH') }}

                    <select name="user_id" class="form-control" id="formUsers" placeholder="Select Username"  style="display: none;">
                        <option>
                            {{ $user->id }}
                        </option>
                     </select>
                    {{-- <h2>Edit 2019 for {{ $user->name }}</h2> --}}
                    <div class="form-group">
                        <label for="workDayForm">Work Day in Hours</label>
                        <input name="work_day" type="read-only" class="form-control" id="workDayForm" value="{{ $work_day}}">
                    </div>

                    <div class="form-group">
                        <label for="vacationTime">Vacation Allotment</label>
                        <input name="vacation_allotment" type="read-only" class="form-control" id="vacationTime" value="{{ $vacation_allotment }}">
                    </div>

                    <div class="form-group">
                        <label for="personalTime">Personal Time Allotment</label>
                        <input name="personal_time_allotment" type="read-only" class="form-control" id="personalTime" value="{{ $personal_time }}">
                    </div>

                    <div class="form-group">
                        <label for="overtime">Overtime</label>
                        <input name="overtime" type="read-only" class="form-control" id="overtime" value="{{ $overtime }}">
                    </div>

                    <div class="form-group">
                        <label for="vacationCarryOver">Vacation Carry Over</label>
                        <input name="vacation_carry_over" type="read-only" class="form-control" id="vacationCarryOver" value="{{ $vacation_carry_over }}">
                    </div>

                    
                    @if($use_carry_over == 1)
                    <input name="use_carry_over" type='hidden' value='0' id="hiddenCarryOver">
                    <div class="form-check">
                            <input name="use_carry_over" class="form-check-input" type="checkbox" value="1" id="carryOver" checked>
                            <label class="form-check-label" for="carryOver"> Use Carry Over? </label>
                    </div>
                    
                    @else
                    <input name="use_carry_over" type='hidden' value='0' id="hiddenCarryOver">
                    <div class="form-check">
                        <input name="use_carry_over" class="form-check-input" type="checkbox" value="1" id="carryOver">
                        <label class="form-check-label" for="carryOver"> Use Carry Over? </label>
                    </div>
                    @endif

                    <br>
                    <div class="updateCarry">
                        <button type="submit" name="action" id="updateCarryOver" class="btn btn-dark" value="updateCarryOver">Update Carry Over</button>
                        <p class="last_updated">Last Updated: {{ $last_updated }}</p>
                    </div>
                    <br>
                    <div class="editHours">
                        <button type="submit" name="action" id="editStaffButton" class="btn btn-danger" value="editHours">Submit</button>
                    </div> 
                  

                </form>
            </div>
        </div>
        <br>
        <div class="returnBack">
            <a href="/admin/staff/{{ $user->id }}"><button id="returnBackButton" type="submit" class="btn btn-md btn-dark">Return back</button></a>
        </div>
        <br>
        @if(session()->has('notify'))
        <div class="row">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session()->get('notify') }} for {{ $user->name }}
            </div>
        </div>
        @endif
    </div>
    
</div>
</div>
@endsection