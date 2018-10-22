<?php

namespace App\Salesforce;

use Illuminate\Support\Collection;
use RuntimeException;

/**
 * Class SFModel
 *
 * @property string $Id
 */
abstract class SFModel
{
    public const FIELDS_ALL = 'all';

    public const FIELDS_READONLY = 'read_only';

    public const FIELDS_WRITEABLE = 'writeable';

    public const FIELDS_INSERT = 'insert';

    public const FIELDS_UPDATE = 'update';

    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'Null';

    /**
     * Salesforce Object Id
     *
     * @var string
     */
    protected static $objectId = 'Id';

    /**
     * Salesforce Object Synchronization Id
     *
     * @var string
     */
    protected static $synchronizationField = 'Id';

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fields = [];

    /**
     * List of Salesforce fields not to check for differences
     *
     * @var string[]
     */
    protected static $fieldsIgnoreDifferences = [];

    /**
     * List of read only Salesforce fields
     *
     * @var string[]
     */
    protected static $fieldsRead = ['Id', 'CreatedDate'];

    /**
     * List of Salesforce fields only to be used on Insert
     *
     * @var string[]
     */
    protected static $fieldsInsert = [];

    /**
     * List of Salesforce fields only to be used on Update
     *
     * @var string[]
     */
    protected static $fieldsUpdate = [];

    /**
     * Array with values for a specific object entry.
     *
     * @var string[]
     */
    protected $values = [];

    protected $realEmail = null;

    /**
     * The identifying field of the object
     *
     * @return string
     */
    public static function objectId()
    {
        return static::$objectId;
    }

    /**
     * The object name
     *
     * @return string
     */
    public static function objectName()
    {
        return static::$object;
    }

    /**
     * The identifying field of the object
     *
     * @return string
     */
    public static function synchronizationField()
    {
        return static::$synchronizationField;
    }

    protected static $fieldsCache = [];

    /**
     * Gets the attribute key list of on object type
     *
     * @param string $fieldTypes
     * @return string[]
     */
    public static function getFields($fieldTypes = self::FIELDS_ALL)
    {
        if (isset(self::$fieldsCache[get_called_class()][$fieldTypes])) {
            return self::$fieldsCache[get_called_class()][$fieldTypes];
        }

        if (! in_array($fieldTypes, [self::FIELDS_ALL, self::FIELDS_WRITEABLE, self::FIELDS_READONLY, self::FIELDS_INSERT, self::FIELDS_UPDATE])) {
            throw new RuntimeException('Invalid field type provided to '.get_called_class().': '.$fieldTypes);
        }

        if (! array_key_exists(get_called_class(), self::$fieldsCache)) {
            self::$fieldsCache[get_called_class()] = [];
        }

        if (! array_key_exists($fieldTypes, self::$fieldsCache[get_called_class()])) {
            $keys = [];

            if (in_array($fieldTypes, [self::FIELDS_ALL, self::FIELDS_WRITEABLE, self::FIELDS_INSERT, self::FIELDS_UPDATE])) {
                $keys = array_merge($keys, static::$fields);
            }

            if (in_array($fieldTypes, [self::FIELDS_INSERT])) {
                $keys = array_diff($keys, static::$fieldsUpdate);
            }

            if (in_array($fieldTypes, [self::FIELDS_UPDATE])) {
                $keys = array_diff($keys, static::$fieldsInsert);
            }

            if (in_array($fieldTypes, [self::FIELDS_ALL, self::FIELDS_READONLY])) {
                $keys = array_merge($keys, static::$fieldsRead);
            }

            self::$fieldsCache[get_called_class()][$fieldTypes] = $keys;
        }

        return self::$fieldsCache[get_called_class()][$fieldTypes];
    }

    /**
     * Gets a comma separated list of the object fields
     *
     * @param string $fieldTypes
     * @return string
     */
    public static function getFieldText($fieldTypes = self::FIELDS_ALL)
    {
        $fields = static::getFields($fieldTypes);

        // Filter out non alphanumeric characters (plus underscore)
        // This avoids any issues regarding Salesforce API usage.
        foreach ($fields as $key => $field) {
            $fields[$key] = preg_replace("/[^a-z0-9_]+/i", '', $field);
        }

        return implode(', ', $fields);
    }

    public function getRealEmail()
    {
        if (! $this->realEmail) {
            $this->realEmail = strtolower(trim(real_email($this->Email)));
        }

        return $this->realEmail ?? $this->Email;
    }

    /**
     * SFModel constructor.
     *
     * @param array $row
     */
    public function __construct($row = [])
    {
        foreach (array_merge(static::$fields, static::$fieldsRead) as $field) {
            $this->values[$field] = null;
        }

        if ($row !== null) {
            $this->setData($row);
        }
    }

    /**
     * Filters and sets the data on existing fields
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        if (! is_object($data)) {
            $data = (object) $data;
        }
        foreach ($data as $key => $value) {
            if (in_array($key, static::getFields())) {
                $this->values[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Gets data associated with an object
     *
     * @param string $fieldTypes
     * @return array
     */
    public function getData($fieldTypes = self::FIELDS_ALL)
    {
        $data = [];

        foreach (static::getFields($fieldTypes) as $field) {
            $data[$field] = $this->values[$field];
        }

        return $data;
    }

    /**
     *  Get data filtered by fields
     *
     * @param string[] $fieldList
     * @return array
     */
    public function getFilteredData($fieldList)
    {
        $data = [];

        foreach (static::getFields() as $field) {
            if (in_array($field, $fieldList)) {
                $data[$field] = $this->values[$field];
            }
        }

        return $data;
    }

    /**
     * Setter for fields
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        if (! in_array($name, static::getFields())) {
            throw new RuntimeException('Trying to set invalid field on '.get_called_class().': '.$name);
        }

        $this->values[$name] = (string) $value;
    }

    /**
     * Getter for fields
     *
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        if (! in_array($name, static::getFields())) {
            throw new RuntimeException('Trying to get invalid field on '.get_called_class().': '.$name);
        }

        return $this->values[$name];
    }

    /**
     * Get list of fields that are different between two objects
     *
     * @param SFModel $object
     * @param string  $fieldTypes
     * @return string[]
     */
    public function getDifferentFields(SFModel $object, $fieldTypes = self::FIELDS_ALL)
    {
        $differenceFields = [];

        foreach ($this->getFields($fieldTypes) as $field) {
            if (in_array($field, static::$fieldsIgnoreDifferences)) {
                continue;
            }

            if (! loosely_equal($this->$field, $object->$field)) {
                $differenceFields[] = $field;
            }
        }

        return $differenceFields;
    }

    /**
     * Returns whether or not two models have the same data
     *
     * @param SFModel $object
     * @param string  $fieldTypes
     * @return bool
     */
    public function isEqual(SFModel $object, $fieldTypes = self::FIELDS_ALL)
    {
        return count($this->getDifferentFields($object, $fieldTypes)) == 0;
    }

    /**
     * Return any data provided that is different from the model data
     *
     * @param Collection|array $data
     * @param string           $fieldTypes
     * @return Collection
     */
    public function getDifferentData($data, $fieldTypes = self::FIELDS_ALL)
    {
        $difference = [];

        foreach (static::getFields($fieldTypes) as $field) {
            if (in_array($field, static::$fieldsIgnoreDifferences)) {
                continue;
            }

            if (! isset($data[$field])) {
                continue;
            }

            if (! loosely_equal($this->$field, $data[$field])) {
                $difference[$field] = [$this->$field, $data[$field]];
            }
        }

        return collect($difference);
    }
}