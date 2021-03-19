<?php namespace App\Entities;

use App\Connectors\Sap\Di\Server\Builder;
use App\Exceptions\BadRequestException;
use App\Validation\Validator;
use Illuminate\Container\Container;

/**
 * Class BaseEntity
 * @package App\Entities
 * @property $id
 */
class BaseEntity
{
    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * This array can be used to store any in-memory optimizations
     *
     * @var array
     */
    protected $cache = array();

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey;


    /**
     * @var array
     */
    protected $validation = array();

    /**
     * @var array
     */
    protected $configs = array();

    /**
     * Constructs a new BaseEntity.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes($attributes);
    }

    /**
     * Sets attributes on the current entity.
     *
     * @param array $attributes
     * @return BaseEntity
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * Sets an attribute on this entity.
     *
     * @param string $name
     * @param mixed $value
     * @return BaseEntity
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Returns the attributes of the current entity.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ( ! isset($this->attributes[$name])) {
            return null;
        }
        return $this->attributes[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function toArray(array $args = array())
    {
        $return = $this->getAttributes();
        ksort($return);
        return $return;
    }

    /**
     * Persists the result of $func to this entity for the duration of its life
     *
     * @param string $key
     * @param Callable $func
     * @return mixed
     */
    protected function persist($key, $func)
    {
        if ( ! isset($this->cache[$key])) {
            $this->cache[$key] = $func();
        }
        return $this->cache[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function inject($key, $value)
    {
        $this->cache[$key] = $value;
    }

    /**
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getRules() {
        return $this->validation;
    }

    /**
     * @return array
     */
    public function getConfigs() {
        return $this->configs;
    }

    /**
     * @param $data
     * @return BaseEntity
     * @throws BadRequestException
     */
    public static function create($data) {
        try {
            $obj = new static($data); /** @var $obj BaseEntity */

            $obj->preCreateHook($data);
            $obj->save();
            return $obj;
        } catch (BadRequestException $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     * @return BaseEntity
     * @throws BadRequestException
     */
    public function update($data) {
        try {
            $this->setAttributes($data);

            $this->preUpdateHook($data);
            $this->save();
            return $this;
        } catch (BadRequestException $e) {
            throw $e;
        }
    }

    /**
     * @return $this
     * @throws BadRequestException
     */
    public function save()
    {
        $data = $this->validate();
        $connecion = Container::getInstance()->make(Builder::class);

        if ($this->id) {
            $connecion->table($this->getTable())->where([$this->primaryKey => $this->id])->update($data);
        } else {
            $id = $connecion->table($this->getTable())->insert($data);
            $this->id = $id;
        }

        return $this;
    }

    /**
     * @return array
     * @throws BadRequestException
     */
    public function validate()
    {
        return Validator::validate($this->getAttributes(), $this->getRules());
    }

    public function preCreateHook($data) {}

    public function preUpdateHook($data) {}
}
