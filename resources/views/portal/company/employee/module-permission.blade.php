@extends('layout.app')
@section('title')
<div class="page-title">
	<div>
		<h1><i class="fa fa-key"></i>&nbsp;Employee Module Permission</h1>
	</div>
	<div>
		<ul class="breadcrumb">
			<li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
			<li><a href="{{route('companyemployee')}}">Employee List</a></li>
			<li><a href="">{{ucfirst($employee_data->first_name)." ". ucfirst($employee_data->last_name)}}</a></li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<input type="hidden" name="employee_id" id="oprate_id" value="{{$employee_data->id}}">
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-key"></i> MENU PERMISSIONS </h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						@foreach($menus as $menu)  
							@if($menu->parent_id == 0)
								<li class="treeview ">
									<input type="checkbox" class="menu_opration main_menu_{{$menu->id}}" name="menus_id[]"
									data-id='{{$menu->id}}' value="{{$menu->id}}" @foreach($employee_menu as $per)
									@if($per->menu_id == $menu->id) checked @endif @endforeach ><span>{{$menu->menu_name}}</span>
									<ul class="treeview-menu">
										@foreach($menus as $child)
											@if($menu->id == $child->parent_id)
												<li class="treeview ">
													<input type="checkbox" class="menu_opration main_menu_{{$child->id}}" data-id='{{$child->id}}' name="menus_id[]" value="{{$child->id}}" @foreach($employee_menu as $per)
													@if($per->menu_id == $child->id) checked @endif @endforeach ><span>{{$child->menu_name}}</span>
												</li>
												<ul class="treeview-menu">
													@foreach($menus as $sub_child)
														@if($child->id == $sub_child->parent_id )
															<li><input type="checkbox" name="menus_id[]" data-id='{{$sub_child->id}}' class="menu_opration main_menu_{{$sub_child->id}}" value="{{$sub_child->id}}" @foreach($employee_menu as $per)
																@if($per->menu_id == $sub_child->id) checked @endif @endforeach ><span>{{$sub_child->menu_name}}</span>
															</li>
														@endif
													@endforeach
												</ul>
											@endif
										@endforeach
										<hr>
									</ul>
								</li>
							@endif  
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-7">
 
</div>

@endsection

@section('script')
<script type="text/javascript">
	jQuery(document).on('click','#id-check_all_client',function(event){
		 if(this.checked){
            jQuery('li .check_all').each(function(){
                this.checked = true;
                buttonevent(true);

            });

        }else{
            jQuery('.check_all').each(function(){
                this.checked = false;
                jQuery('.btn_email').attr('disabled',true);
            });
        }

	});


	jQuery(document).on('click','.check_all',function(event){
		var employee_id = jQuery('#oprate_id').val();
		jQuery.ajax({
			url:"{{route('employee.client.permission.storeAll')}}",
			type:"get",
			data: {employee_id:employee_id},
			dataType:'json',
			success: function(response){
				console.log(response);
				if(response.success){
					debugger;
					jQuery('.check_all').prop("checked",true);
					if(response.message){
						ViewHelpers.notify("success",response.message);
					}
					else{
						ViewHelpers.notify("error",response.message);
					}
				}
				else{
					jQuery('.check_all').prop("checked",false);
					if(response.message){
						ViewHelpers.notify("error",response.message);
					}
				}

			},
			error: function(err){

			}
		});
		event.preventDefault();
		return false;

	});



	jQuery(document).on('click','.menu_opration',function(event){
		var employee_id = jQuery('#oprate_id').val();
		var menu_id = jQuery(this).data('id');
		jQuery.ajax({
			url:"{{route('employee.permission.store')}}",
			type:"get",
			data: {employee_id:employee_id,menu_id:menu_id},
			dataType:'json',
			success: function(response){
				console.log(response);
				if(response.success){
					jQuery('.main_menu_'+menu_id).prop("checked",true);
					if(response.message){
						ViewHelpers.notify("success",response.message);
					}
					else{
						ViewHelpers.notify("error",response.message);
					}
				}
				else{
					jQuery('.main_menu_'+menu_id).prop("checked",false);
					if(response.message){
						ViewHelpers.notify("error",response.message);
					}
				}
				$('#cost_att').val('');
			},
			error: function(err){

			}
		});
		event.preventDefault();
		return false;

	});


	jQuery(document).on('click','.client_opration',function(event){
		var client_id = jQuery(this).data('client_id');
		var employee_id = jQuery('#oprate_id').val();
		jQuery.ajax({
			url:"{{route('employee.client.permission.store')}}",
			type:"get",
			data: {client_id:client_id,employee_id:employee_id},
			dataType:'json',
			success: function(response){
				console.log(response);
				if(response.success){
					debugger;
					jQuery('.client_id_'+client_id).prop("checked",true);
					if(response.message){
						ViewHelpers.notify("success",response.message);
					}
					else{
						ViewHelpers.notify("error",response.message);
					}
				}
				else{
					jQuery('.client_id_'+client_id).prop("checked",false);
					if(response.message){
						ViewHelpers.notify("error",response.message);
					}
				}
				$('#cost_att').val('');
			},
			error: function(err){

			}
		});
		event.preventDefault();
		return false;

	});

</script>
@endsection
