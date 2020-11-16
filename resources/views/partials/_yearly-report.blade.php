<thead class="tableCols">
     <tr>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"><h4><b>{{ $year }} Report for {{ $user->name }}</b></h4></th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
     </tr>
     <tr>
         <th scope="col">Month</th>
         <th scope="col">Overtime Hours</th>
         <th scope="col">Compensation Hours</th>
         <th scope="col">Vacation</th>
         <th scope="col">Personal Hours</th>
         <th scope="col">Sick Hours</th>
     </tr>
 </thead>
 <tbody>
       <tr>
           <th scope="row">Carry Over</th>
           <th>{{ empty($overtime)? '-' : $calculator->secToHR($overtime) }}</th>
           <th>-</th>
           <th>{{ empty($vacation_carry_over)? '-' : $calculator->secToHR($vacation_carry_over)}}</th>
           <th>-</th>
           <th>-</th>
       </tr>

       <tr>
           <th scope="row">Allotted</th>
           <th>-</th>
           <th>-</th>
           <th>{{ empty($vacation_allotment)? '-' : $calculator->secToHR($vacation_allotment)}}</th>
           <th>{{ empty($personal_time_allotment)? '-' : $calculator->secToHR($personal_time_allotment) }}</th>
           <th>-</th>
       </tr>

       <tr>
           <th scope="row">Starting Total</th>
           <th>-</th>
           <th>-</th>
           <th>{{ $vacation_carry_over + $vacation_allotment == 0? '-' : $calculator->secToHR($vacation_carry_over + $vacation_allotment) }}</th>
           <th>{{ $personal_time_allotment == 0? '-' : $calculator->secToHR($personal_time_allotment)  }}</th>
           <th>-</th>
       </tr>


   @for($i = 1; $i <= 12; $i++)
         <tr>
             <th scope="row">{{ date('F', mktime(0, 0, 0, $i, 1))}}</th>
             <td><b>{{empty($all_ot[$i])? '-' : $calculator->secToHR($all_ot[$i])}}</b></td>
             <td><b>{{empty($all_comp[$i])? '-' : $calculator->secToHR($all_comp[$i])}}</b></td>
             <td><b>{{empty($all_vacation[$i])? '-' : $calculator->secToHR($all_vacation[$i])}}</b></td>
             <td><b>{{empty($all_personal[$i])? '-' : $calculator->secToHR($all_personal[$i])}}</b></td>
             <td><b>{{empty($all_sick[$i])? '-' : $calculator->secToHR($all_sick[$i])}}</b></td>
         </tr>
   @endfor

    <tr>
       <th scope="row">Yearly Total</th>
       <th><b>{{ empty($total_ot)? '0:00' : $calculator->secToHR($total_ot)}}</b></th>
       <th><b>{{ empty($total_comp)? '0:00' : $calculator->secToHR($total_comp)}}</b></th>
       <th><b>{{ empty($total_vacation)? '0:00' : $calculator->secToHR($total_vacation)}}</b></th>
       <th><b>{{ empty($total_personal)? '0:00' : $calculator->secToHR($total_personal)}}</b></th>
       <th><b>{{ empty($total_sick)? '0:00' : $calculator->secToHR($total_sick)}}</b></th>
   </tr>


   <tr>
       <th scope="row">Balance in Hours</th>
       <th>{{ $balance_in_hours_ot}} ({{ $calculator->secToHR($total_ot) }}@1.5x)</th>
       <th>{{ $calculator->secToHR(($total_ot * 1.5)-($total_comp)) }}</th>
       <th>{{ $balance_in_hours_vacation }}</th>
       <th>{{ $calculator->secToHR($personal_time_allotment - $total_personal)  }}</th>
       <th>{{ $calculator->secToHR($total_sick) }}</th>
   </tr>

   <tr>
       <th scope="row">Balance in Days</th>
       <th>{{ empty($work_day)?"0:00" :round(($total_ot * 1.5)/$work_day, 2 )}}</th>
       <th>{{ empty($work_day)?"0:00" :round((($total_ot * 1.5)-($total_comp))/$work_day, 2) }}</th>
       <th>{{ empty($work_day)?"0:00" :round(($vacation_carry_over+$vacation_allotment-$total_vacation)/$work_day, 2)}}</th>
       <th>{{ empty($work_day)?"0:00" :round(($personal_time_allotment - $total_personal)/$work_day, 2) }}</th>
       <th>{{ empty($work_day)?"0:00" :round(($total_sick)/$work_day, 2) }}</th>
    </tr>

 </tbody>