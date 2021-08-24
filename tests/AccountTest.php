<?php

class AccountTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetBalance()
    {
        $this->get('/balance?account_id=1234');

        $this->assertEquals(
            0, $this->response->getContent()
        );
    }
}
