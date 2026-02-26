<table>
    <thead>
        <tr>
             <th style="font-weight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Name</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Email</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Phone</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Service Type</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Price</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Domain Name</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Duration</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Start Date</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Expire Date</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach($plans as $plan)
            <tr>
              <td> {{$plan->clients()->first()->name}}</td>
              <td> {{$plan->clients()->first()->email}}</td>
              <td> {{$plan->clients()->first()->phone}}</td>
              <td> {{$plan->service_type()->first()->name}}</td>
              <td> {{$plan->price}}</td>
              <td> {{$plan->domain_name}}</td>
              <td> {{$plan->duration.'yr'}}</td>
              <td style="text-align: center"> {{ \Carbon\Carbon::parse($plan->start_date)->format('d-m-Y') }}</td> 
              <td style="text-align: center"> {{ \Carbon\Carbon::parse($plan->expire_date)->format('d-m-Y') }}</td> 
            </tr>
        @endforeach
    </tbody>
</table>







