<?php
require_once "vendor/autoload.php";

$cpu = new Td4\Cpu();

$cpu->ram = [
    0b10110001,
    0b10110010,
    0b10110100,
    0b10111000,
    0b10110100,
    0b10110010,
    0b11110000,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
];

do {
    printf("PC: 0b%04b > ", $cpu->pc);
    $stdin = strtolower(trim(fgets(STDIN)));
    if ($stdin === 'quit'){
        break;
    }
    if (preg_match('/[01]{4,4}/', $stdin)){
        $cpu->in = bindec($stdin);
    }
    $cpu->executeInstruction();
    printf("IN: 0b%04b  OUT: 0b%04b\n", $cpu->in, $cpu->out);
} while(true);
