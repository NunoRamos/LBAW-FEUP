<?php
/* Smarty version 3.1.30, created on 2017-02-20 18:32:34
  from "/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/answer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab28328997c5_48668366',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '018f1b47a7d596ae1fdf42c787e1ae10885cc979' => 
    array (
      0 => '/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/answer.tpl',
      1 => 1487611799,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ab28328997c5_48668366 (Smarty_Internal_Template $_smarty_tpl) {
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
