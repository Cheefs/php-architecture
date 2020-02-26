<?php

declare(strict_types = 1);

use Command\UseCase\RegisterConfigHandler;
use Command\UseCase\RegisterRoutesHandler;
use Framework\Command\RegisterConfigCommand;
use Framework\Command\RegisterRoutesCommand;
use Framework\Registry;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     *  Шаблонный метод, он определяет три последовательных шага
     *  которые алгоритм должен выполнить
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $registerConfigCommand = new RegisterConfigCommand( $this->containerBuilder );
        (new RegisterConfigHandler( $registerConfigCommand ))->execute();

        $registerRoutesCommand = new RegisterRoutesCommand( $registerConfigCommand->getContainerBuilder() );
        (new RegisterRoutesHandler( $registerRoutesCommand ))->execute();

        return $this->process( $request, $registerRoutesCommand->getRouteCollection() );
    }

    /**
     * @param Request $request
     * @param RouteCollection $routeCollection
     * @return Response
     */
    protected function process(Request $request, RouteCollection $routeCollection): Response
    {
        $matcher = new UrlMatcher($routeCollection, new RequestContext());
        $matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $request->setSession(new Session());

            $controller = (new ControllerResolver())->getController($request);
            $arguments = (new ArgumentResolver())->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Page not found. 404', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $error = 'Server error occurred. 500';
            if (Registry::getDataConfig('environment') === 'dev') {
                $error .= '<pre>' . $e->getTraceAsString() . '</pre>';
            }

            return new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
