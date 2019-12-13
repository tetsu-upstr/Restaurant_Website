<?php

  // var_dump($sanitize_POST);

  $change_page_flag = 0;
  $sanitize_POST = array();
  $error = array();

  // サニタイズ（無害化）
if( !empty($_POST) ) {
	foreach( $_POST as $key => $value ) {
		$sanitize_POST[$key] = htmlspecialchars( $value, ENT_QUOTES);
	}
}

  // お問い合わせページ切り替え設定
  if( !empty($sanitize_POST['btn_confirm']) ) {

    $error = validation($sanitize_POST);

    if( empty($error) ) {

    $change_page_flag = 1;

    }

  } elseif( !empty($sanitize_POST['btn_submit']) ) {

    $change_page_flag = 2;

  // メール自動返信
  // 変数とタイムゾーンを初期化
	$headers = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');
  
  // ヘッダー情報を設定
	$headers = "MIME-Version: 1.0\n";
	$headers .= "From: Demo restaurant <noreply@demo-restaurant.com>\n";
	$headers .= "Reply-To: Demo restaurant <noreply@demo-restaurant.com>\n";

	// 件名を設定
	$auto_reply_subject = 'お問い合わせありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
                      下記の内容でお問い合わせを受け付けました。\n\n";
	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$auto_reply_text .= "氏名：" . $sanitize_POST['your_name'] . "\n";
	$auto_reply_text .= "メールアドレス：" . $sanitize_POST['email'] . "\n\n";
	$auto_reply_text .= "Demo restaurant";

	// メール送信
  mb_send_mail( $sanitize_POST['email'], $auto_reply_subject, $auto_reply_text, $headers);
  
  // 運営側へ送るメールの件名
  $admin_reply_subject = "お問い合わせを受け付けました";
  
  // 本文を設定
	$admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
	$admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$admin_reply_text .= "お名前：" . $sanitize_POST['your_name'] . "\n";
	$admin_reply_text .= "メールアドレス：" . $sanitize_POST['email'] . "\n\n";

  // 運営側へメール送信
  mb_send_mail( 'webmaster@demo-restaurant.com', $admin_reply_subject, $admin_reply_text, $headers);

  }

  // バリデーション
  function validation($data) {
    $error = array();

    if( empty($data['your_name'])) {
      $error[] = "お名前は必須項目です。";
    }

    return $error;
  }
  
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="サイトの説明文">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Caveat+Brush|Noto+Serif+JP&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="icon" href="images/favicon.png">
  <title>demo restaurant</title>
</head>

<body>
    
      <div class="wrapper">
        <header class="page-header">
            <h1><a href="index.html"><img class="logo" src="images/logo.png" alt="home"></a></h1>
                <nav>
                        <ul class="main-nav">
                        <li><a href="tel:06-1234-5678">Tel.06-1234-5678</a></li>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        </ul>
                </nav>
        </header>

      </div>



      <div class="wrapper">
            <h1 class="page-title">お問い合わせ</h1>

            <?php if( $change_page_flag === 1 ): ?>  
              
              <!-- 確認ページ -->
              <form method="post" action="">
                <div>
                  <label>お名前</label>
                  <p><?php echo $sanitize_POST['your_name']; ?></p>
                </div>
                <div>
                  <label>メールアドレス</label>
                  <p><?php echo $sanitize_POST['email']; ?></p>
                </div>
                <div>
                  <label>タイトル</label>
                  <p><?php echo $sanitize_POST['message-title']; ?></p>
                </div>
                <div>
                  <label>お問い合わせ内容</label>
                  <p><?php echo $sanitize_POST['your-message']; ?></p>
                </div>
                <br>
                <p>以下の内容でよろしければ、送信をお願いします。</p>

                <!-- POST入力値の受け渡し -->
                <input type="submit" class="button" name="btn_back" value="戻る">
                <input type="submit" class="button" name="btn_submit" value="確認して送信">
                <input type="hidden" name="your_name" value="<?php echo $sanitize_POST['your_name']; ?>">
                <input type="hidden" name="email" value="<?php echo $sanitize_POST['email']; ?>">
                <input type="hidden" name="message-title" value="<?php echo $sanitize_POST['your-message-title']; ?>">
                <input type="hidden" name="message" value="<?php echo $sanitize_POST['your-message']; ?>">
              </form>

            <?php elseif( $change_page_flag === 2 ): ?>

            <p>送信が完了しました。</p>

            <?php else: ?>

            <!-- お問い合わせフォーム -->
            <p>当店に対するご意見ご感想、お問い合わせなど、こちらのフォームよりお気軽にお尋ねください。</p>
            <form method="post" action="">
                <div>
                    <label for="name">お名前</label>
                    <input type="text" id="name" name="your_name" value="
                    <?php if( !empty($sanitize_POST['your_name']) ){ echo $sanitize_POST['your_name']; } ?>" >
                </div>

                <div>
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="
                    <?php if( !empty($sanitize_POST['email']) ){ echo $sanitize_POST['email']; } ?>" required>
                </div>

                <div>
                        <label for="message-title">タイトル</label>
                        <input type="message-title" id="message-title" name="your-message-title" value="" required>
                    </div>

                <div>
                    <label for="message">お問い合わせ内容</label>
                    <textarea id="message" name="your-message"></textarea>
                </div>

                <input type="submit" class="button" name="btn_confirm" value="送信">
            </form>

            
        </div>
    </div>
    
    <?php endif; ?>
  

    <footer>
        <div class="wrapper">

          <div class="circle">
            <a href="https://www.facebook.com/">
              <i class="icon fab fa-facebook-f"></i>
            </a>
          </div>

          <div class="circle">
              <a href="https://www.instagram.com/">
                <i class="icon fab fa-instagram"></i>
              </a>
            </div>

        </div>

        <p><small>&copy; Demo restaurant site</small></p>

    </footer>
  
</body>
</html>