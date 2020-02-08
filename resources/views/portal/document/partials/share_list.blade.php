<div class="table-responsive">
    <table class="table table-bordered searchTable" >
        <thead>
            <tr class="btn-primary">
                <th>Sr.No.</th>        
                <th>Name</th>
                <!-- <th>Mobile No.</th> -->
            </tr>
        </thead>
        <tbody ><?php $i=1?>
            @foreach($documentsharewith as $value)            
            <tr>                  
                <td>{{$i++}}</td>
                <td>{{$value->getName->first_name}}{{$value->getName->last_name}}</td>
                <!-- <td>{{$value->getName->phone}}</td>     -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
          
 