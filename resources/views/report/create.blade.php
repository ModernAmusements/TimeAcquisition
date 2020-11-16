@extends('layouts.app')


@section('content')

<div id="reportCreate" class="container">
    <div class="row justify-content center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('getReport') }}">
                        @csrf
                        <div class="form-group">
                            <label for="formUsers"><b>User</b></label>
                            <select name="form_user" class="form-control" id="formUsers" placeholder="Select Username">
                            <option name="user_id" value="{{ $user->id }}">
                                     {{ $user->name }}
                                    </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="reportTypeForm"><b>Report Type</b></label>
                            <select name="reportTypeForm" class="form-control" id="reportTypeForm" placeholder="Select Report Type">
                                    <option>
                                        Yearly
                                    </option>
                                    <option>
                                        Single Month
                                    </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year"><b>Year</b></label>
                            <select name="year" class="form-control" id="timeYearForm" placeholder="Select Year">
                                @foreach ($years as $year)
                                <option>
                                    {{ $year }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="reportMonth"><b>Month</b></label>
                            <select name="month" class="form-control" id="reportMonth" placeholder="Select Month">
                                @foreach ($months as $month)
                                    <option>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" id="reportButton" class="btn btn-danger">Get Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
