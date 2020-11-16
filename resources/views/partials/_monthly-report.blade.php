    <thead class="tableCols">
        <tr>
            <th scope="col"></th>
            <th scope="col"><h4><b>{{ $month }} {{ $year }} Report for {{ $user->name }}</b></h4></th>
            <th scope="col"></th>
        </tr>
         <tr>
            <th scope="col">Monthly Summary</th>
             <th scope="col">Total in Hours</th>
             <th scope="col">Total in Days</th>
         </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Overtime</th>
            <th>{{ $all_ot == null? '' : $calculator->secToHR($all_ot * 1.5) }} ({{ $calculator->secToHR($all_ot)  }}@1.5x)</th>
            <th>{{ $all_ot == null? '-' : round(($all_ot * 1.5)/($work_day))}}</th>
       </tr>
        <tr>
            <th scope="row">Compensation Hours</th>
            <th>{{ $all_comp == null? '-' : $calculator->secToHR($all_comp) }}</th>
            <th>{{ $all_comp == null? '-' : round(($all_comp)/($work_day))}}</th>
        </tr>
        <tr>
            <th scope="row">Vacation</th>
            <th>{{ $all_vacation == null? '-' : $calculator->secToHR($all_vacation) }}</th>
            <th>{{ $all_vacation == null? '-' : round(($all_vacation)/($work_day))}}</th>
        </tr>
        <tr>
            <th scope="row">Personal Hours</th>
            <th>{{ $all_personal == null? '-' : $calculator->secToHR($all_personal) }}</th>
            <th>{{ $all_personal == null? '-' : round(($all_personal)/($work_day))}}</th>
        </tr>
        <tr>
            <th scope="row">Sick Hours</th>
            <th>{{ $all_sick == null? '-' : $calculator->secToHR($all_sick) }}</th>
            <th>{{ $all_sick == null? '-' : round(($all_sick)/($work_day))}}</th>
        </tr> 

    </tbody>