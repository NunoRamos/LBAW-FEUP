<?php
/* Smarty version 3.1.30, created on 2017-02-25 16:00:13
  from "/home/bernardo/Documents/lbaw-feup/src/pages/templates/question.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58b1aa0e0045e5_89267984',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf2d64d54363db3ef93c5bda11f0a7428ada5ae3' => 
    array (
      0 => '/home/bernardo/Documents/lbaw-feup/src/pages/templates/question.tpl',
      1 => 1488038324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58b1aa0e0045e5_89267984 (Smarty_Internal_Template $_smarty_tpl) {
?>
<a href="question_page.php" class="list-group-item">
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
