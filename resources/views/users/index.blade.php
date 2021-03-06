@extends('adminlte::page')

@section('title', 'Easy School | Users')

@section('content_header')
    <h1>
    	Users Management
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('users.create') }}"> Create New Headmaster</a>
			</div>
		</h1>
		
@stop

@section('content')
  @permission('user-crud')
	{{-- @if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif --}}
	<h4>Super Admin</h4>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th width="280px">কার্যকলাপ</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($superadmins[0]->users as $key => $user)
				<tr>
					<td></td>
					<td><a class="link bold" href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></td>
					<td>{{ $user->email }}</td>
					<td>
						@if(!empty($user->roles))
							@foreach($user->roles as $v)
								<label class="label label-success">{{ $v->display_name }}</label>
							@endforeach
						@endif
					</td>
					<td>
						{{-- edit modal--}}
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editsuperadminModal{{ $user->id }}" data-backdrop="static">
							<i class="fa fa-pencil"></i>
						</button>
									<!-- Trigger the modal with a button -->
								  <!-- Modal -->
								  <div class="modal fade" id="editsuperadminModal{{ $user->id }}" role="dialog" style="overflow:hidden;">
								    <div class="modal-dialog modal-lg">
								      <div class="modal-content">
								        <div class="modal-header modal-header-primary">
								          <button type="button" class="close" data-dismiss="modal">&times;</button>
								          <h4 class="modal-title">{{ $user->name }} সম্পাদনাঃ</b></h4>
								        </div>
								        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
								        <div class="modal-body">
								            <div class="row">
								                <div class="col-md-12">
						                        <div class="form-group">
						                            <strong>Name:</strong>
						                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
						                        </div>
						                        <div class="form-group">
						                            <strong>Email:</strong>
						                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
						                        </div>
						                        <div class="form-group">
						                            <strong>Password:</strong>
						                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
						                        </div>
						                        <div class="form-group">
						                            <strong>Confirm Password:</strong>
						                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
						                        </div>
						                        <div class="form-group">
						                            <strong>Role:</strong>
						                            @php
						                            	$userrole = $user->roles->lists('id','id')->toArray();
						                            @endphp
						                            {!! Form::select('roles[]', $roles, $userrole, array('class' => 'form-control multiple'.$user->id.'','multiple')) !!}
						                        </div>
						                        <script type="text/javascript">
						                            $(document).ready(function() {
						                                $('.multiple{{ $user->id }}').select2({
																					    dropdownParent: $("#editsuperadminModal{{ $user->id }}")
																					  });
						                            });
						                        </script>
						                        <div class="form-group">
						                            <strong>School:</strong>
						                            @php
						                            	$userschool = $user->school->lists('id','id')->toArray();
						                            @endphp
						                            {!! Form::select('school_id', $schools, $userschool, array('class' => 'form-control')) !!}
						                        </div>
								                </div>
								            </div>
								        </div>
								        <div class="modal-footer">
								          <button type="submit" class="btn  btn-success">Save</button>
								          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								        </div>
								        {!! Form::close() !!}
								      </div>
								    </div>
								  </div>
						{{-- edit modal--}}
				    {{-- delete modal--}}
				    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletesuperadminModal{{ $user->id }}" data-backdrop="static"
							@if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
				    	><i class="fa fa-trash" aria-hidden="true"></i></button>
				      	<!-- Trigger the modal with a button -->
			        	<!-- Modal -->
				        <div class="modal fade" id="deletesuperadminModal{{ $user->id }}" role="dialog">
				          <div class="modal-dialog modal-md">
				            <div class="modal-content">
				              <div class="modal-header modal-header-danger">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Delete confirmation</h4>
				              </div>
				              <div class="modal-body">
				                Delete user <b>{{ $user->name }}</b>?
				              </div>
				              <div class="modal-footer">
				                {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
				                    <button type="submit" class="btn btn-danger">Delete</button>
				                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                {!! Form::close() !!}
				              </div>
				            </div>
				          </div>
				        </div>
			      {{-- delete modal--}}
					</td>
				</tr>
			@endforeach
			</tbody>
			</table>	
			</div>

			<h4>Headmasters</h4>
			<div class="table-responsive">
				<table class="table" id="datatable-headmasters">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Roles</th>
							<th>School</th>
							<th>কার্যকলাপ</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($headmasters[0]->users as $key => $user)
						<tr>
							<td></td>
							<td><a class="link bold" href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></td>
							<td>{{ $user->email }}</td>
							<td>
								@if(!empty($user->roles))
									@foreach($user->roles as $v)
										<label class="label label-success">{{ $v->display_name }}</label>
									@endforeach
								@endif
							</td>
							<td>{{ $user->school->name }}-{{ $user->school->eiin }}</td>
							<td>
								{{-- edit modal--}}
								<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editheadmastersModal{{ $user->id }}" data-backdrop="static">
									<i class="fa fa-pencil"></i>
								</button>
											<!-- Trigger the modal with a button -->
										  <!-- Modal -->
										  <div class="modal fade" id="editheadmastersModal{{ $user->id }}" role="dialog" style="overflow:hidden;">
										    <div class="modal-dialog modal-lg">
										      <div class="modal-content">
										        <div class="modal-header modal-header-primary">
										          <button type="button" class="close" data-dismiss="modal">&times;</button>
										          <h4 class="modal-title">{{ $user->name }} সম্পাদনাঃ</b></h4>
										        </div>
										        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
										        <div class="modal-body">
										            <div class="row">
										                <div class="col-md-12">
								                        <div class="form-group">
								                            <strong>Name:</strong>
								                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Email:</strong>
								                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Password:</strong>
								                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Confirm Password:</strong>
								                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Role:</strong>
								                            @php
								                            	$userrole = $user->roles->lists('id','id')->toArray();
								                            @endphp
								                            {!! Form::select('roles[]', $roles, $userrole, array('class' => 'form-control multiple'.$user->id.'','multiple')) !!}
								                        </div>
								                        <script type="text/javascript">
								                            $(document).ready(function() {
								                                $('.multiple{{ $user->id }}').select2({
																							    dropdownParent: $("#editheadmastersModal{{ $user->id }}")
																							  });
								                            });
								                        </script>
								                        <div class="form-group">
								                            <strong>School:</strong>
								                            @php
								                            	$userschool = $user->school->id;
								                            @endphp
								                            {!! Form::select('school_id', $schools, $userschool, array('class' => 'form-control')) !!}
								                        </div>
										                </div>
										            </div>
										        </div>
										        <div class="modal-footer">
										          <button type="submit" class="btn  btn-success">Save</button>
										          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										        </div>
										        {!! Form::close() !!}
										      </div>
										    </div>
										  </div>
								{{-- edit modal--}}
						    {{-- delete modal--}}
						    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteheadmasterModal{{ $user->id }}" data-backdrop="static"
									@if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
						    	><i class="fa fa-trash" aria-hidden="true"></i></button>
						      	<!-- Trigger the modal with a button -->
					        	<!-- Modal -->
						        <div class="modal fade" id="deleteheadmasterModal{{ $user->id }}" role="dialog">
						          <div class="modal-dialog modal-md">
						            <div class="modal-content">
						              <div class="modal-header modal-header-danger">
						                <button type="button" class="close" data-dismiss="modal">&times;</button>
						                <h4 class="modal-title">Delete confirmation</h4>
						              </div>
						              <div class="modal-body">
						                Delete user <b>{{ $user->name }}</b>?
						              </div>
						              <div class="modal-footer">
						                {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
						                    <button type="submit" class="btn btn-danger">Delete</button>
						                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						                {!! Form::close() !!}
						              </div>
						            </div>
						          </div>
						        </div>
					      {{-- delete modal--}}
							</td>
						</tr>
					@endforeach
					</tbody>
					</table>	
					</div>

			<h4>Teachers</h4>
			<div class="table-responsive">
				<table class="table" id="datatable-teachers">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Roles</th>
							<th>School</th>
							<th>কার্যকলাপ</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($teachers[0]->users as $key => $user)
						<tr>
							<td></td>
							<td><a class="link bold" href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></td>
							<td>{{ $user->email }}</td>
							<td>
								@if(!empty($user->roles))
									@foreach($user->roles as $v)
										<label class="label label-success">{{ $v->display_name }}</label>
									@endforeach
								@endif
							</td>
							<td>{{ $user->school->name }}-{{ $user->school->eiin }}</td>
							<td>
								{{-- edit modal--}}
								<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editteachersModal{{ $user->id }}" data-backdrop="static">
									<i class="fa fa-pencil"></i>
								</button>
											<!-- Trigger the modal with a button -->
										  <!-- Modal -->
										  <div class="modal fade" id="editteachersModal{{ $user->id }}" role="dialog" style="overflow:hidden;">
										    <div class="modal-dialog modal-lg">
										      <div class="modal-content">
										        <div class="modal-header modal-header-primary">
										          <button type="button" class="close" data-dismiss="modal">&times;</button>
										          <h4 class="modal-title">{{ $user->name }} সম্পাদনাঃ</b></h4>
										        </div>
										        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
										        <div class="modal-body">
										            <div class="row">
										                <div class="col-md-12">
								                        <div class="form-group">
								                            <strong>Name:</strong>
								                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Email:</strong>
								                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Password:</strong>
								                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Confirm Password:</strong>
								                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
								                        </div>
								                        <div class="form-group">
								                            <strong>Role:</strong>
								                            @php
								                            	$userrole = $user->roles->lists('id','id')->toArray();
								                            @endphp
								                            {!! Form::select('roles[]', $roles, $userrole, array('class' => 'form-control multiple'.$user->id.'','multiple')) !!}
								                        </div>
								                        <script type="text/javascript">
								                            $(document).ready(function() {
								                                $('.multiple{{ $user->id }}').select2({
																							    dropdownParent: $("#editteachersModal{{ $user->id }}")
																							  });
								                            });
								                        </script>
								                        <div class="form-group">
								                            <strong>School:</strong>
								                            @php
								                            	$userschool = $user->school->id;
								                            @endphp
								                            {!! Form::select('school_id', $schools, $userschool, array('class' => 'form-control')) !!}
								                        </div>
										                </div>
										            </div>
										        </div>
										        <div class="modal-footer">
										          <button type="submit" class="btn  btn-success">Save</button>
										          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										        </div>
										        {!! Form::close() !!}
										      </div>
										    </div>
										  </div>
								{{-- edit modal--}}
						    {{-- delete modal--}}
						    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteteachersModal{{ $user->id }}" data-backdrop="static"
									@if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
						    	><i class="fa fa-trash" aria-hidden="true"></i></button>
						      	<!-- Trigger the modal with a button -->
					        	<!-- Modal -->
						        <div class="modal fade" id="deleteteachersModal{{ $user->id }}" role="dialog">
						          <div class="modal-dialog modal-md">
						            <div class="modal-content">
						              <div class="modal-header modal-header-danger">
						                <button type="button" class="close" data-dismiss="modal">&times;</button>
						                <h4 class="modal-title">Delete confirmation</h4>
						              </div>
						              <div class="modal-body">
						                Delete user <b>{{ $user->name }}</b>?
						              </div>
						              <div class="modal-footer">
						                {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
						                    <button type="submit" class="btn btn-danger">Delete</button>
						                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						                {!! Form::close() !!}
						              </div>
						            </div>
						          </div>
						        </div>
					      {{-- delete modal--}}
							</td>
						</tr>
					@endforeach
					</tbody>
					</table>	
					</div>
	@endpermission
@stop

@section('js')
		<script type="text/javascript">
        $(document).ready(function() {
            $('.multiple').select2();
        });
    </script>

    <script type="text/javascript">
    	$(function () {
    	  $('#datatable-headmasters').DataTable({
    	    'paging'      : true,
    	    'pageLength'  : 10,
    	    'lengthChange': true,
    	    'searching'   : true,
    	    'ordering'    : true,
    	    'info'        : true,
    	    'autoWidth'   : true,
    	    columnDefs: [
    	    		{ targets: [5], visible: true, searchable: false},
			        { targets: '_all', visible: true, searchable: true }
			    ],
			     'language': {
			        "lengthMenu": "প্রতি পৃষ্ঠায় _MENU_ টি রেকর্ড প্রদর্শন করুন",
			        "zeroRecords": "কোন তথ্য পাওয়া যায়নি!",
			        "info": "পৃষ্ঠা নম্বরঃ _PAGE_, মোট পৃষ্ঠাঃ _PAGES_ টি",
			        "infoEmpty": "তথ্য পাওয়া যায়নি",
			        "infoFiltered": "(মোট _MAX_ সংখ্যক রেকর্ড থেকে খুঁজে বের করা হয়েছে)",
			        "search":         "খুঁজুনঃ",
			        "paginate": {
			            "first":      "প্রথম পাতা",
			            "last":       "শেষ পাতা",
			            "next":       "পরের পাতা",
			            "previous":   "আগের পাতা"
			        },
			    }
    	  })
    	})
    	$(function () {
    	  $('#datatable-teachers').DataTable({
    	    'paging'      : true,
    	    'pageLength'  : 10,
    	    'lengthChange': true,
    	    'searching'   : true,
    	    'ordering'    : true,
    	    'info'        : true,
    	    'autoWidth'   : true,
    	    columnDefs: [
    	    		{ targets: [5], visible: true, searchable: false},
			        { targets: '_all', visible: true, searchable: true }
			    ],
			     'language': {
			        "lengthMenu": "প্রতি পৃষ্ঠায় _MENU_ টি রেকর্ড প্রদর্শন করুন",
			        "zeroRecords": "কোন তথ্য পাওয়া যায়নি!",
			        "info": "পৃষ্ঠা নম্বরঃ _PAGE_, মোট পৃষ্ঠাঃ _PAGES_ টি",
			        "infoEmpty": "তথ্য পাওয়া যায়নি",
			        "infoFiltered": "(মোট _MAX_ সংখ্যক রেকর্ড থেকে খুঁজে বের করা হয়েছে)",
			        "search":         "খুঁজুনঃ",
			        "paginate": {
			            "first":      "প্রথম পাতা",
			            "last":       "শেষ পাতা",
			            "next":       "পরের পাতা",
			            "previous":   "আগের পাতা"
			        },
			    }
    	  })
    	})

    </script>
@stop