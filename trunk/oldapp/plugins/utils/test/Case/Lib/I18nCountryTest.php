<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Lib", "Utils.I18nCountry");

class I18nCountryTest extends CakeTestCase
{
    public function testGetList()
    {
        $Country = new I18nCountry();
        $result = $Country->getList();
        $this->assertTrue(is_array($result));
        $this->assertEqual($result["AF"], "Afghanistan");
    }

    public function testGetBy()
    {
        $Country = new I18nCountry();
        $this->assertEqual($Country->getBy("US"), "United States");
        $result = $Country->getBy("US", true);
        $this->assertTrue(is_array($result));
    }

}




?>