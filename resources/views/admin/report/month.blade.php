@extends('layouts.app')


@section('content')

<div class="container">

    <table class="table table-striped table-sm">
        @include('partials._monthly-report')
    </table>

    <div class="downloadReport">
        <a href="{{ route('admin.downloadPdf.month', ['id' => $user->id, 'year' => $year, 'month' => $month]) }}"><button type="button" id="pdfButton" class="btn btn-lg btn-danger">Download Report</button></a>
    </div> 

</div>
@endsection
