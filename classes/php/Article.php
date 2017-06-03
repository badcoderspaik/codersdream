<?php

/*класс вывода всех статей на главной странице с описанием книги*/

class Article
{
    protected $template;// файл html-шаблона статьи

    function __construct($template)
    {
        $this->template = file_get_contents($template);// прочитать файл в переменную
    }

    //читает и возвращает преобразованный файл шаблона статьи
    //функции передается предварительно полученный программой  результирующий набор mysqli_result,
    // полученный из запроса в базу данных
    public function readTemplate($mysqli_object)
    {
        //переменная, которая будет возвращена методом
        $content = "";
        //массив меток-заполнителей в html-шаблоне, которые будут заменены на результаты,
        //полученные из базы данных
        $needle = array("[article_id]", "[cover_url]", "[title]", "[author]", "[year]", "[text]");
        //объект
        $db_object = $mysqli_object->fetch_object();
        //если объект не пустой
        if ($db_object != "") {
            //переместить указатель результата в начало
            $mysqli_object->data_seek(0);
            //запускать цикл, пока присутсвует очередная строка результата
            while ($db_object = $mysqli_object->fetch_object()) {
                //присвоить переменной ссылку на файл шаблона, т.к. непосредственное обращение к $this->template в цикле
                //в каждом проходе цикла осуществляет новое чтение файла шаблона, что сказывается на быстродействии
                $cont = $this->template;
                //разбить полученный из базы текст статьи пр разделителю [end] и поместить в массив; нулевой элемент массива
                //будет соответсвовать первой строке, т.е. в данном случае первой строке до разделителя [end]
                $cutted_text = explode("[end]", $db_object->text);
                //обновляющийся при каждом проходе цикла массив значений из базы данных, значения которого будут заменять
                //метки-заполнители (массив $needle) полученного файла html-шаблона
                $replace = array($db_object->id, $db_object->cover_url, $db_object->title, $db_object->author, $db_object->year, $cutted_text[0]);
                //заменить массив меток-заполнителей на массив значений базы данных в файле шаблона
                $cont = str_replace($needle, $replace, $cont);
                //результаты распарсенного с замененными значениями шаблона на каждом проходе цикла конкатенируются в этой переменной
                $content .= "$cont";
            }
        } else {
            //если $db_object пуст
            $content = "<h3 class='text-center'> В данной категории пока еще нет книг</h3>";
        }
        //вернуть строку (можно сказать, что возвращается html-разметка) с замененными значениями
        return $content;
    }

}