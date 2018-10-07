<?php
main::start("Student_Database.csv");
class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
        $webPage = htmlTags::openBasicTags();
        $webPage .= htmlTags::openTableTags();
        $webPage .= html::generateTable($records);
        $webPage .= htmlTags::closeTableTags();
        $webPage .= htmlTags::scriptTags();
        $webPage .= htmlTags::closeBasicTags();

        system::display($webPage);
    }
}
class system  {
    static public function display($webPage){
        echo $webPage;
    }
}
class html {
    public static function generateTable($records) {
        $headset = 0;
        $table = "";
        foreach ($records as $record) {
            $array = $record->returnArray();
            if($headset == 0) {
                $fields = array_keys($array);
                $row = htmlTags::columnTableTags($fields,true);
                $table .= htmlTags::trTableTags($row);
                $headset =1;
            }
            $values = array_values($array);
            $row = htmlTags::columnTableTags($values,false);
            $table .= htmlTags::trTableTags($row);
        }
        return $table;
    }
}
class htmlTags {
    static public function openBasicTags(){
        $open = '<html><head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';
        $open .= '<style>table, th, td {border: 2px solid black; border-collapse: collapse;}th, td {padding: 25px;text-align: left;}/**th{background-color: aqua;}*/tr:nth-child(even){background-color: #f2f2f2;}</style>';
        $open .= '</head><body>';
        return $open;
    }
    static public function openTableTags(){
        $openTables = '<table style="width:100%">';
        return $openTables;
    }
    static public function columnTableTags($fields, $thTag){
        $row = "";
        if($thTag == true){
            $openingTag = "<th>";
            $closingTag = "</th>";
        }
        else{
            $openingTag = "<td>";
            $closingTag = "</td>";
        }
        foreach($fields as $field){
            $row .= $openingTag. $field .$closingTag;
        }
        return $row;
    }
    static public function trTableTags($data) {
        $result = '<tr>'.$data.'</tr>';
        return $result;
    }
    static public function closeTableTags(){
        $closeTables = '</table>';
        return $closeTables;
    }
    static public function scriptTags(){
        $scripts = '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>';
        $scripts .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>';
        $scripts .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';
        return $scripts;
    }
    static public function closeBasicTags(){
        $close = '</body></html>';
        return $close;
    }
}
class csv {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}
class record {
    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function returnArray() {
        $array = (array) $this;
        return $array;
    }
    public function createProperty($name = 'First Name', $value = 'Barry') {
        $this->{$name} = $value;
    }
}
class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
    }
}

