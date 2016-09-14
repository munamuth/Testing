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
                            <th>Model</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_customer">
                        
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
                    <h2 class="title pull-left" id="label-add">Add New Device</h2>
                    <div class="actions panel_actions pull-right">
                        <i class="fa fa-chevron-down" data-toggle="collapse" data-target="#form-add"></i>
                    </div>
                </header>
                <div class="content-body collapse in" id="form-add">
                    <div class="row">
                        <form method="post" action="/customers/store" id="form">

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                <input type="hidden" value="" id="txtId">
                                    <label class="label-control">Device's name</label>
                                    <!-- <span class="desc">eg "Grand Tech Sys"</span> -->
                                    <input type="text" name="txtName" id="txtName" placeholder="Enter device's name" class="form-control" value="{{ old('txtName') }}" tabindex="3">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group"> 
                                    <label class="label-control">Model</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="text" name="txtModel" id="txtModel" placeholder="Device's model" class="form-control" value="{{ old('txtName') }}" tabindex="4">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input type="button" class="btn btn-success" id="btnSave" onclick="btnSave_click()" tabindex="100" value="Save">
                                    <button type="button" class="btn btn-danger" onclick="btnCancel_click()" tabindex="100">Cancel</button>
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
        var page = 1;
        var limit = 3;
        var key = '';
        page_load();
        function page_load(){
            $.ajax({
                url: '/devices/page/' + page + '/item/' + limit +'/' +key,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS ==  true ){
                        
                        listDevice( data );
                        bootpage( data );

                    } else {
                        console.log('Data not found');
                    }
                } ,
                error: function( data ) {
                    console.log("Can not get data from url requested!");
                }
            });
        }
        function listDevice( page ){     
            $.ajax({
                url: '/devices/page/' + page + '/item/' + limit +'/' +key,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS ==  true ){
                        $('tbody').html( tbody( data ) );
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
                            +'<td>'+data.DATA[i].dev_id+'</td>' 
                            +'<td>'+data.DATA[i].dev_name+'</td>' 
                            +'<td>'+data.DATA[i].dev_model+'</td>' 
                            +'<td>'
                                +'<button class="btn btn-info" data-toggle="modal" data-target="#form-edit" onclick="btnEdit_click('+data.DATA[i].dev_id+')">Edit</button> '
                                +'<button class="btn btn-info" onclick="btnDelete_click('+data.DATA[i].dev_id+')">Delete</button>'
                            +'</td>'
                        +'</tr>';
            }
            return str;
        }
        function bootpage( data ){
            $('#page').bootpag({
                total: data.PAGINATION.TOTALPAGE,
                page: 1,
                maxVisible: 3,
                leaps: true,
                firstLastUse: true,
                first: '←',
                last: '→',
                wrapClass: 'pagination',
                activeClass: 'active',
                disabledClass: 'disabled',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first'
            }).on("page", function(event, num){
                listDevice( num );
            }); 
        }

        function btnSave_click(){
            var name = $('#txtName').val();
            var model = $('#txtModel').val();
            $.ajax({
                url: '/devices?dev_name='+name+'&dev_model='+model,
                type: 'post',
                success: function( data ) {
                    if( data.STATUS == true ){
                        swal('Success', 'Data was inserted!', 'success');
                        page_load();
                    } else {
                        swal('Success', 'Data was inserted!', 'success');
                        page_load();
                    }
                }, 
                error: function( data ) {
                    console.log('Invalid url requested');
                }
            });
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
                url: '/devices/' + id,
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

        function btnEdit_click( id ) {
            $.ajax({
                url: '/devices/'+id ,
                type: 'get',
                success: function( data ){
                    if( data.STATUS == true ){
                        $('#txtName').val( data.DATA.dev_name );
                        $('#txtModel').val( data.DATA.dev_model );
                        $('#btnSave').val( 'Update' );
                        $('#btnSave').attr('onclick', 'btnUpdate_click()');
                        $('#txtId').val( data.DATA.dev_id )
                        $('#label-add').text('Update device');
                    } else {
                        console.log("Data not found!");
                    }
                }, 
                error: function( data ) {
                    console.log("Can not get data from url requested!");
                }
            })
        }

        function btnUpdate_click(){
            var id = $('#txtId').val();
            var name = $('#txtName').val();
            var model = $('#txtModel').val();
            $.ajax({
                url: '/devices/'+id+'?dev_name='+name+'&dev_model='+model,
                type: 'put',
                success: function( data ) {
                    if( data.STATUS == true ){
                        swal('Success', 'Your data was updated!', 'success');
                        page_load();
                        reset();
                    } else {
                        swal('Error', 'Your data was not updated!', 'error');
                    }
                },
                error: function( data ) {
                    console.log("Can not get data from url requested!");
                }
            })
        }
        function btnCancel_click(){
            reset();
        }
        function reset(){
            $('#txtName').val('');
            $('#txtModel').val('');
            $('#btnSave').val('Save');
            $('#btnSave').attr('onclick', 'btnSave_click()');
            $('#txtId').val( '' )
            $('#label-add').text('Add New device');
        }
        function btnSearch_click() {
            key = $('#txtSearch').val();
            $.ajax({
                url: '/devices/page/'+page+'/item/'+limit+'/'+key,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS == true ) {
                        page_load()
                    } else {
                        alert('eeee')
                    }
                },
                error: function( data ) {
                    alert('uuuuu')
                }
            })
        }
    </script>
    @stop