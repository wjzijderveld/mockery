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
        $this->spy->shouldReceive('foo');
        $this->assertNull($this->spy->foo());
    }
    
    /*public function testReturnsNullWhenSingleArg()
    {
        $this->spy->shouldReceive('foo');
        $this->assertNull($this->spy->foo(1));
    }
    
    public function testReturnsNullWhenManyArgs()
    {
        $this->spy->shouldReceive('foo');
        $this->assertNull($this->spy->foo('foo', array(), new stdClass));
    }
    
    public function testReturnsSameValueForAllIfNoArgsExpectationAndNoneGiven()
    {
        $this->spy->shouldReceive('foo')->andReturn(1);
        $this->assertEquals(1, $this->spy->foo());
    }
    
    public function testReturnsSameValueForAllIfNoArgsExpectationAndSomeGiven()
    {
        $this->spy->shouldReceive('foo')->andReturn(1);
        $this->assertEquals(1, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentially()
    {
        $this->spy->shouldReceive('foo')->andReturn(1, 2, 3);
        $this->spy->foo('foo');
        $this->assertEquals(2, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCalls()
    {
        $this->spy->shouldReceive('foo')->andReturn(1, 2, 3);
        $this->spy->foo('foo');
        $this->spy->foo('foo');
        $this->assertEquals(3, $this->spy->foo('foo'));
        $this->assertEquals(3, $this->spy->foo('foo'));
    }
    
    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCallsWithManyAndReturnCalls()
    {
        $this->spy->shouldReceive('foo')->andReturn(1)->andReturn(2, 3);
        $this->spy->foo('foo');
        $this->spy->foo('foo');
        $this->assertEquals(3, $this->spy->foo('foo'));
        $this->assertEquals(3, $this->spy->foo('foo'));
    }

    public function testReturnsValueOfClosure()
    {
        $this->spy->shouldReceive('foo')->with(5)->andReturnUsing(function($v){return $v+1;});
        $this->assertEquals(6, $this->spy->foo(5));
    }
    
    public function testReturnsUndefined()
    {
        $this->spy->shouldReceive('foo')->andReturnUndefined();
        $this->assertTrue($this->spy->foo() instanceof \Mockery\Undefined);
    }*/
    
    /**
     * @expectedException OutOfBoundsException
     */
    /*public function testThrowsException()
    {
        $this->spy->shouldReceive('foo')->andThrow(new OutOfBoundsException);
        $this->spy->foo();
    }*/
    
    /**
     * @expectedException OutOfBoundsException
     */
    /*public function testThrowsExceptionBasedOnArgs()
    {
        $this->spy->shouldReceive('foo')->andThrow('OutOfBoundsException');
        $this->spy->foo();
    }
    
    public function testThrowsExceptionBasedOnArgsWithMessage()
    {
        $this->spy->shouldReceive('foo')->andThrow('OutOfBoundsException', 'foo');
        try {
            $this->spy->foo();
        } catch (OutOfBoundsException $e) {
            $this->assertEquals('foo', $e->getMessage());
        }
    }*/
    
    /**
     * @expectedException OutOfBoundsException
     */
    /*public function testThrowsExceptionSequentially()
    {
        $this->spy->shouldReceive('foo')->andThrow(new Exception)->andThrow(new OutOfBoundsException);
        try {
            $this->spy->foo();
        } catch (Exception $e) {}
        $this->spy->foo();
    }
    
    public function testMultipleExpectationsWithReturns()
    {
        $this->spy->shouldReceive('foo')->with(1)->andReturn(10);
        $this->spy->shouldReceive('bar')->with(2)->andReturn(20);
        $this->assertEquals(10, $this->spy->foo(1));
        $this->assertEquals(20, $this->spy->bar(2));
    }
    
    public function testExpectsNoArguments()
    {
        $this->spy->shouldReceive('foo')->withNoArgs();
        $this->spy->foo();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testExpectsNoArgumentsThrowsExceptionIfAnyPassed()
    {
        $this->spy->shouldReceive('foo')->withNoArgs();
        $this->spy->foo(1);
    }
    
    public function testExpectsAnyArguments()
    {
        $this->spy->shouldReceive('foo')->withAnyArgs();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 'k', new stdClass);
    }
    
    public function testExpectsArgumentMatchingRegularExpression()
    {
        $this->spy->shouldReceive('foo')->with('/bar/i');
        $this->spy->foo('xxBARxx');
    }
    
    public function testExpectsArgumentMatchingObjectType()
    {
        $this->spy->shouldReceive('foo')->with('\stdClass');
        $this->spy->foo(new stdClass);
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testThrowsExceptionOnNoArgumentMatch()
    {
        $this->spy->shouldReceive('foo')->with(1);
        $this->spy->foo(2);
    }
    
    public function testNeverCalled()
    {
        $this->spy->shouldReceive('foo')->never();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testNeverCalledThrowsExceptionOnCall()
    {
        $this->spy->shouldReceive('foo')->never();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledOnce()
    {
        $this->spy->shouldReceive('foo')->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfNotCalled()
    {
        $this->spy->shouldReceive('foo')->once();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfCalledTwice()
    {
        $this->spy->shouldReceive('foo')->once();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledTwice()
    {
        $this->spy->shouldReceive('foo')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledTwiceThrowsExceptionIfNotCalled()
    {
        $this->spy->shouldReceive('foo')->twice();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testCalledOnceThrowsExceptionIfCalledThreeTimes()
    {
        $this->spy->shouldReceive('foo')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledZeroOrMoreTimesAtZeroCalls()
    {
        $this->spy->shouldReceive('foo')->zeroOrMoreTimes();
        $this->container->mockery_verify();
    }
    
    public function testCalledZeroOrMoreTimesAtThreeCalls()
    {
        $this->spy->shouldReceive('foo')->zeroOrMoreTimes();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testTimesCountCalls()
    {
        $this->spy->shouldReceive('foo')->times(4);
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
        $this->spy->shouldReceive('foo')->times(2);
        $this->spy->foo();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testTimesCountCallThrowsExceptionOnTooManyCalls()
    {
        $this->spy->shouldReceive('foo')->times(2);
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtLeastOnceAtExactlyOneCall()
    {
        $this->spy->shouldReceive('foo')->atLeast()->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtLeastOnceAtExactlyThreeCalls()
    {
        $this->spy->shouldReceive('foo')->atLeast()->times(3);
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
        $this->spy->shouldReceive('foo')->atLeast()->twice();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtMostOnceAtExactlyOneCall()
    {
        $this->spy->shouldReceive('foo')->atMost()->once();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testCalledAtMostAtExactlyThreeCalls()
    {
        $this->spy->shouldReceive('foo')->atMost()->times(3);
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
        $this->spy->shouldReceive('foo')->atMost()->twice();
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
        $this->spy->shouldReceive('foo')->atLeast()->once()->once();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testComboOfLeastAndMostCallsWithOneCall()
    {
        $this->spy->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }
    
    public function testComboOfLeastAndMostCallsWithTwoCalls()
    {
        $this->spy->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testComboOfLeastAndMostCallsThrowsExceptionAtTooFewCalls()
    {
        $this->spy->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->container->mockery_verify(); 
    }*/
    
    /**
     * @expectedException \Mockery\CountValidator\Exception
     */
    /*public function testComboOfLeastAndMostCallsThrowsExceptionAtTooManyCalls()
    {
        $this->spy->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify(); 
    }
    
    public function testCallCountingOnlyAppliesToMatchedExpectations()
    {
        $this->spy->shouldReceive('foo')->with(1)->once();
        $this->spy->shouldReceive('foo')->with(2)->twice();
        $this->spy->shouldReceive('foo')->with(3);
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
        $this->spy->shouldReceive('foo')->with(1)->once();
        $this->spy->shouldReceive('foo')->with(2)->twice();
        $this->spy->shouldReceive('foo')->with(3);
        $this->spy->shouldReceive('bar');
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->spy->foo(3);
        $this->spy->bar();
        $this->container->mockery_verify();
    }
    
    public function testOrderedCallsWithoutError()
    {
        $this->spy->shouldReceive('foo')->ordered();
        $this->spy->shouldReceive('bar')->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOrderedCallsWithOutOfOrderError()
    {
        $this->spy->shouldReceive('foo')->ordered();
        $this->spy->shouldReceive('bar')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDifferentArgumentsAndOrderingsPassWithoutException()
    {
        $this->spy->shouldReceive('foo')->with(1)->ordered();
        $this->spy->shouldReceive('foo')->with(2)->ordered();
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testDifferentArgumentsAndOrderingsThrowExceptionWhenInWrongOrder()
    {
        $this->spy->shouldReceive('foo')->with(1)->ordered();
        $this->spy->shouldReceive('foo')->with(2)->ordered();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testUnorderedCallsIgnoredForOrdering()
    {
        $this->spy->shouldReceive('foo')->with(1)->ordered();
        $this->spy->shouldReceive('foo')->with(2);
        $this->spy->shouldReceive('foo')->with(3)->ordered();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->spy->foo(2);
        $this->spy->foo(3);
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testOrderingOfDefaultGrouping()
    {
        $this->spy->shouldReceive('foo')->ordered();
        $this->spy->shouldReceive('bar')->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOrderingOfDefaultGroupingThrowsExceptionOnWrongOrder()
    {
        $this->spy->shouldReceive('foo')->ordered();
        $this->spy->shouldReceive('bar')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testOrderingUsingNumberedGroups()
    {
        $this->spy->shouldReceive('start')->ordered(1);
        $this->spy->shouldReceive('foo')->ordered(2);
        $this->spy->shouldReceive('bar')->ordered(2);
        $this->spy->shouldReceive('final')->ordered();
        $this->spy->start();
        $this->spy->bar();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->final();
        $this->container->mockery_verify();
    }*/
    
    /*public function testOrderingUsingNamedGroups()
    {
        $this->spy->shouldReceive('start')->ordered('start');
        $this->spy->shouldReceive('foo')->ordered('foobar');
        $this->spy->shouldReceive('bar')->ordered('foobar');
        $this->spy->shouldReceive('final')->ordered();
        $this->spy->start();
        $this->spy->bar();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->final();
        $this->container->mockery_verify();
    }
    
    public function testGroupedUngroupedOrderingDoNotOverlap()
    {
        $s = $this->spy->shouldReceive('start')->ordered();
        $m = $this->spy->shouldReceive('mid')->ordered('foobar');
        $e = $this->spy->shouldReceive('end')->ordered();
        $this->assertTrue($s->getOrderNumber() < $m->getOrderNumber());
        $this->assertTrue($m->getOrderNumber() < $e->getOrderNumber());
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testGroupedOrderingThrowsExceptionWhenCallsDisordered()
    {
        $this->spy->shouldReceive('foo')->ordered('first');
        $this->spy->shouldReceive('bar')->ordered('second');
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testExpectationMatchingWithNoArgsOrderings()
    {
        $this->spy->shouldReceive('foo')->withNoArgs()->once()->ordered();
        $this->spy->shouldReceive('bar')->withNoArgs()->once()->ordered();
        $this->spy->shouldReceive('foo')->withNoArgs()->once()->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testExpectationMatchingWithAnyArgsOrderings()
    {
        $this->spy->shouldReceive('foo')->withAnyArgs()->once()->ordered();
        $this->spy->shouldReceive('bar')->withAnyArgs()->once()->ordered();
        $this->spy->shouldReceive('foo')->withAnyArgs()->once()->ordered();
        $this->spy->foo();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testEnsuresOrderingIsNotCrossMockByDefault()
    {
        $this->spy->shouldReceive('foo')->ordered();
        $mock2 = $this->container->mock('bar');
        $mock2->shouldReceive('bar')->ordered();
        $mock2->bar();
        $this->spy->foo();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testEnsuresOrderingIsCrossMockWhenGloballyFlagSet()
    {
        $this->spy->shouldReceive('foo')->globally()->ordered();
        $mock2 = $this->container->mock('bar');
        $mock2->shouldReceive('bar')->globally()->ordered();
        $mock2->bar();
        $this->spy->foo();
    }
    
    public function testExpectationCastToStringFormatting()
    {
        $exp = $this->spy->shouldReceive('foo')->with(1, 'bar', new stdClass, array());
        $this->assertEquals('[foo(1, "bar", stdClass, Array)]', (string) $exp);
    }
    
    public function testMultipleExpectationCastToStringFormatting()
    {
        $exp = $this->spy->shouldReceive('foo', 'bar')->with(1);
        $this->assertEquals('[foo(1), bar(1)]', (string) $exp);
    }
    
    public function testGroupedOrderingWithLimitsAllowsMultipleReturnValues()
    {
        $this->spy->shouldReceive('foo')->with(2)->once()->andReturn('first');
        $this->spy->shouldReceive('foo')->with(2)->twice()->andReturn('second/third');
        $this->spy->shouldReceive('foo')->with(2)->andReturn('infinity');
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
        $this->spy->shouldReceive('foo')->andReturn('bar')->byDefault();
        $this->assertEquals('bar', $this->spy->foo());
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsValidatedInCorrectOrder()
    {
        $this->spy->shouldReceive('foo')->with(1)->once()->andReturn('first')->byDefault();
        $this->spy->shouldReceive('foo')->with(2)->once()->andReturn('second')->byDefault();
        $this->assertEquals('first', $this->spy->foo(1));
        $this->assertEquals('second', $this->spy->foo(2));
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsAreReplacedByLaterConcreteExpectations()
    {
        $this->spy->shouldReceive('foo')->andReturn('bar')->once()->byDefault();
        $this->spy->shouldReceive('foo')->andReturn('bar')->twice();
        $this->spy->foo();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsCanBeChangedByLaterExpectations()
    {
        $this->spy->shouldReceive('foo')->with(1)->andReturn('bar')->once()->byDefault();
        $this->spy->shouldReceive('foo')->with(2)->andReturn('baz')->once();
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
        $this->spy->shouldReceive('foo')->ordered()->byDefault();
        $this->spy->shouldReceive('bar')->ordered()->byDefault();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testDefaultExpectationsCanBeOrderedAndReplaced()
    {
        $this->spy->shouldReceive('foo')->ordered()->byDefault();
        $this->spy->shouldReceive('bar')->ordered()->byDefault();
        $this->spy->shouldReceive('bar')->ordered();
        $this->spy->shouldReceive('foo')->ordered();
        $this->spy->bar();
        $this->spy->foo();
        $this->container->mockery_verify();
    }
    
    public function testByDefaultOperatesFromMockConstruction()
    {
        $container = new \Mockery\Container;
        $mock = $container->mock('f', array('foo'=>'rfoo','bar'=>'rbar','baz'=>'rbaz'))->byDefault();
        $mock->shouldReceive('foo')->andReturn('foobar');
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
        $exp = $this->spy->shouldReceive('foo')->andReturn(1);
        $this->spy->shouldReceive('foo')->andReturn(2);
        $exp->byDefault();
    }
    
    public function testAnyConstraintMatchesAnyArg()
    {
        $this->spy->shouldReceive('foo')->with(1, Mockery::any())->twice();
        $this->spy->foo(1, 2);
        $this->spy->foo(1, 'str');
        $this->container->mockery_verify();
    }
    
    public function testAnyConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::any())->never();
        $this->spy->foo();
        $this->spy->foo(1);
        $this->spy->foo(1, 2, 3);
        $this->container->mockery_verify();
    }
    
    public function testArrayConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('array'))->once();
        $this->spy->foo(array());
        $this->container->mockery_verify();
    }
    
    public function testArrayConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('array'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('array'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testBoolConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('bool'))->once();
        $this->spy->foo(true);
        $this->container->mockery_verify();
    }
    
    public function testBoolConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('bool'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('bool'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testCallableConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('callable'))->once();
        $this->spy->foo(function(){return 'f';});
        $this->container->mockery_verify();
    }
    
    public function testCallableConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('callable'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('callable'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testDoubleConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('double'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testDoubleConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('double'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('double'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testFloatConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('float'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testFloatConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('float'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('float'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testIntConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('int'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testIntConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('int'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('int'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testLongConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('long'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testLongConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('long'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('long'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testNullConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('null'))->once();
        $this->spy->foo(null);
        $this->container->mockery_verify();
    }
    
    public function testNullConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('null'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('null'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testNumericConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('numeric'))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testNumericConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('numeric'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('numeric'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testObjectConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('object'))->once();
        $this->spy->foo(new stdClass);
        $this->container->mockery_verify();
    }
    
    public function testObjectConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('object`'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('object'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testRealConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('real'))->once();
        $this->spy->foo(2.25);
        $this->container->mockery_verify();
    }
    
    public function testRealConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('real'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('real'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testResourceConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('resource'))->once();
        $r = fopen(dirname(__FILE__) . '/_files/file.txt', 'r');
        $this->spy->foo($r);
        $this->container->mockery_verify();
    }
    
    public function testResourceConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('resource'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('resource'))->once();
        $this->spy->foo('f');
        $this->container->mockery_verify();
    }
    
    public function testScalarConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('scalar'))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testScalarConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('scalar'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('scalar'))->once();
        $this->spy->foo(array());
        $this->container->mockery_verify();
    }
    
    public function testStringConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('string'))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testStringConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('string'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('string'))->once();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testClassConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::type('stdClass'))->once();
        $this->spy->foo(new stdClass);
        $this->container->mockery_verify();
    }
    
    public function testClassConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::type('stdClass'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::type('stdClass'))->once();
        $this->spy->foo(new Exception);
        $this->container->mockery_verify();
    }
    
    public function testDucktypeConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::ducktype('quack', 'swim'))->once();
        $this->spy->foo(new Mockery_Duck);
        $this->container->mockery_verify();
    }
    
    public function testDucktypeConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::ducktype('quack', 'swim'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::ducktype('quack', 'swim'))->once();
        $this->spy->foo(new Mockery_Duck_Nonswimmer);
        $this->container->mockery_verify();
    }
    
    public function testArrayContentConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::subset(array('a'=>1,'b'=>2)))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testArrayContentConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::subset(array('a'=>1,'b'=>2)))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::subset(array('a'=>1,'b'=>2)))->once();
        $this->spy->foo(array('a'=>1,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testContainsConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::contains(1, 2))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testContainsConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::contains(1, 2))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::contains(1, 2))->once();
        $this->spy->foo(array('a'=>1,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasKeyConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::hasKey('c'))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasKeyConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::hasKey('a'))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::hasKey('c'))->once();
        $this->spy->foo(array('a'=>1,'b'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasValueConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::hasValue(1))->once();
        $this->spy->foo(array('a'=>1,'b'=>2,'c'=>3));
        $this->container->mockery_verify();
    }
    
    public function testHasValueConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::hasValue(1))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::hasValue(2))->once();
        $this->spy->foo(array('a'=>1,'b'=>3));
        $this->container->mockery_verify();
    }
    
    public function testOnConstraintMatchesArgument_ClosureEvaluatesToTrue()
    {
        $function = function($arg){return $arg % 2 == 0;};
        $this->spy->shouldReceive('foo')->with(Mockery::on($function))->once();
        $this->spy->foo(4);
        $this->container->mockery_verify();
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testOnConstraintThrowsExceptionWhenConstraintUnmatched_ClosureEvaluatesToFalse()
    {
        $function = function($arg){return $arg % 2 == 0;};
        $this->spy->shouldReceive('foo')->with(Mockery::on($function))->once();
        $this->spy->foo(5);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::mustBe(2))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::mustBe(2))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::mustBe(2))->once();
        $this->spy->foo('2');
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintMatchesObjectArgumentWithEqualsComparisonNotIdentical()
    {
        $a = new stdClass; $a->foo = 1;
        $b = new stdClass; $b->foo = 1;
        $this->spy->shouldReceive('foo')->with(Mockery::mustBe($a))->once();
        $this->spy->foo($b);
        $this->container->mockery_verify();
    }
    
    public function testMustBeConstraintNonMatchingCaseWithObject()
    {
        $a = new stdClass; $a->foo = 1;
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::mustBe($a))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::mustBe($a))->once();
        $this->spy->foo($b);
        $this->container->mockery_verify();
    }
    
    public function testMatchPrecedenceBasedOnExpectedCallsFavouringExplicitMatch()
    {
        $this->spy->shouldReceive('foo')->with(1)->once();
        $this->spy->shouldReceive('foo')->with(Mockery::any())->never();
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testMatchPrecedenceBasedOnExpectedCallsFavouringAnyMatch()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::any())->once();
        $this->spy->shouldReceive('foo')->with(1)->never();
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
        $m = $this->container->mock('f')->shouldReceive('foo')->with(1)->andReturn(3)->mock();
        $this->assertTrue($m instanceof \Mockery\MockInterface);
    }
    
    public function testNotConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::not(1))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }
    
    public function testNotConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::not(2))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::not(2))->once();
        $this->spy->foo(2);
        $this->container->mockery_verify();
    }

    public function testAnyOfConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::anyOf(1, 2))->twice();
        $this->spy->foo(2);
        $this->spy->foo(1);
        $this->container->mockery_verify();
    }
    
    public function testAnyOfConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::anyOf(1, 2))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::anyOf(1, 2))->once();
        $this->spy->foo(3);
        $this->container->mockery_verify();
    }
    
    public function testNotAnyOfConstraintMatchesArgument()
    {
        $this->spy->shouldReceive('foo')->with(Mockery::notAnyOf(1, 2))->once();
        $this->spy->foo(3);
        $this->container->mockery_verify();
    }
    
    public function testNotAnyOfConstraintNonMatchingCase()
    {
        $this->spy->shouldReceive('foo')->times(3);
        $this->spy->shouldReceive('foo')->with(1, Mockery::notAnyOf(1, 2))->never();
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
        $this->spy->shouldReceive('foo')->with(Mockery::notAnyOf(1, 2))->once();
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
        $mock->shouldReceive('foo');
    }*/
    
    /**
     * @expectedException \Mockery\Exception
     */
    /*public function testGlobalConfigMayForbidMockingNonExistentMethodsOnObjects()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = $this->container->mock(new stdClass);
        $mock->shouldReceive('foo');
    }*/
    
}

class MockerySpy_Duck {
    function quack(){}
    function swim(){}
}

class MockerySpy_Duck_Nonswimmer {
    function quack(){}
}
