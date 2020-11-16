<h1>McMaster CSU</h1>
    <table style="  text-align:center;
    border-style: solid;
    border-color: rgb(230,230,230);
    display: flex;
    justify-content: center;
    font-family: sans-serif;
    ">
        @if(empty($month)) 
            @include('partials._yearly-report')
        @else
            @include('partials._monthly-report')
        @endif
    </table>

