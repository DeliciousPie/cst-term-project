<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class S42Test extends TestCase
{

    
    /**
     * Test that that valid emails are returned as true.
     * This test ensures that the filter_var function (which handles all our
     * email validation) will not reject a variety of valid emails. Any of these
     * emails can be used to register with.
     */
    public function testValidEmails()
    {
        //Make an array of valid emails
        $validEmails = array("example@example.com", "totallyreal123@example.ca",
            "123realemail@example.co.uk", "valid_girl_222@example.sk.ca",
            "phpunitsucks@example.gov", "I_have_resorted_to_this@example.us",
            "aaayyyyyyy_lmao@example.jp"
            );
        //Loop through all the emails. filter_var returns the filtered text if
        // it is valid (e.g. a valid email) or false if it fails. As long as
        // these aren't returning false they are valid emails. And since all
        // the emails in the array are valid they will all return !False.
        foreach( $validEmails as $email)
        {
            $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        }
    }
    /**
     * Test that a variety of invalid email addresses are all invalid.
     * This test ensures that the filter_var function (which handles all of our
     * email validation) will reject a variety of invalid emails
     */
    public function testInvalidEmails()
    {
        //Make an array of invalid emails
        $invalidEmails = array("example", "example@", "example@example", 
            "&&$*&$^#&@example.^^#&*@^", "$&^8u47gjhydgfs7d68&^#T&FGUVVDd",
            "email.valid@reversed", "@", ".@.", ".@.com",
            "smeeeeegul@randomsymbolsarenotdomains.^^&*@&#%%@&&#^@*#(",
            "example@example.", "fakeEMAIL@_____|****"
            );
        //Loop through every invalid email. filter_var returns False when
        // the value doesn't match the filter. Since none of these are valid
        // emails, they will all return false and the test will pass.
        foreach($invalidEmails as $email)
        {
            $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        }
    }
}
