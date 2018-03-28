<?php
class Draw
{
    public static function FromRedBeans($headers, $data)
    {
        $th = "";

        foreach ($headers as $value)
        {
            $translateTh = Languages::Translate($value);

            $th .= "<th>$translateTh</th>";
        }

        $tr = "";

        foreach ($data as $value)
        {
            $td = "";

            foreach ($headers as $subValue)
            {
                $translateTd = Languages::Translate($value[$subValue]);

                $td .= "<td>$translateTd</td>";
            }

            $tr .= "<tr>$td</tr>";
        }

        $table = <<<EOF
        <div class="shell-table">
            <table class="table">
                <thead>
                    {$th}
                </thead>
                <tbody>
                    {$tr}
                </tbody>
            </table>
        </div>
EOF;


        return $table;
    }

    public static function DashboardOrders($data, $count = 10)
    {
        $text = "";

        if($count > 1)
        {
            foreach ($data as $value)
            {
                $icon = IncludesFn::ReturnIconCategory($value["carrot_services_category_alias"]);

                $button = Elements::Button("dashboard_more", "button button-small button-color");

                $text .= <<<EOF
                <div class="col-md-4">
                    <div class="dashboard-one-order">
                        <img src="$icon" />
                        <strong>{$value["carrot_customers_orders_name"]}</strong>
                        <a href="/dashboard/orders/{$value["carrot_customers_orders_id"]}">{$button}</a>
                    </div>
                </div>
EOF;
            }

            return $text;
        }

        $icon = IncludesFn::ReturnIconCategory($data["carrot_services_category_alias"]);

        $button = Elements::Button("dashboard_more", "button button-small button-color");

        $text .= <<<EOF
        <div class="col-md-4">
            <div class="dashboard-one-order">
                <img src="$icon" />
                <strong>{$data["carrot_customers_orders_name"]}</strong>
                <a href="/dashboard/orders/{$data["carrot_customers_orders_id"]}">{$button}</a>
            </div>
        </div>
EOF;

        return $text;
    }

    public static function SelectFile($path, $class = null)
    {
        $content = <<<EOF
<div class="slct-modal-div-image">
    <img src="{$path}">
    <span class="slct-name"><i class="fa fa-camera" aria-hidden="true"></i></span>
    <button class="clear-button product-preview {$class}" data-url="{$path}"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
</div>
<button class="clear-button product-trash" data-url=""><i class="fa fa-trash" aria-hidden="true"></i></button>
EOF;

        return $content;
    }
}