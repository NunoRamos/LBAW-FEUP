<?php
/* Smarty version 3.1.30, created on 2017-02-20 16:09:55
  from "/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/landing_page.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab06c32dbe05_54001018',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a9fe5d74456fae893fcda124c554449e260c6fe' => 
    array (
      0 => '/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/landing_page.tpl',
      1 => 1487603332,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:question.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_58ab06c32dbe05_54001018 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Top Questions</h3>
        </div>
        <div class="list-group">
            <?php $_smarty_tpl->_assignInScope('questions', array(array("id"=>"1","title"=>"Network Problems","author"=>"Nuno Ramos","date"=>"20/02/2017","rate"=>"5"),array("id"=>"2","title"=>"Internet Problems","author"=>"Vasco Ribeiro","date"=>"19/02/2017","rate"=>"-2")));
?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['questions']->value, 'question');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['question']->value) {
?>
                <?php $_smarty_tpl->_subTemplateRender("file:question.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4">
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
