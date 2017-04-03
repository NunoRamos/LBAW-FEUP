{include file="common/header.tpl"}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css"
      integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous">
<link rel="stylesheet" href="/css/select2.css">
<link rel="stylesheet" href="/lib/trumbowyg/ui/trumbowyg.min.css">

<div class="panel panel-default">
    <div class="panel-heading">
        Ask A Question
    </div>
    <form class="panel-body form-horizontal">
        <div class="form-group clearfix">
            <label class="col-xs-12 col-sm-2 control-label" for="question-title">Title</label>
            <div class="col-xs-12 col-sm-9">
                <input type="text" placeholder="Title" id="question-title" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label id="question-text-label" class="col-xs-12 col-sm-2 control-label"
                   for="question-text">Question</label>
            <div class="col-xs-12 col-sm-9">
                <textarea class="form-control" id="question-text" rows="8"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-12 col-sm-2 control-label" for="question-tags">Tags</label>
            <div class="col-xs-12 col-sm-9">
                <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
                <select id="question-tags" multiple="multiple" style="width: 100%;">
                    <!-- Add these options dinamically  -->
                    <option value="android">Android</option>
                    <option value="ios">iOS</option>
                    <option value="java">Java</option>
                    <option value="bootstrap">Bootstrap</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-9">
                <input class="btn btn-default submit-answer-btn full-width-xs" type="submit" value="Ask Question">
            </div>
        </div>
    </form>
</div>

{include file="common/footer.tpl"}

<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"
        integrity="sha256-+mWd/G69S4qtgPowSELIeVAv7+FuL871WXaolgXnrwQ=" crossorigin="anonymous"></script>
<script src="/lib/trumbowyg/trumbowyg.min.js"></script>
<script src="/javascript/create_question.js"></script>
