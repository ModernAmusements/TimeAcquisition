@extends('layouts.app')


@section('content')

<div class="container">

    <table class="table table-striped table-sm">
        @include('partials._yearly-report')
    </table>

    <div class="downloadReport">
        <a href="{{ route('admin.downloadPdf.year', ['id' => $user->id, 'year' => $year]) }}"><button type="button" id="pdfButton" class="btn btn-lg btn-danger">Download Report</button></a>
    </div>

</div>
@endsection
