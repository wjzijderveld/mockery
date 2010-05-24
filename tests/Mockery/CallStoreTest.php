<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

class CallStoreTest extends PHPUnit_Framework_TestCase
{

    public function setup ()
    {
        $this->container = new \Mockery\Container;
        $this->spy = $this->container->spy('foo');
    }
    
    public function teardown()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
        $this->container->mockery_close();
    }

    public function testReturnsNullWhenNoArgs()
    {
        $this->assertNull($this->spy->foo());
    }
    
    public function testReturnsNullWhenSingleArg()
    {
        $this->assertNull($this->spy->foo(1));
    }
    
    public function testReturnsNullWhenManyArgs()
    {
        $this->assertNull($this->spy->foo('foo', array(), new stdClass));
    }
    
    public function testReturnsSameValueForAllIfNoArgsExpectationAndNoneGiven()
    {
        $this->spy->whenReceives('foo')->thenReturn(1);
        $this->assertEquals(1, $this->spy->foo());
    }
    
    public function testReturnsSameValueForAllIfNoArgsExpectationAndSomeGiven()
    {
        $this->spy->whenReceives('foo')->thenReturn(1);
        $this->assertEquals(1, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentially()
    {
        $this->spy->whenReceives('foo')->thenReturn(1, 2, 3);
        $this->spy->foo('foo');
        $this->assertEquals(2, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCalls()
    {
        $this->spy->whenReceives('foo')->thenReturn(1, 2, 3);
        $this->spy->foo('foo');
        $this->spy->foo('foo');
        $this->assertEquals(3, $this->spy->foo('foo'));
        $this->assertEquals(3, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCallsWithManythenReturnCalls()
    {
        $this->spy->whenReceives('foo')->thenReturn(1)->thenReturn(2, 3);
        $this->spy->foo('foo');
        $this->spy->foo('foo');
        $this->assertEquals(3, $this->spy->foo('foo'));
        $this->assertEquals(3, $this->spy->foo('foo'));
    }

    public function testReturnsValueOfClosure()
    {
        $this->spy->whenReceives('foo')->with(5)->thenReturnUsing(function($v){return $v+1;});
        $this->assertEquals(6, $this->spy->foo(5));
    }
    
    public function testReturnsUndefined()
    {
        $this->spy->whenReceives('foo')->thenReturnUndefined();
        $this->assertTrue($this->spy->foo() instanceof \Mockery\Undefined);
    }
    
    /**
     * @expectedException OutOfBoundsException
     */
    public function testThrowsException()
    {
        $this->spy->whenReceives('foo')->thenThrow(new OutOfBoundsException);
        $this->spy->foo();
    }
    
    /**
     * @expectedException OutOfBoundsException
     */
    public function testThrowsExceptionBasedOnArgs()
    {
        $this->spy->whenReceives('foo')->thenThrow('OutOfBoundsException');
        $this->spy->foo();
    }
    
    public function testThrowsExceptionBasedOnArgsWithMessage()
    {
        $this->spy->whenReceives('foo')->thenThrow('OutOfBoundsException', 'foo');
        try {
            $this->spy->foo();
        } catch (OutOfBoundsException $e) {
            $this->assertEquals('foo', $e->getMessage());
        }
    }
    
    /**
     * @expectedException OutOfBoundsException
     */
    public function testThrowsExceptionSequentially()
    {
        $this->spy->whenReceives('foo')->thenThrow(new Exception)->thenThrow(new OutOfBoundsException);
        try {
            $this->spy->foo();
        } catch (Exception $e) {}
        $this->spy->foo();
    }
    
    public function testMultipleExpectationsWithReturns()
    {
        $this->spy->whenReceives('foo')->with(1)->thenReturn(10);
        $this->spy->whenReceives('bar')->with(2)->thenReturn(20);
        $this->assertEquals(10, $this->spy->foo(1));
        $this->assertEquals(20, $this->spy->bar(2));
    }
    
    public function testExpectsNoArguments()
    {
        $this->spy->whenReceives('foo')->withNoArgs()->thenReturn(9);
        $this->assertEquals(9, $this->spy->foo());
    }
    
    /**
     * @expectedException \Mockery\Exception
     */
    public function testThrowsExceptionWhenWeAssertReceiptofUnreceivedMethodCall()
    {
        $this->spy->assertReceived('foo');
    }
    
    public function testThrowsExceptionWhenWeAssertReceiptofReceivedMethodCall()
    {
        $this->spy->foo();
        $this->spy->assertReceived('foo');
    }
    
    /**
     * @expectedException \Mockery\Exception
     */
    public function testExpectsNoArgumentsThrowsExceptionIfAnyPassed()
    {
        $this->spy->foo();
        $this->spy->assertReceived('foo')->with(1);
    }
    
    public function testExpectsAnyArgumentsWhenNoneGiven()
    {
        $this->spy->foo();
        $this->spy->assertReceived('foo');
    }
    
    public function testExpectsAnyArgumentsWhenOneGiven()
    {
        $this->spy->foo(1);
        $this->spy->assertReceived('foo');
    }
    
    public function testExpectsAnyArgumentsWhenManyGiven()
    {
        $this->spy->foo(1, 'k', new stdClass);
        $this->spy->assertReceived('foo');
    }
    
    public function testAnyArgs()
    {
        $this->markTestIncomplete();
    }
    
    public function testExpectsArgumentMatchingRegularExpression()
    {
        $this->spy->foo('xxBARxx');
        $this->spy->assertReceived('foo')->with('/bar/i');
    }
    
    public function testExpectsArgumentMatchingObjectType()
    {
        $this->spy->foo(new stdClass);
        $this->spy->assertReceived('foo')->with('\stdClass');
    }
    
    /**
     * @expectedException \Mockery\Exception
     */
    public function testThrowsExceptionOnNoArgumentMatch()
    {
        $this->spy->foo(2);
        $this->spy->assertReceived('foo')->with(1);
    }
    
    public function testNeverCalled()
    {
        $this->spy->assertNeverReceived('foo');
    }
    
    /**
     * @expectedException \Mockery\Exception
     */
    public function testNeverCalledThrowsExceptionOnCall()
    {
        $this->spy->foo();
        $this->spy->assertNeverReceived('foo');
    }
    
    /*public function testCalledOnce()
    {
        $this->spy->whenReceives('foo')->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfNotCalled()
    {
        $this->spy->whenReceives('foo')->once();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfCalledTwice()
    {
        $this->spy->whenReceives('foo')->once();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledTwice()
    {
        $this->spy->whenReceives('foo')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledTwiceThrowsExceptionIfNotCalled()
    {
        $this->spy->whenReceives('foo')->twice();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfCalledThreeTimes()
    {
        $this->spy->whenReceives('foo')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledZeroOrMoreTimesAtZeroCalls()
    {
        $this->spy->whenReceives('foo')->zeroOrMoreTimes();
        $this->container->mockery_verify();
    }
    
    public function testCalledZeroOrMoreTimesAtThreeCalls()
    {
        $this->spy->whenReceives('foo')->zeroOrMoreTimes();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testTimesCountCalls()
    {
        $this->spy->whenReceives('foo')->times(4);
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testTimesCountCallThrowsExceptionOnTooFewCalls()
    {
        $this->spy->whenReceives('foo')->times(2);
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testTimesCountCallThrowsExceptionOnTooManyCalls()
    {
        $this->spy->whenReceives('foo')->times(2);
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtLeastOnceAtExactlyOneCall()
    {
        $this->spy->whenReceives('foo')->atLeast()->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtLeastOnceAtExactlyThreeCalls()
    {
        $this->spy->whenReceives('foo')->atLeast()->times(3);
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledAtLeastThrowsExceptionOnTooFewCalls()
    {
        $this->spy->whenReceives('foo')->atLeast()->twice();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtMostOnceAtExactlyOneCall()
    {
        $this->spy->whenReceives('foo')->atMost()->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtMostAtExactlyThreeCalls()
    {
        $this->spy->whenReceives('foo')->atMost()->times(3);
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledAtLeastThrowsExceptionOnTooManyCalls()
    {
        $this->spy->whenReceives('foo')->atMost()->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testExactCountersOverrideAnyPriorSetNonExactCounters()
    {
        $this->spy->whenReceives('foo')->atLeast()->once()->once();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testComboOfLeastAndMostCallsWithOneCall()
    {
        $this->spy->whenReceives('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }
    
    public function testComboOfLeastAndMostCallsWithTwoCalls()
    {
        $this->spy->whenReceives('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testComboOfLeastAndMostCallsThrowsExceptionAtTooFewCalls()
    {
        $this->spy->whenReceives('foo')->atleast()->once()->atMost()->twice();
        $this->container->mockery_verify(); 
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testComboOfLeastAndMostCallsThrowsExceptionAtTooManyCalls()
    {
        $this->spy->whenReceives('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }
    
    public function testCallCountingOnlyAppliesToMatchedExpectations()
    {
        $this->spy->whenReceives('foo')->with(1)->once();
        $this->spy->whenReceives('foo')->with(2)->twice();
        $this->spy->whenReceives('foo')->with(3);
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->spy->foo(2);
        $this->spy->foo(3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCallCountingThrowsExceptionOnAnyMismatch()
    {
        $this->spy->whenReceives('foo')->with(1)->once();
        $this->spy->whenReceives('foo')->with(2)->twice();
        $this->spy->whenReceives('foo')->with(3);
        $this->spy->whenReceives('bar');
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->spy->foo(3);
        $this->spy->bar();
        $this->container->mockery_verify();
    }
    
    public function testOrderedCallsWithoutError()
    {
        $this->spy->whenReceives('foo')->ordered();
        $this->spy->whenReceives('bar')->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOrderedCallsWithOutOfOrderError()
    {
        $this->spy->whenReceives('foo')->ordered();
        $this->spy->whenReceives('bar')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDifferentArgumentsAndOrderingsPassWithoutException()
    {
        $this->spy->whenReceives('foo')->with(1)->ordered();
        $this->spy->whenReceives('foo')->with(2)->ordered();
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testDifferentArgumentsAndOrderingsThrowExceptionWhenInWrongOrder()
    {
        $this->spy->whenReceives('foo')->with(1)->ordered();
        $this->spy->whenReceives('foo')->with(2)->ordered();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testUnorderedCallsIgnoredForOrdering()
    {
        $this->spy->whenReceives('foo')->with(1)->ordered();
        $this->spy->whenReceives('foo')->with(2);
        $this->spy->whenReceives('foo')->with(3)->ordered();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->spy->foo(3);
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testOrderingOfDefaultGrouping()
    {
        $this->spy->whenReceives('foo')->ordered();
        $this->spy->whenReceives('bar')->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOrderingOfDefaultGroupingThrowsExceptionOnWrongOrder()
    {
        $this->spy->whenReceives('foo')->ordered();
        $this->spy->whenReceives('bar')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testOrderingUsingNumberedGroups()
    {
        $this->spy->whenReceives('start')->ordered(1);
        $this->spy->whenReceives('foo')->ordered(2);
        $this->spy->whenReceives('bar')->ordered(2);
        $this->spy->whenReceives('final')->ordered();
        $this->spy->start();
        $this->spy->bar();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->final();
        $this->container->mockery_verify();
    }*/
    
    /*public function testOrderingUsingNamedGroups()
    {
        $this->spy->whenReceives('start')->ordered('start');
        $this->spy->whenReceives('foo')->ordered('foobar');
        $this->spy->whenReceives('bar')->ordered('foobar');
        $this->spy->whenReceives('final')->ordered();
        $this->spy->start();
        $this->spy->bar();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->final();
        $this->container->mockery_verify();
    }
    
    public function testGroupedUngroupedOrderingDoNotOverlap()
    {
        $s = $this->spy->whenReceives('start')->ordered();
        $m = $this->spy->whenReceives('mid')->ordered('foobar');
        $e = $this->spy->whenReceives('end')->ordered();
        $this->assertTrue($s->getOrderNumber() < $m->getOrderNumber());
        $this->assertTrue($m->getOrderNumber() < $e->getOrderNumber());
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testGroupedOrderingThrowsExceptionWhenCallsDisordered()
    {
        $this->spy->whenReceives('foo')->ordered('first');
        $this->spy->whenReceives('bar')->ordered('second');
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testExpectationMatchingWithNoArgsOrderings()
    {
        $this->spy->whenReceives('foo')->withNoArgs()->once()->ordered();
        $this->spy->whenReceives('bar')->withNoArgs()->once()->ordered();
        $this->spy->whenReceives('foo')->withNoArgs()->once()->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testExpectationMatchingWithAnyArgsOrderings()
    {
        $this->spy->whenReceives('foo')->withAnyArgs()->once()->ordered();
        $this->spy->whenReceives('bar')->withAnyArgs()->once()->ordered();
        $this->spy->whenReceives('foo')->withAnyArgs()->once()->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testEnsuresOrderingIsNotCrossMockByDefault()
    {
        $this->spy->whenReceives('foo')->ordered();
        $mock2 = $this->container->mock('bar');
        $mock2->whenReceives('bar')->ordered();
        $mock2->bar();
        $this->spy->foo();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testEnsuresOrderingIsCrossMockWhenGloballyFlagSet()
    {
        $this->spy->whenReceives('foo')->globally()->ordered();
        $mock2 = $this->container->mock('bar');
        $mock2->whenReceives('bar')->globally()->ordered();
        $mock2->bar();
        $this->spy->foo();
    }
    
    public function testExpectationCastToStringFormatting()
    {
        $exp = $this->spy->whenReceives('foo')->with(1, 'bar', new stdClass, array());
        $this->assertEquals('[foo(1, "bar", stdClass, Array)]', (string) $exp);
    }
    
    public function testMultipleExpectationCastToStringFormatting()
    {
        $exp = $this->spy->whenReceives('foo', 'bar')->with(1);
        $this->assertEquals('[foo(1), bar(1)]', (string) $exp);
    }
    
    public function testGroupedOrderingWithLimitsAllowsMultipleReturnValues()
    {
        $this->spy->whenReceives('foo')->with(2)->once()->thenReturn('first');
        $this->spy->whenReceives('foo')->with(2)->twice()->thenReturn('second/third');
        $this->spy->whenReceives('foo')->with(2)->thenReturn('infinity');
        $this->assertEquals('first', $this->spy->foo(2));
        $this->assertEquals('second/third', $this->spy->foo(2));
        $this->assertEquals('second/third', $this->spy->foo(2));
        $this->assertEquals('infinity', $this->spy->foo(2));
        $this->assertEquals('infinity', $this->spy->foo(2));
        $this->assertEquals('infinity', $this->spy->foo(2));
        $this->container->mockery_verify();
    }
    
    public function testExpectationsCanBeMarkedAsDefaults()
    {
        $this->spy->whenReceives('foo')->thenReturn('bar')->byDefault();
        $this->assertEquals('bar', $this->spy->foo());
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsValidatedInCorrectOrder()
    {
        $this->spy->whenReceives('foo')->with(1)->once()->thenReturn('first')->byDefault();
        $this->spy->whenReceives('foo')->with(2)->once()->thenReturn('second')->byDefault();
        $this->assertEquals('first', $this->spy->foo(1));
        $this->assertEquals('second', $this->spy->foo(2));
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsAreReplacedByLaterConcreteExpectations()
    {
        $this->spy->whenReceives('foo')->thenReturn('bar')->once()->byDefault();
        $this->spy->whenReceives('foo')->thenReturn('bar')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsCanBeChangedByLaterExpectations()
    {
        $this->spy->whenReceives('foo')->with(1)->thenReturn('bar')->once()->byDefault();
        $this->spy->whenReceives('foo')->with(2)->thenReturn('baz')->once();
        try {
            $this->spy->foo(1);
            $this->fail('Expected exception not thrown');
        } catch (\Mockery\Exception $e) {}
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testDefaultExpectationsCanBeOrdered()
    {
        $this->spy->whenReceives('foo')->ordered()->byDefault();
        $this->spy->whenReceives('bar')->ordered()->byDefault();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsCanBeOrderedAndReplaced()
    {
        $this->spy->whenReceives('foo')->ordered()->byDefault();
        $this->spy->whenReceives('bar')->ordered()->byDefault();
        $this->spy->whenReceives('bar')->ordered();
        $this->spy->whenReceives('foo')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testByDefaultOperatesFromMockConstruction()
    {
        $container = new \Mockery\Container;
        $mock = $container->mock('f', array('foo'=>'rfoo','bar'=>'rbar','baz'=>'rbaz'))->byDefault();
        $mock->whenReceives('foo')->thenReturn('foobar');
        $this->assertEquals('foobar', $mock->foo());
        $this->assertEquals('rbar', $mock->bar());
        $this->assertEquals('rbaz', $mock->baz());
        $mock->mockery_verify();
    }
    
    public function testByDefaultOnAMockDoesSquatWithoutExpectations()
    {
        $container = new \Mockery\Container;
        $mock = $container->mock('f')->byDefault();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testByDefaultPreventedFromSettingDefaultWhenDefaultingExpectationWasReplaced()
    {
        $exp = $this->spy->whenReceives('foo')->thenReturn(1);
        $this->spy->whenReceives('foo')->thenReturn(2);
        $exp->byDefault();
    }
    
    public function testAnyConstraintMatchesAnyArg()
    {
        $this->spy->whenReceives('foo')->with(1, Mockery::any())->twice();
        $this->spy->foo(1, 2);
        $this->spy->foo(1, 'str');
        $this->container->mockery_verify();
    }
    
    public function testAnyConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::any())->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }
    
    public function testArrayConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('array'))->once();
        $this->spy->foo(array());
        $this->container->mockery_verify();
    }
    
    public function testArrayConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('array'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testArrayConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('array'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testBoolConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('bool'))->once();
        $this->spy->foo(true);
        $this->container->mockery_verify();
    }
    
    public function testBoolConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('bool'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testBoolConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('bool'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testCallableConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('callable'))->once();
        $this->spy->foo(function(){return 'f';});
        $this->container->mockery_verify();
    }
    
    public function testCallableConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('callable'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testCallableConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('callable'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testDoubleConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('double'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testDoubleConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('double'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testDoubleConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('double'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testFloatConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('float'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testFloatConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('float'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testFloatConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('float'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testIntConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('int'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testIntConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('int'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testIntConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('int'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testLongConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('long'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testLongConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('long'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testLongConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('long'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testNullConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('null'))->once();
        $this->spy->foo(null);
        $this->container->mockery_verify();
    }
    
    public function testNullConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('null'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testNullConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('null'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testNumericConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('numeric'))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testNumericConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('numeric'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testNumericConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('numeric'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testObjectConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('object'))->once();
        $this->spy->foo(new stdClass);
        $this->container->mockery_verify();
    }
    
    public function testObjectConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('object`'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testObjectConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('object'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testRealConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('real'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testRealConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('real'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testRealConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('real'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testResourceConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('resource'))->once();
        $r = fopen(dirname(__FILE__) . '/_files/file.txt', 'r');
        $this->spy->foo($r);
        $this->container->mockery_verify();
    }
    
    public function testResourceConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('resource'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testResourceConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('resource'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testScalarConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('scalar'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testScalarConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('scalar'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testScalarConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('scalar'))->once();
        $this->spy->foo(array());
        $this->container->mockery_verify();
    }
    
    public function testStringConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('string'))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testStringConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('string'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testStringConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('string'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testClassConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('stdClass'))->once();
        $this->spy->foo(new stdClass);
        $this->container->mockery_verify();
    }
    
    public function testClassConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::type('stdClass'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testClassConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::type('stdClass'))->once();
        $this->spy->foo(new Exception);
        $this->container->mockery_verify();
    }
    
    public function testDucktypeConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::ducktype('quack', 'swim'))->once();
        $this->spy->foo(new Mockery_Duck);
        $this->container->mockery_verify();
    }
    
    public function testDucktypeConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::ducktype('quack', 'swim'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testDucktypeConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::ducktype('quack', 'swim'))->once();
        $this->spy->foo(new Mockery_Duck_Nonswimmer);
        $this->container->mockery_verify();
    }
    
    public function testArrayContentConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::subset(array('a'=>1,'b'=>2)))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testArrayContentConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::subset(array('a'=>1,'b'=>2)))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testArrayContentConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::subset(array('a'=>1,'b'=>2)))->once();
        $this->spy->foo(array('a'=>1,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testContainsConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::contains(1, 2))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testContainsConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::contains(1, 2))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testContainsConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::contains(1, 2))->once();
        $this->spy->foo(array('a'=>1,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasKeyConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::hasKey('c'))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasKeyConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::hasKey('a'))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, array('a'=>1), 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testHasKeyConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::hasKey('c'))->once();
        $this->spy->foo(array('a'=>1,'b'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasValueConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::hasValue(1))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasValueConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::hasValue(1))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, array('a'=>1), 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testHasValueConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::hasValue(2))->once();
        $this->spy->foo(array('a'=>1,'b'=>3));
        $this->container->mockery_verify();
    }
    
    public function testOnConstraintMatchesArgument_ClosureEvaluatesToTrue()
    {
        $function = function($arg){return $arg % 2 == 0;};
        $this->spy->whenReceives('foo')->with(Mockery::on($function))->once();
        $this->spy->foo(4);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOnConstraintThrowsExceptionWhenConstraintUnmatched_ClosureEvaluatesToFalse()
    {
        $function = function($arg){return $arg % 2 == 0;};
        $this->spy->whenReceives('foo')->with(Mockery::on($function))->once();
        $this->spy->foo(5);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::mustBe(2))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::mustBe(2))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testMustBeConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::mustBe(2))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintMatchesObjectArgumentWithEqualsComparisonNotIdentical()
    {
        $a = new stdClass; $a->foo = 1;
        $b = new stdClass; $b->foo = 1;
        $this->spy->whenReceives('foo')->with(Mockery::mustBe($a))->once();
        $this->spy->foo($b);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintNonMatchingCaseWithObject()
    {
        $a = new stdClass; $a->foo = 1;
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::mustBe($a))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, $a, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testMustBeConstraintThrowsExceptionWhenConstraintUnmatchedWithObject()
    {
        $a = new stdClass; $a->foo = 1;
        $b = new stdClass; $b->foo = 2;
        $this->spy->whenReceives('foo')->with(Mockery::mustBe($a))->once();
        $this->spy->foo($b);
        $this->container->mockery_verify();
    }
    
    public function testMatchPrecedenceBasedOnExpectedCallsFavouringExplicitMatch()
    {
        $this->spy->whenReceives('foo')->with(1)->once();
        $this->spy->whenReceives('foo')->with(Mockery::any())->never();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testMatchPrecedenceBasedOnExpectedCallsFavouringAnyMatch()
    {
        $this->spy->whenReceives('foo')->with(Mockery::any())->once();
        $this->spy->whenReceives('foo')->with(1)->never();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testReturnUndefinedIfIgnoreMissingMethodsSet()
    {
        $this->spy->shouldIgnoreMissing();
        $this->assertTrue($this->spy->g(1,2) instanceof \Mockery\Undefined);
    }
    
    public function testReturnUndefinedAllowsForInfiniteSelfReturningChain()
    {
        $this->spy->shouldIgnoreMissing();
        $this->assertTrue($this->spy->g(1,2)->a()->b()->c() instanceof \Mockery\Undefined);
    }
    
    public function testOptionalMockRetrieval()
    {
        $m = $this->container->mock('f')->whenReceives('foo')->with(1)->thenReturn(3)->mock();
        $this->assertTrue($m instanceof \Mockery\MockInterface);
    }
    
    public function testNotConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::not(1))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testNotConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::not(2))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testNotConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::not(2))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }

    public function testAnyOfConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::anyOf(1, 2))->twice();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testAnyOfConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::anyOf(1, 2))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testAnyOfConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::anyOf(1, 2))->once();
        $this->spy->foo(3);
        $this->container->mockery_verify();
    }
    
    public function testNotAnyOfConstraintMatchesArgument()
    {
        $this->spy->whenReceives('foo')->with(Mockery::notAnyOf(1, 2))->once();
        $this->spy->foo(3);
        $this->container->mockery_verify();
    }
    
    public function testNotAnyOfConstraintNonMatchingCase()
    {
        $this->spy->whenReceives('foo')->times(3);
        $this->spy->whenReceives('foo')->with(1, Mockery::notAnyOf(1, 2))->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 4, 3);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testNotAnyOfConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->spy->whenReceives('foo')->with(Mockery::notAnyOf(1, 2))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testGlobalConfigMayForbidMockingNonExistentMethodsOnClasses()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = $this->container->mock('stdClass');
        $mock->whenReceives('foo');
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testGlobalConfigMayForbidMockingNonExistentMethodsOnObjects()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = $this->container->mock(new stdClass);
        $mock->whenReceives('foo');
    }*/
    
}

class MockerySpy_Duck {
    function quack(){}
    function swim(){}
}

class MockerySpy_Duck_Nonswimmer {
    function quack(){}
}
