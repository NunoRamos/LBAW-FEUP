<div class="col-xs-12 col-sm-6 medium-bottom-margin" data-tag-id="{$tag['id']}">
    <div class="list-group-item">
        <div class="pull-right">
            <button id="add-pending-tag-button" class="btn btn-xs btn-success small-left-margin"
                    onclick="addPendingTag({$tag['id']})"><span class="glyphicon glyphicon-ok"></span>
            </button>
            <button id="remove-pending-tag-button" class="btn btn-xs btn-danger small-left-margin"
                    onclick="removePendingTag({$tag['id']})"><span
                        class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div style="overflow: hidden">
            <span class="no-overflow">{$tag['name']}</span>
        </div>
    </div>
</div>
