<div class="  table-responsive ">
    <table class="table table-bordered main-table search-table " >
        <thead>
            <tr class="btn-primary">
                <th>Sr No.</th>
                <th>Account Holder Name</th>
                <th>Account Number </th>
                <th>Bank Name</th>
                <th>Branch Name </th>
                <th>IFSC CODE</th>
                <th>IBAN No.</th>
                
                
            </tr>
        </thead>
        <tbody>
            
            <?php $i=1?>
           @foreach($data as $value)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$value->account_holder_name}}</td>
                <td>{{$value->account_number}}</td>
                <td>{{$value->bank_name}}</td>
                <td>{{$value->branch_name}}</td>
                <td>{{$value->ifsc_code}}</td>
                <td>{{$value->iban_number}}</td>  
            </tr>
            @endforeach     
                       
        </tbody>
    </table>
</div>