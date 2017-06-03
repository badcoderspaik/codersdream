<?php

//класс, наследующий от Article, для вывода полной статьи с описанием книги
class Full_Article extends Article
{
    function __construct($template)
    {
        //вызов конструктора суперкласса
        parent::__construct($template);
    }

    //читает и возвращает преобразованный файл шаблона статьи
    //функции передается предварительно полученный программой  результирующий набор mysqli_result,
    // полученный из запроса в базу данных
    public function readTemplate($mysqli_object)
    {
        //объект
        $db_object = $mysqli_object->fetch_object();
        //массив меток-заполнителей в html-шаблоне, которые будут заменены на результаты,
        //полученные из базы данных
        $needle = array("[cover_url]", "[title]", "[author]", "[year]", "[text]");
        //если объект не пустой
        if ($db_object != "") {
            //заменить метку [end] в тексте описания на пустое значение, т.е. удалить метку-заполнитель из текста
            //и записать полученный результат в переменную
            $text = str_replace("[end]", "", $db_object->text);
            //обновляющийся при каждом проходе цикла массив значений из базы данных, значения которого будут заменять
            //метки-заполнители (массив $needle) полученного файла html-шаблона
            $replace = array($db_object->cover_url, $db_object->title, $db_object->author, $db_object->year, $text);
            //заменить массив меток-заполнителей на массив значений базы данных в файле шаблона
            $this->template = str_replace($needle, $replace, $this->template);
        } else {
            //если $db_object пуст
            $this->template = "<p>No data in database</p>";
        }
        //вернуть строку (можно сказать, что возвращается html-разметка) с замененными значениями
        return $this->template;
    }
}