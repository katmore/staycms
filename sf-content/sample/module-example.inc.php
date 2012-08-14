<?php $form = $this->getModule("procform"); /* get the form widget */ ?>
<?php $form->setContentid("module-example"); /* initialize: provide the target page content-id */ ?>
<?php $form->addValruleToFormvar("lucky","noblank");  /* add rule to the form*/ ?>
<?php $form->addValruleToFormvar("lucky","integer");  /* add rule to the form*/ ?>
<?php $form->addValruleToFormvar("comments","noblank");  /* add rule to the form*/ ?>
<?php $form->processForm(); /* process any HTTP POST input */ ?>


<h3>This is an example of using a module directly in content.</h3>
<h4>More modules can be found at <a href="http://katmore.com/sft/staycms">katmore.com/sft/staycms</a></h4>
<p>This page specifically deals with the sf-ProcForm and sf-Form Modules. They are included by default in the StayCMS pacakge.</p>
<p>The ProcForm module obtains and organizes HTTP POST/GET values for safe use; typically for processing HTML forms.
Because of the generalized nature of sf-ProcForm, it is simple to implement. For more complex forms it may not be as runtime efficent compared to extending the sf-Form module.</p>
<p>In other words, ProcForm has to have extra error handling and searching capability that wouldn't otherwise have to exist. Yet it serves as a safe and quick way to create form processing routines.</p>
<p>ProcForm itself is an extention of the sf-Form module.
Extentions to the sf-Form module could be created in the content space, or new modules can be created which extend it as well.</p>
<p>View the "Submission Summary" section of this page in both the Browser and in the PHP source to get an idea how ProcForm works.</p>
<p>Notice how input values are made persistent between submission requests, and default values and names can be easily configured for all different types of inputs. This is where ProcForm can elimiate the need for tedious form handling code, which is where it can save on development time.</p>
<p>Check out <a href="<?php $this->showContentLink("mailform-example");?>">mail form example</a> which emails the submission of a form (server side)
<form <?php $form->showFormAttrs(); ?>>
<div class="inputgroup">
   <div class="inputlabel">favorite movie:</div>
   <input type="text" <?php $form->showNameValueAttrs("movie","Tron"); ?>/>
</div><!--inputgroup-->
<div class="inputgroup">
   <div class="inputlabel">lucky number: <? $form->showStrIfValruleExistent("lucky","noblank","*"); ?></div>
   <input type="text" <?php $form->showNameValueAttrs("lucky");  ?>/>
</div><!--inputgroup-->
<div class="inputgroup">
   <div class="inputlabel">choose color:</div>
   <div class="radiogroup">
      <input type="radio" name="color" id="red" <?php $form->showValueCheckedAttrs("color","red",true); ?>><label for="red">red</label>
   </div><!--radiogroup-->
   <div class="radiogroup">
      <input type="radio" name="color" <?php $form->showValueCheckedIdAttrs("color","green"); ?>><label for="green">green</label>
   </div><!--radiogroup-->
   <div class="radiogroup">
      <input type="radio" <?php $form->showNameValueCheckedIdAttrs("color","blue"); ?>><label for="blue">blue</label>
   </div><!--radiogroup-->
   <div class="radiogroup">
      <input type="radio" <?php $form->showNameValueCheckedIdAttrs("color","white"); ?>><label for="white">white</label>
   </div><!--radiogroup-->
   <div class="radiogroup">
      <input type="radio" <?php $form->showNameValueCheckedIdAttrs("color","grey"); ?>><label for="grey">grey</label>
   </div><!--radiogroup-->
   <div class="radiogroup">
      <input type="radio" <?php $form->showNameValueCheckedIdAttrs("color","black"); ?>><label for="black">black</label>
   </div><!--radiogroup-->
</div><!--inputgroup-->
<div class="inputgroup">
   <div class="inputlabel">preferred carnivore:</div>
   <select name="carnivore">
      <option <?php $form->showValueSelectedAttrs("carnivore","lion"); ?>>lion</option>
      <option <?php $form->showValueSelectedAttrs("carnivore","otter",true); ?>>otter</option>
      <option <?php $form->showValueSelectedAttrs("carnivore","praying_mantis"); ?>>praying mantis</option>
      <option <?php $form->showValueSelectedAttrs("carnivore","spider"); ?>>spider</option>
   </select>
