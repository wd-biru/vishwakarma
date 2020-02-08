<div class="table-responsive">
    <table class="table table-bordered searchTable" >
        <thead>
            <tr >
                <th><strong>Document Name</strong></th> <td>{{$documentshare->doc_name}}</td>
            </tr>
             <tr >
                <th><strong>For Approval </strong></th> 
                @if($documentshare->shareEmployee_id==0)
                <td><strong>{{$portalData->name}} {{$portalData->surname}}</strong></td>                
                @else
                <td>{{$documentshare->getName->first_name}}{{$documentshare->getName->last_name}}</td>   
                @endif 
            </tr>
            <tr>       
                <th><strong>Uploded By</strong></th> <td>{{$documentshare->upload_by}}</td>
            </tr>
            <tr>
                <th><strong>Description</strong></th>  <td>{{$documentshare->doc_description}}</td>
            </tr>
            <tr>
                <th><strong>Status</strong></th>
                @if($documentshare->status == "APPROVED")
                <td style="color: #168e4c;">{{$documentshare->status}}</td>
                @elseif($documentshare->status == "PENDING")
                <td style="color: #e8a817;">{{$documentshare->status}}</td>
                @else
                <td style="color: #f13737;">{{$documentshare->status}}</td>
                @endif               
            </tr>
            <tr>
                <th><strong>Remark</strong></th><td>{{$documentshare->remark_upload}}</td>
            </tr>
            <tr>
                <th><strong>Action Remark</strong></th><td>{{$documentshare->remark_approve}}</td>
            </tr>
            <tr>
                <th><strong>Upload Date</strong></th><td>{{Carbon\Carbon::parse($documentshare->upload_date)->format('d/m/Y')}} </td>
            </tr>
        </thead>
    </table>
</div>