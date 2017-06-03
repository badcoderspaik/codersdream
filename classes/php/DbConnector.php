<?

/*класс соединения и работы с базой данных*/

class DbConnector
{
    public $db;//объект соединения с базой данных

    /*в конструктор передается строка с именем хоста, именем пользователя
    паролем и именем базы данных
    */
    function __construct($host, $username, $password, $dbname)
    {
        $this->db = new mysqli($host, $username, $password, $dbname);
    }

    /*sql-инструкция SELECT
    $query - строка запроса
    $show - логическая переменная - если передано true, то результаты запроса
            выводятся на экран, если false, то нет;
    в случае неудачи возвращет false,
    в случае успешного выполнения возвращает объект mysqli_result
    */
    public function select($query, $show = true)
    {
        $result = $this->db->query($query);//объект mysqli_result
        if ($show) {
            while ($row = $result->fetch_row()) {
                foreach ($row as $column) {
                    echo "$column,";
                }
            }
        }
        return $this->db->query($query);
    }

    /*sql-инструкция INSERT
    $query - строка запроса - возвращает false случае неудачи, true в случае успеха
    */
    public function insert($query)
    {
        $result = $this->db->query($query);
        return $result;
    }

    /*sql-инструкция DELETE
    $query - строка запроса - возвращает false случае неудачи, true в случае успеха
    */
    public function delete($query)
    {
        $result = $this->db->query($query);
        return $result;
    }

    /*sql-инструкция UPDATE
    $query - строка запроса - возвращает false случае неудачи, true в случае успеха
    */
    public function update($query)
    {
        $result = $this->db->query($query);
        return $result;
    }

}