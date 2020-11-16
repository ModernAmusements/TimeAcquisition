@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                        <div class="enterWorkHours">
                            <a href="/timetracker/create"><button type="button" id="enterHours" class="btn btn-lg btn-danger">Enter Work Hours</button></a>
                        </div>
                        <br>

                        <div class="viewReports">
                                <a href="/reports/create"><button type="button" id="viewReports" class="btn btn-lg btn-dark">View Reports</button></a></a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection