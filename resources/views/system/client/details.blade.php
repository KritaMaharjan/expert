<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Client Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Preferred Name: </label> {{$client->preferred_name}}
                    </div>
                    <div class="col-md-6">
                        <label>Current Phone Number: </label> {{$client->phone}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                            <label>Given Name: </label> {{$client->given_name}}
                    </div>
                    <div class="col-md-6">
                        <label>Surname: </label> {{$client->surname}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>