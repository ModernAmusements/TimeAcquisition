@extends('layouts.app')

@section('content')

<div class="container">
    <div id="timeCreate" class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="/timetracker">
                             @include('partials._timetracker') 
                        </form>
                    </div>
                </div>
           </div>
    </div>
</div>

@endsection