</div><!--inputgroup-->
<div class="inputgroup">
<div class="inputlabel">ideal bouquet:</div>
   <input <?php $form->showCheckedAttrIfOn("bouquet","daffoldils"); ?> type="checkbox" name="bouquet['daffoldils']" id="daffoldils"><label for="daffoldils">daffodils</label>
   <input type="checkbox" <?php $form->showNameCheckedAttrs("bouquet","tulips"); ?> id="tulips"><label for="tulips">tulips</label>
   <input type="checkbox" <?php $form->showNameCheckedIdAttrs("bouquet","orchids"); ?> ><label for="orchids">orchids</label><br>
   <input type="checkbox" <?php $form->showNameCheckedIdAttrs("bouquet","carnations"); ?>><label for="carnations">carnations</label>
   <input type="checkbox" <?php $form->showNameCheckedIdAttrs("bouquet","violets"); ?>><label for="violets">violets</label>
   <input type="checkbox" <?php $form->showNameCheckedIdAttrs("bouquet","sunflowers",true); ?>><label for="sunflowers">sunflowers<br></label>
</div><!--inputgroup-->
<div class="inputgroup">
   <div class="inputlabel">desired holiday spots: <span style="font-weight:normal;">(multiple select possible)</span></div>
   <select multiple="multiple" size="5" name="vacation[]">
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","london"); ?>>London</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","paris",true); ?>>Paris</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","new_york"); ?>>New York</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","rome"); ?>>Rome</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","moscow"); ?>>Moscow</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","tokyo"); ?>>Tokyo</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","toronto"); ?>>Toronto</option>
      <option <?php $form->showValueSelectedAttrsForGroup("vacation","jburg"); ?>>Johannesburg</option>
   </select>
</div><!--inputgroup-->
<div class="inputgroup">
<div class="inputlabel">comments:</div>
   <textarea name="comments"><?php $form->getFormvar("comments")->showValue(new htmlfilter()); ?></textarea><br>
   <input name="sfform_submit" type="submit" value="submit">
</form>
</div><!--inputgroup-->
<h3>Submission Summary</h3>
<?php if  ( $form->isProcessed() ) { /* begin is Processed? section */ ?>
<b><?php $form->showFormvarCount(); ?> values submitted:</b>
<?php $form->showStrIfAnyValruleBroken("at least one rule broken"); ?>
<ul>
<?php for($i=0;$i < $form->getFormvarCount();$i++) { /* begin form var loop section */ ?>
   <?php if (is_a($form->getFormvar($i),"sfformvargrp")) { ?>
   <li>'<?php $form->getFormvar($i)->showName(); ?>' is a group with <?php $form->getFormvar($i)->showCount(); ?> members</li>
      <ul>
      <?php for($j=0;$j < $form->getFormvar($i)->getCount();$j++ ) { ?>
         <li><?php $form->getFormvar($i)->showKey($j); ?>:<?php $form->getFormvar($i)->showValue($j); ?></li>
      <?php } ?>
      </ul>
   <?php } else { ?>
   <li>
   <?php $form->getFormvar($i)->showName(); ?>='<?php $form->getFormvar($i)->showValue(); ?>'
   <? $form->showStrForEachValruleExistent($form->getFormvar($i)->name(),"has rule: %pneumonic%. "); ?>
   <?php if ($form->isValruleBroken($form->getFormvar($i)->name())) { ?>
   <?php $form->showMsgForEachValruleBroken($form->getFormvar($i)->name(),"rule broken: %msg%. ");?>
   <?php } ?>
   </li>
   <?php } ?>
<?php } /* end form var loop section */ ?>
</ul>
<?php $form->showCountIfAnyValruleBroken(); ?>
<?php } else {  ?>
   nothing submitted
<?php } /* end is Processed? section */  ?>





