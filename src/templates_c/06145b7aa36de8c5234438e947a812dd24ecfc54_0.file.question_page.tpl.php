<?php
/* Smarty version 3.1.30, created on 2017-02-20 19:02:31
  from "/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/question_page.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab2f374801e4_21991102',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06145b7aa36de8c5234438e947a812dd24ecfc54' => 
    array (
      0 => '/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/question_page.tpl',
      1 => 1487613750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:answer.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_58ab2f374801e4_21991102 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Question</h3>
        </div>
        <div class="list-group">
            <?php $_smarty_tpl->_assignInScope('question', array("id"=>"1","title"=>"Network Problems","author"=>"Nuno Ramos","date"=>"20/02/2017","rate"=>"5","text"=>"Quando tento aceder à rede não consigo, porque será?"));
?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-2 col-sm-1 center-text">
                        <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
                        <div><?php echo $_smarty_tpl->tpl_vars['question']->value["rate"];?>
</div>
                        <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
                    </div>
                    <div class="col-xs-10 col-sm-11">
                        <div class="question-title"><?php echo $_smarty_tpl->tpl_vars['question']->value["title"];?>
</div>
                        <div class="question-text"><?php echo $_smarty_tpl->tpl_vars['question']->value["text"];?>
</div>
                        <span class="question-author">By <?php echo $_smarty_tpl->tpl_vars['question']->value["author"];?>
</span>
                        <span class="pull-right"><?php echo $_smarty_tpl->tpl_vars['question']->value["date"];?>
</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-offset-1">
        <div class="list-group">
            <?php $_smarty_tpl->_assignInScope('answers', array(array("id"=>"1","text"=>"Deixa de ser um noob","date"=>"20/02/2017","author"=>"Bernardo Belchior"),array("id"=>"2","text"=>"Isso é trivial, meu caro","date"=>"20/02/2017","author"=>"João Gomes")));
?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['answers']->value, 'answer');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['answer']->value) {
?>
                <?php $_smarty_tpl->_subTemplateRender("file:answer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
    </div>
    <div class="col-xs-offset-1">
        <div class="leave-answer-text">Leave your answer:</div>
        <form class="form-horizontal">
            <textarea class="form-control" rows="3" placeholder="Help Me"></textarea>
            <input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">
        </form>
    </div>
</div>
<div class="container col-xs-12 col-md-4 visible-lg visible-md" data-toogle="collapse">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Suggested Tags</h3>
        </div>
        <div class="panel-body list-group">
            <a href="#" class="list-group-item">Android</a>
            <a href="#" class="list-group-item">iOS</a>
            <a href="#" class="list-group-item">Windows Phone</a>
        </div>
    </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
