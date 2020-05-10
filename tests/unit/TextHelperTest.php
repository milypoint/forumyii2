<?php 
class TextHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @test
     * @dataProvider textDataProvider
     */
    public function testSomeFeature($inputData, $expectedResult)
    {
        $result = \app\helpers\TextHelper::textToPath($inputData);
        $this->assertEquals($expectedResult, $result);
    }

    public function textDataProvider()
    {
        return [
            ['This is text', 'this-is-text'],
            ['This is text.', 'this-is-text'],
            ['%This% Is Text?', 'this-is-text']
        ];
    }
}