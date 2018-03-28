<?php
function InitHere($query = null)
{
    if($query == "add")
    {
        return R::exec("INSERT INTO carrot_customers_tasks (carrot_customers_tasks_order, carrot_customers_tasks_user, carrot_customers_tasks_text)
        VALUES (?, ?, ?)", [BF::ClearCode("orderId", "int", "post"), BF::ReturnInfoUser("carrot_users_id"), BF::ClearCode("text", "str", "post")]);
    }
    else if($query == "start")
    {
        return R::exec("UPDATE carrot_customers_tasks
        SET carrot_customers_tasks_start = ?
        WHERE carrot_customers_tasks_id = ?",
        [date('Y-m-d H:i:s'), BF::ClearCode("taskId", "int", "post")]);
    }
    else if($query == "stop")
    {
        return R::exec("UPDATE carrot_customers_tasks
        SET carrot_customers_tasks_end = ?
        WHERE carrot_customers_tasks_id = ?",
        [date('Y-m-d H:i:s'), BF::ClearCode("taskId", "int", "post")]);
    }
    else if($query == "SetUserOnTask")
    {
        AuxiliaryFn::StylePrint(BF::ClearCode("taskId", "int", "post"));
        AuxiliaryFn::StylePrint(BF::ClearCode("userId", "int", "post"));

        R::exec("UPDATE carrot_customers_tasks SET carrot_customers_tasks_executor = ? WHERE carrot_customers_tasks_id = ?", [BF::ClearCode("userId", "int", "post"), BF::ClearCode("taskId", "int", "post")]);
    }
}
