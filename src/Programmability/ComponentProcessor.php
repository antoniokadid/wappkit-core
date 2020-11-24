<?php

namespace AntonioKadid\WAPPKitCore\Programmability;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;
use AntonioKadid\WAPPKitCore\Programmability\Exceptions\ProgrammabilityException;
use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Class ComponentProcessor.
 *
 * @package AntonioKadid\WAPPKitCore\Programmability
 */
class ComponentProcessor
{
    public const COMPONENT_DEFINITION = '/#\{\{\s*(?<name>\w+)(?:\s+(?<parameters>[^}}]+))?\s*\}\}/i';

    /**
     * Contains the contents of dynamic components.
     *
     * @var Component[]
     */
    private $cache;

    /**
     * A callable that will convert a component name into its contents.
     *
     * @var callable
     */
    private $componentEvaluator;

    /**
     * ComponentProcessor constructor.
     *
     * @param callable $componentEvaluator a callable that will convert a component name into its contents
     */
    public function __construct(callable $componentEvaluator)
    {
        $this->cache              = [];
        $this->componentEvaluator = $componentEvaluator;
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $async
     *
     * @return string
     */
    public static function describe(string $name, array $parameters = [], bool $async = false): string
    {
        if ($async) {
            if (empty($parameters)) {
                return sprintf('<AsyncComponent name="%s"></AsyncComponent>', $name);
            }

            $keys   = array_keys($parameters);
            $values = array_values($parameters);

            array_walk($keys, function (&$key) {
                $key = preg_replace_callback('/([[:lower:]]|[[:digit:]])([[:upper:]]|[[:digit:]])/', function ($matches) {
                    return sprintf('%s-%s', $matches[1], strtolower($matches[2]));
                }, $key);
            });

            $parameters = [];
            foreach (array_combine($keys, $values) as $key => $value) {
                $parameters[] = sprintf('data-%s="%s"', $key, urlencode($value));
            }

            return sprintf('<AsyncComponent name="%s" %s></AsyncComponent>', $name, implode(' ', $parameters));
        }

        if (empty($parameters)) {
            return sprintf('#{{%s}}', $name);
        }

        $httpQuery = http_build_query($parameters);

        return sprintf('#{{%s %s}}', $name, $httpQuery);
    }

    /**
     * @param Component $component
     *
     * @throws IOException
     * @throws ProgrammabilityException
     *
     * @return string
     */
    public function processComponent(Component $component): string
    {
        if (!$this->classDefinedForComponent($component)) {
            CodeEvaluator::evaluate($component->getContent());
        }

        $instance = $this->classInstanceForComponent($component);
        if ($instance == null) {
            return '';
        }

        try {
            $content = $instance->generate();
        } catch (Exception $exception) {
            throw new ProgrammabilityException(sprintf('Unable to generate code of %s', $component->getName()), $component->getParameters(), $component->getContext(), $exception);
        }

        $context = new ExecutionContext($component->getParameters(), $component->getContext());

        return $this->processContent($content, $context);
    }

    /**
     * @param string                $content
     * @param null|ExecutionContext $context
     *
     * @throws IOException
     * @throws ProgrammabilityException
     *
     * @return null|string
     */
    public function processContent(string $content, ExecutionContext $context = null): ?string
    {
        return preg_replace_callback(
            self::COMPONENT_DEFINITION,
            function (array $matches) use ($context) {
                $name = $matches['name'];

                $parameters = [];
                if (array_key_exists('parameters', $matches)) {
                    parse_str($matches['parameters'], $parameters);
                }

                if (array_key_exists($name, $this->cache)) {
                    $component = $this->cache[$name];
                    $component->setParameters($parameters);
                    $component->setContext($context);

                    return $this->processComponent($component);
                }

                $content = call_user_func_array($this->componentEvaluator, [$name]);
                if ($content === false || $content == null) {
                    return $matches[0];
                }

                $component = new Component($name, $content, $parameters, $context);
                $this->cache[$name] = $component;

                return $this->processComponent($component);
            },
            $content
        );
    }

    /**
     * @param Component $component
     *
     * @return bool
     */
    private function classDefinedForComponent(Component $component): bool
    {
        return class_exists($component->getClassName());
    }

    /**
     * @param Component $component
     *
     * @return null|IComponentImplementation
     */
    private function classInstanceForComponent(Component $component): ?IComponentImplementation
    {
        if (!$this->classDefinedForComponent($component)) {
            return null;
        }

        try {
            $class = new ReflectionClass($component->getClassName());
            if (!$class->implementsInterface(IComponentImplementation::class)) {
                return null;
            }

            /** @var IComponentImplementation $instance */
            $instance = $class->newInstance();
            $instance->setData($component->getParameters(), $component->getContext());

            return $instance;
        } catch (ReflectionException $e) {
            return null;
        }
    }
}
