<?php declare(strict_types=1);


use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use tennis_tournament\player\domain\PlayerBuilder;
use tennis_tournament\util\domain\GenderEnum;

final class PlayerTest extends TestCase
{

    #[Test]
    #[DataProvider("dataProvider")]
    #[TestDox('Player creation')]
    public function playerCreation(GenderEnum $gender, array $attributes, bool $spectedCreationStatus): void
    {
        $playerCreated = false;
        try {
            $player = PlayerBuilder::build($gender, $attributes);
            $playerCreated = true;
        } catch (\Throwable $th) {
            $playerCreated = false;
        }
        // TODO: Differentiate the causes of it failures, using for example domain exceptions
        $this->assertSame($spectedCreationStatus, $playerCreated);
    }

    public static function dataProvider()
    {
        return [
            "Data set 00" => [
                GenderEnum::Male,
                [
                    'name' => 'playerName',
                    'level' => 100,
                    'force' => 100,
                    'displacementSpeed' => 100,
                ],
                true
            ],
            "Data set 01" => [
                GenderEnum::Male,
                [
                    'name' => 'playerName',
                    'level' => 101,
                    'force' => 100,
                    'displacementSpeed' => 100,
                ],
                false
            ],
            "Data set 02" => [
                GenderEnum::Male,
                [
                    'name' => 'playerName',
                    'level' => 'level', 
                    'force' => 'force',
                    'displacementSpeed' => 100,
                ],
                true // level and force will be zero without errors/wargnings
            ],
            "Data set 03" => [
                GenderEnum::Male,
                [
                    'name' => 'playerName',
                    'level' => '100',
                    'force' => '100',
                    'displacementSpeed' => '100',
                ],
                true
            ],
            // Female
            "Data set 04" => [
                GenderEnum::Female,
                [
                    'name' => 'playerName',
                    'level' => 100,
                    'reactionTime' => 100,
                ],
                true
            ],
            "Data set 05" => [
                GenderEnum::Female,
                [
                    'name' => 'playerName',
                    'level' => 0,
                    'reactionTime' => 0,
                ],
                true
            ],
            "Data set 06" => [
                GenderEnum::Female,
                [
                    'name' => 'playerName',
                    'level' => -1,
                    'reactionTime' => 100,
                ],
                false
            ],
            "Data set 07" => [
                GenderEnum::Female,
                [
                    'name' => 'playerName',
                    'level' => 0,
                    'reactionTime' => 0,
                ],
                true
            ],
        ];
    }

}
