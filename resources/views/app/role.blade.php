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

    <div class="row" id="row" style="height: 50%">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-default" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list_role">
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script type="text/javascript">
        var page = 1;
        var limit = 3;
        var key = '';
        page_load();
        function page_load(){
            $.ajax({
                url: '/role/all',
                type: 'get',
                success: function( data ) {
                    if( data.STATUS ==  true ){
                        
                        list_role( data );

                    } else {
                        console.log('Data not found');
                    }
                } ,
                error: function( data ) {
                    console.log("Can not get data from url requested!");
                }
            });
        }
        function list_role( page ){     
            $.ajax({
                url: '/role/all',
                type: 'get',
                success: function( data ) {
                    if( data.STATUS ==  true ){
                        $('#list_role').html( tbody( data ) );
                    } else {
                        console.log('Data not found');
                    }
                } ,
                error: function( data ) {
                    console.log("Can not get data from url requested!");
                }
            });
        }
        /* Add data to table */
        function tbody( data ){
            var str ='';
            for( var i = 0; i < data.DATA.length; i++){
                str += '<tr>'
                            +'<td>'+data.DATA[i].role_id+'</td>' 
                            +'<td>'+data.DATA[i].role_name+'</td>' 
                            +'<td>'
                                +'<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#form-edit" onclick="btnEdit_click('+data.DATA[i].id+')">Edit</button> '
                            +'</td>'
                        +'</tr>';
            }
            return str;
        }
        function btnDelete_click( id ) {
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
                url: '/user/' + id,
                type: 'delete',
                success: function( data ) {
                    if( data.STATUS == true ){
                        swal('Success', 'Data was deleted!', 'success');
                        page_load();
                    } else {
                        swal('Error', 'Data was not deleted!', 'error');
                    }
                }
                });
            });
        }
    </script>
    @stop