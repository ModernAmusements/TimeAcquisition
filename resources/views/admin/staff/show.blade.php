@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justidy-content-center">
        <div class="col-md-5">
            <h2 class="editStaffHours">Edit {{ $user->name }} Hours</h2>
                <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Years</th>
                    </tr>
                </thead>
                <tbody>
                  
                        <tr>
                            <td>
                                <a href="/admin/staff/{{ $user->id }}/create/{{ $min_year - 1 }}"><p style="color:maroon; font-weight:bold;">{{ $min_year - 1}} - Add New</p></a>
                            </td>
                        </tr>
                    @foreach($years as $year)
                        <tr>
                            <td>
                                <a href="/admin/staff/{{ $user->id }}/{{ $year }}/edit"><p style="color:maroon; font-weight:bold;">{{ $year }}</p></a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <a href="/admin/staff/{{ $user->id }}/create/{{ $max_year + 1 }}" ><p style="color:maroon; font-weight:bold;">{{ $max_year + 1}} - Add New</p></a>
                        </td>
                    </tr>
                </tbody>
                </table>   

                <div class="crudStaffButtons">
                    <a href="/admin/staff/"><button type="submit" class="btn btn-md btn-dark">View Staff</button></a>
                    <a href="/admin/staff/{{ $user->id }}/{{ $current_year }}/edit"><button id="editCurrentYearButton" type="submit" class="btn btn-md btn-danger">Edit Current Year</button></a>
                </div>
        </div>
    </div>
</div>

@endsection