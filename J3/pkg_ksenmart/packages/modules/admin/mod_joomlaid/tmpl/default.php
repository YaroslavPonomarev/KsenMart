<div class="account_info_block clearfix">
    <div class="item">
        <a href="javascript:void(0);" title="<?php echo JText::_('MOD_JOOMLAID_PROFILE_TITLE'); ?>" class="settings-l">
            <?php echo $account_info->user_info->realname; ?>
        </a>
    </div>
    <div class="item">
        <a href="index.php?option=com_ksenmart&view=account&layout=credits_list" title="" class="getAccountActivity-none">
            <?php echo number_format($account_info->user_balance_info->balance, 2, ',', ' '); ?> <?php echo mb_substr(mb_strtolower($account_info->user_balance_info->currency), 0, 3); ?>
        </a>
    </div>
    <div class="item">
        <a href="index.php?option=com_ksenmart&view=account&layout=tickets_list" class="getAllMessage-none">
            <?php echo $account_info->user_open_tickets == 0 ? JText::_('MOD_JOOMLAID_MESSAGES_TITLE') : JText::sprintf('MOD_JOOMLAID_MESSAGES_COUNT_TITLE', $account_info->user_open_tickets); ?>
        </a>
    </div>
    <div class="item">
        <a href="index.php?option=com_ksenmart&task=account.logout" title="<?php echo JText::_('MOD_JOOMLAID_LOGOUT_TITLE'); ?>"><?php echo JText::_('MOD_JOOMLAID_LOGOUT_TITLE'); ?></a>
    </div>
</div>