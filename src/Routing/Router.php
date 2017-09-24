<?php
/**
 * User: boshurik
 * Date: 24.09.17
 * Time: 13:53
 */

namespace App\Routing;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;

class Router implements RouterInterface
{
    /**
     * @var RouterInterface
     */
    private $base;

    /**
     * @var string
     */
    private $locale;

    public function __construct(BaseRouter $base, $locale)
    {
        $this->base = $base;
        $this->locale = $locale;
    }

    /**
     * @inheritDoc
     */
    public function generate($name, $parameters = array(), $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        $localeRoute = sprintf('locale_%s', $name);
        if ($this->hasRoute($localeRoute) && isset($parameters['_locale']) && $parameters['_locale'] != $this->locale) {
            return $this->base->generate($localeRoute, $parameters, $referenceType);
        }
        unset($parameters['_locale']);

        return $this->base->generate($name, $parameters, $referenceType);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function hasRoute($name)
    {
        try {
            $this->base->generate($name);
        } catch (\InvalidArgumentException $e) {
            return !$e instanceof RouteNotFoundException;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setContext(RequestContext $context)
    {
        $this->base->setContext($context);
    }

    /**
     * @inheritDoc
     */
    public function getContext()
    {
        return $this->base->getContext();
    }

    /**
     * @inheritDoc
     */
    public function getRouteCollection()
    {
        return $this->base->getRouteCollection();
    }

    /**
     * @inheritDoc
     */
    public function match($pathinfo)
    {
        return $this->base->match($pathinfo);
    }

    /**
     * @inheritDoc
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->base, $name], $arguments);
    }
}