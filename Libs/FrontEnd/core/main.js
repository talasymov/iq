var appDir = "/disp.php?command=";
var FM_this_element;
var FM_this_folder;
var SelectModalType;
var ResultNameInput;
var idProductWhenShowModal;
var resultProductWhenShowModal;

$(document).ready(function ()
{
    $("#example").DataTable();
    $(".exampleDataTable").DataTable();
    //send ajax request for update status of worker
    //$.ajax({
    //    url: appDir + "update_status_worker_onLoadPage",
    //    data: {
    //        "name": null
    //    },
    //    method: "post",
    //    async: false,
    //    success: function (result)
    //    {
    //    }
    //});

    $('#dtpLeadsTo').click(function ()
    {
        alert($('#dtpLeadsTo').html());
    });

    $("body").on("focus", ".input-label input", function ()
    {
        $(this).parent().find(".line-input").css("width", "100%");
    });
    $("body").on("blur", ".input-label input", function ()
    {
        $(this).parent().find(".line-input").css("width", "0%");
    });

    //on select Company <select> in `Create order`
    $('#newOrder_selectCompany').on('change', function ()
    {
        $.ajax({
            url: appDir + "select_customers_by_company",
            data: {
                "companyId": this.value
            },
            method: "post",
            success: function (result)
            {
                array = $.parseJSON(result);
                console.log('Длина массива: ' + array.length);
                $("#newOrder_selectClients").empty();
                for (i = 0; i < array.length; i++)
                {
                    console.log(array[i].lastName);
                    $("#newOrder_selectClients").append("<option value=" + array[i].customerId + ">" + array[i].lastName + " " + array[i].firstName + "" + array[i].patronymicName + "</option>");
                }
            }
        });
    })

    $(".confirmPaying").click(function ()
    {
        $.ajax({
            url: appDir + "payingUser",
            data: {
                "userId": $(this).attr("data-order")
            },
            method: "post",
            success: function (result)
            {
                console.log(result);
                location.reload();
            }
        });
    });
    $(".find-customer").keyup(function () {
        $.ajax({
            url: appDir + "inputSearch_customer",
            data: {
                "query": $(this).val()
            },
            method: "post",
            success: function (result)
            {
                $(this).parent().find(".result-search").html(result);
            }
        });
    });

    $("#addNewClient").click(function ()
    {
        company = $("#newOrder_company_user").val();
        companyName = $("#newOrder_company_name").val();
        surname = $("#newOrder_surname_user").val();
        name = $("#newOrder_name_user").val();
        patronymic = $("#newOrder_patronymic_user").val();
        city = $("#newOrder_city_user").val();
        street = $("#newOrder_street_user").val();
        build = $("#newOrder_build_user").val();
        apartment = $("#newOrder_apartment_user").val();
        phone = $("#newOrder_phone_user").val();
        phone2 = $("#newOrder_phone2_user").val();
        phone3 = $("#newOrder_phone3_user").val();
        email = $("#newOrder_email_user").val();
        site = $("#newOrder_site_user").val();
        bankDetails = $("#newOrder_bankDetails_user").val();
        from = $("#newOrder_from_user").val();

        $.ajax({
            url: appDir + "add_new_client",
            data: {
                "company": company,
                "companyName": companyName,
                "surname": surname,
                "name": name,
                "patronymic": patronymic,
                "city": city,
                "street": street,
                "build": build,
                "apartment": apartment,
                "phone": phone,
                "phone2": phone2,
                "phone3": phone3,
                "email": email,
                "site": site,
                "bankDetails": bankDetails,
                "from": from
            },
            method: "post",
            success: function (result)
            {
                data = JSON.parse(result);

                if(data.result == 0)
                {
                    alert("Такой контакт уже существует!");
                }

                console.log(data);
                //location.reload();
                //alert(result);
                //console.log(result);
            }
        });
    });

    $("#addNewLead").click(function ()
    {
        lastName = $("#newLeadLastName").val();
        firstName = $("#newLeadFirstName").val();
        patronymicName = $("#newLeadPatronymicName").val();
        phone = $("#newLeadPhone").val();
        phone2 = $("#newLeadPhone2").val();
        phone3 = $("#newLeadPhone3").val();
        comment = $("#newLeadComment").val();

        $.ajax({
            url: appDir + "addNewLead",
            data: {
                "lastName": lastName,
                "firstName": firstName,
                "patronymicName": patronymicName,
                "phone": phone,
                "phone2": phone2,
                "phone3": phone3,
                "comment": comment
            },
            method: "post",
            success: function (result)
            {
                // alert(result);
                location.reload();
                //console.log(result);
            }
        });
    });

    $(".confirmSetCall").click(function ()
    {
        var idLead = $(this).attr("data-order");

        var time = $("#callTime" + idLead).val();
        var name = $("#callName" + idLead).val();
        var phone = $("#callPhone" + idLead).val();
        var comment = $("#callText" + idLead).val();

        $.ajax({
            url: appDir + "addNewCall",
            data: {
                "time": time,
                "name": name,
                "phone": phone,
                "comment": comment
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });

    $(".confirmEditCall").click(function ()
    {
        var idLead = $(this).attr("data-order");

        var time = $("#editCallTime" + idLead).val();
        var name = $("#editCallName" + idLead).val();
        var phone = $("#editCallPhone" + idLead).val();
        var comment = $("#editCallText" + idLead).val();

        $.ajax({
            url: appDir + "editNewCall",
            data: {
                "time": time,
                "name": name,
                "phone": phone,
                "comment": comment,
                "idLead": idLead
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });

    $(".confirmDeleteCall").click(function ()
    {
        var idCall = $(this).attr("data-order");

        $.ajax({
            url: appDir + "deleteCall",
            data: {
                "idCall": idCall
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });

    $("#addNewCall").click(function ()
    {
        var time = $("#addCallTime").val();
        var name = $("#addCallName").val();
        var phone = $("#addCallPhone").val();
        var comment = $("#addCallText").val();

        $.ajax({
            url: appDir + "addNewCall",
            data: {
                "time": time,
                "name": name,
                "phone": phone,
                "comment": comment
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });

    $('#newOrderDesigner_selectCompany').on('change', function ()
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
                //console.log('Успе'+array+'шно');
                //console.log(array[0].lastName);
                console.log('Длина массива: ' + array.length);
                $("#newOrderDesigner_selectClients").empty();
                $("#newOrderDesigner_selectClients").append("<option value=0>Не выбрано</option>");
                for (i = 0; i < array.length; i++)
                {
                    console.log(array[i].lastName);
                    $("#newOrderDesigner_selectClients").append("<option value=" + array[i].customerId + ">" + array[i].lastName + " " + array[i].firstName + " " + array[i].patronymicName + "</option>");
                }
            }
        });
    });

    $('.selectCompanyClass').on('change', function ()
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
                //console.log('Успе'+array+'шно');
                //console.log(array[0].lastName);
                console.log('Длина массива: ' + array.length);
                $(".selectClientsClass").empty();
                $(".selectClientsClass").append("<option value=0>Не выбрано</option>");
                for (i = 0; i < array.length; i++)
                {
                    console.log(array[i].lastName);
                    $(".selectClientsClass").append("<option value=" + array[i].customerId + ">" + array[i].lastName + " " + array[i].firstName + " " + array[i].patronymicName + "</option>");
                }
            }
        });
    });

    $(".addOrderDesigner").click(function ()
    {
        orderId = $(this).attr("data-id");

        $.ajax({
            url: appDir + "add_order_designer",
            data: {
                "orderId": orderId
            },
            method: "post",
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $("#myModalConfirmAdd").click(function ()
    {
        name = $("#newOrderDesigner_name").val();
        client = $("#newOrderDesigner_selectClients").val();
        company = $("#newOrderDesigner_selectCompany").val();
        type = $("#newOrderDesigner_type").val();
        price = $("#newOrderDesigner_price").val();
        comment = $("#newOrderDesigner_comment").val();
        size = $("#newOrderDesigner_size").val();
        orientation = $("#newOrderDesigner_orientation").val();
        colors = $("#newOrderDesigner_colors").val();
        packets = $("#newOrderDesigner_packets").val();
        slogan = $("#newOrderDesigner_slogan").val();
        companyName = $("#newOrderDesigner_company_name").val();
        quick = $("#newOrderDesigner_quick").val();

        // description =  "Размер: " + size + "<br />Ориентация: " + orientation + "<br />Фирменные цвета: " + colors + "<br />Пакет: " + packets + "<br />Слоган: " + slogan + "<br />Название компании: " + companyName + "<br />Описание: " + comment;

        $.ajax({
            url: appDir + "addNewOrderDesign",
            data: {
                "name": name,
                "client": client,
                "company": company,
                "type": type,
                "price": price,
                "comment": comment,
                "quick": quick,
                "size": size,
                "orientation": orientation,
                "colors": colors,
                "packets": packets,
                "slogan": slogan
            },
            method: "post",
            success: function (result)
            {
                location.reload();
            }
        });
    });

    $(".editOrderDesigner").click(function ()
    {
        idOrder = $(this).attr("data-id");
        name = $("#editOrderDesigner_name" + idOrder).val();
        client = $("#editOrderDesigner_selectClients" + idOrder).val();
        type = $("#editOrder_type" + idOrder).val();
        price = $("#editOrder_price" + idOrder).val();
        comment = $("#editOrder_comment" + idOrder).val();
        size = $("#editOrder_size" + idOrder).val();
        orientation = $("#editOrderDesigner_orientir" + idOrder).val();
        colors = $("#editOrder_colors" + idOrder).val();
        packets = $("#editOrderDesigner_packets" + idOrder).val();
        slogan = $("#editOrder_slogan" + idOrder).val();
        companyName = $("#editOrder_company_name" + idOrder).val();
        quick = $("#editOrder_quick" + idOrder).val();

        $.ajax({
            url: appDir + "editNewOrderDesign",
            data: {
                "name": name,
                "client": client,
                "type": type,
                "price": price,
                "comment": comment,
                "quick": quick,
                "size": size,
                "orientation": orientation,
                "colors": colors,
                "packets": packets,
                "slogan": slogan,
                "idOrder": idOrder
            },
            method: "post",
            success: function (result)
            {
                location.reload();
            }
        });
    });

    $("#addNewWorker").click(function ()
    {
        name = $("#newOrder_name_worker").val();
        patronymic = $("#newOrder_patronymic_worker").val();
        surname = $("#newOrder_surname_worker").val();
        phone = $("#newOrder_phone_worker").val();

        $.ajax({
            url: appDir + "add_new_worker",
            data: {
                "name": name,
                "patronymic": patronymic,
                "surname": surname,
                "phone": phone,
            },
            method: "post",
            success: function (result)
            {
                // alert(result);
                location.reload();
            }
        });
    });

    $(".confirmEditCustomer").click(function ()
    {
        dataId = $(this).attr("data-order");

        company = $("#companyNameCustomerEdit" + dataId).val();
        surname = $("#lastNameCustomerEdit" + dataId).val();
        name = $("#firstNameCustomerEdit" + dataId).val();
        patronymic = $("#patronymicNameCustomerEdit" + dataId).val();
        city = $("#cityCustomerEdit" + dataId).val();
        street = $("#streetCustomerEdit" + dataId).val();
        build = $("#buildCustomerEdit" + dataId).val();
        apartment = $("#apartmentCustomerEdit" + dataId).val();
        phone = $("#phoneCustomerEdit" + dataId).val();
        phone2 = $("#phone2CustomerEdit" + dataId).val();
        phone3 = $("#phone3CustomerEdit" + dataId).val();
        email = $("#emailCustomerEdit" + dataId).val();
        site = $("#urlCustomerEdit" + dataId).val();
        bankDetails = $("#bankDetailsCustomerEdit" + dataId).val();
        from = $("#newOrder_from_user" + dataId).val();

        $.ajax({
            url: appDir + "editCustomer",
            data: {
                "id": dataId,
                "company": company,
                "surname": surname,
                "name": name,
                "patronymic": patronymic,
                "city": city,
                "street": street,
                "build": build,
                "apartment": apartment,
                "phone": phone,
                "phone2": phone2,
                "phone3": phone3,
                "email": email,
                "site": site,
                "bankDetails": bankDetails,
                "from": from
            },
            method: "post",
            success: function ()
            {
                //location.reload();
                //alert(result);
                //console.log(result);
            }
        });
    });


    $(".confirmEditLead").click(function ()
    {
        dataId = $(this).attr("data-order");
        lastName = $("#editLastNameLead" + dataId).val();
        firstName = $("#editFirstNameLead" + dataId).val();
        patronymicName = $("#editPatronymicNameLead" + dataId).val();
        phone = $("#editPhoneLead" + dataId).val();
        comment = $("#editCommentLead" + dataId).val();
        whenCall = $("#timeEditOrderOp" + dataId).val();

        $.ajax({
            url: appDir + "editLead",
            data: {
                "lastName": lastName,
                "firstName": firstName,
                "patronymicName": patronymicName,
                "phone": phone,
                "id": dataId,
                "comment": comment,
                "whenCall": whenCall
            },
            method: "post",
            success: function (result)
            {
                //alert(result);
                location.reload();
                //console.log(result);
            }
        });
    });

    $("#showThisDate").click(function()
    {
      var link = "/crm/diary.php?date_from=" + $("#timeEditOrderFrom").val() + "&date_to=" + $("#timeEditOrderTo").val();
      window.location.href = link;
    });

    $("#showThisDateEmployment").click(function()
    {
      var link = "/crm/showallmaketsfordirector.php?date_from=" + $("#timeEditOrderFrom").val() + "&date_to=" + $("#timeEditOrderTo").val();
      window.location.href = link;
    });

    // $("#checkOrders").click(function()
    // {
    //   var arrWithElements = [];
    //   var date = $("#timeCopyOrder").val();
    //
    //   $('.checkOrder').each(function(i,elem) {
    //     if($(elem).prop("checked"))
    //     {
    //       arrWithElements.push($(elem).attr("data-id"));
    //     }
    //   });
    //   console.log(arrWithElements);
    //   $.ajax({
    //       url: appDir + "copyOrdersDiary",
    //       data: {
    //           "array": arrWithElements,
    //           "date": date
    //       },
    //       method: "post",
    //       success: function (result)
    //       {
    //           console.log(result);
    //       }
    //   });
    // });

    $("#payWorkers").click(function()
    {
      var arrWithElements = [];
      var moneyAll = 0;

      $('.checkOrder').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
          moneyAll += parseInt($(elem).parents("tr").find(".money").html());
        }
      });
      $("#finalMoney").html(moneyAll);
    });

    $("#copyInvoice").click(function()
    {
        var arrWithElements = [];

        $('.checkInvoice').each(function(i,elem) {
            if($(elem).prop("checked"))
            {
                arrWithElements.push($(elem).attr("data-id"));
            }
        });

        $.ajax({
            url: appDir + "copyInvoices",
            data: {
                "array": arrWithElements
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });

    $(".confirmPaying").click(function()
    {
      var arrWithElements = [];
      var moneyAll = 0;

      $('.checkOrder').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
          moneyAll += parseInt($(elem).parents("tr").find(".money").html());
        }
      });

      $.ajax({
          url: appDir + "payWorkers",
          data: {
              "array": arrWithElements
          },
          method: "post",
          success: function (result)
          {
              location.reload();
          }
      });
    });

    $("#checkOrders").click(function()
    {
      var arrWithElements = [];
      var date = $("#timeCopyOrder").val();

      $('.checkOrder').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
        }
      });
      console.log(arrWithElements);
      $.ajax({
          url: appDir + "copyOrdersDiary",
          data: {
              "array": arrWithElements,
              "date": date
          },
          method: "post",
          success: function (result)
          {
            location.reload();
              // console.log(result);
          }
      });
    });

    $("#paySuperVisor").click(function()
    {
      var arrWithElements = [];
      var moneyAll = 0;

      $('.checkOrder').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
          moneyAll += parseInt($(elem).parents("tr").find(".money").html());
        }
      });
      $("#finalMoney").html(moneyAll);
    });

    $(".confirmPayingSuper").click(function()
    {
      var arrWithElements = [];
      var moneyAll = 0;

      $('.checkOrder').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
          moneyAll += parseInt($(elem).parents("tr").find(".money").html());
        }
      });

      $.ajax({
          url: appDir + "paySuperVisor",
          data: {
              "array": arrWithElements
          },
          method: "post",
          success: function (result)
          {
              location.reload();
          }
      });
    });

    $("#paySuperVisorDay").click(function()
    {
      var arrWithElements = [];
      var moneyAll = 0;

      $('.checkOrderPay').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
          moneyAll += parseInt($("#moneyEveryDay").html());
        }
      });
      $("#finalMoneyDay").html(moneyAll);
    });

    $(".confirmPayingSuperDay").click(function()
    {
      var arrWithElements = [];

      $('.checkOrderPay').each(function(i,elem) {
        if($(elem).prop("checked"))
        {
          arrWithElements.push($(elem).attr("data-id"));
        }
      });

      $.ajax({
          url: appDir + "paySuperVisorDays",
          data: {
              "array": arrWithElements
          },
          method: "post",
          success: function (result)
          {
              location.reload();
          }
      });
    });


    $(".confirmEdit").click(function ()
    {
        dataId = $(this).attr("data-order");

        patronymic = $("#editpartonymic" + dataId).val();
        name = $("#editName" + dataId).val();
        surname = $("#editSurname" + dataId).val();
        phone = $("#editPhone" + dataId).val();

        $.ajax({
            url: appDir + "edit_worker",
            data: {
                "name": name,
                "patronymic": patronymic,
                "surname": surname,
                "phone": phone,
                "id": dataId
            },
            method: "post",
            success: function (result)
            {
                //alert(result);
                location.reload();
            }
        });
    });

    $(".confirmPenalty").click(function ()
    {
        dataId = $(this).attr("data-order");

        $.ajax({
            url: appDir + "add_penalty",
            data: {
                "id": dataId
            },
            method: "post",
            success: function (result)
            {
                // alert(result);
                location.reload();
            }
        });
    });

    //function to delete row on Workers
    $(".deleteWorker").click(function ()
    {
        dataId = $(this).attr("data-order");

        $.ajax({
            url: appDir + "delete_worker",
            data: {
                "id": dataId
            },
            method: "post",
            success: function (result)
            {
                // alert(result);
                location.reload();
            }
        });
    });

    $(".deleteLead").click(function ()
    {
        dataId = $(this).attr("data-order");

        $.ajax({
            url: appDir + "deleteLead",
            data: {
                "id": dataId
            },
            method: "post",
            success: function (result)
            {
                // alert(result);
                location.reload();
                //console.log(result);
            }
        });
    });


    $(".confirmMaket").click(function ()
    {
        print1 = $(this).parents(".fade").find(".newOrderDesigner_print").val();
        print2 = $(this).parents(".fade").find(".newOrderDesigner_print_2").val();
        preview = $(this).parents(".fade").find(".newOrderDesigner_preview").val();
        base = $(this).parents(".fade").find(".newOrderDesigner_base").val();
        base2 = $(this).parents(".fade").find(".newOrderDesigner_base_2").val();
        idDesignerOrder = $(this).parents(".fade").attr("data-id");

        $.ajax({
            url: appDir + "edit_designer_maket",
            data: {
                "print": print1,
                "print2": print2,
                "preview": preview,
                "base": base,
                "base2": base2,
                "idDesignerOrder": idDesignerOrder
            },
            method: "post",
            success: function (result)
            {
              // console.log(result);
                //alert(result);
                location.reload();
            }
        });
    });

    $("#addNewOrder").click(function ()
    {
        data = [];

        data.push({
            title: "place",
            value: $('#newOrder_place').val()
        });
        data.push({
            title: "count",
            value: $('#newOrder_count').val()
        });
        data.push({
            title: "date",
            value: $('#datetimepicker2').find("input").val()
        });
        data.push({
            title: "time",
            value: $('#datetimepicker2').find("input").val()
        });
        data.push({
            title: "customer",
            value: $('#newOrder_selectClients').val()
        });
        data.push({
            title: "worker",
            value: $('#newOrder_selectWorkers').val()
        });
        data.push({
            title: "type",
            value: $('#select-type-result').val()
        });
        data.push({
            title: "comment",
            value: $('#newOrder_comment').val()
        });



        jsonString = JSON.stringify(data);

        $.ajax({
            url: appDir + "add_order",
            data: {
                data: jsonString
            },
            type: "post",
            method: "post",
            cache: false,
            success: function (result)
            {
                // alert(result);
                location.reload();
            }
        });
    });

    $(".edit-order").click(function ()
    {
        var id;
        data = [];

        id = $(this).attr("data-order");

        data.push({
            title: "place",
            value: $('#placeEditOrder' + id).val()
        });
        data.push({
            title: "count",
            value: $('#editOrder_count' + id).val()
        });
        data.push({
            title: "date",
            value: $('#datetimepicker' + id).find("input").val()
        });
        data.push({
            title: "time",
            value: $('#datetimepicker' + id).find("input").val()
        });
        data.push({
            title: "customer",
            value: $('#clientEditOrder' + id).val()
        });
        data.push({
            title: "worker",
            value: $('#workersEditOrder' + id).val()
        });
        data.push({
            title: "type",
            value: $('#select-type2-result').val()
        });
        data.push({
            title: "comment",
            value: $('#editOrder_comment' + id).val()
        });
        // alert($('#editOrder_comment' + id).val());
        jsonString = JSON.stringify(data);
        $.ajax({
            url: appDir + "edit_order",
            data: {
                data: jsonString,
                id: id
            },
            type: "post",
            method: "post",
            cache: false,
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $(".delete-order").click(function (){

      id = $(this).attr("data-order");

      $.ajax({
          url: appDir + "delete_order",
          data: {
              "id": id
          },
          type: "post",
          method: "post",
          cache: false,
          success: function (result)
          {
              location.reload();
          }
      });
    });

    $("#select-type").change(function ()
    {
        var category = $(this).val();

        $.ajax({
            url: appDir + "get_worker_types",
            type: "post",
            data: {
                "category": category
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                $("#select-type-result").html(result);
            }
        });
    });

    $("#select-type2").change(function ()
    {
        var category = $(this).val();

        $.ajax({
            url: appDir + "get_worker_types",
            type: "post",
            data: {
                "category": category
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                $("#select-type2-result").html(result);
            }
        });
    });

    $(".companyNameCreateCustomerByLead").change(function ()
    {
        dataId = $(this).attr("data-order");
        if ($("#companyNameCreateCustomerByLead" + dataId).val() !== '0')
        {
            $("#companyName" + dataId).remove();
        }
        else
        {
            console.log("else srabotal");
            $("<tr id='companyName" + dataId + "'><td>Название компании:</td><td><input id='newCompanyNameCreateCustomerByLead" + dataId + "' type='text' class='form-control' value='' placeholder=''></td></tr>").insertAfter("#company" + dataId);
        }
    });

    $(".confirmCreateCustomerByLeadNewCompany").click(function ()
    {
        dataId = $(this).attr("data-order");

        company = $("#companyNameCreateCustomerByLead" + dataId).val();

        if (company == 0)
        {
            //values for creating company
            companyName = $("#newCompanyNameCreateCustomerByLead" + dataId).val();

            //values for creating customer by lead
            leadId = $(this).attr("data-order");
            lastName = $("#lastNameCreateCustomerByLead" + dataId).val();
            firstName = $("#firstNameCreateCustomerByLead" + dataId).val();
            patronymicName = $("#patronymicNameCreateCustomerByLead" + dataId).val();
            city = $("#cityCreateCustomerByLead" + dataId).val();
            street = $("#streetCreateCustomerByLead" + dataId).val();
            build = $("#buildCreateCustomerByLead" + dataId).val();
            apartment = $("#apartmentCreateCustomerByLead" + dataId).val();
            phone = $("#phoneCreateCustomerByLead" + dataId).val();
            phone2 = $("#phone2CreateCustomerByLead" + dataId).val();
            phone3 = $("#phone3CreateCustomerByLead" + dataId).val();
            email = $("#emailCreateCustomerByLead" + dataId).val();
            url = $("#urlCreateCustomerByLead" + dataId).val();
            bankDetails = $("#bankDetailsCreateCustomerByLead" + dataId).val();
            fromWhom = $("#fromCreateCustomerByLead" + dataId).val();

            $.ajax({
                url: appDir + "createCustomerByLeadNewCompany",
                type: "post",
                data: {
                    "companyName": companyName,
                    "leadId": leadId,
                    "lastName": lastName,
                    "firstName": firstName,
                    "patronymicName": patronymicName,
                    "city": city,
                    "street": street,
                    "build": build,
                    "apartment": apartment,
                    "phone": phone,
                    "phone2": phone2,
                    "phone3": phone3,
                    "email": email,
                    "url": url,
                    "bankDetails": bankDetails,
                    "fromWhom": fromWhom
                },
                method: "post",
                cache: false,
                success: function (result)
                {
                    location.reload();
                    //console.log(result);
                }
            });
        }
        else
        {
            //values for creating customer by lead
            leadId = $(this).attr("data-order");
            companyId = $("#companyNameCreateCustomerByLead" + dataId).val();
            lastName = $("#lastNameCreateCustomerByLead" + dataId).val();
            firstName = $("#firstNameCreateCustomerByLead" + dataId).val();
            patronymicName = $("#patronymicNameCreateCustomerByLead" + dataId).val();
            street = $("#streetCreateCustomerByLead" + dataId).val();
            build = $("#buildCreateCustomerByLead" + dataId).val();
            apartment = $("#apartmentCreateCustomerByLead" + dataId).val();
            phone = $("#phoneCreateCustomerByLead" + dataId).val();
            phone2 = $("#phone2CreateCustomerByLead" + dataId).val();
            phone3 = $("#phone3CreateCustomerByLead" + dataId).val();
            email = $("#emailCreateCustomerByLead" + dataId).val();
            url = $("#urlCreateCustomerByLead" + dataId).val();
            bankDetails = $("#bankDetailsCreateCustomerByLead" + dataId).val();
            fromWhom = $("#fromCreateCustomerByLead" + dataId).val();

            $.ajax({
                url: appDir + "createCustomerByLead",
                type: "post",
                data: {
                    "leadId": leadId,
                    "companyId": companyId,
                    "lastName": lastName,
                    "firstName": firstName,
                    "patronymicName": patronymicName,
                    "street": street,
                    "build": build,
                    "apartment": apartment,
                    "phone": phone,
                    "phone2": phone2,
                    "phone3": phone3,
                    "email": email,
                    "url": url,
                    "bankDetails": bankDetails,
                    "fromWhom": fromWhom
                },
                method: "post",
                cache: false,
                success: function (result)
                {
                    location.reload();
                    //console.log(result);
                }
            });
        }
    });

    $('.companyEditOrder').change(function ()
    {
        alert($(this).val());
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
                //console.log('Успе'+array+'шно');
                //console.log(array[0].lastName);
                console.log('Длина массива: ' + array.length);
                $(".customersEditOrder").empty();
                $(".customersEditOrder").append("<option value=0>Не выбрано</option>");
                for (i = 0; i < array.length; i++)
                {
                    console.log(array[i].lastName);
                    $(".customersEditOrder").append("<option value=" + array[i].customerId + ">" + array[i].lastName + " " + array[i].firstName + " " + array[i].patronymicName + "</option>");
                }
            }
        });
    });

    $(".status-select li").click(function ()
    {
        var idOrder = $(this).parents("tr").find(".idOrder").val();
        var status = $(this).attr("data-id");

        $.ajax({
            url: appDir + "change_status_order",
            type: "post",
            data: {
                "idOrder": idOrder,
                "status": status
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $(".delete-notification").click(function ()
    {
        var id = $(this).attr("data-id");

        $.ajax({
            url: appDir + "delete_notification",
            type: "post",
            data: {
                "id": id
            },
            method: "post",
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });

    $(".status-lead-select li").click(function ()
    {
        var idOrder = $(this).parents("td").find(".idOrder").val();
        var status = $(this).attr("data-id");

        $.ajax({
            url: appDir + "change_status_lead",
            type: "post",
            data: {
                "idOrder": idOrder,
                "status": status
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $(".status-designer-order-select li").click(function ()
    {
        var idOrder = $(this).parents("td").find(".idOrder").val();
        var status = $(this).attr("data-id");

        $.ajax({
            url: appDir + "change_status_design_order_makets",
            type: "post",
            data: {
                "idOrder": idOrder,
                "status": status
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $(".status-designer-select li").click(function ()
    {
        var idOrder = $(this).parents("tr").find(".idOrder").val();
        var status = $(this).attr("data-id");

        $.ajax({
            url: appDir + "change_status_design_order",
            type: "post",
            data: {
                "idOrder": idOrder,
                "status": status
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                location.reload();
            }
        });
    });
    $(".status-invoice-order-select li").click(function ()
    {
        var idOrder = $(this).parents("tr").find(".idOrder").val();
        var status = $(this).attr("data-id");

        $.ajax({
            url: appDir + "change_status_order_invoice",
            type: "post",
            data: {
                "idOrder": idOrder,
                "status": status
            },
            method: "post",
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
    $("#start-end-button").find(".buttonDay").click(function ()
    {
        $.ajax({
            url: appDir + "start_working_day",
            type: "post",
            method: "post",
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
    $("#addNewOffer").click(function ()
    {

        type = $("#selectNewOffer").val();
        text = $("#textareaNewOffer").val();

        $.ajax({
            url: appDir + "add_new_offer",
            type: "post",
            method: "post",
            data: {
                "type": type,
                "text": text
            },
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
    $("#addNewNotification").click(function ()
    {

        date = $("#inputTimeNewNotification").val();
        text = $("#textNewNotification").val();
        forPeople = 0;

        if($("select").is("#forPeople"))
        {
            forPeople = $("#forPeople").val();
        }


        $.ajax({
            url: appDir + "add_new_notification",
            type: "post",
            method: "post",
            data: {
                "date": date,
                "text": text,
                "forPeople": forPeople
            },
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
    $(".search").keyup(function()
    {
        elementResult = $(this).attr("data-table");
        dataName = $(this).attr("data-name");
        query = $(this).val();

        $.ajax({
            url: appDir + "search_" + dataName,
            type: "post",
            method: "post",
            data: {
                "dataName": dataName,
                "query": query
            },
            cache: false,
            success: function (result)
            {
                $(elementResult).hide();
                $(".result-ajax-search[data-id='" + elementResult + "']").html(result);
                //$(elementResult).find("tbody").html(result);
            }
        });
    });
    $("#newMovement").click(function ()
    {
        var type, worker, money;

        type = $("#movementType").val();
        worker = $("#movementWorker").val();
        money = $("#movementMoney").val();

        $.ajax({
            url: appDir + "newMovement",
            type: "post",
            method: "post",
            data: {
                "type" : type,
                "worker" : worker,
                "money" : money
            },
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
    $("#menu-help").find(".link").click(function()
    {
        $("#result-help").load("/crm/help/supervisor.php");
    });
    $(".open-file-manager").click(function()
    {
        idModal = $(this).attr("data-target");
        console.log(idModal);
        $.ajax({
            url: appDir + "FM_getFiles",
            type: "post",
            method: "post",
            cache: false,
            success: function (result)
            {
                $(idModal).find(".modal-body").html(result);
            }
        });
    });
    $(".open-fm").click(function ()
    {
        FM_this_element = $(this).attr("data-return");
        FM_this_folder = $(this).attr("data-folder");
        openFM();
    });
    $(".addOrderDesignerFromInvoice").click(function ()
    {
        var idInvoice = $(this).attr("data-order");

        $.ajax({
            url: appDir + "getInfoAboutOrderGroup",
            type: "post",
            method: "post",
            data: {
                "idInvoice": idInvoice
            },
            cache: false,
            success: function (result)
            {
                    bootbox.dialog({
                    size: "large",
                    title: "Выберите заказы, которые Вы хотите отправить в печать",
                    message: result,
                    buttons:
                    {
                        danger:
                        {
                            label: "Отмена",
                            className: "btn-default",
                            callback: function()
                            {
                            }
                        },
                        success:
                        {
                            label: "Отправить в печать",
                            className: "btn-info",
                            callback: function()
                            {
                                var arrWithElements = [];

                                $('.checkOrderInvoice').each(function(i,elem) {
                                    if($(elem).prop("checked"))
                                    {
                                        arrWithElements.push($(elem).attr("data-id"));
                                    }
                                });

                                $.ajax({
                                    url: appDir + "addOrderDesignerFromInvoice",
                                    type: "post",
                                    method: "post",
                                    data: {
                                        "orders": arrWithElements
                                    },
                                    cache: false,
                                    success: function (resultOrders)
                                    {
                                        alert(resultOrders);
                                        //location.href = "/crm/ordersDesigner.php";
                                    }
                                });
                            }
                        }
                    }
                });
                //location.href = "/crm/ordersDesigner.php";
            }
        });



        //$.ajax({
        //    url: appDir + "orderDesignerFromInvoice",
        //    type: "post",
        //    method: "post",
        //    data: {
        //        "idInvoice": idInvoice
        //    },
        //    cache: false,
        //    success: function ()
        //    {
        //        location.href = "/crm/ordersDesigner.php";
        //    }
        //});
    });
    $("body").on("click", ".list-one-file", function ()
    {
        linkFile = $(this).attr("data-link");
        $(FM_this_element).val(linkFile);
        bootbox.hideAll();
    });
    $("body").on("keyup", ".search-client", function ()
    {
        var nameDB = $(this).attr("data-name-db");
        var query = $(this).val();

        $.ajax({
            url: appDir + "getsearch_" + nameDB,
            type: "post",
            method: "post",
            data: {
                "query": query
            },
            cache: false,
            success: function (result)
            {
                $(".ul-result-ajax").html(result);
            }
        });
    });
    $("body").on("keyup", ".search-ajax", function ()
    {
        var nameDB = $(this).attr("data-name-db");
        var liClass = $(this).attr("data-li-class");
        var query = $(this).val();

        $.ajax({
            url: appDir + "getsearch_" + nameDB,
            type: "post",
            method: "post",
            data: {
                "query": query,
                "liClass": liClass
            },
            cache: false,
            success: function (result)
            {
                $(".result-ajax").html(result);
            }
        });
    });
    $("body").on("keyup", ".search-ajax-worker", function ()
    {
        //var nameDB = $(this).attr("data-name-db");
        //var liClass = $(this).attr("data-li-class");
        var query = $(this).val();

        $.ajax({
            url: appDir + "getsearch_worker",
            type: "post",
            method: "post",
            data: {
                "query": query
            },
            cache: false,
            success: function (result)
            {
                $(".result-ajax").html(result);
            }
        });
    });
    $("body").on("click", ".set-client", function ()
    {
        var dataId = $(this).attr("data-id");
        var text = $(this).html();

        $(ResultNameInput + "printResult").html(text);
        $(ResultNameInput).val(dataId);

        hideThisWindow($(this));
        setTimeout(modalOpen, 1000);
    });
    $("body").on("click", ".set-worker", function ()
    {
        var dataId = $(this).attr("data-id");
        var text = $(this).html();

        $(ResultNameInput + "printResult").html(text);
        $(ResultNameInput).val(dataId);

        hideThisWindow($(this));
        setTimeout(modalOpen, 1000);
    });
    $("body").on("click", ".edit-client", function () {
        var dataId = $(this).attr("data-id");

        $.ajax({
            url: appDir + "getInfoAboutClient",
            type: "post",
            method: "post",
            data: {
                "dataId": dataId
            },
            cache: false,
            success: function (result)
            {
                bootbox.dialog({
                    size: "large",
                    title: "Редактирование заказа",
                    message: result,
                    buttons:
                    {
                        danger:
                        {
                            label: "Отмена",
                            className: "btn-default",
                            callback: function()
                            {
                            }
                        },
                        success:
                        {
                            label: "Отправить в печать",
                            className: "btn-info",
                            callback: function()
                            {
                                //var arrWithElements = [];
                                //
                                //$('.checkOrderInvoice').each(function(i,elem) {
                                //    if($(elem).prop("checked"))
                                //    {
                                //        arrWithElements.push($(elem).attr("data-id"));
                                //    }
                                //});
                                //
                                //$.ajax({
                                //    url: appDir + "addOrderDesignerFromInvoice",
                                //    type: "post",
                                //    method: "post",
                                //    data: {
                                //        "orders": arrWithElements
                                //    },
                                //    cache: false,
                                //    success: function (resultOrders)
                                //    {
                                //        alert(resultOrders);
                                //        //location.href = "/crm/ordersDesigner.php";
                                //    }
                                //});
                            }
                        }
                    }
                });
            }
        });
    });
    $("body").on("click", ".set-li", function ()
    {
        var dataId = $(this).attr("data-id");
        var nameCompany = $(this).html();

        if(SelectModalType != "clients")
        {
            $("button[data-name-db='companies']").parent().find("input").val(dataId);
            $("button[data-name-db='companies']").parent().find(".result-txt").html(nameCompany);

            //bootbox.hideAll();
            hideThisWindow($(this));
            setTimeout(modalOpen, 1000);

            return;
        }

        $.ajax({
            url: appDir + "getClientsFromThisCompany",
            type: "post",
            method: "post",
            data: {
                "idCompany": dataId
            },
            cache: false,
            success: function (result)
            {
                $(".result-ajax").html(result);
            }
        });
    });

    $("body").on("click", "#addLineMultiOrder", function ()
    {
        count = $(this).attr("data-count");
        $(this).attr("data-count", parseInt(count) + 1);

        $.ajax({
            url: appDir + "getWindowMultiOrder",
            type: "post",
            data: {
                "type": "justRow",
                "count": count
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                $(".tr-line").append(result);
                $(".timeFromTo").mask("99:99 - 99:99");
            }
        });
    });

    $("body").on("click", ".deleteLineMultiOrder", function ()
    {
        $(this).parents("tr").remove();
    });

    $("#addMultiOrder").click(function () {
        $.ajax({
            url: appDir + "getWindowMultiOrder",
            type: "post",
            method: "post",
            cache: false,
            success: function (result)
            {
                bootbox.dialog({
                    size: "large",
                    title: "Создание мультизаказа",
                    message: result,
                    buttons:
                    {
                        danger:
                        {
                            label: "Отмена",
                            className: "btn-default",
                            callback: function()
                            {
                            }
                        },
                        success:
                        {
                            label: "Создать заказ",
                            className: "btn-default",
                            callback: function()
                            {
                                $(".oneMultiOrder").each(function (i, elem) {
                                    count = $(elem).attr("data-count");
                                    parent = $(elem).parents("tr");

                                    place = parent.find("#new_place" + count).val();
                                    time = parent.find("#new_time" + count).val();

                                    console.log(place + " " + time);
                                });
                                //$.ajax({
                                //    url: appDir + "",
                                //    type: "post",
                                //    method: "post",
                                //    data: {
                                //        "orders": arrWithElements
                                //    },
                                //    cache: false,
                                //    success: function (resultOrders)
                                //    {
                                //        alert(resultOrders);
                                //        //location.href = "/crm/ordersDesigner.php";
                                //    }
                                //});
                            }
                        }
                    }
                });
            }
        });

    });

    $("body").on("click", ".company-li", function ()
    {
        var dataId = $(this).attr("data-id");
        var nameCompany = $(this).html();

        $(ResultNameInput).val(dataId);
        $(ResultNameInput + "printResult").html(nameCompany);

        hideThisWindow($(this));

        //bootbox.hideAll();
        //setTimeout(modalOpen, 1000);
    });

    $(".select-DB").find("button").click(function () {
        var nameDB = $(this).attr("data-name-db");
        var input = $("<input>");
        var resultDB = $("<div>");
        var shellDiv = $("<div>");

        input.attr("class", "form-control search-ajax");
        input.attr("data-name-db", nameDB);
        input.attr("data-li-class", "set-li");
        input.attr("placeholder", "Введите название компании");

        resultDB.attr("class", "result-ajax");

        shellDiv.append(input);
        shellDiv.append(resultDB);

        bootbox.alert({
            size: "large",
            title: "File Manager",
            message: shellDiv ,
            callback: function(){
                setTimeout(modalOpen, 1000);
            }
        });
    });
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
            '<input type="hidden" id="newProduct' + dataId + '" class="listOrders" data-id="0" value="">' +
            '<button class="btn btn-primary select-product-modal" data-name-result="#newProduct' + dataId + '">' +
            'Выберите продукт &nbsp;&nbsp;<i class="fa fa-archive" aria-hidden="true"></i>' +
            '</button>' +
            '<span id="newProduct' + dataId + 'printResult" class="text-near-button"></span>' +
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
        //$('<tr id="lastProductRowInTable">' +
        //    '<td>' +
        //    '<select id="selectCategoryProductNewProductOrder' + dataId + '" type="text" class="form-control selectCategoryNewProductOrder" data-order="' + dataId + '">' +
        //    '<?php echo $outCategory; ?>' +
        //    '</select>' +
        //    '</td>' +
        //    '<td>' +
        //    '<select id="selectSubCategoryProductNewProductOrder' + dataId + '" type="text" class="form-control selectSubCategoryNewProductOrder" data-order="' + dataId + '">' +
        //    '<?php echo $outSubCategory; ?>' +
        //    '</select>' +
        //    '</td>' +
        //    '<td>' +
        //    '<select id="selectProductNewProductOrder' + dataId + '" type="text" class="form-control selectProductNewProductOrder" data-order="' + dataId + '">' +
        //    '</select>' +
        //    '</td>' +
        //    '<td>' +
        //    '<input type="text" id="productTextNewOrder' + dataId + '" class="form-control productTextNewOrder" value="" data-order="' + dataId + '">' +
        //    '</td>' +
        //    '<td>' +
        //    '<input type="text" id="productCountNewOrder' + dataId + '" class="form-control productCountNewOrder" value="" data-order="' + dataId + '">' +
        //    '</td>' +
        //    '<td>' +
        //    '<input type="text" id="productPricePerOneNewOrder' + dataId + '" class="form-control productPricePerOneNewOrder" value="" data-order="' + dataId + '">' +
        //    '</td>' +
        //    '</tr>').appendTo('#productListTable');
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
        //dataId = $(this).attr('data-order');
        //totalSum = $(this).attr('totalSum');
        //
        //arrayToJson = {};
        //arrayToJson['orderData'] = {};
        //arrayToJson['orderData']['productOrderName'] = $('#productOrderName').val();
        //arrayToJson['orderData']['newProductOrderCustomer'] = $('#newProductOrderCustomer').val();
        //arrayToJson['orderData']['countOfRows'] = dataId;
        //arrayToJson['orderData']['totalSum'] = parseFloat(totalSum);
        //for (i = 1; i < parseInt(dataId); i++) {
        //    arrayToJson[i] = {};
        //    arrayToJson[i]['categoryId'] = $('#selectCategoryProductNewProductOrder' + i).val();
        //    arrayToJson[i]['subCategoryId'] = $('#selectSubCategoryProductNewProductOrder' + i).val();
        //    arrayToJson[i]['productId'] = $('#selectProductNewProductOrder' + i).val();
        //    arrayToJson[i]['information'] = $('#productTextNewOrder' + i).val();
        //    arrayToJson[i]['count'] = parseFloat($('#productCountNewOrder' + i).val());
        //    arrayToJson[i]['costPerOne'] = parseFloat($('#productPricePerOneNewOrder' + i).val());
        //}
        //
        //$.ajax({
        //    url: appDir + 'createNewOrder',
        //    data: {
        //        "jsonArray": arrayToJson
        //    },
        //    method: "post",
        //    success: function (result)
        //    {
        //        location.reload();
        //    }
        //})
        var totalOrderMoney = 0;
        var arrayToSend = {};

        // INFO ORDER

        var client = $("#inputSelectClient").val();
        var nameOrder = $("#productOrderName").val();


        $(".listOrders").each(function (i, elem) {
            var parents = $(this).parents("tr");
            var idProduct = $(this).val();
            var information = parents.find(".productTextNewOrder").val();
            var count = parents.find(".productCountNewOrder").val();
            var price = parents.find(".productPricePerOneNewOrder").val();

            totalOrderMoney += (parseFloat(price) * parseFloat(count));

            arrayToSend[i] = {
                "idProduct": idProduct,
                "information": information,
                "count": count,
                "price": price
            };
        });

        var infoAboutOrder = {
            "totalSum": totalOrderMoney,
            "client": client,
            "nameOrder": nameOrder
        };

        $.ajax({
            type: "POST",
            url: appDir + 'createNewOrder',
            data: {
                "orders": arrayToSend,
                "info": infoAboutOrder
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
    });
    $(document).on('click', '.confirmEditOrder', function ()
    {
        var totalOrderMoney = 0;
        var arrayToSend = {};

        // INFO ORDER

        var client = $("#inputSelectClient").val();
        var nameOrder = $("#productOrderName").val();
        var idGroup = $("#productOrderGroupId").val();


        $(".listOrders").each(function (i, elem) {
            var parents = $(this).parents("tr");
            var idProduct = $(this).val();
            var idOrder = $(this).attr("data-id");
            var information = parents.find(".productTextNewOrder").val();
            var count = parents.find(".productCountNewOrder").val();
            var price = parents.find(".productPricePerOneNewOrder").val();

            totalOrderMoney += (parseFloat(price) * parseFloat(count));

            arrayToSend[i] = {
                "idProduct": idProduct,
                "idOrder": idOrder,
                "information": information,
                "count": count,
                "price": price
            };
        });

        var infoAboutOrder = {
            "totalSum": totalOrderMoney,
            "client": client,
            "nameOrder": nameOrder,
            "idGroup": idGroup
        };

        $.ajax({
            type: "POST",
            url: appDir + 'editOrder',
            data: {
             "orders": arrayToSend,
             "info": infoAboutOrder
            },
            method: "post",
            success: function ()
            {
                location.reload();
            }
        });
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
    $("body").on("click", ".click-category", function(){
        var categoryId = $(this).attr("data-category-id");

        $.ajax({
            url: appDir + "selectCategoryOfProducts",
            type: "post",
            data: {
                "type": "subCategory",
                "categoryId": categoryId
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                $(".bootbox-body").html(result);
            }
        });
    });
    $("body").on("click", ".click-subCategory", function(){
        var categoryId = $(this).attr("data-category-id");

        $.ajax({
            url: appDir + "selectCategoryOfProducts",
            type: "post",
            data: {
                "type": "product",
                "categoryId": categoryId
            },
            method: "post",
            cache: false,
            success: function (result)
            {
                $(".bootbox-body").html(result);
            }
        });
    });
    $("body").on("click", ".click-product", function(){
        productId = $(this).attr("data-category-id");
        nameProduct = $(this).html();

        $(idProductWhenShowModal).val(productId);
        $(resultProductWhenShowModal).html(nameProduct);

        bootbox.hideAll();
    });
    $("body").on("click", "#save-account", function(){
        login = $("#newOrder_name_login").val();
        password = $("#newOrder_name_password").val();
        name = $("#newOrder_name_name").val();
        birth = $("#timeEditOrder1").val();
        email = $("#newOrder_name_email").val();
        skype = $("#newOrder_name_skype").val();
        phone = $("#newOrder_name_phone").val();

        $.ajax({
            url: appDir + "save_account",
            type: "post",
            data: {
                "login": login,
                "password": password,
                "name": name,
                "birth": birth,
                "email": email,
                "skype": skype,
                "phone": phone
            },
            method: "post",
            cache: false,
            success: function ()
            {
                location.reload();
            }
        });
    });
});
function hideThisWindow(event)
{
    event.parents(".modal").hide();

    $(".modal-backdrop").each(function (i, elem) {
        if(i == ($(".modal-backdrop").length -1))
        {
            $(elem).hide();
        }
    });
}
function openFM()
{
    $.ajax({
        url: appDir + "FM_getFiles",
        type: "post",
        data: {
            "button_link": false,
            "folder": FM_this_folder
        },
        method: "post",
        cache: false,
        success: function (result)
        {
            bootbox.alert({
                size: "large",
                title: "File Manager",
                message: result,
                callback: function(){ /* your callback code */ }
            });
        }
    });
}
function modalOpen()
{
    $("body").addClass("modal-open");
}
function submitForm()
{
    login = $("#login").val();
    password = $("#password").val();

    $.ajax({
        url: appDir + "check_user_in_system",
        type: "post",
        data: {
            "login": login,
            "password": password
        },
        method: "post",
        cache: false,
        success: function (result)
        {
            location.reload();
        }
    });
}
function submitFormCustom()
{
    login = $("#login").val();
    password = $("#password").val();

    $.ajax({
        url: appDir + "check_custom_in_system",
        type: "post",
        data: {
            "login": login,
            "password": password
        },
        method: "post",
        cache: false,
        success: function (result)
        {
            location.reload();
        }
    });
}
function logout()
{
    $.ajax({
        url: appDir + "out_from_system",
        type: "post",
        method: "post",
        cache: false,
        success: function (result)
        {
            location.href = "/crm/";
        }
    });
}
function SelectWorkerModal(nameDB, inputName)
{
    SelectModalType = "clients";
    ResultNameInput = inputName;

    var input = $("<input>");
    var resultDB = $("<div>");
    var shellDiv = $("<div>");

    input.attr("class", "form-control search-ajax-worker");
    input.attr("data-name-db", nameDB);
    input.attr("data-li-class", "set-li-worker");
    input.attr("placeholder", "Введите ФИО работника");

    resultDB.attr("class", "result-ajax");

    shellDiv.append(input);
    shellDiv.append(resultDB);

    bootbox.dialog({
        size: "large",
        title: "Выбор работника",
        message: shellDiv,
        buttons: {
            danger:
            {
                label: "Отмена",
                className: "btn-default",
                callback: function()
                {

                }
            },
            success:
            {
                label: "Выбрать",
                className: "btn-primary",
                callback: function()
                {

                }
            }
        },
        callback: function(){ /* your callback code */ }
    });
}
function SelectClientModal(nameDB, inputName)
{
    SelectModalType = "clients";
    ResultNameInput = inputName;

    var input = $("<input>");
    var resultDB = $("<div>");
    var shellDiv = $("<div>");

    input.attr("class", "form-control search-ajax");
    input.attr("data-name-db", nameDB);
    input.attr("data-li-class", "set-li");
    input.attr("placeholder", "Введите название компании");

    resultDB.attr("class", "result-ajax");

    shellDiv.append(input);
    shellDiv.append(resultDB);

    bootbox.dialog({
        size: "large",
        title: "File Manager",
        message: shellDiv,
        buttons: {
            danger:
            {
                label: "Отмена",
                className: "btn-default",
                callback: function()
                {

                }
            },
            success:
            {
                label: "Выбрать",
                className: "btn-primary",
                callback: function()
                {

                }
            }
        },
        callback: function(){ /* your callback code */ }
    });
}
function SelectSuperTypeModal(nameDB, inputName)
{
    $.ajax({
        url: appDir + "getTypesSuper",
        type: "post",
        method: "post",
        cache: false,
        success: function (result)
        {
            bootbox.dialog({
                size: "large",
                title: "Выбор типа работы",
                message: result,
                buttons: {
                    danger:
                    {
                        label: "Отмена",
                        className: "btn-default",
                        callback: function()
                        {

                        }
                    },
                    success:
                    {
                        label: "Выбрать",
                        className: "btn-primary",
                        callback: function()
                        {

                        }
                    }
                },
                callback: function(){ /* your callback code */ }
            });
        }
    });
    //SelectModalType = "clients";
    //ResultNameInput = inputName;
    //
    //var input = $("<input>");
    //var resultDB = $("<div>");
    //var shellDiv = $("<div>");
    //
    //input.attr("class", "form-control search-ajax");
    //input.attr("data-name-db", nameDB);
    //input.attr("data-li-class", "set-li");
    //input.attr("placeholder", "Введите название компании");
    //
    //resultDB.attr("class", "result-ajax");
    //
    //shellDiv.append(input);
    //shellDiv.append(resultDB);

    //bootbox.dialog({
    //    size: "large",
    //    title: "File Manager",
    //    message: shellDiv,
    //    buttons: {
    //        danger:
    //        {
    //            label: "Отмена",
    //            className: "btn-default",
    //            callback: function()
    //            {
    //
    //            }
    //        },
    //        success:
    //        {
    //            label: "Выбрать",
    //            className: "btn-primary",
    //            callback: function()
    //            {
    //
    //            }
    //        }
    //    },
    //    callback: function(){ /* your callback code */ }
    //});
}

function SelectCompanyModal(nameDB, inputName)
{
    SelectModalType = "company";
    ResultNameInput = inputName;

    var input = $("<input>");
    var resultDB = $("<div>");
    var shellDiv = $("<div>");

    input.attr("class", "form-control search-ajax");
    input.attr("data-name-db", nameDB);
    input.attr("data-li-class", "company-li");
    input.attr("placeholder", "Введите название компании");

    resultDB.attr("class", "result-ajax");

    shellDiv.append(input);
    shellDiv.append(resultDB);

    bootbox.dialog({
        size: "large",
        title: "Выберите компанию",
        message: shellDiv,
        buttons: {
            danger:
            {
                label: "Отмена",
                className: "btn-default",
                callback: function()
                {

                }
            },
            success:
            {
                label: "Выбрать",
                className: "btn-primary",
                callback: function()
                {

                }
            }
        },
        callback: function(){ /* your callback code */ }
    });
}
function SelectProductModal(inputName, resultName)
{
    idProductWhenShowModal = inputName;
    resultProductWhenShowModal = resultName;

    $.ajax({
        url: appDir + "selectCategoryOfProducts",
        type: "post",
        method: "post",
        data: {
            "type": "category"
        },
        cache: false,
        success: function (result)
        {
            bootbox.dialog({
                size: "large",
                title: "Select Product",
                message: result,
                buttons: {
                    danger:
                    {
                        label: "Отмена",
                        className: "btn-default",
                        callback: function()
                        {

                        }
                    },
                    success:
                    {
                        label: "Выбрать",
                        className: "btn-primary",
                        callback: function()
                        {

                        }
                    }
                },
                callback: function(){ /* your callback code */ }
            });
        }
    });
}
