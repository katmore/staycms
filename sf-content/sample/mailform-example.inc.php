<?php $form = $this->getModule("mailform"); /* get the form module */ ?>
<?php $form->setContentid("mailform-example"); /* initialize: provide the target page content-id */ ?>
<?php $form->addValruleToFormvar("lucky","noblank");  /* add rule to the form*/ ?>
<?php $form->addValruleToFormvar("lucky","integer");  /* add rule to the form*/ ?>
<?php $form->addValruleToFormvar("comments","noblank");  /* add rule to the form*/ ?>
<?php $form->processForm(); /* process any HTTP POST input */ ?>


<h3>This is an example of using the mailform Module to mail results of a form submission.</h3>
<h4>More modules can be found at <a href="http://katmore.com/sft/staycms">katmore.com/sft/staycms</a></h4>
<p>This module is designed to make it easy to email a form submission. It extends (and depends on) the procform module.
<p>The body of the email message comes from the file template.body.inc.php.

<form <?php $form->showFormAttrs(); ?>>
<div class="inputlabel">email form when rules are broken?</div>
<input type="radio" <?php $form->showNameValueCheckedIdAttrs("ignorerules","ignore_yes"); ?>><label for="ignore_yes">yes</label>
<input type="radio" <?php $form->showNameValueCheckedIdAttrs("ignorerules","ignore_no",true); ?>><label for="ignore_no">no</label>

<div class="inputlabel">display the message being emailed?</div>
<input type="radio" <?php $form->showNameValueCheckedIdAttrs("displaybody","display_yes",true); ?>><label for="display_yes">yes</label>
<input type="radio" <?php $form->showNameValueCheckedIdAttrs("displaybody","display_no"); ?>><label for="display_no">no</label>


<div class="inputlabel">favorite movie:</div>
   <input type="text" <?php $form->showNameValueAttrs("movie","Tron"); ?>/>
<!--inputgroup-->
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
<?php $form->showStrIfAnyValruleBroken("at least one rule broken"); ?>: <?php $form->showCountIfAnyValruleBroken("(%count%)"); ?>
<?php $form->addTo("myself@localhost.localdomain"); ?>
<p>the form will be sent to: '<code><?php $form->showTo(); ?></code>'
<p>the subject will show as: '<code><?php $form->showSubject(); ?></code>'
<p>the headers will look like:<p><code><?php $form->showHeaders(); ?></code>
<p>the body will look like:<p><code><?php $form->showBody(); ?></code>
<p>attempting to send the form:
<?php $form->send(); ?>
<p>email given to local agent
<?php } else {  ?>
<p>nothing submitted
<?php } /* end is Processed? section */  ?>





