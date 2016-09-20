<?php namespace Stats;
require_once "vendor/autoload.php";

// require_once 'Denials.php';
// require_once 'Verified.php';

class RecordPrinter
{
  private $denials;
  private $verified;

  function __construct($denials, $verified)
  {
    $this->denials=$denials;
    $this->verified=$verified;
    $this->getUserIds()
      ->buildCounts();
      //->toJson();
  }

  private function getUserIds()
  {
    $denialsAll = $this->denials->all();
    $verifiedsAll = $this->verified->all();
    $userIDArray1=array_keys($denialsAll);
    $userIDArray2=array_keys($verifiedsAll);
    $this->userIDs=array_unique(array_merge($userIDArray1,$userIDArray2));
    return $this;
  }

  private function buildCounts()
  {
    $infoArray = array();

    foreach ($this->userIDs as $userid)
    {
      $temp = array();
      $temp['denialCount'] = $this->denials->byUserId($userid);
      $temp['verifiedCount'] = $this->verified->byUserId($userid);

      if ($temp['denialCount'] != 0 )
      {
        $temp = array_merge($temp, $this->denials->userData($userid));
      }
      else if ($temp['verifiedCount'] != 0 )
      {
        $temp = array_merge($temp, $this->verified->userData($userid));
      }
      else
      {
        echo "Error";
      }
      $temp['verifiedPercent'] = round(($temp['verifiedCount']/($temp['verifiedCount']+$temp['denialCount'])),2);
      $temp['denialPercent'] = round(($temp['denialCount']/($temp['verifiedCount']+$temp['denialCount'])),2);
      array_push($infoArray, $temp);
    }
    $this->infoArray = $infoArray;

    return $this;
  }

  public function toArray()
  {
    return $this->infoArray;
  }

  public function toJson()
  {
    return json_encode($this->infoArray, true);
  }
}

//$denials = new Denials();
//$verified = new Verified();

//new RecordPrinter($denials, $verified);
