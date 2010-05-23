<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */
 
namespace Mockery;

class CompositeCallStore
{

    /**
     * Stores an array of all expectations for this composite
     *
     * @var array
     */
    protected $_callStores = array();
    
    /**
     * Add an expectation to the composite
     *
     * @param \Mockery\Expectation $expectation
     * @return void
     */
    public function add(\Mockery\CallStore $callStore)
    {
        $this->_callStores[] = $callStore;
    }
    
    /**
     * Intercept any expectation calls and direct against all expectations
     *
     * @param string $method
     * @param array $args
     * @return self
     */
    public function __call($method, array $args)
    {
        foreach ($this->_callStores as $expectation) {
            call_user_func_array(array($expectation, $method), $args);
        }
        return $this;
    }
    
    /**
     * Return order number of the first expectation
     *
     * @return int
     */
    public function getOrderNumber()
    {
        reset($this->_callStores);
        $first = current($this->_callStores);
        return $first->getOrderNumber();
    }
    
    /**
     * Return the parent mock of the first expectation
     *
     * @return \Mockery\MockInterface
     */
    public function getMock()
    {
        reset($this->_callStores);
        $first = current($this->_callStores);
        return $first->getMock();
    }
    
    /**
     * Mockery API alias to getMock
     *
     * @return \Mockery\MockInterface
     */
    public function spy()
    {
        return $this->getMock();
    }
    
    /**
     * Starts a new expectation addition on the first mock which is the primary
     * target outside of a demeter chain
     *
     * @return \Mockery\Expectation
     */
    public function whenReceives()
    {
        $args = func_get_args();
        reset($this->_callStores);
        $first = current($this->_callStores);
        return call_user_func_array(array($first->getMock(), 'shouldReceive'), $args);
    }
    
    /**
     * Return the string summary of this composite expectation
     *
     * @return string
     */
    public function __toString()
    {
        $return = '[';
        $parts = array();
        foreach ($this->_callStores as $exp) {
            $parts[] = (string) $exp;
        }
        $return .= implode(', ', $parts) . ']';
        return $return;
    }

}
