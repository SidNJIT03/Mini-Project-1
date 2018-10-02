<?php
main::display();
class main{
    static public function display(){
        $data = csvFile::getData();
        $table = htmlOP::generateTable($data);
        $table = 'test';
        system::printPage($table);
    }
}
class csvFile{
    static public function getData(){

    }
}
class htmlOP{
    static public function generateTable(){

    }
}
class system{
    static public function printPage($page){
        echo $page;
    }
}

