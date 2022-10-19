<div style="margin-top: -4%">
    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">Status</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{$data['icount']['status']??''}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Date Callback</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{$data['icount']['created_at']??''}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
            </div>
        </form>
</div>