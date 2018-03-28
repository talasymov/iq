var appDir = "/requests/ajax?command=";

function logInSystem()
{
    login = $("#login").val();
    password = $("#password").val();

    $.ajax({
        url: appDir + "checkUserInSystem",
        data: {
            "login": login,
            "password": password
        },
        method: "post",
        type: "post",
        success: function (result)
        {
            resultCheckingUser = parseInt(result);

            if(resultCheckingUser == 1)
            {
                location.href = "/dashboard";
            }
        }
    });
}