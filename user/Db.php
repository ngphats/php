<?php
class MysqliDatabase extends mysqli {

    private $_table;
    private $_where = '';
    
    function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);
    }

    public function setTable($table) {
        $this->_table = $table;
        return $this;
    }

    public function getTable() {
        return $this->_table;
    }

    public function getNumRows() {
        $query = $this->query("SELECT * from ". $this->getTable() ."");
        return $query->num_rows;
    }

    public function findAll() {
        
        $query = $this->query("SELECT * from ". $this->getTable() ."");
        while( $row = $query->fetch_assoc() ) :
            $data[] = $row;
        endwhile;
        return $data;
    }

    public function findBy($select = null, $where = null, $limitNumber = null) {

        //process select:
        if (is_array($select) && !empty($select)) :
            $select = implode(', ', $select);
        else :
            $select = '*';
        endif;

        //process where
        $this->setWhere($where);

        //process limit:
        if (null !== $limitNumber) :
            if(is_numeric($limitNumber)) :
                $limit = " limit $limitNumber";
            elseif (is_array($limitNumber)) :
                $limit = ' limit ' . $limitNumber[0] . ',' . $limitNumber[1];
            else :
                $limit = '';
            endif;
        endif;

        $sql = "SELECT $select from ". $this->getTable() . $this->getWhere() . $limit;

        $query = $this->query($sql);

        while( $row = $query->fetch_assoc() ) :
            $data[] = $row;
        endwhile;

        return $data;
    }

    public function findOneBy(array $where) {
        
        foreach ( $where as $key => $value ) :
           $whereArr[] = "$key = '$value'";
        endforeach;

        //exchange array to string:
        $whereStr = implode(' and ', $whereArr);

        //query builder:
        $query = $this->query( "SELECT * from ". $this->getTable() ." WHERE ". $whereStr ."");

        if ($query) {
            return $query->fetch_assoc();
        }

        return false;
    }

    public function setWhere($where) {
        
        //process where
        if( is_array($where) && !empty($where) ) :
            //foreach where:
            foreach ( $where as $key => $value ) :
               $whereArr[] = "$key = '$value'";
            endforeach;
            //exchange array to string:
            $this->_where = " where " . implode(' and ', $whereArr);
        else :
            $this->_where = '';
        endif;

        return $this;
    }

    public function getWhere() {
        return $this->_where;
    }

    public function insert( $data ) {

        if($data != null) :

            foreach( $data as $k => $v ) :
                if ($v != '') :
                    $value[] = "'$v'";
                    $key[] = $k;
                endif;
            endforeach;

            $keys = implode(', ', $key);
            $values = implode(', ', $value);

            $sql = "INSERT into ".$this->getTable()."($keys) VALUES($values)";

            $this->query($sql);
            
        endif;
    }

    public function update($data, $where = null) {
        
        if($data != null) :
            
            foreach( $data as $k => $v ) :
                if ($v != '') :
                    $value[] = "$k = '$v'";
                endif;
            endforeach;
            
            $values = implode(', ', $value);

            $this->setWhere($where);

            $sql = "UPDATE ". $this->getTable() ." SET $values ". $this->getWhere();

            $this->query($sql);
            
        endif;
    }

    public function delete($where = null) {
        
        $sql = "DELETE from ".$this->getTable().$this->getWhere();
        $this->query($sql);
    }
}