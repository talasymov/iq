<?php
$pageName = "Управление характеристиками";

IncludesFn::printHeader($pageName, "grey");

//$selectRootCategory = AuxiliaryFn::ArrayToSelect(R::getAll("SELECT * FROM RootCategory"), "rootCategory design-input", "ID_rootCategory", "CategoryName", "Выберите из списка");
//$selectRootCategoryNew = AuxiliaryFn::ArrayToSelect(R::getAll("SELECT * FROM RootCategory"), "rootCategoryNew design-input", "ID_rootCategory", "CategoryName", "Выберите из списка");

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
                    <td><span>' . $element . $value["Categories_name"] . '</span></td>
                    <td class="ta-c" width="70">
                        <a href="/dashboard/characteristics/category/' . $value["Categories_id"] . '"><button class="btn btn-default circle"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
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
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th>Название категории</th><th class="ta-c">Управление</th></tr>
                </thead>
                <tbody>
                {$tree->_tr}
                </tbody>
            </table>
        </div>
        <!--<div class="col-md-6">
            <h3>Характеристики</h3>
            
            <span class="header-blue">Шаг 1. Выбор категории</span>
            <!--{$selectRootCategory}
            <div class="subCategoryPaste"></div>
            {$data["links"]}
            <div class="slct-modal-div select-category-char" data-key="ojansd23asd">
                <span class="slct-num">0</span>
                <span class="slct-name">Выберите категорию</span>
                <button class="clear-button"><i class="fa fa-folder-open" aria-hidden="true"></i></button>
            </div>
            <span class="header-blue">Шаг 2. Введите название характеристики</span>
            <input class="design-input name-characteristic"><br />
            <span class="header-blue">Шаг 3. Создание характеристики</span>
            <button class="add-characteristic btn btn-info"><i class="fa fa-cloud" aria-hidden="true"></i> Создать</button>
            <span class="header-blue">Шаг 4. Для редактирования характеристик выберите категорию</span>
            <div class="charListPaste"></div>
        </div>
        <div class="col-md-6">
            <h3>Значение характеристик</h3>
            <!--<span class="header-blue">Родительская категория</span>
            {$selectRootCategoryNew}
            <span class="header-blue">Шаг 1. Выбор категории</span>
            <div class="slct-modal-div select-category-char-2" data-key="dsf23">
                <span class="slct-num">0</span>
                <span class="slct-name">Выберите категорию</span>
                <button class="clear-button"><i class="fa fa-folder-open" aria-hidden="true"></i></button>
            </div>
            <div class="CategoryNewPaste"></div>
            <div class="SchemeNewPaste"></div>
            <span class="header-blue">Шаг 3. Введите значение характеристики</span>
            <input class="design-input value-characteristic"><br />
            <span class="header-blue">Шаг 4. Создание значения характеристики</span>
            <button class="add-characteristic-value btn btn-info"><i class="fa fa-cloud" aria-hidden="true"></i> Создать</button>
            <span class="header-blue">Шаг 5. Для редактирования значения характеристик выберите категорию и характеристику</span>
            <div class="charListValPaste"></div>
        </div>-->
    </div>
</div>
EOF;
