<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>ログイン</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

  <div class="w-full max-w-xs mx-auto">
    <form name="form1" action="login_act.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <h2 class="text-2xl font-bold text-center mb-6">ログイン</h2>

      <div class="mb-4">
        <label for="lid" class="block text-gray-700 text-sm font-bold mb-2">ID:</label>
        <input type="text" name="lid" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="IDを入力">
      </div>

      <div class="mb-6">
        <label for="lpw" class="block text-gray-700 text-sm font-bold mb-2">PW:</label>
        <input type="password" name="lpw" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="パスワードを入力">
      </div>

      <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          ログイン
        </button>
      </div>
    </form>

    <div class="text-center">
      <a href="user.php" class="text-blue-500 hover:text-blue-700">新規ユーザー登録はこちら</a>
    </div>
  </div>

</body>
</html>


