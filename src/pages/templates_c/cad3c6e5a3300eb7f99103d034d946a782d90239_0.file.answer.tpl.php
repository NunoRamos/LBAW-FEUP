<?php
/* Smarty version 3.1.30, created on 2017-02-25 16:00:15
  from "/home/bernardo/Documents/lbaw-feup/src/pages/templates/answer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58b1aa0f2f3fd7_93536017',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cad3c6e5a3300eb7f99103d034d946a782d90239' => 
    array (
      0 => '/home/bernardo/Documents/lbaw-feup/src/pages/templates/answer.tpl',
      1 => 1487612081,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58b1aa0f2f3fd7_93536017 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="list-group-item answer-div">
    <div class="row">
        <div class="col-xs-10 col-sm-11">
            <div><?php echo $_smarty_tpl->tpl_vars['answer']->value["text"];?>
</div>
            <span class="answer-author">By <?php echo $_smarty_tpl->tpl_vars['answer']->value["author"];?>
</span>
            <span class="answer-date pull-right"><?php echo $_smarty_tpl->tpl_vars['answer']->value["date"];?>
</span>
        </div>
    </div>
</div><?php }
}
