<?php
namespace TD4;

class Cpu {
    public $ram = [];
    public $a = 0;
    public $b = 0;
    public $carry = 0;
    public $pc = 0;
    public $in = 0;
    public $out = 0;

    public function __construct()
    {
        $this->ram = array_fill(0, 16, 0);
    }

    public function executeInstruction()
    {
        $byte = $this->ram[$this->pc];
        $opcode = $byte >> 4;
        $operand = $byte & 0b00001111;
        switch ($opcode){
            case 0b0000:
                // ADD A, Im
                $result = $this->a + $operand;
                $this->carry = ($result > 0b1111);
                $this->a = $result & 0b1111;
                break;
            case 0b0001:
                // MOV A, B
                $this->a = $this->b;
                break;
            case 0b0010:
                // IN A
                $this->a = $this->in;
                break;
            case 0b0011:
                // MOV A, Im
                $this->a = $operand;
                break;
            case 0b0100:
                // MOV B, A
                $this->b = $this->a;
                break;
            case 0b0101:
                // ADD B, Im
                $result = $this->b + $operand;
                $this->carry = ($result > 0b1111);
                $this->b = $result & 0b1111;
                break;
            case 0b0110:
                // IN B
                $this->b = $this->in;
                break;
            case 0b0111:
                // MOV B, Im
                $this->b = $operand;
                break;
            case 0b1001:
                // OUT B
                $this->out = $this->b;
                break;
            case 0b1011:
                // OUT Im
                $this->out = $operand;
                break;
            case 0b1110:
                // JNC
                if (! $this->carry){
                    $this->pc = $operand;
                    return;
                }
                break;
            case 0b1111:
                // JMP
                $this->pc = $operand;
                return;
        }
        $this->pc++;
    }
}

