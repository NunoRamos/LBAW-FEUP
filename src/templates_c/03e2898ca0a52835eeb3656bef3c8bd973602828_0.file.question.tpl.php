<?php
/* Smarty version 3.1.30, created on 2017-02-20 17:44:20
  from "/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/question.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab1ce48d0957_98583403',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03e2898ca0a52835eeb3656bef3c8bd973602828' => 
    array (
      0 => '/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/question.tpl',
      1 => 1487609059,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ab1ce48d0957_98583403 (Smarty_Internal_Template $_smarty_tpl) {
?>
<a href="index.php?page=question_page&id=<?php echo $_smarty_tpl->tpl_vars['question']->value["id"];?>
" class="list-group-item">
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
            <span>By <?php echo $_smarty_tpl->tpl_vars['question']->value["author"];?>
</span>
            <span class="pull-right"><?php echo $_smarty_tpl->tpl_vars['question']->value["date"];?>
</span>
        </div>
    </div>
</a>
<?php }
}
