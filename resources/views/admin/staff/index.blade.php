@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justidy-content-center">
        <div class="col-md-5">
            {{-- <img src="\css\images\McMaster.jpg" alt="logo"> --}}
            <h2 class="editStaffHours">Edit Staff Hours</h2>
                <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach ($users as $user)
                    <tr>
                     <td>
                        <a href="/admin/staff/{{ $user->id }}"><p style="color:maroon; font-weight:bold;">{{ $user->name }}</p></a>
                     </td>
                    </tr>
                 @endforeach
                </tbody>
                </table>
        </div>
    </div>
</div>

@endsection