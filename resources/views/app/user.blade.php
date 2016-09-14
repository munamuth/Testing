@extends('master')

@section('contain')
    <div class="row" id="row">
        <div class="col-xs-12">
            <!-- form search -->
            <div class="">
                <form>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search device's name" tabindex="1" name="txtSearch" id="txtSearch" onfocus="btnSearch_click()" onSeach="">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="btnSearch_click()"><span class="glyphicon glyphicon-search" tabindex="2"></span></button>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
            <!-- end of form search -->
        </div>
    </div>

    <div class="row" id="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-default" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list_user">
                        @foreach( $users as $u )
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone }}</td>
                                @if( $u->role_id_for == 1 )
                                    <td>Admin</td>
                                @else
                                    <td>User</td>
                                @endif
                                @if( $u->id == Auth::user()->id )
                                    <td><button href="#" class="btn btn-info btn-xs" onclick="btnEdit_click({{$u->id}})">Edit</button></td>
                                @else
                                    <td>
                                        <button class="btn btn-info btn-xs" onclick="btnEdit_click({{ $u->id }})">Edit</button>
                                        <button href="#" class="btn btn-danger btn-xs" onclick="btnDelete_click({{ $u->id }})">Delete</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <p id="page"></p>
            </div>
        </div>
    </div>


    <div class="row" id="row" style="height: 50%">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <section class="box ">
                <header class="panel_header">
                    <h2 class="title pull-left" id="label-add">Add New User</h2>
                    <div class="actions panel_actions pull-right">
                        <i class="fa fa-chevron-down" data-toggle="collapse" data-target="#form-add"></i>
                    </div>
                </header>
                <div class="content-body collapse in" id="form-add">
                    <div class="row">
                        <form method="post" action="/users" id="form">

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                <input type="hidden" value="" id="txtId">
                                    <label class="label-control">Name</label>
                                    <!-- <span class="desc">eg "Grand Tech Sys"</span> -->
                                    <input type="text" name="txtName" id="txtName" placeholder="Username" class="form-control" value="{{ old('txtName') }}" tabindex="10">
                                    <p class="text-danger">{{ $errors->first('txtName') }}</p>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Email</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="Email" name="txtEmail" id="txtEmail" placeholder="Email" class="form-control" value="{{ old('txtName') }}" tabindex="11">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Phone</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="text" name="txtPhone" id="txtPhone" placeholder="Phone" class="form-control" value="{{ old('txtName') }}" tabindex="12">
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                <input type="hidden" value="" id="txtId">
                                    <label class="label-control">Password</label>
                                    <!-- <span class="desc">eg "Grand Tech Sys"</span> -->
                                    <input type="password" name="txtPassword" id="txtPassword" placeholder="Password" class="form-control" value="{{ old('txtName') }}" tabindex="13">
                                    <p class="text-danger"> {{ $errors->first('txtPassword') }}</p>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Confirm password</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="password" name="txtCPassword" id="txtCPassword" placeholder="Comfirm password" class="form-control" value="{{ old('txtName') }}" tabindex="14" onblur="validateCPassword()">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Role</label>

                                    <select class="form-control" id="txtRole" name="txtRole" tabindex="15">
                                        @foreach( $role as $r )
                                            <option value="{{ $r->role_id }}">{{ $r->role_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" id="btnSave" tabindex="16" value="Save">
                                    <button type="button" class="btn btn-danger" onclick="btnCancel_click()" tabindex="100" id="btnCancel" tabindex="17">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">

        function btnDelete_click( id ){
            swal({   
                title: "Are you sure?",   
                text: "You will not be able to recover this imaginary file!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: false 
            }, function(){   
                $.ajax({
                    url : '/users/' + id,
                    type : 'delete',
                    success: function ( data ) {
                        if( data.STATUS == true ) {
                            swal('Success', 'Your data was deleted!', 'success');
                        }
                    },
                    error: function ( data ) {
                        swal('Error', 'Your data was not deleted!', 'error');
                    }
                }) 
            });
        }
        function btnEdit_click( id ) {
            $.ajax({
                url: '/users/' + id,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS == true ){
                        $('#txtId').val(data.DATA.id);
                        $('#txtName').val(data.DATA.name);
                        $('#txtEmail').val(data.DATA.email);
                        $('#txtPhone').val(data.DATA.phone);
                        $("#txtRole").val( data.DATA.role_id_for ).change();
                        $('#form').attr('action', '/users/'+id);
                        $('#btnSave').val('Update');
                    } else {
                       $('#txtName').val('Muth'); 
                    }
                },
                error: function( data ) {
                    $('#txtName').val('Muth');
                }
            });
        }

        function btnCancel_click(){
            $('#txtId').val('');
            $('#txtName').val('');
            $('#txtEmail').val('');
            $('#txtPhone').val('');
            $("#txtRole").val(1)
            $('#btnSave').val('Save')
            $('#form').attr('action', '/users/');
        }
        function Validate(){
            var name = $('#txtName').val();
            var pass = $('#txtPassword').val();
            var cpass = $('#txtCPassword').val();
            if( name.length == 0){
                $('#txtName').css('border-color', 'red');
            } else if(pass.length == 0) {
                $('#txtName').css('border-color', 'silver');
                $('#txtPassword').css('border-color', 'red');
            }
        }
    </script>
@stop