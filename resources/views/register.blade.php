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
                                    <input type="text" name="txtName" id="txtName" placeholder="Enter device's name" class="form-control" value="{{ old('txtName') }}" tabindex="3">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Email</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="text" name="txtEmail" id="txtEmail" placeholder="Device's model" class="form-control" value="{{ old('txtName') }}" tabindex="4">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Phone</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="text" name="txtPhone" id="txtPhone" placeholder="Device's model" class="form-control" value="{{ old('txtName') }}" tabindex="4">
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                <input type="hidden" value="" id="txtId">
                                    <label class="label-control">Password</label>
                                    <!-- <span class="desc">eg "Grand Tech Sys"</span> -->
                                    <input type="password" name="txtPassword" id="txtPassword" placeholder="Enter device's name" class="form-control" value="{{ old('txtName') }}" tabindex="3">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Confirm password</label>
                                    <!--<span class="desc">eg "#13, st 271"</span> -->
                                    <input type="password" name="txtCPassword" id="txtCPassword" placeholder="Device's model" class="form-control" value="{{ old('txtName') }}" tabindex="4">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group"> 
                                    <label class="label-control">Role</label>

                                    <select class="form-control" id="txtRole" name="txtRole">
                                        @foreach( $role as $r )
                                            <option value="{{ $r->role_id}}">{{ $r->role_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" id="btnSave" tabindex="100" value="Save">
                                    <button type="button" class="btn btn-danger" onclick="btnCancel_click()" tabindex="100">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>