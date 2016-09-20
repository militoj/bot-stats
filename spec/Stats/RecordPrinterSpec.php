<?php namespace spec\Stats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stats\Denials;
use Stats\Verified;

class RecordPrinterSpec extends ObjectBehavior
{
    function let(Denials $denials, Verified $verified) {
      $denials->all()->willReturn([]);
      $verified->all()->willReturn([]);
      $this->beConstructedWith($denials, $verified);

    }
    function it_is_initializable($denials, $verified)
    {

        $this->shouldHaveType('Stats\RecordPrinter');
    }
    function it_sets_infoArray_to_empty($denials, $verified) {
      $this->infoArray->shouldreturn([]);
    }
}
