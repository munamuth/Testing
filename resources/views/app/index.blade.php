@extends('master')

@section('contain')

    <div class="row" id="row">
        <div class="col-xs-12">
            <!-- form search -->
            <div class="">
                <form method="post" action="/customer/search">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtCusSearch" placeholder="Search customer's name" tabindex="1" onblur="btnSearch_click()" onchange="btnSearch_click()" onsubmit="btnSearch_click()">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" id="btnSearch" onclick="btnSearch_click()"><span class="glyphicon glyphicon-search" tabindex="2"></span></button>
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
            <div id="table">
                <div class="table-responsive">
                    <table class="table table-default">
                        <thead>
                            <tr>
                                <th width="15%">Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Devices</th>
                                <th width="20%">Action</th>
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
    </div>


    <div class="row" id="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <section class="box ">
                <header class="panel_header">
                    <h2 class="title pull-left" id="label-add">New customer</h2>
                    <div class="actions panel_actions pull-right">
                        <i class="fa fa-chevron-down" data-toggle="collapse" data-target="#form-add"></i>
                    </div>
                </header>
                <div class="content-body collapse in" id="form-add">
                    <div class="row">
                        <form method="post" action="/customers/store" id="formAdd">
                            <div class="col-xs-12 col-sm-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="label-control">Name</label>
                                            <!-- <span class="desc">eg "Grand Tech Sys"</span> -->
                                            <input type="hidden" id="txtId">
                                            <input type="text" name="txtName" id="txtName" placeholder="Enter customer's name (*)" class="form-control" value="{{ old('txtName') }}" tabindex="3">
                                            <p class="text-danger" id="txtNameErr">{{ $errors->first('txtName') }}</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12">
                                        <div class="form-group"> 
                                            <label class="label-control">Phone number</label>
                                            <!--<span class="desc">eg "069394383"</span> -->
                                            <input type="text" name="txtPhone" id="txtPhone" placeholder="Enter phone number (*)" class="form-control" value="{{ old('txtName') }}" tabindex="5">
                                            <p class="text-danger" id="txtPhoneErr">{{ $errors->first('txtPhone') }}</p>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="form-group"> 
                                            <label class="label-control">Email</label>
                                            <!--<span class="desc">eg "muth123ktr@gmail.com"</span> -->
                                            <input type="email" name="txtEmail" id="txtEmail" placeholder="Enter email (optional)" class="form-control" value="{{ old('txtName') }}" tabindex="6">
                                            <p class="text-danger">{{ $errors->first('txtEmail') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">

                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <textarea rows="9" id="txtAddr" name="txtAddr" class="form-control" placeholder="Enter Address"></textarea>
                                        <p id="txtAddrErr" class="text-danger"></p>
                                    </div>

                            </div>                                

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info hidden" id="btnAddDevice">Add Device</button>
                                        <button type="button" class="btn btn-success" id="btnSave" onclick="validateCustomerForm()" tabindex="100">Save</button>
                                        <button type="button" class="btn btn-danger" id="btnCancel" onclick="myClear()" tabindex="99">Cancel</button>
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
        var limit = 2;
        var key = '';

        page_load();
        function page_load(){
            $.ajax({
                url: '/customers/page/'+ page + '/item/'+ limit + '/' + key,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS == true){

                        if( data.DATA.length == 0){
                            
                            $('#page').html( '' );
                            $('#empty').html( 'No records' );
                            $('#table').hide();
                            
                        } else {

                            listCustomer( data ); 
                            bootpage( data );
                            $('#empty').html( '' );
                            $('#table').show();
                        }
                            
                    } else {
                        $('#tbl_customer').html('No customer records');
                    }
                },
                error: function(){
                    console.log('Can not get data from requested url')
                }
            });
        }
        /* list customer */
        function listCustomer( page ){
            $.ajax({
                url: '/customers/page/'+ page + '/item/'+ limit + '/' + key,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS == true){
                        $('#tbl_customer').html( tbody(data) );
                    } else {
                        $('#tbl_customer').html('No customer records');
                    }
                },
                error: function(){
                    console.log('Can not get data from requested url')
                }
            });
        }
        /* Add data to table */
        function tbody( data ){
            var str ='';
            for( var i = 0; i < data.DATA.length; i++){
                str += '<tr>'
                            +'<td>'+data.DATA[i].cus_name+'</td>'
                            +'<td>'+data.DATA[i].cus_addr+'</td>'
                            +'<td>'+data.DATA[i].cus_phone+'</td>'
                            +'<td>'+data.DATA[i].cus_email+'</td>'
                            +'<td> <button class="btn btn-info"  data-toggle="modal" data-target="#view_device" data-backdrop="false" onclick="btnViewDevice_click('+data.DATA[i].cus_id+')">View Device</button></td>'
                            +'<td>' 
                                +'<button class="btn btn-info"onclick="btnEdit_click('+data.DATA[i].cus_id+')">Edit</button> '
                                +'<button class="btn btn-info" onclick="btnDelete_click('+data.DATA[i].cus_id+')">Delete</button>'
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
                listCustomer( num );
            }); 
        }
        function btnSearch_click(){
            key = $('#txtCusSearch').val();
            page_load();
        }
        /* btnSave click */        
        function btnSave_click() {
                    var name = $('#txtName').val();
                    var addr = $('#txtAddr').val();
                    var phone = $('#txtPhone').val();
                    var email = $('#txtEmail').val();
                    $.ajax({
                        url: '/customers?cus_name='+name+'&cus_addr='+addr+'&cus_phone='+phone+'&cus_email='+email,
                        type: 'post',
                        success: function (data){     
                            swal('Success', 'Data was inserted', 'success');
                            myClear();
                            page_load();
                        },
                        error: function( data ){
                            swal('Data not inserted')
                        }
                    })
            }

        /* btnDelete click*/
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
                    url: '/customers/' + id,
                    type: 'delete',
                    success: function( data ){
                        page_load();
                        swal("Deleted!","Your imaginary file has been deleted.","success");

                    },
                    error: function( data ) {
                        swal("Deleted!","Your imaginary file has been deleted.","error");
                    }
                });                  
            });            
        }
        var i=0;
        

        /*function btn Edit click*/
        function btnEdit_click( id ){
            $.ajax({
                url: '/customers/' + id,
                type: 'get',
                success: function( data ) {
                    if( data.STATUS == true ){

                        $('#txtId').val( data.DATA.cus_id );
                        $('#txtName').val( data.DATA.cus_name );
                        $('#txtAddr').val( data.DATA.cus_addr );
                        $('#txtPhone').val( data.DATA.cus_phone );
                        $('#txtEmail').val( data.DATA.cus_email );
                        $('#btnSave').text('Save Change');
                        $('#btnSave').attr('onclick', 'btnUpdate_click()');

                    } else {
                        console.log( data.MESSAGE )
                    }
                },
                error: function( data ) {
                    alert('Eroor')
                }
            });
        }
        /* function button modal save click*/
        function btnUpdate_click(){
            var id = $('#txtId').val();
            var name = $('#txtName').val();
            var addr = $('#txtAddr').val();
            var phone = $('#txtPhone').val();
            var email = $('#txtEmail').val();
            $.ajax({
                url: '/customers/'+id+'?cus_name='+name+'&cus_addr='+addr+'&cus_phone='+phone+'&cus_email='+email,
                type: 'put',
                success: function( data ) {
                    if ( data.STATUS ==  true ){                        
                        page_load();
                        swal('Success', 'Data updated!', 'success');
                        myClear();
                    } else {
                        swal('Error', 'Data not updated!', 'error');
                    }
                },
                error: function ( data ) {
                    console.log('error');
                }

             });

        }

        function myClear(){
            $('#txtCId').val( '' );
            $('#txtName').val( '' );
            $('#txtAddr').val( '' );
            $('#txtPhone').val( '' );
            $('#txtEmail').val( '' );
            $('#btnSave').text('Save');
            $('#btnSave').attr('onclick', 'btnSave_click()');
        }
        function validateCustomerForm(){
            var name = $('#txtName').val();
            var addr = $('#txtAddr').val();
            var phone = $('#txtPhone').val();
            if( name.length < 2 ){

                $('#txtName').css({'border-color':'red', 'color':'red'});
                $('#txtNameErr').text("Please enter customer's name.");

            } else if(addr == null || addr == '' || addr.match(/[#]/) ) {

                $('#txtAddrErr').text('Plase enter address but not acept # symbol');
                $('#txtNameErr').text("");
                $('#txtName').css({'border-color':'silver', 'color':'black'});
                $('#txtAddr').css({'border-color':'red', 'color':'red'});

            } else if( isNaN(phone) || phone.length < 9 ) {

                $('#txtPhoneErr').text('Invalid phone number');
                $('#txtName').css({'border-color':'silver', 'color':'black'});
                $('#txtAddr').css({'border-color':'silver', 'color':'black'});
                $('#txtPhone').css({'border-color':'red', 'color':'red'});

            } else {                

                $('#txtAddrErr').text('');
                $('#txtName').css({'border-color':'silver', 'color':'black'});
                $('#txtAddr').css({'border-color':'silver', 'color':'black'});
                $('#txtPhone').css({'border-color':'silver', 'color':'black'});
                btnSave_click();

            }
        }
        function btnViewDevice_click( id ) {
            
            $.ajax({
                url: '/customer/'+ id +'/devices/page/'+page+'/item/3',
                type: 'get',
                success: function( data ) {
                    if ( data.STATUS ==  true ){
                        $('#customer_name').text( data.DATA[i].cus_name+"'s Devices" );
                        $('#txtCusId').val(data.DATA.cus_id);
                        $('#table-modal').slideDown();
                        listCusDev( id );
                        devPage( data );
                    } else {
                        $('#table-modal').hide();
                    }
                },
                error: function ( data ) {
                    console.log('invalid url');
                }
            });
            $.ajax({
                url: '/customers/' + id,
                type: 'get',
                success: function( data ) {

                    if( data.STATUS == true ){

                        $('#customer_name').text( data.DATA.cus_name+"'s Devices" );
                        $('#txtCusId').val(data.DATA.cus_id);

                    } else {
                        console.log( data.MESSAGE )
                    }
                },
                error: function( data ) {
                    alert('Eroor')
                }
            });
        }
        /* list customer divice */

        function listCusDev( id ){
            
            $.ajax({
                url: '/customer/'+ id +'/devices/page/'+page+'/item/3',
                type: 'get',
                success: function( data ) {
                    if ( data.STATUS ==  true ){
                        $('#tbl_Device').html( tbodyDev( data ) );
                    } else {
                        console.log('Data not found!');
                    }
                },
                error: function ( data ) {
                    console.log('invalid url');
                }

             });
        }
        function tbodyDev( data ){

            var str ='';
            var i;
            for( i= 0; i < data.DATA.length; i++){
                str += '<tr>'
                            +'<td>'+ data.DATA[i].dev_name+'</td>'
                            +'<td>'+ data.DATA[i].local_ip+'</td>'
                            +'<td>'+ data.DATA[i].public_ip+'</td>'
                            +'<td>'+ data.DATA[i].port+'</td>'
                            +'<td>'+ data.DATA[i].username+'</td>'
                            +'<td>'+ data.DATA[i].password+'</td>'
                            +'<td>'
                                +'<button type="button" class="btn btn-warning" id="btnDevEdit" onclick="btnDevEdit_click('+data.DATA[i].cus_dev_id+')">Edit</button> '
                                +'<button type="button" class="btn btn-danger" id="btnDevDelete" onclick="btnDevDelete_click('+data.DATA[i].cus_dev_id+')">Delete</button> '
                            +'</td>'
                        +'</tr>'
            }
            return str;
        }
        /* function pagination for customer devices */
        function devPage( data ){
            $('#devPage').bootpag({
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
                listCusDev( num );
            });
        }
         /* function button modal save click*/
        function btnModalSave_click(){
            var cus_id = $('#txtCusId').val();
            var dev_id = $('#txtDeviceName').val();
            var local_ip = $('#txtLocalIp').val();
            var public_ip = $('#txtPublicIp').val();
            var port = $('#txtPort').val();
            var username = $('#txtUsername').val();
            var password = $('#txtPassword').val();
            $.ajax({
                url: '/customer/devices?cus_id_for='+cus_id+'&dev_id_for='+dev_id+'&local_ip='+local_ip+'&public_ip='+public_ip+'&port='+port+'&username='+username+'&password='+password,
                type: 'post',
                success: function( data ) {
                    if ( data.STATUS ==  true ){  
                        btnViewDevice_click(cus_id);     
                        swal('Success', 'Data updated!', 'success');
                        btnDevCancel_click();
                    } else {
                       btnViewDevice_click(cus_id);     
                        swal('Success', 'Data updated!', 'success');
                        btnDevCancel_click();                   
                    }
                },
                error: function ( data ) {
                    console.log('error');
                }

             });

        }
        /* button delete on modla*/
        function btnDevDelete_click( id ) {
            var cus_id = $('#txtCusId').val();
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
                    url: '/customer/devices/'+ id,
                    type: 'delete',
                    success: function( data ) {
                        if ( data.STATUS ==  true ){   
                            btnViewDevice_click( cus_id );   
                            swal('Success', 'Data deleted!', 'success');
                        } else {
                            swal('Error', 'Data not delete!', 'error');
                        }
                    },
                    error: function ( data ) {
                        console.log('error');
                    }

                 });                  
            });
            
        }
        /* button edit devic click */
        function btnDevEdit_click( id ) {
            var cus_id = $('#txtCusId').val();
            $.ajax({
                url: '/customer/devices/'+ id,
                type: 'get',
                success: function( data ) {
                    if ( data.STATUS ==  true ){  
                        $('#txtDevId').val( data.DATA.cus_dev_id);
                        $('#txtDeviceName').val( data.DATA.dev_id_for);
                        $('#txtLocalIp').val( data.DATA.local_ip );
                        $('#txtPublicIp').val( data.DATA.public_ip );
                        $('#txtPort').val( data.DATA.port );
                        $('#txtUsername').val( data.DATA.username );
                        $('#txtPassword').val( data.DATA.password );

                        $('#btnDevSave').text('Update');
                        $('#btnDevSave').attr('onclick', 'btnDevUpdate_click()');

                    } else {
                        swal('Error', 'Data not delete!', 'error');
                    }
                },
                error: function ( data ) {
                    console.log('error');
                }

             });

        }
        /* Handle button Update click on modal */
        function btnDevUpdate_click(){
            var id = $('#txtDevId').val();
            var dev = $('#txtDeviceName').val();
            var local_ip = $('#txtLocalIp').val();
            var public_ip = $('#txtPublicIp').val();
            var port = $('#txtPort').val();
            var username = $('#txtUsername').val();
            var password = $('#txtPassword').val();

            var cus_id = $('#txtCusId').val();
            $.ajax({
                url: '/customers/devices/'+ id +'?dev_id_for='+ dev + '&local_ip='+ local_ip + '&public_ip=' + public_ip + '&port=' + port + '&username='+ username +'&password='+ password,
                type: 'put',
                success: function( data ) {
                    if ( data.STATUS ==  true ){                        
                        btnViewDevice_click( cus_id );
                        swal('Success', 'Data updated!', 'success');
                        btnDevCancel_click();
                    } else {
                        swal('Error', 'Data not updated!', 'error');
                    }
                },
                error: function ( data ) {
                    console.log('error');
                }

             });
        }
        /* btn Dev cancel click */
        function btnDevCancel_click(){
            $('#txtDeviceName').val(1);
            $('#txtLocalIp').val('');
            $('#txtPublicIp').val('');
            $('#txtPort').val('');
            $('#txtUsername').val('');
            $('#txtPassword').val('');
            $('#btnDevSave').text('Save');
            $('#btnDevSave').attr('onclick', 'btnModalSave_click()');
        }

    </script>
    <!-- /* modal edit */ -->
    <div id="view_device" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="customer_name"></h4>
          <div class="modal-body">
            <div class="row" id="row">
                    <div class="text-center" id="empty"></div>
                    <div id="table-modal">
                        <div class="table-responsive">
                            <table class="table table-default">
                                <thead>
                                    <tr>
                                        <th>Device's Name</th>
                                        <th width="">Local IP</th>
                                        <th width="">Public IP</th>
                                        <th width="">Port</th>
                                        <th width="">Username</th>
                                        <th width="">Password</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_Device">
                                    
                                </tbody>
                            </table>
                        </div>                        
                    <div id="devPage" class="text-center"></div>
                    </div>
            </div>
            <form class="horizontal-form">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Device's name</label>
                            <input type="hidden" id="txtDevId">
                            <input type="hidden" id="txtCusId">
                            <select class="form-control" id="txtDeviceName" tabindex="1">
                                @foreach( $device as $d )
                                     <option value="{{ $d->dev_id }}">{{ $d->dev_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Local IP address</label>
                            <input type="text" class="form-control" id="txtLocalIp" placeholder="192.168.100.100" maxlength="15">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Public IP address</label>
                            <input type="text" class="form-control" id="txtPublicIp" placeholder="203.189.100.100" maxlength="15">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Port Number</label>
                            <input type="text" class="form-control" id="txtPort" placeholder="80">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Username</label>
                            <input type="text" class="form-control" id="txtUsername" placeholder="Enter username">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label class="label-control">Password</label>
                            <input type="password" class="form-control" id="txtPassword" placeholder="Password">
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="row">

                            <button type="button" class="btn btn-success" onclick="btnModalSave_click()" id="btnDevSave">Save</button>
                            <button type="button" class="btn btn-warning" id="btnDevCancel" onclick="btnDevCancel_click()">Cancel</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnDevClose">Close</button>

                        </div>
                    </div>

                </div>

            </form>
          </div>
        </div>

      </div>
    </div>
    <style>
        .modal-lg{
            width: 90%;
        }
    </style>
@stop