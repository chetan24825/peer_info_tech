<table>
    <thead>
        <tr>
             <th style="font-weight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Name</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Email</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Phone</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Service Type</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Domain Name</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Plan Duration</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Price</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Plan Start</th>
             <th style="font-wxeight: bold; text-align: center; background-color: #dddddd; width: 100px; border: 1px solid #000;">Plan End</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
              <td> {{($client->name)?$client->name:""}}</td>
              <td> {{($client->email)?$client->email:""}}</td>
              <td> {{($client->phone)?$client->phone:""}}</td>
              <td style="text-align: center">{{$client->plans()->first()->service_type()->first()->name}}</td> 
              <td style="text-align: center">{{$client->plans()->first()->domain_name}}</td> 
              <td style="text-align: center">{{$client->plans()->first()->duration."yr"}}</td> 
              <td style="text-align: center">{{$client->plans()->first()->price}}</td> 
              <td style="text-align: center"> {{ \Carbon\Carbon::parse($client->plans()->first()->start_date)->format('d-m-Y') }}</td> 
              <td style="text-align: center"> {{ \Carbon\Carbon::parse($client->plans()->first()->expire_date)->format('d-m-Y') }}</td> 
             </tr>
        @endforeach
    </tbody>
</table>







