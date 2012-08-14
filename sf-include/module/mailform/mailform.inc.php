<?php
/**
 * sfprocform.inc.php
 * 
 * Purpose:
 *  Module for emailing the contents of HTTP POST/GET submission 
 *  extends sf-Procform
 * 
 * Features:
 *  Sanitizes and sends HTTP POST/GET submission 
 *  
 * 
 * 
 */

 
 
 
define("staycms_module_mailform_default_to","nobody@localhost.localdomain");
define("staycms_module_mailform_default_from","noreply@localhost.localdomain");
define("staycms_module_mailform_default_subject","No Subject");





require_once(__DIR__ . "/../procform/procform.inc.php");

define("staycms_module_mailform_version","0.1");
define("staycms_module_mailform_errflag","705300"); //modules are flag 700000, sfform and deriv are +5000, mailproc is +100


class sfmailform_addr {
   private $addr;
   public function value() {
      return $this->addr;
   }  
   public function __construct($addr) {
      if (filter_var($addr,FILTER_VALIDATE_EMAIL)) {
         $this->addr = $addr;
      } else {
         throw new Exception( ("invalid email used '$addr' (" .(staycms_module_mailform_errflag+10).")"),staycms_module_mailform_errflag+10);
      }
      
   }
}

class sfmailform extends sfprocform {
   
   private $bodytemplate;
   
   private $from; //sfmailform_addr
   private $replyto; //sfmailform_addr 
   
   
   private $to; //array of sfmailform_addr
   private $to_csv; //comma-sep vals of (result of to serialization)
   private $to_serialized;
   
   private $body;
   private $body_serialized; //boolean
   
   private $headers;
   private $headers_serialized; //boolean
   
   public function from() {
      return $this->from->value();
   }

   public function replyto() {
      return $this->replyto->value();
   }
      
   public function setFrom($from) {
      $this->from = NULL;
      $this->from = new sfmailform_addr($from);
   }
   
   public function setReplyto($replyto) {
      $this->replyto = NULL;
      $this->replyto = new sfmailform_addr($replyto);
   }
   
   public function serializeto() {
      $this->to_serialized = false;
      if (count($this->to) == 0) {
         $this->addTo(staycms_module_mailform_default_from);
      }
      $addr = array();
      foreach ($this->to as $mbr) {
         $addr[] = $mbr->value();
      }
      $this->to_csv = implode(",",$addr);
      $this->to_serialized = true;
   }
   
   public function showTo($separator=", ") {
      if ($separator == ",") {
         echo $this->to_csv();
      } else {
         echo str_replace(",",$separator,$this->to_csv());
      }
   }
   
   public function to_csv() {
      if (!$this->to_serialized) $this->serializeto();
      
      return $this->to_csv;
   }
   
   public function subject() {
      return $this->subject;
   }
   
   private function serializeheaders() {
      $headers_serialized = false;
      $header   = array();
      $header[] = "MIME-Version: 1.0";
      $header[] = "Content-type: text/plain; charset=iso-8859-1";
      $header[] = "From: Sender Name <".$this->from().">";
      $header[] = "Reply-To: Recipient Name <".$this->replyto().">";
      $header[] = "Subject: {".$this->subject()."}";
      $header[] = "X-Mailer: staycms_".staycms_core_version."_mailform_".staycms_module_mailform_version."_sys_".phpversion();
      $this->headers = implode("\r\n", $header);
   }
   
   public function showHeaders($htmlentities=true,$nl2br=true) {
      $buff = $this->headers();
      if ($htmlentities===true) {
          $buff = htmlentities($buff); 
      }
      if ($nl2br === true) {
         $buff = nl2br($buff);
      }
      echo $buff;
   }
   
   public function headers() {
      if (!$this->headers_serialized) $this->serializeheaders();
      return $this->headers;
   }
   
   private function serializebody() {
      $this->body_serialized = false;
      ob_start();
      require($this->bodytemplate);
      $body = ob_get_contents();
      ob_end_clean();
      $body = wordwrap($body, 70);
      $this->body = $body;
      $this->body_serialized = true;
   }
   
   public function showBody($htmlentities=true,$nl2br=true) {
      $buff = $this->body();
      if ($htmlentities===true) {
          $buff = htmlentities($buff); 
      }
      if ($nl2br === true) {
         $buff = nl2br($buff);
      }
      echo $buff;
   }
   
   public function body() {
      if (!$this->body_serialized) $this->serializebody();
      return $this->body;
   }
   
   public function send() {
      define("staycms_module_mailform_send_errflag",20);
      //imap_mail( string $to , string $subject , string $message , $additional_headers
      if (
      false === imap_mail(
         $this->to_csv(),
         $this->subject,
         $this->body(),
         $this->headers(),
         "", /*cc*/
         "", /*bcc*/
         $this->from->value()
         ) 
      ) {
         
         throw new Exception("mail send failed (".(staycms_module_mailform_errflag+staycms_module_mailform_send_errflag).")",staycms_module_mailform_errflag+20);
      }
      
   }

   public function addTo($addr,$strict_addr=false) {

      $this->to[] = new sfmailform_addr($addr);
      
   }
   
   public function showSubject($format="%subject%") {
      $format = str_replace("%subject%",$this->subject,$format);
      echo $format;
   }
   
   public function setSubject($val) {
      /*some overly-cautious filtering for RFC 2047 compliance*/
      $val = preg_replace('/[^A-Za-z0-9_ -]/',"_",$val);
      if ($val == "") {
         $val = "(no subject)";
      } else
      if (strlen($val) > 70) {
         $val = substr($val,0,66);
         $val .= "...";
      }
      $this->subject = $val;
   }
   
   protected function initMailform(
      $to_addr=NULL,
      $from=staycms_module_mailform_default_from,
      $subject=staycms_module_mailform_default_subject,
      $bodytemplate=NULL
   ) {
      $this->to = array();
      $this->to_csv = "";
      $this->to_serialized = false;

      $this->body = "";
      $this->body_serialized = false;
      
      $this->headers = "";
      $this->headers_serialized = false;
      
      $this->setFrom($from);
      $this->setReplyto($from);
      
      if ($to_addr !== NULL) {
         $this->addTo($to_addr);
      }
      
      if (is_readable($bodytemplate)) {
         $this->bodytemplate = $bodytemplate;
      } else
      $this->bodytemplate = "template.body.inc.php";
      
      $this->setSubject($subject);
   }
   public function __construct(
      $to_addr=NULL,
      $from=staycms_module_mailform_default_from,
      $subject=staycms_module_mailform_default_subject,
      $bodytemplate=NULL
   ) {
      $this->initForm();
      $this->initMailform($to_addr,$from,$subject,$bodytemplate);
   }
}









