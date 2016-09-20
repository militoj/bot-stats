<?php namespace Stats\Service;

require_once "../vendor/autoload.php";

use Stats;
use Devtools\Response;
use Stats\Denials;

class RecordPrinter extends Response
{
  function __construct(Stats\RecordPrinter $recordPrinter)
  {
    parent::__construct();
    $this->recordPrinter = $recordPrinter;
    $this->processRequest();
  }

  function get() {
    $result = $this->recordPrinter->toArray();
    $this->data(array('rows'=>$result));
    echo $this->json();
  }
}

$recordPrinter=new Stats\RecordPrinter(new Denials(), new Stats\Verified());
new RecordPrinter($recordPrinter);
