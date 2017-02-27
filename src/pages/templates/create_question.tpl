{include file="header.tpl"}

<div class="container">
    <div class="form-group">
        <div class="div-margins row">
            <label class="col-xs-12 col-sm-1 label-style" for="inputTitle">Title</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <input type="text" id="inputTitle" class="form-control">
            </div>
        </div>
        <div class="div-margins row">
            <label class="col-xs-12 col-sm-1 label-style" for="InputQuestionText">Question</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <textarea class="form-control" id="InputQuestionText" rows="8"></textarea>
            </div>
        </div>
        <div class="div-margins row">
            <label class="col-xs-12 col-sm-1 label-style" for="inputTags">Tags</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <input type="text" class="form-control" id="inputTags">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <input class="btn btn-default submit-answer-btn" type="submit" value="Ask Question">
            </div>
        </div>
    </div>
</div>


{include file="footer.tpl"}