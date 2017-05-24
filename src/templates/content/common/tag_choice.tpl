<div class="col-xs-12 col-sm-4 col-md-3 medium-bottom-margin"  data-tag-id="{$tag['id']}" >
    <div class="list-group-item">
        <span>{$tag['name']}</span>
        <button id="remove-pending-tag-button" class="pull-right btn btn-xs btn-danger small-left-margin" onclick="removePendingTag({$tag['id']})"><span
                    class="glyphicon glyphicon-remove"></span>
        </button>
        <button id = "add-pending-tag-button" class="pull-right btn btn-xs btn-success small-left-margin" onclick="addPendingTag({$tag['id']})"><span class="glyphicon glyphicon-ok"></span>
        </button>
    </div>
</div>
