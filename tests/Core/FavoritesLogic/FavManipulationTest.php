<?php

namespace Core\FavoritesLogic;

use App\Core\FavoritesLogic\FavManipulation;
use PHPUnit\Framework\TestCase;

class FavManipulationTest extends TestCase
{
    public function testMoveNumberUpSuccessfully() : void
    {
     $manipulator = new FavManipulation();

     $array = array(
         "0" => "3",
         "1" => "4",
     );

     $expectedArray = array(
         "0" => "4",
         "1" => "3"
     );

     $numberToMove = "4";

     $sortedArray = $manipulator->moveNumberUp($array, $numberToMove);

     self::assertSame($expectedArray, $sortedArray);
    }
    public function testMoveNumberUpInvalid() : void
    {
        $manipulator = new FavManipulation();

        $array = array(
            "0" => "3",
            "1" => "4",
        );

        $expectedArray = array(
            "0" => "3",
            "1" => "4"
        );

        $numberToMove = "3";

        // expects to receive the same array, since numberToMove can't be pushed higher.

        $sortedArray = $manipulator->moveNumberUp($array, $numberToMove);

        self::assertSame($expectedArray, $sortedArray);
    }
    public function testMoveNumberUpDownSuccessfully() : void
    {
        $manipulator = new FavManipulation();

        $array = array(
            "0" => "3",
            "1" => "4",
        );

        $expectedArray = array(
            "0" => "4",
            "1" => "3"
        );

        $numberToMove = "3";

        $sortedArray = $manipulator->moveNumberDown($array, $numberToMove);

        self::assertSame($expectedArray, $sortedArray);
    }
    public function testMoveNumberUpDownInvalid() : void
    {
        $manipulator = new FavManipulation();

        $array = array(
            "0" => "4",
            "1" => "3",
        );

        $expectedArray = array(
            "0" => "4",
            "1" => "3"
        );

        $numberToMove = "3";

        // expects to receive the same array, since numberToMove can't be pushed higher.

        $sortedArray = $manipulator->moveNumberDown($array, $numberToMove);

        self::assertSame($expectedArray, $sortedArray);
    }


}