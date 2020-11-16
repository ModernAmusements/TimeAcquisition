@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                        <div class="enterWorkHours">
                            <a href="/admin/timetracker/create"><button type="button" id="enterHoursButton" class="btn btn-lg btn-dark">Enter Work Hours</button></a>
                        </div>

                        <br>

                        <div class="editWorkHours">
                            <a href="/admin/staff"><button type="button" id="editHoursButton" class="btn btn-lg btn-danger">Edit Staff Hours</button></a></a>
                        </div>
                        <br>
                        <div class="viewReports">
                                <a href="/admin/reports/create"><button type="button" id="viewReports" class="btn btn-lg btn-dark">View Reports</button></a></a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection