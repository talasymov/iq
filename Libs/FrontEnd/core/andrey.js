var appDir = "/disp.php?command=";

$(document).ready(function ()
{

    //test upload on testUloadingFile.php
    $('#uploadNewCompany').on('click', function ()
    {
        var file_data = $('#newCompanyLogo').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('text', $('#newCompanyName').val());
        form_data.append('mobile', $('#newCompanyPhoneMobile').val());
        form_data.append('phone', $('#newCompanyPhoneHome').val());
        form_data.append('anyPhone', $('#newCompanyPhoneAny').val());
        form_data.append('email', $('#newCompanyEmail').val());
        form_data.append('address', $('#newCompanyAddress').val());
        //console.log(appDir + 'add_new_company&text=' + encodeURI($('#newCompanyName').val()));
        $.ajax({
            url: appDir + 'add_new_company', // point to server-side PHP
            dataType: 'text',  // what to expect back from the PHP script, if anything
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response)
            {
                console.log(php_script_response); // display response from the PHP script, if any
                //location.reload();
                location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    });

    $(".confirmEditCompany").click(function ()
    {
        dataId = $(this).attr("data-order");
        companyName = $("#editCompanyName" + dataId).val();
        mobile = $("#editCompanyMobile" + dataId).val();
        phone = $("#editCompanyPhone" + dataId).val();
        anyPhone = $("#editCompanyAnyPhone" + dataId).val();
        email = $("#editCompanyEmail" + dataId).val();
        address = $("#editCompanyAddress" + dataId).val();

        var file_data = $('#editCompanyLogo' + dataId).prop('files')[0];

        var form_data = new FormData();

        form_data.append('file', file_data);
        form_data.append('companyName', companyName);
        form_data.append('mobile', mobile);
        form_data.append('phone', phone);
        form_data.append('anyPhone', anyPhone);
        form_data.append('email', email);
        form_data.append('address', address);

        $.ajax({
            url: appDir + 'edit_company&id='+dataId, // point to server-side PHP
                                                                                           // script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response)
            {
                console.log(php_script_response); // display response from the PHP script, if any
                location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                console.log(XMLHttpRequest);
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    });

    /*
     * 
     * WORKING WITH `subcategory`
     * 
     */
    $("#addNewProductSubCategory").click(function ()
    {
        categoryId = $("#newProductSubCategoryId").val();
        name = $("#newProductSubCategoryName").val();
        console.log(name + " " + categoryId);
        $.ajax({
            url: appDir + "addNewProductSubCategory",
            data: {
                "name": name,
                "categoryId": categoryId
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });

    $(".confirmEditProductSubCategory").click(function ()
    {
        dataId = $(this).attr('data-order');
        $.ajax({
            url: appDir + "editProductSubCategory",
            data: {
                "id": $(this).attr("data-order"),
                "name": $("#editProductSubCategoryName" + dataId).val(),
                "categoryId": $('#editProductSubCategoryId' + dataId).val()
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });

    $(".deleteProductSubCategory").click(function ()
    {
        $.ajax({
            url: appDir + "deleteProductSubCategory",
            data: {
                "id": $(this).attr("data-order")
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });
    /*
     * 
     * ===============================================
     * 
     */


    /*
     * 
     * WORKING WITH `category`
     * 
     */
    $("#addNewProductCategory").click(function ()
    {
        $.ajax({
            url: appDir + "addNewProductCategory",
            data: {
                "name": $("#newProductCategoryName").val()
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });

    $(".confirmEditProductCategory").click(function ()
    {
        dataId = $(this).attr("data-order");
        name = $("#editProductCategoryName" + dataId).val();
        console.log(dataId + " " + name);
        $.ajax({
            url: appDir + "editProductCategory",
            data: {
                "id": dataId,
                "name": name
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });

    $(".deleteProductCategory").click(function ()
    {
        $.ajax({
            url: appDir + "deleteProductCategory",
            data: {
                "id": $(this).attr("data-order")
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });
    /*
     * 
     * ===============================================
     * 
     */


    /*
     * 
     * WORKING WITH products
     * 
     */

//product change subcategory on change category when we adding new product
    $("#newProductCategoryId").change(function ()
    {
        //console.log($(this).val());
        $.ajax({
            url: appDir + "changeCategoryAtNewProduct",
            data: {
                "categoryId": $(this).val()
            },
            method: "post",
            success: function (result)
            {
                tmp = JSON.parse(result);
                $('#newProductSubCategoryId').empty();
                if (result.length !== 2) {
                    $(tmp).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#newProductSubCategoryId");
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#newProductSubCategoryId");
                }
            }
        });
    });

//product change subcategory on change category when we edit product
    $(".editProductCategoryId").change(function ()
    {
        attribute = $(this).attr("data-order");
        console.log('#editProductSubCategoryId' + attribute);
        $.ajax({
            url: appDir + "changeCategoryAtNewProduct",
            data: {
                "categoryId": $(this).val()
            },
            method: "post",
            success: function (result)
            {
                tmp = JSON.parse(result);
                $('#editProductSubCategoryId' + attribute).empty();
                if (result.length !== 2) {
                    $(tmp).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo('#editProductSubCategoryId' + attribute);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo('#editProductSubCategoryId' + attribute);
                }
            }
        });
    });

    $("#addNewProduct").click(function ()
    {
        //console.log($(this).val());
        $.ajax({
            url: appDir + "addNewProduct",
            data: {
                "categoryId": $('#newProductCategoryId').val(),
                "subCategoryId": $('#newProductSubCategoryId').val(),
                "newProductName": $('#newProductName').val()
            },
            method: "post",
            success: function (result)
            {
                console.log(result);
                location.reload();
            }
        });
    });

    $(".confirmEditProduct").click(function ()
    {
        dataId = $(this).attr('data-order');
        console.log($(this).val());
        $.ajax({
            url: appDir + "editProduct",
            data: {
                "id": dataId,
                "categoryId": $('#editProductCategoryId' + dataId).val(),
                "subCategoryId": $('#editProductSubCategoryId' + dataId).val(),
                "newProductName": $('#editProductName' + dataId).val()
            },
            method: "post",
            success: function (result)
            {
                //console.log(result);
                location.reload();
            }
        });
    });

    $(".deleteProduct").click(function ()
    {
        $.ajax({
            url: appDir + "deleteProduct",
            data: {
                "id": $(this).attr('data-order')
            },
            method: "post",
            success: function (result)
            {
                console.log(result);
                location.reload();
            }
        });
    });
    /*
     * 
     * ==============================================
     * 
     */

    /*
     * 
     * WORKING WITH creating order
     * 
     */
    $('#newProductOrderCompany').on('change', function ()
    {
        $.ajax({
            url: appDir + "select_customers_by_company",
            data: {
                "companyId": this.value
            },
            method: "post",
            success: function (result)
            {
                //alert
                array = $.parseJSON(result);
                $("#newProductOrderCustomer").empty();
                //$("#newOrder_selectClients").append("<option value=0>Не выбрано</option>");
                for (i = 0; i < array.length; i++) {
                    console.log(array[i].lastName);
                    $("#newProductOrderCustomer").append("<option value=" + array[i].customerId + ">"  + array[i].lastName + " " + array[i].firstName + " " + array[i].patronymicName +  "</option>");
                }

            }
        });
    });

//change product category
    $(document).on('change', '.selectCategoryNewProductOrder', function ()
    {
        dataId = $(this).attr("data-order");
        $.ajax({
            url: appDir + 'changeCategoryNewProductOrder',
            data: {
                "categoryId": $(this).val()
            },
            method: "post",
            success: function (result)
            {
                tmp = $.parseJSON(result);
                console.log(tmp);
                //tmp[0] - products, tmp[1] - subCategory
                console.log(tmp[0].length);
                $("#selectProductNewProductOrder" + dataId).empty();
                $("#selectSubCategoryProductNewProductOrder" + dataId).empty();
                if (tmp[0].length !== 0) {
                    $(tmp[0]).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectProductNewProductOrder" + dataId);
                }

                if (tmp[1].length !== 0) {
                    $(tmp[1]).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectSubCategoryProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectSubCategoryProductNewProductOrder" + dataId);
                }
            }
        });
    });

    //changeproduct subCategory
    $(document).on('change', '.selectSubCategoryNewProductOrder', function ()
    {
        dataId = $(this).attr("data-order");
        $.ajax({
            url: appDir + 'changeSubCategoryNewProductOrder',
            data: {
                "categoryId": $('#selectCategoryProductNewProductOrder' + dataId).val(),
                "subCategoryId": $(this).val()
            },
            method: "post",
            success: function (result)
            {
                tmp = $.parseJSON(result);
                console.log(tmp);
                //tmp[0] - products, tmp[1] - subCategory
                //console.log(tmp.length);
                $("#selectProductNewProductOrder" + dataId).empty();
                if (tmp.length !== 0) {
                    $(tmp).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectProductNewProductOrder" + dataId);
                }
            }
        });
    });


//click button Add one more good
    $(document).on('click', '.btnAddRowNewOrder', function ()
    {
        dataId = parseInt($(this).attr('data-order'));
        //console.log(dataId);
        $('#lastProductRowInTable').removeAttr('id');
        $('<tr id="lastProductRowInTable">' +
            '<td>' +
            '<select id="selectCategoryProductNewProductOrder' + dataId + '" type="text" class="form-control selectCategoryNewProductOrder" data-order="' + dataId + '">' +
            '<?php echo $outCategory; ?>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select id="selectSubCategoryProductNewProductOrder' + dataId + '" type="text" class="form-control selectSubCategoryNewProductOrder" data-order="' + dataId + '">' +
            '<?php echo $outSubCategory; ?>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select id="selectProductNewProductOrder' + dataId + '" type="text" class="form-control selectProductNewProductOrder" data-order="' + dataId + '">' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" id="productTextNewOrder' + dataId + '" class="form-control productTextNewOrder" value="" data-order="' + dataId + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" id="productCountNewOrder' + dataId + '" class="form-control productCountNewOrder" value="" data-order="' + dataId + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" id="productPricePerOneNewOrder' + dataId + '" class="form-control productPricePerOneNewOrder" value="" data-order="' + dataId + '">' +
            '</td>' +
            '</tr>').appendTo('#productListTable');
        $(this).attr('data-order', (dataId + 1));
        //console.log($('#confirmCreateNewOrder').attr('data-order'));
        $('.confirmCreateNewOrder').attr('data-order', (dataId + 1));
        $.ajax({
            url: appDir + 'addedByButtonNewRowFroNewProductOrder',
            method: "post",
            success: function (result)
            {
                tmp = $.parseJSON(result);
                //console.log(tmp);
                //tmp[0] - products, tmp[1] - subCategory
                //console.log(tmp[0].length);
                if (tmp[0].length !== 0) {
                    $(tmp[0]).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectProductNewProductOrder" + dataId);
                }

                if (tmp[1].length !== 0) {
                    $(tmp[1]).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectSubCategoryProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectSubCategoryProductNewProductOrder" + dataId);
                }

                if (tmp[2].length !== 0) {
                    $(tmp[2]).each(function ()
                    {
                        $("<option value=" + this.id + ">" + this.name + "</option>").appendTo("#selectCategoryProductNewProductOrder" + dataId);
                    });
                }
                else {
                    $("<option value='0'></option>").appendTo("#selectCategoryProductNewProductOrder" + dataId);
                }
                $("select").select2({width: "100%"});
            }
        });
    });

    $(document).on('click', '.confirmCreateNewOrder', function ()
    {
        dataId = $(this).attr('data-order');
        totalSum = $(this).attr('totalSum');
        //console.log(dataId);
        arrayToJson = {};
        arrayToJson['orderData'] = {};
        arrayToJson['orderData']['productOrderName'] = $('#productOrderName').val();
        arrayToJson['orderData']['newProductOrderCustomer'] = $('#newProductOrderCustomer').val();
        arrayToJson['orderData']['countOfRows'] = dataId;
        arrayToJson['orderData']['totalSum'] = parseFloat(totalSum);
        for (i = 1; i < parseInt(dataId); i++) {
            arrayToJson[i] = {};
            arrayToJson[i]['categoryId'] = $('#selectCategoryProductNewProductOrder' + i).val();
            arrayToJson[i]['subCategoryId'] = $('#selectSubCategoryProductNewProductOrder' + i).val();
            arrayToJson[i]['productId'] = $('#selectProductNewProductOrder' + i).val();
            arrayToJson[i]['information'] = $('#productTextNewOrder' + i).val();
            arrayToJson[i]['count'] = parseFloat($('#productCountNewOrder' + i).val());
            arrayToJson[i]['costPerOne'] = parseFloat($('#productPricePerOneNewOrder' + i).val());
        }
        //console.log(arrayToJson);
        //JSON.stringify(arrayToJson);
        $.ajax({
            url: appDir + 'createNewOrder',
            data: {
                "jsonArray": arrayToJson
            },
            method: "post",
            success: function (result)
            {
                //console.log(JSON.stringify(JSON.parse(result), 0, 4));
                //console.log(result);
                location.reload();
            }
        })
    });

    $(document).on('keyup', '.productCountNewOrder, .productPricePerOneNewOrder', function ()
    {
        $('#totalSumTd').empty();
        dataId = $('.btnAddRowNewOrder').attr('data-order');
        totalSum = 0;
        for (i = 1; i < dataId; i++) {
            productCount = parseFloat($('#productCountNewOrder' + i).val());
            productPricePerOne = parseFloat($('#productPricePerOneNewOrder' + i).val());
            totalSum += productCount * productPricePerOne;
        }
        if (isNaN(totalSum)) {
            $('#totalSumTd').append('Введите корректные данные');
        }
        else {
            $('#totalSumTd').append('Итого: ' + totalSum.toFixed(2));
            $('.confirmCreateNewOrder').attr('totalSum', totalSum.toFixed(2));
        }
    });
    /*
     * 
     * ============================================
     * 
     */

    /*
     * 
     * WORKING WITH invoices
     * 
     */
    $(document).on('click', '.createInvoice', function ()
    {
        dataId = $(this).attr('data-order');
        window.location.href = "/crm/viewInvoice.php?productsOrderGroup=" + dataId;
    });
    /*
     * 
     * =============================================
     * 
     */


    /*


     $("#addNewCompany").click(function ()
     {
     name = $("#newOrder_name_company").val();

     $.ajax({
     url: appDir + "add_new_company",
     data: {
     "nameCompany": name
     },
     method: "post",
     success: function (result)
     {
     console.log(result);
     // location.reload();
     }
     });
     });


     */

    $("#addNewCompanyBtn").click(function ()
    {
        var form = new FormData($('#addNewCompanyForms')[0]);

        // Make the ajax call
        $.ajax({
            url: $('#addNewCompanyForms').attr('action') + 'add_new_company',
            type: 'POST',
            xhr: function ()
            {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', progress, false);
                }
                return myXhr;
            },
            //add before send handler to validate or something
            //beforeSend: function name,
            success: function (result)
            {
                $('#content_here_please').html(result);
            },
            //add error handler for when a error occurs if you want!
            //error: error function,
            data: form,
            // this is the important stuff you need to override the usual post behavior
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Yes outside of the .ready space because this is a function not an event listener!
    function progress(e)
    {
        if (e.lengthComputable) {
            //this makes a nice fancy progress bar
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }


    if (window.location.pathname == "/crm/statistic.php") {

        //get top UP products
        $.ajax({
            url: appDir + 'getTopUpProducts',
            async: true,
            success: function (result)
            {
                //alert(window.location.pathname);
                var array = [];
                var tmp = JSON.parse(result);

                if (result.length !== 2) {
                    var i = 0;


                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {

                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Название продукта');
                        data.addColumn('number', 'Общее число дохода');


                        $(tmp).each(function ()
                        {
                            data.addRow([this.productName, parseInt(this.totalSum)]);
                            i++;
                        });

                        var options = {
                            title: 'Топ прибыльных продуктов',
                            pieHole: 0.4
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('topProductsUpStatistic'));

                        chart.draw(data, options);
                    }
                }
            }
        });


        //get top DOWN products
        $.ajax({
            url: appDir + 'getTopDownProducts',
            async: true,
            success: function (result)
            {
                //alert(window.location.pathname);
                array = [];
                var tmp = JSON.parse(result);

                if (result.length !== 2) {
                    var i = 0;


                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {

                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Название продукта');
                        data.addColumn('number', 'Общее число дохода');


                        $(tmp).each(function ()
                        {
                            var a = [];
                            a.push(this.productName, this.totalSum);
                            array.push(a);
                            data.addRow([this.productName, parseInt(this.totalSum)]);
                            i++;
                        });
                        //console.log(array);


                        var options = {
                            title: 'Топ неприбыльных продуктов',
                            pieHole: 0.4
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('topProductsDownStatistic'));

                        chart.draw(data, options);
                    }


                }
            }
        });

        //get top UP workers
        $.ajax({
            url: appDir + 'getTopUpWorkers',
            async: true,
            success: function (result)
            {
                //alert(window.location.pathname);
                array = [];
                var tmp = JSON.parse(result);

                if (result.length !== 2) {
                    var i = 0;


                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'ФИО сотрудника');
                        data.addColumn('number', 'Сумма дохода');


                        $(tmp).each(function ()
                        {
                            data.addRow([this.userName, parseInt(this.totalSumOfOrder)]);
                            i++;
                        });
                        var options = {
                            title: 'Топ лучших сотрудников компании',
                            pieHole: 0.4
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('topWorkersUpStatistic'));

                        chart.draw(data, options);
                    }
                }
            }
        });

        //get top UP workers
        $.ajax({
            url: appDir + 'getTopDownWorkers',
            async: true,
            success: function (result)
            {
                //alert(window.location.pathname);
                array = [];
                var tmp = JSON.parse(result);

                if (result.length !== 2) {
                    var i = 0;
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'ФИО сотрудника');
                        data.addColumn('number', 'Сумма дохода');


                        $(tmp).each(function ()
                        {
                            data.addRow([this.userName, parseInt(this.totalSumOfOrder)]);
                            i++;
                        });
                        var options = {
                            title: 'Топ худших сотрудников компании',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('topWorkersDownStatistic'));

                        chart.draw(data, options);
                    }
                }
            }
        });


        //get top days
        $.ajax({
            url: appDir + 'getBestDays',
            async: true,
            success: function (result)
            {
                tmp = JSON.parse(result);

                console.log(result);
                console.log('asdas');

                if (result.length !== 2) {
                    var i = 0;
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Дата');
                        data.addColumn('number', 'Сумма дохода');


                        $(tmp).each(function ()
                        {
                            data.addRow([this[0], parseInt(this[1])]);
                            i++;
                        });
                        var options = {
                            title: 'Самые лучшие дни',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('bestDays'));

                        chart.draw(data, options);
                    }
                }
            }
        });


        //get top months
        $.ajax({
            url: appDir + 'getBestMonths',
            async: true,
            success: function (result)
            {
                var tmp = JSON.parse(result);

                console.log(result);
                console.log('asdas');

                if (result.length !== 2) {
                    var i = 0;
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Месяц');
                        data.addColumn('number', 'Сумма дохода');


                        $(tmp).each(function ()
                        {
                            data.addRow([this[0], parseInt(this[1])]);
                            i++;
                        });
                        var options = {
                            title: 'Самые лучшие месяцы',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('bestMonths'));

                        chart.draw(data, options);
                    }
                }
            }
        });


    }
});