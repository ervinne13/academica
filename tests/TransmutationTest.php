<?php

use Academica\Grading\Transmuter;
use App\Models\Transmutation;

class TransmutationTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample() {

        //  Assumes Transmutation is seeded
        $transmutation = Transmutation::all();

        echo json_encode($transmutation);

        $transmuter = new Transmuter($transmutation);

        $this->assertEquals(60, $transmuter->transmute(0));
        $this->assertEquals(60, $transmuter->transmute(2));
        $this->assertEquals(60, $transmuter->transmute(3.99));

        $this->assertEquals(61, $transmuter->transmute(4));

        $this->assertEquals(75, $transmuter->transmute(60));
        $this->assertEquals(80, $transmuter->transmute(68));
        $this->assertEquals(90, $transmuter->transmute(84));

        $this->assertEquals(100, $transmuter->transmute(100));
    }

}
