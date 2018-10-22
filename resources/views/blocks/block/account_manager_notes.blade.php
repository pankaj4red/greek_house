<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Campus Manager Notes</span></h3>
    </div>
    <div class="panel-body">
        {{ Form::model($campaign, ['url' => $blockUrl]) }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::textarea('account_manager_notes', null, ['class' => 'form-control', 'rows' => 13]) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" name="account_manager_notes_button" value="save" class="btn btn-info pull-right">Save</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

