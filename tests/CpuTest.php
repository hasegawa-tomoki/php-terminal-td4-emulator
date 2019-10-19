<?php
namespace Td4\Test;

use PHPUnit\Framework\TestCase;
use Td4\Cpu;

class Td4Test extends TestCase
{
    /** @var Cpu */
    private $cpu;

    public function setUp(): void
    {
        parent::setUp();

        $this->cpu = new Cpu();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testOpCode0000()
    {
        // ADD A, Im
        $this->cpu->ram[0] = 0b00001000;
        $this->cpu->ram[1] = 0b00001000;

        $this->cpu->executeInstruction();
        self::assertEquals(8, $this->cpu->a);
        self::assertEquals(0, $this->cpu->carry);

        $this->cpu->executeInstruction();
        self::assertEquals(0, $this->cpu->a);
        self::assertEquals(1, $this->cpu->carry);
    }
    public function testOpCode0001()
    {
        // MOV A, B
        $this->cpu->ram[0] = 0b00010000;
        $this->cpu->b = 5;
        $this->cpu->executeInstruction();
        self::assertEquals(5, $this->cpu->a);
    }
    public function testOpCode0010()
    {
        // IN A
        $this->cpu->ram[0] = 0b00100000;
        $this->cpu->in = 0b1011;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1011, $this->cpu->a);
    }
    public function testOpCode0011()
    {
        // MOV A, Im
        $this->cpu->ram[0] = 0b00111111;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1111, $this->cpu->a);
    }
    public function testOpCode0100()
    {
        // MOV B, A
        $this->cpu->ram[0] = 0b01000000;
        $this->cpu->a = 7;
        $this->cpu->executeInstruction();
        self::assertEquals(7, $this->cpu->b);
    }
    public function testOpCode0101()
    {
        // ADD B, Im
        $this->cpu->ram[0] = 0b01011000;
        $this->cpu->ram[1] = 0b01011000;

        $this->cpu->executeInstruction();
        self::assertEquals(8, $this->cpu->b);
        self::assertEquals(0, $this->cpu->carry);

        $this->cpu->executeInstruction();
        self::assertEquals(0, $this->cpu->b);
        self::assertEquals(1, $this->cpu->carry);
    }
    public function testOpCode0110()
    {
        // IN B
        $this->cpu->ram[0] = 0b01100000;
        $this->cpu->in = 0b1010;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1010, $this->cpu->b);
    }
    public function testOpCode0111()
    {
        // MOV B, Im
        $this->cpu->ram[0] = 0b01110101;
        $this->cpu->executeInstruction();
        self::assertEquals(0b0101, $this->cpu->b);
    }
    public function testOpCode1001()
    {
        // OUT B
        $this->cpu->ram[0] = 0b10010000;
        $this->cpu->b = 0b1110;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1110, $this->cpu->out);
    }
    public function testOpCode1011()
    {
        // OUT Im
        $this->cpu->ram[0] = 0b10110011;
        $this->cpu->executeInstruction();
        self::assertEquals(0b0011, $this->cpu->out);
    }
    public function testOpCode1110()
    {
        // JNC
        $this->cpu->ram[0] = 0b11101110;
        $this->cpu->ram[1] = 0b11101110;

        $this->cpu->carry = 1;
        $this->cpu->executeInstruction();
        self::assertEquals(0b0001, $this->cpu->pc);

        $this->cpu->carry = 0;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1110, $this->cpu->pc);
    }
    public function testOpCode1111()
    {
        // JMP
        $this->cpu->ram[0] = 0b11111111;
        $this->cpu->executeInstruction();
        self::assertEquals(0b1111, $this->cpu->pc);
    }
}
