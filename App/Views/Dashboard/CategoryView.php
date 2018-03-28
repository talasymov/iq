<?php
$pageName = "Категории товаров";

Dashboard::printHeader($pageName, "grey");

$tr = '';

class TreeOX2 {

    private $_db = null;
    private $_category_arr = array();
    public $_tr = '';

    public function __construct() {
        //Подключаемся к базе данных, и записываем подключение в переменную _db
//        $this->_db = new PDO("mysql:dbname=ox2.ru-test-base;host=localhost", "root", "");
        //В переменную $_category_arr записываем все категории (см. ниже)
        $this->_category_arr = $this->_getCategory();
    }

    /**
     * Метод читает из таблицы category все сточки, и
     * возвращает двумерный массив, в котором первый ключ - id - родителя
     * категории (parent_id)
     * @return Array
     */
    private function _getCategory() {
        $result = R::getAll("SELECT * FROM `Categories`"); //Готовим запрос
//        $query->execute(); //Выполняем запрос
        //Читаем все строчки и записываем в переменную $result
//        $result = $query->fetchAll(PDO::FETCH_OBJ);
        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором
        //первый ключ - parent_id)
        $return = array();
        foreach ($result as $value) { //Обходим массив
            $return[$value["Categories_parent"]][] = $value;
        }
        return $return;
    }

    /**
     * Вывод дерева
     * @param Integer $parent_id - id-родителя
     * @param Integer $level - уровень вложености
     */
    public function outTree($parent_id, $level) {
        if (isset($this->_category_arr[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->_category_arr[$parent_id] as $value) { //Обходим ее
                /**
                 * Выводим категорию
                 *  $level * 25 - отступ, $level - хранит текущий уровень вложености (0,1,2..)
                 */

                $element = "";

                for ($i = 1; $i <= $level; $i++)
                {
                    $element .= '<i style="margin-right: 10px;" class="fa fa-arrow-right" aria-hidden="true"></i> ';
                }

                $this->_tr .= '<tr>
                    <td class="ta-c" width="50">' . $value["Categories_id"] . '</td>
                    <td width="200">' . $element . '<input class="design-input edit-root-category' . $value["Categories_id"] . '" value="' . $value["Categories_name"] . '" /></td>
                    <td>' . $element . '<input class="design-input edit-root-category-ru' . $value["Categories_id"] . '" value="' . $value["Categories_name_ru"] . '" /></td>
                    <!--<td><div class="slct-modal-div-image">
                        <img src="' . $value["Categories_image"] . '">
                        <span class="slct-name"><i class="fa fa-camera" aria-hidden="true"></i></span>
                        <button class="clear-button product-preview cat-img-' . $value["Categories_id"] . '" data-url=""><i class="fa fa-paperclip" aria-hidden="true"></i></button>
                    </div>
                    </td>-->
                    <td></td>
                    <td class="ta-c">
                        <!--<button class="add-sub-category-btn btn btn-default circle" data-toggle="tooltip" title="Новая подкатегория" data-id="' . $value["Categories_id"] . '"><i class="fa fa-plus" aria-hidden="true"></i></button>-->
                        <button class="save-category btn btn-default circle" data-toggle="tooltip" title="Сохранить изменения" data-id="' . $value["Categories_id"] . '"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        <button class="delete-category btn btn-default circle" data-toggle="tooltip" title="Удалить категорию" data-id="' . $value["Categories_id"] . '"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <!--<button class="up-price-category btn btn-default circle" data-toggle="tooltip" title="Массовое изменение цен" data-id="' . $value["Categories_id"] . '"><i class="fa fa-dollar" aria-hidden="true"></i></button>-->
                    </td>
                </tr>';
                $level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->outTree($value["Categories_id"], $level);
                $level--; //Уменьшаем уровень вложености
            }
        }
    }

}

$tree = new TreeOX2();
$tree->outTree(0, 0); //Выводим дерево

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <input class="design-input text-root-category" data-placeholder="Название" /> <button class="add-root-category btn btn-default circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-12">
            <!--<div class="council-div"><i class="fa fa-info-circle" aria-hidden="true"></i>Подойдите серьезно к построению иерархии категорий и подкатегорий, чтобы в
            будущем не возникло потребности в полном перестроении структуры!</div>-->
            <table class="table">
                <thead class="strong">
                    <tr><th class="ta-c">#</th><th>Название категории (АНГЛ)</th><th>Название категории (РУС)</th><th></th><th class="ta-c">Управление</th></tr>
                </thead>
                <tbody class="arrow-category">
                {$tree->_tr}
                </tbody>
            </table>
            <hr />
        </div>
    </div>
</div>
EOF;
