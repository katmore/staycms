---------------begin staycms mailform submission---------------
<?php for($i=0;$i < $this->getFormvarCount();$i++) { /* begin form var loop section */ ?>
<?php if (is_a($this->getFormvar($i),"sfformvargrp")) { ?>
'<?php $this->getFormvar($i)->showName(); ?>'
--is a group with <?php $this->getFormvar($i)->showCount(); ?> members

<?php for($j=0;$j < $this->getFormvar($i)->getCount();$j++ ) { ?>
<?php $this->getFormvar($i)->showKey($j); ?>:<?php $this->getFormvar($i)->showValue($j); ?>
<?php } ?>
<?php } else { ?>
<?php $this->getFormvar($i)->showName(); ?>='<?php $this->getFormvar($i)->showValue(); ?>'
<? $this->showStrForEachValruleExistent($this->getFormvar($i)->name(),"--has rule: %pneumonic%"); ?>

<?php if ($this->isValruleBroken($this->getFormvar($i)->name())) { ?>
<?php $this->showMsgForEachValruleBroken($this->getFormvar($i)->name(),"--rule broken: %msg%.\n\n");?>
<?php } ?>
<?php } ?>
<?php } /* end form var loop section */ ?>
----------------end staycms mailform submission----------------