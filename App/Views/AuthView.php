<?php
if($data["social"] == "vk")
{
    $params = array(
        'client_id'     => $data["client_id"],
        'redirect_uri'  => $data["redirect_uri"],
        'response_type' => $data["response_type"]
    );

    echo $link = '<p><a href="' . $data["auth_uri"] . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';

    $result = false;
    $userInfo = false;

    if (isset($_GET['code'])) {


        $params = array(
            'client_id' => $data["client_id"],
            'client_secret' => $data["client_secret"],
            'code' => $_GET['code'],
            'redirect_uri' => $data["redirect_uri"]
        );

        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

        if (isset($token['access_token'])) {
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                'access_token' => $token['access_token']
            );

            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);

            if (isset($userInfo['response'][0]['uid'])) {
                $userInfo = $userInfo['response'][0];
                $result = true;
            }
        }
    }

    if($result)
    {
        AuxiliaryFn::StylePrint($userInfo);
    }
}
else if($data["social"] == "fb")
{
    $params = array(
        'client_id'     => $data["client_id"],
        'redirect_uri'  => $data["redirect_uri"],
        'response_type' => $data["response_type"],
        'scope' => "email,user_birthday"
    );

    echo $link = '<p><a href="' . $data["auth_uri"] . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Facebook</a></p>';
}
else
{
    $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
    //$user['network'] - соц. сеть, через которую авторизовался пользователь
    //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
    //$user['first_name'] - имя пользователя
    //$user['last_name'] - фамилия пользователя

    $userId = $user['uid'];

    if(!$userId)
    {
        $userId = intval($user['identity']);
    }

    if(!$userId)
    {
        BF::NotFound();
    }

    $userInfo = R::getRow("SELECT * FROM Users WHERE Users_from = ? AND Users_uid = ?", [
        $user['network'],
        $userId
    ]);

    if(intval($userInfo["Users_id"]) > 0)
    {
        BF::LoginUser($userInfo["Users_login"], $userInfo["Users_password"]);

        BF::RedirectUser("", 1);

//        AuxiliaryFn::StylePrint("as1");
    }
    else
    {
        $login = BF::GeneratePass($userId . "_82347j*sad-P");
        $password = BF::GeneratePass($userId . "_asd)9sd-.47j*sad-P");

        R::exec("INSERT INTO Users(Users_from, Users_uid, Users_login, Users_password, Users_name, Users_surname)
        VALUES(?, ?, ?, ?, ?, ?)",[
            $user['network'],
            $userId,
            $login,
            $password,
            $user['first_name'],
            $user['last_name']
        ]);

//        AuxiliaryFn::StylePrint(BF::CheckUserInSystem($login, $password));

        if(BF::CheckUserInSystem($login, $password))
        {
            BF::LoginUser($login, $password);
//            AuxiliaryFn::StylePrint("login");

        }

        BF::RedirectUser("", 1);

//        AuxiliaryFn::StylePrint("as2");

//        BF::LoginUser($login, $password);
    }

//    AuxiliaryFn::StylePrint($user);
}
