{include file="header.tpl"}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css"
      integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous">
<link rel="stylesheet" href="../../stylesheets/select2.css">

<div class="container">
    <form class="form-group">
        <div class="div-margins row">
            <label class="col-xs-12 col-sm-1 label-style" for="inputTitle">Title</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <input type="text" placeholder="Give me a title" id="inputTitle" class="form-control">
            </div>
        </div>
        <div class="div-margins row">
            <label class="col-xs-12 col-sm-1 label-style" for="InputQuestionText">Question</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <textarea class="form-control" id="InputQuestionText" rows="8"></textarea>
            </div>
        </div>
        <div class="row">
            <label class="col-xs-12 col-sm-1 label-style" for="inputTags">Tags</label>
            <div class="col-xs-10 col-sm-8 col-md-6">
               <!-- <input type="text" class="form-control" id="inputTags">-->
                <form class="form-horizontal filter-list">
                    <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
                    <select id="tags-select-create-question" multiple="multiple" style="width: 100%;">
                        <!-- Add these options dinamically  -->
                        <option value="android">Android</option>
                        <option value="ios">iOS</option>
                        <option value="java">Java</option>
                        <option value="bootstrap">Bootstrap</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <input class="btn btn-default submit-answer-btn" type="submit" value="Ask Question">
            </div>
        </div>
    </form>
</div>

{include file="footer.tpl"}

<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"
        integrity="sha256-+mWd/G69S4qtgPowSELIeVAv7+FuL871WXaolgXnrwQ=" crossorigin="anonymous"></script>
<script src="javascript/create_question.js"></script>
