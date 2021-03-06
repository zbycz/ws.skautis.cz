<?php

/**
 * @author Hána František
 */
abstract class BaseService extends Nette\Object {

    /**
     * reference na třídu typu Table
     * @var instance of BaseTable
     */
    protected $table;

    /**
     * slouží pro komunikaci se skautISem
     * @var \SkautIS\SkautIS
     */
    protected $skautis;

    /**
     * používat lokální úložiště?
     * @var bool
     */
    private $useCache = TRUE;

    /**
     * krátkodobé lokální úložiště pro ukládání odpovědí ze skautISU
     * @var type 
     */
    private static $storage;

    public function __construct($skautIS = NULL) {
        $this->skautis = $skautIS;
        self::$storage = array();
    }
    
    public function getInfo(){
        return array(
            "ID_Login"=>$this->skautis->getToken(),
            "ID_Role"=>$this->skautis->getRoleId(),
            "ID_Unit"=>$this->skautis->getUnitId(),
        );
    }

    /**
     * ukládá $val do lokálního úložiště
     * @param mixed $id
     * @param mixed $val
     * @return mixed 
     */
    protected function save($id, $val) {
        if ($this->useCache) {
            self::$storage[$id] = $val;
        }
        return $val;
    }

    /**
     * vrací objekt z lokálního úložiště
     * @param string|int $id
     * @return mixed | FALSE
     */
    protected function load($id) {
        if ($this->useCache && array_key_exists($id, self::$storage)) {
            return self::$storage[$id];
        }
        return FALSE;
    }

}

